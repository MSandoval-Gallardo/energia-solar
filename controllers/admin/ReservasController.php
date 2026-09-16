<?php

namespace app\controllers\admin;

use Yii;
use app\models\Reserva;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ReservasController extends Controller
{
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],

            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                    'confirmar' => ['POST'],
                    'cancelar' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $reservas = Reserva::find()
            ->orderBy([
                'fecha' => SORT_DESC,
                'hora' => SORT_DESC,
                'id' => SORT_DESC,
            ])
            ->all();

        return $this->render('index', [
            'reservas' => $reservas,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionConfirmar($id)
    {
        $model = $this->findModel($id);

        $model->estado = 1;
        $model->updated_at = date('Y-m-d H:i:s');

        if ($model->save(false)) {
            Yii::$app->session->setFlash(
                'success',
                'Reserva confirmada correctamente.'
            );
        }

        return $this->redirect(['index']);
    }

    public function actionCancelar($id)
    {
        $model = $this->findModel($id);

        $model->estado = 2;
        $model->updated_at = date('Y-m-d H:i:s');

        if ($model->save(false)) {
            Yii::$app->session->setFlash(
                'success',
                'Reserva cancelada correctamente.'
            );
        }

        return $this->redirect(['index']);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if ($model->delete()) {
            Yii::$app->session->setFlash(
                'success',
                'Reserva eliminada correctamente.'
            );
        }

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Reserva::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(
            'La reserva solicitada no existe.'
        );
    }
}