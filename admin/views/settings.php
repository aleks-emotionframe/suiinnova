<?php
/**
 * Admin — Einstellungen
 */

// Self-Heal: 404-Defaults sinnvoll setzen (alter Default '404' war schlechte UX)
try {
    $existing = $db->fetch("SELECT setting_val FROM settings WHERE setting_key = '404_title'");
    if (!$existing || $existing['setting_val'] === '404' || $existing['setting_val'] === '') {
        $val = $existing ? null : null;
        if (!$existing) {
            $db->insert('settings', ['setting_key' => '404_title', 'setting_val' => 'Seite nicht gefunden', 'group_name' => '404']);
        } elseif ($existing['setting_val'] === '404' || $existing['setting_val'] === '') {
            $db->update('settings', ['setting_val' => 'Seite nicht gefunden'], 'setting_key = :k', ['k' => '404_title']);
        }
        $GLOBALS['settings']['404_title'] = 'Seite nicht gefunden';
    }
} catch (Exception $e) {}

// Self-Heal: Cookie-Banner-Defaults (mit Accept All / Necessary-Wahl)
$cookieDefaults = [
    'cookie_visible'         => '1',
    'cookie_text'            => 'Wir verwenden technisch notwendige Cookies und – mit Ihrer Einwilligung – Statistik-Cookies (Google Analytics) zur anonymen Analyse der Website-Nutzung.',
    'cookie_link_text'       => 'Datenschutzerklärung',
    'cookie_btn_accept_all'  => 'Alle akzeptieren',
    'cookie_btn_accept_only' => 'Nur notwendige',
];

// Cleanup alter Default falls vorhanden (vom alten Single-Button-Design)
try {
    $oldText = $db->fetch("SELECT setting_val FROM settings WHERE setting_key = 'cookie_text'");
    if ($oldText && strpos($oldText['setting_val'], 'kein Tracking') !== false) {
        $db->update('settings', ['setting_val' => $cookieDefaults['cookie_text']], 'setting_key = :k', ['k' => 'cookie_text']);
        $GLOBALS['settings']['cookie_text'] = $cookieDefaults['cookie_text'];
    }
} catch (Exception $e) {}
try {
    foreach ($cookieDefaults as $key => $default) {
        $exists = $db->fetch("SELECT id FROM settings WHERE setting_key = :k", ['k' => $key]);
        if (!$exists) {
            $db->insert('settings', [
                'setting_key' => $key,
                'setting_val' => $default,
                'group_name'  => 'cookie',
            ]);
            $GLOBALS['settings'][$key] = $default;
        }
    }
} catch (Exception $e) {}

// Self-Heal: Defaults fuer Schriftgroessen anlegen falls nicht vorhanden
$typoDefaults = [
    'fs_h1'         => '64',
    'fs_heading'    => '48',
    'fs_subtitle'   => '18',
    'fs_card_title' => '24',
    'fs_body'       => '16',
    'fs_small'      => '14',
];
try {
    foreach ($typoDefaults as $key => $default) {
        $exists = $db->fetch("SELECT id FROM settings WHERE setting_key = :k", ['k' => $key]);
        if (!$exists) {
            $db->insert('settings', [
                'setting_key' => $key,
                'setting_val' => $default,
                'group_name'  => 'typography',
            ]);
            $GLOBALS['settings'][$key] = $default;
        }
    }
} catch (Exception $e) {}

$settingGroups = [
    'general' => [
        'label' => 'Allgemein',
        'fields' => [
            'site_name'        => ['label' => 'Firmenname',       'type' => 'text'],
            'site_description' => ['label' => 'Beschreibung',     'type' => 'text'],
            'logo_url'         => ['label' => 'Logo URL',         'type' => 'text'],
            'maintenance_mode' => ['label' => 'Wartungsmodus aktiv', 'type' => 'checkbox', 'hint' => 'Wenn aktiv, sehen Besucher die Wartungsseite. Eingeloggte Admins sehen die Seite normal.'],
            'maintenance_text' => ['label' => 'Wartungsmodus-Text', 'type' => 'textarea'],
        ],
    ],
    'contact' => [
        'label' => 'Kontakt',
        'fields' => [
            'company_name'          => ['label' => 'Firmenname',                    'type' => 'text'],
            'address_street'        => ['label' => 'Strasse',                       'type' => 'text'],
            'address_city'          => ['label' => 'PLZ / Ort',                     'type' => 'text'],
            'phone'                 => ['label' => 'Telefon',                        'type' => 'tel'],
            'contact_email'         => ['label' => 'E-Mail (wird auf Website angezeigt)', 'type' => 'email'],
            'contact_form_receiver' => ['label' => 'Kontaktformular-Empfänger (E-Mail)', 'type' => 'email'],
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
    'typography' => [
        'label' => 'Typografie (Schriftgrössen in px)',
        'fields' => [
            'fs_h1'         => ['label' => 'Hero-Titel (H1)',           'type' => 'number', 'hint' => 'Grösster Titel, z.B. „PRÄZISION IN DER VORFABRIKATION". Standard 64 px · Empfehlung 48–80 · auf Mobile automatisch 60 % kleiner.'],
            'fs_heading'    => ['label' => 'Hauptüberschriften (H2)',   'type' => 'number', 'hint' => 'Section-Titel wie „UNSERE LEISTUNGEN". Standard 48 px · Empfehlung 36–64.'],
            'fs_subtitle'   => ['label' => 'Untertitel / Intro-Text',   'type' => 'number', 'hint' => 'Unter der Hauptüberschrift. Standard 18 px · Empfehlung 16–22.'],
            'fs_card_title' => ['label' => 'Karten-Titel (H3)',         'type' => 'number', 'hint' => 'z.B. Titel innerhalb der Leistungs-Karten. Standard 24 px · Empfehlung 18–32.'],
            'fs_body'       => ['label' => 'Fliesstext / Absätze',      'type' => 'number', 'hint' => 'Normaler Text innerhalb von Sektionen. Standard 16 px · Empfehlung 14–20.'],
            'fs_small'      => ['label' => 'Kleintext / Labels',        'type' => 'number', 'hint' => 'Footer-Infos, kurze Labels, Untertags. Standard 14 px · Empfehlung 12–16.'],
        ],
    ],
    'cookie' => [
        'label' => 'Cookie-Banner (mit Consent-Wahl)',
        'fields' => [
            'cookie_visible'         => ['label' => 'Cookie-Banner anzeigen', 'type' => 'checkbox', 'hint' => 'Schaltet den Cookie-Hinweis am unteren Bildschirmrand ein/aus. Pflicht wenn Google Analytics aktiv ist.'],
            'cookie_text'            => ['label' => 'Banner-Text', 'type' => 'textarea', 'hint' => 'Hauptaussage. Sollte erwähnen, dass Google Analytics nur mit Einwilligung geladen wird.'],
            'cookie_link_text'       => ['label' => 'Link-Text zur Datenschutzerklärung', 'type' => 'text', 'hint' => 'Standard: „Datenschutzerklärung". Verlinkt automatisch auf /datenschutz.'],
            'cookie_btn_accept_all'  => ['label' => 'Button: Alle akzeptieren', 'type' => 'text', 'hint' => 'Roter Hauptbutton. Lädt Google Analytics nach.'],
            'cookie_btn_accept_only' => ['label' => 'Button: Nur notwendige', 'type' => 'text', 'hint' => 'Outline-Button. Lädt KEIN Tracking.'],
        ],
    ],
    'career' => [
        'label' => 'Karriere / Bewerbungen (Header-Banner)',
        'fields' => [
            'career_visible'     => ['label' => 'Karriere-Banner im Header anzeigen', 'type' => 'checkbox', 'hint' => 'Schaltet den roten „Wir stellen ein"-Button im Header ein/aus.'],
            'career_text'        => ['label' => 'Banner-Text (Langfassung, auf grossen Bildschirmen)', 'type' => 'text', 'hint' => 'z.B. „Wir suchen Verstärkung! GIS-Monteur gesucht."'],
            'career_button_text' => ['label' => 'Banner-Text (Kurzfassung, auf kleineren Bildschirmen)', 'type' => 'text', 'hint' => 'z.B. „Jetzt bewerben" oder „Wir stellen ein"'],
            'career_position'    => ['label' => 'Ausgeschriebene Position', 'type' => 'text', 'hint' => 'Erscheint als Titel im Bewerbungs-Popup, z.B. „GIS-Element-Monteur (m/w/d)".'],
            'career_intro'       => ['label' => 'Intro-Text im Bewerbungs-Popup', 'type' => 'textarea', 'hint' => 'Kurze Einleitung unter der Position, z.B. was mitzubringen ist.'],
            'career_email'       => ['label' => 'E-Mail-Empfänger für neue Bewerbungen', 'type' => 'email', 'hint' => 'Leer lassen = fällt auf Kontaktformular-Empfänger zurück.'],
        ],
    ],
    '404' => [
        'label' => '404-Seite (Seite nicht gefunden)',
        'fields' => [
            '404_title'  => ['label' => 'Überschrift', 'type' => 'text', 'hint' => 'Grosse Überschrift auf der 404-Seite. Empfehlung: „Seite nicht gefunden" oder „Hoppla, hier gibt es nichts".'],
            '404_text'   => ['label' => 'Beschreibungstext', 'type' => 'textarea', 'hint' => 'Kurzer erklärender Text unter der Überschrift.'],
            '404_button' => ['label' => 'Button-Text', 'type' => 'text', 'hint' => 'Beschriftung des roten Buttons. Empfehlung: „Zur Startseite".'],
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
                        <?php $type = $field['type'] ?? 'text'; $val = setting($key); ?>
                        <div>
                            <?php if ($type === 'checkbox'): ?>
                                <label style="display:inline-flex;align-items:center;gap:10px;cursor:pointer;">
                                    <!-- Hidden input sorgt dafuer, dass "0" gesendet wird wenn unchecked -->
                                    <input type="hidden" name="settings[<?= e($key) ?>]" value="0">
                                    <input type="checkbox" name="settings[<?= e($key) ?>]" value="1" <?= $val === '1' ? 'checked' : '' ?>
                                           style="width:18px;height:18px;cursor:pointer;accent-color:#111;">
                                    <span class="text-sm text-gray-900 font-medium"><?= e($field['label']) ?></span>
                                </label>
                            <?php else: ?>
                                <label class="admin-label"><?= e($field['label']) ?></label>
                                <?php if ($type === 'textarea'): ?>
                                    <textarea name="settings[<?= e($key) ?>]" rows="3"
                                              class="admin-textarea"><?= e($val) ?></textarea>
                                <?php else: ?>
                                    <?php
                                    $inputType = match ($type) {
                                        'email'  => 'email',
                                        'tel'    => 'tel',
                                        'number' => 'number',
                                        default  => 'text',
                                    };
                                    ?>
                                    <input type="<?= e($inputType) ?>"
                                           name="settings[<?= e($key) ?>]"
                                           value="<?= e($val) ?>"
                                           <?= $type === 'number' ? 'min="8" max="96" step="1"' : '' ?>
                                           class="admin-input"
                                           <?= $type === 'number' ? 'style="max-width:160px;"' : '' ?>>
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php if (!empty($field['hint'])): ?>
                                <p class="text-[11px] text-gray-400 mt-1.5"><?= e($field['hint']) ?></p>
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
