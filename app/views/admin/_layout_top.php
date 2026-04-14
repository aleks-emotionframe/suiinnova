<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMS – SUI Innova GmbH</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@500;700&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/admin.css">
</head>
<body class="admin-body">
    <aside class="admin-sidebar" id="admin-sidebar">
        <div class="sidebar-header">
            <a href="<?= SITE_URL . ADMIN_PATH ?>" class="sidebar-logo">
                <span class="logo-mark">SUI</span>
                <span class="logo-text">CMS</span>
            </a>
        </div>
        <nav class="sidebar-nav" aria-label="Administration">
            <ul class="sidebar-menu">
                <li><a href="<?= SITE_URL . ADMIN_PATH ?>" class="sidebar-link <?= currentPath() === ADMIN_PATH || currentPath() === ADMIN_PATH . '/' ? 'is-active' : '' ?>">
                    <svg viewBox="0 0 24 24" fill="none"><path d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h3a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1h3a1 1 0 001-1V10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Dashboard
                </a></li>
                <li><a href="<?= SITE_URL . ADMIN_PATH ?>/pages" class="sidebar-link <?= str_starts_with(currentPath(), ADMIN_PATH . '/pages') ? 'is-active' : '' ?>">
                    <svg viewBox="0 0 24 24" fill="none"><path d="M4 4h16v16H4z" stroke="currentColor" stroke-width="1.5"/><path d="M8 8h8M8 12h6M8 16h4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                    Seiten & Inhalte
                </a></li>
                <li><a href="<?= SITE_URL . ADMIN_PATH ?>/references" class="sidebar-link <?= str_starts_with(currentPath(), ADMIN_PATH . '/references') ? 'is-active' : '' ?>">
                    <svg viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="7" height="7" rx="1" stroke="currentColor" stroke-width="1.5"/><rect x="14" y="3" width="7" height="7" rx="1" stroke="currentColor" stroke-width="1.5"/><rect x="3" y="14" width="7" height="7" rx="1" stroke="currentColor" stroke-width="1.5"/><rect x="14" y="14" width="7" height="7" rx="1" stroke="currentColor" stroke-width="1.5"/></svg>
                    Referenzen
                </a></li>
                <li><a href="<?= SITE_URL . ADMIN_PATH ?>/messages" class="sidebar-link <?= str_starts_with(currentPath(), ADMIN_PATH . '/messages') ? 'is-active' : '' ?>">
                    <svg viewBox="0 0 24 24" fill="none"><rect x="2" y="4" width="20" height="16" rx="2" stroke="currentColor" stroke-width="1.5"/><path d="M2 7l10 7 10-7" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/></svg>
                    Nachrichten
                    <?php
                    try {
                        $unread = Database::getInstance()->query('SELECT COUNT(*) FROM contact_messages WHERE is_read = 0')->fetchColumn();
                        if ($unread > 0): ?>
                        <span class="sidebar-badge"><?= $unread ?></span>
                    <?php endif; } catch (Exception $e) {} ?>
                </a></li>
                <li><a href="<?= SITE_URL . ADMIN_PATH ?>/settings" class="sidebar-link <?= str_starts_with(currentPath(), ADMIN_PATH . '/settings') ? 'is-active' : '' ?>">
                    <svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.5"/><path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                    Einstellungen
                </a></li>
            </ul>
        </nav>
        <div class="sidebar-footer">
            <a href="<?= SITE_URL . ADMIN_PATH ?>/password" class="sidebar-link-sm">Passwort ändern</a>
            <a href="<?= SITE_URL . ADMIN_PATH ?>/logout" class="sidebar-link-sm">Abmelden</a>
            <a href="<?= SITE_URL ?>/" class="sidebar-link-sm" target="_blank">Website ansehen &nearr;</a>
        </div>
    </aside>

    <div class="admin-main">
        <header class="admin-topbar">
            <button class="sidebar-toggle" id="sidebar-toggle" aria-label="Menü umschalten">
                <svg viewBox="0 0 24 24" fill="none"><path d="M3 12h18M3 6h18M3 18h18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            </button>
            <div class="admin-topbar-right">
                <span class="admin-user"><?= e(Auth::user('display_name') ?? Auth::user('username') ?? '') ?></span>
            </div>
        </header>

        <div class="admin-content">
            <?php $flash = getFlash(); ?>
            <?php if ($flash): ?>
            <div class="alert alert-<?= e($flash['type']) ?>" role="alert"><?= e($flash['message']) ?></div>
            <?php endif; ?>
