<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= e($metaDescription ?? '') ?>">
    <?php if (!empty($metaKeywords)): ?><meta name="keywords" content="<?= e($metaKeywords) ?>"><?php endif; ?>
    <title><?= e($pageTitle ?? 'SUI Innova GmbH') ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/style.css">
    <link rel="icon" type="image/svg+xml" href="<?= SITE_URL ?>/assets/img/favicon.svg">
</head>
<body>
    <a href="#main-content" class="skip-link">Zum Inhalt springen</a>

    <header class="site-header" id="site-header">
        <div class="header-inner">
            <a href="<?= SITE_URL ?>/" class="logo" aria-label="SUI Innova GmbH – Startseite">
                <img src="<?= SITE_URL ?>/assets/img/logo-white.svg" alt="SUI Innova GmbH" class="logo-img logo-img-white">
                <img src="<?= SITE_URL ?>/assets/img/SUI-Innova_Logo.webp" alt="SUI Innova GmbH" class="logo-img logo-img-dark">
            </a>

            <nav class="main-nav" id="main-nav" aria-label="Hauptnavigation">
                <ul class="nav-list">
                    <?php foreach (($navPages ?? []) as $navItem): ?>
                    <li class="nav-item">
                        <a href="<?= pageUrl($navItem['slug']) ?>"
                           class="nav-link <?= isActivePage($navItem['slug']) ? 'is-active' : '' ?>"
                           <?= isActivePage($navItem['slug']) ? 'aria-current="page"' : '' ?>>
                            <?= e($navItem['title']) ?>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </nav>

            <button class="nav-toggle" id="nav-toggle" aria-expanded="false" aria-controls="main-nav" aria-label="Navigation öffnen">
                <span class="nav-toggle-bar"></span>
                <span class="nav-toggle-bar"></span>
                <span class="nav-toggle-bar"></span>
            </button>
        </div>
    </header>

    <main id="main-content">
