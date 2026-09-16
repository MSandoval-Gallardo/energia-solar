<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Presupuesto[] $presupuestos */

$this->title = 'Presupuestos';
?>

<div class="presupuestos-index">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1><?= Html::encode($this->title) ?></h1>

            <p class="text-muted mb-0">
                Administración de presupuestos y reservas.
            </p>
        </div>

        <?= Html::a(
            'Nuevo presupuesto',
            ['create'],
            ['class' => 'btn btn-primary']
        ) ?>

    </div>

    <?php if (empty($presupuestos)): ?>

        <div class="alert alert-info">
            Actualmente no hay presupuestos registrados.
        </div>

    <?php else: ?>

        <div class="table-responsive">

            <table class="table table-bordered table-hover align-middle">

                <thead class="table-dark">

                    <tr>
                        <th>ID</th>
                        <th>Código</th>
                        <th>Cliente</th>
                        <th>Monto total</th>
                        <th>Reserva</th>
                        <th>Monto reserva</th>
                        <th>Estado</th>
                        <th style="width: 280px;">Acciones</th>
                    </tr>

                </thead>

                <tbody>

                <?php foreach ($presupuestos as $presupuesto): ?>

                    <tr>

                        <td>
                            <?= Html::encode($presupuesto->id) ?>
                        </td>

                        <td>
                            <strong>
                                <?= Html::encode($presupuesto->codigo) ?>
                            </strong>
                        </td>

                        <td>
                            <?= Html::encode($presupuesto->cliente) ?>

                            <?php if (!empty($presupuesto->email)): ?>

                                <br>

                                <small class="text-muted">
                                    <?= Html::encode($presupuesto->email) ?>
                                </small>

                            <?php endif; ?>
                        </td>

                        <td>
                            <strong>
                                $<?= number_format(
                                    $presupuesto->monto_total,
                                    0,
                                    ',',
                                    '.'
                                ) ?>
                            </strong>

                            <small class="text-muted">
                                CLP
                            </small>
                        </td>

                        <td>
                            <span class="badge bg-info text-dark">
                                <?= Html::encode(
                                    $presupuesto->porcentaje_reserva
                                ) ?>%
                            </span>
                        </td>

                        <td>
                            <strong class="text-success">
                                $<?= number_format(
                                    $presupuesto->monto_reserva,
                                    0,
                                    ',',
                                    '.'
                                ) ?>
                            </strong>

                            <small class="text-muted">
                                CLP
                            </small>
                        </td>

                        <td>

                            <?php if ($presupuesto->estado == 1): ?>

                                <span class="badge bg-success">
                                    Activo
                                </span>

                            <?php else: ?>

                                <span class="badge bg-secondary">
                                    Inactivo
                                </span>

                            <?php endif; ?>

                        </td>

                        <td>

                            <?= Html::a(
                                'Ver',
                                ['view', 'id' => $presupuesto->id],
                                ['class' => 'btn btn-sm btn-primary']
                            ) ?>

                            <?= Html::a(
                                'Editar',
                                ['update', 'id' => $presupuesto->id],
                                ['class' => 'btn btn-sm btn-warning']
                            ) ?>

                            <?= Html::beginForm(
                                ['toggle', 'id' => $presupuesto->id],
                                'post',
                                ['style' => 'display:inline']
                            ) ?>

                                <?= Html::submitButton(
                                    $presupuesto->estado == 1
                                        ? 'Desactivar'
                                        : 'Activar',
                                    [
                                        'class' =>
                                            'btn btn-sm ' .
                                            (
                                                $presupuesto->estado == 1
                                                    ? 'btn-secondary'
                                                    : 'btn-success'
                                            ),
                                        'data-confirm' =>
                                            $presupuesto->estado == 1
                                                ? '¿Desactivar este presupuesto?'
                                                : '¿Activar este presupuesto?',
                                    ]
                                ) ?>

                            <?= Html::endForm() ?>

                            <?= Html::beginForm(
                                ['delete', 'id' => $presupuesto->id],
                                'post',
                                ['style' => 'display:inline']
                            ) ?>

                                <?= Html::submitButton(
                                    'Eliminar',
                                    [
                                        'class' => 'btn btn-sm btn-danger',
                                        'data-confirm' =>
                                            '¿Eliminar definitivamente este presupuesto?',
                                    ]
                                ) ?>

                            <?= Html::endForm() ?>

                        </td>

                    </tr>

                <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    <?php endif; ?>

</div>