<?php
/**
 * Hilfsfunktionen
 */

/**
 * HTML-Escape (XSS-Schutz)
 */
function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * Asset-URL mit Cache-Busting
 */
function asset(string $path): string
{
    $filePath = BASE_PATH . '/assets/' . ltrim($path, '/');
    $version = file_exists($filePath) ? filemtime($filePath) : time();
    return SITE_URL . '/assets/' . ltrim($path, '/') . '?v=' . $version;
}

/**
 * Interne URL generieren
 */
function url(string $path = ''): string
{
    return SITE_URL . '/' . ltrim($path, '/');
}

/**
 * Upload-URL generieren
 */
function uploadUrl(string $path): string
{
    return UPLOADS_URL . '/' . ltrim($path, '/');
}

/**
 * Einstellung aus dem globalen Settings-Array holen
 */
function setting(string $key, string $default = ''): string
{
    global $settings;
    return $settings[$key] ?? $default;
}

/**
 * Media-Eintrag aus der DB holen (mit Caching pro Request)
 */
function getMedia(int $id): ?array
{
    static $cache = [];

    if (isset($cache[$id])) {
        return $cache[$id];
    }

    global $db;
    $media = $db->fetch("SELECT * FROM media WHERE id = :id", ['id' => $id]);
    $cache[$id] = $media;
    return $media;
}

/**
 * Media-URL holen (Convenience)
 */
function mediaUrl(?int $id, string $size = 'full'): string
{
    if (!$id) return '';

    $media = getMedia($id);
    if (!$media) return '';

    if ($size === 'thumb' && !empty($media['thumb_path'])) {
        return uploadUrl($media['thumb_path']);
    }

    return uploadUrl($media['path']);
}

/**
 * Slug aus einem String generieren
 */
function slugify(string $text): string
{
    $text = mb_strtolower($text, 'UTF-8');

    // Deutsche Umlaute
    $replacements = [
        'ä' => 'ae', 'ö' => 'oe', 'ü' => 'ue',
        'Ä' => 'ae', 'Ö' => 'oe', 'Ü' => 'ue',
        'ß' => 'ss',
    ];
    $text = str_replace(array_keys($replacements), array_values($replacements), $text);

    // Nur Buchstaben, Zahlen, Bindestriche
    $text = preg_replace('/[^a-z0-9\-]/', '-', $text);
    $text = preg_replace('/-+/', '-', $text);
    return trim($text, '-');
}

/**
 * Kurzen Text-Auszug erstellen
 */
function excerpt(string $text, int $length = 160): string
{
    $text = strip_tags($text);
    if (mb_strlen($text) <= $length) {
        return $text;
    }
    return mb_substr($text, 0, $length) . '...';
}

/**
 * JSON sicher dekodieren
 */
function jsonDecode(string $json): array
{
    $data = json_decode($json, true);
    return is_array($data) ? $data : [];
}

/**
 * Dateigroesse menschenlesbar
 */
function formatFileSize(int $bytes): string
{
    if ($bytes >= 1048576) {
        return round($bytes / 1048576, 1) . ' MB';
    }
    if ($bytes >= 1024) {
        return round($bytes / 1024, 1) . ' KB';
    }
    return $bytes . ' B';
}

/**
 * Datum deutsch formatieren
 */
function formatDate(string $datetime, string $format = 'd.m.Y'): string
{
    return date($format, strtotime($datetime));
}

/**
 * Datum + Uhrzeit deutsch formatieren
 */
function formatDateTime(string $datetime): string
{
    return date('d.m.Y, H:i', strtotime($datetime));
}

/**
 * IP-Adresse hashen (DSGVO)
 */
function hashIp(string $ip): string
{
    return hash('sha256', $ip . IP_HASH_SALT);
}

/**
 * Flash-Nachricht setzen
 */
function setFlash(string $type, string $message): void
{
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

/**
 * Flash-Nachricht holen und loeschen
 */
function getFlash(): ?array
{
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

/**
 * Richtext rendern: Wenn der Text schon HTML enthaelt (<p>, <ul> etc.)
 * wird er direkt ausgegeben. Sonst werden Absaetze (Leerzeilen) zu <p>-Tags.
 */
function renderRichtext(?string $text): string
{
    if (!$text) return '';

    // Erlaubte HTML-Tags
    $allowedTags = '<p><br><strong><b><em><i><a><ul><ol><li><h2><h3><h4><span>';

    // Wenn irgendwelche HTML-Tags vorhanden sind
    if (preg_match('/<[a-z][a-z0-9]*[\s>\/]/i', $text)) {
        // <div> zu <br> konvertieren (contenteditable erzeugt <div> statt <br>)
        $text = preg_replace('/<div>/i', '<br>', $text);
        $text = preg_replace('/<\/div>/i', '', $text);

        $clean = strip_tags($text, $allowedTags);
        // Doppelte <br> bereinigen
        $clean = preg_replace('/(<br\s*\/?>){3,}/i', '<br><br>', $clean);
        return $clean;
    }

    // Plain-Text: Absaetze bei Doppel-Zeilenumbruch, <br> bei einfachem
    $text = e($text);
    $paragraphs = preg_split('/\n\s*\n/', $text);
    $html = '';
    foreach ($paragraphs as $p) {
        $p = trim($p);
        if ($p !== '') {
            $html .= '<p>' . nl2br($p) . '</p>';
        }
    }
    return $html ?: '<p>' . nl2br($text) . '</p>';
}
