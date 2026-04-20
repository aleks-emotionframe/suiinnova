-- ============================================
-- SUI Innova GmbH — Kontakt-Seite DESIGN v2
-- ============================================
-- Struktur passend zu den anderen Unterseiten (z.B. „Ueber uns"):
-- 1) Parallax-Image als Banner oben (mittlere Hoehe)
-- 2) Kontaktformular mit Adresse + Telefon
-- 3) Werte / USPs (3 Reassurance-Punkte)
--
-- Ausfuehren in phpMyAdmin: DB auswaehlen → Tab "SQL" → einfuegen → OK
-- Idempotent: kann beliebig oft ausgefuehrt werden.
-- ============================================

-- 1) Seite sicherstellen
INSERT INTO pages (title, slug, meta_title, meta_desc, is_active, is_homepage, sort_order, created_at, updated_at)
SELECT 'Kontakt', 'kontakt', 'Kontakt',
       'Kontaktieren Sie SUI Innova GmbH. Wir freuen uns auf Ihre Anfrage und melden uns innerhalb eines Werktages bei Ihnen.',
       1, 0, 10, NOW(), NOW()
FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE slug = 'kontakt');

SET @kontakt_id = (SELECT id FROM pages WHERE slug = 'kontakt' LIMIT 1);

-- 2) Sektionen ersetzen
DELETE FROM sections WHERE page_id = @kontakt_id;

INSERT INTO sections (page_id, type, content, sort_order, is_active, created_at, updated_at) VALUES

-- ── BANNER (parallax-image, mittlere Hoehe, wie „Ueber uns") ─────
(
    @kontakt_id,
    'parallax-image',
    JSON_OBJECT(
        'image_id',     0,
        'image_url',    '/assets/img/parallax-werkstatt.jpg',
        'height',       'medium',
        'overlay_text', ''
    ),
    1, 1, NOW(), NOW()
),

-- ── KONTAKTFORMULAR ──────────────────────────────────────────────
(
    @kontakt_id,
    'contact-form',
    JSON_OBJECT(
        'heading',       'Lassen Sie uns sprechen',
        'subtitle',      'Ob erste Idee, konkrete Offerte oder technische Frage – schreiben Sie uns. Wir melden uns in der Regel innerhalb eines Werktages zurueck.',
        'email_target',  '',
        'show_address',  '1',
        'show_phone',    '1',
        'show_map',      '0'
    ),
    2, 1, NOW(), NOW()
),

-- ── WERTE / USPs (Reassurance nach dem Formular) ─────────────────
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
);

-- ============================================
-- Fertig! https://sui-innova.ch/kontakt
--
-- Hinweis: Das Banner-Bild ist derzeit parallax-werkstatt.jpg.
-- Falls ein passenderes Bild gewuenscht: Admin → Seiten → Kontakt
--   → Banner-Sektion bearbeiten → Bild aus Medien-Bibliothek waehlen.
-- ============================================
