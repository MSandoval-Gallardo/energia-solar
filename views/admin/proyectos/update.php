<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Proyecto $model */

$this->title = 'Editar proyecto: ' . $model->titulo;
?>

<div class="proyecto-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if ($model->imagen): ?>

        <div class="mb-4">
            <p><strong>Imagen actual:</strong></p>

            <img
                src="<?= Yii::getAlias('@web/uploads/proyectos/' . $model->imagen) ?>"
                alt="<?= Html::encode($model->titulo) ?>"
                style="
                    max-width: 400px;
                    max-height: 250px;
                    object-fit: cover;
                    border-radius: 8px;
                    border: 1px solid #ddd;
                    padding: 4px;
                "
            >
        </div>

    <?php endif; ?>

    <?php $form = ActiveForm::begin([
        'options' => [
            'enctype' => 'multipart/form-data',
        ],
    ]); ?>

    <?= $form->field($model, 'titulo')->textInput([
        'maxlength' => true,
    ]) ?>

    <?= $form->field($model, 'descripcion')->textarea([
        'rows' => 5,
    ]) ?>

    <?= $form->field($model, 'imagenFile')->fileInput([
        'accept' => 'image/jpeg,image/png,image/webp',
    ]) ?>

    <div class="form-text mb-3">
        Selecciona una nueva imagen solamente si deseas reemplazar
        la imagen actual.<br>
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

        <?= Html::submitButton('Guardar cambios', [
            'class' => 'btn btn-primary',
        ]) ?>

        <?= Html::a('Cancelar', ['index'], [
            'class' => 'btn btn-secondary ms-2',
        ]) ?>

    </div>

    <?php ActiveForm::end(); ?>

</div>