-- ============================================================
-- SUI Innova GmbH — Gedankenstriche aus allen Texten entfernen
--
-- In den Inhalten stehen rund 30 Gedankenstriche, meist aus
-- aelteren Migrationen. Beispiele:
--
--   "...technische Frage – schreiben Sie uns."
--   "...einen festen Ansprechpartner – keine Hotline."
--   "...durch erfahrene Teams – damit Ihr Projekt im Zeitplan
--    bleibt."
--
-- Ersetzt wird jeweils durch ein Komma. In allen vorgefundenen
-- Faellen ist der Strich ein Einschub, und ein Komma leistet
-- dasselbe.
--
-- WICHTIG, was NICHT angefasst wird:
--
--   Bindestriche in zusammengesetzten Woertern bleiben.
--   "GIS-Elemente" und "Sanitaer-Vorwandelemente" enthalten
--   einen Bindestrich, keinen Gedankenstrich. Die Ersetzung
--   greift nur, wenn links und rechts ein Leerzeichen steht.
--
--   Zeitspannen wie "Mo-Fr" oder "07:00-12:00" bleiben aus
--   demselben Grund unberuehrt.
--
-- Gefahrlos mehrfach ausfuehrbar: nach dem ersten Durchlauf
-- gibt es nichts mehr zu ersetzen.
-- ============================================================

SET NAMES utf8mb4;


-- ------------------------------------------------------------
-- Seiteninhalte
-- ------------------------------------------------------------
UPDATE sections
SET content = REPLACE(REPLACE(content, ' — ', ', '), ' – ', ', ')
WHERE content LIKE '% — %' OR content LIKE '% – %';


-- ------------------------------------------------------------
-- Seitentitel und Beschreibungen fuer das Suchergebnis
-- ------------------------------------------------------------
UPDATE pages
SET meta_desc = REPLACE(REPLACE(meta_desc, ' — ', ', '), ' – ', ', ')
WHERE meta_desc LIKE '% — %' OR meta_desc LIKE '% – %';

UPDATE pages
SET meta_title = REPLACE(REPLACE(meta_title, ' — ', ', '), ' – ', ', ')
WHERE meta_title LIKE '% — %' OR meta_title LIKE '% – %';

UPDATE pages
SET title = REPLACE(REPLACE(title, ' — ', ', '), ' – ', ', ')
WHERE title LIKE '% — %' OR title LIKE '% – %';


-- ------------------------------------------------------------
-- Einstellungen: Cookie-Banner, Karriere-Text, Footer und so weiter
-- ------------------------------------------------------------
UPDATE settings
SET setting_val = REPLACE(REPLACE(setting_val, ' — ', ', '), ' – ', ', ')
WHERE setting_val LIKE '% — %' OR setting_val LIKE '% – %';


-- ------------------------------------------------------------
-- Referenzen
-- ------------------------------------------------------------
UPDATE ref_items
SET description = REPLACE(REPLACE(description, ' — ', ', '), ' – ', ', ')
WHERE description LIKE '% — %' OR description LIKE '% – %';

UPDATE ref_items
SET title = REPLACE(REPLACE(title, ' — ', ', '), ' – ', ', ')
WHERE title LIKE '% — %' OR title LIKE '% – %';


-- ------------------------------------------------------------
-- Doppelte Kommas aufraeumen
--
-- Stand vor dem Strich schon ein Komma, entsteht ", ,". Das
-- faellt hier wieder weg.
-- ------------------------------------------------------------
UPDATE sections SET content    = REPLACE(content,    ', , ', ', ') WHERE content    LIKE '%, , %';
UPDATE pages    SET meta_desc  = REPLACE(meta_desc,  ', , ', ', ') WHERE meta_desc  LIKE '%, , %';
UPDATE pages    SET meta_title = REPLACE(meta_title, ', , ', ', ') WHERE meta_title LIKE '%, , %';
UPDATE settings SET setting_val= REPLACE(setting_val,', , ', ', ') WHERE setting_val LIKE '%, , %';


-- ------------------------------------------------------------
-- Nachbesserung: Komma zu Punkt, wo ein Hauptsatz folgt
--
-- Die Ersetzung oben setzt ueberall ein Komma. Das passt bei
-- Einschueben ("durch erfahrene Teams, damit Ihr Projekt im
-- Zeitplan bleibt") und bei Aufzaehlungen. Folgt aber ein
-- vollstaendiger Hauptsatz mit eigenem Subjekt und Verb, ist
-- das ein Kommafehler: "technische Frage, schreiben Sie uns".
--
-- Diese Stellen sind namentlich bekannt und werden einzeln
-- korrigiert. Findet sich eine nicht, passiert nichts.
-- ------------------------------------------------------------

-- Kontaktseite
UPDATE sections SET content = REPLACE(content,
    'technische Frage, schreiben Sie uns',
    'technische Frage. Schreiben Sie uns')
WHERE content LIKE '%technische Frage, schreiben Sie uns%';

-- Leistungsseite
UPDATE sections SET content = REPLACE(content,
    'ohne Verpflichtung, wir melden uns',
    'ohne Verpflichtung. Wir melden uns')
WHERE content LIKE '%ohne Verpflichtung, wir melden uns%';

UPDATE sections SET content = REPLACE(content,
    'Aqua Panel und Montage, alle Sanitärleistungen',
    'Aqua Panel und Montage: alle Sanitärleistungen')
WHERE content LIKE '%Aqua Panel und Montage, alle Sanitärleistungen%';

-- Datenschutzseite
UPDATE sections SET content = REPLACE(content,
    'Administratoren, wird beim Schliessen',
    'Administratoren. Wird beim Schliessen')
WHERE content LIKE '%Administratoren, wird beim Schliessen%';

-- Karriere-Einleitung im Bewerbungsfenster
UPDATE settings SET setting_val = REPLACE(setting_val,
    'Ihre Bewerbung, wir freuen uns darauf',
    'Ihre Bewerbung. Wir freuen uns darauf')
WHERE setting_val LIKE '%Ihre Bewerbung, wir freuen uns darauf%';

-- Beschreibungen fuers Suchergebnis: nach dem Firmennamen liest
-- sich ein Doppelpunkt besser als ein drittes Komma
UPDATE pages SET meta_desc = REPLACE(meta_desc,
    'SUI Innova GmbH, Kontaktadresse', 'SUI Innova GmbH: Kontaktadresse')
WHERE meta_desc LIKE '%SUI Innova GmbH, Kontaktadresse%';

UPDATE pages SET meta_desc = REPLACE(meta_desc,
    'SUI Innova GmbH, Informationen zur', 'SUI Innova GmbH: Informationen zur')
WHERE meta_desc LIKE '%SUI Innova GmbH, Informationen zur%';

UPDATE pages SET meta_desc = REPLACE(meta_desc,
    'SUI Innova GmbH, Sanitärinstallationen', 'SUI Innova GmbH: Sanitärinstallationen')
WHERE meta_desc LIKE '%SUI Innova GmbH, Sanitärinstallationen%';


-- ------------------------------------------------------------
-- Kontrolle: muss ueberall 0 ergeben
-- ------------------------------------------------------------
-- SELECT 'sections' AS tabelle, COUNT(*) AS offen FROM sections
--   WHERE content LIKE '% — %' OR content LIKE '% – %'
-- UNION ALL SELECT 'pages', COUNT(*) FROM pages
--   WHERE meta_desc LIKE '% — %' OR meta_desc LIKE '% – %'
--      OR meta_title LIKE '% — %' OR meta_title LIKE '% – %'
-- UNION ALL SELECT 'settings', COUNT(*) FROM settings
--   WHERE setting_val LIKE '% — %' OR setting_val LIKE '% – %';
