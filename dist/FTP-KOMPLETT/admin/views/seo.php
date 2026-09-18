<?php
/**
 * Admin — SEO & Suchmaschinen
 *
 * Zentrale Seite fuer:
 * - Globale SEO-Einstellungen (Title Suffix, Default Meta Description, Favicon, OG-Image, Verification Codes, robots)
 * - Pro-Seite SEO (Meta Title + Meta Description inline editierbar)
 * - Sitemap-Status
 */

$pages = $db->fetchAll("SELECT id, title, slug, meta_title, meta_desc, is_active, is_homepage FROM pages ORDER BY sort_order ASC");

$globalFields = [
    [
        'label'       => 'Globale Einstellungen',
        'description' => 'Diese Werte werden auf allen Seiten verwendet, wenn pro Seite nichts angegeben ist.',
        'fields' => [
            'meta_title_suffix'        => ['label' => 'Title-Suffix', 'type' => 'text', 'hint' => 'Wird hinter jedem Seitentitel angehaengt. Beispiel: „Pfäffikon SZ"'],
            'default_meta_description' => ['label' => 'Fallback-Meta-Description', 'type' => 'textarea', 'hint' => 'Wird verwendet, wenn eine Seite keine eigene hat. Max. 160 Zeichen empfohlen.'],
        ],
    ],
    [
        'label'       => 'Branding / Social Sharing',
        'description' => 'Bilder & Icons, die Google, Facebook, LinkedIn etc. verwenden.',
        'fields' => [
            'favicon_url'   => ['label' => 'Favicon URL', 'type' => 'text', 'hint' => 'Kleines Icon im Browser-Tab. Empfohlen: 32×32 PNG oder ICO. URL aus Medien-Bibliothek kopieren.'],
            'og_image_url'  => ['label' => 'OpenGraph / Social-Share Bild', 'type' => 'text', 'hint' => 'Bild, das beim Teilen auf Facebook, LinkedIn, WhatsApp etc. erscheint. Empfohlen: 1200×630 px.'],
        ],
    ],
    [
        'label'       => 'Suchmaschinen-Verifizierung',
        'description' => 'Bestätigungs-Codes für Google Search Console & Bing Webmaster Tools.',
        'fields' => [
            'google_site_verification' => ['label' => 'Google Search Console Verification-Code', 'type' => 'text', 'hint' => 'Nur den Inhalt des content="..."-Attributs einfügen (ohne Meta-Tag-Umgebung).'],
            'bing_site_verification'   => ['label' => 'Bing Webmaster Verification-Code', 'type' => 'text', 'hint' => 'Inhalt aus dem meta-Tag <meta name="msvalidate.01" content="...">.'],
        ],
    ],
    [
        'label'       => 'Web-Analyse',
        'description' => 'Google Analytics — wird nur geladen wenn der Besucher im Cookie-Banner „Alle akzeptieren" wählt.',
        'fields' => [
            'google_analytics_id' => ['label' => 'Google Analytics Mess-ID', 'type' => 'text', 'hint' => 'GA4-Mess-ID im Format G-XXXXXXXXXX. Leer lassen = kein Analytics. IP-Anonymisierung ist automatisch aktiv.'],
        ],
    ],
    [
        'label'       => 'Indexierung',
        'description' => 'Globale Suchmaschinen-Sichtbarkeit.',
        'fields' => [
            'seo_noindex' => ['label' => 'noindex/nofollow aktivieren (Website aus Google entfernen!)', 'type' => 'checkbox', 'hint' => 'Nur aktivieren, wenn die Seite vorübergehend aus Suchmaschinen verschwinden soll.'],
        ],
    ],
];
?>

<div x-data="seoManager()">

    <!-- Sitemap-Status -->
    <div class="admin-card mb-6" style="border-left:3px solid #111;">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h2 class="text-xs font-medium uppercase tracking-wider text-gray-500 mb-2">Sitemap</h2>
                <p class="text-sm text-gray-900 mb-1">Die Sitemap aktualisiert sich automatisch aus der Datenbank — sie enthält alle aktiven Seiten.</p>
                <p class="text-xs text-gray-500">In der Google Search Console unter „Sitemaps" einreichen: <code class="bg-gray-100 px-1.5 py-0.5 text-xs"><?= e(SITE_URL) ?>/sitemap.xml</code></p>
            </div>
            <a href="<?= url('sitemap.xml') ?>" target="_blank" class="admin-btn-secondary text-xs h-7 px-3 whitespace-nowrap">
                Sitemap öffnen ↗
            </a>
        </div>
    </div>

    <!-- Globale SEO-Einstellungen -->
    <form @submit.prevent="saveSettings($event.target)">
        <?php foreach ($globalFields as $group): ?>
            <div class="admin-card mb-6">
                <h2 class="text-xs font-medium uppercase tracking-wider text-gray-500 mb-1"><?= e($group['label']) ?></h2>
                <p class="text-xs text-gray-400 mb-4"><?= e($group['description']) ?></p>

                <div class="space-y-4">
                    <?php foreach ($group['fields'] as $key => $field): ?>
                        <div>
                            <label class="admin-label"><?= e($field['label']) ?></label>
                            <?php if ($field['type'] === 'textarea'): ?>
                                <textarea name="settings[<?= e($key) ?>]" rows="2"
                                          class="admin-textarea"><?= e(setting($key)) ?></textarea>
                            <?php elseif ($field['type'] === 'checkbox'): ?>
                                <label style="display:inline-flex;align-items:center;gap:8px;cursor:pointer;">
                                    <input type="checkbox" name="settings[<?= e($key) ?>]" value="1" <?= setting($key) === '1' ? 'checked' : '' ?>>
                                    <span class="text-sm text-gray-700">aktiviert</span>
                                </label>
                            <?php else: ?>
                                <input type="text" name="settings[<?= e($key) ?>]"
                                       value="<?= e(setting($key)) ?>"
                                       class="admin-input">
                            <?php endif; ?>
                            <?php if (!empty($field['hint'])): ?>
                                <p class="text-xs text-gray-400 mt-1"><?= e($field['hint']) ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>

        <button type="submit" class="admin-btn-primary" :disabled="saving">
            <span x-show="!saving">Globale SEO-Einstellungen speichern</span>
            <span x-show="saving" x-cloak>Speichere...</span>
        </button>
    </form>

    <!-- Pro-Seite SEO -->
    <div class="admin-card mt-10">
        <h2 class="text-xs font-medium uppercase tracking-wider text-gray-500 mb-1">SEO pro Seite</h2>
        <p class="text-xs text-gray-400 mb-4">Meta-Title und Meta-Description für jede Seite einzeln. Änderungen werden beim Verlassen des Feldes automatisch gespeichert.</p>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="text-left text-[10px] uppercase tracking-wider text-gray-400 font-medium pb-3 pr-4" style="width:18%;">Seite</th>
                        <th class="text-left text-[10px] uppercase tracking-wider text-gray-400 font-medium pb-3 pr-4" style="width:32%;">Meta-Title</th>
                        <th class="text-left text-[10px] uppercase tracking-wider text-gray-400 font-medium pb-3" style="width:50%;">Meta-Description</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pages as $p): ?>
                        <tr class="border-b border-gray-50 align-top" <?= !$p['is_active'] ? 'style="opacity:0.6;"' : '' ?>>
                            <td class="py-3 pr-4">
                                <div class="flex items-center gap-2">
                                    <?php if ($p['is_homepage']): ?>
                                        <svg class="w-3.5 h-3.5 text-brand-accent flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                                        </svg>
                                    <?php endif; ?>
                                    <div>
                                        <div class="font-medium text-gray-900"><?= e($p['title']) ?></div>
                                        <div class="text-xs text-gray-400">/<?= e($p['slug']) ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 pr-4">
                                <input type="text"
                                       value="<?= e($p['meta_title'] ?? '') ?>"
                                       placeholder="<?= e($p['title']) ?>"
                                       class="admin-input"
                                       @change="savePageMeta(<?= (int)$p['id'] ?>, 'meta_title', $event.target.value)">
                                <div class="text-[10px] text-gray-400 mt-1">Wenn leer: Seitentitel wird verwendet</div>
                            </td>
                            <td class="py-3">
                                <textarea rows="2"
                                          placeholder="Kurze Beschreibung für Google-Snippets (max. 160 Zeichen)"
                                          class="admin-textarea"
                                          @change="savePageMeta(<?= (int)$p['id'] ?>, 'meta_desc', $event.target.value)"><?= e($p['meta_desc'] ?? '') ?></textarea>
                                <div class="text-[10px] text-gray-400 mt-1" x-data="{ c: <?= mb_strlen($p['meta_desc'] ?? '') ?> }"
                                     @input="c = $event.target.value?.length || c">
                                    <span x-text="c"></span> Zeichen (Empfehlung: 120–160)
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Toast -->
    <div x-show="toast" x-transition x-cloak
         :class="toastType === 'success' ? 'toast-success' : 'toast-error'"
         x-text="toastMessage"></div>
</div>

<script>
function seoManager() {
    return {
        saving: false,
        toast: false,
        toastType: 'success',
        toastMessage: '',

        async saveSettings(form) {
            this.saving = true;
            const formData = new FormData(form);
            formData.append('csrf_token', CSRF_TOKEN);

            try {
                const resp = await fetch('/admin/api/save-settings.php', { method: 'POST', body: formData });
                const data = await resp.json();
                this.showToast(data.message || 'Gespeichert', data.error ? 'error' : 'success');
            } catch (e) {
                this.showToast('Netzwerkfehler', 'error');
            } finally {
                this.saving = false;
            }
        },

        async savePageMeta(pageId, field, value) {
            const formData = new FormData();
            formData.append('page_id', pageId);
            formData.append('field', field);
            formData.append('value', value);
            formData.append('csrf_token', CSRF_TOKEN);

            try {
                const resp = await fetch('/admin/api/save-page-meta.php', { method: 'POST', body: formData });
                const data = await resp.json();
                this.showToast(data.error || 'Gespeichert', data.error ? 'error' : 'success');
            } catch (e) {
                this.showToast('Netzwerkfehler', 'error');
            }
        },

        showToast(message, type) {
            this.toastType = type;
            this.toastMessage = message;
            this.toast = true;
            setTimeout(() => { this.toast = false; }, 2500);
        }
    };
}
</script>
