<?php require APP_PATH . '/views/admin/_layout_top.php'; ?>

<div class="admin-header">
    <h1 class="admin-title">Dashboard</h1>
    <p class="admin-subtitle">Willkommen, <?= e(Auth::user('display_name') ?? Auth::user('username') ?? 'Admin') ?></p>
</div>

<!-- Stats -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon stat-icon-pages">
            <svg viewBox="0 0 24 24" fill="none"><path d="M4 4h16v16H4z" stroke="currentColor" stroke-width="1.5"/><path d="M8 8h8M8 12h6M8 16h4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
        </div>
        <div class="stat-info">
            <span class="stat-number"><?= (int)$pageCount ?></span>
            <span class="stat-label">Seiten</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon stat-icon-refs">
            <svg viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="7" height="7" rx="1" stroke="currentColor" stroke-width="1.5"/><rect x="14" y="3" width="7" height="7" rx="1" stroke="currentColor" stroke-width="1.5"/><rect x="3" y="14" width="7" height="7" rx="1" stroke="currentColor" stroke-width="1.5"/><rect x="14" y="14" width="7" height="7" rx="1" stroke="currentColor" stroke-width="1.5"/></svg>
        </div>
        <div class="stat-info">
            <span class="stat-number"><?= (int)$refCount ?></span>
            <span class="stat-label">Referenzen</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon stat-icon-msgs">
            <svg viewBox="0 0 24 24" fill="none"><rect x="2" y="4" width="20" height="16" rx="2" stroke="currentColor" stroke-width="1.5"/><path d="M2 7l10 7 10-7" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/></svg>
        </div>
        <div class="stat-info">
            <span class="stat-number"><?= (int)$msgCount ?></span>
            <span class="stat-label">Neue Nachrichten</span>
        </div>
    </div>
</div>

<!-- Recent Messages -->
<div class="admin-section">
    <div class="admin-section-header">
        <h2 class="admin-section-title">Neueste Nachrichten</h2>
        <a href="<?= SITE_URL . ADMIN_PATH ?>/messages" class="btn btn-sm btn-outline">Alle anzeigen</a>
    </div>
    <?php if (empty($recentMessages)): ?>
        <p class="empty-state">Keine Nachrichten vorhanden.</p>
    <?php else: ?>
    <div class="table-wrapper">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Name</th>
                    <th>Betreff</th>
                    <th>Datum</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recentMessages as $msg): ?>
                <tr class="<?= $msg['is_read'] ? '' : 'is-unread' ?>">
                    <td><span class="status-dot <?= $msg['is_read'] ? 'status-read' : 'status-unread' ?>"></span></td>
                    <td><?= e($msg['name']) ?></td>
                    <td><?= e($msg['subject'] ?? '–') ?></td>
                    <td><?= date('d.m.Y H:i', strtotime($msg['created_at'])) ?></td>
                    <td><a href="<?= SITE_URL . ADMIN_PATH ?>/messages/<?= $msg['id'] ?>" class="btn btn-sm btn-ghost">Ansehen</a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>

<?php require APP_PATH . '/views/admin/_layout_bottom.php'; ?>
