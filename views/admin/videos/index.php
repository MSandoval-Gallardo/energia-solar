<?php

use yii\helpers\Html;

/** @var app\models\Video[] $videos */

$this->title = 'Administrar Videos';
?>

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><?= Html::encode($this->title) ?></h1>

        <?= Html::a(
            '➕ Nuevo video',
            ['create'],
            ['class' => 'btn btn-primary']
        ) ?>
    </div>

    <?php if (empty($videos)): ?>

        <div class="alert alert-info">
            No hay videos registrados todavía.
        </div>

    <?php else: ?>

        <div class="row">

            <?php foreach ($videos as $video): ?>

                <div class="col-md-6 col-lg-4 mb-4">

                    <div class="card h-100 shadow-sm">

                        <div class="card-body">

                            <h5 class="card-title">
                                <?= Html::encode($video->titulo) ?>
                            </h5>

                            <?php if (!empty($video->descripcion)): ?>
                                <p class="card-text">
                                    <?= Html::encode($video->descripcion) ?>
                                </p>
                            <?php endif; ?>

                            <p class="mb-2">
                                <strong>URL:</strong><br>

                                <?= Html::a(
                                    Html::encode($video->url),
                                    $video->url,
                                    [
                                        'target' => '_blank',
                                        'rel' => 'noopener noreferrer',
                                    ]
                                ) ?>
                            </p>

                            <p class="mb-2">
                                <strong>Orden:</strong>
                                <?= Html::encode($video->orden) ?>
                            </p>

                            <?php if ($video->estado == 1): ?>

                                <span class="badge bg-success">
                                    Activo
                                </span>

                            <?php else: ?>

                                <span class="badge bg-secondary">
                                    Inactivo
                                </span>

                            <?php endif; ?>

                        </div>

                        <div class="card-footer bg-white">

                            <div class="d-flex gap-2 flex-wrap">

                                <?= Html::a(
                                    '✏️ Editar',
                                    ['update', 'id' => $video->id],
                                    ['class' => 'btn btn-sm btn-warning']
                                ) ?>

                                <?= Html::a(
                                    $video->estado == 1
                                        ? '🚫 Desactivar'
                                        : '✅ Activar',
                                    ['toggle', 'id' => $video->id],
                                    [
                                        'class' => 'btn btn-sm btn-secondary',
                                        'data-method' => 'post',
                                    ]
                                ) ?>

                                <?= Html::a(
                                    '🗑️ Eliminar',
                                    ['delete', 'id' => $video->id],
                                    [
                                        'class' => 'btn btn-sm btn-danger',
                                        'data-method' => 'post',
                                        'data-confirm' => '¿Seguro que deseas eliminar este video?',
                                    ]
                                ) ?>

                            </div>

                        </div>

                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    <?php endif; ?>

</div>