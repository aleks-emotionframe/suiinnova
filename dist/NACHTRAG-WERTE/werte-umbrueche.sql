-- ============================================================
-- SUI Innova GmbH — Harte Zeilenumbrueche in den Werte-Karten
--
-- In der Karte "Transparent" steht:
--
--   Offene Preise, ehrliche Beratung, nachvollziehbare Abläufe.
--   Sie wissen immer, woran Sie sind.
--
-- Der zweite Satz beginnt auf einer eigenen Zeile, weil im Feld
-- ein Zeilenumbruch steht. Das Feld ist ein Textarea, und
-- renderRichtext() macht aus einem einfachen Umbruch ein <br>.
--
-- Bei drei Karten nebeneinander bricht der Text ohnehin
-- unterschiedlich um, je nach Spaltenbreite und Fenstergroesse.
-- Ein fester Umbruch sitzt dann mal richtig und mal mitten im
-- Satz. Er faellt hier weg, der Text fliesst.
--
-- Betrifft nur Sektionen vom Typ "values". Andere Texte
-- bleiben unberuehrt.
--
-- Gefahrlos mehrfach ausfuehrbar.
-- ============================================================

SET NAMES utf8mb4;

-- Im gespeicherten JSON steht ein Zeilenumbruch als die zwei
-- Zeichen Backslash und n. Genau die werden durch ein
-- Leerzeichen ersetzt.
UPDATE sections
SET content = REPLACE(content, '\\n', ' ')
WHERE type = 'values'
  AND content LIKE '%\\\\n%';

-- Doppelte Leerzeichen aufraeumen, falls vor dem Umbruch schon
-- eines stand
UPDATE sections
SET content = REPLACE(content, '  ', ' ')
WHERE type = 'values'
  AND content LIKE '%  %';


-- ------------------------------------------------------------
-- Kontrolle: muss 0 ergeben
-- ------------------------------------------------------------
-- SELECT COUNT(*) FROM sections WHERE type = 'values' AND content LIKE '%\\\\n%';
--
-- Und so sehen die Texte danach aus:
-- SELECT JSON_UNQUOTE(JSON_EXTRACT(content, '$.items[0].desc')) AS wert_1,
--        JSON_UNQUOTE(JSON_EXTRACT(content, '$.items[1].desc')) AS wert_2,
--        JSON_UNQUOTE(JSON_EXTRACT(content, '$.items[2].desc')) AS wert_3
-- FROM sections WHERE type = 'values';
