-- ============================================================
-- SUI Innova GmbH — SEO Paket 3b
-- Interne Verlinkung auf die neuen Keyword-Seiten
--
-- ERZEUGT VON dist/scripts/build_keyword_pages.php links
--
-- ACHTUNG: ERST AUSFUEHREN, WENN DIE SECHS SEITEN ONLINE SIND.
--
-- Solange die neuen Seiten deaktiviert sind, landet ein Besucher
-- beim Klick auf diese Links auf der Startseite. Das ist fuer
-- Google ein Signal fuer eine kaputte Seitenstruktur.
--
-- Reihenfolge:
--   1. seo-paket-3-keyword-seiten.sql einspielen
--   2. Angaben vom Kunden einarbeiten
--   3. Seiten im CMS unter Seiten online schalten
--   4. DIESE Datei einspielen
--
-- Gefahrlos mehrfach ausfuehrbar.
-- ============================================================

SET NAMES utf8mb4;

SET @pid = (SELECT id FROM pages WHERE slug = 'leistungen' LIMIT 1);
SET @sort = (SELECT COALESCE(MAX(sort_order), 0) + 10 FROM sections WHERE page_id = @pid);

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'text-block', '{"heading":"Leistungen im Detail","body":"<p>Zu den einzelnen Arbeitsschritten haben wir eigene Seiten mit Aufbau, Massen und häufigen Fragen:</p><ul><li><a href=\\"/sanitaer-vorwandelemente\\">Sanitär Vorwandelemente: Aufbau, Montage und Beplankung erklärt</a></li><li><a href=\\"/sanitaer-vorwaende\\">Sanitär Vorwände vorfabriziert, montiert und beplankt</a></li><li><a href=\\"/gis-elemente-beplanken\\">GIS Elemente beplanken: von der Vorfabrikation bis zur fertigen Wand</a></li><li><a href=\\"/sanitaer-vorwandelemente-beplanken\\">Sanitär Vorwandelemente beplanken</a></li><li><a href=\\"/sanitaer-gis-elemente-bestellen\\">Sanitär GIS Elemente bestellen</a></li><li><a href=\\"/sanitaer-vorwandelemente-bestellen\\">Sanitär Vorwandelemente bestellen</a></li></ul>","alignment":"left"}', @sort, 1
FROM DUAL
WHERE @pid IS NOT NULL
  AND NOT EXISTS (
    SELECT 1 FROM sections
    WHERE page_id = @pid AND type = 'text-block'
      AND content LIKE '%Leistungen im Detail%'
  );

-- ────────────────────────────────────────────────────────────
-- Kontrolle: alle sechs muessen is_active = 1 sein
-- ────────────────────────────────────────────────────────────
-- SELECT slug, is_active FROM pages WHERE slug IN (
--   'sanitaer-vorwandelemente',
--   'sanitaer-vorwaende',
--   'gis-elemente-beplanken',
--   'sanitaer-vorwandelemente-beplanken',
--   'sanitaer-gis-elemente-bestellen',
--   'sanitaer-vorwandelemente-bestellen'
-- );
