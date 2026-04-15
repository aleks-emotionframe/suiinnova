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
