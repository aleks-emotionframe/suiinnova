<?php
define("BASE_PATH", dirname(dirname(__DIR__)));
require_once BASE_PATH . "/core/bootstrap.php";
requireAuth();
/**
 * AJAX: Section loeschen
 */

header('Content-Type: application/json');
requireCsrf();

$sectionId = (int) ($_POST['section_id'] ?? 0);
if (!$sectionId) {
    echo json_encode(['error' => 'Keine Section-ID']);
    exit;
}

$db->delete('sections', 'id = :id', ['id' => $sectionId]);

echo json_encode(['success' => true]);
