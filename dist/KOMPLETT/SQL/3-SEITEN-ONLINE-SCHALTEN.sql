-- ============================================================
-- SUI INNOVA — SCHRITT 3 VON 3
-- Die sechs neuen Seiten oeffentlich machen
--
-- ERST AUSFUEHREN, WENN SIE DIE SEITEN ANGESCHAUT HABEN.
--
-- Diese Datei macht dreierlei, in dieser Reihenfolge:
--   A) die sechs Seiten online schalten
--   B) sie von der Leistungsseite aus verlinken
--
-- Sobald sie online sind, erscheinen sie automatisch
--   - in der sitemap.xml
--   - im Footer unter "Leistungen im Detail"
-- Dafuer ist nichts weiter zu tun.
-- ============================================================

-- Zeichensatz der Verbindung festnageln. MUSS als Erstes kommen.
-- Ohne diese Zeile interpretiert der Server die Datei je nach Client als
-- latin1, und aus "Pfäffikon" wird "PfÃ¤ffikon" — in jedem Titel, jeder
-- Beschreibung und jedem Seitentext. Im Test genau so passiert.
SET NAMES utf8mb4;


-- ════════════════════════════════════════════════════════════
-- A) ONLINE SCHALTEN
-- ════════════════════════════════════════════════════════════

UPDATE pages SET is_active = 1
WHERE slug IN (
    'sanitaer-vorwandelemente',
    'sanitaer-gis-elemente-bestellen',
    'sanitaer-vorwandelemente-bestellen',
    'sanitaer-vorwaende',
    'gis-elemente-beplanken',
    'sanitaer-vorwandelemente-beplanken'
);

-- Rueckgaengig machen, falls doch noch etwas auffaellt:
-- UPDATE pages SET is_active = 0 WHERE slug IN ( ... dieselbe Liste ... );

-- Kontrolle: alle sechs muessen jetzt 1 zeigen
-- SELECT slug, is_active FROM pages WHERE slug LIKE 'sanitaer-%' OR slug LIKE 'gis-%';


-- ════════════════════════════════════════════════════════════
-- B) INTERNE VERLINKUNG VON DER LEISTUNGSSEITE
-- ════════════════════════════════════════════════════════════

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


-- ════════════════════════════════════════════════════════════
-- FERTIG
--
-- Zum Schluss in der Google Search Console unter URL-Pruefung
-- jede der sechs Adressen eingeben und "Indexierung beantragen".
-- ════════════════════════════════════════════════════════════
