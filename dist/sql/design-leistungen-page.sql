-- ============================================
-- SUI Innova GmbH — Leistungen-Seite DESIGN
-- ============================================
-- Struktur passend zu Ueber uns & Kontakt:
-- 1) Parallax-Banner
-- 2) Text-Block: Intro
-- 3) Services-Sektion: 2 Hauptpfeiler (Vorfabrikation + Montage)
-- 4) Text-Block: Detail-Ueberleitung
-- 5) Values: 6 konkrete Leistungen als USP-Karten
-- 6) Parallax-Image: Werkstatt-Bild mit Overlay-Text
-- 7) CTA-Banner: Offert-Anfrage
-- ============================================

-- 1) Seite sicherstellen
INSERT INTO pages (title, slug, meta_title, meta_desc, is_active, is_homepage, sort_order, created_at, updated_at)
SELECT 'Leistungen', 'leistungen', 'Leistungen',
       'Von der Vorfabrikation bis zur Montage – alle Leistungen der SUI Innova GmbH: GIS-Elemente, Rohrleitungsbau, STOClick, Duofix, Beplankungen, AquaPanel.',
       1, 0, 3, NOW(), NOW()
FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE slug = 'leistungen');

SET @page_id = (SELECT id FROM pages WHERE slug = 'leistungen' LIMIT 1);

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

-- ── 2) INTRO ──────────────────────────────────
(
    @page_id,
    'text-block',
    JSON_OBJECT(
        'heading',   'Alles aus einer Hand',
        'body',      '<p>Wir übernehmen den kompletten Prozess – von der Vorfabrikation in unserer Werkstatt bis zur fachgerechten Montage auf der Baustelle. Ein Partner, ein Ansprechpartner, durchgängige Qualität.</p><p>Das reduziert Schnittstellen, verkürzt Bauzeiten und sorgt dafür, dass Ihr Projekt termingerecht und im Budget fertig wird.</p>',
        'alignment', 'left'
    ),
    2, 1, NOW(), NOW()
),

-- ── 3) HAUPTPFEILER: VORFABRIKATION + MONTAGE ──
(
    @page_id,
    'services',
    JSON_OBJECT(
        'heading',  'Unsere zwei Pfeiler',
        'subtitle', 'Vom Rohbau bis zur fertigen Wand – wir decken beide Enden des Sanitärprozesses ab.',
        'items', JSON_ARRAY(
            JSON_OBJECT(
                'image_id',  0,
                'icon',      'hammer',
                'title',     'Vorfabrikation',
                'desc',      'In unserer Werkstatt fertigen wir GIS-Elemente, Rohrleitungsmodule und komplette Installationsbausteine. Fix, fertig, anschlussbereit – einfach auf der Baustelle einbauen.',
                'link',      '',
                'link_text', ''
            ),
            JSON_OBJECT(
                'image_id',  0,
                'icon',      'wrench',
                'title',     'Montage vor Ort',
                'desc',      'Unsere Teams montieren Duofix-Vorwände, Beplankungen und AquaPanel direkt auf der Baustelle. Spachtelungen und Ausflockungen inklusive – bereit für Fliesen oder Anstrich.',
                'link',      '',
                'link_text', ''
            )
        )
    ),
    3, 1, NOW(), NOW()
),

-- ── 4) DETAIL-UEBERLEITUNG ────────────────────
(
    @page_id,
    'text-block',
    JSON_OBJECT(
        'heading',   'Unser Leistungsspektrum im Detail',
        'body',      '<p>Für jeden Bereich die richtige Lösung: von Standard-Sanitärinstallation bis zu Spezial-Themen wie AquaPanel in Feuchträumen oder STOClick-Befestigungen.</p>',
        'alignment', 'center'
    ),
    4, 1, NOW(), NOW()
),

-- ── 5) VALUES: 6 DETAIL-LEISTUNGEN ────────────
(
    @page_id,
    'values',
    JSON_OBJECT(
        'heading', '',
        'items', JSON_ARRAY(
            JSON_OBJECT(
                'icon',  'boxes',
                'title', 'GIS-Elemente',
                'desc',  'Vorfabrizierte Geberit-Installationssysteme, massgeschneidert für Ihr Projekt und bereit für die schnelle Baustellen-Montage.'
            ),
            JSON_OBJECT(
                'icon',  'route',
                'title', 'Rohrleitungsbau',
                'desc',  'Trink-, Ab- und Heizwasser-Installationen in allen gängigen Materialien. Nach SIA-Normen ausgeführt, dicht und langlebig.'
            ),
            JSON_OBJECT(
                'icon',  'zap',
                'title', 'STOClick-System',
                'desc',  'Schnellbefestigungs-System für sanitäre Installationen. Millimetergenau vorgefertigt, auf der Baustelle in Minuten montiert.'
            ),
            JSON_OBJECT(
                'icon',  'layout-panel-top',
                'title', 'Duofix & Vorwände',
                'desc',  'Geberit Duofix und gleichwertige Vorwand-Systeme – für WC, Lavabo, Urinal und Spezialkonstruktionen.'
            ),
            JSON_OBJECT(
                'icon',  'square-stack',
                'title', 'Beplankungen',
                'desc',  'Gipsfaser-, Gipskarton- und OSB-Beplankungen. Saubere Übergänge, stabile Untergründe für die Weiterbearbeitung.'
            ),
            JSON_OBJECT(
                'icon',  'droplets',
                'title', 'AquaPanel & Spachtelung',
                'desc',  'Wasserresistente AquaPanel-Platten für Feuchträume, inklusive Spachtelung und Ausflockung – bereit für Fliesen oder Anstrich.'
            )
        )
    ),
    5, 1, NOW(), NOW()
),

-- ── 6) PARALLAX IMAGE (Break) ─────────────────
(
    @page_id,
    'parallax-image',
    JSON_OBJECT(
        'image_id',     0,
        'image_url',    '/assets/img/hero-bg.jpg',
        'height',       'medium',
        'overlay_text', 'Qualität aus einer Hand'
    ),
    6, 1, NOW(), NOW()
),

-- ── 7) CTA-BANNER ─────────────────────────────
(
    @page_id,
    'cta-banner',
    JSON_OBJECT(
        'heading',     'Planen Sie ein Projekt?',
        'body',        'Sprechen wir darüber. Wir erstellen Ihnen gerne eine unverbindliche Offerte – von der Vorfabrikation bis zur Montage.',
        'button_text', 'Kontakt aufnehmen',
        'button_url',  '/kontakt'
    ),
    7, 1, NOW(), NOW()
);

-- ============================================
-- Fertig! https://sui-innova.ch/leistungen
-- ============================================
