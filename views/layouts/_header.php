<?php

declare(strict_types=1);

/** @var yii\web\View $this */

use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\helpers\Html;

$items = [
    [
        'label' => 'Proyectos',
        'url' => ['/site/index'],
    ],
    [
        'label' => 'Cómo funciona',
        'url' => ['/site/about'],
    ],
    [
        'label' => 'Garantias',
        'url' => ['/site/contact'],
    ],
    [
        'label' => 'Galeria',
        'url' => ['/site/contact'],
    ],
    [
        'label' => 'Asesoría',
        'url' => ['/site/contact'],
    ],
    [
        'label' => 'Login',
        'url' => ['/site/login'],
        'visible' => Yii::$app->user->isGuest,
    ],
    [
        'label' => 'Logout (' . Html::encode(Yii::$app->user->identity?->username ?? '') . ')',
        'url' => ['/site/logout'],
        'linkOptions' => [
            'data-method' => 'post',
            'class' => 'nav-link logout',
        ],
        'visible' => !Yii::$app->user->isGuest,
    ],
];

?>

