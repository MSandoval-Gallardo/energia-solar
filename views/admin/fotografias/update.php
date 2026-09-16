<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Fotografia;

/** @var Fotografia $model */

$this->title = 'Editar fotografía';
?>

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1>Editar fotografía</h1>

            <p class="text-muted mb-0">
                Modifica los datos de la fotografía.
            </p>
        </div>

        <?= Html::a(
            '← Volver',
            ['index'],
            ['class' => 'btn btn-outline-secondary']
        ) ?>

    </div>

    <div class="card shadow-sm">

        <div class="card-body">

            <?php if (!empty($model->archivo)): ?>

                <div class="mb-4">
                    <p class="fw-bold mb-2">Fotografía actual</p>

                    <?= Html::img(
                        Yii::getAlias(
                            '@web/uploads/fotografias/' . $model->archivo
                        ),
                        [
                            'class' => 'img-fluid rounded',
                            'style' => 'max-height: 300px;',
                            'alt' => $model->titulo,
                        ]
                    ) ?>
                </div>

            <?php endif; ?>

            <?php $form = ActiveForm::begin([
                'options' => [
                    'enctype' => 'multipart/form-data',
                ],
            ]); ?>

            <?= $form->field($model, 'titulo')
                ->textInput([
                    'maxlength' => true,
                ]) ?>

            <?= $form->field($model, 'descripcion')
                ->textarea([
                    'rows' => 4,
                ]) ?>

            <?= $form->field($model, 'imagenFile')
                ->fileInput([
                    'accept' => 'image/jpeg,image/png,image/webp',
                ]) ?>

            <div class="form-text mb-3">
                Si no seleccionas una nueva imagen, se conservará la actual.
            </div>

            <?= $form->field($model, 'orden')
                ->input('number', [
                    'min' => 0,
                ]) ?>

            <?= $form->field($model, 'estado')
                ->dropDownList([
                    1 => 'Visible',
                    0 => 'Oculta',
                ]) ?>

            <div class="mt-4">

                <?= Html::submitButton(
                    'Guardar cambios',
                    ['class' => 'btn btn-primary']
                ) ?>

                <?= Html::a(
                    'Cancelar',
                    ['index'],
                    ['class' => 'btn btn-secondary ms-2']
                ) ?>

            </div>

            <?php ActiveForm::end(); ?>

        </div>

    </div>

</div>