<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($offlineTitle ?? 'Diese Seite') ?> - Wird überarbeitet | <?= e(setting('site_name', SITE_NAME)) ?></title>
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

        <!-- Kicker -->
        <div class="text-[10px] uppercase tracking-[0.25em] text-brand-accent font-semibold mb-3">
            Seite wird überarbeitet
        </div>

        <!-- Titel -->
        <h1 class="text-2xl md:text-3xl font-bold uppercase tracking-wider mb-4">
            <?= e($offlineTitle ?? 'Diese Seite') ?> ist aktuell offline
        </h1>
        <p class="text-white/50 text-sm md:text-base leading-relaxed mb-10">
            Wir aktualisieren diesen Bereich gerade für Sie. Schauen Sie in Kürze wieder vorbei – die übrigen Seiten sind wie gewohnt erreichbar.
        </p>

        <!-- Zurück -->
        <a href="<?= url() ?>"
           class="inline-flex items-center h-10 px-6 border border-white/25 text-white text-sm font-medium uppercase tracking-wider hover:bg-white hover:text-gray-900 transition-colors duration-200">
            ← Zur Startseite
        </a>

        <!-- Kontakt -->
        <?php $phone = setting('phone'); $email = setting('email', CONTACT_EMAIL); ?>
        <?php if ($phone || $email): ?>
            <p class="text-white/30 text-xs mt-10">
                Direktkontakt:
                <?php if ($phone): ?>
                    <a href="tel:<?= e(preg_replace('/\s+/', '', $phone)) ?>" class="text-white/50 hover:text-white"><?= e($phone) ?></a>
                <?php endif; ?>
                <?php if ($phone && $email): ?> · <?php endif; ?>
                <?php if ($email): ?>
                    <a href="mailto:<?= e($email) ?>" class="text-white/50 hover:text-white"><?= e($email) ?></a>
                <?php endif; ?>
            </p>
        <?php endif; ?>
    </div>

</body>
</html>
