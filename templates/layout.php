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

    <!-- Layout-Overrides: breiterer Container + per CMS einstellbare Schriften -->
    <?php
        // Schriftgroessen in px aus dem CMS (einstellbar unter Admin → Einstellungen → Typografie)
        $fsH1        = max(16, min(128, (int) setting('fs_h1',        '64')));
        $fsHeading   = max(14, min(96,  (int) setting('fs_heading',   '48')));
        $fsSubtitle  = max(10, min(48,  (int) setting('fs_subtitle',  '18')));
        $fsCardTitle = max(12, min(48,  (int) setting('fs_card_title','24')));
        $fsBody      = max(10, min(32,  (int) setting('fs_body',      '16')));
        $fsSmall     = max(8,  min(24,  (int) setting('fs_small',     '14')));
    ?>
    <style>
        /* ── Container-Breite ───────────────────────────── */
        .section-container { max-width: 112rem; padding-left: 1.5rem; padding-right: 1.5rem; }
        @media (min-width: 768px) {
            .section-container { padding-left: 2.5rem; padding-right: 2.5rem; }
        }
        .max-w-container { max-width: 112rem; }
        .max-w-container-wide { max-width: 116rem; }

        /* ── Typografie (per CMS einstellbar, px wie in Word) ── */
        :root {
            --fs-h1:         <?= $fsH1 ?>px;
            --fs-heading:    <?= $fsHeading ?>px;
            --fs-subtitle:   <?= $fsSubtitle ?>px;
            --fs-card-title: <?= $fsCardTitle ?>px;
            --fs-body:       <?= $fsBody ?>px;
            --fs-small:      <?= $fsSmall ?>px;
        }

        /* H1 (Hero-Titel / Seiten-Haupttitel)
           Desktop: eingestellter Wert | Tablet: 80% | Mobile: 60% */
        main h1 {
            font-size: calc(var(--fs-h1) * 0.6) !important;
            line-height: 1.1 !important;
            hyphens: auto;
            -webkit-hyphens: auto;
            overflow-wrap: break-word;
        }
        @media (min-width: 768px) { main h1 { font-size: calc(var(--fs-h1) * 0.8) !important; } }
        @media (min-width: 1024px) { main h1 { font-size: var(--fs-h1) !important; } }

        /* Section-Hauptueberschriften (H2)
           Desktop: eingestellter Wert | Tablet: 85% | Mobile: 70% */
        .section-heading {
            font-size: calc(var(--fs-heading) * 0.7);
            line-height: 1.15;
            letter-spacing: 0.02em;
            hyphens: auto;
            -webkit-hyphens: auto;
            overflow-wrap: break-word;
        }
        @media (min-width: 768px) { .section-heading { font-size: calc(var(--fs-heading) * 0.85); } }
        @media (min-width: 1024px) { .section-heading { font-size: var(--fs-heading); line-height: 1.1; } }

        /* Section-Untertitel */
        .section-subtitle {
            font-size: calc(var(--fs-subtitle) * 0.9);
            line-height: 1.65;
            max-width: 60rem;
        }
        @media (min-width: 768px) { .section-subtitle { font-size: var(--fs-subtitle); line-height: 1.7; } }

        /* Karten- / Service-Titel (h3) in Sektionen */
        main .section h3,
        main section h3 {
            font-size: calc(var(--fs-card-title) * 0.85);
            line-height: 1.25;
            hyphens: auto;
            -webkit-hyphens: auto;
            overflow-wrap: break-word;
        }
        @media (min-width: 768px) { main .section h3, main section h3 { font-size: var(--fs-card-title); } }

        /* Body-Text in Sektionen */
        main .section p,
        main section p {
            font-size: var(--fs-body);
            line-height: 1.7;
        }

        /* Kleine Labels / Untertexte */
        main .section .text-xs,
        main .section .text-sm {
            font-size: var(--fs-small);
        }

        /* Mehrzeilige Ueberschriften: Silbentrennung + Balanced-Break */
        main h1, main h2, main h3 {
            text-wrap: balance;
            hyphens: auto;
            -webkit-hyphens: auto;
            overflow-wrap: break-word;
        }
    </style>

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

    <?php
        // Globaler Flash-Banner (oben am Bildschirm-Rand, auto-hide nach 6s)
        // Wird NICHT vom contact-form-Section konsumiert - aber das contact-form
        // setzt seinen Flash trotzdem hier an (peek statt consume).
        $globalFlash = $_SESSION['flash'] ?? null;
        if ($globalFlash):
            // Wir lassen Flash in Session - contact-form kann ihn auch sehen
            // Sobald JS die Toast anzeigt, löschen wir die Session via fetch
    ?>
    <div id="global-flash-banner" data-type="<?= e($globalFlash['type']) ?>"
         style="position:fixed;top:24px;left:50%;transform:translateX(-50%);z-index:200;padding:14px 24px;border-radius:6px;font-size:14px;font-weight:500;box-shadow:0 10px 30px -10px rgba(0,0,0,0.4);display:flex;align-items:center;gap:10px;max-width:90vw;<?= $globalFlash['type'] === 'success' ? 'background:#15803d;color:#fff;' : 'background:#C41018;color:#fff;' ?>">
        <svg style="width:18px;height:18px;flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
            <?php if ($globalFlash['type'] === 'success'): ?>
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            <?php else: ?>
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            <?php endif; ?>
        </svg>
        <span><?= e($globalFlash['message']) ?></span>
        <button type="button" onclick="this.parentElement.style.display='none';" style="background:none;border:0;color:#fff;cursor:pointer;padding:0;margin-left:6px;opacity:0.7;line-height:1;">
            <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>
    <script>
        setTimeout(() => {
            const el = document.getElementById('global-flash-banner');
            if (el) el.style.transition = 'opacity 0.5s', el.style.opacity = '0', setTimeout(() => el.remove(), 500);
        }, 6000);
    </script>
    <?php
        unset($_SESSION['flash']);
        endif;
    ?>

    <?php include BASE_PATH . '/templates/partials/header.php'; ?>

    <main id="content">
        <?php if (isset($sections) && !empty($sections)): ?>
            <?php foreach ($sections as $section): ?>
                <?php renderSection($section); ?>
            <?php endforeach; ?>
        <?php elseif (http_response_code() === 404): ?>
            <!-- 404-Seite -->
            <section style="background:#FAFAFA;min-height:70vh;display:flex;align-items:center;padding:80px 24px;position:relative;overflow:hidden;">
                <!-- Riesige Hintergrund-404 -->
                <div aria-hidden="true" style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);font-size:clamp(220px, 36vw, 480px);font-weight:900;color:#C41018;opacity:0.06;letter-spacing:-0.05em;line-height:0.9;user-select:none;pointer-events:none;white-space:nowrap;">
                    404
                </div>

                <!-- Inhalt -->
                <div class="section-container relative" style="text-align:center;max-width:720px;margin:0 auto;z-index:1;">
                    <!-- Roter Akzent-Strich -->
                    <div style="width:48px;height:2px;background:#C41018;margin:0 auto 24px auto;"></div>

                    <!-- Kicker -->
                    <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.28em;color:#C41018;margin-bottom:18px;">
                        Fehler 404
                    </div>

                    <!-- Heading -->
                    <h1 style="font-size:clamp(28px, 5vw, 48px);font-weight:800;text-transform:uppercase;letter-spacing:0.01em;line-height:1.1;color:#111;margin:0 0 18px 0;text-wrap:balance;">
                        <?= e(setting('404_title', 'Seite nicht gefunden')) ?>
                    </h1>

                    <!-- Description -->
                    <p style="font-size:17px;color:#6B7280;line-height:1.7;margin:0 auto 36px auto;max-width:520px;">
                        <?= e(setting('404_text', 'Die angeforderte Seite existiert nicht oder wurde verschoben. Schauen Sie auf der Startseite vorbei oder kontaktieren Sie uns direkt.')) ?>
                    </p>

                    <!-- Buttons -->
                    <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;margin-bottom:48px;">
                        <a href="<?= url() ?>" style="display:inline-flex;align-items:center;gap:8px;height:46px;padding:0 28px;background:#C41018;color:#fff;font-size:13px;font-weight:600;text-transform:uppercase;letter-spacing:0.1em;text-decoration:none;border-radius:6px;transition:opacity 0.2s;box-shadow:0 4px 12px -4px rgba(196,16,24,0.4);"
                           onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                            <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11 17l-5-5m0 0l5-5m-5 5h12"/></svg>
                            <?= e(setting('404_button', 'Zur Startseite')) ?>
                        </a>
                        <a href="<?= url('kontakt') ?>" style="display:inline-flex;align-items:center;height:46px;padding:0 28px;background:transparent;color:#111;font-size:13px;font-weight:600;text-transform:uppercase;letter-spacing:0.1em;text-decoration:none;border-radius:6px;border:1px solid #D1D5DB;transition:all 0.2s;"
                           onmouseover="this.style.background='#111';this.style.color='#fff';this.style.borderColor='#111'" onmouseout="this.style.background='transparent';this.style.color='#111';this.style.borderColor='#D1D5DB'">
                            Kontakt
                        </a>
                    </div>

                    <!-- Quicklinks zu den Hauptseiten -->
                    <?php if (!empty($navigation)): ?>
                        <div style="border-top:1px solid #E5E7EB;padding-top:32px;">
                            <p style="font-size:11px;text-transform:uppercase;letter-spacing:0.18em;color:#9CA3AF;margin-bottom:16px;font-weight:600;">
                                Vielleicht suchen Sie eine dieser Seiten:
                            </p>
                            <div style="display:flex;gap:24px;justify-content:center;flex-wrap:wrap;">
                                <?php foreach ($navigation as $navItem): ?>
                                    <?php $href = $navItem['url'] ?: url($navItem['page_slug'] ?? ''); ?>
                                    <a href="<?= e($href) ?>" style="font-size:13px;color:#374151;text-decoration:none;font-weight:500;transition:color 0.2s;border-bottom:1px solid transparent;padding-bottom:2px;"
                                       onmouseover="this.style.color='#C41018';this.style.borderBottomColor='#C41018'" onmouseout="this.style.color='#374151';this.style.borderBottomColor='transparent'">
                                        <?= e($navItem['label']) ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        <?php endif; ?>
    </main>

    <?php include BASE_PATH . '/templates/partials/footer.php'; ?>

    <!-- Karriere-Modal (einmal pro Seite) -->
    <?php include BASE_PATH . '/templates/partials/career-modal.php'; ?>

    <!-- Cookie-Banner (nur wenn aktiviert und noch nicht akzeptiert) -->
    <?php include BASE_PATH . '/templates/partials/cookie-banner.php'; ?>

    <!-- App JS -->
    <script src="<?= asset('js/app.js') ?>"></script>
</body>
</html>
