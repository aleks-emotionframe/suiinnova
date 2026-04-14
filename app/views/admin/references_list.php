<?php require APP_PATH . '/views/admin/_layout_top.php'; ?>

<div class="admin-header">
    <h1 class="admin-title">Referenzen</h1>
    <a href="<?= SITE_URL . ADMIN_PATH ?>/references/new" class="btn btn-primary btn-sm">+ Neue Referenz</a>
</div>

<?php if (empty($references)): ?>
    <p class="empty-state">Noch keine Referenzen vorhanden.</p>
<?php else: ?>
<div class="table-wrapper">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Projekt</th>
                <th>Kunde</th>
                <th>Ort</th>
                <th>Jahr</th>
                <th>Kategorie</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($references as $ref): ?>
            <tr>
                <td><strong><?= e($ref['title']) ?></strong></td>
                <td><?= e($ref['client'] ?? '–') ?></td>
                <td><?= e($ref['location'] ?? '–') ?></td>
                <td><?= e($ref['year'] ?? '–') ?></td>
                <td><?= e($ref['category'] ?? '–') ?></td>
                <td>
                    <span class="badge <?= $ref['is_active'] ? 'badge-success' : 'badge-muted' ?>"><?= $ref['is_active'] ? 'Aktiv' : 'Inaktiv' ?></span>
                    <?php if ($ref['is_featured']): ?><span class="badge badge-accent">Featured</span><?php endif; ?>
                </td>
                <td><a href="<?= SITE_URL . ADMIN_PATH ?>/references/<?= $ref['id'] ?>" class="btn btn-sm btn-ghost">Bearbeiten</a></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>

<?php require APP_PATH . '/views/admin/_layout_bottom.php'; ?>
