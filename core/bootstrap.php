<?php
/**
 * Bootstrap — wird von jedem Request geladen
 *
 * Reihenfolge: Config → DB → Session → Helpers → Auth → Settings
 */

// Fehler anzeigen (in Produktion deaktivieren)
error_reporting(E_ALL & ~E_WARNING);
ini_set('display_errors', '0'); // Auf '1' setzen zum Debuggen

// Konfiguration laden
require_once BASE_PATH . '/config/config.php';

// Core-Dateien laden
require_once BASE_PATH . '/core/db.php';
require_once BASE_PATH . '/core/helpers.php';
require_once BASE_PATH . '/core/auth.php';

// Datenbank-Verbindung
$db = new Database();

// Session starten (sichere Einstellungen)
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', '1');
    ini_set('session.cookie_samesite', 'Strict');
    ini_set('session.use_strict_mode', '1');

    // HTTPS in Produktion
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
        ini_set('session.cookie_secure', '1');
    }

    session_start();
}

// Globale Settings aus DB laden (gecached pro Request)
$settings = [];
try {
    $rows = $db->fetchAll("SELECT setting_key, setting_val FROM settings");
    foreach ($rows as $row) {
        $settings[$row['setting_key']] = $row['setting_val'];
    }
} catch (Exception $e) {
    // DB existiert vielleicht noch nicht (Install-Modus)
    $settings = [];
}

// Navigation aus DB laden
$navigation = [];
try {
    $navigation = $db->fetchAll(
        "SELECT n.*, p.slug AS page_slug
         FROM navigation n
         LEFT JOIN pages p ON n.page_id = p.id
         WHERE n.is_active = 1
         ORDER BY n.sort_order ASC"
    );
} catch (Exception $e) {
    $navigation = [];
}
