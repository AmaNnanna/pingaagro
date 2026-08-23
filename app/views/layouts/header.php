<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= isset($metaDesc) ? htmlspecialchars($metaDesc) : 'Pinga Agro Investment Limited — Another Name for Quality.' ?>">
    <title><?= isset($title) ? htmlspecialchars($title) : SITENAME ?></title>
    <link rel="icon" type="image/png" href="<?= URLROOT ?>/images/favicon.png">

    <?php
    // Determine current page for active link highlighting and CSS loading
    $currentUrl = isset($_GET['url']) ? trim($_GET['url'], '/') : '';
    ?>

    <!-- ── Core CSS (loaded on every page) ─────────────────── -->
    <link rel="stylesheet" href="<?= URLROOT ?>/css/style.css">
    <link rel="stylesheet" href="<?= URLROOT ?>/css/components.css">
    <link rel="stylesheet" href="<?= URLROOT ?>/css/animations.css">

    <!-- ── Page-specific CSS (loaded only when needed) ──────── -->
    <?php if ($currentUrl === ''): ?>
        <link rel="stylesheet" href="<?= URLROOT ?>/css/home.css">

    <?php elseif (in_array($currentUrl, ['about', 'products']) || strpos($currentUrl, 'products') === 0): ?>
        <link rel="stylesheet" href="<?= URLROOT ?>/css/pages.css">

    <?php elseif (strpos($currentUrl, 'insights') === 0): ?>
        <link rel="stylesheet" href="<?= URLROOT ?>/css/insights.css">

    <?php elseif ($currentUrl === 'contact'): ?>
        <link rel="stylesheet" href="<?= URLROOT ?>/css/contact.css">

    <?php elseif (strpos($currentUrl, 'review') === 0): ?>
        <link rel="stylesheet" href="<?= URLROOT ?>/css/reviews.css">
    <?php endif; ?>

</head>

<body>

    <nav class="navbar" id="navbar">
        <div class="container">
            <div class="navbar__inner">

                <a href="<?= URLROOT ?>/" class="navbar__logo">
                    <img src="<?= URLROOT ?>/images/logo.png" alt="Pinga Agro Investment Limited">
                </a>

                <div class="navbar__menu">
                    <ul class="navbar__links">
                        <li><a href="<?= URLROOT ?>/" class="<?= ($currentUrl === '') ? 'active' : '' ?>">Home</a></li>
                        <li><a href="<?= URLROOT ?>/about" class="<?= ($currentUrl === 'about') ? 'active' : '' ?>">About Us</a></li>
                        <li><a href="<?= URLROOT ?>/products" class="<?= (strpos($currentUrl, 'products') === 0) ? 'active' : '' ?>">Our Products</a></li>
                        <li><a href="<?= URLROOT ?>/insights" class="<?= (strpos($currentUrl, 'insights') === 0) ? 'active' : '' ?>">Insights</a></li>
                    </ul>
                    <a href="<?= URLROOT ?>/contact" class="btn btn-primary navbar__cta">Contact Us</a>
                </div>

                <button class="navbar__toggle" id="navToggle" aria-label="Open menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>

            </div>
        </div>

        <div class="navbar__mobile" id="mobileMenu">
            <a href="<?= URLROOT ?>/">Home</a>
            <a href="<?= URLROOT ?>/about">About Us</a>
            <a href="<?= URLROOT ?>/products">Our Products</a>
            <a href="<?= URLROOT ?>/insights">Insights</a>
            <a href="<?= URLROOT ?>/contact" class="btn btn-primary">Contact Us</a>
        </div>

    </nav>