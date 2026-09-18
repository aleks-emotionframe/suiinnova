<?php
define("BASE_PATH", dirname(dirname(__DIR__)));
require_once BASE_PATH . "/core/bootstrap.php";
requireAuth();
/**
 * AJAX: Seiten-Meta speichern (Titel, SEO)
 */

header('Content-Type: application/json');
requireCsrf();

$pageId = (int) ($_POST['page_id'] ?? 0);
$field = $_POST['field'] ?? '';
$value = $_POST['value'] ?? '';

$allowedFields = ['title', 'meta_title', 'meta_desc'];

if (!$pageId || !in_array($field, $allowedFields)) {
    echo json_encode(['error' => 'Ungültige Daten']);
    exit;
}

$db->update('pages', [$field => $value], 'id = :id', ['id' => $pageId]);

echo json_encode(['success' => true]);
