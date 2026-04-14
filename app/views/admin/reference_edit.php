<?php require APP_PATH . '/views/admin/_layout_top.php'; ?>
<?php $isNew = empty($ref); ?>

<div class="admin-header">
    <h1 class="admin-title"><?= $isNew ? 'Neue Referenz' : 'Referenz bearbeiten: ' . e($ref['title']) ?></h1>
    <a href="<?= SITE_URL . ADMIN_PATH ?>/references" class="btn btn-sm btn-outline">&larr; Zurück</a>
</div>

<form method="post" action="<?= SITE_URL . ADMIN_PATH ?>/references/<?= $isNew ? 'new' : $ref['id'] ?>" enctype="multipart/form-data" class="admin-form">
    <input type="hidden" name="<?= CSRF_TOKEN_NAME ?>" value="<?= Auth::generateCsrfToken() ?>">
    <?php if (!$isNew): ?>
    <input type="hidden" name="existing_image" value="<?= e($ref['image_path'] ?? '') ?>">
    <?php endif; ?>

    <div class="form-card">
        <div class="form-field">
            <label for="title" class="form-label">Projektname</label>
            <input type="text" id="title" name="title" class="form-input" required value="<?= e($ref['title'] ?? '') ?>">
        </div>

        <div class="form-row">
            <div class="form-field">
                <label for="client" class="form-label">Auftraggeber</label>
                <input type="text" id="client" name="client" class="form-input" value="<?= e($ref['client'] ?? '') ?>">
            </div>
            <div class="form-field">
                <label for="location" class="form-label">Standort</label>
                <input type="text" id="location" name="location" class="form-input" value="<?= e($ref['location'] ?? '') ?>">
            </div>
        </div>

        <div class="form-row">
            <div class="form-field">
                <label for="year" class="form-label">Jahr</label>
                <input type="number" id="year" name="year" class="form-input" min="2000" max="2099" value="<?= e($ref['year'] ?? date('Y')) ?>">
            </div>
            <div class="form-field">
                <label for="category" class="form-label">Kategorie</label>
                <input type="text" id="category" name="category" class="form-input" value="<?= e($ref['category'] ?? '') ?>" placeholder="z.B. Wohnbau, Gewerbebau, Spitalbau">
            </div>
        </div>

        <div class="form-field">
            <label for="description" class="form-label">Beschreibung</label>
            <textarea id="description" name="description" class="form-input form-textarea" rows="5"><?= e($ref['description'] ?? '') ?></textarea>
        </div>

        <div class="form-field">
            <label for="image" class="form-label">Projektbild</label>
            <?php if (!empty($ref['image_path'])): ?>
            <div class="current-image">
                <img src="<?= e($ref['image_path']) ?>" alt="" style="max-width: 200px; max-height: 150px;">
            </div>
            <?php endif; ?>
            <input type="file" id="image" name="image" class="form-input-file" accept="image/jpeg,image/png,image/webp">
        </div>

        <div class="form-row">
            <div class="form-field">
                <label class="form-checkbox">
                    <input type="checkbox" name="is_active" value="1" <?= ($ref['is_active'] ?? 1) ? 'checked' : '' ?>>
                    <span>Aktiv</span>
                </label>
            </div>
            <div class="form-field">
                <label class="form-checkbox">
                    <input type="checkbox" name="is_featured" value="1" <?= ($ref['is_featured'] ?? 0) ? 'checked' : '' ?>>
                    <span>Auf Startseite anzeigen (Featured)</span>
                </label>
            </div>
        </div>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Speichern</button>
        <?php if (!$isNew): ?>
        <form method="post" action="<?= SITE_URL . ADMIN_PATH ?>/references/<?= $ref['id'] ?>/delete" class="inline-form" onsubmit="return confirm('Referenz wirklich löschen?')">
            <input type="hidden" name="<?= CSRF_TOKEN_NAME ?>" value="<?= Auth::generateCsrfToken() ?>">
            <button type="submit" class="btn btn-danger btn-sm">Löschen</button>
        </form>
        <?php endif; ?>
    </div>
</form>

<?php require APP_PATH . '/views/admin/_layout_bottom.php'; ?>
