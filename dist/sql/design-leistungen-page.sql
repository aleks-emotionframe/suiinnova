-- ============================================
-- SUI Innova GmbH — Leistungen-Seite DESIGN v2
-- ============================================
-- Texte mit Absatz-Umbruechen (\n\n) - werden vom Template als <p>-Tags gerendert.
--
-- Struktur:
-- 1) Parallax-Banner
-- 2) Services-Sektion mit 4 Hauptleistungen (Prozess-Reihenfolge)
-- 3) Parallax-Bild (Break)
-- 4) CTA-Banner
--
-- Idempotent: SQL kann beliebig oft ausgefuehrt werden.
-- ============================================

-- 1) Seite sicherstellen
INSERT INTO pages (title, slug, meta_title, meta_desc, is_active, is_homepage, sort_order, created_at, updated_at)
SELECT 'Leistungen', 'leistungen', 'Leistungen',
       'Vorfabrikation, Beplankungen, Aqua Panel und Montage – alle Sanitärleistungen der SUI Innova GmbH aus einer Hand. Von der Werkstatt bis zur Baustelle.',
       1, 0, 3, NOW(), NOW()
FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE slug = 'leistungen');

SET @page_id = (SELECT id FROM pages WHERE slug = 'leistungen' LIMIT 1);

-- 2) Sektionen ersetzen
DELETE FROM sections WHERE page_id = @page_id;

INSERT INTO sections (page_id, type, content, sort_order, is_active, created_at, updated_at) VALUES

-- ── 1) PARALLAX-BANNER ──────────────
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

-- ── 2) SERVICES (4 Karten, Prozess-Reihenfolge) ──
(
    @page_id,
    'services',
    JSON_OBJECT(
        'heading',  'Unsere Leistungen',
        'subtitle', 'Vier Bereiche, ein Partner: von der Vorfabrikation in unserer Werkstatt bis zur fertigen Montage auf Ihrer Baustelle.',
        'items', JSON_ARRAY(
            -- 1) VORFABRIKATION
            JSON_OBJECT(
                'image_id',  0,
                'image_url', '/assets/img/service-vorfabrikation.jpg',
                'icon',      'hammer',
                'title',     'Vorfabrikation',
                'desc',      'GIS-Elemente fix und fertig verrohrt aus unserer Werkstatt.\n\nTrink-, Ab- und Heizwasser-Leitungen werden direkt am vorgefertigten Element installiert – einbaufertig zur Baustelle.',
                'link',      '',
                'link_text', ''
            ),
            -- 2) BEPLANKUNGEN + SPACHTELUNGEN
            JSON_OBJECT(
                'image_id',  0,
                'image_url', '',
                'icon',      'square-stack',
                'title',     'Beplankungen + Spachtelungen',
                'desc',      'Verkleidung der GIS-Elemente mit Gipsfaser oder Gipskarton.\n\nFertig gespachtelt und bereit für Fliesen oder Anstrich – saubere Übergänge und stabile Untergründe für die Weiterbearbeitung.',
                'link',      '',
                'link_text', ''
            ),
            -- 3) AQUA PANEL
            JSON_OBJECT(
                'image_id',  0,
                'image_url', '',
                'icon',      'droplets',
                'title',     'Aqua Panel',
                'desc',      'Spezielle Gipsplatten für Nasszellen und Feuchträume. Höhere Feuchtigkeitsaufnahme als Standard-Gipskarton.\n\nIdeal für Bäder, Duschen und Industrie-Nassräume – langlebig und feuchtigkeitsresistent.',
                'link',      '',
                'link_text', ''
            ),
            -- 4) MONTAGE
            JSON_OBJECT(
                'image_id',  0,
                'image_url', '/assets/img/service-montage.jpg',
                'icon',      'wrench',
                'title',     'Montage',
                'desc',      'Professionelle Montage der vorgefertigten Elemente direkt auf Ihrer Baustelle.\n\nTermingerecht, präzise und durch erfahrene Teams – damit Ihr Projekt im Zeitplan bleibt.',
                'link',      '',
                'link_text', ''
            )
        )
    ),
    2, 1, NOW(), NOW()
),

-- ── 3) PARALLAX-IMAGE ─────────
(
    @page_id,
    'parallax-image',
    JSON_OBJECT(
        'image_id',     0,
        'image_url',    '/assets/img/hero-bg.jpg',
        'height',       'medium',
        'overlay_text', 'Alles aus einer Hand'
    ),
    3, 1, NOW(), NOW()
),

-- ── 4) CTA-BANNER ────────────
(
    @page_id,
    'cta-banner',
    JSON_OBJECT(
        'heading',     'Bereit für Ihr nächstes Projekt?',
        'body',        'Sprechen Sie mit uns über Ihre Anforderungen. Unverbindlich und ohne Verpflichtung – wir melden uns innerhalb eines Werktages zurück.',
        'button_text', 'Jetzt kontaktieren',
        'button_url',  '/kontakt'
    ),
    4, 1, NOW(), NOW()
);

-- ============================================
-- Fertig! Aufruf https://sui-innova.ch/leistungen
-- ============================================
