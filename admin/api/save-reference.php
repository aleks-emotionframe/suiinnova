<?php
define("BASE_PATH", dirname(dirname(__DIR__)));
require_once BASE_PATH . "/core/bootstrap.php";
requireAuth();

header('Content-Type: application/json');
requireCsrf();

$id              = (int)($_POST['id'] ?? 0);
$title           = trim($_POST['title'] ?? '');
$description     = trim($_POST['description'] ?? '');
$category        = trim($_POST['category'] ?? '');
$city            = trim($_POST['city'] ?? '');
$year            = $_POST['year'] ?? '';
$imageId         = $_POST['image_id'] ?? '';
$isActive        = (int)($_POST['is_active'] ?? 1);
$isFeaturedHome  = (int)($_POST['is_featured_home'] ?? 0);
$homeOrder       = $_POST['home_order'] ?? '';

if ($title === '') {
    echo json_encode(['error' => 'Titel ist erforderlich']);
    exit;
}

if (mb_strlen($title) > 255 || mb_strlen($description) > 5000 || mb_strlen($category) > 100 || mb_strlen($city) > 100) {
    echo json_encode(['error' => 'Eingabe zu lang']);
    exit;
}

$data = [
    'title'            => $title,
    'description'      => $description !== '' ? $description : null,
    'category'         => $category !== '' ? $category : null,
    'city'             => $city !== '' ? $city : null,
    'year'             => is_numeric($year) ? (int)$year : null,
    'image_id'         => is_numeric($imageId) && (int)$imageId > 0 ? (int)$imageId : null,
    'is_active'        => $isActive === 1 ? 1 : 0,
    'is_featured_home' => $isFeaturedHome === 1 ? 1 : 0,
    'home_order'       => is_numeric($homeOrder) ? max(0, min(99, (int)$homeOrder)) : 0,
];

try {
    if ($id > 0) {
        $db->update('ref_items', $data, 'id = :id', ['id' => $id]);
        echo json_encode(['success' => true, 'id' => $id, 'message' => 'Referenz aktualisiert']);
    } else {
        // Naechste sort_order-Position
        $maxSort = (int)$db->fetchColumn("SELECT COALESCE(MAX(sort_order), 0) FROM ref_items");
        $data['sort_order'] = $maxSort + 1;
        $newId = $db->insert('ref_items', $data);
        echo json_encode(['success' => true, 'id' => $newId, 'message' => 'Referenz angelegt']);
    }
} catch (Exception $e) {
    echo json_encode(['error' => 'Datenbank-Fehler']);
}
