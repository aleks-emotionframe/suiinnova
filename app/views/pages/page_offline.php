<?php
$sitePhone = setting('site_phone', '');
$siteEmail = setting('site_email', '');
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title><?= e($offlineTitle) ?> – Wird überarbeitet | SUI Innova GmbH</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #111; color: #fff;
            min-height: 100vh; display: flex;
            align-items: center; justify-content: center;
            text-align: center; padding: 2rem;
        }
        .offline { max-width: 560px; }
        .offline-logo { margin-bottom: 2.5rem; }
        .offline-logo img { height: 40px; filter: grayscale(1) brightness(10); }
        .offline-kicker {
            display: inline-block;
            font-size: 0.75rem; font-weight: 600;
            letter-spacing: 0.2em; text-transform: uppercase;
            color: #E30613; margin-bottom: 1.25rem;
        }
        .offline h1 {
            font-size: 2rem; font-weight: 800;
            margin-bottom: 1rem; line-height: 1.2;
        }
        .offline p {
            font-size: 1rem; color: rgba(255,255,255,0.7);
            line-height: 1.7; margin-bottom: 2rem;
        }
        .offline-back {
            display: inline-block;
            padding: 0.875rem 1.75rem;
            border: 1px solid rgba(255,255,255,0.25);
            border-radius: 2px;
            color: #fff; text-decoration: none;
            font-weight: 600; font-size: 0.875rem;
            letter-spacing: 0.05em;
            transition: all 0.2s ease;
        }
        .offline-back:hover {
            background: #E30613; border-color: #E30613;
        }
        .offline-contact {
            margin-top: 2.5rem;
            font-size: 0.875rem; color: rgba(255,255,255,0.5);
        }
        .offline-contact a { color: #E30613; text-decoration: none; }
        .offline-contact a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="offline">
        <div class="offline-logo">
            <img src="<?= SITE_URL ?>/assets/img/SUI-Innova_Logo.webp" alt="SUI Innova GmbH">
        </div>
        <span class="offline-kicker">Seite wird überarbeitet</span>
        <h1><?= e($offlineTitle) ?> ist aktuell nicht verfügbar</h1>
        <p>Wir aktualisieren diesen Bereich gerade für Sie. Schauen Sie in Kürze wieder vorbei – die übrigen Seiten sind wie gewohnt erreichbar.</p>
        <a href="<?= SITE_URL ?>/" class="offline-back">← Zur Startseite</a>
        <?php if (!empty($sitePhone) || !empty($siteEmail)): ?>
        <p class="offline-contact">
            Direktkontakt:
            <?php if (!empty($sitePhone)): ?><a href="tel:<?= e(str_replace(' ', '', $sitePhone)) ?>"><?= e($sitePhone) ?></a><?php endif; ?>
            <?php if (!empty($sitePhone) && !empty($siteEmail)): ?> · <?php endif; ?>
            <?php if (!empty($siteEmail)): ?><a href="mailto:<?= e($siteEmail) ?>"><?= e($siteEmail) ?></a><?php endif; ?>
        </p>
        <?php endif; ?>
    </div>
</body>
</html>
