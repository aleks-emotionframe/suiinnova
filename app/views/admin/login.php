<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anmeldung – SUI Innova CMS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@500;700&family=Outfit:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/admin.css">
</head>
<body class="login-page">
    <div class="login-wrapper">
        <div class="login-card">
            <div class="login-logo">
                <span class="logo-mark">SUI</span>
                <span class="logo-text">Innova</span>
            </div>
            <h1 class="login-title">Administration</h1>

            <?php if (!empty($error)): ?>
            <div class="alert alert-error" role="alert"><?= e($error) ?></div>
            <?php endif; ?>

            <form method="post" action="<?= SITE_URL . ADMIN_PATH ?>/login" class="login-form">
                <input type="hidden" name="<?= CSRF_TOKEN_NAME ?>" value="<?= Auth::generateCsrfToken() ?>">

                <div class="form-field">
                    <label for="username" class="form-label">Benutzername</label>
                    <input type="text" id="username" name="username" class="form-input" required autofocus autocomplete="username">
                </div>

                <div class="form-field">
                    <label for="password" class="form-label">Passwort</label>
                    <input type="password" id="password" name="password" class="form-input" required autocomplete="current-password">
                </div>

                <button type="submit" class="btn btn-primary btn-full">Anmelden</button>
            </form>

            <a href="<?= SITE_URL ?>/" class="login-back">&larr; Zurück zur Website</a>
        </div>
    </div>
</body>
</html>
