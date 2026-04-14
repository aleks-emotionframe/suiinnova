<?php require APP_PATH . '/views/admin/_layout_top.php'; ?>

<div class="admin-header">
    <h1 class="admin-title">Passwort ändern</h1>
</div>

<form method="post" action="<?= SITE_URL . ADMIN_PATH ?>/password" class="admin-form">
    <input type="hidden" name="<?= CSRF_TOKEN_NAME ?>" value="<?= Auth::generateCsrfToken() ?>">

    <div class="form-card" style="max-width: 500px;">
        <div class="form-field">
            <label for="current_password" class="form-label">Aktuelles Passwort</label>
            <input type="password" id="current_password" name="current_password" class="form-input" required autocomplete="current-password">
        </div>
        <div class="form-field">
            <label for="new_password" class="form-label">Neues Passwort</label>
            <input type="password" id="new_password" name="new_password" class="form-input" required autocomplete="new-password" minlength="8">
            <small class="form-hint">Mindestens 8 Zeichen.</small>
        </div>
        <div class="form-field">
            <label for="confirm_password" class="form-label">Passwort bestätigen</label>
            <input type="password" id="confirm_password" name="confirm_password" class="form-input" required autocomplete="new-password">
        </div>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Passwort ändern</button>
    </div>
</form>

<?php require APP_PATH . '/views/admin/_layout_bottom.php'; ?>
