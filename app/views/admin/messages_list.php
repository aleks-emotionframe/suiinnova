<?php require APP_PATH . '/views/admin/_layout_top.php'; ?>

<div class="admin-header">
    <h1 class="admin-title">Nachrichten</h1>
</div>

<?php if (empty($messages)): ?>
    <p class="empty-state">Keine Nachrichten vorhanden.</p>
<?php else: ?>
<div class="table-wrapper">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Status</th>
                <th>Name</th>
                <th>E-Mail</th>
                <th>Betreff</th>
                <th>Datum</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($messages as $msg): ?>
            <tr class="<?= $msg['is_read'] ? '' : 'is-unread' ?>">
                <td><span class="status-dot <?= $msg['is_read'] ? 'status-read' : 'status-unread' ?>"></span></td>
                <td><?= e($msg['name']) ?></td>
                <td><a href="mailto:<?= e($msg['email']) ?>"><?= e($msg['email']) ?></a></td>
                <td><?= e($msg['subject'] ?? '–') ?></td>
                <td><?= date('d.m.Y H:i', strtotime($msg['created_at'])) ?></td>
                <td><a href="<?= SITE_URL . ADMIN_PATH ?>/messages/<?= $msg['id'] ?>" class="btn btn-sm btn-ghost">Ansehen</a></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>

<?php require APP_PATH . '/views/admin/_layout_bottom.php'; ?>
