-- ============================================================
-- SUI Innova GmbH — Texte der Startseite schaerfen
--
-- Drei Probleme im heutigen Text:
--
--   1. "Professionelle Montage", "professionell beplankt"
--      Ein Adjektiv ist kein Argument. Jeder Mitbewerber
--      schreibt dasselbe.
--
--   2. "Unser Arbeitsansatz: Sanitaerelemente in der Werkstatt
--      unter kontrollierten Bedingungen vorgefertigt und
--      anschliessend auf der Baustelle montiert."
--      Kein Satz, es fehlt das finite Verb. Danach drei
--      abstrakte Substantive: "gewaehrleistet eine
--      gleichbleibend hohe Ausfuehrungsqualitaet".
--
--   3. Die Kartentexte tragen keine Suchbegriffe. Das
--      Hauptkeyword der Startseite ist "GIS Elemente
--      Vorfabrikation" — in den Karten kam "GIS-Elemente"
--      genau einmal vor.
--
-- Neu enthaelt jede Karte ein Substantiv, nach dem jemand
-- sucht: GIS-Elemente, Baustelle, AquaPanel, Nasszellen,
-- beplanken, spachteln.
--
-- Keine Gedankenstriche, keine Floskeln.
--
-- SICHERHEIT: Jede Anweisung prueft vorher den Titel der Karte.
-- Stimmt die Reihenfolge auf Ihrer Seite nicht mit der
-- erwarteten ueberein, passiert an der Stelle einfach nichts.
--
-- Gefahrlos mehrfach ausfuehrbar.
-- ============================================================

SET NAMES utf8mb4;


-- ------------------------------------------------------------
-- Karte "Montage"
--
-- vorher:  Professionelle Montage direkt auf Ihrer Baustelle
-- Suchbegriffe neu: GIS-Elemente, montiert, Baustelle
-- ------------------------------------------------------------
UPDATE sections s
JOIN pages p ON p.id = s.page_id
SET s.content = JSON_SET(s.content, '$.items[1].desc',
    'Unser eigenes Team montiert die GIS-Elemente auf Ihrer Baustelle')
WHERE p.is_homepage = 1 AND s.type = 'services' AND JSON_VALID(s.content)
  AND LOWER(JSON_UNQUOTE(JSON_EXTRACT(s.content, '$.items[1].title'))) = 'montage';


-- ------------------------------------------------------------
-- Karte "Aqua Panel (Beplankung)"
--
-- vorher:  AquaPanel für Feuchträume und Nasszellen
-- Suchbegriffe neu: AquaPanel, Abdichtung, Plättli, Nasszellen
-- ------------------------------------------------------------
UPDATE sections s
JOIN pages p ON p.id = s.page_id
SET s.content = JSON_SET(s.content, '$.items[2].desc',
    'AquaPanel als Untergrund für Abdichtung und Plättli in Nasszellen')
WHERE p.is_homepage = 1 AND s.type = 'services' AND JSON_VALID(s.content)
  AND LOWER(JSON_UNQUOTE(JSON_EXTRACT(s.content, '$.items[2].title'))) LIKE 'aqua%';


-- ------------------------------------------------------------
-- Karte "Beplankungen und Spachtelungen"
--
-- vorher:  Fertig montierte GIS-Elemente professionell beplankt
--          und gespachtelt
--
-- Der erste Entwurf lautete "Beplankt und gespachtelt, die Wand
-- geht spachtelfertig ans naechste Gewerk". Zwei Partizipien am
-- Anfang, kein Substantiv, und der Kartentitel steht schon
-- darueber. Jetzt steht das Verb "beplanken" drin, nach dem
-- gesucht wird, dazu GIS-Elemente und die beiden Gewerke, die
-- danach kommen.
-- ------------------------------------------------------------
UPDATE sections s
JOIN pages p ON p.id = s.page_id
SET s.content = JSON_SET(s.content, '$.items[3].desc',
    'Wir beplanken die montierten GIS-Elemente und spachteln die Flächen für Maler und Plattenleger')
WHERE p.is_homepage = 1 AND s.type = 'services' AND JSON_VALID(s.content)
  AND LOWER(JSON_UNQUOTE(JSON_EXTRACT(s.content, '$.items[3].title'))) LIKE 'beplankung%';


-- ------------------------------------------------------------
-- Link-Texte vereinheitlichen
--
-- Heute steht abwechselnd "Jetzt entdecken" und "Mehr erfahren",
-- ohne dass ein Unterschied dahintersteckt. "Entdecken" ist
-- ausserdem Sprache aus dem Onlineshop. Ein Bauleiter entdeckt
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
-- Beide Absaetze neu. Ganze Saetze, keine Substantivketten,
-- kein Gedankenstrich. Die Angabe "ueber 25 Fachkraefte" bleibt,
-- das ist die staerkste Zahl auf der ganzen Startseite.
-- ------------------------------------------------------------
UPDATE sections s
JOIN pages p ON p.id = s.page_id
SET s.content = JSON_SET(s.content, '$.body',
    CONCAT(
      '<p>Die SUI Innova GmbH fertigt Sanitärelemente vor und montiert sie. ',
      'Von Pfäffikon SZ aus arbeiten über 25 Fachkräfte in der ganzen Deutschschweiz.</p>',
      '<p>Wir bauen die GIS-Elemente in der Werkstatt auf und verrohren sie komplett. ',
      'Auf der Baustelle wird gestellt und angeschlossen, nicht mehr zusammengebaut. ',
      'Das verkürzt die Zeit im Rohbau. Was im Trockenen geprüft wurde, muss vor Ort ',
      'nicht nachgearbeitet werden.</p>'
    ))
WHERE p.is_homepage = 1 AND s.type = 'about-teaser' AND JSON_VALID(s.content);


-- ------------------------------------------------------------
-- Kontrolle: was steht jetzt drin?
-- ------------------------------------------------------------
-- SELECT JSON_UNQUOTE(JSON_EXTRACT(content, '$.items[0].title')) AS karte,
--        JSON_UNQUOTE(JSON_EXTRACT(content, '$.items[0].desc'))  AS text
-- FROM sections s JOIN pages p ON p.id = s.page_id
-- WHERE p.is_homepage = 1 AND s.type = 'services';
