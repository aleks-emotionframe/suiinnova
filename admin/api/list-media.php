<?php
define("BASE_PATH", dirname(dirname(__DIR__)));
require_once BASE_PATH . "/core/bootstrap.php";
requireAuth();
/**
 * AJAX: Alle Medien als JSON (fuer Media-Picker)
 */

header('Content-Type: application/json');

$media = $db->fetchAll("SELECT id, filename, original, mime_type, file_size, path, thumb_path, alt_text, created_at FROM media ORDER BY created_at DESC");

$result = [];
foreach ($media as $m) {
    $result[] = [
        'id'        => (int) $m['id'],
        'original'  => $m['original'],
        'url'       => uploadUrl($m['path']),
        'thumb_url' => $m['thumb_path'] ? uploadUrl($m['thumb_path']) : uploadUrl($m['path']),
        'alt_text'  => $m['alt_text'],
        'file_size' => formatFileSize($m['file_size']),
    ];
}

echo json_encode($result);
