<?php

namespace app\controllers\admin;

use app\models\Fotografia;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class FotografiasController extends Controller
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
        $fotografias = Fotografia::find()
            ->orderBy([
                'orden' => SORT_ASC,
                'id' => SORT_DESC,
            ])
            ->all();

        return $this->render('index', [
            'fotografias' => $fotografias,
        ]);
    }

    public function actionCreate()
    {
        $model = new Fotografia();

        if ($model->load($this->request->post())) {

            $model->imagenFile = UploadedFile::getInstance(
                $model,
                'imagenFile'
            );

            if ($model->validate()) {

                if ($model->imagenFile !== null) {

                    $nombreArchivo = uniqid(
                        'foto_',
                        true
                    ) . '.' . $model->imagenFile->extension;

                    $ruta = \Yii::getAlias(
                        '@webroot/uploads/fotografias/'
                    ) . $nombreArchivo;

                    if ($model->imagenFile->saveAs($ruta)) {

                        $model->archivo = $nombreArchivo;
                    } else {

                        $model->addError(
                            'imagenFile',
                            'No fue posible guardar la imagen.'
                        );
                    }
                }

                if (!$model->hasErrors()) {

                    $model->created_at = date('Y-m-d H:i:s');
                    $model->updated_at = date('Y-m-d H:i:s');

                    if ($model->save(false)) {
                        return $this->redirect(['index']);
                    }
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

    $archivoAnterior = $model->archivo;

    if ($model->load($this->request->post())) {
        $model->imagenFile = UploadedFile::getInstance(
            $model,
            'imagenFile'
        );

        // Si no se seleccionó una nueva imagen,
        // conservamos la imagen actual.
        if ($model->validate()) {

            if ($model->imagenFile !== null) {

                $nombreArchivo = uniqid(
                    'foto_',
                    true
                ) . '.' . $model->imagenFile->extension;

                $ruta = \Yii::getAlias(
                    '@webroot/uploads/fotografias/'
                ) . $nombreArchivo;

                if (!$model->imagenFile->saveAs($ruta)) {

                    $model->addError(
                        'imagenFile',
                        'No fue posible guardar la nueva imagen.'
                    );

                } else {

                    $model->archivo = $nombreArchivo;

                    if (!empty($archivoAnterior)) {

                        $rutaAnterior = \Yii::getAlias(
                            '@webroot/uploads/fotografias/'
                        ) . $archivoAnterior;

                        if (is_file($rutaAnterior)) {
                            @unlink($rutaAnterior);
                        }
                    }
                }
            }

            if (!$model->hasErrors()) {

    $model->updated_at = date('Y-m-d H:i:s');

    if ($model->save()) {

        return $this->redirect(['index']);
    }

    dd($model->errors);
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

        if (!empty($model->archivo)) {

            $ruta = \Yii::getAlias(
                '@webroot/uploads/fotografias/'
            ) . $model->archivo;

            if (is_file($ruta)) {
                @unlink($ruta);
            }
        }

        $model->delete();

        return $this->redirect(['index']);
    }

    public function actionToggle($id)
    {
        $model = $this->findModel($id);

        $model->estado = $model->estado == 1 ? 0 : 1;
        $model->updated_at = time();

        $model->save(false);

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Fotografia::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(
            'La fotografía solicitada no existe.'
        );
    }
}