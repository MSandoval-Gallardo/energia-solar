<?php

use yii\helpers\Html;

$this->title = 'Panel de Administración';
?>

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="mb-1">Panel de Administración</h1>

            <p class="text-muted mb-0">
                Gestión del sitio Energía Solar
            </p>
        </div>

        <div>
            <?= Html::a(
                'Cerrar sesión',
                ['/site/logout'],
                [
                    'class' => 'btn btn-outline-danger',
                    'data-method' => 'post',
                ]
            ) ?>
        </div>
    </div>

    <div class="row g-4">

        <!-- Fotografías -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h3 class="card-title">📷 Fotografías</h3>

                    <p class="card-text text-muted">
                        Administra las fotografías que aparecen
                        en la galería del sitio.
                    </p>

                    <?= Html::a(
                        'Administrar fotografías',
                        ['/admin/fotografias'],
                        ['class' => 'btn btn-primary']
                    ) ?>
                </div>
            </div>
        </div>

        <!-- Videos -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h3 class="card-title">🎬 Videos</h3>

                    <p class="card-text text-muted">
                        Agrega y administra videos del sitio.
                    </p>

                    <?= Html::a(
                        'Administrar videos',
                        ['/admin/videos'],
                        ['class' => 'btn btn-primary']
                    ) ?>
                </div>
            </div>
        </div>

        <!-- Proyectos -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h3 class="card-title">🏗️ Proyectos</h3>

                    <p class="card-text text-muted">
                        Gestiona los proyectos de energía solar.
                    </p>

                    <?= Html::a(
                        'Administrar proyectos',
                        ['/admin/proyectos'],
                        ['class' => 'btn btn-primary']
                    ) ?>
                </div>
            </div>
        </div>

        <!-- Reservas -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h3 class="card-title">📅 Reservas</h3>

                    <p class="card-text text-muted">
                        Consulta y administra las reservas
                        realizadas por los clientes.
                    </p>

                    <?= Html::a(
                        'Ver reservas',
                        ['/admin/reservas'],
                        ['class' => 'btn btn-primary']
                    ) ?>
                </div>
            </div>
        </div>

        <!-- Pagos -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h3 class="card-title">💳 Pagos</h3>

                    <p class="card-text text-muted">
                        Consulta el estado de los pagos y
                        transacciones.
                    </p>

                    <?= Html::a(
                        'Ver pagos',
                        ['/admin/pagos'],
                        ['class' => 'btn btn-primary']
                    ) ?>
                </div>
            </div>
        </div>

        <!-- Usuarios -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h3 class="card-title">👤 Administradores</h3>

                    <p class="card-text text-muted">
                        Gestiona las cuentas de administradores
                        del sistema.
                    </p>

                    <?= Html::a(
                        'Administrar usuarios',
                        ['/admin/usuarios'],
                        ['class' => 'btn btn-primary']
                    ) ?>
                </div>
            </div>
        </div>

    </div>

</div>