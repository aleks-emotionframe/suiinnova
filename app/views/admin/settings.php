<?php require APP_PATH . '/views/admin/_layout_top.php'; ?>

<div class="admin-header">
    <h1 class="admin-title">Einstellungen</h1>
</div>

<form method="post" action="<?= SITE_URL . ADMIN_PATH ?>/settings" class="admin-form">
    <input type="hidden" name="<?= CSRF_TOKEN_NAME ?>" value="<?= Auth::generateCsrfToken() ?>">

    <div class="form-card">
        <h2 class="form-card-title">Allgemein</h2>
        <div class="form-field">
            <label for="site_name" class="form-label">Firmenname</label>
            <input type="text" id="site_name" name="site_name" class="form-input" value="<?= e($settings['site_name'] ?? '') ?>">
        </div>
        <div class="form-field">
            <label for="site_tagline" class="form-label">Slogan</label>
            <input type="text" id="site_tagline" name="site_tagline" class="form-input" value="<?= e($settings['site_tagline'] ?? '') ?>">
        </div>
        <div class="form-field">
            <label for="footer_text" class="form-label">Footer-Text</label>
            <input type="text" id="footer_text" name="footer_text" class="form-input" value="<?= e($settings['footer_text'] ?? '') ?>">
        </div>
    </div>

    <div class="form-card">
        <h2 class="form-card-title">Kontakt</h2>
        <div class="form-row">
            <div class="form-field">
                <label for="site_email" class="form-label">E-Mail</label>
                <input type="email" id="site_email" name="site_email" class="form-input" value="<?= e($settings['site_email'] ?? '') ?>">
            </div>
            <div class="form-field">
                <label for="site_phone" class="form-label">Telefon</label>
                <input type="text" id="site_phone" name="site_phone" class="form-input" value="<?= e($settings['site_phone'] ?? '') ?>">
            </div>
        </div>
        <div class="form-field">
            <label for="site_address" class="form-label">Adresse</label>
            <textarea id="site_address" name="site_address" class="form-input" rows="2"><?= e($settings['site_address'] ?? '') ?></textarea>
        </div>
        <div class="form-field">
            <label for="contact_email" class="form-label">Kontaktformular E-Mail (Empfänger)</label>
            <input type="email" id="contact_email" name="contact_email" class="form-input" value="<?= e($settings['contact_email'] ?? '') ?>">
            <small class="form-hint">An diese Adresse werden Kontaktanfragen gesendet.</small>
        </div>
    </div>

    <div class="form-card">
        <h2 class="form-card-title">Karte</h2>
        <div class="form-field">
            <label for="google_maps_embed" class="form-label">Google Maps Embed URL</label>
            <input type="text" id="google_maps_embed" name="google_maps_embed" class="form-input" value="<?= e($settings['google_maps_embed'] ?? '') ?>" placeholder="https://www.google.com/maps/embed?...">
            <small class="form-hint">Embed-URL von Google Maps (optional).</small>
        </div>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Einstellungen speichern</button>
    </div>
</form>

<?php require APP_PATH . '/views/admin/_layout_bottom.php'; ?>
