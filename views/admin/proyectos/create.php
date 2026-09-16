<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Proyecto $model */

$this->title = 'Nuevo proyecto';
?>

<div class="proyecto-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        'options' => [
            'enctype' => 'multipart/form-data',
        ],
    ]); ?>

    <?= $form->field($model, 'titulo')->textInput([
        'maxlength' => true,
        'placeholder' => 'Ej: Instalación solar residencial',
    ]) ?>

    <?= $form->field($model, 'descripcion')->textarea([
        'rows' => 5,
        'placeholder' => 'Describe brevemente el proyecto...',
    ]) ?>

    <?= $form->field($model, 'imagenFile')->fileInput([
        'accept' => 'image/jpeg,image/png,image/webp',
    ]) ?>

    <div class="form-text mb-3">
        Formatos permitidos: JPG, JPEG, PNG y WEBP.
        Tamaño máximo: 5 MB.
    </div>

    <?= $form->field($model, 'orden')->input('number', [
        'min' => 0,
    ]) ?>

    <?= $form->field($model, 'estado')->dropDownList([
        1 => 'Activo',
        0 => 'Inactivo',
    ]) ?>

    <div class="form-group mt-3">
        <?= Html::submitButton('Guardar proyecto', [
            'class' => 'btn btn-primary',
        ]) ?>

        <?= Html::a('Cancelar', ['index'], [
            'class' => 'btn btn-secondary ms-2',
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>