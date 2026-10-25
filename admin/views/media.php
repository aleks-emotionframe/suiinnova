<?php
/**
 * Admin — Medien-Manager
 */
// Spalte fuer die Groessenvarianten sicherstellen, bevor wir sie auslesen
ensureMediaVariantsColumn();

$mediaItems = $db->fetchAll("SELECT * FROM media ORDER BY created_at DESC");

/**
 * Taugt dieser Alternativtext etwas?
 *
 * Beim Upload setzt das CMS alt_text auf den Dateinamen ohne Endung. Aus
 * image.jpg wird so "image" — das Feld ist nicht leer, hilft aber niemandem.
 * Ein blosser Dateiname, eine Kameranummer oder ein Wort sind kein
 * Alternativtext. Solche Eintraege werden hier wie fehlende behandelt.
 */
function altTextTaugt(array $media): bool
{
    $alt = trim((string) ($media['alt_text'] ?? ''));
    if ($alt === '') return false;

    // Identisch mit dem Dateinamen ohne Endung
    $stamm = pathinfo((string) ($media['original'] ?? ''), PATHINFO_FILENAME);
    if ($stamm !== '' && mb_strtolower($alt) === mb_strtolower($stamm)) return false;

    // Automatik-Namen aus Kamera, Telefon und Screenshot-Werkzeugen.
    // Statt nach festen Mustern zu suchen, streichen wir alle Allerweltswoerter,
    // Zahlen und Trennzeichen. Bleibt nichts uebrig, war es kein Alternativtext,
    // sondern ein Dateiname — "WhatsApp Image 2024-03-02 at 14.21" etwa.
    $rest = preg_replace(
        '/\b(image|img|bild|foto|photo|dsc|dscn|pxl|mvimg|screenshot|bildschirmfoto|'
        . 'whatsapp|unbenannt|untitled|ohne|titel|kopie|copy|final|neu|new|at|um|von)\b/iu',
        ' ',
        $alt
    );
    $rest = preg_replace('/[\s_\-0-9().:,;]+/u', '', (string) $rest);
    if ($rest === '') return false;

    // Ein einzelnes Wort beschreibt kein Bild
    if (!preg_match('/\s/u', $alt)) return false;

    return true;
}

// Wie viele Bilder haben noch keine Groessenvarianten?
$ohneVarianten = 0;
try {
    $ohneVarianten = (int) $db->fetchColumn(
        "SELECT COUNT(*) FROM media
         WHERE (variants IS NULL OR variants = '' OR variants = '[]' OR variants = '{}')
           AND mime_type LIKE 'image/%'
           AND mime_type <> 'image/svg+xml'"
    );
} catch (Throwable $e) {
    $ohneVarianten = 0;
}

// Bilder, deren Alternativtext noch nichts taugt
$ohneAlt = 0;
foreach ($mediaItems as $m) {
    if (str_starts_with((string) $m['mime_type'], 'image/') && !altTextTaugt($m)) {
        $ohneAlt++;
    }
}
?>

<div x-data="mediaManager()">
    <!-- Upload Area -->
    <div class="admin-card mb-6">
        <div class="border-2 border-dashed border-gray-200 p-8 text-center hover:border-gray-400 transition-colors duration-200"
             @dragover.prevent="dragOver = true"
             @dragleave.prevent="dragOver = false"
             @drop.prevent="handleDrop($event)"
             :class="{ 'border-brand-accent bg-brand-accent/5': dragOver }">

            <svg class="w-8 h-8 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>

            <p class="text-sm text-gray-500 mb-3">Dateien hierher ziehen oder</p>

            <label class="admin-btn-primary text-xs h-8 px-4 cursor-pointer">
                Dateien auswählen
                <input type="file" class="hidden" multiple accept="image/*,.pdf"
                       @change="handleFileSelect($event)">
            </label>

            <p class="text-[10px] text-gray-400 mt-3">
                JPG, PNG, WebP, SVG, PDF — max. <?= formatFileSize(MAX_UPLOAD_SIZE) ?>
            </p>
        </div>

        <!-- Upload Progress -->
        <div x-show="uploading" x-cloak class="mt-3 text-sm text-gray-600">
            Wird hochgeladen...
        </div>
    </div>

    <!-- Groessenvarianten nachgenerieren -->
    <?php if ($ohneVarianten > 0): ?>
        <div class="admin-card mb-6" style="border-left:3px solid #C41018;">
            <div style="display:flex;flex-wrap:wrap;align-items:center;gap:16px;">
                <div style="flex:1;min-width:260px;">
                    <h3 style="font-size:14px;font-weight:600;color:#111;margin:0 0 6px 0;">
                        <?= (int) $ohneVarianten ?> Bilder werden noch in Originalgrösse ausgeliefert
                    </h3>
                    <p style="font-size:13px;color:#6B7280;line-height:1.6;margin:0;">
                        Jedes Gerät bekommt bei diesen Bildern dieselbe Datei — das Telefon lädt
                        also dieselben Megabyte wie der grosse Bildschirm. Beim Umwandeln entstehen
                        kleinere Fassungen daneben, und der Browser sucht sich die passende aus.
                        <strong>Die Originale bleiben unverändert.</strong>
                    </p>
                    <p x-show="regenLog" x-cloak x-text="regenLog"
                       style="font-size:12px;color:#374151;margin:10px 0 0 0;font-variant-numeric:tabular-nums;"></p>
                </div>
                <button type="button"
                        @click="regenerateVariants()"
                        :disabled="regenerating"
                        class="admin-btn-primary"
                        style="height:38px;padding:0 20px;font-size:13px;white-space:nowrap;"
                        :style="regenerating ? 'opacity:0.6;cursor:wait;' : ''">
                    <span x-show="!regenerating">Bilder jetzt umwandeln</span>
                    <span x-show="regenerating" x-cloak>Läuft …</span>
                </button>
            </div>
        </div>
    <?php endif; ?>

    <!-- Hinweis zu fehlenden Alternativtexten -->
    <?php if ($ohneAlt > 0): ?>
        <div class="admin-card mb-6" style="border-left:3px solid #C41018;">
            <h3 style="font-size:14px;font-weight:600;color:#111;margin:0 0 6px 0;">
                <?= (int) $ohneAlt ?> Bilder brauchen noch einen Alternativtext
            </h3>
            <p style="font-size:13px;color:#6B7280;line-height:1.6;margin:0;">
                Der Alternativtext beschreibt, was auf dem Bild zu sehen ist. Google liest ihn,
                und er wird vorgelesen, wenn jemand die Seite nicht sehen kann. Beim Hochladen
                trägt das CMS den Dateinamen ein — <em>image</em> oder <em>IMG_4213</em> nützt
                aber niemandem, deshalb zählen solche Einträge hier als fehlend.
            </p>
            <p style="font-size:13px;color:#374151;line-height:1.6;margin:10px 0 0 0;">
                <strong>Gut:</strong> „Verrohrtes GIS-Element in der Werkstatt in Pfäffikon“<br>
                <strong>Schlecht:</strong> „Sanitär Vorfabrikation GIS Elemente Pfäffikon SZ“
            </p>
            <p style="font-size:13px;color:#6B7280;line-height:1.6;margin:8px 0 0 0;">
                Beschreiben, was zu sehen ist — keine Suchbegriffe aneinanderreihen.
                Google merkt den Unterschied.
            </p>
        </div>
    <?php endif; ?>

    <!-- Media Grid -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        <?php foreach ($mediaItems as $media): ?>
            <?php
                $istBild  = str_starts_with((string) $media['mime_type'], 'image/');
                $altFehlt = $istBild && !altTextTaugt($media);
            ?>
            <div class="bg-white border border-gray-200 overflow-hidden">

                <!-- Bild mit Hover-Infos -->
                <div class="group relative bg-gray-100 aspect-[4/3] overflow-hidden">
                    <?php if ($istBild): ?>
                        <img src="<?= e(uploadUrl($media['thumb_path'] ?: $media['path'])) ?>"
                             alt="<?= e($media['alt_text']) ?>"
                             class="w-full h-full object-cover">
                    <?php else: ?>
                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    <?php endif; ?>

                    <?php if ($altFehlt): ?>
                        <span title="Alternativtext fehlt oder ist nur der Dateiname"
                              style="position:absolute;top:8px;left:8px;z-index:2;background:#C41018;color:#fff;font-size:11px;font-weight:700;letter-spacing:0.06em;line-height:1;padding:4px 7px;border-radius:3px;">
                            ALT
                        </span>
                    <?php endif; ?>

                    <div class="absolute inset-0 bg-black/70 opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex flex-col justify-end gap-1 p-3">
                        <span class="text-[12px] text-white/85 truncate"><?= e($media['original']) ?></span>
                        <span class="text-[12px] text-white/60">
                            <?= formatFileSize($media['file_size']) ?>
                            <?php if (!empty($media['width'])): ?>
                                · <?= (int) $media['width'] ?>×<?= (int) $media['height'] ?>
                            <?php endif; ?>
                        </span>
                        <div class="flex items-center justify-between mt-1">
                            <span class="text-[12px] text-white/45 font-mono">ID <?= (int) $media['id'] ?></span>
                            <button @click="deleteMedia(<?= (int) $media['id'] ?>)"
                                    class="text-[12px] text-brand-accent hover:text-white">
                                Löschen
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Alternativtext, dauerhaft sichtbar -->
                <?php if ($istBild): ?>
                    <div style="padding:10px;">
                        <label style="display:block;font-size:11px;text-transform:uppercase;letter-spacing:0.08em;color:<?= $altFehlt ? '#C41018' : '#9CA3AF' ?>;margin-bottom:5px;font-weight:600;">
                            Alternativtext
                        </label>
                        <input type="text"
                               id="alt-<?= (int) $media['id'] ?>"
                               value="<?= e($media['alt_text']) ?>"
                               placeholder="Was ist zu sehen?"
                               @change="saveAlt(<?= (int) $media['id'] ?>, $event.target.value)"
                               style="width:100%;background:#fff;border:1px solid <?= $altFehlt ? '#FCA5A5' : '#D1D5DB' ?>;color:#111;font-size:13px;padding:6px 8px;border-radius:3px;">
                    </div>
                <?php endif; ?>

            </div>
        <?php endforeach; ?>
    </div>

    <?php if (empty($mediaItems)): ?>
        <p class="text-center text-gray-400 text-sm py-12">Noch keine Medien hochgeladen.</p>
    <?php endif; ?>

    <!-- Toast -->
    <div x-show="toast" x-transition
         :class="toastType === 'success' ? 'toast-success' : 'toast-error'"
         x-text="toastMessage" x-cloak>
    </div>
</div>
