<?php
define("BASE_PATH", dirname(dirname(__DIR__)));
require_once BASE_PATH . "/core/bootstrap.php";
requireAuth();
/**
 * AJAX: Datei hochladen
 */

header('Content-Type: application/json');
requireCsrf();

if (!isset($_FILES['file'])) {
    echo json_encode(['error' => 'Keine Datei']);
    exit;
}

$file = $_FILES['file'];

// Fehler pruefen
if ($file['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['error' => 'Upload-Fehler: ' . $file['error']]);
    exit;
}

// Groesse pruefen
if ($file['size'] > MAX_UPLOAD_SIZE) {
    echo json_encode(['error' => 'Datei zu gross (max. ' . formatFileSize(MAX_UPLOAD_SIZE) . ')']);
    exit;
}

// MIME-Type pruefen
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mimeType = finfo_file($finfo, $file['tmp_name']);
finfo_close($finfo);

if (!in_array($mimeType, ALLOWED_MIME_TYPES)) {
    echo json_encode(['error' => 'Dateityp nicht erlaubt: ' . $mimeType]);
    exit;
}

// Extension pruefen
$originalName = $file['name'];
$extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
if (!in_array($extension, ALLOWED_EXTENSIONS)) {
    echo json_encode(['error' => 'Dateiendung nicht erlaubt: ' . $extension]);
    exit;
}

// Dateiname generieren (Hash + Extension)
$hash = bin2hex(random_bytes(16));
$filename = $hash . '.' . $extension;
$relativePath = 'images/' . $filename;
$absolutePath = UPLOADS_PATH . '/images/' . $filename;

// Verzeichnis sicherstellen
if (!is_dir(UPLOADS_PATH . '/images')) {
    mkdir(UPLOADS_PATH . '/images', 0755, true);
}

// Datei verschieben
if (!move_uploaded_file($file['tmp_name'], $absolutePath)) {
    echo json_encode(['error' => 'Datei konnte nicht gespeichert werden']);
    exit;
}

// Bildabmessungen
$width = null;
$height = null;
$thumbPath = null;

if (str_starts_with($mimeType, 'image/') && $mimeType !== 'image/svg+xml') {
    $imageInfo = getimagesize($absolutePath);
    if ($imageInfo) {
        $width = $imageInfo[0];
        $height = $imageInfo[1];
    }

    // Thumbnail generieren (AVIF: graceful skip wenn PHP-Server kein AVIF kann)
    try {
        $thumbPath = createThumbnail($absolutePath, $filename);
    } catch (Throwable $e) {
        $thumbPath = null;
    }
}

// In DB speichern
$mediaId = $db->insert('media', [
    'filename'   => $filename,
    'original'   => $originalName,
    'mime_type'  => $mimeType,
    'file_size'  => $file['size'],
    'width'      => $width,
    'height'     => $height,
    'alt_text'   => pathinfo($originalName, PATHINFO_FILENAME),
    'path'       => $relativePath,
    'thumb_path' => $thumbPath,
]);

echo json_encode([
    'success' => true,
    'media'   => [
        'id'        => $mediaId,
        'filename'  => $filename,
        'original'  => $originalName,
        'url'       => uploadUrl($relativePath),
        'thumb_url' => $thumbPath ? uploadUrl($thumbPath) : uploadUrl($relativePath),
    ],
]);

/**
 * Thumbnail erstellen
 */
function createThumbnail(string $sourcePath, string $filename): ?string
{
    $thumbDir = UPLOADS_PATH . '/thumbnails';
    if (!is_dir($thumbDir)) {
        mkdir($thumbDir, 0755, true);
    }

    $thumbFilename = 'thumb_' . $filename;
    $thumbFullPath = $thumbDir . '/' . $thumbFilename;
    $thumbRelative = 'thumbnails/' . $thumbFilename;

    $imageInfo = getimagesize($sourcePath);
    if (!$imageInfo) return null;

    [$origW, $origH, $type] = $imageInfo;

    // Source laden (AVIF nur wenn PHP-Build es unterstuetzt)
    $avifType = defined('IMAGETYPE_AVIF') ? IMAGETYPE_AVIF : null;
    $source = null;
    try {
        $source = match (true) {
            $type === IMAGETYPE_JPEG                                                   => imagecreatefromjpeg($sourcePath),
            $type === IMAGETYPE_PNG                                                    => imagecreatefrompng($sourcePath),
            $type === IMAGETYPE_WEBP && function_exists('imagecreatefromwebp')         => imagecreatefromwebp($sourcePath),
            $avifType && $type === $avifType && function_exists('imagecreatefromavif') => imagecreatefromavif($sourcePath),
            default                                                                    => null,
        };
    } catch (Throwable $e) {
        $source = null;
    }

    if (!$source) return null;

    // Groesse berechnen (proportional)
    $ratio = min(THUMB_WIDTH / $origW, THUMB_HEIGHT / $origH);
    $newW = (int) ($origW * $ratio);
    $newH = (int) ($origH * $ratio);

    $thumb = imagecreatetruecolor($newW, $newH);

    // Transparenz erhalten (PNG)
    if ($type === IMAGETYPE_PNG) {
        imagealphablending($thumb, false);
        imagesavealpha($thumb, true);
    }

    imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newW, $newH, $origW, $origH);

    // Speichern als JPEG (kleiner)
    $thumbFilenameJpg = pathinfo($thumbFilename, PATHINFO_FILENAME) . '.jpg';
    $thumbFullPathJpg = $thumbDir . '/' . $thumbFilenameJpg;

    imagejpeg($thumb, $thumbFullPathJpg, 85);
    imagedestroy($source);
    imagedestroy($thumb);

    return 'thumbnails/' . $thumbFilenameJpg;
}
