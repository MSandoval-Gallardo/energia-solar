<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Presupuesto $model */

$this->title = 'Editar presupuesto #' . $model->id;
?>

<div class="presupuestos-update">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1><?= Html::encode($this->title) ?></h1>

            <p class="text-muted mb-0">
                Modifica los datos del presupuesto y su porcentaje de reserva.
            </p>
        </div>

        <?= Html::a(
            'Volver a presupuestos',
            ['index'],
            ['class' => 'btn btn-secondary']
        ) ?>

    </div>


    <div class="card shadow-sm">

        <div class="card-body">

            <?php $form = ActiveForm::begin(); ?>

            <h4 class="mb-4">
                Información del cliente
            </h4>

            <?= $form->field($model, 'codigo')
                ->textInput([
                    'maxlength' => true,
                ]) ?>

            <?= $form->field($model, 'cliente')
                ->textInput([
                    'maxlength' => true,
                ]) ?>

            <div class="row">

                <div class="col-md-6">

                    <?= $form->field($model, 'email')
                        ->input('email') ?>

                </div>

                <div class="col-md-6">

                    <?= $form->field($model, 'telefono')
                        ->textInput([
                            'maxlength' => true,
                        ]) ?>

                </div>

            </div>


            <hr class="my-4">


            <h4 class="mb-4">
                Información del presupuesto
            </h4>


            <?= $form->field($model, 'monto_total')
                ->textInput([
                    'type' => 'number',
                    'min' => 1,
                    'step' => 1,
                    'id' => 'monto-total',
                ]) ?>


            <div class="row">

                <div class="col-md-6">

                    <?= $form->field($model, 'porcentaje_reserva')
                        ->dropDownList(
                            [
                                10 => '10%',
                                20 => '20%',
                                30 => '30%',
                                40 => '40%',
                                50 => '50%',
                                60 => '60%',
                                70 => '70%',
                                80 => '80%',
                                90 => '90%',
                                100 => '100%',
                            ],
                            [
                                'id' => 'porcentaje-reserva',
                            ]
                        ) ?>

                </div>


                <div class="col-md-6">

                    <label class="form-label">
                        Monto de reserva
                    </label>

                    <div
                        id="monto-reserva-preview"
                        class="form-control bg-light fw-bold"
                    >
                        $0 CLP
                    </div>

                    <div class="form-text">
                        Se recalcula automáticamente según el monto total y el porcentaje.
                    </div>

                </div>

            </div>


            <div class="alert alert-info mt-4">

                <strong>Resumen del presupuesto</strong>

                <div class="mt-2">

                    Monto total:
                    <strong id="resumen-total">
                        $0 CLP
                    </strong>

                </div>

                <div>

                    Reserva:
                    <strong id="resumen-porcentaje">
                        50%
                    </strong>

                </div>

                <div>

                    Monto a reservar:
                    <strong id="resumen-reserva">
                        $0 CLP
                    </strong>

                </div>

                <div>

                    Saldo restante:
                    <strong id="resumen-saldo">
                        $0 CLP
                    </strong>

                </div>

            </div>


            <?= $form->field($model, 'estado')
                ->dropDownList([
                    1 => 'Activo',
                    0 => 'Inactivo',
                ]) ?>


            <div class="mt-4">

                <?= Html::submitButton(
                    'Guardar cambios',
                    [
                        'class' => 'btn btn-primary',
                    ]
                ) ?>

                <?= Html::a(
                    'Cancelar',
                    ['view', 'id' => $model->id],
                    [
                        'class' => 'btn btn-secondary',
                    ]
                ) ?>

            </div>


            <?php ActiveForm::end(); ?>

        </div>

    </div>

</div>


<?php

$js = <<<JS

function actualizarResumenPresupuesto() {

    const montoTotal =
        parseInt(
            document.getElementById('monto-total').value
        ) || 0;

    const porcentaje =
        parseInt(
            document.getElementById('porcentaje-reserva').value
        ) || 0;

    const montoReserva =
        Math.round(
            montoTotal * porcentaje / 100
        );

    const saldo =
        montoTotal - montoReserva;

    const formato = new Intl.NumberFormat('es-CL');

    document.getElementById('monto-reserva-preview').textContent =
        '$' + formato.format(montoReserva) + ' CLP';

    document.getElementById('resumen-total').textContent =
        '$' + formato.format(montoTotal) + ' CLP';

    document.getElementById('resumen-porcentaje').textContent =
        porcentaje + '%';

    document.getElementById('resumen-reserva').textContent =
        '$' + formato.format(montoReserva) + ' CLP';

    document.getElementById('resumen-saldo').textContent =
        '$' + formato.format(saldo) + ' CLP';
}


document.getElementById('monto-total')
    .addEventListener('input', actualizarResumenPresupuesto);


document.getElementById('porcentaje-reserva')
    .addEventListener('change', actualizarResumenPresupuesto);


actualizarResumenPresupuesto();

JS;

$this->registerJs($js);

?>