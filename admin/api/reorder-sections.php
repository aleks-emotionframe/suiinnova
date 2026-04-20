<?php
define("BASE_PATH", dirname(dirname(__DIR__)));
require_once BASE_PATH . "/core/bootstrap.php";
requireAuth();
/**
 * AJAX: Sektionen neu ordnen
 */

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);

// CSRF aus JSON-Body prüfen
$token = $input['csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
if (!hash_equals(csrfToken(), $token)) {
    http_response_code(403);
    echo json_encode(['error' => 'CSRF ungültig']);
    exit;
}

$order = $input['order'] ?? [];

if (!is_array($order)) {
    echo json_encode(['error' => 'Ungültige Daten']);
    exit;
}

foreach ($order as $index => $sectionId) {
    $db->update('sections', [
        'sort_order' => $index,
    ], 'id = :id', ['id' => (int) $sectionId]);
}

echo json_encode(['success' => true]);
