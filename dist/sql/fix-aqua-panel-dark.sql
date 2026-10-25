-- ============================================
-- SUI Innova GmbH — Aqua-Panel-Karte: Bild entfernen
-- ============================================
-- Setzt die image_url der Aqua-Panel-Karte auf leer
-- → Template rendert sie dann als dunkle Karte (wie Beplankungen)
-- ============================================

SET @page_id = (SELECT id FROM pages WHERE slug = 'leistungen' LIMIT 1);

-- Hole aktuellen JSON-Inhalt der services-Sektion
SET @section_id = (SELECT id FROM sections WHERE page_id = @page_id AND type = 'services' LIMIT 1);
SET @items = (SELECT JSON_EXTRACT(content, '$.items') FROM sections WHERE id = @section_id);

-- Iteriere durch items und setze bei Aqua-Panel image_url auf leer
-- MySQL unterstuetzt kein FOREACH, daher gezielter Pfad-Update auf alle 4 Indices
UPDATE sections
SET content = JSON_SET(
    content,
    '$.items[0].image_url',
        IF(JSON_UNQUOTE(JSON_EXTRACT(content, '$.items[0].title')) = 'Aqua Panel', '', JSON_UNQUOTE(JSON_EXTRACT(content, '$.items[0].image_url'))),
    '$.items[1].image_url',
        IF(JSON_UNQUOTE(JSON_EXTRACT(content, '$.items[1].title')) = 'Aqua Panel', '', JSON_UNQUOTE(JSON_EXTRACT(content, '$.items[1].image_url'))),
    '$.items[2].image_url',
        IF(JSON_UNQUOTE(JSON_EXTRACT(content, '$.items[2].title')) = 'Aqua Panel', '', JSON_UNQUOTE(JSON_EXTRACT(content, '$.items[2].image_url'))),
    '$.items[3].image_url',
        IF(JSON_UNQUOTE(JSON_EXTRACT(content, '$.items[3].title')) = 'Aqua Panel', '', JSON_UNQUOTE(JSON_EXTRACT(content, '$.items[3].image_url')))
)
WHERE id = @section_id;

-- ============================================
-- Fertig! Aqua-Panel-Karte ist jetzt dunkel.
-- ============================================
