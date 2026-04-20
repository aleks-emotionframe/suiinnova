<?php
/**
 * Karriere-Modal (Bewerbungs-Formular mit Datei-Upload).
 * Wird ueber das Event "open-career-modal" geoeffnet.
 *
 * Alle Texte via Settings (CMS-editierbar).
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
     class="fixed inset-0 z-[100] flex items-center justify-center p-4"
     style="background:rgba(0,0,0,0.65);backdrop-filter:blur(4px);">

    <div @click.away="open = false; document.body.style.overflow = '';"
         x-transition:enter="transition ease-out duration-250"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         class="bg-white w-full max-w-2xl max-h-[90vh] overflow-y-auto shadow-2xl">

        <!-- Header -->
        <div class="px-6 md:px-8 py-5 border-b border-gray-100 flex items-start justify-between">
            <div>
                <div class="text-[10px] uppercase tracking-[0.2em] font-semibold" style="color:#C41018;">Bewerbung</div>
                <h2 class="text-xl md:text-2xl font-bold uppercase tracking-wide text-gray-900 mt-1"><?= e($careerPosition) ?></h2>
            </div>
            <button type="button" @click="open = false; document.body.style.overflow = '';"
                    class="text-gray-400 hover:text-gray-900 transition-colors p-1 -m-1"
                    aria-label="Schliessen">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Body -->
        <form action="<?= url('karriere/bewerben') ?>" method="POST" enctype="multipart/form-data"
              class="px-6 md:px-8 py-6 space-y-5"
              x-data="{ sending: false, fileNames: [] }"
              @submit="sending = true">

            <?= csrfField() ?>
            <input type="hidden" name="form_loaded_at" value="<?= (int)$formLoadedAt ?>">
            <input type="hidden" name="app_position" value="<?= e($careerPosition) ?>">

            <!-- Honeypot -->
            <div class="absolute -left-[9999px]" aria-hidden="true">
                <input type="text" name="website_url" tabindex="-1" autocomplete="off">
            </div>

            <?php if ($careerIntro): ?>
                <p class="text-sm text-gray-600 leading-relaxed"><?= e($careerIntro) ?></p>
            <?php endif; ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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

            <!-- File Upload -->
            <div>
                <label class="form-label">Dokumente (Lebenslauf, Zeugnisse, ...)</label>
                <label for="app_files"
                       class="block border-2 border-dashed border-gray-300 hover:border-gray-500 transition-colors cursor-pointer p-5 text-center">
                    <svg class="w-8 h-8 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <div class="text-sm text-gray-700 font-medium">Dateien auswaehlen</div>
                    <div class="text-xs text-gray-400 mt-1">PDF, DOC, DOCX, JPG, PNG, WebP - max. 10 MB pro Datei, bis zu 5 Dateien</div>
                    <input type="file" id="app_files" name="app_files[]" multiple
                           accept=".pdf,.doc,.docx,.odt,.jpg,.jpeg,.png,.webp"
                           class="sr-only"
                           @change="fileNames = Array.from($event.target.files).map(f => f.name)">
                </label>

                <!-- Gewaehlte Dateien -->
                <template x-if="fileNames.length > 0">
                    <ul class="mt-3 space-y-1 text-xs text-gray-600">
                        <template x-for="name in fileNames" :key="name">
                            <li class="flex items-center gap-2">
                                <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span x-text="name"></span>
                            </li>
                        </template>
                    </ul>
                </template>
            </div>

            <div class="pt-3 flex items-center justify-between gap-3 flex-wrap">
                <button type="button" @click="open = false; document.body.style.overflow = '';"
                        class="text-sm text-gray-500 hover:text-gray-900 transition-colors">
                    Abbrechen
                </button>
                <button type="submit" :disabled="sending"
                        class="inline-flex items-center h-11 px-6 text-white text-sm font-medium uppercase tracking-wider transition-opacity hover:opacity-90"
                        style="background:#C41018;">
                    <span x-show="!sending">Bewerbung abschicken</span>
                    <span x-show="sending" x-cloak>Wird gesendet...</span>
                </button>
            </div>

            <p class="text-[10px] text-gray-400 text-center pt-1">
                Ihre Daten werden vertraulich behandelt und ausschliesslich fuer den Bewerbungsprozess verwendet.
            </p>
        </form>
    </div>
</div>
