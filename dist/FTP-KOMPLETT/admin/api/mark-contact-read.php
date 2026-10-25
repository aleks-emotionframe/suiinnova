<?php
define("BASE_PATH", dirname(dirname(__DIR__)));
require_once BASE_PATH . "/core/bootstrap.php";
requireAuth();
/**
 * AJAX: Kontaktanfrage als gelesen markieren
 */

header('Content-Type: application/json');
requireCsrf();

$contactId = (int) ($_POST['contact_id'] ?? 0);
if (!$contactId) {
    echo json_encode(['error' => 'Keine ID']);
    exit;
}

$db->update('contacts', ['is_read' => 1], 'id = :id', ['id' => $contactId]);

echo json_encode(['success' => true]);
