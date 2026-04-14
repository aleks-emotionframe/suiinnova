<?php
$title = 'Wartungsarbeiten';
$message = 'Unsere Website wird gerade aktualisiert. Wir sind in Kürze wieder für Sie da.';

try {
    $db = Database::getInstance();
    $stmt = $db->prepare("SELECT setting_key, setting_value FROM settings WHERE setting_key IN ('maintenance_title', 'maintenance_message', 'site_phone', 'site_email')");
    $stmt->execute();
    while ($row = $stmt->fetch()) {
        if ($row['setting_key'] === 'maintenance_title') $title = $row['setting_value'];
        if ($row['setting_key'] === 'maintenance_message') $message = $row['setting_value'];
        if ($row['setting_key'] === 'site_phone') $phone = $row['setting_value'];
        if ($row['setting_key'] === 'site_email') $email = $row['setting_value'];
    }
} catch (Exception $e) {}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title><?= htmlspecialchars($title) ?> – SUI Innova GmbH</title>
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
        .maintenance { max-width: 540px; }
        .maintenance-logo { margin-bottom: 2.5rem; }
        .maintenance-logo img { height: 40px; filter: brightness(10) drop-shadow(0 0 0 #fff); }
        .maintenance h1 {
            font-size: 2rem; font-weight: 800;
            margin-bottom: 1rem; line-height: 1.2;
        }
        .maintenance h1 span { color: #E30613; }
        .maintenance p {
            font-size: 1rem; color: rgba(255,255,255,0.7);
            line-height: 1.7; margin-bottom: 1.5rem;
        }
        .maintenance-contact {
            font-size: 0.875rem; color: rgba(255,255,255,0.5);
        }
        .maintenance-contact a {
            color: #E30613; text-decoration: none;
        }
        .maintenance-contact a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="maintenance">
        <div class="maintenance-logo">
            <img src="<?= SITE_URL ?>/assets/img/SUI-Innova_Logo.webp" alt="SUI Innova GmbH">
        </div>
        <h1><?= htmlspecialchars($title) ?></h1>
        <p><?= nl2br(htmlspecialchars($message)) ?></p>
        <?php if (!empty($phone) || !empty($email)): ?>
        <p class="maintenance-contact">
            Kontakt:
            <?php if (!empty($phone)): ?><a href="tel:<?= htmlspecialchars(str_replace(' ', '', $phone)) ?>"><?= htmlspecialchars($phone) ?></a><?php endif; ?>
            <?php if (!empty($phone) && !empty($email)): ?> · <?php endif; ?>
            <?php if (!empty($email)): ?><a href="mailto:<?= htmlspecialchars($email) ?>"><?= htmlspecialchars($email) ?></a><?php endif; ?>
        </p>
        <?php endif; ?>
    </div>
</body>
</html>
