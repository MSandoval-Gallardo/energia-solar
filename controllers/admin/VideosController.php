<?php

namespace app\controllers\admin;

use app\models\Video;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class VideosController extends Controller
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
        ];
    }

    public function actionIndex()
    {
        $videos = Video::find()
            ->orderBy([
                'orden' => SORT_ASC,
                'id' => SORT_DESC,
            ])
            ->all();

        return $this->render('index', [
            'videos' => $videos,
        ]);
    }

    public function actionCreate()
    {
        $model = new Video();

        if ($model->load($this->request->post())) {

            if ($model->validate()) {

                $model->created_at = date('Y-m-d H:i:s');
                $model->updated_at = date('Y-m-d H:i:s');

                if ($model->save()) {
                    return $this->redirect(['index']);
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load($this->request->post())) {

            if ($model->validate()) {

                $model->updated_at = date('Y-m-d H:i:s');

                if ($model->save()) {
                    return $this->redirect(['index']);
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $model->delete();

        return $this->redirect(['index']);
    }

    public function actionToggle($id)
    {
        $model = $this->findModel($id);

        $model->estado = $model->estado == 1 ? 0 : 1;
        $model->updated_at = date('Y-m-d H:i:s');

        $model->save(false);

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Video::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(
            'El video solicitado no existe.'
        );
    }
}