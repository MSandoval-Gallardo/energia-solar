<?php

use yii\helpers\Html;

$this->title = 'Fotografías';
?>

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1 class="mb-1">Fotografías</h1>

            <p class="text-muted mb-0">
                Administra las fotografías de la galería pública.
            </p>
        </div>

        <?= Html::a(
            '+ Agregar fotografía',
            ['create'],
            ['class' => 'btn btn-primary']
        ) ?>

    </div>

    <?php if (empty($fotografias)): ?>

        <div class="alert alert-info">
            No hay fotografías registradas todavía.
        </div>

    <?php else: ?>

        <div class="row g-4">

            <?php foreach ($fotografias as $fotografia): ?>

                <div class="col-md-6 col-lg-4">

                    <div class="card h-100 shadow-sm">
                        <?php if (!empty($fotografia->archivo)): ?>

                            <?= Html::img(
                                Yii::getAlias('@web/uploads/fotografias/' . $fotografia->archivo),
                                [
                                    'class' => 'card-img-top',
                                    'alt' => $fotografia->titulo,
                                    'style' => 'height: 220px; object-fit: cover;',
                                ]
                            ) ?>

                        <?php endif; ?>

                        <div class="card-body">

                            <h5 class="card-title">
                                <?= Html::encode($fotografia->titulo) ?>
                            </h5>

                            <?php if (!empty($fotografia->descripcion)): ?>

                                <p class="card-text text-muted">
                                    <?= Html::encode($fotografia->descripcion) ?>
                                </p>

                            <?php endif; ?>

                            <div class="mb-3">

                                <?php if ($fotografia->estado == 1): ?>

                                    <span class="badge bg-success">
                                        Visible
                                    </span>

                                <?php else: ?>

                                    <span class="badge bg-secondary">
                                        Oculta
                                    </span>

                                <?php endif; ?>

                            </div>

                            <div class="d-flex gap-2 flex-wrap">

                                <?= Html::a(
                                    'Editar',
                                    ['update', 'id' => $fotografia->id],
                                    ['class' => 'btn btn-sm btn-outline-primary']
                                ) ?>

                                <?= Html::a(
                                    $fotografia->estado == 1
                                        ? 'Ocultar'
                                        : 'Mostrar',
                                    ['toggle', 'id' => $fotografia->id],
                                    [
                                        'class' => 'btn btn-sm btn-outline-secondary',
                                        'data-method' => 'post',
                                    ]
                                ) ?>

                                <?= Html::a(
                                    'Eliminar',
                                    ['delete', 'id' => $fotografia->id],
                                    [
                                        'class' => 'btn btn-sm btn-outline-danger',
                                        'data-method' => 'post',
                                        'data-confirm' =>
                                            '¿Estás seguro de eliminar esta fotografía?',
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