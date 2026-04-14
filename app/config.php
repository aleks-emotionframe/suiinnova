<?php
/**
 * SUI Innova GmbH - Configuration
 * Adjust these settings for your Hostpoint hosting environment.
 */

// Error reporting (disable in production)
define('APP_DEBUG', false);

// Database configuration (Hostpoint MySQL)
define('DB_HOST', 'bifitudo.mysql.db.internal');
define('DB_NAME', 'bifitudo_suiinnova');
define('DB_USER', 'bifitudo_sui');
define('DB_PASS', 'Novitr@vnik1');
define('DB_CHARSET', 'utf8mb4');

// Application paths
define('APP_ROOT', dirname(__DIR__));
define('APP_PATH', __DIR__);
define('PUBLIC_PATH', APP_ROOT . '/public');
define('UPLOAD_PATH', PUBLIC_PATH . '/uploads');
define('UPLOAD_URL', '/uploads');

// Site URL (without trailing slash)
define('SITE_URL', 'https://www.sui-innova.ch');

// Admin path
define('ADMIN_PATH', '/admin');

// Session settings
define('SESSION_NAME', 'suiinnova_session');
define('SESSION_LIFETIME', 7200); // 2 hours

// Upload settings
define('MAX_UPLOAD_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_IMAGE_TYPES', ['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml']);

// CSRF token name
define('CSRF_TOKEN_NAME', 'csrf_token');

// Timezone
date_default_timezone_set('Europe/Zurich');
