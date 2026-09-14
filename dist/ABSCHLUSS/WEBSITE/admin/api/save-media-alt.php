<?php
define("BASE_PATH", dirname(dirname(__DIR__)));
require_once BASE_PATH . "/core/bootstrap.php";
requireAuth();
/**
 * AJAX: Alternativtext eines Bildes speichern
 *
 * Audit-Befund 06: 11 von 59 Bildern hatten keinen Alternativtext, und im CMS
 * gab es keine Stelle, an der man ihn haette nachtragen koennen.
 */

header('Content-Type: application/json');
requireCsrf();

$mediaId = (int) ($_POST['media_id'] ?? 0);
$altText = trim((string) ($_POST['alt_text'] ?? ''));

if ($mediaId < 1) {
    echo json_encode(['error' => 'Keine Bild-ID angegeben']);
    exit;
}

// Laenge begrenzen: Alternativtexte beschreiben, sie sind keine Textwueste
if (mb_strlen($altText) > 250) {
    $altText = mb_substr($altText, 0, 250);
}

try {
    $affected = $db->update('media', ['alt_text' => $altText], 'id = :id', ['id' => $mediaId]);
} catch (Throwable $e) {
    echo json_encode(['error' => 'Speichern fehlgeschlagen']);
    exit;
}

echo json_encode([
    'success'  => true,
    'alt_text' => $altText,
]);
