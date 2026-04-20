<?php
/**
 * SUI Innova GmbH — Konfiguration (Vorlage)
 *
 * Kopiere diese Datei nach config.php und passe die Werte an.
 */

// --- Datenbank ---
define('DB_HOST', 'localhost');
define('DB_NAME', 'sui_innova');
define('DB_USER', 'dein_db_user');
define('DB_PASS', 'dein_db_passwort');
define('DB_CHARSET', 'utf8mb4');

// --- Site ---
define('SITE_URL', 'https://www.sui-innova.ch');
define('SITE_NAME', 'SUI Innova GmbH');

// --- Pfade ---
define('BASE_PATH', dirname(__DIR__));
define('UPLOADS_PATH', BASE_PATH . '/uploads');
define('UPLOADS_URL', SITE_URL . '/uploads');

// --- Sicherheit ---
define('CSRF_SALT', 'HIER-EINEN-ZUFAELLIGEN-STRING-EINFUEGEN');
define('IP_HASH_SALT', 'HIER-EINEN-ANDEREN-ZUFAELLIGEN-STRING');

// --- Session ---
define('SESSION_LIFETIME', 7200);

// --- Upload ---
define('MAX_UPLOAD_SIZE', 10 * 1024 * 1024);
define('ALLOWED_MIME_TYPES', [
    'image/jpeg',
    'image/png',
    'image/webp',
    'image/svg+xml',
    'application/pdf',
]);
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'webp', 'svg', 'pdf']);

// --- Thumbnail ---
define('THUMB_WIDTH', 400);
define('THUMB_HEIGHT', 300);

// --- E-Mail ---
define('CONTACT_EMAIL', 'info@sui-innova.ch');
define('SMTP_ENABLED', false);
