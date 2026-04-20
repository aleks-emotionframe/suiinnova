<?php
/**
 * Admin — Seiten-Editor
 *
 * Sektionen als ausklappbare Karten. AJAX-Save fuer sofortige Aenderungen.
 */

$page = $db->fetch("SELECT * FROM pages WHERE id = :id", ['id' => $editPageId]);
if (!$page) {
    echo '<p class="text-gray-500">Seite nicht gefunden.</p>';
    return;
}

$sections = $db->fetchAll(
    "SELECT * FROM sections WHERE page_id = :pid ORDER BY sort_order ASC",
    ['pid' => $page['id']]
);

$sectionTypes = require BASE_PATH . '/config/sections.php';
?>

<div x-data="pageEditor()" x-init="init()">
    <!-- Page Meta -->
    <div class="admin-card mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="admin-label">Seitentitel</label>
                <input type="text" value="<?= e($page['title']) ?>" class="admin-input"
                       @change="savePageMeta(<?= $page['id'] ?>, 'title', $event.target.value)">
            </div>
            <div>
                <label class="admin-label">Meta Title (SEO)</label>
                <input type="text" value="<?= e($page['meta_title'] ?? '') ?>" class="admin-input"
                       @change="savePageMeta(<?= $page['id'] ?>, 'meta_title', $event.target.value)">
            </div>
            <div class="md:col-span-2">
                <label class="admin-label">Meta Description (SEO)</label>
                <textarea class="admin-textarea" rows="2"
                          @change="savePageMeta(<?= $page['id'] ?>, 'meta_desc', $event.target.value)"><?= e($page['meta_desc'] ?? '') ?></textarea>
            </div>
        </div>
    </div>

    <!-- Sections -->
    <div class="space-y-3" id="sections-list">
        <?php foreach ($sections as $index => $section): ?>
            <?php
            $sType = $section['type'];
            $sContent = jsonDecode($section['content']);
            $typeDef = $sectionTypes[$sType] ?? null;
            ?>

            <div class="section-card" data-section-id="<?= $section['id'] ?>"
                 x-data="{ open: false, saving: false }">

                <!-- Header -->
                <div class="section-card-header" @click="open = !open">
                    <div class="flex items-center gap-3">
                        <!-- Drag Handle -->
                        <svg class="drag-handle w-4 h-4 text-gray-300 cursor-grab hover:text-gray-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" @click.stop>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 8h16M4 16h16"/>
                        </svg>

                        <!-- Type Badge -->
                        <span class="px-2 py-0.5 bg-gray-100 text-[10px] uppercase tracking-wider text-gray-500 font-medium">
                            <?= e($typeDef['label'] ?? $sType) ?>
                        </span>

                        <!-- Preview Text -->
                        <span class="text-sm text-gray-600 truncate max-w-xs">
                            <?= e(excerpt($sContent['heading'] ?? $sContent['title'] ?? '', 50)) ?>
                        </span>
                    </div>

                    <div class="flex items-center gap-2">
                        <!-- Status -->
                        <?php if ($section['is_active']): ?>
                            <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                        <?php else: ?>
                            <span class="w-2 h-2 bg-gray-300 rounded-full"></span>
                        <?php endif; ?>

                        <!-- Toggle Arrow -->
                        <svg class="w-4 h-4 text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </div>

                <!-- Body (Collapsed by default) -->
                <div x-show="open" x-transition class="section-card-body pt-5">
                    <form @submit.prevent="saveSection(<?= $section['id'] ?>, $event.target)"
                          class="space-y-4">

                        <?php if ($typeDef): ?>
                            <?php foreach ($typeDef['fields'] as $fieldKey => $fieldDef): ?>
                                <?php $fieldValue = $sContent[$fieldKey] ?? ''; ?>

                                <?php if ($fieldDef['type'] === 'text' || $fieldDef['type'] === 'textarea' || $fieldDef['type'] === 'richtext'): ?>
                                    <?php $editorId = 'ed_' . $section['id'] . '_' . $fieldKey; ?>
                                    <div x-data="richEditor()" x-init="initEditor($refs.<?= $editorId ?>, $refs.h_<?= $editorId ?>)">
                                        <label class="admin-label"><?= e($fieldDef['label']) ?></label>
                                        <!-- Toolbar -->
                                        <div class="flex items-center gap-1 border border-gray-200 border-b-0 rounded-t-md px-2 py-1.5 bg-gray-50">
                                            <button type="button" @click="execCmd('bold')" class="w-7 h-7 flex items-center justify-center text-gray-600 hover:bg-gray-200 rounded text-xs font-bold" title="Fett">B</button>
                                            <button type="button" @click="execCmd('italic')" class="w-7 h-7 flex items-center justify-center text-gray-600 hover:bg-gray-200 rounded text-xs italic" title="Kursiv">I</button>
                                            <div class="w-px h-4 bg-gray-300 mx-1"></div>
                                            <button type="button" @click="execCmd('insertUnorderedList')" class="w-7 h-7 flex items-center justify-center text-gray-600 hover:bg-gray-200 rounded" title="Liste">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"/></svg>
                                            </button>
                                            <button type="button" @click="addLink()" class="w-7 h-7 flex items-center justify-center text-gray-600 hover:bg-gray-200 rounded text-xs underline" title="Link">A</button>
                                        </div>
                                        <!-- Editor -->
                                        <div x-ref="<?= $editorId ?>"
                                             contenteditable="true"
                                             class="admin-textarea text-sm min-h-[2.5rem] border-t-0 rounded-t-none focus:outline-none"
                                             style="white-space: pre-wrap;"
                                             @input="syncToHidden($refs.<?= $editorId ?>, $refs.h_<?= $editorId ?>)"
                                        ><?= $fieldValue ?></div>
                                        <!-- Hidden field -->
                                        <textarea x-ref="h_<?= $editorId ?>" name="<?= e($fieldKey) ?>" class="hidden"><?= e($fieldValue) ?></textarea>
                                    </div>

                                <?php elseif ($fieldDef['type'] === 'select'): ?>
                                    <div>
                                        <label class="admin-label"><?= e($fieldDef['label']) ?></label>
                                        <select name="<?= e($fieldKey) ?>" class="admin-select">
                                            <?php foreach ($fieldDef['options'] as $optVal => $optLabel): ?>
                                                <option value="<?= e($optVal) ?>" <?= $fieldValue == $optVal ? 'selected' : '' ?>>
                                                    <?= e($optLabel) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                <?php elseif ($fieldDef['type'] === 'checkbox'): ?>
                                    <div class="flex items-center gap-2">
                                        <input type="checkbox" name="<?= e($fieldKey) ?>" value="1"
                                               <?= $fieldValue ? 'checked' : '' ?>
                                               class="w-4 h-4 border-gray-300 text-brand-accent focus:ring-brand-accent">
                                        <label class="text-sm text-gray-700"><?= e($fieldDef['label']) ?></label>
                                    </div>

                                <?php elseif ($fieldDef['type'] === 'media'): ?>
                                    <div x-data="mediaField(<?= (int) $fieldValue ?>, '<?= e($fieldKey) ?>', '<?= e($fieldValue ? mediaUrl((int)$fieldValue, 'thumb') : '') ?>')">
                                        <label class="admin-label"><?= e($fieldDef['label']) ?></label>
                                        <input type="hidden" :name="fieldName" :value="mediaId">

                                        <div class="border border-dashed border-gray-200 rounded-md p-4">
                                            <!-- Bild vorhanden -->
                                            <div x-show="thumbUrl" class="flex items-center gap-4">
                                                <img :src="thumbUrl" class="w-24 h-16 object-cover bg-gray-100 rounded" alt="">
                                                <div class="flex-1">
                                                    <span class="text-xs text-gray-500" x-text="'Media ID: ' + mediaId"></span>
                                                </div>
                                                <div class="flex gap-2">
                                                    <button type="button" @click="openPicker()" class="admin-btn-secondary text-xs h-7 px-3">Ersetzen</button>
                                                    <button type="button" @click="removeMedia()" class="text-xs text-gray-400 hover:text-brand-accent px-2">Entfernen</button>
                                                </div>
                                            </div>
                                            <!-- Kein Bild -->
                                            <div x-show="!thumbUrl" class="text-center py-2">
                                                <button type="button" @click="openPicker()" class="admin-btn-secondary text-xs h-7 px-3">Aus Medien auswählen</button>
                                            </div>
                                        </div>
                                    </div>

                                <?php elseif ($fieldDef['type'] === 'repeater'): ?>
                                    <div x-data="repeaterField(<?= htmlspecialchars(json_encode($fieldValue ?: []), ENT_QUOTES) ?>)">
                                        <label class="admin-label"><?= e($fieldDef['label']) ?></label>

                                        <template x-for="(item, idx) in items" :key="idx">
                                            <div class="p-4 bg-gray-50 border border-gray-200 mb-2 relative">
                                                <button type="button" @click="removeItem(idx)"
                                                        class="absolute top-2 right-2 text-gray-400 hover:text-brand-accent">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/>
                                                    </svg>
                                                </button>

                                                <?php foreach ($fieldDef['fields'] as $subKey => $subDef): ?>
                                                    <div class="mb-2">
                                                        <label class="text-[10px] uppercase tracking-wider text-gray-400 font-medium"><?= e($subDef['label']) ?></label>
                                                        <?php if ($subDef['type'] === 'textarea'): ?>
                                                            <textarea :name="'<?= e($fieldKey) ?>[' + idx + '][<?= e($subKey) ?>]'"
                                                                      x-model="item.<?= e($subKey) ?>"
                                                                      rows="2" class="admin-textarea text-xs"></textarea>
                                                        <?php elseif ($subDef['type'] === 'media'): ?>
                                                            <div class="mt-1 border border-dashed border-gray-200 p-3 rounded-md">
                                                                <input type="hidden" :name="'<?= e($fieldKey) ?>[' + idx + '][<?= e($subKey) ?>]'" x-model="item.<?= e($subKey) ?>">
                                                                <div class="flex items-center gap-3">
                                                                    <button type="button"
                                                                            @click="window.openMediaPicker((m) => { item.<?= e($subKey) ?> = m.id; $el.closest('.flex').querySelector('.rep-thumb').src = m.thumb_url; $el.closest('.flex').querySelector('.rep-thumb').classList.remove('hidden'); })"
                                                                            class="admin-btn-secondary text-[10px] h-7 px-3 flex-shrink-0">
                                                                        Aus Medien wählen
                                                                    </button>
                                                                    <img src="" class="rep-thumb w-14 h-10 object-cover bg-gray-100 rounded hidden" alt="">
                                                                    <span class="text-[10px] text-gray-400" x-text="item.<?= e($subKey) ?> > 0 ? 'Media ID: ' + item.<?= e($subKey) ?> : 'Kein Bild'"></span>
                                                                </div>
                                                            </div>
                                                        <?php else: ?>
                                                            <textarea :name="'<?= e($fieldKey) ?>[' + idx + '][<?= e($subKey) ?>]'"
                                                                      x-model="item.<?= e($subKey) ?>"
                                                                      rows="1"
                                                                      class="admin-textarea text-xs"
                                                                      style="min-height: 2rem; resize: none; overflow: hidden; padding-top: 0.4rem; padding-bottom: 0.4rem;"
                                                                      x-init="$nextTick(() => { $el.style.height = $el.scrollHeight + 'px' })"
                                                                      @input="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'"
                                                            ></textarea>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </template>

                                        <button type="button" @click="addItem()"
                                                class="admin-btn-secondary text-xs h-7 px-3 mt-2">
                                            + Eintrag hinzufügen
                                        </button>

                                        <input type="hidden" name="<?= e($fieldKey) ?>_json"
                                               :value="JSON.stringify(items)">
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <!-- Actions -->
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <button type="submit" class="admin-btn-primary text-xs h-8"
                                    :disabled="saving">
                                <span x-show="!saving">Speichern</span>
                                <span x-show="saving" x-cloak>Speichere...</span>
                            </button>

                            <button type="button" @click="deleteSection(<?= $section['id'] ?>)"
                                    class="text-xs text-gray-400 hover:text-brand-accent transition-colors duration-200">
                                Sektion löschen
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Add Section -->
    <div class="mt-4" x-data="{ showTypes: false }">
        <button @click="showTypes = !showTypes" class="admin-btn-secondary w-full justify-center h-10 text-xs">
            + Neue Sektion hinzufügen
        </button>

        <div x-show="showTypes" x-transition class="grid grid-cols-2 md:grid-cols-4 gap-2 mt-3">
            <?php foreach ($sectionTypes as $typeKey => $typeDef): ?>
                <button @click="addSection(<?= $page['id'] ?>, '<?= e($typeKey) ?>')"
                        class="px-3 py-2 bg-white border border-gray-200 text-xs text-gray-700 hover:bg-gray-50 hover:border-gray-300 transition-colors duration-200 text-left">
                    <span class="font-medium"><?= e($typeDef['label']) ?></span>
                </button>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Toast Notification -->
    <div x-show="toast" x-transition
         :class="toastType === 'success' ? 'toast-success' : 'toast-error'"
         x-text="toastMessage" x-cloak>
    </div>
</div>

<script>
    const CSRF_TOKEN = '<?= e(csrfToken()) ?>';
    const PAGE_ID = <?= $page['id'] ?>;
</script>
