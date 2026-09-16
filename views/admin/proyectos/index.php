<?php

use yii\helpers\Html;

/** @var app\models\Proyecto[] $proyectos */

$this->title = 'Proyectos';
?>

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1><?= Html::encode($this->title) ?></h1>
            <p class="text-muted mb-0">
                Administración de proyectos solares instalados.
            </p>
        </div>

        <?= Html::a(
            '＋ Nuevo proyecto',
            ['create'],
            ['class' => 'btn btn-primary']
        ) ?>
    </div>

    <?php if (Yii::$app->session->hasFlash('success')): ?>

        <div class="alert alert-success">
            <?= Yii::$app->session->getFlash('success') ?>
        </div>

    <?php endif; ?>

    <?php if (empty($proyectos)): ?>

        <div class="alert alert-info">
            No existen proyectos registrados todavía.
        </div>

    <?php else: ?>

        <div class="table-responsive">

            <table class="table table-bordered table-hover align-middle">

                <thead class="table-dark">
                    <tr>
                        <th width="70">ID</th>
                        <th width="100">Imagen</th>
                        <th>Título</th>
                        <th>Descripción</th>
                        <th width="80">Orden</th>
                        <th width="100">Estado</th>
                        <th width="230">Acciones</th>
                    </tr>
                </thead>

                <tbody>

                <?php foreach ($proyectos as $proyecto): ?>

                    <tr>

                        <td>
                            <?= Html::encode($proyecto->id) ?>
                        </td>

                        <td>

                            <?php if ($proyecto->imagen): ?>

                                <img
                                    src="<?= Yii::getAlias('@web/uploads/proyectos/' . $proyecto->imagen) ?>"
                                    alt="<?= Html::encode($proyecto->titulo) ?>"
                                    style="
                                        width:80px;
                                        height:60px;
                                        object-fit:cover;
                                        border-radius:6px;
                                    "
                                >

                            <?php else: ?>

                                <span class="text-muted">
                                    Sin imagen
                                </span>

                            <?php endif; ?>

                        </td>

                        <td>
                            <strong>
                                <?= Html::encode($proyecto->titulo) ?>
                            </strong>
                        </td>

                        <td>
                            <?= Html::encode($proyecto->descripcion) ?>
                        </td>

                        <td class="text-center">
                            <?= Html::encode($proyecto->orden) ?>
                        </td>

                        <td>

                            <?php if ($proyecto->estado == 1): ?>

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
                                'Editar',
                                ['update', 'id' => $proyecto->id],
                                ['class' => 'btn btn-sm btn-primary']
                            ) ?>

                            <?= Html::a(
                                $proyecto->estado == 1
                                    ? 'Desactivar'
                                    : 'Activar',
                                ['toggle', 'id' => $proyecto->id],
                                [
                                    'class' => 'btn btn-sm btn-warning',
                                    'data-method' => 'post',
                                    'data-confirm' =>
                                        '¿Quieres cambiar el estado de este proyecto?',
                                ]
                            ) ?>

                            <?= Html::a(
                                'Eliminar',
                                ['delete', 'id' => $proyecto->id],
                                [
                                    'class' => 'btn btn-sm btn-danger',
                                    'data-method' => 'post',
                                    'data-confirm' =>
                                        '¿Seguro que deseas eliminar este proyecto?',
                                ]
                            ) ?>

                        </td>

                    </tr>

                <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    <?php endif; ?>

</div>