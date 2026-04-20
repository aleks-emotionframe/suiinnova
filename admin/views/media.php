<?php
/**
 * Admin — Medien-Manager
 */
$mediaItems = $db->fetchAll("SELECT * FROM media ORDER BY created_at DESC");
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

                <!-- Overlay on Hover -->
                <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex flex-col items-center justify-center gap-2">
                    <span class="text-[10px] text-white/80 truncate px-2 max-w-full"><?= e($media['original']) ?></span>
                    <span class="text-[10px] text-white/60"><?= formatFileSize($media['file_size']) ?></span>
                    <span class="text-[10px] text-white/60 font-mono">ID: <?= $media['id'] ?></span>
                    <button @click="deleteMedia(<?= $media['id'] ?>)"
                            class="text-[10px] text-brand-accent hover:text-white mt-1">
                        Löschen
                    </button>
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
