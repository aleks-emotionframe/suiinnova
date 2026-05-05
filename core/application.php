<?php
/**
 * Bewerbungen — Handler fuer das Karriere-Formular.
 *
 * Dateien werden in /uploads/applications/ gespeichert.
 * In die DB wandert ein JSON-Array mit den relativen Pfaden.
 */

const APPLICATION_ALLOWED_EXT  = ['pdf', 'doc', 'docx', 'odt', 'jpg', 'jpeg', 'png', 'webp'];
const APPLICATION_MAX_FILE_MB  = 10;
const APPLICATION_MAX_FILES    = 5;

function handleApplicationSubmit(): void
{
    global $db;

    // ── Self-Heal: Tabelle anlegen falls noch nicht vorhanden ──
    try {
        $db->query("CREATE TABLE IF NOT EXISTS applications (
            id          INT AUTO_INCREMENT PRIMARY KEY,
            name        VARCHAR(255) NOT NULL,
            email       VARCHAR(255) NOT NULL,
            phone       VARCHAR(50)  DEFAULT NULL,
            position    VARCHAR(255) DEFAULT NULL,
            message     TEXT         DEFAULT NULL,
            files       TEXT         DEFAULT NULL,
            is_read     TINYINT(1)   NOT NULL DEFAULT 0,
            created_at  DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_created (created_at),
            INDEX idx_is_read (is_read)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    } catch (Exception $e) {}

    // ── Self-Heal: Upload-Ordner anlegen falls fehlt ──
    $uploadDir = BASE_PATH . '/uploads/applications';
    if (!is_dir($uploadDir)) {
        @mkdir($uploadDir, 0755, true);
        // .htaccess als Schutz fuer den Ordner
        @file_put_contents($uploadDir . '/.htaccess', "Options -Indexes\n<FilesMatch \"\\.(php|phtml|php[0-9]|phar)$\">\n    Require all denied\n</FilesMatch>\n");
    }

    if (!validateCsrf()) {
        setFlash('error', 'Sicherheitstoken abgelaufen. Bitte versuchen Sie es erneut.');
        redirectToHome();
    }

    $name     = trim($_POST['app_name'] ?? '');
    $email    = trim($_POST['app_email'] ?? '');
    $phone    = trim($_POST['app_phone'] ?? '');
    $position = trim($_POST['app_position'] ?? setting('career_position', ''));
    $message  = trim($_POST['app_message'] ?? '');

    // Honeypot
    if (!empty($_POST['website_url'])) {
        setFlash('success', 'Vielen Dank für Ihre Bewerbung.');
        redirectToHome();
    }

    // Zeit-Check
    $formLoadedAt = (int)($_POST['form_loaded_at'] ?? 0);
    if ($formLoadedAt > 0 && (time() - $formLoadedAt) < 3) {
        setFlash('success', 'Vielen Dank für Ihre Bewerbung.');
        redirectToHome();
    }

    // Pflichtfelder
    if ($name === '' || $email === '') {
        setFlash('error', 'Bitte Name und E-Mail angeben.');
        redirectToHome();
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        setFlash('error', 'Bitte eine gültige E-Mail-Adresse angeben.');
        redirectToHome();
    }

    // Laengenlimits
    if (mb_strlen($name) > 200 || mb_strlen($message) > 5000 || mb_strlen($position) > 255) {
        setFlash('error', 'Eingaben sind zu lang.');
        redirectToHome();
    }

    // Dateien validieren + speichern
    $savedFiles = [];
    if (!empty($_FILES['app_files']) && is_array($_FILES['app_files']['name'])) {
        $count = count($_FILES['app_files']['name']);
        if ($count > APPLICATION_MAX_FILES) {
            setFlash('error', 'Maximal ' . APPLICATION_MAX_FILES . ' Dateien erlaubt.');
            redirectToHome();
        }

        $uploadDir = BASE_PATH . '/uploads/applications';
        if (!is_dir($uploadDir)) {
            @mkdir($uploadDir, 0755, true);
        }

        for ($i = 0; $i < $count; $i++) {
            $err  = $_FILES['app_files']['error'][$i];
            $size = (int)$_FILES['app_files']['size'][$i];
            $tmp  = $_FILES['app_files']['tmp_name'][$i];
            $orig = $_FILES['app_files']['name'][$i];

            if ($err === UPLOAD_ERR_NO_FILE) continue;
            if ($err !== UPLOAD_ERR_OK) {
                setFlash('error', 'Ein Dokument konnte nicht hochgeladen werden (Fehlercode ' . $err . ').');
                cleanupApplicationFiles($savedFiles);
                redirectToHome();
            }
            if ($size > APPLICATION_MAX_FILE_MB * 1024 * 1024) {
                setFlash('error', 'Eine Datei ist zu gross (max. ' . APPLICATION_MAX_FILE_MB . ' MB).');
                cleanupApplicationFiles($savedFiles);
                redirectToHome();
            }

            $ext = strtolower(pathinfo($orig, PATHINFO_EXTENSION));
            if (!in_array($ext, APPLICATION_ALLOWED_EXT, true)) {
                setFlash('error', 'Dateityp nicht erlaubt: .' . e($ext) . ' (erlaubt: PDF, DOC, DOCX, ODT, JPG, PNG, WebP).');
                cleanupApplicationFiles($savedFiles);
                redirectToHome();
            }

            // Sicherer Dateiname
            $safeBase = preg_replace('/[^a-zA-Z0-9_\-.]/', '_', pathinfo($orig, PATHINFO_FILENAME));
            $safeBase = mb_substr($safeBase, 0, 60);
            $newName  = date('Ymd-His') . '_' . bin2hex(random_bytes(4)) . '_' . $safeBase . '.' . $ext;
            $target   = $uploadDir . '/' . $newName;

            if (!move_uploaded_file($tmp, $target)) {
                setFlash('error', 'Datei konnte nicht gespeichert werden.');
                cleanupApplicationFiles($savedFiles);
                redirectToHome();
            }

            $savedFiles[] = [
                'name' => $orig,
                'path' => 'applications/' . $newName,
                'size' => $size,
            ];
        }
    }

    // In DB speichern
    try {
        $db->insert('applications', [
            'name'       => $name,
            'email'      => $email,
            'phone'      => $phone,
            'position'   => $position,
            'message'    => $message,
            'files'      => json_encode($savedFiles, JSON_UNESCAPED_UNICODE),
            'is_read'    => 0,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    } catch (Exception $e) {
        cleanupApplicationFiles($savedFiles);
        // Fehler in Logfile schreiben (fuer Debugging)
        @file_put_contents(BASE_PATH . '/uploads/applications/_error.log',
            date('Y-m-d H:i:s') . ' — DB-Insert fehlgeschlagen: ' . $e->getMessage() . "\n",
            FILE_APPEND
        );
        setFlash('error', 'Ein technischer Fehler ist aufgetreten. Bitte versuchen Sie es später erneut.');
        redirectToHome();
    }

    // E-Mail-Benachrichtigung
    $receiver = setting('career_email', setting('contact_form_receiver', setting('contact_email', CONTACT_EMAIL)));
    if ($receiver && filter_var($receiver, FILTER_VALIDATE_EMAIL)) {
        $subject  = 'Neue Bewerbung: ' . $position;
        $fileList = '';
        foreach ($savedFiles as $f) {
            $fileList .= '- ' . $f['name'] . ' (' . round($f['size'] / 1024) . " KB)\n";
        }
        $body = "Eine neue Bewerbung ist eingegangen.\n\n"
              . "Position: {$position}\n"
              . "Name: {$name}\n"
              . "E-Mail: {$email}\n"
              . "Telefon: {$phone}\n\n"
              . "Nachricht:\n{$message}\n\n"
              . "Angehaengte Dokumente:\n{$fileList}\n"
              . "Im Admin-Bereich einsehbar: " . SITE_URL . "/admin/applications\n";

        $headers = "From: noreply@sui-innova.ch\r\n"
                 . "Reply-To: {$email}\r\n"
                 . "Content-Type: text/plain; charset=UTF-8\r\n";
        @mail($receiver, $subject, $body, $headers);
    }

    setFlash('success', 'Vielen Dank für Ihre Bewerbung! Wir melden uns in Kürze bei Ihnen.');
    redirectToHome();
}

function cleanupApplicationFiles(array $files): void
{
    foreach ($files as $f) {
        $full = BASE_PATH . '/uploads/' . $f['path'];
        if (is_file($full)) @unlink($full);
    }
}

function redirectToHome(): void
{
    header('Location: ' . url(), true, 302);
    exit;
}
