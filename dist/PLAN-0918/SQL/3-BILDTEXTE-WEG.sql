-- ============================================================
-- SUI Innova GmbH
-- Texte auf den Bildstreifen entfernen
--
-- Zwei Bildstreifen tragen eine Zeile in weisser Grossschrift:
--
--   /leistungen   ALLES AUS EINER HAND
--   /referenzen   PRÄZISION IN JEDER VERBINDUNG
--
-- Beide fallen weg. Andere Bildstreifen auf der Website tragen
-- keinen Text, es sind genau diese zwei.
--
-- Mit dem Text verschwindet auch die dunkle Flaeche, die heute
-- ueber dem ganzen Bild liegt, damit die weisse Schrift lesbar
-- bleibt. Die Vorlage legt sie nur an, wenn ueberhaupt ein Text
-- da ist. Das Bild steht danach also wieder unverdunkelt.
--
-- SICHERHEIT: Geleert wird nur, wo genau diese beiden Texte
-- stehen. Schreiben Sie spaeter etwas anderes hinein, bleibt es
-- stehen, auch wenn diese Datei nochmal laeuft.
--
-- Gefahrlos mehrfach ausfuehrbar.
--
-- Geht auch ohne SQL: CMS -> Seiten -> [Seite] -> Sektion
-- "Parallax Bildstreifen" -> Feld "Text auf Bild" leeren.
-- ============================================================

SET NAMES utf8mb4;

UPDATE sections s
JOIN pages p ON p.id = s.page_id
SET s.content = JSON_SET(s.content, '$.overlay_text', '')
WHERE s.type = 'parallax-image'
  AND JSON_VALID(s.content)
  AND (
        (p.slug = 'leistungen'
         AND LOWER(JSON_UNQUOTE(JSON_EXTRACT(s.content, '$.overlay_text')))
             = 'alles aus einer hand')
     OR (p.slug = 'referenzen'
         AND LOWER(JSON_UNQUOTE(JSON_EXTRACT(s.content, '$.overlay_text')))
             = 'präzision in jeder verbindung')
      );


-- ------------------------------------------------------------
-- Kontrolle: in der Spalte text_auf_bild darf nichts mehr stehen
-- ------------------------------------------------------------
-- SELECT p.slug, s.sort_order,
--        JSON_UNQUOTE(JSON_EXTRACT(s.content, '$.overlay_text')) AS text_auf_bild
-- FROM sections s JOIN pages p ON p.id = s.page_id
-- WHERE s.type = 'parallax-image'
-- ORDER BY p.sort_order, s.sort_order;
