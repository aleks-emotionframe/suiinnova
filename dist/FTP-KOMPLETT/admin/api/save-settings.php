<?php
define("BASE_PATH", dirname(dirname(__DIR__)));
require_once BASE_PATH . "/core/bootstrap.php";
requireAuth();
/**
 * AJAX: Einstellungen speichern
 */

header('Content-Type: application/json');
requireCsrf();

$settings = $_POST['settings'] ?? [];
if (!is_array($settings)) {
    echo json_encode(['error' => 'Ungültige Daten']);
    exit;
}

foreach ($settings as $key => $value) {
    $key = preg_replace('/[^a-z0-9_]/', '', $key);

    $exists = $db->fetch("SELECT id FROM settings WHERE setting_key = :k", ['k' => $key]);
    if ($exists) {
        $db->update('settings', [
            'setting_val' => $value,
        ], 'setting_key = :k', ['k' => $key]);
    } else {
        $db->insert('settings', [
            'setting_key' => $key,
            'setting_val' => $value,
            'group_name'  => 'general',
        ]);
    }
}

echo json_encode(['success' => true, 'message' => 'Einstellungen gespeichert']);
