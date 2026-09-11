<?php
define("BASE_PATH", dirname(dirname(__DIR__)));
require_once BASE_PATH . "/core/bootstrap.php";
requireAuth();
/**
 * AJAX: Groessenvarianten fuer den Bildbestand nachgenerieren
 *
 * Laeuft in kleinen Haeppchen, damit auf dem Shared Hosting weder das
 * Zeitlimit noch das Speicherlimit reisst. Die Oberflaeche ruft den Endpunkt
 * so lange auf, bis "done" zurueckkommt.
 */

header('Content-Type: application/json');
requireCsrf();

@set_time_limit(120);

if (!ensureMediaVariantsColumn()) {
    echo json_encode([
        'error' => 'Die Spalte media.variants fehlt und konnte nicht angelegt werden. '
                 . 'Bitte die SQL-Migration einspielen.',
    ]);
    exit;
}

if (!function_exists('imagecreatetruecolor')) {
    echo json_encode(['error' => 'Auf diesem Server fehlt die GD-Bildbibliothek.']);
    exit;
}

// Wie viele Bilder pro Aufruf. Bewusst klein: ein 3000er-JPEG braucht beim
// Umwandeln gut 40 MB Arbeitsspeicher.
$batchSize = 3;

// Nur echte Rasterbilder, SVG kann und muss nicht skaliert werden
$pending = $db->fetchAll(
    "SELECT id, filename, path, width, height
     FROM media
     WHERE (variants IS NULL OR variants = '' OR variants = '[]' OR variants = '{}')
       AND mime_type LIKE 'image/%'
       AND mime_type <> 'image/svg+xml'
     ORDER BY file_size DESC
     LIMIT " . (int) $batchSize
);

$remaining = (int) $db->fetchColumn(
    "SELECT COUNT(*) FROM media
     WHERE (variants IS NULL OR variants = '' OR variants = '[]' OR variants = '{}')
       AND mime_type LIKE 'image/%'
       AND mime_type <> 'image/svg+xml'"
);

$processed = [];
$failed    = [];

foreach ($pending as $row) {
    $abs = UPLOADS_PATH . '/' . ltrim((string) $row['path'], '/');

    if (!is_file($abs)) {
        // Datei fehlt auf der Platte: leeres Objekt schreiben, damit der
        // Eintrag nicht bei jedem Durchlauf erneut probiert wird.
        $db->update('media', ['variants' => '{}'], 'id = :id', ['id' => $row['id']]);
        $failed[] = ['id' => (int) $row['id'], 'grund' => 'Datei nicht gefunden'];
        continue;
    }

    // Abmessungen nachtragen, falls sie fehlen — ohne width und height
    // kann das Markup den Platz nicht vorab reservieren.
    $update = [];
    if (empty($row['width']) || empty($row['height'])) {
        if ($info = @getimagesize($abs)) {
            $update['width']  = $info[0];
            $update['height'] = $info[1];
        }
    }

    try {
        $variants = generateImageVariants($abs, (string) $row['filename']);
    } catch (Throwable $e) {
        $variants = [];
        $failed[] = ['id' => (int) $row['id'], 'grund' => $e->getMessage()];
    }

    // Auch ein leeres Ergebnis wird geschrieben: das Bild ist dann entweder
    // kleiner als 400 Pixel oder in einem Format, das GD nicht lesen kann.
    // So bleibt der Durchlauf endlich.
    $update['variants'] = $variants ? json_encode($variants) : '{}';

    $db->update('media', $update, 'id = :id', ['id' => $row['id']]);

    $processed[] = [
        'id'       => (int) $row['id'],
        'datei'    => (string) $row['filename'],
        'varianten' => array_keys($variants),
    ];

    // Speicher zwischen den Bildern freigeben
    if (function_exists('gc_collect_cycles')) {
        gc_collect_cycles();
    }
}

$remainingAfter = max(0, $remaining - count($pending));

echo json_encode([
    'success'   => true,
    'done'      => $remainingAfter === 0,
    'verbleibend' => $remainingAfter,
    'verarbeitet' => $processed,
    'fehler'      => $failed,
    'webp'        => imagesCanWriteWebp(),
]);
