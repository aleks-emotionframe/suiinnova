<?php
/**
 * Bild-Varianten und responsive Ausgabe
 *
 * Ausgangslage (SEO-Audit 03.09.2026): 57 von 59 Bildern wurden zu gross
 * ausgeliefert. Es gab keine Groessenvarianten — jedes Geraet bekam dieselbe
 * Datei. Das groesste Bild kam mit 3000 Pixel Breite und wurde auf 364 Pixel
 * angezeigt. Auf der Referenzseite lagen dadurch 4,93 MB an, davon 2,1 MB fuer
 * ein einziges JPEG, und die Seite brauchte 8,1 Sekunden bis zum groessten
 * sichtbaren Element.
 *
 * Dieses Modul erzeugt beim Upload mehrere Breiten als WebP und liefert sie
 * ueber srcset aus. Der Browser laedt dann die Variante, die er wirklich
 * braucht. Zusaetzlich stehen width und height im Markup, damit der Browser
 * den Platz vorab freihalten kann.
 */

/** Breiten, die erzeugt werden. Groesser als das Original wird nie skaliert. */
const IMAGE_VARIANT_WIDTHS = [400, 800, 1200, 1600, 2000];

/** Qualitaet der erzeugten Varianten. 82 ist der uebliche Kompromiss. */
const IMAGE_VARIANT_QUALITY = 82;

/** Unterordner unterhalb von uploads/ */
const IMAGE_VARIANT_DIR = 'images/variants';

/**
 * Kann dieser PHP-Build WebP schreiben?
 */
function imagesCanWriteWebp(): bool
{
    return function_exists('imagewebp');
}

/**
 * Bildressource aus einer Datei laden.
 * Gibt null zurueck, wenn das Format vom Server nicht unterstuetzt wird —
 * AVIF zum Beispiel kann nicht jeder PHP-Build.
 */
function imagesLoadSource(string $path, int $type): ?\GdImage
{
    $avifType = defined('IMAGETYPE_AVIF') ? IMAGETYPE_AVIF : null;

    try {
        $img = match (true) {
            $type === IMAGETYPE_JPEG                                                   => imagecreatefromjpeg($path),
            $type === IMAGETYPE_PNG                                                    => imagecreatefrompng($path),
            $type === IMAGETYPE_WEBP && function_exists('imagecreatefromwebp')          => imagecreatefromwebp($path),
            $avifType && $type === $avifType && function_exists('imagecreatefromavif')  => imagecreatefromavif($path),
            default                                                                     => null,
        };
    } catch (Throwable $e) {
        return null;
    }

    return $img ?: null;
}

/**
 * Groessenvarianten fuer eine hochgeladene Datei erzeugen.
 *
 * @param  string $absolutePath  Vollstaendiger Pfad zur Originaldatei
 * @param  string $filename      Dateiname inkl. Endung (Hash-Name aus dem Upload)
 * @return array                 [breite => relativer Pfad], leer wenn nichts ging
 */
function generateImageVariants(string $absolutePath, string $filename): array
{
    if (!is_file($absolutePath)) return [];

    $info = @getimagesize($absolutePath);
    if (!$info) return [];

    [$origW, $origH, $type] = $info;
    if ($origW < 1 || $origH < 1) return [];

    // SVG und alles, was GD nicht lesen kann, bleibt wie es ist
    $source = imagesLoadSource($absolutePath, $type);
    if (!$source) return [];

    $dir = UPLOADS_PATH . '/' . IMAGE_VARIANT_DIR;
    if (!is_dir($dir) && !@mkdir($dir, 0755, true) && !is_dir($dir)) {
        imagedestroy($source);
        return [];
    }

    $base    = pathinfo($filename, PATHINFO_FILENAME);
    $useWebp = imagesCanWriteWebp();
    $ext     = $useWebp ? 'webp' : 'jpg';
    $hasAlpha = in_array($type, [IMAGETYPE_PNG, IMAGETYPE_WEBP], true);

    $variants = [];

    foreach (IMAGE_VARIANT_WIDTHS as $targetW) {
        // Nie hochskalieren: ein 900px-Bild bekommt keine 1200er-Variante
        if ($targetW >= $origW) continue;

        $targetH = (int) round($origH * ($targetW / $origW));
        if ($targetH < 1) continue;

        $canvas = imagecreatetruecolor($targetW, $targetH);

        if ($hasAlpha) {
            imagealphablending($canvas, false);
            imagesavealpha($canvas, true);
            $transparent = imagecolorallocatealpha($canvas, 0, 0, 0, 127);
            imagefilledrectangle($canvas, 0, 0, $targetW, $targetH, $transparent);
            imagealphablending($canvas, true);
        }

        imagecopyresampled($canvas, $source, 0, 0, 0, 0, $targetW, $targetH, $origW, $origH);

        $outName = $base . '-' . $targetW . '.' . $ext;
        $outPath = $dir . '/' . $outName;

        $ok = false;
        try {
            $ok = $useWebp
                ? imagewebp($canvas, $outPath, IMAGE_VARIANT_QUALITY)
                : imagejpeg($canvas, $outPath, IMAGE_VARIANT_QUALITY);
        } catch (Throwable $e) {
            $ok = false;
        }

        imagedestroy($canvas);

        if ($ok && is_file($outPath)) {
            $variants[$targetW] = IMAGE_VARIANT_DIR . '/' . $outName;
        }
    }

    imagedestroy($source);
    ksort($variants);

    return $variants;
}

/**
 * Sicherstellen, dass media.variants existiert.
 *
 * Die Spalte kommt normalerweise mit der SQL-Migration. Der Self-Heal hier
 * greift, falls jemand nur die Dateien hochgeladen und die SQL vergessen hat —
 * dann repariert sich das CMS beim ersten Upload selbst, statt mit einem
 * Datenbankfehler auszusteigen.
 */
function ensureMediaVariantsColumn(): bool
{
    static $result = null;
    if ($result !== null) return $result;

    global $db;

    try {
        if (!$db->fetch("SHOW COLUMNS FROM media LIKE 'variants'")) {
            $db->query("ALTER TABLE media ADD COLUMN variants TEXT NULL AFTER thumb_path");
        }
        $result = true;
    } catch (Throwable $e) {
        // Fehlt die Spalte weiterhin, laufen Uploads ohne Varianten weiter.
        error_log('media.variants konnte nicht angelegt werden: ' . $e->getMessage());
        $result = false;
    }

    return $result;
}

/**
 * Varianten eines Media-Eintrags lesen.
 * Die Spalte media.variants haelt ein JSON-Objekt [breite => pfad].
 */
function mediaVariants(array $media): array
{
    if (empty($media['variants'])) return [];

    $decoded = json_decode((string) $media['variants'], true);
    if (!is_array($decoded)) return [];

    $out = [];
    foreach ($decoded as $w => $path) {
        $w = (int) $w;
        if ($w > 0 && is_string($path) && $path !== '') {
            $out[$w] = $path;
        }
    }

    ksort($out);
    return $out;
}

/**
 * srcset-Zeichenkette fuer einen Media-Eintrag bauen.
 *
 * Das Original kommt bewusst NICHT ins srcset. Sonst zieht ein grosser oder
 * hochaufloesender Bildschirm genau die Datei, die der Audit beanstandet hat —
 * auf der Referenzseite ein einzelnes JPEG mit 2113 KB. Die Obergrenze liegt
 * deshalb bei 2000 Pixel. Der sichtbare Unterschied auf einem 4K-Schirm ist
 * gering, die eingesparte Datenmenge betraechtlich.
 *
 * Das Original bleibt als src-Attribut erhalten und wird nur von Browsern
 * geladen, die srcset gar nicht koennen.
 */
function mediaSrcset(array $media): string
{
    $variants = mediaVariants($media);
    if (!$variants) return '';

    $parts = [];
    foreach ($variants as $w => $path) {
        $parts[] = uploadUrl($path) . ' ' . $w . 'w';
    }

    return implode(', ', $parts);
}

/**
 * Vollstaendiges <img>-Tag fuer einen Media-Eintrag.
 *
 * Optionen:
 *   alt      string  Alternativtext. Leerstring = dekoratives Bild.
 *                    Ohne Angabe wird media.alt_text genommen.
 *   sizes    string  Wie breit das Bild im Layout dargestellt wird.
 *                    Default 100vw — bitte pro Sektion passend setzen,
 *                    sonst laedt der Browser zu grosszuegig.
 *   class    string  CSS-Klassen
 *   style    string  Inline-Style
 *   loading  string  'lazy' (Default) oder 'eager' fuers erste Bild
 *   fetchpriority string  'high' fuer das LCP-Bild
 *
 * Faellt auf ein einfaches <img> zurueck, wenn es keine Varianten gibt —
 * etwa bei SVG oder bei Bestandsbildern vor dem Nachgenerieren.
 */
function responsiveImg(?int $mediaId, array $opts = []): string
{
    if (!$mediaId) return '';

    $media = getMedia($mediaId);
    if (!$media) return '';

    $alt = array_key_exists('alt', $opts)
        ? (string) $opts['alt']
        : (string) ($media['alt_text'] ?? '');

    $attrs = [
        'src' => uploadUrl($media['path']),
        'alt' => $alt,
    ];

    if ($srcset = mediaSrcset($media)) {
        $attrs['srcset'] = $srcset;
        $attrs['sizes']  = (string) ($opts['sizes'] ?? '100vw');
    }

    // width und height verhindern Layoutspruenge beim Laden
    if (!empty($media['width']) && !empty($media['height'])) {
        $attrs['width']  = (string) (int) $media['width'];
        $attrs['height'] = (string) (int) $media['height'];
    }

    $attrs['loading']  = (string) ($opts['loading'] ?? 'lazy');
    $attrs['decoding'] = 'async';

    if (!empty($opts['fetchpriority'])) {
        $attrs['fetchpriority'] = (string) $opts['fetchpriority'];
    }
    if (!empty($opts['class'])) {
        $attrs['class'] = (string) $opts['class'];
    }
    if (!empty($opts['style'])) {
        $attrs['style'] = (string) $opts['style'];
    }

    // Freie Zusatzattribute, etwa data-parallax fuer den Scroll-Effekt.
    // Als [name => wert]; ein leerer Wert erzeugt ein Attribut ohne Wert.
    foreach ((array) ($opts['attrs'] ?? []) as $name => $value) {
        if (!is_string($name) || !preg_match('/^[a-z][a-z0-9:._-]*$/i', $name)) continue;
        $attrs[$name] = (string) $value;
    }

    $html = '<img';
    foreach ($attrs as $k => $v) {
        $html .= ' ' . $k . '="' . e($v) . '"';
    }
    $html .= '>';

    return $html;
}

/**
 * URL der kleinsten Variante, die mindestens so breit ist wie gewuenscht.
 *
 * Fuer Stellen, an denen kein <img> moeglich ist — etwa der Parallax-Streifen,
 * der auf dem Desktop mit background-attachment: fixed arbeitet. Statt des
 * 3000-Pixel-Originals kommt dort dann die 1600er-Variante.
 *
 * Gibt es keine passende Variante, kommt das Original zurueck. Der Aufruf ist
 * dadurch immer sicher, auch fuer SVG oder noch nicht umgewandelte Bestands-
 * bilder.
 */
function mediaVariantUrl(?int $mediaId, int $minWidth): string
{
    if (!$mediaId) return '';

    $media = getMedia($mediaId);
    if (!$media) return '';

    foreach (mediaVariants($media) as $w => $path) {
        if ($w >= $minWidth) {
            return uploadUrl($path);
        }
    }

    return uploadUrl($media['path']);
}
