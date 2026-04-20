-- ============================================
-- SUI Innova GmbH — Kontakt-Seite DESIGN
-- ============================================
-- Fuellt die bestehende Kontakt-Seite mit dem finalen Design:
-- 1) Hero-Banner (Kontakt-Titel + 2 Buttons)
-- 2) Kontaktformular (mit Adresse, Telefon)
-- 3) Werte / Reassurance (3 USPs)
-- 4) Parallax-Bild (Werkstatt, als Abschluss)
--
-- Ausfuehren in phpMyAdmin: Datenbank auswaehlen → Tab "SQL" → einfuegen → OK
-- Idempotent: kann beliebig oft ausgefuehrt werden, ersetzt jedes Mal die Sektionen.
-- ============================================

-- 1) Sicherstellen, dass die Kontakt-Seite existiert (anlegen falls nicht)
INSERT INTO pages (title, slug, meta_title, meta_desc, is_active, is_homepage, sort_order, created_at, updated_at)
SELECT 'Kontakt', 'kontakt', 'Kontakt',
       'Kontaktieren Sie SUI Innova GmbH. Wir freuen uns auf Ihre Anfrage und melden uns innerhalb eines Werktages bei Ihnen.',
       1, 0, 10, NOW(), NOW()
FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE slug = 'kontakt');

SET @kontakt_id = (SELECT id FROM pages WHERE slug = 'kontakt' LIMIT 1);

-- 2) Alte Sektionen wegraeumen (kompletter Reset fuer sauberes Design)
DELETE FROM sections WHERE page_id = @kontakt_id;

-- 3) Finales Design in 4 Sektionen anlegen
INSERT INTO sections (page_id, type, content, sort_order, is_active, created_at, updated_at) VALUES
-- ── HERO ──────────────────────────────────────────
(
    @kontakt_id,
    'hero',
    JSON_OBJECT(
        'heading',         'Lassen Sie uns sprechen',
        'tagline',         'Kontakt',
        'subheading',      'Ob erste Idee, konkrete Offerte oder technische Frage – wir hören zu und melden uns in der Regel innerhalb eines Werktages zurück.',
        'button_text',     'Zum Formular',
        'button_url',      '#kontakt',
        'button2_text',    'Direkt anrufen',
        'button2_url',     'tel:+41554201990',
        'overlay_opacity', '0.75',
        'image_id',        0
    ),
    1, 1, NOW(), NOW()
),

-- ── KONTAKTFORMULAR ───────────────────────────────
(
    @kontakt_id,
    'contact-form',
    JSON_OBJECT(
        'heading',       'Nachricht senden',
        'subtitle',      'Gerne dürfen Sie uns unverbindlich kontaktieren. Wir freuen uns auf Ihre Anfrage.',
        'email_target',  '',
        'show_address',  '1',
        'show_phone',    '1',
        'show_map',      '0'
    ),
    2, 1, NOW(), NOW()
),

-- ── WERTE / USPS (Reassurance nach dem Formular) ──
(
    @kontakt_id,
    'values',
    JSON_OBJECT(
        'heading', 'Was Sie von uns erwarten dürfen',
        'items', JSON_ARRAY(
            JSON_OBJECT(
                'icon',  'clock',
                'title', 'Schnelle Rückmeldung',
                'desc',  'Antwort innerhalb eines Werktages – auch bei kurzfristigen Anfragen oder Baustellen-Notfällen.'
            ),
            JSON_OBJECT(
                'icon',  'handshake',
                'title', 'Unverbindliche Beratung',
                'desc',  'Erstgespräch, Offerte und technische Abklärung sind selbstverständlich kostenlos und ohne Verpflichtung.'
            ),
            JSON_OBJECT(
                'icon',  'user-check',
                'title', 'Persönlicher Ansprechpartner',
                'desc',  'Vom ersten Kontakt bis zur Abnahme haben Sie einen festen Ansprechpartner – keine Hotline, keine Weiterleitungen.'
            )
        )
    ),
    3, 1, NOW(), NOW()
),

-- ── PARALLAX-BILD (visueller Abschluss) ───────────
(
    @kontakt_id,
    'parallax-image',
    JSON_OBJECT(
        'image_id',     0,
        'image_url',    '/assets/img/parallax-werkstatt.jpg',
        'height',       'medium',
        'overlay_text', 'Qualität aus einer Hand'
    ),
    4, 1, NOW(), NOW()
);

-- ============================================
-- Fertig! Die Seite ist live unter:
-- https://sui-innova.ch/kontakt
--
-- Anpassen geht im Admin:
--   /admin/pages → Kontakt → Bearbeiten
-- ============================================
