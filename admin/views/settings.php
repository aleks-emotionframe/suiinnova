<?php
/**
 * Admin — Einstellungen
 */

$settingGroups = [
    'general' => [
        'label' => 'Allgemein',
        'fields' => [
            'site_name'        => ['label' => 'Firmenname',       'type' => 'text'],
            'site_description' => ['label' => 'Beschreibung',     'type' => 'text'],
            'logo_url'         => ['label' => 'Logo URL',         'type' => 'text'],
            'maintenance_mode' => ['label' => 'Wartungsmodus (1 = aktiv, 0 = aus)', 'type' => 'text'],
            'maintenance_text' => ['label' => 'Wartungsmodus Text', 'type' => 'textarea'],
        ],
    ],
    'contact' => [
        'label' => 'Kontakt',
        'fields' => [
            'company_name'          => ['label' => 'Firmenname',                    'type' => 'text'],
            'address_street'        => ['label' => 'Strasse',                       'type' => 'text'],
            'address_city'          => ['label' => 'PLZ / Ort',                     'type' => 'text'],
            'phone'                 => ['label' => 'Telefon',                        'type' => 'text'],
            'contact_email'         => ['label' => 'E-Mail (wird auf Website angezeigt)', 'type' => 'text'],
            'contact_form_receiver' => ['label' => 'Kontaktformular-Empfänger (E-Mail)', 'type' => 'text'],
        ],
    ],
    'footer' => [
        'label' => 'Footer',
        'fields' => [
            'footer_text'     => ['label' => 'Footer Text',      'type' => 'textarea'],
            'footer_logo_url' => ['label' => 'Footer Logo URL',  'type' => 'text'],
            'created_by'      => ['label' => 'Created by (Name)', 'type' => 'text'],
            'created_by_url'  => ['label' => 'Created by (Link)', 'type' => 'text'],
        ],
    ],
    'career' => [
        'label' => 'Karriere / Bewerbungen (Header-Banner)',
        'fields' => [
            'career_visible'     => ['label' => 'Karriere-Banner im Header anzeigen (1 = ja, 0 = nein)', 'type' => 'text'],
            'career_text'        => ['label' => 'Banner-Text (z.B. „Wir suchen Verstärkung! GIS-Monteur gesucht.")', 'type' => 'text'],
            'career_button_text' => ['label' => 'Button-Beschriftung (z.B. „Jetzt bewerben")', 'type' => 'text'],
            'career_position'    => ['label' => 'Ausgeschriebene Position (erscheint als Titel im Bewerbungs-Popup)', 'type' => 'text'],
            'career_intro'       => ['label' => 'Intro-Text im Bewerbungs-Popup', 'type' => 'textarea'],
            'career_email'       => ['label' => 'E-Mail-Empfaenger fuer neue Bewerbungen', 'type' => 'text'],
        ],
    ],
    '404' => [
        'label' => '404-Seite (Seite nicht gefunden)',
        'fields' => [
            '404_title'  => ['label' => 'Überschrift (z.B. „404" oder „Hoppla!")', 'type' => 'text'],
            '404_text'   => ['label' => 'Beschreibungstext',                       'type' => 'textarea'],
            '404_button' => ['label' => 'Button-Text',                             'type' => 'text'],
        ],
    ],
];
?>

<div x-data="settingsManager()">
    <form @submit.prevent="saveSettings($event.target)">
        <?php foreach ($settingGroups as $groupKey => $group): ?>
            <div class="admin-card mb-6">
                <h2 class="text-xs font-medium uppercase tracking-wider text-gray-500 mb-4"><?= e($group['label']) ?></h2>

                <div class="space-y-4">
                    <?php foreach ($group['fields'] as $key => $field): ?>
                        <div>
                            <label class="admin-label"><?= e($field['label']) ?></label>
                            <?php if ($field['type'] === 'textarea'): ?>
                                <textarea name="settings[<?= e($key) ?>]" rows="2"
                                          class="admin-textarea"><?= e(setting($key)) ?></textarea>
                            <?php else: ?>
                                <input type="text" name="settings[<?= e($key) ?>]"
                                       value="<?= e(setting($key)) ?>"
                                       class="admin-input">
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>

        <button type="submit" class="admin-btn-primary" :disabled="saving">
            <span x-show="!saving">Einstellungen speichern</span>
            <span x-show="saving" x-cloak>Speichere...</span>
        </button>
    </form>

    <!-- Toast -->
    <div x-show="toast" x-transition
         :class="toastType === 'success' ? 'toast-success' : 'toast-error'"
         x-text="toastMessage" x-cloak>
    </div>
</div>
