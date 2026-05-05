<?php
define("BASE_PATH", dirname(dirname(__DIR__)));
require_once BASE_PATH . "/core/bootstrap.php";
requireAuth();
/**
 * AJAX: Medium löschen
 */

header('Content-Type: application/json');
requireCsrf();

$mediaId = (int) ($_POST['media_id'] ?? 0);
if (!$mediaId) {
    echo json_encode(['error' => 'Keine Media-ID']);
    exit;
}

$media = $db->fetch("SELECT * FROM media WHERE id = :id", ['id' => $mediaId]);
if (!$media) {
    echo json_encode(['error' => 'Medium nicht gefunden']);
    exit;
}

// Dateien löschen
$fullPath = UPLOADS_PATH . '/' . $media['path'];
if (file_exists($fullPath)) unlink($fullPath);

if ($media['thumb_path']) {
    $thumbPath = UPLOADS_PATH . '/' . $media['thumb_path'];
    if (file_exists($thumbPath)) unlink($thumbPath);
}

// DB-Eintrag löschen
$db->delete('media', 'id = :id', ['id' => $mediaId]);

echo json_encode(['success' => true]);
