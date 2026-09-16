<?php

namespace app\controllers\admin;

use Yii;
use app\models\Proyecto;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\FileHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class ProyectosController extends Controller
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
                    'toggle' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $proyectos = Proyecto::find()
            ->orderBy([
                'orden' => SORT_ASC,
                'id' => SORT_ASC,
            ])
            ->all();

        return $this->render('index', [
            'proyectos' => $proyectos,
        ]);
    }

    public function actionCreate()
    {
        $model = new Proyecto();
        $model->estado = 1;
        $model->orden = 0;

        if ($model->load(Yii::$app->request->post())) {

            $model->loadUploadedImage();

            if ($model->validate()) {

                if ($model->imagenFile) {

                    $uploadPath = Yii::getAlias('@webroot/uploads/proyectos');

                    FileHelper::createDirectory($uploadPath);

                    $extension = strtolower($model->imagenFile->extension);

                    $fileName = Yii::$app->security->generateRandomString(32)
                        . '.'
                        . $extension;

                    if (!$model->imagenFile->saveAs($uploadPath . DIRECTORY_SEPARATOR . $fileName)) {
                        $model->addError(
                            'imagenFile',
                            'No fue posible guardar la imagen.'
                        );

                        return $this->render('create', [
                            'model' => $model,
                        ]);
                    }

                    $model->imagen = $fileName;
                }

                $now = date('Y-m-d H:i:s');

                $model->created_at = $now;
                $model->updated_at = $now;

                if ($model->save(false)) {

                    Yii::$app->session->setFlash(
                        'success',
                        'Proyecto creado correctamente.'
                    );

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

        $oldImage = $model->imagen;

        if ($model->load(Yii::$app->request->post())) {

            $model->loadUploadedImage();

            if ($model->validate()) {

                if ($model->imagenFile) {

                    $uploadPath = Yii::getAlias('@webroot/uploads/proyectos');

                    FileHelper::createDirectory($uploadPath);

                    $extension = strtolower($model->imagenFile->extension);

                    $fileName = Yii::$app->security->generateRandomString(32)
                        . '.'
                        . $extension;

                    if (!$model->imagenFile->saveAs($uploadPath . DIRECTORY_SEPARATOR . $fileName)) {
                        $model->addError(
                            'imagenFile',
                            'No fue posible guardar la nueva imagen.'
                        );

                        return $this->render('update', [
                            'model' => $model,
                        ]);
                    }

                    $model->imagen = $fileName;
                } else {
                    $model->imagen = $oldImage;
                }

                $model->updated_at = date('Y-m-d H:i:s');

                if ($model->save(false)) {

                    if ($model->imagenFile && $oldImage) {

                        $oldPath = Yii::getAlias(
                            '@webroot/uploads/proyectos/' . $oldImage
                        );

                        if (is_file($oldPath)) {
                            @unlink($oldPath);
                        }
                    }

                    Yii::$app->session->setFlash(
                        'success',
                        'Proyecto actualizado correctamente.'
                    );

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

        $image = $model->imagen;

        if ($model->delete()) {

            if ($image) {

                $imagePath = Yii::getAlias(
                    '@webroot/uploads/proyectos/' . $image
                );

                if (is_file($imagePath)) {
                    @unlink($imagePath);
                }
            }

            Yii::$app->session->setFlash(
                'success',
                'Proyecto eliminado correctamente.'
            );
        }

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
        if (($model = Proyecto::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(
            'El proyecto solicitado no existe.'
        );
    }
}