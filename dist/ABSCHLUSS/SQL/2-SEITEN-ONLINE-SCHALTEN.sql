-- ============================================================
-- SUI INNOVA — Die sechs neuen Seiten oeffentlich machen
--
-- ERST AUSFUEHREN, WENN SIE DIE SEITEN ANGESCHAUT HABEN.
--
-- Als Admin eingeloggt sind sie schon jetzt aufrufbar:
--   sui-innova.ch/sanitaer-vorwandelemente
--   sui-innova.ch/sanitaer-vorwaende
--   sui-innova.ch/sanitaer-gis-elemente-bestellen
--   sui-innova.ch/sanitaer-vorwandelemente-bestellen
--   sui-innova.ch/gis-elemente-beplanken
--   sui-innova.ch/sanitaer-vorwandelemente-beplanken
--
-- Sobald sie online sind, erscheinen sie von selbst
--   in der sitemap.xml
--   im Footer unter "Leistungen im Detail"
--   als Linkblock auf der Leistungsseite
--
-- Gefahrlos mehrfach ausfuehrbar.
-- ============================================================

SET NAMES utf8mb4;

-- ════ A) ONLINE SCHALTEN ════

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


-- ════ B) VERLINKUNG VON DER LEISTUNGSSEITE ════

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
-- FERTIG. Zum Schluss in der Search Console fuer alle elf
-- Adressen die Indexierung beantragen.
-- ════════════════════════════════════════════════════════════
