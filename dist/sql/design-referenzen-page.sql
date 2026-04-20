-- ============================================
-- SUI Innova GmbH — Referenzen-Seite DESIGN
-- ============================================
-- Struktur passend zu Ueber uns, Leistungen & Kontakt:
-- 1) Parallax-Banner
-- 2) Text-Block: Intro
-- 3) References-Grid: ausgewaehlte Projekte
-- 4) Stats-Bar: Zahlen & Fakten
-- 5) Parallax-Image mit Overlay-Text
-- 6) CTA-Banner: naechstes Projekt
-- ============================================

-- 1) Seite sicherstellen
INSERT INTO pages (title, slug, meta_title, meta_desc, is_active, is_homepage, sort_order, created_at, updated_at)
SELECT 'Referenzen', 'referenzen', 'Referenzen',
       'Ausgewählte Referenzprojekte der SUI Innova GmbH – Sanitärinstallationen in der ganzen Schweiz. Wohnbau, Gewerbe, Spital, Industrie.',
       1, 0, 4, NOW(), NOW()
FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE slug = 'referenzen');

SET @page_id = (SELECT id FROM pages WHERE slug = 'referenzen' LIMIT 1);

-- 2) Sektionen ersetzen
DELETE FROM sections WHERE page_id = @page_id;

INSERT INTO sections (page_id, type, content, sort_order, is_active, created_at, updated_at) VALUES

-- ── 1) PARALLAX-BANNER ──────────────────────────
(
    @page_id,
    'parallax-image',
    JSON_OBJECT(
        'image_id',     0,
        'image_url',    '/assets/img/parallax-werkstatt.jpg',
        'height',       'medium',
        'overlay_text', ''
    ),
    1, 1, NOW(), NOW()
),

-- ── 2) REFERENCES-GRID (Titel + Intro direkt integriert) ──
(
    @page_id,
    'references-grid',
    JSON_OBJECT(
        'heading',  'Unsere Referenzen',
        'subtitle', 'Qualität zeigt sich erst in der Umsetzung. Ein Auszug aus Projekten, bei denen wir in den letzten Jahren mit Vorfabrikation und Montage beteiligt waren.',
        'items', JSON_ARRAY(),
        'button_text', '',
        'button_url',  ''
    ),
    2, 1, NOW(), NOW()
),

-- ── 3) STATS-BAR ─────────────────────────────
(
    @page_id,
    'stats-bar',
    JSON_OBJECT(
        'style', 'dark',
        'items', JSON_ARRAY(
            JSON_OBJECT('number', '150+',  'label', 'Abgeschlossene Projekte'),
            JSON_OBJECT('number', '85+',   'label', 'Fachkräfte im Team'),
            JSON_OBJECT('number', '20+',   'label', 'Jahre Erfahrung'),
            JSON_OBJECT('number', 'CH',    'label', 'Schweizweit tätig')
        )
    ),
    3, 1, NOW(), NOW()
),

-- ── 4) PARALLAX-IMAGE ────────────────────────
(
    @page_id,
    'parallax-image',
    JSON_OBJECT(
        'image_id',     0,
        'image_url',    '/assets/img/hero-bg.jpg',
        'height',       'medium',
        'overlay_text', 'Präzision in jeder Verbindung'
    ),
    4, 1, NOW(), NOW()
),

-- ── 5) CTA-BANNER ────────────────────────────
(
    @page_id,
    'cta-banner',
    JSON_OBJECT(
        'heading',     'Ihr Projekt als nächstes?',
        'body',        'Wir beraten Sie gerne zur Vorfabrikation, Montage und Terminplanung. Unverbindlich und ohne Verpflichtung.',
        'button_text', 'Projekt besprechen',
        'button_url',  '/kontakt'
    ),
    5, 1, NOW(), NOW()
);

-- ============================================
-- Fertig! https://sui-innova.ch/referenzen
-- ============================================
