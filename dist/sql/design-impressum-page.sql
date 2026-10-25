-- ============================================
-- SUI Innova GmbH — Impressum-Seite
-- ============================================
-- Struktur:
-- 1) Parallax-Banner (Werkstatt) — konsistent mit anderen Unterseiten
-- 2) Text-Block: Impressum mit allen gesetzlichen Angaben
--
-- Idempotent: SQL kann beliebig oft ausgefuehrt werden.
-- ============================================

-- 1) Seite sicherstellen
INSERT INTO pages (title, slug, meta_title, meta_desc, is_active, is_homepage, sort_order, created_at, updated_at)
SELECT 'Impressum', 'impressum', 'Impressum',
       'Impressum der SUI Innova GmbH – Kontaktadresse, Handelsregistereintrag, Mehrwertsteuernummer und Haftungsausschluss.',
       1, 0, 50, NOW(), NOW()
FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE slug = 'impressum');

SET @page_id = (SELECT id FROM pages WHERE slug = 'impressum' LIMIT 1);

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

-- ── 2) IMPRESSUM-TEXT ──────────────
(
    @page_id,
    'text-block',
    JSON_OBJECT(
        'heading',   'Impressum',
        'body',      '<h2>Kontaktadresse</h2><p>SUI Innova GmbH<br>Talstrasse 31<br>8808 Pfäffikon SZ<br>Schweiz<br>info@sui-innova.ch<br>+41 55 420 19 90</p><h2>Vertretungsberechtigte Personen</h2><p>Riad Ljatifi, Inhaber & Geschäftsführer</p><h2>Handelsregistereintrag</h2><p>Eingetragener Firmenname: SUI Innova GmbH<br>Nummer: CHE-145.418.862</p><h2>Mehrwertsteuernummer</h2><p>CH-130-4029769-5</p><h2>Haftungsausschluss</h2><p>Der Autor übernimmt keinerlei Gewähr hinsichtlich der inhaltlichen Richtigkeit, Genauigkeit, Aktualität, Zuverlässigkeit und Vollständigkeit der Informationen. Haftungsansprüche gegen den Autor wegen Schäden materieller oder immaterieller Art, welche aus dem Zugriff oder der Nutzung bzw. Nichtnutzung der veröffentlichten Informationen, durch Missbrauch der Verbindung oder durch technische Störungen entstanden sind, werden ausgeschlossen. Alle Angebote sind unverbindlich. Der Autor behält es sich ausdrücklich vor, Teile der Seiten oder das gesamte Angebot ohne gesonderte Ankündigung zu verändern, zu ergänzen, zu löschen oder die Veröffentlichung zeitweise oder endgültig einzustellen.</p><h2>Haftung für Links</h2><p>Verweise und Links auf Webseiten Dritter liegen ausserhalb unseres Verantwortungsbereichs Es wird jegliche Verantwortung für solche Webseiten abgelehnt. Der Zugriff und die Nutzung solcher Webseiten erfolgen auf eigene Gefahr des Nutzers oder der Nutzerin.</p><h2>Urheberrechte</h2><p>Die Urheber- und alle anderen Rechte an Inhalten, Bildern, Fotos oder anderen Dateien auf der Website gehören ausschliesslich der Firma SUI Innova GmbH oder den speziell genannten Rechtsinhabern. Für die Reproduktion jeglicher Elemente ist die schriftliche Zustimmung der Urheberrechtsträger im Voraus einzuholen.</p><h2>Quelle</h2><p>Dieses Impressum wurde am 5.05.2026 mit dem Impressum Generator der Webdesign Agentur <a href="https://webkoenig.ch/" target="_blank" rel="noopener">Webkönig</a> erstellt. Die Agentur Webkönig übernimmt keine Haftung.</p>',
        'alignment', 'left'
    ),
    2, 1, NOW(), NOW()
);

-- ============================================
-- Fertig! Aufruf https://sui-innova.ch/impressum
-- Footer-Link ist bereits vorhanden.
-- ============================================
