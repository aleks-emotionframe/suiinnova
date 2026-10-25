<?php
/**
 * Admin — Referenzen (zentral)
 *
 * Wird auf der Startseite und Referenzen-Seite verwendet.
 * CRUD + Reihenfolge + aktiv/inaktiv.
 *
 * Self-healing: legt Tabelle und Default-Referenzen an, falls noch nicht vorhanden.
 */

// ── Self-Heal: Tabelle anlegen falls nicht vorhanden ──
try {
    $db->query("CREATE TABLE IF NOT EXISTS ref_items (
        id               INT AUTO_INCREMENT PRIMARY KEY,
        title            VARCHAR(255) NOT NULL,
        description      TEXT         DEFAULT NULL,
        category         VARCHAR(100) DEFAULT NULL,
        city             VARCHAR(100) DEFAULT NULL,
        year             INT          DEFAULT NULL,
        image_id         INT          DEFAULT NULL,
        is_active        TINYINT(1)   NOT NULL DEFAULT 1,
        is_featured_home TINYINT(1)   NOT NULL DEFAULT 0,
        sort_order       INT          NOT NULL DEFAULT 0,
        home_order       INT          NOT NULL DEFAULT 0,
        created_at       DATETIME     DEFAULT CURRENT_TIMESTAMP,
        updated_at       DATETIME     DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_sort (sort_order),
        INDEX idx_active (is_active),
        INDEX idx_home (is_featured_home, home_order)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
} catch (Exception $e) {}

// ── Self-Heal: neue Spalten falls Tabelle aus alter Version ──
try { $db->query("ALTER TABLE ref_items ADD COLUMN is_featured_home TINYINT(1) NOT NULL DEFAULT 0"); } catch (Exception $e) {}
try { $db->query("ALTER TABLE ref_items ADD COLUMN home_order INT NOT NULL DEFAULT 0"); } catch (Exception $e) {}
try { $db->query("ALTER TABLE ref_items ADD INDEX idx_home (is_featured_home, home_order)"); } catch (Exception $e) {}

// ── Self-Heal: Wenn keine Featured-Refs existieren, die ersten 6 aktiven als Featured markieren ──
try {
    $featuredCount = (int)$db->fetchColumn("SELECT COUNT(*) FROM ref_items WHERE is_featured_home = 1");
    if ($featuredCount === 0) {
        $first6 = $db->fetchAll("SELECT id FROM ref_items WHERE is_active = 1 ORDER BY sort_order ASC, id ASC LIMIT 6");
        foreach ($first6 as $i => $row) {
            $db->update('ref_items', [
                'is_featured_home' => 1,
                'home_order'       => $i + 1,
            ], 'id = :id', ['id' => $row['id']]);
        }
    }
} catch (Exception $e) {}

// ── Self-Heal: Startseiten-References-Grid auf source=featured + limit=6 setzen (nur einmal) ──
try {
    $db->query("UPDATE sections s
        JOIN pages p ON p.id = s.page_id
        SET s.content = JSON_SET(
            COALESCE(s.content, JSON_OBJECT()),
            '$.source', 'featured',
            '$.limit',  6
        )
        WHERE s.type = 'references-grid'
          AND p.is_homepage = 1
          AND (JSON_EXTRACT(s.content, '$.source') IS NULL
               OR JSON_UNQUOTE(JSON_EXTRACT(s.content, '$.source')) NOT IN ('featured', 'all'))");
} catch (Exception $e) {}

// ── Self-Heal: Referenzen-Daten sicherstellen ──
$count = 0;
$hasOldExamples = 0;
try {
    $count = (int)$db->fetchColumn("SELECT COUNT(*) FROM ref_items");
    // Alte Beispiel-Daten erkennen (meine Platzhalter)
    $hasOldExamples = (int)$db->fetchColumn("SELECT COUNT(*) FROM ref_items WHERE title IN ('Wohnüberbauung Limmatfeld','Geschäftshaus Europaallee','Spital Limmattal Erweiterung','Schulanlage Leutschenbach','Alterszentrum Grünau','Industriepark Glattbrugg')");
} catch (Exception $e) {}

// Die echten 6 Referenzen aus der Startseite (SUI Innova)
$realRefs = [
    // [title,                              category,              city,                         description (optional)]
    ['Wohnüberbauung Neualtwil',     '8 Mehrfamilienhäuser', 'Neualtwil SG',               ''],
    ['Industrieplatz Ost',           'Wohnen, Gewerbe',      'Neuhausen am Rheinfall SH',  ''],
    ['Wohnüberbauung Aupark',        'Wohnen, Gewerbe',      'Wädenswil ZH',               ''],
    ['Schulanlage im Isengrind',     'Schule',               'Affoltern ZH',               ''],
    ['Wohnüberbauung im Ämet',       'Wohnen',               'Birmensdorf ZH',             ''],
    ['Wohnüberbauung Nidfeld',       'Wohnen',               'Kriens LU',                  ''],
];

// Wenn Tabelle leer ODER noch meine Beispiele drin → mit echten Referenzen befuellen
if ($count === 0 || $hasOldExamples > 0) {
    try {
        if ($hasOldExamples > 0) {
            // Nur die alten Beispiele löschen, nicht neu hinzugefuegte
            $db->query("DELETE FROM ref_items WHERE title IN ('Wohnüberbauung Limmatfeld','Geschäftshaus Europaallee','Spital Limmattal Erweiterung','Schulanlage Leutschenbach','Alterszentrum Grünau','Industriepark Glattbrugg')");
        }

        foreach ($realRefs as $i => [$title, $cat, $city, $desc]) {
            // Nur einfuegen, wenn dieser Titel noch nicht existiert (idempotent)
            $exists = (int)$db->fetchColumn("SELECT COUNT(*) FROM ref_items WHERE title = :t", ['t' => $title]);
            if ($exists === 0) {
                $db->insert('ref_items', [
                    'title'       => $title,
                    'description' => $desc !== '' ? $desc : null,
                    'category'    => $cat,
                    'city'        => $city,
                    'year'        => null,
                    'sort_order'  => $i + 1,
                    'is_active'   => 1,
                ]);
            }
        }

        // Bestehende references-grid-Sektionen zuruecksetzen, damit sie aus ref_items ziehen
        $db->query("UPDATE sections SET content = JSON_SET(COALESCE(content, JSON_OBJECT()), '$.items', JSON_ARRAY()) WHERE type = 'references-grid'");
    } catch (Exception $e) {}
}

$refs = [];
$featuredCount = 0;
try {
    $refs = $db->fetchAll("SELECT * FROM ref_items ORDER BY sort_order ASC, id ASC");
    $featuredCount = (int)$db->fetchColumn("SELECT COUNT(*) FROM ref_items WHERE is_featured_home = 1");
} catch (Exception $e) {}
?>

<div x-data="referencesManager()">

    <!-- Header -->
    <div class="admin-card mb-6" style="border-left:3px solid #111;">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h2 class="text-xs font-medium uppercase tracking-wider text-gray-500 mb-2">Referenzen zentral verwalten</h2>
                <p class="text-sm text-gray-700 mb-2">Einmal eintragen – überall auf der Website sichtbar. Auf der <strong>Referenzen-Seite</strong> erscheinen alle aktiven Einträge. Auf der <strong>Startseite</strong> nur die als „Auf Startseite" markierten (in der eingestellten Reihenfolge, max. 6).</p>
                <p class="text-xs text-gray-500">
                    <span style="display:inline-flex;align-items:center;gap:6px;">
                        <span style="width:8px;height:8px;border-radius:50%;background:#C41018;"></span>
                        <strong><?= $featuredCount ?></strong> von max. 6 Referenzen aktuell auf der Startseite
                    </span>
                </p>
            </div>
            <button type="button" @click="startNew()" class="admin-btn-primary text-xs h-9 px-4 whitespace-nowrap">
                + Neue Referenz
            </button>
        </div>
    </div>

    <!-- Add / Edit Form -->
    <template x-if="editing !== null">
        <div class="admin-card mb-6" style="border-left:3px solid #C41018;">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-sm font-semibold uppercase tracking-wider text-gray-900" x-text="editing.id ? 'Referenz bearbeiten' : 'Neue Referenz'"></h3>
                <button type="button" @click="editing = null" class="text-gray-400 hover:text-gray-900">
                    <svg style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="admin-label">Projekt-Titel *</label>
                    <input type="text" x-model="editing.title" class="admin-input" placeholder="z.B. Wohnüberbauung Limmatfeld">
                </div>
                <div>
                    <label class="admin-label">Kategorie (erster Tag)</label>
                    <input type="text" x-model="editing.category" class="admin-input" placeholder="z.B. Wohnbau">
                </div>
                <div>
                    <label class="admin-label">Ort / Stadt (zweiter Tag)</label>
                    <input type="text" x-model="editing.city" class="admin-input" placeholder="z.B. Zürich">
                </div>
                <div>
                    <label class="admin-label">Fertigstellungsjahr (optional)</label>
                    <input type="number" x-model="editing.year" class="admin-input" placeholder="2024" min="1990" max="2100">
                </div>
            </div>

            <div class="mb-4">
                <label class="admin-label">Beschreibung</label>
                <textarea x-model="editing.description" rows="3" class="admin-textarea" placeholder="Kurze Projekt-Beschreibung..."></textarea>
            </div>

            <div class="mb-5">
                <label class="admin-label">Projekt-Bild</label>
                <div class="flex items-center gap-4">
                    <div style="width:120px;height:90px;border:1px solid #E5E7EB;border-radius:4px;background:#F9FAFB;display:flex;align-items:center;justify-content:center;overflow:hidden;flex-shrink:0;">
                        <template x-if="editing.image_url">
                            <img :src="editing.image_url" style="width:100%;height:100%;object-fit:cover;">
                        </template>
                        <template x-if="!editing.image_url">
                            <svg style="width:28px;height:28px;color:#D1D5DB;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v13.5A1.5 1.5 0 003.75 21z"/>
                            </svg>
                        </template>
                    </div>
                    <div class="flex gap-2">
                        <button type="button" @click="openMediaPickerForRef()" class="admin-btn-secondary text-xs h-9 px-3">
                            Bild wählen
                        </button>
                        <button type="button" x-show="editing.image_id" @click="editing.image_id = null; editing.image_url = ''" class="text-xs text-gray-500 hover:text-gray-900 underline">
                            entfernen
                        </button>
                    </div>
                </div>
            </div>

            <!-- Sichtbarkeit + Startseite-Block -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4 border-t border-gray-100 mb-4">
                <!-- Allgemein aktiv -->
                <div>
                    <label style="display:inline-flex;align-items:center;gap:8px;cursor:pointer;font-size:13px;">
                        <input type="checkbox" x-model="editing.is_active_bool" style="width:16px;height:16px;accent-color:#111;">
                        <span>Aktiv (auf Website anzeigen)</span>
                    </label>
                    <p class="text-[11px] text-gray-400 mt-1.5">Inaktive Referenzen werden nirgendwo angezeigt.</p>
                </div>

                <!-- Startseite-Anzeige -->
                <div style="background:#FEF2F3;padding:12px;border-radius:4px;border:1px solid #FBE5E7;">
                    <label style="display:inline-flex;align-items:center;gap:8px;cursor:pointer;font-size:13px;">
                        <input type="checkbox" x-model="editing.is_featured_home_bool" style="width:16px;height:16px;accent-color:#C41018;">
                        <span><strong>Auf Startseite anzeigen</strong></span>
                    </label>
                    <div x-show="editing.is_featured_home_bool" x-transition class="mt-2.5">
                        <label style="font-size:11px;color:#6B7280;text-transform:uppercase;letter-spacing:0.05em;display:block;margin-bottom:4px;">Reihenfolge auf Startseite</label>
                        <input type="number" x-model="editing.home_order" min="1" max="99" class="admin-input" style="max-width:120px;" placeholder="1-6">
                        <p class="text-[11px] text-gray-500 mt-1.5">1 = erste Position, 2 = zweite, usw. Maximal 6 Referenzen werden auf der Startseite angezeigt.</p>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3">
                <button type="button" @click="editing = null" class="text-xs text-gray-500 hover:text-gray-900 uppercase tracking-wider">
                    Abbrechen
                </button>
                <button type="button" @click="saveReference()" :disabled="saving" class="admin-btn-primary text-xs h-9 px-5">
                    <span x-show="!saving" x-text="editing.id ? 'Änderungen speichern' : 'Referenz anlegen'"></span>
                    <span x-show="saving">Speichere...</span>
                </button>
            </div>
        </div>
    </template>

    <!-- Liste -->
    <div class="admin-card">
        <?php if (!$refs): ?>
            <p class="text-sm text-gray-500 text-center py-8">Noch keine Referenzen. Oben mit „+ Neue Referenz" anlegen.</p>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="text-left text-[10px] uppercase tracking-wider text-gray-400 font-medium pb-3">Bild</th>
                            <th class="text-left text-[10px] uppercase tracking-wider text-gray-400 font-medium pb-3">Projekt</th>
                            <th class="text-left text-[10px] uppercase tracking-wider text-gray-400 font-medium pb-3">Kategorie / Ort</th>
                            <th class="text-left text-[10px] uppercase tracking-wider text-gray-400 font-medium pb-3">Status</th>
                            <th class="text-left text-[10px] uppercase tracking-wider text-gray-400 font-medium pb-3">Startseite</th>
                            <th class="text-right text-[10px] uppercase tracking-wider text-gray-400 font-medium pb-3">Aktion</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($refs as $r): ?>
                            <?php
                            $imgUrl = '';
                            if (!empty($r['image_id'])) {
                                $m = $db->fetch("SELECT path FROM media WHERE id = :id", ['id' => $r['image_id']]);
                                if ($m) $imgUrl = uploadUrl($m['path']);
                            }
                            ?>
                            <tr class="border-b border-gray-50" :class="{ 'opacity-50': false }">
                                <td class="py-3">
                                    <div style="width:64px;height:48px;border:1px solid #E5E7EB;border-radius:3px;background:#F9FAFB;overflow:hidden;">
                                        <?php if ($imgUrl): ?>
                                            <img src="<?= e($imgUrl) ?>" style="width:100%;height:100%;object-fit:cover;">
                                        <?php else: ?>
                                            <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:#D1D5DB;font-size:10px;">–</div>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="py-3">
                                    <div class="font-medium text-gray-900"><?= e($r['title']) ?></div>
                                    <?php if ($r['description']): ?>
                                        <div class="text-xs text-gray-400 mt-0.5" style="max-width:340px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"><?= e($r['description']) ?></div>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3 text-xs text-gray-600">
                                    <?= e($r['category'] ?? '') ?><?= ($r['category'] && $r['city']) ? ' · ' : '' ?><?= e($r['city'] ?? '') ?>
                                    <?php if ($r['year']): ?><span class="text-gray-400"> · <?= (int)$r['year'] ?></span><?php endif; ?>
                                </td>
                                <td class="py-3">
                                    <?php if ($r['is_active']): ?>
                                        <span class="inline-flex items-center px-1.5 py-0.5 bg-gray-900 text-white text-[10px] font-medium">AKTIV</span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center px-1.5 py-0.5 text-white text-[10px] font-medium" style="background:#9CA3AF;">INAKTIV</span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3">
                                    <?php if ((int)($r['is_featured_home'] ?? 0) === 1): ?>
                                        <span class="inline-flex items-center gap-1.5 px-2 py-1 text-white text-[10px] font-medium" style="background:#C41018;border-radius:3px;">
                                            <span style="width:5px;height:5px;border-radius:50%;background:#fff;"></span>
                                            POS. <?= (int)($r['home_order'] ?? 0) ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-[10px] text-gray-400 uppercase tracking-wider">—</span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3 text-right">
                                    <div class="inline-flex items-center gap-2">
                                        <button type="button" @click='startEdit(<?= json_encode($r, JSON_HEX_APOS|JSON_HEX_QUOT) ?>, "<?= e($imgUrl) ?>")'
                                                class="admin-btn-secondary text-xs h-7 px-3">
                                            Bearbeiten
                                        </button>
                                        <button type="button" @click="deleteReference(<?= (int)$r['id'] ?>, '<?= e(addslashes($r['title'])) ?>')"
                                                class="text-xs h-7 px-3 inline-flex items-center font-medium uppercase tracking-wider text-white border-0 cursor-pointer transition-opacity hover:opacity-85"
                                                style="background:#9CA3AF;">
                                            Löschen
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <!-- Toast -->
    <div x-show="toast.show" x-transition x-cloak
         class="fixed bottom-6 right-6 px-4 py-3 text-sm font-medium shadow-lg z-50 text-white"
         :style="toast.type === 'error' ? 'background:#dc2626' : 'background:#111827'"
         x-text="toast.message"></div>
</div>

<script>
function referencesManager() {
    return {
        editing: null,
        saving: false,
        toast: { show: false, type: 'success', message: '' },

        startNew() {
            this.editing = {
                id: null,
                title: '',
                description: '',
                category: '',
                city: '',
                year: '',
                image_id: null,
                image_url: '',
                is_active_bool: true,
                is_featured_home_bool: false,
                home_order: '',
            };
        },

        startEdit(row, imageUrl) {
            this.editing = {
                id: row.id,
                title: row.title || '',
                description: row.description || '',
                category: row.category || '',
                city: row.city || '',
                year: row.year || '',
                image_id: row.image_id || null,
                image_url: imageUrl || '',
                is_active_bool: !!(row.is_active === 1 || row.is_active === '1' || row.is_active === true),
                is_featured_home_bool: !!(row.is_featured_home === 1 || row.is_featured_home === '1' || row.is_featured_home === true),
                home_order: row.home_order || '',
            };
            window.scrollTo({ top: 0, behavior: 'smooth' });
        },

        openMediaPickerForRef() {
            // Media-Picker-Modal von der globalen admin.js benutzen
            if (typeof window.openMediaPicker === 'function') {
                window.openMediaPicker((media) => {
                    this.editing.image_id = media.id;
                    this.editing.image_url = media.url || media.path || '';
                });
            } else {
                // Fallback: prompt
                const id = prompt('Medien-ID eingeben (aus Admin → Medien):');
                if (id) this.editing.image_id = parseInt(id) || null;
            }
        },

        async saveReference() {
            if (!this.editing.title.trim()) {
                this.showToast('Titel ist erforderlich', 'error');
                return;
            }
            this.saving = true;

            const formData = new FormData();
            if (this.editing.id) formData.append('id', this.editing.id);
            formData.append('title', this.editing.title);
            formData.append('description', this.editing.description);
            formData.append('category', this.editing.category);
            formData.append('city', this.editing.city);
            formData.append('year', this.editing.year);
            formData.append('image_id', this.editing.image_id || '');
            formData.append('is_active', this.editing.is_active_bool ? 1 : 0);
            formData.append('is_featured_home', this.editing.is_featured_home_bool ? 1 : 0);
            formData.append('home_order', this.editing.home_order || '');
            formData.append('csrf_token', CSRF_TOKEN);

            try {
                const resp = await fetch('/admin/api/save-reference.php', { method: 'POST', body: formData });
                const data = await resp.json();
                if (data.error) {
                    this.showToast(data.error, 'error');
                } else {
                    this.showToast(data.message || 'Gespeichert', 'success');
                    this.editing = null;
                    setTimeout(() => location.reload(), 600);
                }
            } catch (e) {
                this.showToast('Netzwerkfehler', 'error');
            } finally {
                this.saving = false;
            }
        },

        async deleteReference(id, title) {
            if (!confirm(`Referenz „${title}" wirklich löschen?`)) return;

            const formData = new FormData();
            formData.append('id', id);
            formData.append('csrf_token', CSRF_TOKEN);

            try {
                const resp = await fetch('/admin/api/delete-reference.php', { method: 'POST', body: formData });
                const data = await resp.json();
                if (data.error) {
                    this.showToast(data.error, 'error');
                } else {
                    this.showToast('Referenz gelöscht', 'success');
                    setTimeout(() => location.reload(), 500);
                }
            } catch (e) {
                this.showToast('Netzwerkfehler', 'error');
            }
        },

        showToast(message, type) {
            this.toast = { show: true, type, message };
            setTimeout(() => { this.toast.show = false; }, 3000);
        }
    };
}
</script>
