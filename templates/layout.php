<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- SEO -->
    <title><?= e($pageTitle ?? 'SUI Innova GmbH') ?> - <?= e(setting('site_name', SITE_NAME)) ?></title>
    <?php if (!empty($pageDesc)): ?>
        <meta name="description" content="<?= e($pageDesc) ?>">
    <?php endif; ?>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= asset('img/favicon.ico') ?>">

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
        <div class="fixed top-0 left-0 right-0 z-[60] bg-amber-500 text-gray-900 text-sm font-medium shadow-lg" id="admin-offline-banner">
            <div class="max-w-container-wide mx-auto px-4 md:px-6 py-2.5 flex flex-wrap items-center gap-3">
                <span class="inline-flex items-center gap-2">
                    <span class="w-2 h-2 bg-gray-900 rounded-full animate-pulse"></span>
                    <strong class="uppercase tracking-wider text-[11px]">Offline für Besucher</strong>
                </span>
                <span class="text-gray-900/80 hidden sm:inline">Diese Seite ist deaktiviert. Nur Sie als Admin sehen sie.</span>
                <a href="<?= url('admin/pages') ?>" class="ml-auto inline-flex items-center bg-gray-900 text-white px-3 py-1 text-[11px] uppercase tracking-wider font-semibold hover:bg-gray-700 transition-colors">
                    Im CMS verwalten
                </a>
            </div>
        </div>
        <style>
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
                    <h1 class="text-5xl font-bold uppercase tracking-wide mb-4">404</h1>
                    <p class="text-gray-600 text-lg mb-8">Die angeforderte Seite wurde nicht gefunden.</p>
                    <a href="<?= url() ?>" class="inline-flex items-center h-10 px-6 bg-gray-900 text-white font-medium hover:bg-gray-700 transition-colors duration-200">
                        Zur Startseite
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
