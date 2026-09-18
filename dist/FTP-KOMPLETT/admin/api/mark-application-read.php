<?php
define("BASE_PATH", dirname(dirname(__DIR__)));
require_once BASE_PATH . "/core/bootstrap.php";
requireAuth();

header('Content-Type: application/json');
requireCsrf();

$id = (int)($_POST['application_id'] ?? 0);
if (!$id) {
    echo json_encode(['error' => 'Ungültige ID']);
    exit;
}

$db->update('applications', ['is_read' => 1], 'id = :id', ['id' => $id]);
echo json_encode(['success' => true]);
