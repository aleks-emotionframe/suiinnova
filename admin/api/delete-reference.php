<?php
define("BASE_PATH", dirname(dirname(__DIR__)));
require_once BASE_PATH . "/core/bootstrap.php";
requireAuth();

header('Content-Type: application/json');
requireCsrf();

$id = (int)($_POST['id'] ?? 0);
if ($id <= 0) {
    echo json_encode(['error' => 'Ungültige ID']);
    exit;
}

try {
    $db->query("DELETE FROM ref_items WHERE id = :id", ['id' => $id]);
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['error' => 'Datenbank-Fehler']);
}
