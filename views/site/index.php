<?php

use yii\helpers\Html;
use yii\helpers\Json;

/** @var yii\web\View $this */
/** @var app\models\Fotografia[] $fotografias */
/** @var app\models\Video[] $videos */

$this->title = 'Alfima · Energía Solar con Garantía';

$galleryImages = [];
foreach ($fotografias as $fotografia) {
    $galleryImages[] = [
        'src' => Yii::getAlias('@web/uploads/fotografias/' . $fotografia->archivo),
        'caption' => $fotografia->titulo,
        'description' => $fotografia->descripcion,
    ];
}

function youtubeEmbedUrl(string $url): ?string
{
    $parts = parse_url(trim($url));
    if (!$parts || empty($parts['host'])) {
        return null;
    }

    $host = strtolower($parts['host']);
    $host = preg_replace('/^www\\./', '', $host);

    if ($host === 'youtube.com' || $host === 'm.youtube.com') {
        if (!empty($parts['path']) && str_starts_with($parts['path'], '/embed/')) {
            $id = substr($parts['path'], 7);
        } elseif (!empty($parts['query'])) {
            parse_str($parts['query'], $query);
            $id = $query['v'] ?? '';
        } else {
            $id = '';
        }
    } elseif ($host === 'youtu.be') {
        $id = trim($parts['path'] ?? '', '/');
    } else {
        return null;
    }

    $id = preg_replace('/[^A-Za-z0-9_-]/', '', (string)$id);

    return strlen($id) === 11
        ? 'https://www.youtube.com/embed/' . $id
        : null;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Alfima · Energía Solar con Garantía</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    <style>
        /* ===== RESET & BASE ===== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        html {
            scroll-behavior: smooth;
        }
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background: #f8fafc;
            color: #0b1a2e;
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
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }

        /* ===== TOPBAR ===== */
        .topbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.06);
            padding: 0 24px;
            height: 72px;
            display: flex;
            align-items: center;
        }
        .topbar .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            padding: 0;
        }
        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 800;
            font-size: 1.2rem;
            color: #0b2b44;
        }
        .brand-mark {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: linear-gradient(135deg, #10a978, #e5ad32);
            display: grid;
            place-items: center;
            color: #fff;
            font-size: 1.1rem;
        }
        .nav-links {
            display: none;
            gap: 28px;
            font-weight: 600;
            font-size: 0.95rem;
            color: #1e3a5f;
        }
        .nav-links a:hover {
            color: #10a978;
        }
        .btn-nav {
            display: none;
            background: #10a978;
            color: #fff;
            padding: 10px 22px;
            border-radius: 30px;
            font-weight: 700;
            font-size: 0.9rem;
            transition: 0.2s;
        }
        .btn-nav:hover {
            background: #0d8f64;
            transform: translateY(-2px);
        }

        /* ===== HERO ===== */
        .hero {
            padding: 140px 0 80px;
            background: radial-gradient(ellipse at 80% 20%, rgba(16, 169, 120, 0.12), transparent 50%),
                linear-gradient(145deg, #f0f7fa 0%, #ffffff 100%);
        }
        .hero-grid {
            /* display: grid; */
            gap: 48px;
            align-items: center;
        }
        .hero-content h1 {
            font-size: clamp(2.4rem, 7vw, 4.2rem);
            line-height: 1.05;
            color: #0b2b44;
            margin-bottom: 16px;
            font-weight: 800;
            letter-spacing: -0.02em;
        }
        .hero-content p {
            font-size: 1.2rem;
            color: #2d4a6a;
            max-width: 600px;
            margin-bottom: 28px;
        }
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #e6f7f0;
            border: 1px solid rgba(16, 169, 120, 0.25);
            border-radius: 40px;
            padding: 8px 16px;
            font-weight: 700;
            font-size: 0.85rem;
            color: #0d8f64;
            margin-bottom: 20px;
        }
        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 14px 28px;
            border-radius: 40px;
            font-weight: 700;
            font-size: 1rem;
            border: none;
            cursor: pointer;
            transition: 0.25s ease;
        }
        .btn-primary {
            background: #10a978;
            color: #fff;
            box-shadow: 0 8px 24px rgba(16, 169, 120, 0.35);
        }
        .btn-primary:hover {
            background: #0d8f64;
            transform: translateY(-3px);
            box-shadow: 0 12px 32px rgba(16, 169, 120, 0.4);
        }
        .btn-outline {
            background: transparent;
            color: #0b2b44;
            border: 2px solid #d0dce8;
        }
        .btn-outline:hover {
            border-color: #10a978;
            color: #10a978;
            transform: translateY(-3px);
        }
        .btn-whatsapp {
            background: #25d366;
            color: #fff;
            box-shadow: 0 8px 24px rgba(37, 211, 102, 0.35);
        }
        .btn-whatsapp:hover {
            background: #1ebe5c;
            transform: translateY(-3px);
        }

        .hero-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-top: 32px;
        }
        .hero-stats .stat {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(4px);
            padding: 16px 12px;
            border-radius: 12px;
            border: 1px solid rgba(0, 0, 0, 0.06);
            text-align: center;
            font-weight: 700;
            font-size: 0.9rem;
            color: #1e3a5f;
        }

        /* ===== SECCIONES ===== */
        .section {
            padding: 35px 0;
        }
        .section-alt {
            background: #f8fafc;
        }
        .section-header {
            max-width: 700px;
            margin-bottom: 48px;
        }
        .section-header .tag {
            display: inline-block;
            background: #e6f7f0;
            color: #0d8f64;
            font-weight: 700;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            padding: 6px 14px;
            border-radius: 20px;
            margin-bottom: 12px;
        }
        .section-header h2 {
            font-size: clamp(2rem, 4vw, 2.8rem);
            font-weight: 800;
            color: #0b2b44;
            line-height: 1.1;
        }
        .section-header p {
            color: #4a6580;
            font-size: 1.05rem;
            margin-top: 8px;
        }

        /* ===== GARANTÍAS ===== */
        .grid-3 {
            display: grid;
            gap: 24px;
        }
        .card {
            background: #fff;
            border-radius: 16px;
            padding: 32px 24px;
            border: 1px solid rgba(0, 0, 0, 0.06);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
            transition: 0.3s;
        }
        .card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.08);
        }
        .card .icon {
            width: 52px;
            height: 52px;
            border-radius: 12px;
            display: grid;
            place-items: center;
            font-size: 1.4rem;
            font-weight: 800;
            color: #fff;
            margin-bottom: 16px;
        }
        .card .icon.green {
            background: #10a978;
        }
        .card .icon.gold {
            background: #e5ad32;
        }
        .card .icon.blue {
            background: #1a4a7a;
        }
        .card h3 {
            font-size: 1.15rem;
            margin-bottom: 6px;
            color: #0b2b44;
        }
        .card p {
            color: #4a6580;
            font-size: 0.95rem;
        }

        /* ===== PLANES / PRECIOS ===== */
        .pricing-grid {
            display: grid;
            gap: 24px;
            margin-top: 16px;
        }
        .pricing-card {
            background: #fff;
            border-radius: 20px;
            padding: 32px 24px;
            border: 1px solid rgba(0, 0, 0, 0.06);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
            text-align: center;
            transition: 0.3s;
            position: relative;
        }
        .pricing-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.08);
        }
        .pricing-card.popular {
            border-color: #10a978;
            background: #fafffd;
        }
        .pricing-card .badge {
            position: absolute;
            top: -12px;
            left: 50%;
            transform: translateX(-50%);
            background: #10a978;
            color: #fff;
            font-size: 0.7rem;
            font-weight: 700;
            padding: 4px 18px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }
        .pricing-card .price {
            font-size: 2.4rem;
            font-weight: 800;
            color: #0b2b44;
            margin: 12px 0 4px;
        }
        .pricing-card .price span {
            font-size: 1rem;
            font-weight: 400;
            color: #4a6580;
        }
        .pricing-card .desc {
            color: #4a6580;
            font-size: 0.95rem;
            margin-bottom: 20px;
        }
        .pricing-card ul {
            list-style: none;
            text-align: left;
            margin: 16px 0 24px;
        }
        .pricing-card ul li {
            padding: 6px 0;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.9rem;
            color: #1e3a5f;
        }
        .pricing-card ul li i {
            color: #10a978;
            font-size: 0.8rem;
        }

        /* ===== FORMULARIO DE PAGO ===== */
        .payment-section {
            background: #fff;
            border-radius: 24px;
            padding: 48px 40px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.06);
            border: 1px solid rgba(0, 0, 0, 0.04);
            max-width: 640px;
            margin: 0 auto;
        }
        .payment-section h3 {
            font-size: 1.6rem;
            font-weight: 800;
            color: #0b2b44;
            text-align: center;
        }
        .payment-section .sub {
            text-align: center;
            color: #4a6580;
            margin-bottom: 32px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            font-weight: 600;
            font-size: 0.9rem;
            color: #1e3a5f;
            margin-bottom: 4px;
        }
        .form-group input,
        .form-group select {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 1rem;
            color:#1a1919;
            transition: 0.2s;
            background: #fff;
        }
        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #10a978;
            box-shadow: 0 0 0 4px rgba(16, 169, 120, 0.12);
        }
        .form-row {
            display: grid;
            gap: 16px;
        }
        .payment-summary {
            background: #f8fafc;
            border-radius: 12px;
            padding: 20px 24px;
            margin: 24px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }
        .payment-summary .label {
            color: #4a6580;
            font-weight: 600;
        }
        .payment-summary .amount {
            font-size: 1.6rem;
            font-weight: 800;
            color: #0b2b44;
        }
        .payment-summary .amount small {
            font-size: 0.9rem;
            font-weight: 400;
            color: #4a6580;
        }
        .btn-pay {
            width: 100%;
            padding: 16px;
            background: #0b2b44;
            color: #fff;
            border: none;
            border-radius: 14px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: 0.25s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .btn-pay:hover {
            background: #1a3a5a;
            transform: translateY(-2px);
        }
        .btn-pay i {
            font-size: 1.2rem;
        }
        .payment-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 0.85rem;
            color: #7a8fa5;
        }
        .payment-footer i {
            color: #10a978;
        }
        .payment-footer .lock {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #f1f4f8;
            padding: 4px 14px;
            border-radius: 20px;
            font-size: 0.75rem;
            color: #2d4a6a;
        }

        /* ===== VIDEOS ===== */
        .videos-grid {
            display: grid;
            gap: 24px;
        }
        .video-card {
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid rgba(0, 0, 0, 0.06);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
            transition: 0.3s;
        }
        .video-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.08);
        }
        .video-frame {
            position: relative;
            aspect-ratio: 16 / 9;
            background: #0b1a2e;
        }
        .video-frame iframe {
            width: 100%;
            height: 100%;
            border: 0;
            display: block;
        }
        .video-info {
            padding: 20px 22px 24px;
        }
        .video-info h3 {
            color: #0b2b44;
            margin-bottom: 6px;
        }
        .video-info p {
            color: #4a6580;
            font-size: 0.95rem;
        }

        /* ===== FOOTER ===== */
        .footer {
            background: #0b1a2e;
            color: rgba(255, 255, 255, 0.8);
            padding: 48px 0 32px;
        }
        .footer-grid {
            display: grid;
            gap: 32px;
        }
        .footer h3 {
            color: #fff;
            font-size: 1rem;
            margin-bottom: 12px;
        }
        .footer p {
            font-size: 0.9rem;
            line-height: 1.7;
        }
        .footer .socials {
            display: flex;
            gap: 12px;
        }
        .footer .socials a {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.12);
            display: grid;
            place-items: center;
            color: #fff;
            transition: 0.2s;
        }
        .footer .socials a:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 255, 255, 0.3);
        }
        .footer .brand-footer {
            font-weight: 800;
            color: #fff;
            font-size: 1.1rem;
        }

        /* ===== WHATSAPP FAB ===== */
        .fab-whatsapp {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 999;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: #25d366;
            color: #fdfbfb;
            display: grid;
            place-items: center;
            font-size: 1.6rem;
            box-shadow: 0 8px 28px rgba(37, 211, 102, 0.4);
            transition: 0.25s;
        }
        .fab-whatsapp:hover {
            transform: scale(1.08);
        }

        /* ===== REVEAL ===== */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }
        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* ===== RESPONSIVE ===== */
        @media (min-width: 768px) {
            .nav-links {
                display: flex;
            }
            .btn-nav {
                display: inline-flex;
            }
            .hero-grid {
                grid-template-columns: 1fr 1fr;
            }
            .grid-3 {
                grid-template-columns: repeat(3, 1fr);
            }
            .pricing-grid {
                grid-template-columns: repeat(3, 1fr);
            }
            .videos-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .form-row {
                grid-template-columns: 1fr 1fr;
            }
            .footer-grid {
                grid-template-columns: 2fr 1fr 1fr;
            }
        }
        @media (max-width: 480px) {
            .hero-stats {
                grid-template-columns: 1fr;
            }
            .payment-section {
                padding: 28px 18px;
            }
            .btn {
                width: 100%;
                justify-content: center;
            }
            .hero-actions {
                flex-direction: column;
            }
        }
        .hero {
            /* Imagen de fondo */
            background-image: 
                /* Degradado oscuro para legibilidad */
                linear-gradient(rgba(0, 0, 0, 0.55), rgba(0, 0, 0, 0.70)),
                /* Tu imagen */
                url('<?= Yii::getAlias('@web/images/hero.jpeg') ?>');
            
            background-size: cover;
            background-position: center;
            background-attachment: fixed; /* efecto parallax opcional */
            
            padding: 160px 0 100px;
            color: #fff; /* texto blanco para contraste */
        }

        /* Ajuste de colores para que el texto sea legible */
        .hero h1 {
            color: #fff;
        }

        .hero p {
            color: rgba(255,255,255,0.9);
        }

        .hero .hero-badge {
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,0.2);
            color: #fff;
        }
        .contact-form-wrapper {
            max-width: 640px;
            margin: 0 auto;
            background: #fff;
            border-radius: 24px;
            padding: 40px 36px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.06);
            border: 1px solid rgba(0, 0, 0, 0.04);
        }

        .contact-form textarea {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 1rem;
            font-family: inherit;
            resize: vertical;
            transition: 0.2s;
            background: #fff;
        }

        .contact-form textarea:focus {
            outline: none;
            border-color: #10a978;
            box-shadow: 0 0 0 4px rgba(16, 169, 120, 0.12);
        }
        /* ===== MENU HAMBURGUESA ===== */
.menu-toggle {
    display: none;
    flex-direction: column;
    gap: 5px;
    background: none;
    border: none;
    cursor: pointer;
    padding: 8px 4px;
    z-index: 1001;
}

.menu-toggle .bar {
    display: block;
    width: 28px;
    height: 3px;
    background: #0b2b44;
    border-radius: 4px;
    transition: 0.3s ease;
}

/* Animación para convertir las 3 líneas en una "X" */
.menu-toggle.active .bar:nth-child(1) {
    transform: rotate(45deg) translate(5px, 6px);
}
.menu-toggle.active .bar:nth-child(2) {
    opacity: 0;
}
.menu-toggle.active .bar:nth-child(3) {
    transform: rotate(-45deg) translate(5px, -6px);
}

/* ===== NAV LINKS ===== */
.nav-links {
    display: flex;
    align-items: center;
    gap: 28px;
    font-weight: 600;
    font-size: 0.95rem;
    color: #1e3a5f;
    transition: 0.3s ease;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    .menu-toggle {
        display: flex;
    }

    .nav-links {
        position: fixed;
        top: 0;
        right: -100%;
        width: 280px;
        height: 100vh;
        background: #ffffff;
        flex-direction: column;
        justify-content: center;
        padding: 80px 32px 40px;
        gap: 20px;
        box-shadow: -8px 0 40px rgba(0, 0, 0, 0.1);
        transition: right 0.35s ease;
        font-size: 1.1rem;
        z-index: 1000;
    }

    .nav-links.open {
        right: 0;
    }

    .nav-links a {
        padding: 10px 0;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        width: 100%;
    }

    .nav-links .btn-nav {
        display: inline-flex;
        width: 100%;
        justify-content: center;
        margin-top: 8px;
    }

    /* Overlay oscuro detrás del menú */
    .nav-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.4);
        z-index: 999;
    }

    .nav-overlay.active {
        display: block;
    }
}
/* ===== GALERÍA ===== */
.gallery-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    grid-auto-rows: 220px;
    gap: 16px;
}

.gallery-item {
    position: relative;
    border-radius: 16px;
    overflow: hidden;
    cursor: pointer;
    transition: 0.3s ease;
}

.gallery-item:hover {
    transform: scale(1.02);
    box-shadow: 0 12px 32px rgba(0, 0, 0, 0.15);
}

.gallery-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: 0.5s ease;
}

.gallery-item:hover img {
    transform: scale(1.08);
}

.gallery-item .overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(transparent 40%, rgba(0, 0, 0, 0.7));
    display: flex;
    align-items: flex-end;
    padding: 20px;
    opacity: 0;
    transition: 0.3s ease;
}

.gallery-item:hover .overlay {
    opacity: 1;
}

.gallery-item .overlay span {
    color: #fff;
    font-weight: 600;
    font-size: 0.9rem;
    text-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
}

/* Tamaños especiales para destacar imágenes */
.gallery-item:nth-child(1) {
    grid-column: span 2;
    grid-row: span 2;
}

.gallery-item:nth-child(4) {
    grid-column: span 2;
}

.gallery-item:nth-child(7) {
    grid-row: span 2;
}

/* ===== MODAL / LIGHTBOX ===== */
.gallery-modal {
    display: none;
    position: fixed;
    inset: 0;
    z-index: 2000;
    background: rgba(0, 0, 0, 0.92);
    justify-content: center;
    align-items: center;
    padding: 40px;
}

.gallery-modal.active {
    display: flex;
}

.gallery-modal .modal-image {
    max-width: 90vw;
    max-height: 80vh;
    border-radius: 12px;
    object-fit: contain;
    animation: modalFade 0.3s ease;
}

@keyframes modalFade {
    from {
        opacity: 0;
        transform: scale(0.95);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

.gallery-modal .modal-caption {
    position: absolute;
    bottom: 60px;
    left: 50%;
    transform: translateX(-50%);
    color: #fff;
    font-weight: 600;
    font-size: 1.1rem;
    background: rgba(0, 0, 0, 0.5);
    padding: 8px 24px;
    border-radius: 30px;
    backdrop-filter: blur(8px);
}

.gallery-modal .modal-close {
    position: absolute;
    top: 24px;
    right: 32px;
    background: none;
    border: none;
    color: #fff;
    font-size: 2.2rem;
    cursor: pointer;
    transition: 0.2s;
    padding: 8px;
}

.gallery-modal .modal-close:hover {
    transform: rotate(90deg);
    color: #10a978;
}

.gallery-modal .modal-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(255, 255, 255, 0.1);
    border: none;
    color: #fff;
    width: 56px;
    height: 56px;
    border-radius: 50%;
    font-size: 1.5rem;
    cursor: pointer;
    transition: 0.2s;
    backdrop-filter: blur(4px);
}

.gallery-modal .modal-nav:hover {
    background: rgba(255, 255, 255, 0.2);
}

.gallery-modal .modal-prev {
    left: 24px;
}

.gallery-modal .modal-next {
    right: 24px;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    .gallery-grid {
        grid-template-columns: repeat(2, 1fr);
        grid-auto-rows: 180px;
        gap: 12px;
    }

    .gallery-item:nth-child(1) {
        grid-column: span 2;
        grid-row: span 1;
    }

    .gallery-item:nth-child(4) {
        grid-column: span 2;
    }

    .gallery-item:nth-child(7) {
        grid-row: span 1;
    }

    .gallery-modal {
        padding: 16px;
    }

    .gallery-modal .modal-image {
        max-width: 100vw;
        max-height: 70vh;
    }

    .gallery-modal .modal-nav {
        width: 40px;
        height: 40px;
        font-size: 1rem;
    }

    .gallery-modal .modal-prev {
        left: 8px;
    }

    .gallery-modal .modal-next {
        right: 8px;
    }

    .gallery-modal .modal-close {
        top: 12px;
        right: 16px;
        font-size: 1.6rem;
    }

    .gallery-modal .modal-caption {
        bottom: 40px;
        font-size: 0.9rem;
        padding: 6px 16px;
    }
}

@media (max-width: 480px) {
    .gallery-grid {
        grid-template-columns: 1fr 1fr;
        grid-auto-rows: 140px;
        gap: 8px;
    }
}
    </style>
</head>
<body>

    <!-- ===== TOPBAR ===== -->
    <header class="topbar">
    <div class="container">
        <a class="brand" href="#inicio" style="display: flex; align-items: center; gap: 10px;">
            <img src="<?= Yii::getAlias('@web/images/logo4.png') ?>" alt="Alfima Logo" style="height: 45px; width: auto;" />
            <span style="font-weight: 800; font-size: 1.2rem; color: #0b2b44;">Energía renovable</span>
        </a>

        <!-- Botón hamburguesa (visible solo en móvil) -->
        <button class="menu-toggle" id="menuToggle" aria-label="Abrir menú">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </button>

        <nav class="nav-links" id="navLinks">
            <a href="#garantias">Garantías</a>
            <a href="#galeria">Galeria</a>
            <a href="#videos">Videos</a>
            <a href="#proyectos">Proyectos</a>
            <a href="#funciona">Cómo funciona</a>
            
            
            
            <a href="#asesoria">Asesoría</a>
            <a class="btn-nav" href="#pago">Reservar ahora</a>
        </nav>
    </div>
</header>

    <!-- ===== HERO ===== -->
    <section class="hero" id="inicio">
        <div class="container hero-grid">
            <div class="hero-content reveal">
                <div class="hero-badge">
                    <i class="fa-solid fa-shield-check"></i>
                    Energía solar con respaldo inteligente
                </div>
                <h1>Independencia Energética<br/>con Garantía</h1>
                <p>Instalamos sistemas solares seguros que reducen tu factura y protegen tu hogar ante cortes de red, con respaldo técnico y monitoreo real.</p>
                <div class="hero-actions">
                    <a class="btn btn-primary" href="#pago">Reservar con 50%</a>
                    <a class="btn btn-whatsapp" href="https://wa.me/+56971806441" target="_blank">
                        <i class="fa-brands fa-whatsapp"></i> Consultar
                    </a>
                    <a class="btn btn-white" href="#proyectos">Ver proyectos</a>
                </div>
                <div class="hero-stats">
                    <div class="stat">✅ Respaldo ante cortes</div>
                    <div class="stat">📊 Ahorro medible</div>
                    <div class="stat">🔧 Garantía técnica</div>
                </div>
            </div>
            <div class="reveal">
                <!-- <img src="<?= Yii::getAlias('@web/images/logo1.jpeg') ?>" alt="Ilustración de energía solar" style="border-radius:20px; width:100%;" /> -->
            </div>
        </div>
    </section>

    <!-- ===== GARANTÍAS ===== -->
    <section class="section" id="garantias">
        <div class="container">
            <div class="section-header reveal">
                <span class="tag">Confianza</span>
                <h2>Garantías claras para tu inversión</h2>
                <p>Te acompañamos desde la evaluación hasta la instalación, con respaldo real y transparente.</p>
            </div>
            <div class="grid-3">
                <div class="card reveal">
                    <div class="icon green">✓</div>
                    <h3>Instaladores Certificados</h3>
                    <p>Equipo acreditado para montaje en cubierta y conexión eléctrica segura.</p>
                </div>
                <div class="card reveal">
                    <div class="icon gold">10</div>
                    <h3>Garantía de 10 años</h3>
                    <p>Equipos seleccionados por durabilidad y soporte técnico disponible.</p>
                </div>
                <div class="card reveal">
                    <div class="icon blue">$</div>
                    <h3>Ahorro Garantizado</h3>
                    <p>Simulación de consumo y producción antes de decidir.</p>
                </div>
            </div>
        </div>
    </section>
    <!-- ===== GALERÍA ===== -->
    <section class="section" id="galeria">
        <div class="container">
            <div class="section-header reveal" style="text-align:center; margin:0 auto 40px;">
                <span class="tag">Nuestros trabajos</span>
                <h2>Galería de proyectos</h2>
                <p>Conoce algunos de nuestros proyectos solares instalados en hogares y empresas.</p>
            </div>

            <div class="gallery-grid" id="galleryGrid">
                <?php if (!empty($fotografias)): ?>
                    <?php foreach ($fotografias as $fotografia): ?>
                        <div class="gallery-item">
                            <img
                                src="<?= Html::encode(Yii::getAlias('@web/uploads/fotografias/' . $fotografia->archivo)) ?>"
                                alt="<?= Html::encode($fotografia->titulo) ?>"
                                loading="lazy"
                            />
                            <div class="overlay">
                                <span><?= Html::encode($fotografia->titulo) ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="grid-column:1/-1; text-align:center; color:#4a6580;">
                        Actualmente no hay fotografías disponibles.
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- ===== MODAL / LIGHTBOX ===== -->
    <div class="gallery-modal" id="galleryModal">
        <button class="modal-close" id="modalClose">
            <i class="fa-solid fa-xmark"></i>
        </button>
        <button class="modal-nav modal-prev" id="modalPrev">
            <i class="fa-solid fa-chevron-left"></i>
        </button>
        <button class="modal-nav modal-next" id="modalNext">
            <i class="fa-solid fa-chevron-right"></i>
        </button>
        <img class="modal-image" id="modalImage" src="" alt="Imagen del proyecto" />
        <div class="modal-caption" id="modalCaption"></div>
    </div>

    <!-- ===== VIDEOS ===== -->
    <section class="section section-alt" id="videos">
        <div class="container">
            <div class="section-header reveal">
                <span class="tag">Videos</span>
                <h2>Conoce nuestros proyectos</h2>
                <p>Revisa videos de nuestras instalaciones y soluciones de energía solar.</p>
            </div>

            <?php if (!empty($videos)): ?>
                <div class="videos-grid">
                    <?php foreach ($videos as $video): ?>
                        <?php $embedUrl = youtubeEmbedUrl($video->url); ?>
                        <?php if ($embedUrl !== null): ?>
                            <article class="video-card reveal">
                                <div class="video-frame">
                                    <iframe
                                        src="<?= Html::encode($embedUrl) ?>"
                                        title="<?= Html::encode($video->titulo) ?>"
                                        loading="lazy"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                        referrerpolicy="strict-origin-when-cross-origin"
                                        allowfullscreen
                                    ></iframe>
                                </div>
                                <div class="video-info">
                                    <h3><?= Html::encode($video->titulo) ?></h3>
                                    <?php if (!empty($video->descripcion)): ?>
                                        <p><?= Html::encode($video->descripcion) ?></p>
                                    <?php endif; ?>
                                </div>
                            </article>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p style="text-align:center; color:#4a6580;">
                    Actualmente no hay videos disponibles.
                </p>
            <?php endif; ?>
        </div>
    </section>

    <!-- ===== PROYECTOS ===== -->
<section class="section section-alt" id="proyectos">
    <div class="container">
        <div class="section-header reveal">
            <span class="tag">Portafolio</span>
            <h2>Proyectos solares instalados</h2>
            <p>Soluciones para hogares y comercios que buscan estabilidad energética y ahorro sostenido.</p>
        </div>

        <div class="grid-3">

            <?php if (!empty($proyectos)): ?>

                <?php foreach ($proyectos as $proyecto): ?>

                    <div class="card reveal">

                        <?php if (!empty($proyecto->imagen)): ?>

                            <img
                                src="<?= Html::encode(Yii::getAlias('@web/uploads/proyectos/' . $proyecto->imagen)) ?>"
                                alt="<?= Html::encode($proyecto->titulo) ?>"
                                style="border-radius:12px; width:100%; margin-bottom:12px;"
                                loading="lazy"
                            />

                        <?php endif; ?>

                        <h3><?= Html::encode($proyecto->titulo) ?></h3>

                        <?php if (!empty($proyecto->descripcion)): ?>
                            <p><?= Html::encode($proyecto->descripcion) ?></p>
                        <?php endif; ?>

                    </div>

                <?php endforeach; ?>

            <?php else: ?>

                <p style="grid-column:1/-1; text-align:center; color:#4a6580;">
                    Actualmente no hay proyectos disponibles.
                </p>

            <?php endif; ?>

        </div>
    </div>
</section>

    <!-- ===== CÓMO FUNCIONA ===== -->
    <section class="section" id="funciona">
        <div class="container">
            <div class="section-header reveal">
                <span class="tag">Proceso</span>
                <h2>¿Cómo funciona?</h2>
                <p>Un proceso simple, con precisión técnica y conexión eléctrica preparada para operar con tranquilidad.</p>
            </div>
            <div class="grid-3">
                <div class="card reveal">
                    <div class="icon blue">1</div>
                    <h3>Diseño a medida</h3>
                    <p>Analizamos consumo, orientación, sombras y capacidad estructural.</p>
                </div>
                <div class="card reveal">
                    <div class="icon green">2</div>
                    <h3>Instalación especializada</h3>
                    <p>Montaje con fijaciones certificadas y rutas eléctricas protegidas.</p>
                </div>
                <div class="card reveal">
                    <div class="icon gold">3</div>
                    <h3>Conexión segura</h3>
                    <p>Configuración a tu medida con gestión dinámica de energía y monitoreo continuo de la red eléctrica, para maximizar tu ahorro y proteger tu inversión.</p>
                </div>
            </div>
        </div>
    </section>
    <!-- ===== FORMULARIO DE CONTACTO ===== -->
<section class="section" id="asesoria">
    <div class="container">
        <div class="section-header reveal" style="text-align:center; margin:0 auto 40px;">
            <span class="tag">Asesoría</span>
            <h2>¿Tienes dudas?</h2>
            <p>Déjanos tus datos y te ayudamos a resolver tus preguntas sobre energía solar.</p>
        </div>

        <div class="contact-form-wrapper reveal">
            <form id="formContacto" class="contact-form">
                <div class="form-row">
                    <div class="form-group">
                        <label for="contacto-nombre">Nombre completo</label>
                        <input type="text" id="contacto-nombre" placeholder="Ej: María González" required />
                    </div>
                    <div class="form-group">
                        <label for="contacto-email">Correo electrónico</label>
                        <input type="email" id="contacto-email" placeholder="maria@correo.cl" required />
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="contacto-telefono">Teléfono</label>
                        <input type="tel" id="contacto-telefono" placeholder="+56 9 1234 5678" required />
                    </div>
                    <div class="form-group">
                        <label for="contacto-tipo">Me interesa...</label>
                        <select id="contacto-tipo">
                            <option value="cotizar">Cotizar mi proyecto</option>
                            <option value="dudas">Resolver dudas técnicas</option>
                            <option value="reunion">Agendar una reunión</option>
                            <option value="otro">Otro</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="contacto-mensaje">Mensaje</label>
                    <textarea id="contacto-mensaje" rows="4" placeholder="Cuéntanos sobre tu proyecto o tus dudas..."></textarea>
                </div>

                <button type="submit" class="btn btn-primary" style="width:100%; justify-content:center;">
                    <i class="fa-regular fa-paper-plane"></i>
                    Enviar consulta
                </button>

                <p style="text-align:center; font-size:0.85rem; color:#7a8fa5; margin-top:12px;">
                    <i class="fa-regular fa-clock"></i>
                    Respondemos en menos de 24 horas
                </p>
            </form>
        </div>
    </div>
</section>

    <!-- ===== PAGO / RESERVA ===== -->
    <section class="section section-alt" id="pago">
        <div class="container">
            <div class="section-header reveal" style="text-align:center; margin:0 auto 40px;">
                <span class="tag">Reserva</span>
                <h2>Reserva tu proyecto solar</h2>
                <p>Completa tus datos y asegura tu cupo con el 50% del presupuesto.</p>
            </div>

            <div class="payment-section reveal">
                <h3>📋 Datos de reserva</h3>
                <p class="sub">Completa el formulario y te contactaremos para coordinar la evaluación técnica.</p>

                <?= \yii\helpers\Html::beginForm(
                    ['site/reserva'],
                    'post',
                    ['id' => 'formReserva']
                ) ?>

                    <div class="form-group">
                        <label for="nombre">Nombre completo</label>
                        <input
                            type="text"
                            id="nombre"
                            name="Reserva[nombre]"
                            placeholder="Ej: Juan Pérez"
                            value="<?= \yii\helpers\Html::encode($reserva->nombre) ?>"
                            required
                        />
                    </div>

                    <div class="form-group">
                        <label for="presupuesto">Número de presupuesto</label>
                        <input
                            type="text"
                            id="presupuesto"
                            name="Reserva[presupuesto]"
                            placeholder="Ej: SB342"
                            autocomplete="off"
                            required
                            value="<?= \yii\helpers\Html::encode($reserva->presupuesto) ?>"
                        />
                        <div
                            id="presupuestoMensaje"
                            style="margin-top:8px; font-size:0.9rem;"
                        ></div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">Correo electrónico</label>
                            <input
                                type="email"
                                id="email"
                                name="Reserva[email]"
                                placeholder="juan@correo.cl"
                                value="<?= \yii\helpers\Html::encode($reserva->email) ?>"
                                required
                            />
                        </div>

                        <div class="form-group">
                            <label for="telefono">Teléfono</label>
                            <input
                                type="tel"
                                id="telefono"
                                name="Reserva[telefono]"
                                placeholder="+56 9 1234 5678"
                                value="<?= \yii\helpers\Html::encode($reserva->telefono) ?>"
                                required
                            />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="direccion">Dirección del proyecto</label>
                        <input
                            type="text"
                            id="direccion"
                            name="Reserva[direccion]"
                            placeholder="Calle, número, comuna"
                            value="<?= \yii\helpers\Html::encode($reserva->direccion) ?>"
                            required
                        />
                    </div>

                    <div class="payment-summary">
                        <span class="label" id="reservaLabel">
                            💡 Reserva
                        </span>

                        <span class="amount" id="reservaMonto">
                            $0 <small>CLP</small>
                        </span>
                    </div>

                    <div
                        id="presupuestoDetalle"
                        style="margin-top:10px; text-align:center; display:none;"
                    >
                        <small>
                            Presupuesto total:
                            <strong id="presupuestoTotal">$0</strong>
                            <br>
                            Reserva:
                            <strong id="presupuestoPorcentaje">0%</strong>
                        </small>
                    </div>

                    <button type="submit" class="btn-pay">
                        <i class="fa-solid fa-lock"></i>
                        Pagar
                        <span id="botonMontoReserva"></span>
                        con Webpay
                    </button>

                    <div class="payment-footer">
                        <div class="lock">
                            <i class="fa-solid fa-lock"></i> Pago seguro vía Webpay
                        </div>

                        <p style="margin-top:8px;">
                            <i class="fa-regular fa-circle-check"></i>
                            Al reservar, recibirás un código de confirmación y coordinaremos la visita técnica.
                        </p>
                    </div>

                <?= \yii\helpers\Html::endForm() ?>
            </div>
        </div>
    </section>

    <!-- ===== FOOTER ===== -->
    <footer class="footer" id="contacto">
        <div class="container footer-grid">
            <div>
    <img src="<?= Yii::getAlias('@web/images/logo-mono.png') ?>" alt="Alfima Logo" style="height: 50px; width: auto; margin-bottom: 12px; opacity: 0.9;" />
    <p class="brand-footer" style="margin-top: 5px;">Allan Mariscal</p>
    <p style="margin:8px 0 16px;">Instalación de paneles solares</p>
            </div>
            <div>
                <h3>Contacto</h3>
                <p>contacto@allanmariscal.cl</p>
                <p>+56 9 71806441</p>
                <p>Lun a Vie, 9:00–18:00</p>
            </div>
            <div>
                <h3>Redes</h3>
                <div class="socials">
                    <a href="#"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#"><i class="fa-brands fa-linkedin"></i></a>
                    <a href="#"><i class="fa-brands fa-facebook"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- ===== WHATSAPP FAB ===== -->
    <a class="fab-whatsapp" href="https://wa.me/+56971806441" target="_blank" rel="noopener">
        <i class="fa-brands fa-whatsapp"></i>
    </a>

    <!-- ===== SCRIPTS ===== -->
    <script>
        // ===== REVEAL =====
        document.addEventListener('DOMContentLoaded', () => {
            const items = document.querySelectorAll('.reveal');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, { threshold: 0.15 });
            items.forEach(el => observer.observe(el));
        });
        // ===== CONSULTA DE PRESUPUESTO =====
        document.addEventListener('DOMContentLoaded', function () {

            const presupuestoInput = document.getElementById('presupuesto');
            const presupuestoMensaje = document.getElementById('presupuestoMensaje');
            const presupuestoDetalle = document.getElementById('presupuestoDetalle');
            const presupuestoTotal = document.getElementById('presupuestoTotal');
            const presupuestoPorcentaje = document.getElementById('presupuestoPorcentaje');
            const reservaLabel = document.getElementById('reservaLabel');
            const reservaMonto = document.getElementById('reservaMonto');
            const botonMontoReserva = document.getElementById('botonMontoReserva');

            let temporizador;

            presupuestoInput.addEventListener('input', function () {

                clearTimeout(temporizador);

                const codigo = this.value.trim();

                presupuestoMensaje.textContent = '';
                presupuestoDetalle.style.display = 'none';
                reservaMonto.innerHTML = '$0 <small>CLP</small>';
                reservaLabel.textContent = '💡 Reserva';
                botonMontoReserva.textContent = '';

                if (codigo.length < 2) {
                    return;
                }

                temporizador = setTimeout(function () {

                    fetch(
                        '<?= \yii\helpers\Url::to(['site/buscar-presupuesto'], true) ?>' +
                        '&codigo=' +
                        encodeURIComponent(codigo)
                    )
                    .then(response => response.json())
                    .then(data => {

                        if (!data.success) {

                            presupuestoMensaje.textContent = data.message;
                            presupuestoMensaje.style.color = '#dc3545';

                            return;
                        }

                        const montoTotal = Number(data.monto_total);
                        const montoReserva = Number(data.monto_reserva);
                        const porcentaje = Number(data.porcentaje_reserva);

                        const formatoPesos = new Intl.NumberFormat('es-CL');

                        presupuestoMensaje.textContent =
                            '✓ Presupuesto encontrado';

                        presupuestoMensaje.style.color = '#198754';

                        presupuestoTotal.textContent =
                            '$' + formatoPesos.format(montoTotal);

                        presupuestoPorcentaje.textContent =
                            porcentaje + '%';

                        reservaLabel.textContent =
                            '💡 Reserva (' + porcentaje + '% del presupuesto)';

                        reservaMonto.innerHTML =
                            '$' + formatoPesos.format(montoReserva) +
                            ' <small>CLP</small>';
                            botonMontoReserva.textContent =
                            ' $' + formatoPesos.format(montoReserva);

                        presupuestoDetalle.style.display = 'block';

                    })
                    .catch(function () {

                        presupuestoMensaje.textContent =
                            'No fue posible consultar el presupuesto.';

                        presupuestoMensaje.style.color = '#dc3545';

                    });

                }, 400);
            });
        });

        // ===== FORMULARIO =====
        // document.getElementById('formReserva').addEventListener('submit', function(e) {
        //     e.preventDefault();

        //     const nombre = document.getElementById('nombre').value.trim();
        //     const email = document.getElementById('email').value.trim();
        //     const telefono = document.getElementById('telefono').value.trim();
        //     const direccion = document.getElementById('direccion').value.trim();

        //     if (!nombre || !email || !telefono || !direccion) {
        //         alert('⚠️ Por favor, completa todos los campos.');
        //         return;
        //     }

        //     // Simulación de redirección a Webpay
        //     alert(
        //         // '✅ ¡Reserva registrada!\n\n' +
        //         'Hola!! ' + nombre + '\n' +
        //         // '📧 Correo: ' + email + '\n' +
        //         // '📱 Teléfono: ' + telefono + '\n' +
        //         // '📍 Dirección: ' + direccion + '\n\n' +
        //         '🔗 Serás redirigido a Webpay para completar el pago del 50%.\n' +
        //         '📩 Te enviaremos un correo con los detalles de tu reserva.'
        //     );

        //     // Aquí iría la integración real con Webpay
        //     // window.location.href = "https://webpay.example.com/pago?...";
        // });

        document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.getElementById('menuToggle');
    const navLinks = document.getElementById('navLinks');
    const overlay = document.createElement('div');
    overlay.className = 'nav-overlay';
    document.body.appendChild(overlay);

    function toggleMenu() {
        menuToggle.classList.toggle('active');
        navLinks.classList.toggle('open');
        overlay.classList.toggle('active');
        document.body.style.overflow = navLinks.classList.contains('open') ? 'hidden' : '';
    }

    function closeMenu() {
        menuToggle.classList.remove('active');
        navLinks.classList.remove('open');
        overlay.classList.remove('active');
        document.body.style.overflow = '';
    }

    menuToggle.addEventListener('click', toggleMenu);
    overlay.addEventListener('click', closeMenu);

    // Cerrar menú al hacer clic en un enlace
    document.querySelectorAll('.nav-links a').forEach(link => {
        link.addEventListener('click', closeMenu);
    });

    // Cerrar menú al presionar la tecla ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeMenu();
    });
});
// ===== DATOS DE LA GALERÍA =====
const galleryImages = <?= Json::htmlEncode($galleryImages) ?>;

// ===== GALERÍA / LIGHTBOX =====
const galleryGrid = document.getElementById('galleryGrid');
const galleryItems = galleryGrid ? galleryGrid.querySelectorAll('.gallery-item') : [];

galleryItems.forEach((item, index) => {
    item.addEventListener('click', () => openModal(index));
});

// ===== MODAL / LIGHTBOX =====
let currentIndex = 0;
const modal = document.getElementById('galleryModal');
const modalImage = document.getElementById('modalImage');
const modalCaption = document.getElementById('modalCaption');

function openModal(index) {
    currentIndex = index;
    updateModal();
    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    modal.classList.remove('active');
    document.body.style.overflow = '';
}

function updateModal() {
    if (!galleryImages.length) return;
    const img = galleryImages[currentIndex];
    modalImage.src = img.src;
    modalImage.alt = img.caption;
    modalCaption.textContent = img.caption;
}

function prevImage() {
    currentIndex = (currentIndex - 1 + galleryImages.length) % galleryImages.length;
    updateModal();
}

function nextImage() {
    currentIndex = (currentIndex + 1) % galleryImages.length;
    updateModal();
}

// ===== EVENTOS DEL MODAL =====
document.getElementById('modalClose').addEventListener('click', closeModal);
document.getElementById('modalPrev').addEventListener('click', prevImage);
document.getElementById('modalNext').addEventListener('click', nextImage);

// Cerrar con ESC
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeModal();
    if (e.key === 'ArrowLeft') prevImage();
    if (e.key === 'ArrowRight') nextImage();
});

// Cerrar al hacer clic fuera de la imagen
modal.addEventListener('click', (e) => {
    if (e.target === modal) closeModal();
});
    </script>

</body>
</html>