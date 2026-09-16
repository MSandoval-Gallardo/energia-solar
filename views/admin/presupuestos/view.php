<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Presupuesto $model */

$this->title = 'Presupuesto #' . $model->id;
?>

<div class="presupuestos-view">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1><?= Html::encode($this->title) ?></h1>

            <p class="text-muted mb-0">
                Detalle del presupuesto.
            </p>
        </div>

        <div>

            <?= Html::a(
                'Editar',
                ['update', 'id' => $model->id],
                ['class' => 'btn btn-warning']
            ) ?>

            <?= Html::a(
                'Volver a presupuestos',
                ['index'],
                ['class' => 'btn btn-secondary']
            ) ?>

        </div>

    </div>


    <div class="card shadow-sm">

        <div class="card-body">

            <h4 class="mb-4">
                Información del cliente
            </h4>

            <div class="row mb-3">

                <div class="col-md-4">
                    <strong>Código de presupuesto</strong>
                </div>

                <div class="col-md-8">
                    <strong>
                        <?= Html::encode($model->codigo) ?>
                    </strong>
                </div>

            </div>

            <div class="row mb-3">

                <div class="col-md-4">
                    <strong>Cliente</strong>
                </div>

                <div class="col-md-8">
                    <?= Html::encode($model->cliente) ?>
                </div>

            </div>

            <?php if (!empty($model->email)): ?>

                <div class="row mb-3">

                    <div class="col-md-4">
                        <strong>Correo electrónico</strong>
                    </div>

                    <div class="col-md-8">
                        <?= Html::encode($model->email) ?>
                    </div>

                </div>

            <?php endif; ?>

            <?php if (!empty($model->telefono)): ?>

                <div class="row mb-3">

                    <div class="col-md-4">
                        <strong>Teléfono</strong>
                    </div>

                    <div class="col-md-8">
                        <?= Html::encode($model->telefono) ?>
                    </div>

                </div>

            <?php endif; ?>


            <hr class="my-4">


            <h4 class="mb-4">
                Información económica
            </h4>


            <div class="row mb-3">

                <div class="col-md-4">
                    <strong>Monto total del proyecto</strong>
                </div>

                <div class="col-md-8">

                    <strong>
                        $<?= number_format(
                            $model->monto_total,
                            0,
                            ',',
                            '.'
                        ) ?>
                    </strong>

                    <span class="text-muted">
                        CLP
                    </span>

                </div>

            </div>


            <div class="row mb-3">

                <div class="col-md-4">
                    <strong>Porcentaje de reserva</strong>
                </div>

                <div class="col-md-8">

                    <span class="badge bg-info text-dark">
                        <?= Html::encode(
                            $model->porcentaje_reserva
                        ) ?>%
                    </span>

                </div>

            </div>


            <div class="row mb-3">

                <div class="col-md-4">
                    <strong>Monto de reserva</strong>
                </div>

                <div class="col-md-8">

                    <strong class="text-success fs-5">
                        $<?= number_format(
                            $model->monto_reserva,
                            0,
                            ',',
                            '.'
                        ) ?>
                    </strong>

                    <span class="text-muted">
                        CLP
                    </span>

                </div>

            </div>


            <div class="row mb-3">

                <div class="col-md-4">
                    <strong>Saldo restante</strong>
                </div>

                <div class="col-md-8">

                    <strong>
                        $<?= number_format(
                            $model->monto_total - $model->monto_reserva,
                            0,
                            ',',
                            '.'
                        ) ?>
                    </strong>

                    <span class="text-muted">
                        CLP
                    </span>

                </div>

            </div>


            <div class="row mb-3">

                <div class="col-md-4">
                    <strong>Estado</strong>
                </div>

                <div class="col-md-8">

                    <?php if ($model->estado == 1): ?>

                        <span class="badge bg-success">
                            Activo
                        </span>

                    <?php else: ?>

                        <span class="badge bg-secondary">
                            Inactivo
                        </span>

                    <?php endif; ?>

                </div>

            </div>


            <hr class="my-4">


            <div class="text-muted small">

                Creado:
                <?= Html::encode($model->created_at) ?>

                <br>

                Última actualización:
                <?= Html::encode($model->updated_at) ?>

            </div>

        </div>

    </div>

</div>
