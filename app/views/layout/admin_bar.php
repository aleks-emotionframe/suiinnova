<?php if (isset($page) && is_array($page) && (int)($page['is_active'] ?? 1) === 0): ?>
<div class="cms-offline-banner">
    <div class="cms-offline-banner-inner">
        <span class="cms-offline-banner-dot"></span>
        <strong>Offline für Besucher</strong>
        <span>Diese Seite ist deaktiviert – nur Sie als Admin sehen sie. Besucher erhalten eine „Seite wird überarbeitet“-Meldung.</span>
        <form method="post" action="<?= SITE_URL . ADMIN_PATH ?>/pages/<?= (int)$page['id'] ?>/toggle" class="cms-offline-banner-form">
            <input type="hidden" name="<?= CSRF_TOKEN_NAME ?>" value="<?= Auth::generateCsrfToken() ?>">
            <input type="hidden" name="return" value="<?= e($_SERVER['REQUEST_URI'] ?? '/') ?>">
            <button type="submit" class="cms-offline-banner-btn">Jetzt online stellen</button>
        </form>
    </div>
</div>
<?php endif; ?>
<div class="cms-toolbar" id="cms-toolbar">
    <div class="cms-toolbar-inner">
        <span class="cms-toolbar-brand">SUI CMS</span>
        <nav class="cms-toolbar-nav">
            <a href="<?= SITE_URL ?>/" class="cms-toolbar-link">Startseite</a>
            <a href="<?= pageUrl('kompetenzen') ?>" class="cms-toolbar-link">Kompetenzen</a>
            <a href="<?= pageUrl('referenzen') ?>" class="cms-toolbar-link">Referenzen</a>
            <a href="<?= pageUrl('unternehmen') ?>" class="cms-toolbar-link">Unternehmen</a>
            <a href="<?= pageUrl('kontakt') ?>" class="cms-toolbar-link">Kontakt</a>
        </nav>
        <div class="cms-toolbar-actions">
            <?php if (isset($page) && is_array($page) && !empty($page['id']) && (int)($page['is_active'] ?? 1) === 1 && ($page['slug'] ?? '') !== 'startseite'): ?>
            <form method="post" action="<?= SITE_URL . ADMIN_PATH ?>/pages/<?= (int)$page['id'] ?>/toggle" class="cms-toolbar-inline-form">
                <input type="hidden" name="<?= CSRF_TOKEN_NAME ?>" value="<?= Auth::generateCsrfToken() ?>">
                <input type="hidden" name="return" value="<?= e($_SERVER['REQUEST_URI'] ?? '/') ?>">
                <button type="submit" class="cms-toolbar-btn cms-toolbar-btn-offline" title="Seite für Besucher deaktivieren, um daran zu arbeiten">Seite offline nehmen</button>
            </form>
            <?php endif; ?>
            <a href="<?= SITE_URL ?>/admin/references" class="cms-toolbar-btn">Referenzen verwalten</a>
            <a href="<?= SITE_URL ?>/admin/messages" class="cms-toolbar-btn">Nachrichten<?php
                try { $unread = Database::getInstance()->query('SELECT COUNT(*) FROM contact_messages WHERE is_read = 0')->fetchColumn();
                    if ($unread > 0) echo ' <span class="cms-badge">' . $unread . '</span>';
                } catch (Exception $e) {} ?></a>
            <a href="<?= SITE_URL ?>/admin/settings" class="cms-toolbar-btn">Einstellungen</a>
            <a href="<?= SITE_URL ?>/admin/logout" class="cms-toolbar-btn cms-toolbar-btn-logout">Abmelden</a>
        </div>
    </div>
</div>
