<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wartung - <?= e(setting('site_name', SITE_NAME)) ?></title>
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
    <meta name="robots" content="noindex, nofollow">
</head>
<body class="font-sans bg-gray-900 text-white antialiased min-h-screen flex items-center justify-center">

    <div class="text-center px-6 max-w-lg">
        <!-- Logo -->
        <img src="<?= asset('img/SUI-Innova_Logo_white.webp') ?>"
             alt="<?= e(setting('site_name', SITE_NAME)) ?>"
             class="h-10 mx-auto mb-10 opacity-80">

        <!-- Icon -->
        <div class="w-16 h-16 mx-auto mb-8 flex items-center justify-center rounded-full bg-white/10">
            <svg class="w-8 h-8 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085"/>
            </svg>
        </div>

        <!-- Text -->
        <h1 class="text-2xl md:text-3xl font-bold uppercase tracking-wider mb-4">
            Wartungsarbeiten
        </h1>
        <p class="text-white/50 text-sm md:text-base leading-relaxed mb-10">
            <?= e(setting('maintenance_text', 'Unsere Website wird gerade aktualisiert. Wir sind in Kürze wieder für Sie da.')) ?>
        </p>

        <!-- Kontakt -->
        <?php if ($phone = setting('phone')): ?>
            <p class="text-white/30 text-xs">
                Telefon: <a href="tel:<?= e(preg_replace('/\s+/', '', $phone)) ?>" class="text-white/50 hover:text-white"><?= e($phone) ?></a>
            </p>
        <?php endif; ?>
    </div>

</body>
</html>
