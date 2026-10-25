<?php
/**
 * Admin — Medien-Manager
 */
// Spalte fuer die Groessenvarianten sicherstellen, bevor wir sie auslesen
ensureMediaVariantsColumn();

$mediaItems = $db->fetchAll("SELECT * FROM media ORDER BY created_at DESC");

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

    <!-- Media Grid -->
    <div class="grid grid-cols-3 md:grid-cols-5 lg:grid-cols-6 gap-3">
        <?php foreach ($mediaItems as $media): ?>
            <div class="group relative bg-gray-100 aspect-square overflow-hidden"
                 x-data="{ showInfo: false }">

                <?php if (str_starts_with($media['mime_type'], 'image/')): ?>
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

                <!-- Hinweis, wenn dem Bild der Alternativtext fehlt -->
                <?php if (str_starts_with($media['mime_type'], 'image/') && trim((string) $media['alt_text']) === ''): ?>
                    <span title="Alternativtext fehlt"
                          style="position:absolute;top:6px;left:6px;z-index:2;background:#C41018;color:#fff;font-size:12px;font-weight:700;line-height:1;padding:3px 6px;border-radius:3px;">
                        ALT
                    </span>
                <?php endif; ?>

                <!-- Overlay on Hover -->
                <div class="absolute inset-0 bg-black/70 opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex flex-col justify-center gap-1.5 p-2">
                    <span class="text-[12px] text-white/80 truncate"><?= e($media['original']) ?></span>
                    <span class="text-[12px] text-white/60">
                        <?= formatFileSize($media['file_size']) ?>
                        <?php if (!empty($media['width'])): ?>
                            · <?= (int) $media['width'] ?>×<?= (int) $media['height'] ?>
                        <?php endif; ?>
                    </span>

                    <?php if (str_starts_with($media['mime_type'], 'image/')): ?>
                        <label class="text-[12px] text-white/50 mt-1">Alternativtext</label>
                        <input type="text"
                               value="<?= e($media['alt_text']) ?>"
                               placeholder="Was ist zu sehen?"
                               @change="saveAlt(<?= (int) $media['id'] ?>, $event.target.value)"
                               @click.stop
                               style="width:100%;background:rgba(255,255,255,0.12);border:1px solid rgba(255,255,255,0.25);color:#fff;font-size:12px;padding:4px 6px;border-radius:3px;">
                    <?php endif; ?>

                    <div class="flex items-center justify-between mt-1">
                        <span class="text-[12px] text-white/40 font-mono">ID <?= $media['id'] ?></span>
                        <button @click="deleteMedia(<?= $media['id'] ?>)"
                                class="text-[12px] text-brand-accent hover:text-white">
                            Löschen
                        </button>
                    </div>
                </div>
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
