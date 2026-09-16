<?php

namespace app\controllers\admin;

use Yii;
use app\models\Presupuesto;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class PresupuestosController extends Controller
{
    public function behaviors()
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
                    'toggle' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lista todos los presupuestos.
     */
    public function actionIndex()
    {
        $presupuestos = Presupuesto::find()
            ->orderBy([
                'id' => SORT_DESC,
            ])
            ->all();

        return $this->render('index', [
            'presupuestos' => $presupuestos,
        ]);
    }

    /**
     * Crea un nuevo presupuesto.
     */
    public function actionCreate()
    {
        $model = new Presupuesto();

        $model->porcentaje_reserva = 50;
        $model->estado = 1;

        if ($model->load(Yii::$app->request->post())) {

            $model->calcularMontoReserva();

            $now = date('Y-m-d H:i:s');

            $model->created_at = $now;
            $model->updated_at = $now;

            if ($model->save()) {

                Yii::$app->session->setFlash(
                    'success',
                    'Presupuesto creado correctamente.'
                );

                return $this->redirect([
                    'view',
                    'id' => $model->id,
                ]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Muestra un presupuesto.
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Edita un presupuesto existente.
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            $model->calcularMontoReserva();

            $model->updated_at = date('Y-m-d H:i:s');

            if ($model->save()) {

                Yii::$app->session->setFlash(
                    'success',
                    'Presupuesto actualizado correctamente.'
                );

                return $this->redirect([
                    'view',
                    'id' => $model->id,
                ]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Activa o desactiva un presupuesto.
     */
    public function actionToggle($id)
    {
        $model = $this->findModel($id);

        $model->estado = $model->estado == 1 ? 0 : 1;
        $model->updated_at = date('Y-m-d H:i:s');

        $model->save(false);

        Yii::$app->session->setFlash(
            'success',
            $model->estado == 1
                ? 'Presupuesto activado.'
                : 'Presupuesto desactivado.'
        );

        return $this->redirect(['index']);
    }

    /**
     * Elimina un presupuesto.
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $model->delete();

        Yii::$app->session->setFlash(
            'success',
            'Presupuesto eliminado correctamente.'
        );

        return $this->redirect(['index']);
    }

    /**
     * Busca un presupuesto por ID.
     */
    protected function findModel($id)
    {
        if (($model = Presupuesto::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(
            'El presupuesto solicitado no existe.'
        );
    }
}