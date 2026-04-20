<?php require APP_PATH . '/views/admin/_layout_top.php'; ?>

<div class="admin-header">
    <h1 class="admin-title"><?= $page ? 'Seite bearbeiten: ' . e($page['title']) : 'Neue Seite' ?></h1>
    <a href="<?= SITE_URL . ADMIN_PATH ?>/pages" class="btn btn-sm btn-outline">&larr; Zurück</a>
</div>

<form method="post" action="<?= SITE_URL . ADMIN_PATH ?>/pages/<?= $page ? $page['id'] : 'new' ?>" class="admin-form">
    <input type="hidden" name="<?= CSRF_TOKEN_NAME ?>" value="<?= Auth::generateCsrfToken() ?>">

    <div class="form-card">
        <div class="form-field">
            <label for="title" class="form-label">Seitentitel</label>
            <input type="text" id="title" name="title" class="form-input" required value="<?= e($page['title'] ?? '') ?>">
        </div>

        <?php if ($page): ?>
        <div class="form-field">
            <label class="form-label">Slug</label>
            <input type="text" class="form-input" value="/<?= e($page['slug'] ?? '') ?>" disabled>
            <small class="form-hint">Der Slug kann nicht geändert werden.</small>
        </div>
        <?php endif; ?>

        <div class="form-field">
            <label for="meta_description" class="form-label">Meta-Beschreibung</label>
            <textarea id="meta_description" name="meta_description" class="form-input" rows="3"><?= e($page['meta_description'] ?? '') ?></textarea>
            <small class="form-hint">Für Suchmaschinen, max. 160 Zeichen.</small>
        </div>

        <div class="form-field">
            <label for="meta_keywords" class="form-label">Meta-Keywords</label>
            <input type="text" id="meta_keywords" name="meta_keywords" class="form-input" value="<?= e($page['meta_keywords'] ?? '') ?>">
        </div>

        <div class="form-row">
            <div class="form-field">
                <?php $isHome = ($page['slug'] ?? '') === 'startseite'; ?>
                <label class="form-checkbox">
                    <input type="checkbox" name="is_active" value="1" <?= ($page['is_active'] ?? 1) ? 'checked' : '' ?> <?= $isHome ? 'disabled' : '' ?>>
                    <span>Seite aktiv<?= $isHome ? ' (Startseite ist immer online)' : '' ?></span>
                </label>
                <?php if ($isHome): ?><input type="hidden" name="is_active" value="1"><?php endif; ?>
            </div>
            <div class="form-field">
                <label class="form-checkbox">
                    <input type="checkbox" name="is_in_nav" value="1" <?= ($page['is_in_nav'] ?? 1) ? 'checked' : '' ?>>
                    <span>In Navigation anzeigen</span>
                </label>
            </div>
        </div>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Speichern</button>
        <?php if ($page): ?>
            <?php
            $protected = ['startseite', 'kompetenzen', 'referenzen', 'unternehmen', 'kontakt'];
            if (!in_array($page['slug'], $protected)):
            ?>
            <form method="post" action="<?= SITE_URL . ADMIN_PATH ?>/pages/<?= $page['id'] ?>/delete" class="inline-form" onsubmit="return confirm('Seite wirklich löschen?')">
                <input type="hidden" name="<?= CSRF_TOKEN_NAME ?>" value="<?= Auth::generateCsrfToken() ?>">
                <button type="submit" class="btn btn-danger btn-sm">Löschen</button>
            </form>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</form>

<?php if ($page && !empty($contentBlocks)): ?>
<!-- Content Blocks for this page -->
<div class="admin-section" style="margin-top: 2rem;">
    <div class="admin-section-header">
        <h2 class="admin-section-title">Inhaltsblöcke</h2>
        <a href="<?= SITE_URL . ADMIN_PATH ?>/pages/<?= $page['id'] ?>/content/new" class="btn btn-sm btn-outline">+ Neuer Block</a>
    </div>
    <div class="table-wrapper">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Sektion</th>
                    <th>Titel</th>
                    <th>Status</th>
                    <th>Reihenfolge</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($contentBlocks as $cb): ?>
                <tr>
                    <td><code><?= e($cb['section_key']) ?></code></td>
                    <td><?= e($cb['title'] ?? '–') ?></td>
                    <td><span class="badge <?= $cb['is_active'] ? 'badge-success' : 'badge-muted' ?>"><?= $cb['is_active'] ? 'Aktiv' : 'Inaktiv' ?></span></td>
                    <td><?= (int)$cb['sort_order'] ?></td>
                    <td><a href="<?= SITE_URL . ADMIN_PATH ?>/content/<?= $cb['id'] ?>" class="btn btn-sm btn-ghost">Bearbeiten</a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php elseif ($page): ?>
<div class="admin-section" style="margin-top: 2rem;">
    <div class="admin-section-header">
        <h2 class="admin-section-title">Inhaltsblöcke</h2>
        <a href="<?= SITE_URL . ADMIN_PATH ?>/pages/<?= $page['id'] ?>/content/new" class="btn btn-sm btn-outline">+ Neuer Block</a>
    </div>
    <p class="empty-state">Noch keine Inhaltsblöcke vorhanden.</p>
</div>
<?php endif; ?>

<?php require APP_PATH . '/views/admin/_layout_bottom.php'; ?>
