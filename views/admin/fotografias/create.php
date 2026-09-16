<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Fotografia;

/** @var Fotografia $model */

$this->title = 'Agregar fotografía';
?>

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1>Agregar fotografía</h1>

            <p class="text-muted">
                Agrega una nueva fotografía a la galería.
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

            <?php $form = ActiveForm::begin([
                'options' => [
                    'enctype' => 'multipart/form-data',
                ],
            ]); ?>

            <?= $form->field($model, 'titulo')
                ->textInput([
                    'maxlength' => true,
                    'placeholder' => 'Ej: Instalación residencial',
                ]) ?>

            <?= $form->field($model, 'descripcion')
                ->textarea([
                    'rows' => 4,
                    'placeholder' => 'Escribe una breve descripción o reseña...',
                ]) ?>

            <?= $form->field($model, 'imagenFile')->fileInput([
                'accept' => 'image/jpeg,image/png,image/webp',
            ]) ?>

            <?= $form->field($model, 'orden')
                ->input('number', [
                    'min' => 0,
                    'value' => 0,
                ]) ?>

            <?= $form->field($model, 'estado')
                ->dropDownList([
                    1 => 'Visible',
                    0 => 'Oculta',
                ]) ?>

            <div class="mt-4">

                <?= Html::submitButton(
                    'Guardar fotografía',
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