<?php
define("BASE_PATH", dirname(dirname(__DIR__)));
require_once BASE_PATH . "/core/bootstrap.php";
requireAuth();

/**
 * AJAX: Seite online/offline schalten
 */

header('Content-Type: application/json');
requireCsrf();

$pageId = (int) ($_POST['page_id'] ?? 0);

if (!$pageId) {
    echo json_encode(['error' => 'Ungültige Seiten-ID']);
    exit;
}

$page = $db->fetch("SELECT id, title, slug, is_homepage, is_active FROM pages WHERE id = :id", ['id' => $pageId]);

if (!$page) {
    echo json_encode(['error' => 'Seite nicht gefunden']);
    exit;
}

if ((int)$page['is_homepage'] === 1) {
    echo json_encode(['error' => 'Die Startseite kann nicht offline genommen werden.']);
    exit;
}

$newState = (int)$page['is_active'] === 1 ? 0 : 1;
$db->update('pages', ['is_active' => $newState], 'id = :id', ['id' => $pageId]);

echo json_encode([
    'success'   => true,
    'is_active' => $newState,
    'title'     => $page['title'],
    'message'   => $newState === 1
        ? 'Seite „' . $page['title'] . '" ist jetzt online.'
        : 'Seite „' . $page['title'] . '" ist jetzt offline.',
]);
