<?php require APP_PATH . '/views/admin/_layout_top.php'; ?>
<?php $isNew = !isset($block['id']); ?>

<div class="admin-header">
    <h1 class="admin-title"><?= $isNew ? 'Neuer Inhaltsblock' : 'Inhalt bearbeiten' ?></h1>
    <a href="<?= SITE_URL . ADMIN_PATH ?>/pages/<?= $block['page_id'] ?? '' ?>" class="btn btn-sm btn-outline">&larr; Zurück zur Seite</a>
</div>

<?php if (!$isNew): ?>
<p class="admin-subtitle">Seite: <strong><?= e($block['page_title'] ?? '') ?></strong> &middot; Sektion: <code><?= e($block['section_key'] ?? '') ?></code></p>
<?php endif; ?>

<form method="post" action="<?= $isNew ? SITE_URL . ADMIN_PATH . '/pages/' . ($block['page_id'] ?? '') . '/content/new' : SITE_URL . ADMIN_PATH . '/content/' . $block['id'] ?>" enctype="multipart/form-data" class="admin-form">
    <input type="hidden" name="<?= CSRF_TOKEN_NAME ?>" value="<?= Auth::generateCsrfToken() ?>">
    <?php if (!$isNew): ?>
    <input type="hidden" name="existing_image" value="<?= e($block['image_path'] ?? '') ?>">
    <?php endif; ?>

    <div class="form-card">
        <?php if ($isNew): ?>
        <div class="form-field">
            <label for="section_key" class="form-label">Sektions-Schlüssel</label>
            <input type="text" id="section_key" name="section_key" class="form-input" placeholder="z.B. hero, intro, custom_1">
            <small class="form-hint">Eindeutiger Schlüssel für diesen Inhaltsblock.</small>
        </div>
        <?php endif; ?>

        <div class="form-field">
            <label for="title" class="form-label">Titel</label>
            <input type="text" id="title" name="title" class="form-input" value="<?= e($block['title'] ?? '') ?>">
        </div>

        <div class="form-field">
            <label for="subtitle" class="form-label">Untertitel</label>
            <input type="text" id="subtitle" name="subtitle" class="form-input" value="<?= e($block['subtitle'] ?? '') ?>">
        </div>

        <div class="form-field">
            <label for="content" class="form-label">Inhalt</label>
            <textarea id="content" name="content" class="form-input form-textarea" rows="8"><?= e($block['content'] ?? '') ?></textarea>
            <small class="form-hint">Text-Inhalt für diesen Block.</small>
        </div>

        <div class="form-field">
            <label for="image" class="form-label">Bild</label>
            <?php if (!empty($block['image_path'])): ?>
            <div class="current-image">
                <img src="<?= e($block['image_path']) ?>" alt="" style="max-width: 200px; max-height: 150px;">
                <small>Aktuelles Bild</small>
            </div>
            <?php endif; ?>
            <input type="file" id="image" name="image" class="form-input-file" accept="image/jpeg,image/png,image/webp,image/svg+xml">
            <small class="form-hint">JPG, PNG, WebP oder SVG. Max. 5 MB.</small>
        </div>

        <div class="form-row">
            <div class="form-field">
                <label for="link_url" class="form-label">Link URL</label>
                <input type="text" id="link_url" name="link_url" class="form-input" value="<?= e($block['link_url'] ?? '') ?>">
            </div>
            <div class="form-field">
                <label for="link_text" class="form-label">Link Text</label>
                <input type="text" id="link_text" name="link_text" class="form-input" value="<?= e($block['link_text'] ?? '') ?>">
            </div>
        </div>

        <div class="form-field">
            <label class="form-checkbox">
                <input type="checkbox" name="is_active" value="1" <?= ($block['is_active'] ?? 1) ? 'checked' : '' ?>>
                <span>Block aktiv</span>
            </label>
        </div>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Speichern</button>
        <?php if (!$isNew): ?>
        <form method="post" action="<?= SITE_URL . ADMIN_PATH ?>/content/<?= $block['id'] ?>/delete" class="inline-form" onsubmit="return confirm('Inhalt wirklich löschen?')">
            <input type="hidden" name="<?= CSRF_TOKEN_NAME ?>" value="<?= Auth::generateCsrfToken() ?>">
            <button type="submit" class="btn btn-danger btn-sm">Löschen</button>
        </form>
        <?php endif; ?>
    </div>
</form>

<?php require APP_PATH . '/views/admin/_layout_bottom.php'; ?>
