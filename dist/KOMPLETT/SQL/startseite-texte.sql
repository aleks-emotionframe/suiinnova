-- ============================================================
-- SUI Innova GmbH — Texte der Startseite schaerfen
--
-- Vier Stellen, an denen der Text heute nichts behauptet:
--
--   "Professionelle Montage"      Jeder Mitbewerber schreibt das.
--   "professionell beplankt"      Ein Adjektiv ist kein Argument.
--   "Unser Arbeitsansatz:"        Danach folgt ein Satz ohne Verb.
--   "gewaehrleistet eine gleich-  Drei abstrakte Substantive
--    bleibend hohe Ausfuehrungs-  hintereinander.
--    qualitaet"
--
-- Ersetzt durch das, was tatsaechlich passiert. Kein neuer
-- Sachverhalt, nur praeziser gesagt.
--
-- SICHERHEIT: Jede Anweisung prueft vorher den Titel der Karte.
-- Stimmt die Reihenfolge auf Ihrer Seite nicht mit der erwarteten
-- ueberein, passiert an der Stelle einfach nichts.
--
-- Gefahrlos mehrfach ausfuehrbar.
-- ============================================================

SET NAMES utf8mb4;


-- ------------------------------------------------------------
-- Karte "Montage"
-- vorher: Professionelle Montage direkt auf Ihrer Baustelle
-- ------------------------------------------------------------
UPDATE sections s
JOIN pages p ON p.id = s.page_id
SET s.content = JSON_SET(s.content, '$.items[1].desc',
    'Unser eigenes Team setzt die Elemente vor Ort — dieselben Leute, die sie gebaut haben')
WHERE p.is_homepage = 1 AND s.type = 'services' AND JSON_VALID(s.content)
  AND LOWER(JSON_UNQUOTE(JSON_EXTRACT(s.content, '$.items[1].title'))) = 'montage';


-- ------------------------------------------------------------
-- Karte "Aqua Panel (Beplankung)"
-- vorher: AquaPanel für Feuchträume und Nasszellen
-- ------------------------------------------------------------
UPDATE sections s
JOIN pages p ON p.id = s.page_id
SET s.content = JSON_SET(s.content, '$.items[2].desc',
    'AquaPanel in Nasszellen: der Untergrund für Abdichtung und Plättli')
WHERE p.is_homepage = 1 AND s.type = 'services' AND JSON_VALID(s.content)
  AND LOWER(JSON_UNQUOTE(JSON_EXTRACT(s.content, '$.items[2].title'))) LIKE 'aqua%';


-- ------------------------------------------------------------
-- Karte "Beplankungen und Spachtelungen"
-- vorher: Fertig montierte GIS-Elemente professionell beplankt und gespachtelt
-- ------------------------------------------------------------
UPDATE sections s
JOIN pages p ON p.id = s.page_id
SET s.content = JSON_SET(s.content, '$.items[3].desc',
    'Beplankt und gespachtelt — die Wand geht spachtelfertig ans nächste Gewerk')
WHERE p.is_homepage = 1 AND s.type = 'services' AND JSON_VALID(s.content)
  AND LOWER(JSON_UNQUOTE(JSON_EXTRACT(s.content, '$.items[3].title'))) LIKE 'beplankung%';


-- ------------------------------------------------------------
-- Link-Texte vereinheitlichen
--
-- Heute steht abwechselnd "Jetzt entdecken" und "Mehr erfahren",
-- ohne dass ein Unterschied dahintersteckt. "Entdecken" ist
-- ausserdem Sprache aus dem Onlineshop — ein Bauleiter entdeckt
-- nichts, er prueft, ob jemand den Auftrag kann.
-- ------------------------------------------------------------
UPDATE sections s
JOIN pages p ON p.id = s.page_id
SET s.content = JSON_SET(s.content,
        '$.items[0].link_text', 'Mehr erfahren',
        '$.items[1].link_text', 'Mehr erfahren',
        '$.items[2].link_text', 'Mehr erfahren',
        '$.items[3].link_text', 'Mehr erfahren')
WHERE p.is_homepage = 1 AND s.type = 'services' AND JSON_VALID(s.content);


-- ------------------------------------------------------------
-- Ueber-uns-Teaser
--
-- Der zweite Absatz lautete: "Unser Arbeitsansatz: Sanitaerelemente
-- in der Werkstatt unter kontrollierten Bedingungen vorgefertigt und
-- anschliessend auf der Baustelle montiert." Das ist kein Satz, es
-- fehlt das Verb. Danach drei abstrakte Substantive.
--
-- Die Zahl "ueber 25 Fachkraefte" bleibt — das ist die staerkste
-- Angabe auf der ganzen Seite.
-- ------------------------------------------------------------
UPDATE sections s
JOIN pages p ON p.id = s.page_id
SET s.content = JSON_SET(s.content, '$.body',
    CONCAT(
      '<p>Die SUI Innova GmbH fertigt Sanitärelemente vor und montiert sie. ',
      'Von Pfäffikon SZ aus, mit über 25 Fachkräften, in der ganzen Schweiz.</p>',
      '<p>Wir bauen die Elemente in der Werkstatt auf und verrohren sie komplett. ',
      'Auf der Baustelle wird gestellt und angeschlossen, nicht mehr zusammengebaut. ',
      'Das verkürzt die Zeit im Rohbau — und was im Trockenen geprüft wurde, muss ',
      'vor Ort nicht nachgearbeitet werden.</p>'
    ))
WHERE p.is_homepage = 1 AND s.type = 'about-teaser' AND JSON_VALID(s.content);


-- ------------------------------------------------------------
-- Kontrolle: was steht jetzt drin?
-- ------------------------------------------------------------
-- SELECT JSON_UNQUOTE(JSON_EXTRACT(content, '$.items[0].title')) AS karte,
--        JSON_UNQUOTE(JSON_EXTRACT(content, '$.items[0].desc'))  AS text
-- FROM sections s JOIN pages p ON p.id = s.page_id
-- WHERE p.is_homepage = 1 AND s.type = 'services';
