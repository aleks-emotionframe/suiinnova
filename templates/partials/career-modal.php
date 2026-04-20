<?php
/**
 * Karriere-Modal (Bewerbungs-Formular mit Datei-Upload).
 * Wird ueber das Event "open-career-modal" geoeffnet.
 *
 * Alle Texte via Settings (CMS-editierbar).
 * Design passt zur Site (uppercase, tracking-wider, roter Akzent, weiche Buttons).
 */

if (setting('career_visible', '1') !== '1') return;

$careerPosition = setting('career_position', 'GIS-Element-Monteur (m/w/d)');
$careerIntro    = setting('career_intro', '');
$formLoadedAt   = time();
?>

<div x-data="{ open: false }"
     @open-career-modal.window="open = true; document.body.style.overflow = 'hidden';"
     @keydown.escape.window="if (open) { open = false; document.body.style.overflow = ''; }"
     x-show="open"
     x-cloak
     class="fixed inset-0 z-[100] flex items-center justify-center p-4 md:p-6"
     style="background:rgba(0,0,0,0.7);backdrop-filter:blur(6px);">

    <div @click.away="open = false; document.body.style.overflow = '';"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95 translate-y-4"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         class="bg-white w-full max-w-2xl max-h-[90vh] overflow-y-auto rounded-md shadow-2xl relative">

        <!-- Roter Akzent-Streifen oben -->
        <div style="height:3px;background:#C41018;"></div>

        <!-- Header -->
        <div class="px-6 md:px-10 py-6 md:py-7 border-b border-gray-100 flex items-start justify-between gap-4">
            <div class="flex-1 min-w-0">
                <div class="text-[10px] uppercase tracking-[0.25em] font-semibold mb-2" style="color:#C41018;">Offene Stelle — Bewerbung</div>
                <h2 class="text-xl md:text-2xl lg:text-3xl font-bold uppercase tracking-wider text-gray-900 leading-tight"><?= e($careerPosition) ?></h2>
                <?php if ($careerIntro): ?>
                    <p class="text-sm text-gray-600 leading-relaxed mt-3 max-w-lg"><?= e($careerIntro) ?></p>
                <?php endif; ?>
            </div>
            <button type="button" @click="open = false; document.body.style.overflow = '';"
                    class="text-gray-400 hover:text-gray-900 transition-colors p-2 -m-2 flex-shrink-0"
                    aria-label="Schliessen">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Body -->
        <form action="<?= url('karriere/bewerben') ?>" method="POST" enctype="multipart/form-data"
              class="px-6 md:px-10 py-6 md:py-8 space-y-6"
              x-data="{ sending: false, files: [] }"
              @submit="sending = true">

            <?= csrfField() ?>
            <input type="hidden" name="form_loaded_at" value="<?= (int)$formLoadedAt ?>">
            <input type="hidden" name="app_position" value="<?= e($careerPosition) ?>">

            <!-- Honeypot -->
            <div style="position:absolute;left:-9999px;" aria-hidden="true">
                <input type="text" name="website_url" tabindex="-1" autocomplete="off">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label for="app_name" class="form-label">Name *</label>
                    <input type="text" name="app_name" id="app_name" required
                           placeholder="Ihr Name" class="form-input">
                </div>
                <div>
                    <label for="app_email" class="form-label">E-Mail *</label>
                    <input type="email" name="app_email" id="app_email" required
                           placeholder="ihre@email.ch" class="form-input">
                </div>
            </div>

            <div>
                <label for="app_phone" class="form-label">Telefon</label>
                <input type="tel" name="app_phone" id="app_phone"
                       placeholder="+41 ..." class="form-input">
            </div>

            <div>
                <label for="app_message" class="form-label">Ihre Nachricht (optional)</label>
                <textarea name="app_message" id="app_message" rows="3"
                          placeholder="Kurz zu sich selbst, Verfuegbarkeit, Motivation..."
                          class="form-textarea"></textarea>
            </div>

            <!-- File Upload — komplett custom, keine native UI -->
            <div>
                <label class="form-label">Dokumente (Lebenslauf, Zeugnisse, ...)</label>

                <!-- Drop-Zone -->
                <div @click="$refs.fileInput.click()"
                     @dragover.prevent="$el.classList.add('is-dragging')"
                     @dragleave.prevent="$el.classList.remove('is-dragging')"
                     @drop.prevent="$el.classList.remove('is-dragging');
                                    const dropped = Array.from($event.dataTransfer.files);
                                    const dt = new DataTransfer();
                                    dropped.forEach(f => dt.items.add(f));
                                    $refs.fileInput.files = dt.files;
                                    files = dropped.map(f => ({ name: f.name, size: f.size }));"
                     class="career-dropzone cursor-pointer border border-dashed transition-all text-center"
                     style="border-color:#B4B4B4;border-radius:6px;padding:28px 20px;background:#FAFAFA;">

                    <svg class="w-9 h-9 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.25" style="color:#888;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>

                    <div class="text-sm text-gray-900 font-medium">
                        Dateien hierher ziehen oder <span style="color:#C41018;text-decoration:underline;text-underline-offset:2px;">auswählen</span>
                    </div>
                    <div class="text-[11px] text-gray-500 mt-1.5 uppercase tracking-wider">
                        PDF · DOC · DOCX · JPG · PNG · max. 10 MB · bis zu 5 Dateien
                    </div>

                    <input type="file" x-ref="fileInput" name="app_files[]" multiple
                           accept=".pdf,.doc,.docx,.odt,.jpg,.jpeg,.png,.webp"
                           @change="files = Array.from($event.target.files).map(f => ({ name: f.name, size: f.size }))"
                           style="display:none;">
                </div>

                <!-- Gewaehlte Dateien -->
                <template x-if="files.length > 0">
                    <ul class="mt-3 space-y-1.5">
                        <template x-for="(f, idx) in files" :key="idx">
                            <li class="flex items-center gap-3 text-sm bg-gray-50 px-3 py-2 border border-gray-100" style="border-radius:4px;">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" style="color:#C41018;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <span x-text="f.name" class="flex-1 text-gray-900 truncate"></span>
                                <span x-text="(f.size / 1024).toFixed(0) + ' KB'" class="text-[11px] text-gray-400 uppercase tracking-wider flex-shrink-0"></span>
                            </li>
                        </template>
                    </ul>
                </template>
            </div>

            <div class="pt-3 flex items-center justify-between gap-3 flex-wrap border-t border-gray-100 -mx-6 md:-mx-10 px-6 md:px-10 pt-5">
                <button type="button" @click="open = false; document.body.style.overflow = '';"
                        class="text-xs uppercase tracking-wider font-medium text-gray-500 hover:text-gray-900 transition-colors">
                    Abbrechen
                </button>
                <button type="submit" :disabled="sending"
                        class="inline-flex items-center h-11 px-7 rounded-md text-white text-xs font-semibold uppercase tracking-wider transition-all duration-200 hover:opacity-90 disabled:opacity-50"
                        style="background:#C41018;box-shadow:0 2px 10px rgba(196,16,24,0.25);">
                    <span x-show="!sending">Bewerbung abschicken</span>
                    <span x-show="sending" x-cloak>Wird gesendet...</span>
                    <svg x-show="!sending" class="w-3.5 h-3.5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </button>
            </div>

            <p class="text-[10px] text-gray-400 text-center uppercase tracking-wider">
                Ihre Daten werden vertraulich behandelt und ausschliesslich fuer den Bewerbungsprozess verwendet.
            </p>
        </form>
    </div>
</div>

<style>
    .career-dropzone.is-dragging { border-color: #C41018 !important; background: #FEF2F3 !important; }
    .career-dropzone:hover { border-color: #888; background: #F5F5F5; }
</style>
