<?php require APP_PATH . '/views/admin/_layout_top.php'; ?>

<div class="admin-header">
    <h1 class="admin-title">Seiten</h1>
    <a href="<?= SITE_URL . ADMIN_PATH ?>/pages/new" class="btn btn-primary btn-sm">+ Neue Seite</a>
</div>

<div class="table-wrapper">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Titel</th>
                <th>Slug</th>
                <th>Status</th>
                <th>Navigation</th>
                <th>Reihenfolge</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pages as $p): ?>
            <tr>
                <td><strong><?= e($p['title']) ?></strong></td>
                <td><code>/<?= e($p['slug']) ?></code></td>
                <td><span class="badge <?= $p['is_active'] ? 'badge-success' : 'badge-muted' ?>"><?= $p['is_active'] ? 'Aktiv' : 'Inaktiv' ?></span></td>
                <td><?= $p['is_in_nav'] ? 'Ja' : 'Nein' ?></td>
                <td><?= (int)$p['sort_order'] ?></td>
                <td>
                    <a href="<?= SITE_URL . ADMIN_PATH ?>/pages/<?= $p['id'] ?>" class="btn btn-sm btn-ghost">Bearbeiten</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require APP_PATH . '/views/admin/_layout_bottom.php'; ?>
