<?php
define("BASE_PATH", dirname(dirname(__DIR__)));
require_once BASE_PATH . "/core/bootstrap.php";
requireAuth();
/**
 * AJAX: Neue Section hinzufuegen
 */

header('Content-Type: application/json');
requireCsrf();

$pageId = (int) ($_POST['page_id'] ?? 0);
$type = $_POST['type'] ?? '';

$sectionTypes = require BASE_PATH . '/config/sections.php';

if (!$pageId || !isset($sectionTypes[$type])) {
    echo json_encode(['error' => 'Ungültige Daten']);
    exit;
}

// Nächste sort_order ermitteln
$maxOrder = (int) $db->fetchColumn(
    "SELECT MAX(sort_order) FROM sections WHERE page_id = :pid",
    ['pid' => $pageId]
);

// Leeren Content generieren
$typeDef = $sectionTypes[$type];
$content = [];
foreach ($typeDef['fields'] as $key => $def) {
    $content[$key] = match($def['type']) {
        'repeater'  => [],
        'checkbox'  => false,
        'media'     => 0,
        default     => '',
    };
}

$sectionId = $db->insert('sections', [
    'page_id'    => $pageId,
    'type'       => $type,
    'content'    => json_encode($content, JSON_UNESCAPED_UNICODE),
    'sort_order' => $maxOrder + 1,
    'is_active'  => 1,
]);

echo json_encode(['success' => true, 'section_id' => $sectionId]);
