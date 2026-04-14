<?php
$pageTitle = 'Seite nicht gefunden – SUI Innova GmbH';
$metaDescription = '';
$navPages = getNavPages();
$currentSlug = '';
require APP_PATH . '/views/layout/header.php';
?>

    <section class="page-hero page-hero-compact" aria-label="Fehler 404">
        <div class="page-hero-bg"></div>
        <div class="container">
            <div class="page-hero-content" data-reveal>
                <span class="section-label">Fehler 404</span>
                <h1 class="page-hero-title">Seite nicht gefunden</h1>
                <p class="page-hero-desc">Die angeforderte Seite existiert leider nicht oder wurde verschoben.</p>
                <div class="hero-actions" style="margin-top: 2rem;">
                    <a href="<?= SITE_URL ?>/" class="btn btn-primary">Zur Startseite</a>
                </div>
            </div>
        </div>
    </section>

<?php require APP_PATH . '/views/layout/footer.php'; ?>
