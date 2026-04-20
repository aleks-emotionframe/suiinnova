<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- SEO -->
    <title><?= e($pageTitle ?? 'SUI Innova GmbH') ?> - <?= e(setting('site_name', SITE_NAME)) ?><?= ($suffix = setting('meta_title_suffix')) ? ' | ' . e($suffix) : '' ?></title>
    <?php $effectiveDesc = $pageDesc ?? '' ?: setting('default_meta_description'); ?>
    <?php if (!empty($effectiveDesc)): ?>
        <meta name="description" content="<?= e($effectiveDesc) ?>">
    <?php endif; ?>
    <?php if (setting('seo_noindex') === '1'): ?>
        <meta name="robots" content="noindex, nofollow">
    <?php endif; ?>

    <!-- OpenGraph / Social -->
    <meta property="og:title" content="<?= e($pageTitle ?? setting('site_name', SITE_NAME)) ?>">
    <?php if (!empty($effectiveDesc)): ?>
        <meta property="og:description" content="<?= e($effectiveDesc) ?>">
    <?php endif; ?>
    <meta property="og:url" content="<?= e(SITE_URL . $_SERVER['REQUEST_URI']) ?>">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="<?= e(setting('site_name', SITE_NAME)) ?>">
    <?php if ($ogImage = setting('og_image_url')): ?>
        <meta property="og:image" content="<?= e($ogImage) ?>">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:image" content="<?= e($ogImage) ?>">
    <?php else: ?>
        <meta name="twitter:card" content="summary">
    <?php endif; ?>

    <!-- Search Console Verification -->
    <?php if ($googleVerify = setting('google_site_verification')): ?>
        <meta name="google-site-verification" content="<?= e($googleVerify) ?>">
    <?php endif; ?>
    <?php if ($bingVerify = setting('bing_site_verification')): ?>
        <meta name="msvalidate.01" content="<?= e($bingVerify) ?>">
    <?php endif; ?>

    <!-- Canonical -->
    <link rel="canonical" href="<?= e(SITE_URL . $_SERVER['REQUEST_URI']) ?>">

    <!-- Favicon -->
    <?php $favicon = setting('favicon_url', asset('img/favicon.ico')); ?>
    <link rel="icon" type="image/x-icon" href="<?= e($favicon) ?>">

    <!-- Fonts (Self-Hosted, DSGVO-konform) -->
    <link rel="preload" href="<?= asset('fonts/Inter-Regular.woff2') ?>" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="<?= asset('fonts/Inter-Medium.woff2') ?>" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="<?= asset('fonts/Inter-Bold.woff2') ?>" as="font" type="font/woff2" crossorigin>

    <!-- Styles -->
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>">

    <!-- Alpine.js (defer) -->
    <script src="<?= asset('js/alpine.min.js') ?>" defer></script>
</head>

<body class="font-sans text-gray-900 bg-white antialiased">

    <?php if (isLoggedIn() && isset($page) && (int)($page['is_active'] ?? 1) === 0): ?>
        <div id="admin-offline-banner" style="position:fixed;top:0;left:0;right:0;z-index:60;background:#f59e0b;color:#111827;font-size:14px;font-weight:500;box-shadow:0 2px 8px rgba(0,0,0,0.15);">
            <div class="max-w-container-wide mx-auto px-4 md:px-6" style="padding-top:10px;padding-bottom:10px;display:flex;flex-wrap:wrap;align-items:center;gap:12px;">
                <span style="display:inline-flex;align-items:center;gap:8px;">
                    <span style="width:8px;height:8px;background:#111827;border-radius:50%;display:inline-block;animation:admin-offline-pulse 1.4s ease-in-out infinite;"></span>
                    <strong style="text-transform:uppercase;letter-spacing:0.05em;font-size:11px;">Offline für Besucher</strong>
                </span>
                <span class="hidden sm:inline" style="color:rgba(17,24,39,0.8);">Diese Seite ist deaktiviert. Nur Sie als Admin sehen sie.</span>
                <a href="<?= url('admin/pages') ?>" style="margin-left:auto;display:inline-flex;align-items:center;background:#111827;color:#fff;padding:4px 12px;font-size:11px;text-transform:uppercase;letter-spacing:0.05em;font-weight:600;text-decoration:none;transition:background 0.2s;"
                   onmouseover="this.style.background='#374151'" onmouseout="this.style.background='#111827'">
                    Im CMS verwalten
                </a>
            </div>
        </div>
        <style>
            @keyframes admin-offline-pulse { 0%,100% { opacity:1; transform:scale(1); } 50% { opacity:0.5; transform:scale(1.3); } }
            #admin-offline-banner ~ header { top: 41px !important; }
            body { padding-top: 41px; }
        </style>
    <?php endif; ?>

    <?php include BASE_PATH . '/templates/partials/header.php'; ?>

    <main id="content">
        <?php if (isset($sections) && !empty($sections)): ?>
            <?php foreach ($sections as $section): ?>
                <?php renderSection($section); ?>
            <?php endforeach; ?>
        <?php elseif (http_response_code() === 404): ?>
            <!-- 404 -->
            <section class="py-24 text-center">
                <div class="max-w-container mx-auto px-4 md:px-6">
                    <h1 class="text-5xl font-bold uppercase tracking-wide mb-4"><?= e(setting('404_title', '404')) ?></h1>
                    <p class="text-gray-600 text-lg mb-8"><?= e(setting('404_text', 'Die angeforderte Seite wurde nicht gefunden.')) ?></p>
                    <a href="<?= url() ?>" class="inline-flex items-center h-10 px-6 bg-gray-900 text-white font-medium hover:bg-gray-700 transition-colors duration-200">
                        <?= e(setting('404_button', 'Zur Startseite')) ?>
                    </a>
                </div>
            </section>
        <?php endif; ?>
    </main>

    <?php include BASE_PATH . '/templates/partials/footer.php'; ?>

    <!-- App JS -->
    <script src="<?= asset('js/app.js') ?>"></script>
</body>
</html>
