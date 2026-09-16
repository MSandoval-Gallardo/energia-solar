<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Reserva $model */

$this->title = 'Reserva #' . $model->id;
?>

<div class="reservas-view">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1><?= Html::encode($this->title) ?></h1>
            <p class="text-muted mb-0">
                Detalle de la solicitud de reserva.
            </p>
        </div>

        <?= Html::a('Volver a reservas', ['index'], [
            'class' => 'btn btn-secondary',
        ]) ?>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <h4 class="mb-4">
                Información del cliente
            </h4>

            <div class="row mb-3">
                <div class="col-md-4">
                    <strong>Nombre</strong>
                </div>
                <div class="col-md-8">
                    <?= Html::encode($model->nombre) ?>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <strong>Correo electrónico</strong>
                </div>
                <div class="col-md-8">
                    <?= Html::encode($model->email) ?>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <strong>Teléfono</strong>
                </div>
                <div class="col-md-8">
                    <?= Html::encode($model->telefono) ?>
                </div>
            </div>

            <hr>

            <h4 class="mb-4">
                Información de la reserva
            </h4>

            <div class="row mb-3">
                <div class="col-md-4">
                    <strong>Fecha</strong>
                </div>
                <div class="col-md-8">
                    <?= Yii::$app->formatter->asDate(
                        $model->fecha,
                        'php:d/m/Y'
                    ) ?>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <strong>Hora</strong>
                </div>
                <div class="col-md-8">
                    <?= Html::encode(substr($model->hora, 0, 5)) ?>
                </div>
            </div>
            <div class="row mb-3">
    <div class="col-md-4">
        <strong>Monto de reserva</strong>
    </div>
    <div class="col-md-8">
        <?php if ($model->monto_reserva !== null): ?>

            <strong class="text-success">
                $<?= number_format(
                    $model->monto_reserva,
                    0,
                    ',',
                    '.'
                ) ?> CLP
            </strong>

        <?php else: ?>

            <span class="text-muted">
                No informado
            </span>

        <?php endif; ?>
    </div>
</div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <strong>Estado</strong>
                </div>
                <div class="col-md-8">

                    <?php if ($model->estado == 0): ?>

                        <span class="badge bg-warning text-dark">
                            Pendiente
                        </span>

                    <?php elseif ($model->estado == 1): ?>

                        <span class="badge bg-success">
                            Confirmada
                        </span>

                    <?php elseif ($model->estado == 2): ?>

                        <span class="badge bg-danger">
                            Cancelada
                        </span>

                    <?php endif; ?>

                </div>
            </div>

            <?php if (!empty($model->mensaje)): ?>

                <hr>

                <h4 class="mb-3">
                    Mensaje del cliente
                </h4>

                <div class="bg-light p-3 rounded">
                    <?= nl2br(Html::encode($model->mensaje)) ?>
                </div>

            <?php endif; ?>

            <hr>

            <div class="text-muted small">
                Creada:
                <?= Html::encode($model->created_at) ?>
                <br>
                Última actualización:
                <?= Html::encode($model->updated_at) ?>
            </div>

        </div>
    </div>

</div>