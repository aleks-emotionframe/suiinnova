<?php
/**
 * Karriere-Modal (Bewerbungs-Formular).
 * Event "open-career-modal" oeffnet es.
 * Komplett on-brand, Inline-Styles wo Tailwind nicht im Bundle.
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
     class="career-overlay"
     style="position:fixed;top:0;right:0;bottom:0;left:0;z-index:100;overflow-y:auto;background:rgba(0,0,0,0.7);backdrop-filter:blur(6px);">

    <div style="min-height:100%;display:flex;align-items:center;justify-content:center;padding:16px;box-sizing:border-box;">

        <div @click.away="open = false; document.body.style.overflow = '';"
             x-transition:enter="career-enter"
             x-transition:enter-start="career-enter-start"
             x-transition:enter-end="career-enter-end"
             class="career-card"
             style="background:#fff;width:100%;max-width:640px;margin:auto;border-radius:6px;box-shadow:0 25px 50px -12px rgba(0,0,0,0.5);position:relative;">

        <!-- Roter Akzent-Strich oben -->
        <div style="height:3px;background:#C41018;"></div>

        <!-- Schliessen-Button -->
        <button type="button" @click="open = false; document.body.style.overflow = '';"
                style="position:absolute;top:18px;right:18px;color:#9CA3AF;padding:6px;cursor:pointer;background:none;border:0;transition:color 0.15s;z-index:2;"
                onmouseover="this.style.color='#111'" onmouseout="this.style.color='#9CA3AF'"
                aria-label="Schliessen">
            <svg style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <!-- Header -->
        <div style="padding:32px 40px 24px 40px;border-bottom:1px solid #F3F4F6;">
            <div style="font-size:10px;font-weight:600;text-transform:uppercase;letter-spacing:0.25em;color:#C41018;margin-bottom:8px;">Offene Stelle</div>
            <h2 style="font-size:24px;font-weight:700;text-transform:uppercase;letter-spacing:0.05em;color:#111;line-height:1.2;margin:0;">
                <?= e($careerPosition) ?>
            </h2>
            <?php if ($careerIntro): ?>
                <p style="font-size:14px;color:#6B7280;line-height:1.6;margin:12px 0 0 0;max-width:520px;">
                    <?= e($careerIntro) ?>
                </p>
            <?php endif; ?>
        </div>

        <!-- Body -->
        <form action="<?= url('karriere/bewerben') ?>" method="POST" enctype="multipart/form-data"
              x-data="{ sending: false, files: [] }"
              @submit="sending = true"
              style="padding:28px 40px;">

            <?= csrfField() ?>
            <input type="hidden" name="form_loaded_at" value="<?= (int)$formLoadedAt ?>">
            <input type="hidden" name="app_position" value="<?= e($careerPosition) ?>">

            <!-- Honeypot -->
            <div style="position:absolute;left:-9999px;" aria-hidden="true">
                <input type="text" name="website_url" tabindex="-1" autocomplete="off">
            </div>

            <!-- Name + E-Mail -->
            <div class="career-grid-2" style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;">
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

            <!-- Telefon -->
            <div style="margin-bottom:16px;">
                <label for="app_phone" class="form-label">Telefon</label>
                <input type="tel" name="app_phone" id="app_phone"
                       placeholder="+41 ..." class="form-input">
            </div>

            <!-- Nachricht -->
            <div style="margin-bottom:20px;">
                <label for="app_message" class="form-label">Nachricht (optional)</label>
                <textarea name="app_message" id="app_message" rows="3"
                          placeholder="Verfuegbarkeit, Motivation, Fragen..."
                          class="form-textarea"></textarea>
            </div>

            <!-- File Upload (custom, kompakt) -->
            <div style="margin-bottom:24px;">
                <label class="form-label">Dokumente</label>

                <div @click="$refs.fileInput.click()"
                     @dragover.prevent="$el.style.borderColor='#C41018';$el.style.background='#FEF2F3';"
                     @dragleave.prevent="$el.style.borderColor='#D1D5DB';$el.style.background='#FAFAFA';"
                     @drop.prevent="$el.style.borderColor='#D1D5DB';$el.style.background='#FAFAFA';
                                    const d = Array.from($event.dataTransfer.files);
                                    const dt = new DataTransfer();
                                    d.forEach(f => dt.items.add(f));
                                    $refs.fileInput.files = dt.files;
                                    files = d.map(f => ({ name: f.name, size: f.size }));"
                     style="cursor:pointer;border:1.5px dashed #D1D5DB;border-radius:4px;padding:20px 16px;background:#FAFAFA;text-align:center;transition:all 0.15s;"
                     onmouseover="if(this.style.borderColor !== 'rgb(196, 16, 24)'){this.style.borderColor='#9CA3AF';}"
                     onmouseout="if(this.style.borderColor !== 'rgb(196, 16, 24)'){this.style.borderColor='#D1D5DB';}">

                    <svg style="width:28px;height:28px;margin:0 auto 8px;color:#6B7280;display:block;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>

                    <div style="font-size:13px;color:#111;font-weight:500;margin-bottom:4px;">
                        Dateien hierher ziehen oder <span style="color:#C41018;text-decoration:underline;text-underline-offset:2px;">auswählen</span>
                    </div>
                    <div style="font-size:10px;color:#9CA3AF;text-transform:uppercase;letter-spacing:0.08em;">
                        PDF · DOC · JPG · PNG — max. 10 MB, bis zu 5 Dateien
                    </div>

                    <input type="file" x-ref="fileInput" name="app_files[]" multiple
                           accept=".pdf,.doc,.docx,.odt,.jpg,.jpeg,.png,.webp"
                           @change="files = Array.from($event.target.files).map(f => ({ name: f.name, size: f.size }))"
                           style="display:none;">
                </div>

                <!-- Gewaehlte Dateien -->
                <template x-if="files.length > 0">
                    <ul style="margin-top:10px;padding:0;list-style:none;">
                        <template x-for="(f, idx) in files" :key="idx">
                            <li style="display:flex;align-items:center;gap:10px;padding:8px 12px;background:#F9FAFB;border:1px solid #F3F4F6;border-radius:4px;font-size:13px;margin-bottom:4px;">
                                <svg style="width:14px;height:14px;color:#C41018;flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <span x-text="f.name" style="flex:1;color:#111;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"></span>
                                <span x-text="(f.size / 1024).toFixed(0) + ' KB'" style="font-size:10px;color:#9CA3AF;text-transform:uppercase;letter-spacing:0.08em;flex-shrink:0;"></span>
                            </li>
                        </template>
                    </ul>
                </template>
            </div>

            <!-- Actions -->
            <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;padding-top:20px;border-top:1px solid #F3F4F6;">
                <button type="button" @click="open = false; document.body.style.overflow = '';"
                        style="background:none;border:0;font-size:11px;text-transform:uppercase;letter-spacing:0.08em;font-weight:500;color:#6B7280;cursor:pointer;transition:color 0.15s;"
                        onmouseover="this.style.color='#111'" onmouseout="this.style.color='#6B7280'">
                    Abbrechen
                </button>
                <button type="submit" :disabled="sending"
                        style="display:inline-flex;align-items:center;height:44px;padding:0 24px;border:0;border-radius:6px;background:#C41018;color:#fff;font-size:12px;font-weight:600;text-transform:uppercase;letter-spacing:0.1em;cursor:pointer;transition:opacity 0.15s;"
                        onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                    <span x-show="!sending">Bewerbung abschicken</span>
                    <span x-show="sending" x-cloak>Wird gesendet...</span>
                </button>
            </div>

            <p style="font-size:10px;color:#9CA3AF;text-align:center;text-transform:uppercase;letter-spacing:0.08em;margin-top:16px;">
                Ihre Daten werden vertraulich behandelt.
            </p>
        </form>
    </div>
    </div>
</div>

<style>
    @media (max-width: 640px) {
        .career-card > div:nth-child(2) { padding: 24px 20px 16px 20px !important; }
        .career-card > form { padding: 20px 20px !important; }
        .career-grid-2 { grid-template-columns: 1fr !important; }
    }
    .career-enter { transition: all 0.25s ease-out; }
    .career-enter-start { opacity: 0; transform: scale(0.96) translateY(16px); }
    .career-enter-end { opacity: 1; transform: scale(1) translateY(0); }
</style>
