<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Reserva[] $reservas */

$this->title = 'Reservas';
?>

<div class="reservas-index">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1><?= Html::encode($this->title) ?></h1>
            <p class="text-muted mb-0">
                Administración de solicitudes de reserva.
            </p>
        </div>
    </div>

    <?php if (empty($reservas)): ?>

        <div class="alert alert-info">
            Actualmente no hay reservas registradas.
        </div>

    <?php else: ?>

        <div class="table-responsive">

            <table class="table table-bordered table-hover align-middle">

                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Contacto</th>
                        <th>Monto reserva</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Estado</th>
                        <th style="width: 260px;">Acciones</th>
                    </tr>
                </thead>

                <tbody>

                <?php foreach ($reservas as $reserva): ?>

                    <tr>

                        <td>
                            <?= Html::encode($reserva->id) ?>
                        </td>

                        <td>
                            <strong>
                                <?= Html::encode($reserva->nombre) ?>
                            </strong>
                        </td>

                       <td>
                            <?= Html::encode($reserva->email) ?><br>
                            <small>
                                <?= Html::encode($reserva->telefono) ?>
                            </small>
                        </td>

                        <td>
                            <?php if ($reserva->monto_reserva !== null): ?>

                                <strong>
                                    $<?= number_format(
                                        $reserva->monto_reserva,
                                        0,
                                        ',',
                                        '.'
                                    ) ?>
                                </strong>

                                <small class="text-muted">CLP</small>

                            <?php else: ?>

                                <span class="text-muted">
                                    No informado
                                </span>

                            <?php endif; ?>
                        </td>

                        <td>
                            <?= Yii::$app->formatter->asDate(
                                $reserva->fecha,
                                'php:d/m/Y'
                            ) ?>
                        </td>

                        <td>
                            <?= Html::encode(
                                substr($reserva->hora, 0, 5)
                            ) ?>
                        </td>

                        <td>

                            <?php if ($reserva->estado == 0): ?>

                                <span class="badge bg-warning text-dark">
                                    Pendiente
                                </span>

                            <?php elseif ($reserva->estado == 1): ?>

                                <span class="badge bg-success">
                                    Confirmada
                                </span>

                            <?php elseif ($reserva->estado == 2): ?>

                                <span class="badge bg-danger">
                                    Cancelada
                                </span>

                            <?php endif; ?>

                        </td>

                        <td>

                            <?= Html::a(
                                'Ver',
                                ['view', 'id' => $reserva->id],
                                ['class' => 'btn btn-sm btn-primary']
                            ) ?>

                            <?php if ($reserva->estado != 1): ?>

                                <?= Html::beginForm(
                                    ['confirmar', 'id' => $reserva->id],
                                    'post',
                                    ['style' => 'display:inline']
                                ) ?>

                                    <?= Html::submitButton(
                                        'Confirmar',
                                        [
                                            'class' => 'btn btn-sm btn-success',
                                            'data-confirm' =>
                                                '¿Confirmar esta reserva?',
                                        ]
                                    ) ?>

                                <?= Html::endForm() ?>

                            <?php endif; ?>

                            <?php if ($reserva->estado != 2): ?>

                                <?= Html::beginForm(
                                    ['cancelar', 'id' => $reserva->id],
                                    'post',
                                    ['style' => 'display:inline']
                                ) ?>

                                    <?= Html::submitButton(
                                        'Cancelar',
                                        [
                                            'class' => 'btn btn-sm btn-warning',
                                            'data-confirm' =>
                                                '¿Cancelar esta reserva?',
                                        ]
                                    ) ?>

                                <?= Html::endForm() ?>

                            <?php endif; ?>

                            <?= Html::beginForm(
                                ['delete', 'id' => $reserva->id],
                                'post',
                                ['style' => 'display:inline']
                            ) ?>

                                <?= Html::submitButton(
                                    'Eliminar',
                                    [
                                        'class' => 'btn btn-sm btn-danger',
                                        'data-confirm' =>
                                            '¿Eliminar definitivamente esta reserva?',
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