<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — <?= e(setting('site_name', SITE_NAME)) ?></title>
    <link rel="preload" href="<?= asset('fonts/Inter-Regular.woff2') ?>" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="<?= asset('fonts/Inter-Medium.woff2') ?>" as="font" type="font/woff2" crossorigin>
    <link rel="stylesheet" href="<?= asset('css/admin.css') ?>">
</head>
<body class="font-sans bg-gray-50 antialiased min-h-screen flex items-center justify-center">

    <div class="w-full max-w-sm px-4">
        <!-- Logo -->
        <div class="text-center mb-10">
            <img src="<?= asset('img/SUI-Innova_Logo.webp') ?>" alt="SUI Innova" class="h-10 mx-auto mb-4">
            <p class="text-xs uppercase tracking-widest text-gray-400 font-medium">Admin-Bereich</p>
        </div>

        <!-- Login Form -->
        <div class="admin-card">
            <?php if (!empty($loginError)): ?>
                <div class="mb-4 px-3 py-2 bg-brand-accent/10 text-brand-accent text-sm border-l-2 border-brand-accent">
                    <?= e($loginError) ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?= url('admin/login') ?>" class="space-y-5">
                <?= csrfField() ?>

                <div>
                    <label for="username" class="admin-label">Benutzername</label>
                    <input type="text" name="username" id="username"
                           value="<?= e($_POST['username'] ?? '') ?>"
                           placeholder="admin" required autofocus
                           class="admin-input">
                </div>

                <div>
                    <label for="password" class="admin-label">Passwort</label>
                    <input type="password" name="password" id="password"
                           placeholder="••••••••" required
                           class="admin-input">
                </div>

                <button type="submit" class="w-full admin-btn-primary h-10 text-sm uppercase tracking-wider">
                    Anmelden
                </button>
            </form>
        </div>

        <p class="text-center text-xs text-gray-400 mt-6">
            <a href="<?= url() ?>" class="hover:text-gray-600 transition-colors duration-200">
                ← Zurück zur Website
            </a>
        </p>
    </div>

</body>
</html>
