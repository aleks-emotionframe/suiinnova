<?php
/**
 * SUI Innova GmbH — Installation Script
 * Run once to set up the database, then DELETE this file.
 *
 * Usage: Open https://yourdomain.ch/install.php in your browser.
 */

$pageTitle = 'Installation – SUI Innova';
$success = false;
$error = '';
$step = $_POST['step'] ?? 'form';

if ($step === 'install') {
    $host = trim($_POST['db_host'] ?? 'localhost');
    $name = trim($_POST['db_name'] ?? '');
    $user = trim($_POST['db_user'] ?? '');
    $pass = $_POST['db_pass'] ?? '';
    $adminUser = trim($_POST['admin_user'] ?? 'admin');
    $adminEmail = trim($_POST['admin_email'] ?? '');
    $adminPass = $_POST['admin_pass'] ?? '';

    if (empty($name) || empty($user) || empty($adminUser) || empty($adminEmail) || empty($adminPass)) {
        $error = 'Bitte alle Pflichtfelder ausfüllen.';
        $step = 'form';
    } elseif (strlen($adminPass) < 8) {
        $error = 'Das Admin-Passwort muss mindestens 8 Zeichen haben.';
        $step = 'form';
    } else {
        try {
            // Connect
            $dsn = "mysql:host={$host};charset=utf8mb4";
            $pdo = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ]);

            // Create database if not exists
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$name}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            $pdo->exec("USE `{$name}`");

            // Read and execute schema (without the CREATE DATABASE and USE lines, and without the INSERT for default admin)
            $schemaFile = __DIR__ . '/database/schema.sql';
            if (!file_exists($schemaFile)) {
                throw new Exception('schema.sql nicht gefunden. Stellen Sie sicher, dass die Datei unter /database/schema.sql liegt.');
            }

            $sql = file_get_contents($schemaFile);

            // Remove CREATE DATABASE and USE lines (we handle them above)
            $sql = preg_replace('/^CREATE DATABASE.*$/m', '', $sql);
            $sql = preg_replace('/^USE .*$/m', '', $sql);

            // Remove the default admin INSERT (we create our own)
            $sql = preg_replace("/INSERT INTO `users`.*?;/s", '', $sql, 1);

            // Execute schema
            $statements = array_filter(array_map('trim', explode(';', $sql)));
            foreach ($statements as $stmt) {
                if (!empty($stmt) && $stmt !== '--') {
                    $pdo->exec($stmt);
                }
            }

            // Create admin user with provided credentials
            $hash = password_hash($adminPass, PASSWORD_DEFAULT);
            $insertAdmin = $pdo->prepare('INSERT INTO users (username, email, password_hash, display_name) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE password_hash = VALUES(password_hash), email = VALUES(email)');
            $insertAdmin->execute([$adminUser, $adminEmail, $hash, 'Administrator']);

            // Update config file with DB settings
            $configFile = __DIR__ . '/app/config.php';
            if (file_exists($configFile)) {
                $config = file_get_contents($configFile);
                $config = preg_replace("/define\('DB_HOST',\s*'[^']*'\)/", "define('DB_HOST', '{$host}')", $config);
                $config = preg_replace("/define\('DB_NAME',\s*'[^']*'\)/", "define('DB_NAME', '{$name}')", $config);
                $config = preg_replace("/define\('DB_USER',\s*'[^']*'\)/", "define('DB_USER', '{$user}')", $config);
                $config = preg_replace("/define\('DB_PASS',\s*'[^']*'\)/", "define('DB_PASS', '{$pass}')", $config);
                file_put_contents($configFile, $config);
            }

            $success = true;

        } catch (PDOException $e) {
            $error = 'Datenbankfehler: ' . $e->getMessage();
            $step = 'form';
        } catch (Exception $e) {
            $error = $e->getMessage();
            $step = 'form';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@500;700&family=Outfit:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Outfit', sans-serif; background: #0f1923; color: #f6f3ef; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 2rem; }
        .card { background: #fff; color: #1a1a1a; border-radius: 12px; padding: 2.5rem; max-width: 520px; width: 100%; box-shadow: 0 16px 48px rgba(0,0,0,0.3); }
        .logo { font-family: 'Syne', sans-serif; font-weight: 800; font-size: 1.5rem; color: #c49a3c; margin-bottom: 0.3rem; }
        .logo span { font-weight: 500; color: #1a1a1a; font-size: 1.1rem; }
        h1 { font-family: 'Syne', sans-serif; font-size: 1.3rem; margin-bottom: 1.5rem; color: #5a5650; font-weight: 500; }
        .field { margin-bottom: 1rem; }
        label { display: block; font-size: 0.85rem; font-weight: 500; margin-bottom: 0.3rem; }
        input { width: 100%; padding: 0.6rem 0.8rem; border: 1px solid #d5cfc7; border-radius: 6px; font-size: 0.95rem; font-family: inherit; }
        input:focus { border-color: #c49a3c; outline: none; box-shadow: 0 0 0 3px rgba(196,154,60,0.12); }
        .sep { border: none; border-top: 1px solid #eee; margin: 1.5rem 0; }
        .btn { display: block; width: 100%; padding: 0.8rem; background: #c49a3c; color: #0f1923; border: none; border-radius: 6px; font-size: 0.95rem; font-weight: 600; cursor: pointer; font-family: inherit; margin-top: 1rem; }
        .btn:hover { background: #d4aa4c; }
        .error { background: rgba(176,58,46,0.1); color: #b03a2e; padding: 0.75rem; border-radius: 6px; margin-bottom: 1rem; font-size: 0.85rem; }
        .success { background: rgba(45,122,79,0.1); color: #2d7a4f; padding: 1rem; border-radius: 6px; line-height: 1.6; font-size: 0.9rem; }
        .success strong { display: block; font-size: 1.1rem; margin-bottom: 0.5rem; }
        .warn { background: rgba(196,154,60,0.12); color: #8a6f2a; padding: 0.75rem; border-radius: 6px; margin-top: 1rem; font-size: 0.8rem; }
        small { color: #999; font-size: 0.75rem; }
    </style>
</head>
<body>
    <div class="card">
        <div class="logo">SUI <span>Innova</span></div>

        <?php if ($success): ?>
            <div class="success">
                <strong>Installation erfolgreich!</strong>
                Die Datenbank wurde eingerichtet und der Admin-Benutzer wurde erstellt.<br><br>
                <a href="/admin/login" style="color: #c49a3c; font-weight: 600;">Zum Admin-Login &rarr;</a>
            </div>
            <div class="warn">
                <strong>Wichtig:</strong> Löschen Sie diese Datei (install.php) jetzt aus Sicherheitsgründen!
            </div>
        <?php else: ?>
            <h1>Installation</h1>

            <?php if ($error): ?>
                <div class="error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="post">
                <input type="hidden" name="step" value="install">

                <div class="field">
                    <label for="db_host">Datenbank-Host</label>
                    <input type="text" id="db_host" name="db_host" value="<?= htmlspecialchars($_POST['db_host'] ?? 'localhost') ?>">
                    <small>Bei Hostpoint meist: localhost</small>
                </div>
                <div class="field">
                    <label for="db_name">Datenbank-Name *</label>
                    <input type="text" id="db_name" name="db_name" value="<?= htmlspecialchars($_POST['db_name'] ?? '') ?>" required>
                </div>
                <div class="field">
                    <label for="db_user">Datenbank-Benutzer *</label>
                    <input type="text" id="db_user" name="db_user" value="<?= htmlspecialchars($_POST['db_user'] ?? '') ?>" required>
                </div>
                <div class="field">
                    <label for="db_pass">Datenbank-Passwort</label>
                    <input type="password" id="db_pass" name="db_pass">
                </div>

                <hr class="sep">

                <div class="field">
                    <label for="admin_user">Admin Benutzername *</label>
                    <input type="text" id="admin_user" name="admin_user" value="<?= htmlspecialchars($_POST['admin_user'] ?? 'admin') ?>" required>
                </div>
                <div class="field">
                    <label for="admin_email">Admin E-Mail *</label>
                    <input type="email" id="admin_email" name="admin_email" value="<?= htmlspecialchars($_POST['admin_email'] ?? '') ?>" required>
                </div>
                <div class="field">
                    <label for="admin_pass">Admin Passwort *</label>
                    <input type="password" id="admin_pass" name="admin_pass" required minlength="8">
                    <small>Mindestens 8 Zeichen</small>
                </div>

                <button type="submit" class="btn">Installation starten</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
