-- ============================================
-- SUI Innova GmbH — Kontakt-Seite anlegen
-- ============================================
-- Ausfuehren in phpMyAdmin: Datenbank auswaehlen → Tab "SQL" → Inhalt einfuegen → OK
-- Sicher wiederholbar: bei erneutem Ausfuehren werden bestehende Sektionen ersetzt.
-- ============================================

-- 1) Seite anlegen (nur wenn noch nicht vorhanden)
INSERT INTO pages (title, slug, meta_title, meta_desc, is_active, is_homepage, sort_order, created_at, updated_at)
SELECT 'Kontakt', 'kontakt', 'Kontakt', 'Kontaktieren Sie SUI Innova GmbH – Ihr Partner für Gebäudetechnik. Wir freuen uns auf Ihre Nachricht und melden uns in Kürze bei Ihnen.', 1, 0, 10, NOW(), NOW()
FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE slug = 'kontakt');

-- 2) ID der Kontakt-Seite merken
SET @kontakt_id = (SELECT id FROM pages WHERE slug = 'kontakt' LIMIT 1);

-- 3) Alte Sektionen entfernen (falls vorhanden) und neu anlegen
DELETE FROM sections WHERE page_id = @kontakt_id;

INSERT INTO sections (page_id, type, content, sort_order, is_active, created_at, updated_at) VALUES
(
    @kontakt_id,
    'hero',
    JSON_OBJECT(
        'heading',         'Kontakt',
        'tagline',         'Wir sind für Sie da',
        'subheading',      'Haben Sie Fragen oder möchten Sie eine Offerte anfordern? Schreiben Sie uns – wir melden uns innerhalb eines Werktages.',
        'button_text',     'Zum Formular',
        'button_url',      '#kontakt',
        'button2_text',    '',
        'button2_url',     '',
        'overlay_opacity', '0.75',
        'image_id',        0
    ),
    1, 1, NOW(), NOW()
),
(
    @kontakt_id,
    'contact-form',
    JSON_OBJECT(
        'heading',       'Nachricht an uns',
        'subtitle',      'Gerne dürfen Sie uns unverbindlich kontaktieren. Wir freuen uns auf Ihre Anfrage.',
        'email_target',  '',
        'show_address',  '1',
        'show_phone',    '1',
        'show_map',      '0'
    ),
    2, 1, NOW(), NOW()
),
(
    @kontakt_id,
    'parallax-image',
    JSON_OBJECT(
        'image_id',     0,
        'image_url',    '/assets/img/parallax-werkstatt.jpg',
        'height',       'medium',
        'overlay_text', 'Qualität aus einer Hand'
    ),
    3, 1, NOW(), NOW()
);

-- ============================================
-- Fertig! Aufruf: https://sui-innova.ch/kontakt
-- ============================================
-- Optional: Kontakt zusaetzlich in die Hauptnavigation aufnehmen (normalerweise nicht noetig,
-- weil in der Header-Leiste bereits ein Kontakt-Button existiert):
-- INSERT INTO navigation (page_id, label, url, sort_order, is_active)
-- VALUES (@kontakt_id, 'Kontakt', '', 99, 1);
