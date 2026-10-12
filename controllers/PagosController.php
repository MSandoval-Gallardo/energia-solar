<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use app\models\Reserva;
use app\models\Pago;
use Transbank\Webpay\Options;
use Transbank\Webpay\WebpayPlus\Transaction;

class PagosController extends Controller
{
    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'iniciar' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Inicia un pago para una reserva existente.
     */
    public function actionIniciar($reserva_id)
    {
        $reserva = Reserva::findOne((int) $reserva_id);

        if ($reserva === null) {
            throw new NotFoundHttpException('La reserva no existe.');
        }

        if ((int) $reserva->estado !== 0) {
            throw new BadRequestHttpException(
                'La reserva no está pendiente.'
            );
        }
        $pagoExistente = Pago::find()
        ->where(['reserva_id' => $reserva->id])
        ->andWhere(['estado' => ['iniciado', 'aprobado']])
        ->one();

    if ($pagoExistente !== null) {
        throw new BadRequestHttpException(
            'Esta reserva ya tiene un pago iniciado o aprobado.'
        );
    }

        $monto = (int) $reserva->monto_reserva;

        if ($monto <= 0) {
            throw new BadRequestHttpException(
                'El monto de la reserva no es válido.'
            );
        }

        $config = require Yii::getAlias('@app/config/webpay.php');

        $ordenCompra = 'ES' . $reserva->id . strtoupper(bin2hex(random_bytes(5)));
        $sesionId = Yii::$app->security->generateRandomString(32);
        $ahora = date('Y-m-d H:i:s');

        $pago = new Pago();
        $pago->reserva_id = $reserva->id;
        $pago->orden_compra = $ordenCompra;
        $pago->monto = $monto;
        $pago->estado = 'iniciado';
        $pago->created_at = $ahora;
        $pago->updated_at = $ahora;

        if (!$pago->save()) {
            Yii::error($pago->errors, __METHOD__);

            throw new \yii\web\ServerErrorHttpException(
                'No fue posible registrar el intento de pago.'
            );
        }

        try {
            $opciones = new Options(
                $config['apiKey'],
                $config['codigoComercio'],
                Options::ENVIRONMENT_INTEGRATION
            );

            $transaccion = new Transaction($opciones);

            $urlRetorno = Url::to(
                ['pagos/retorno'],
                true
            );

            $respuesta = $transaccion->create(
                $ordenCompra,
                $sesionId,
                $monto,
                $urlRetorno
            );

            $pago->token_transbank = $respuesta->getToken();
            $pago->updated_at = date('Y-m-d H:i:s');

            if (!$pago->save(false)) {
                throw new \RuntimeException(
                    'No fue posible guardar el token de Transbank.'
                );
            }

            return $this->redirect($respuesta->getUrl());

        } catch (\Throwable $e) {
            $pago->estado = 'error';
            $pago->updated_at = date('Y-m-d H:i:s');
            $pago->save(false);

            Yii::error(
                'Error al iniciar Webpay: ' . $e->getMessage(),
                __METHOD__
            );

            throw new \yii\web\ServerErrorHttpException(
                'No fue posible iniciar el pago. Intenta nuevamente.'
            );
        }
    }

    /**
     * Recibe el retorno del usuario desde Webpay.
     */
    public function actionRetorno()
    {
        $token = Yii::$app->request->get('token_ws');

        
        if (!$token) {
            $tokenCancelacion = Yii::$app->request->get('TBK_TOKEN');
            $ordenCancelacion = Yii::$app->request->get('TBK_ORDEN_COMPRA');

            // Si Transbank devuelve datos de cancelación,
            // identificar el pago por su orden de compra.
            if ($tokenCancelacion && $ordenCancelacion) {
                $pagoCancelado = Pago::find()
                    ->where(['orden_compra' => $ordenCancelacion])
                    ->one();

                if (
                    $pagoCancelado !== null
                    && $pagoCancelado->estado === 'iniciado'
                    && !empty($pagoCancelado->token_transbank)
                    && hash_equals(
                        (string) $pagoCancelado->token_transbank,
                        (string) $tokenCancelacion
                    )
                ) {
                    $pagoCancelado->estado = 'anulado';
                    $pagoCancelado->updated_at = date('Y-m-d H:i:s');
                    $pagoCancelado->save(false);
                }

                Yii::$app->session->setFlash(
                    'warning',
                    'El pago no se ha confirmado. Puedes volver a intentarlo si corresponde.'
                );
            } else {
                // Sin parámetros no podemos identificar con seguridad
                // qué intento de pago terminó por tiempo de espera.
                Yii::$app->session->setFlash(
                    'warning',
                    'No se pudo confirmar el resultado del pago. Verifica su estado antes de reintentarlo.'
                );
            }

            return $this->redirect(['site/index', '#' => 'pago']);
        }

        $pago = Pago::find()
            ->where(['token_transbank' => $token])
            ->one();

        if ($pago === null) {
            throw new NotFoundHttpException(
                'No se encontró el intento de pago.'
            );
        }

        if ($pago->estado === 'aprobado') {
            Yii::$app->session->setFlash(
                'success',
                'Este pago ya fue confirmado.'
            );

            return $this->redirect(['site/index', '#' => 'pago']);
        }

        try {
            $config = require Yii::getAlias('@app/config/webpay.php');

            $opciones = new Options(
                $config['apiKey'],
                $config['codigoComercio'],
                Options::ENVIRONMENT_INTEGRATION
            );

            $transaccion = new Transaction($opciones);
            $resultado = $transaccion->commit($token);

            $montoConfirmado = (int) $resultado->getAmount();
            $ordenConfirmada = (string) $resultado->getBuyOrder();

            if (
                $resultado->getStatus() === 'AUTHORIZED'
                && $montoConfirmado === (int) $pago->monto
                && hash_equals(
                    (string) $pago->orden_compra,
                    $ordenConfirmada
                )
            ) {
                $transaction = Yii::$app->db->beginTransaction();

        try {
            $pago->estado = 'aprobado';
            $pago->codigo_autorizacion =
                (string) $resultado->getAuthorizationCode();
            $pago->fecha_pago = date('Y-m-d H:i:s');
            $pago->updated_at = date('Y-m-d H:i:s');

            if (!$pago->save(false)) {
                throw new \RuntimeException(
                    'No fue posible actualizar el pago.'
                );
            }

            $reserva = Reserva::findOne($pago->reserva_id);

            if ($reserva === null) {
                throw new \RuntimeException(
                    'No se encontró la reserva asociada.'
                );
            }

            $reserva->estado = 1;
            $reserva->updated_at = date('Y-m-d H:i:s');

            if (!$reserva->save(false)) {
                throw new \RuntimeException(
                    'No fue posible actualizar la reserva.'
                );
            }

            $transaction->commit();

            Yii::$app->session->setFlash(
                'success',
                'Transbank confirmó el pago y la reserva quedó confirmada.'
            );
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }

                Yii::$app->session->setFlash(
                    'success',
                    'Transbank confirmó el pago correctamente.'
                );
            } else {
                $pago->estado = 'rechazado';
                $pago->updated_at = date('Y-m-d H:i:s');
                $pago->save(false);

                Yii::$app->session->setFlash(
                    'error',
                    'El pago no fue aprobado o los datos no coinciden.'
                );
            }

        } catch (\Throwable $e) {
            Yii::error(
                'Error al confirmar Webpay: ' . $e->getMessage(),
                __METHOD__
            );

            Yii::$app->session->setFlash(
                'error',
                'No fue posible confirmar el pago. Se debe verificar su estado antes de reintentar.'
            );
        }

        return $this->redirect(['site/index', '#' => 'pago']);
    }
        
    public function actionConsultarEstado($id)
    {
        $pago = Pago::findOne((int) $id);

        if ($pago === null) {
            throw new NotFoundHttpException('No se encontró el pago.');
        }

        if (empty($pago->token_transbank)) {
            throw new BadRequestHttpException(
                'Este pago no tiene un token de Transbank para consultar.'
            );
        }

        $config = require Yii::getAlias('@app/config/webpay.php');

        try {
            $opciones = new Options(
                $config['apiKey'],
                $config['codigoComercio'],
                Options::ENVIRONMENT_INTEGRATION
            );

            $transaccion = new Transaction($opciones);
            $resultado = $transaccion->status(
                $pago->token_transbank
            );

            $estadoTransbank = (string) $resultado->getStatus();

            Yii::$app->session->setFlash(
                'info',
                'Estado informado por Transbank: ' . $estadoTransbank
                . '. Monto: ' . (int) $resultado->getAmount()
                . '. Orden de compra: ' . (string) $resultado->getBuyOrder()
            );
        } catch (\Throwable $e) {
            Yii::error(
                'Error al consultar estado del pago ID '
                . $pago->id . ': ' . $e->getMessage(),
                __METHOD__
            );

            Yii::$app->session->setFlash(
                'error',
                'No se pudo consultar el estado del pago. No se modificó su estado local.'
            );
        }

        return $this->redirect(['site/index', '#' => 'pago']);
    }
}