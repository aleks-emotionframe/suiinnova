-- ============================================================
-- SUI Innova GmbH
-- Linktext auf /sanitaer-gis-elemente-bestellen
--
-- Der Link im Block "Passend dazu" zeigt auf
-- /gis-elemente-beplanken und hiess "GIS Elemente montieren
-- lassen". Neu "GIS Elemente beplanken lassen", passend zum
-- Suchbegriff der Zielseite. Auftrag vom 25.10.2026.
--
-- Aendert nur diesen einen Linktext. Der Rest der Seite bleibt,
-- auch wenn er seither im CMS bearbeitet wurde. Dieselbe
-- Aenderung steht im Generator, die Gesamt-SQL ist nachgefuehrt.
--
-- Gefahrlos mehrfach ausfuehrbar.
-- ============================================================

SET NAMES utf8mb4;

UPDATE sections s
JOIN pages p ON p.id = s.page_id
SET s.content = REPLACE(s.content, '"GIS Elemente montieren lassen"', '"GIS Elemente beplanken lassen"')
WHERE p.slug = 'sanitaer-gis-elemente-bestellen'
  AND s.type = 'link-list'
  AND s.content LIKE '%"slug":"gis-elemente-beplanken"%'
  AND s.content LIKE '%"GIS Elemente montieren lassen"%';

-- Kontrolle: muss "GIS Elemente beplanken lassen" zeigen
-- SELECT s.content FROM sections s JOIN pages p ON p.id = s.page_id
-- WHERE p.slug = 'sanitaer-gis-elemente-bestellen' AND s.type = 'link-list';
