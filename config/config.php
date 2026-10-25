<?php
/**
 * SUI Innova GmbH — Konfiguration
 *
 * Erkennt automatisch ob lokal oder auf Hostpoint.
 */

// --- Umgebung erkennen ---
$isLocal = in_array($_SERVER['SERVER_NAME'] ?? '', ['localhost', '127.0.0.1', '::1'])
        || (($_SERVER['SERVER_PORT'] ?? '') === '8000')
        || php_sapi_name() === 'cli';

// --- Datenbank ---
define('DB_HOST', $isLocal ? 'bifitudo.mysql.db.hostpoint.ch' : 'bifitudo.mysql.db.internal');
define('DB_NAME', 'bifitudo_suinnova');
define('DB_USER', 'bifitudo_sui');
define('DB_PASS', 'Novitr@vnik1');
define('DB_CHARSET', 'utf8mb4');

// --- Site ---
define('SITE_URL', $isLocal ? 'http://localhost:8000' : 'https://sui-innova.ch');
define('SITE_NAME', 'SUI Innova GmbH');

// --- Pfade ---
if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__));
}
define('UPLOADS_PATH', BASE_PATH . '/uploads');
define('UPLOADS_URL', SITE_URL . '/uploads');

// --- Sicherheit ---
define('CSRF_SALT', 'k8xP2mQ7vR4nT9wB3jL6yF1cA5sD0hG');
define('IP_HASH_SALT', 'zN3wK7pX1mV6qR9tY4bJ8fC2eA5dH0gU');

// --- Session ---
define('SESSION_LIFETIME', 7200);

// --- Upload ---
define('MAX_UPLOAD_SIZE', 10 * 1024 * 1024);
define('ALLOWED_MIME_TYPES', [
    'image/jpeg',
    'image/png',
    'image/webp',
    'image/avif',
    'image/svg+xml',
    'application/pdf',
]);
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'webp', 'avif', 'svg', 'pdf']);

// --- Thumbnail ---
define('THUMB_WIDTH', 400);
define('THUMB_HEIGHT', 300);

// --- E-Mail ---
define('CONTACT_EMAIL', 'info@sui-innova.ch');
define('SMTP_ENABLED', false);
