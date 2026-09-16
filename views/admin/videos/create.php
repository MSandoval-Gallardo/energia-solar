<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var app\models\Video $model */

$this->title = 'Agregar Video';
?>

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><?= Html::encode($this->title) ?></h1>

        <?= Html::a(
            '← Volver',
            ['index'],
            ['class' => 'btn btn-secondary']
        ) ?>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'titulo')->textInput([
                'maxlength' => true,
                'placeholder' => 'Ej: Instalación de paneles solares',
            ]) ?>

            <?= $form->field($model, 'descripcion')->textarea([
                'rows' => 4,
                'placeholder' => 'Breve descripción del video',
            ]) ?>

            <?= $form->field($model, 'url')->textInput([
                'maxlength' => true,
                'placeholder' => 'https://www.youtube.com/watch?v=...',
            ]) ?>

            <?= $form->field($model, 'miniatura')->textInput([
                'maxlength' => true,
                'placeholder' => 'URL de la miniatura (opcional)',
            ]) ?>

            <div class="row">

                <div class="col-md-6">
                    <?= $form->field($model, 'orden')->input('number', [
                        'min' => 0,
                        'value' => $model->orden ?? 0,
                    ]) ?>
                </div>

                <div class="col-md-6">
                    <?= $form->field($model, 'estado')->dropDownList([
                        1 => 'Activo',
                        0 => 'Inactivo',
                    ]) ?>
                </div>

            </div>

            <div class="mt-3">

                <?= Html::submitButton(
                    '💾 Guardar video',
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