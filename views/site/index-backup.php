<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Fotografia[] $fotografias */
/** @var app\models\Video[] $videos */

$this->title = 'Allan Mariscal · Energía Solar con Garantía';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= Html::encode($this->title) ?></title>

    <meta
        name="description"
        content="Energía Solar con Garantía. Soluciones solares para hogares y empresas."
    >

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            color: #222;
            background: #fff;
            line-height: 1.6;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        img {
            max-width: 100%;
            display: block;
        }

        .container {
            width: min(1200px, 92%);
            margin: 0 auto;
        }

        /* =========================
           HEADER
        ========================= */

        header {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,.08);
        }

        .nav-container {
            min-height: 75px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 30px;
        }

        .logo {
            font-size: 1.35rem;
            font-weight: 800;
            color: #222;
        }

        .logo span {
            color: #f5a400;
        }

        nav ul {
            list-style: none;
            display: flex;
            align-items: center;
            gap: 25px;
        }

        nav a {
            font-weight: 600;
            color: #333;
            transition: .3s;
        }

        nav a:hover {
            color: #f5a400;
        }

        .btn {
            display: inline-block;
            padding: 12px 22px;
            border-radius: 8px;
            background: #f5a400;
            color: #fff;
            font-weight: 700;
            transition: .3s;
        }

        .btn:hover {
            background: #d98f00;
            transform: translateY(-2px);
        }

        /* =========================
           HERO
        ========================= */

        .hero {
            min-height: 600px;
            display: flex;
            align-items: center;
            background:
                linear-gradient(
                    rgba(0,0,0,.55),
                    rgba(0,0,0,.55)
                ),
                url('<?= Yii::getAlias('@web/images/hero.jpg') ?>')
                center/cover no-repeat;
            color: #fff;
        }

        .hero-content {
            max-width: 700px;
            padding: 80px 0;
        }

        .hero h1 {
            font-size: clamp(2.4rem, 5vw, 4.5rem);
            line-height: 1.1;
            margin-bottom: 25px;
        }

        .hero p {
            font-size: 1.2rem;
            margin-bottom: 30px;
        }

        /* =========================
           SECCIONES
        ========================= */

        section {
            padding: 80px 0;
        }

        .section-title {
            text-align: center;
            margin-bottom: 50px;
        }

        .section-title h2 {
            font-size: 2.3rem;
            margin-bottom: 12px;
        }

        .section-title p {
            color: #666;
        }

        /* =========================
           GARANTÍAS
        ========================= */

        .guarantees-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
        }

        .guarantee-card {
            padding: 30px;
            text-align: center;
            border-radius: 14px;
            background: #f7f7f7;
        }

        .guarantee-card i {
            font-size: 2.5rem;
            color: #f5a400;
            margin-bottom: 20px;
        }

        .guarantee-card h3 {
            margin-bottom: 10px;
        }

        /* =========================
           GALERÍA
        ========================= */

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
        }

        .gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: 12px;
            cursor: pointer;
            background: #eee;
            aspect-ratio: 1 / 1;
        }

        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .4s ease;
        }

        .gallery-item:hover img {
            transform: scale(1.08);
        }

        .gallery-overlay {
            position: absolute;
            inset: auto 0 0 0;
            padding: 15px;
            color: #fff;
            background: linear-gradient(
                transparent,
                rgba(0,0,0,.8)
            );
        }

        /* =========================
           VIDEOS
        ========================= */

        .videos-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
        }

        .video-card {
            overflow: hidden;
            border-radius: 14px;
            background: #f7f7f7;
            box-shadow: 0 5px 20px rgba(0,0,0,.08);
        }

        .video-container {
            position: relative;
            width: 100%;
            aspect-ratio: 16 / 9;
            background: #111;
        }

        .video-container iframe {
            width: 100%;
            height: 100%;
            border: 0;
        }

        .video-info {
            padding: 20px;
        }

        .video-info h3 {
            margin-bottom: 8px;
        }

        .video-info p {
            color: #666;
        }

        /* =========================
           FOOTER
        ========================= */

        footer {
            padding: 40px 0;
            background: #222;
            color: #fff;
            text-align: center;
        }

        /* =========================
           WHATSAPP
        ========================= */

        .whatsapp-float {
            position: fixed;
            right: 25px;
            bottom: 25px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #25d366;
            color: #fff;
            font-size: 30px;
            z-index: 999;
            box-shadow: 0 5px 15px rgba(0,0,0,.25);
        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 900px) {
            .gallery-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .videos-grid,
            .guarantees-grid {
                grid-template-columns: 1fr;
            }

            nav ul {
                gap: 12px;
                flex-wrap: wrap;
                justify-content: flex-end;
            }
        }

        @media (max-width: 600px) {
            .nav-container {
                flex-direction: column;
                padding: 15px 0;
            }

            nav ul {
                justify-content: center;
            }

            .hero {
                min-height: 500px;
            }
        }
    </style>
</head>

<body>

<header>
    <div class="container nav-container">

        <div class="logo">
            Allan Mariscal <span>· Energía Solar</span>
        </div>

        <nav>
            <ul>
                <li><a href="#inicio">Inicio</a></li>
                <li><a href="#galeria">Galería</a></li>
                <li><a href="#videos">Videos</a></li>
                <li><a href="#garantias">Garantías</a></li>
                <li>
                    <a href="#contacto" class="btn">
                        Contacto
                    </a>
                </li>
            </ul>
        </nav>

    </div>
</header>

<main>

    <!-- HERO -->
    <section class="hero" id="inicio">
        <div class="container">
            <div class="hero-content">

                <h1>
                    Energía Solar<br>
                    con Garantía
                </h1>

                <p>
                    Soluciones de energía solar para hogares y empresas.
                </p>

                <a href="#contacto" class="btn">
                    Solicitar asesoría
                </a>

            </div>
        </div>
    </section>

    <!-- GARANTÍAS -->
    <section id="garantias">
        <div class="container">

            <div class="section-title">
                <h2>¿Por qué elegirnos?</h2>
                <p>Soluciones pensadas para tu proyecto.</p>
            </div>

            <div class="guarantees-grid">

                <div class="guarantee-card">
                    <i class="fa-solid fa-solar-panel"></i>
                    <h3>Calidad</h3>
                    <p>
                        Equipamiento y soluciones adaptadas
                        a cada proyecto.
                    </p>
                </div>

                <div class="guarantee-card">
                    <i class="fa-solid fa-shield-halved"></i>
                    <h3>Garantía</h3>
                    <p>
                        Acompañamiento y respaldo durante
                        todo el proyecto.
                    </p>
                </div>

                <div class="guarantee-card">
                    <i class="fa-solid fa-headset"></i>
                    <h3>Asesoría</h3>
                    <p>
                        Te ayudamos a encontrar la solución
                        adecuada.
                    </p>
                </div>

            </div>

        </div>
    </section>

    <!-- GALERÍA -->
    <section id="galeria">
        <div class="container">

            <div class="section-title">
                <h2>Galería</h2>
                <p>
                    Conoce algunos de nuestros trabajos.
                </p>
            </div>

            <div class="gallery-grid">

                <?php if (!empty($fotografias)): ?>

                    <?php foreach ($fotografias as $fotografia): ?>

                        <div class="gallery-item">

                            <img
                                src="<?= Html::encode(
                                    Yii::getAlias(
                                        '@web/uploads/fotografias/'
                                        . $fotografia->archivo
                                    )
                                ) ?>"
                                alt="<?= Html::encode(
                                    $fotografia->titulo
                                ) ?>"
                                loading="lazy"
                            >

                            <div class="gallery-overlay">
                                <?= Html::encode(
                                    $fotografia->titulo
                                ) ?>
                            </div>

                        </div>

                    <?php endforeach; ?>

                <?php else: ?>

                    <p>
                        Actualmente no hay fotografías disponibles.
                    </p>

                <?php endif; ?>

            </div>

        </div>
    </section>

    <!-- VIDEOS -->
    <section id="videos">
        <div class="container">

            <div class="section-title">
                <h2>Videos</h2>
                <p>
                    Conoce más sobre nuestros proyectos.
                </p>
            </div>

            <?php if (!empty($videos)): ?>

                <div class="videos-grid">

                    <?php foreach ($videos as $video): ?>

                        <article class="video-card">

                            <div class="video-container">

                                <iframe
                                    src="<?= Html::encode($video->url) ?>"
                                    title="<?= Html::encode($video->titulo) ?>"
                                    loading="lazy"
                                    allowfullscreen>
                                </iframe>

                            </div>

                            <div class="video-info">

                                <h3>
                                    <?= Html::encode($video->titulo) ?>
                                </h3>

                                <?php if (!empty($video->descripcion)): ?>
                                    <p>
                                        <?= Html::encode(
                                            $video->descripcion
                                        ) ?>
                                    </p>
                                <?php endif; ?>

                            </div>

                        </article>

                    <?php endforeach; ?>

                </div>

            <?php else: ?>

                <p style="text-align:center;">
                    Actualmente no hay videos disponibles.
                </p>

            <?php endif; ?>

        </div>
    </section>

    <!-- CONTACTO -->
    <section id="contacto">
        <div class="container">

            <div class="section-title">
                <h2>Contacto</h2>
                <p>
                    ¿Tienes un proyecto? Conversemos.
                </p>
            </div>

            <div style="text-align:center;">
                <a href="mailto:<?= Html::encode(
                    Yii::$app->params['adminEmail']
                ) ?>" class="btn">
                    Contactarnos
                </a>
            </div>

        </div>
    </section>

</main>

<footer>
    <div class="container">
        <p>
            &copy; <?= date('Y') ?>
            Allan Mariscal · Energía Solar con Garantía
        </p>
    </div>
</footer>

<a
    href="https://wa.me/"
    class="whatsapp-float"
    target="_blank"
    rel="noopener noreferrer"
    aria-label="WhatsApp"
>
    <i class="fa-brands fa-whatsapp"></i>
</a>

</body>
</html>