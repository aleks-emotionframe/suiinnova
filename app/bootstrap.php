<?php
/**
 * Application bootstrap — loaded by the front controller.
 */

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
