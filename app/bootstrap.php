<?php
/**
 * Application bootstrap — loaded by the front controller.
 */

if (!defined('APP_ROOT')) {
    define('APP_ROOT', dirname(__DIR__));
}
if (!defined('APP_PATH')) {
    define('APP_PATH', APP_ROOT . '/app');
}

require_once APP_PATH . '/config.php';

// Error handling
if (APP_DEBUG) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    error_reporting(0);
    ini_set('display_errors', '0');
}

// Session
ini_set('session.name', SESSION_NAME);
ini_set('session.gc_maxlifetime', SESSION_LIFETIME);
ini_set('session.cookie_httponly', '1');
ini_set('session.cookie_samesite', 'Lax');
session_start();

// Core classes
require_once APP_PATH . '/Database.php';
require_once APP_PATH . '/Auth.php';
require_once APP_PATH . '/Router.php';
require_once APP_PATH . '/helpers.php';

// Ensure upload directory exists
if (!is_dir(UPLOAD_PATH)) {
    @mkdir(UPLOAD_PATH, 0755, true);
}

/**
 * Check maintenance mode — show maintenance page for non-admin visitors.
 */
function checkMaintenance(): void
{
    // Skip for admin routes and logged-in admins
    $uri = $_SERVER['REQUEST_URI'] ?? '/';
    if (str_contains($uri, '/admin') || Auth::check()) {
        return;
    }

    try {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT setting_value FROM settings WHERE setting_key = 'maintenance_mode'");
        $stmt->execute();
        $val = $stmt->fetchColumn();

        if ($val === '1') {
            http_response_code(503);
            header('Retry-After: 3600');
            require APP_PATH . '/views/pages/maintenance.php';
            exit;
        }
    } catch (Exception $e) {
        // DB not yet set up — skip
    }
}
