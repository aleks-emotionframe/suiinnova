-- ============================================================
-- SUI INNOVA — ALLES IN EINER DATEI
--
-- Erstellt 14.09.2026 von EmotionFrame GmbH
--
-- Diese Datei ersetzt alle bisherigen SQL-Dateien und alle
-- Nachtraege. Sie enthaelt neun Abschnitte in der richtigen
-- Reihenfolge und ist gefahrlos mehrfach ausfuehrbar.
--
-- Es spielt keine Rolle, was Sie schon eingespielt haben.
-- Jeder Abschnitt prueft selbst, ob es etwas zu tun gibt.
--
--   A) Seitentitel, Beschreibungen, Hauptueberschriften
--   B) Spalte fuer die Bild-Groessenvarianten
--   C) Sechs neue Seiten anlegen, noch deaktiviert
--   D) Diese Seiten auf den aktuellen Aufbau bringen
--   E) Texte der Startseite schaerfen
--   F) Harte Zeilenumbrueche in den Werte-Karten
--   G) Hero-Titel der Startseite kuerzen
--   H) "ganze Schweiz" wird "ganze Deutschschweiz"
--   I) Gedankenstriche aus allen Texten entfernen
--
-- WICHTIG: Zuerst die Dateien aus dem Ordner WEBSITE
-- hochladen. Abschnitt D stellt Sektionen auf einen Typ um,
-- dessen Vorlage sonst fehlt, und dann zeigen die sechs
-- Seiten nichts an.
--
-- SO GEHT ES:
--   Hostpoint -> phpMyAdmin -> Datenbank bifitudo_suinnova
--   -> Reiter "SQL" -> diese Datei komplett einfuegen -> OK
-- ============================================================

-- Zeichensatz der Verbindung festnageln. MUSS als Erstes kommen.
-- Ohne diese Zeile interpretiert der Server die Datei je nach Client
-- als latin1, und aus "Pfäffikon" wird "PfÃ¤ffikon". Im Test genau
-- so passiert.
SET NAMES utf8mb4;


-- ════════════════════════════════════════════════════════════
-- A) SEITENTITEL, BESCHREIBUNGEN UND UEBERSCHRIFTEN
-- ════════════════════════════════════════════════════════════

UPDATE settings SET setting_val = '' WHERE setting_key = 'meta_title_suffix';


-- ------------------------------------------------------------
-- 2) Seitentitel und Meta-Descriptions
--
-- Muster: "Leistung, Ort | Firma", unter 60 Zeichen.
-- Descriptions rund 150 Zeichen, jede endet mit einer Aufforderung.
--
-- Abweichung vom Keyword-Plan, bewusst:
-- Der Plan weist "sanitär vorfabrikation" UND "gis elemente" beide der
-- Startseite zu. Zwei Begriffe auf einer Seite konkurrieren gegen-
-- einander. Die Aufteilung ist deshalb:
--   Startseite  → "GIS Elemente Vorfabrikation"  (Hauptkeyword,
--                 spezifisches Produkt, Kundenentscheid)
--   Leistungen  → "Sanitär Vorfabrikation"       (Oberbegriff, deckt
--                 alle vier Leistungen ab)
-- ------------------------------------------------------------

-- Startseite → HAUPTKEYWORD: gis elemente vorfabrikation
UPDATE pages SET
    meta_title = 'GIS Elemente Vorfabrikation | SUI Innova GmbH',
    meta_desc  = 'GIS Elemente Vorfabrikation aus Pfäffikon SZ: fertig verrohrt aus der eigenen Werkstatt, inklusive Montage, Beplankung und Spachtelung. Jetzt Offerte anfragen.'
WHERE is_homepage = 1;

-- Leistungen → sanitär vorfabrikation
UPDATE pages SET
    meta_title = 'Sanitär Vorfabrikation: Leistungen | SUI Innova',
    meta_desc  = 'Sanitär Vorfabrikation aus Pfäffikon SZ: GIS-Elemente verrohren, montieren, beplanken und spachteln, alles aus einer Hand. Pläne senden, Offerte erhalten.'
WHERE slug = 'leistungen';

-- Referenzen
UPDATE pages SET
    meta_title = 'Referenzen: vorfabrizierte Nasszellen | SUI Innova',
    meta_desc  = 'Ausgeführte Projekte der SUI Innova GmbH: vorfabrizierte GIS-Elemente, Montage und Beplankung in Neubau und Sanierung. Sehen Sie sich unsere Arbeit an.'
WHERE slug = 'referenzen';

-- Über uns
UPDATE pages SET
    meta_title = 'Werkstatt und Team in Pfäffikon SZ | SUI Innova',
    meta_desc  = 'Die SUI Innova GmbH fertigt Sanitär-Vorwandelemente in der eigenen Werkstatt in Pfäffikon SZ. Lernen Sie Team, Ablauf und Anspruch kennen.'
WHERE slug = 'ueber-uns';

-- Kontakt
UPDATE pages SET
    meta_title = 'Kontakt: Pläne einsenden, Offerte erhalten | SUI Innova',
    meta_desc  = 'Sanitär Vorfabrikation anfragen: Senden Sie uns Ihre Sanitärpläne, wir prüfen sie und melden uns mit einer Offerte. SUI Innova GmbH, Pfäffikon SZ.'
WHERE slug = 'kontakt';

-- Impressum
UPDATE pages SET
    meta_title = 'Impressum | SUI Innova GmbH',
    meta_desc  = 'Impressum der SUI Innova GmbH, Talstrasse 31, 8808 Pfäffikon SZ: Angaben zum Unternehmen, Vertretung und Kontaktmöglichkeiten.'
WHERE slug = 'impressum';

-- Datenschutz
UPDATE pages SET
    meta_title = 'Datenschutzerklärung | SUI Innova GmbH',
    meta_desc  = 'Wie die SUI Innova GmbH Personendaten bearbeitet: Kontaktformular, Bewerbungen, Cookies und Google Analytics, nach revDSG und DSGVO.'
WHERE slug = 'datenschutz';


-- ------------------------------------------------------------
-- 3) Hauptueberschriften (H1)
--
-- Ab Paket 1 rendert die erste Sektion mit Ueberschrift automatisch
-- ein <h1> statt <h2> (core/helpers.php, headingTag()). Hier bekommt
-- genau diese Sektion je Seite ihren keyword-tragenden Text.
--
-- Das Unterabfrage-Konstrukt trifft pro Seite die Sektion mit der
-- kleinsten sort_order, die ueberhaupt eine nicht-leere Ueberschrift
-- hat — also genau die, die zum h1 wird. Sektionen ohne Ueberschrift
-- (z.B. der Parallax-Kopfbanner) werden uebersprungen.
-- ------------------------------------------------------------
UPDATE sections s
JOIN (
    SELECT s2.page_id, p.slug, MIN(s2.sort_order) AS first_sort
    FROM sections s2
    JOIN pages p ON p.id = s2.page_id
    WHERE s2.is_active = 1
      AND JSON_VALID(s2.content)
      AND JSON_UNQUOTE(JSON_EXTRACT(s2.content, '$.heading')) IS NOT NULL
      AND JSON_UNQUOTE(JSON_EXTRACT(s2.content, '$.heading')) <> ''
    GROUP BY s2.page_id, p.slug
) f ON f.page_id = s.page_id AND f.first_sort = s.sort_order
SET s.content = JSON_SET(
    s.content,
    '$.heading',
    CASE f.slug
        WHEN 'leistungen'  THEN 'Sanitär Vorfabrikation: von der Werkstatt bis zur fertigen Wand'
        WHEN 'referenzen'  THEN 'Referenzen: vorfabrizierte Sanitärelemente in Ausführung'
        WHEN 'ueber-uns'   THEN 'Werkstatt und Team in Pfäffikon SZ'
        WHEN 'kontakt'     THEN 'Pläne einsenden und Offerte anfordern'
        WHEN 'impressum'   THEN 'Impressum'
        WHEN 'datenschutz' THEN 'Datenschutzerklärung'
        ELSE JSON_UNQUOTE(JSON_EXTRACT(s.content, '$.heading'))
    END
)
WHERE f.slug IN ('leistungen', 'referenzen', 'ueber-uns', 'kontakt', 'impressum', 'datenschutz');

-- Startseite separat: Der Hero-Titel steht gross und in Grossbuchstaben.
-- Die lange Fassung aus dem Keyword-Plan ("Sanitär Vorfabrikation:
-- GIS-Elemente fertig verrohrt aus Pfäffikon SZ") sprengt den Hero.
-- Das Hauptkeyword und der Ort stehen trotzdem drin.
--
-- Falls die Zeile im Hero optisch zu lang wirkt: im CMS unter
-- Startseite -> Hero auf 'GIS Elemente Vorfabrikation' kuerzen.
-- Das Keyword bleibt dann vollstaendig erhalten.
UPDATE sections s
JOIN pages p ON p.id = s.page_id
SET s.content = JSON_SET(s.content, '$.heading', 'GIS Elemente Vorfabrikation aus Pfäffikon SZ')
WHERE p.is_homepage = 1
  AND s.type = 'hero'
  AND JSON_VALID(s.content);


-- ------------------------------------------------------------
-- 4) Kontrolle
--
-- Nach dem Einspielen pruefen: jede Zeile muss einen Titel und eine
-- Beschreibung haben.
-- ------------------------------------------------------------
-- SELECT slug, CHAR_LENGTH(meta_title) AS titel_laenge, meta_title,
--        CHAR_LENGTH(meta_desc) AS desc_laenge
-- FROM pages ORDER BY sort_order;


-- ════════════════════════════════════════════════════════════
-- B) SPALTE FUER DIE BILD-GROESSENVARIANTEN
-- ════════════════════════════════════════════════════════════

SET @spalte_fehlt = (
    SELECT COUNT(*) = 0 FROM information_schema.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'media' AND COLUMN_NAME = 'variants'
);
SET @befehl = IF(@spalte_fehlt,
    'ALTER TABLE media ADD COLUMN variants TEXT NULL AFTER thumb_path', 'DO 0');
PREPARE anlegen FROM @befehl;
EXECUTE anlegen;
DEALLOCATE PREPARE anlegen;


-- ════════════════════════════════════════════════════════════
-- C) SECHS NEUE SEITEN ANLEGEN (deaktiviert)
-- ════════════════════════════════════════════════════════════

SET @next_sort = (SELECT COALESCE(MAX(sort_order), 0) + 10 FROM pages);

-- ────────────────────────────────────────────────────────────
-- /sanitaer-vorwandelemente
-- ────────────────────────────────────────────────────────────
INSERT INTO pages (title, slug, meta_title, meta_desc, is_active, is_homepage, sort_order)
SELECT 'Sanitär Vorwandelemente', 'sanitaer-vorwandelemente', 'Sanitär Vorwandelemente: Aufbau, Montage | SUI Innova', 'Sanitär Vorwandelemente: Aufbau, Masse, Beplankung und Montage einfach erklärt. Lesen Sie, worauf es ankommt, und fragen Sie Ihr Projekt bei SUI Innova an.', 0, 0, @next_sort + 0
FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE slug = 'sanitaer-vorwandelemente');

SET @pid = (SELECT id FROM pages WHERE slug = 'sanitaer-vorwandelemente' LIMIT 1);

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'parallax-image', '{"image_id":0,"height":"medium","overlay_text":""}', 10, 1
FROM DUAL
WHERE @pid IS NOT NULL
  AND NOT EXISTS (SELECT 1 FROM sections WHERE page_id = @pid AND sort_order = 10);

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'content-grid', '{"heading":"Sanitär Vorwandelemente: Aufbau, Montage und Beplankung erklärt","lead":"<p>Sanitär Vorwandelemente tragen WC, Waschtisch, Dusche oder Urinal und nehmen Zu- und Ablaufleitungen auf, ohne dass jemand die Rohre sieht. Sie bestehen aus einem verzinkten Stahlrahmen, der am Boden und an der Rohbauwand verschraubt wird, und werden anschliessend beplankt und gespachtelt. Auf dieser Seite lesen Sie, wie ein solches Element aufgebaut ist, welche Masse üblich sind, warum die Beplankung im Nassbereich eine eigene Rolle spielt und wo im Bauablauf die Schallentkopplung entschieden wird. SUI Innova aus Pfäffikon fertigt GIS-Elemente in der eigenen Werkstatt fix und fertig verrohrt vor, montiert sie auf der Baustelle und übernimmt Beplankung, Spachtelung und Ausflockung. Sie erhalten die Wand also nicht in Teilen, sondern als eine Leistung.</p>","style":"light","items":[{"title":"Ein Vorwandelement ist Tragwerk und Installationsraum zugleich","text":"<p>Das Element nimmt die Lasten von WC, Waschtisch oder Stützgriffen auf und leitet sie in Boden und Rohbauwand ab. Gleichzeitig läuft im Innenraum alles, was nicht sichtbar sein soll: Kalt- und Warmwasser, Abwasser, teilweise Elektro. Deshalb wird die Position jeder Leitung festgelegt, bevor die erste Platte montiert wird. Fehler in dieser Phase kosten später Aufbruch und Zeit.</p>"},{"title":"Vorfabrikation verlagert die knifflige Arbeit von der Baustelle in die Werkstatt","text":"<p>In der Werkstatt lassen sich Elemente auf dem Tisch verrohren, ausrichten und prüfen. Auf der Baustelle wird das fertige Element nur noch gestellt, befestigt und angeschlossen. Das verkürzt die Zeit, in der andere Gewerke warten müssen, und reduziert Anpassungen vor Ort. SUI Innova liefert GIS-Elemente fix und fertig verrohrt aus der eigenen Werkstatt an.</p>"},{"title":"Masse und Höhen ergeben sich aus dem Apparat, nicht aus dem Gefühl","text":"<p>Übliche Bauhöhen sind das halbhohe Element für die freistehende Vorwand und das raumhohe Element bis zur Decke. Die Fertighöhe der WC-Keramik und die Lage der Spülkasten-Betätigung richten sich nach Herstellerangaben und nach der geplanten Bodenaufbauhöhe. Wird der Bodenaufbau später geändert, stimmt die Höhe nicht mehr. Klären Sie die Aufbauhöhe deshalb vorgängig mit Architektur und Plattenleger. Welche Höhe und welches System für Ihre Nasszelle passen, legen wir anhand der Pläne und der gewählten Apparate fest.</p>"},{"title":"Im Nassbereich entscheidet die Beplankung über die Lebensdauer","text":"<p>Hinter Dusche und Badewanne gehört eine Platte, die Feuchtigkeit verträgt. AquaPanel wird in Feuchträumen und Nasszellen eingesetzt und bildet den Untergrund für Abdichtung und Plättli. Die Fugen und Anschlüsse werden gespachtelt, damit die Fläche ohne Absatz weitergeht. SUI Innova übernimmt Beplankung und Spachtelung im gleichen Auftrag wie die Montage.</p>"},{"title":"Schall wird an der Befestigung entschieden, nicht am Rohr","text":"<p>Spülgeräusche wandern über Körperschall in angrenzende Räume, wenn Element und Rohre starr mit der Rohbauwand verbunden sind. Entkoppelte Befestigungen, Schallschutzsets und eine Ausflockung des Hohlraums dämpfen diesen Weg. Besonders wichtig ist das bei Wänden zu Schlafräumen und in Mehrfamilienhäusern. Welche Anforderung für Ihr Projekt gilt, steht im Schallschutznachweis. Nennen Sie uns die Vorgabe, wir richten den Aufbau danach aus.</p>"},{"title":"Von der Planung bis zur spachtelfertigen Wand aus einer Hand","text":"<p>Sie schicken uns Pläne oder Schemas, wir klären die Apparatepositionen und fertigen die Elemente vor. Danach montieren wir auf der Baustelle, beplanken und spachteln. Sie haben eine Ansprechperson für Vorfabrikation, Montage und Beplankung statt drei Schnittstellen. Was das für Ihr Projekt konkret heisst, klären wir am besten anhand Ihrer Unterlagen.</p>"}]}', 20, 1
FROM DUAL
WHERE @pid IS NOT NULL
  AND NOT EXISTS (SELECT 1 FROM sections WHERE page_id = @pid AND sort_order = 20);

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'faq', '{"heading":"Fragen und Antworten","subtitle":"","items":[{"question":"Wie tief ist eine Sanitärvorwand üblicherweise?","answer":"<p>Die Tiefe richtet sich nach dem Spülkasten und den Leitungen dahinter. Für ein WC-Element rechnet man mit rund 15 bis 20 Zentimetern Rahmentiefe plus Beplankung. Bei zusätzlichen Steigleitungen oder Lüftungen wird die Vorwand entsprechend tiefer.</p>"},{"question":"Kann ich später etwas an der Wand befestigen?","answer":"<p>Nur dort, wo Traversen oder Verstärkungen eingebaut sind. Spiegelschrank, Handtuchhalter oder Stützgriffe sollten Sie deshalb vor der Beplankung anmelden. Nachträglich befestigt man in einer beplankten Vorwand nur leichte Lasten.</p>"},{"question":"Wer koordiniert Sanitär, Trockenbau und Plattenleger?","answer":"<p>Bei getrennten Aufträgen liegt die Koordination bei der Bauleitung. Wenn Vorfabrikation, Montage und Beplankung in einer Hand liegen, entfällt ein Teil dieser Abstimmung. SUI Innova übergibt die Wand spachtelfertig an das Folgegewerk.</p>"}]}', 30, 1
FROM DUAL
WHERE @pid IS NOT NULL
  AND NOT EXISTS (SELECT 1 FROM sections WHERE page_id = @pid AND sort_order = 30);

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'cta-banner', '{"heading":"Pläne einsenden, Offerte erhalten","body":"Senden Sie uns Ihre Pläne, wir melden uns mit Rückfragen zu Apparatepositionen und einer Offerte für Vorfabrikation, Montage und Beplankung.","button_text":"Pläne einsenden","button_url":"/kontakt"}', 40, 1
FROM DUAL
WHERE @pid IS NOT NULL
  AND NOT EXISTS (SELECT 1 FROM sections WHERE page_id = @pid AND sort_order = 40);

-- ────────────────────────────────────────────────────────────
-- /sanitaer-vorwaende
-- ────────────────────────────────────────────────────────────
INSERT INTO pages (title, slug, meta_title, meta_desc, is_active, is_homepage, sort_order)
SELECT 'Sanitär Vorwände', 'sanitaer-vorwaende', 'Sanitär Vorwände vorfabriziert | SUI Innova GmbH', 'Sanitär Vorwände vorfabriziert, montiert und beplankt: GIS-Elemente fix verrohrt aus der Werkstatt von SUI Innova in Pfäffikon. Jetzt Offerte anfragen.', 0, 0, @next_sort + 10
FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE slug = 'sanitaer-vorwaende');

SET @pid = (SELECT id FROM pages WHERE slug = 'sanitaer-vorwaende' LIMIT 1);

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'parallax-image', '{"image_id":0,"height":"medium","overlay_text":""}', 10, 1
FROM DUAL
WHERE @pid IS NOT NULL
  AND NOT EXISTS (SELECT 1 FROM sections WHERE page_id = @pid AND sort_order = 10);

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'content-grid', '{"heading":"Sanitär Vorwände: vorfabriziert, montiert, beplankt","lead":"<p>Sanitär Vorwände liefern wir fix und fertig verrohrt auf Ihre Baustelle. In unserer Werkstatt in Pfäffikon bauen wir GIS-Elemente auf Mass zusammen, montieren sie vor Ort und beplanken sie bis zur spachtelfertigen Wand. So verlagern Sie einen grossen Teil der Sanitärinstallation von der Baustelle in die Halle: weniger Schnittstellen, weniger Wartezeit für die Folgegewerke, planbare Abläufe. Sie erhalten Vorfabrikation, Montage und Beplankung aus einer Hand und haben einen Ansprechpartner für den ganzen Ablauf. Für Nasszellen und Feuchträume setzen wir AquaPanel ein, für Schallschutzanforderungen SilentPanel und Ausflockung. Senden Sie uns Ihre Pläne mit der Adresse der Baustelle, wir prüfen sie und melden uns mit einer Offerte.</p>","style":"light","items":[{"title":"GIS-Elemente verlassen unsere Werkstatt fertig verrohrt","text":"<p>Wir konfektionieren die Vorwandelemente nach Ihren Plänen und verrohren sie komplett. Auf der Baustelle wird das Element gesetzt und angeschlossen, nicht mehr zusammengebaut. Das verkürzt die Zeit im Rohbau und senkt das Risiko von Fehlern in engen Platzverhältnissen. Änderungen klären wir vorgängig am Plan, nicht improvisiert vor Ort.</p>"},{"title":"Montage und Beplankung kommen vom gleichen Team","text":"<p>Unsere Monteure setzen die Vorwände auf Ihrer Baustelle und richten sie aus. Anschliessend beplanken wir die Wände und spachteln sie, sodass der Maler oder Plattenleger direkt weiterarbeiten kann. Weil Vorfabrikation und Montage im gleichen Haus liegen, entfällt die Abstimmung zwischen mehreren Firmen. Bei Terminverschiebungen reagieren wir mit Ihnen zusammen auf den aktuellen Bauablauf.</p>"},{"title":"AquaPanel für Nasszellen, SilentPanel gegen Schall","text":"<p>In Bädern und Duschen beplanken wir mit AquaPanel, das für dauerhafte Feuchtebelastung ausgelegt ist. Wo Schallschutz gefordert ist, arbeiten wir mit SilentPanel und Ausflockung der Hohlräume. Welche Kombination sinnvoll ist, hängt von der Nutzung und den Anforderungen im Bauprojekt ab. Sagen Sie uns, welche Werte gefordert sind, wir schlagen den Aufbau vor.</p>"},{"title":"Für Neubau, Umbau und Sanierung im Wohnungsbau","text":"<p>Wir arbeiten für Sanitärinstallateure, Generalunternehmen und Bauherrschaften. Bei Mehrfamilienhäusern fertigen wir gleiche Elemente in Serie, bei Umbauten passen wir jedes Element an den Bestand an. Für Sanierungen im bewohnten Objekt kürzt die Vorfabrikation die Zeit, in der das Bad nicht nutzbar ist. Ausgeführte Arbeiten sehen Sie unter <a href=\\"/referenzen\\">Referenzen</a>.</p>"},{"title":"So läuft eine Anfrage ab","text":"<p>Sie senden uns Grundrisse und Sanitärpläne. Wir prüfen die Unterlagen, klären offene Punkte mit Ihnen und stellen eine Offerte mit Positionen und Terminen. Nach Ihrer Freigabe fertigen wir die Elemente und vereinbaren den Montagetermin. Sie erhalten von uns eine Ansprechperson, die das Projekt bis zur fertigen Wand begleitet.</p>"}]}', 20, 1
FROM DUAL
WHERE @pid IS NOT NULL
  AND NOT EXISTS (SELECT 1 FROM sections WHERE page_id = @pid AND sort_order = 20);

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'faq', '{"heading":"Fragen und Antworten","subtitle":"","items":[{"question":"Was ist eine Sanitär Vorwand?","answer":"<p>Eine Sanitär Vorwand ist eine vorgesetzte Ständerkonstruktion, in der Zuleitungen, Abläufe und Befestigungen für WC, Waschtisch oder Dusche liegen. Sie wird vor die Rohbauwand gestellt und danach beplankt. Sichtbar bleibt später nur die fertige Wandfläche.</p>"},{"question":"Was ist der Vorteil von vorfabrizierten Vorwänden gegenüber dem Bau auf der Baustelle?","answer":"<p>Die Elemente entstehen in der Werkstatt unter gleichbleibenden Bedingungen und kommen fertig verrohrt auf die Baustelle. Vor Ort bleibt das Setzen und Anschliessen, das verkürzt die Bauzeit und reduziert Nacharbeiten. Zudem koordinieren Sie weniger Beteiligte.</p>"},{"question":"Übernehmen Sie auch die Beplankung und Spachtelung?","answer":"<p>Ja, wir beplanken die montierten Vorwände und spachteln sie auf Wunsch fertig. In Feuchträumen setzen wir AquaPanel ein. Damit übergeben wir eine Wand, an der das nächste Gewerk direkt weiterarbeiten kann.</p>"}]}', 30, 1
FROM DUAL
WHERE @pid IS NOT NULL
  AND NOT EXISTS (SELECT 1 FROM sections WHERE page_id = @pid AND sort_order = 30);

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'cta-banner', '{"heading":"Pläne einsenden und Offerte anfragen","body":"Senden Sie uns Ihre Sanitär- und Grundrisspläne, wir prüfen sie und schicken Ihnen eine Offerte mit Terminen.","button_text":"Pläne einsenden","button_url":"/kontakt"}', 40, 1
FROM DUAL
WHERE @pid IS NOT NULL
  AND NOT EXISTS (SELECT 1 FROM sections WHERE page_id = @pid AND sort_order = 40);

-- ────────────────────────────────────────────────────────────
-- /sanitaer-gis-elemente-bestellen
-- ────────────────────────────────────────────────────────────
INSERT INTO pages (title, slug, meta_title, meta_desc, is_active, is_homepage, sort_order)
SELECT 'GIS-Elemente bestellen', 'sanitaer-gis-elemente-bestellen', 'Sanitär GIS Elemente bestellen | SUI Innova GmbH', 'Sanitär GIS Elemente bestellen: vorfabriziert, verrohrt und auf Wunsch beplankt. Senden Sie uns Ihre Pläne, wir erstellen eine Offerte.', 0, 0, @next_sort + 20
FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE slug = 'sanitaer-gis-elemente-bestellen');

SET @pid = (SELECT id FROM pages WHERE slug = 'sanitaer-gis-elemente-bestellen' LIMIT 1);

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'parallax-image', '{"image_id":0,"height":"medium","overlay_text":""}', 10, 1
FROM DUAL
WHERE @pid IS NOT NULL
  AND NOT EXISTS (SELECT 1 FROM sections WHERE page_id = @pid AND sort_order = 10);

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'content-grid', '{"heading":"Sanitär GIS Elemente bestellen bei SUI Innova","lead":"<p>Sie wollen Sanitär GIS Elemente bestellen, die auf der Baustelle nur noch gestellt und angeschlossen werden müssen. Genau das liefern wir. In unserer Werkstatt in Pfäffikon bauen wir GIS Elemente nach Ihren Plänen auf, verrohren sie fix und fertig und bereiten sie für den Transport vor. Auf Wunsch übernehmen wir auch Montage, Beplankung mit AquaPanel, Spachtelung und Ausflockung mit SilentPanel. Sie erhalten alles aus einer Hand und haben eine Ansprechperson für den ganzen Ablauf. Schicken Sie uns Ihre Sanitärpläne oder eine Skizze mit Apparateliste. Wir prüfen die Unterlagen, melden uns bei offenen Punkten und erstellen Ihnen eine Offerte mit Preis und möglichem Liefertermin.</p>","style":"light","items":[{"title":"So läuft die Bestellung ab","text":"<p>Sie senden uns Ihre Sanitärpläne, die Apparateliste und den gewünschten Liefertermin. Wir prüfen die Unterlagen und klären offene Punkte direkt mit Ihnen oder mit dem Planer. Danach erhalten Sie eine Offerte mit Positionen, Preis und Terminvorschlag. Nach Ihrer Freigabe starten wir die Vorfabrikation in der Werkstatt.</p>"},{"title":"Fix und fertig verrohrt aus der Werkstatt","text":"<p>Wir bauen die GIS Elemente auf und verrohren sie komplett, bevor sie die Werkstatt verlassen. Dadurch verschieben Sie Arbeitsstunden von der Baustelle in eine Umgebung mit festen Arbeitsplätzen und Material zur Hand. Auf der Baustelle bleibt das Stellen, Fixieren und Anschliessen. Das verkürzt die Zeit, in der andere Gewerke warten müssen.</p>"},{"title":"Was Sie zusätzlich zum Element bestellen können","text":"<p>Viele Kunden bestellen nicht nur das nackte Element. Wir montieren die Elemente direkt auf Ihrer Baustelle, beplanken sie mit AquaPanel für Feuchträume und Nasszellen und spachteln die Flächen. Für den Schallschutz flocken wir die Vorwand mit SilentPanel aus. Sie entscheiden, wo unsere Arbeit endet und Ihre beginnt.</p>"},{"title":"Angaben, die wir für eine Offerte brauchen","text":"<p>Für eine belastbare Offerte brauchen wir den Sanitärplan oder eine bemasste Skizze, die Anzahl und Art der Apparate und die Höhen der Vorwand. Nützlich sind zudem Angaben zum Wandaufbau, zur gewünschten Beplankung und zu Anforderungen an den Schallschutz. Nennen Sie uns auch die Zufahrt und die Etage, das beeinflusst Anlieferung und Handling. Fehlt etwas, fragen wir nach, bevor wir rechnen.</p>"},{"title":"Für Sanitärunternehmen, Generalunternehmer und Bauherren","text":"<p>Wir arbeiten für Sanitärbetriebe, die Kapazität in der Werkstatt brauchen, und für Bauleitungen, die einen fixen Liefertermin wollen. Kleine Umbauten mit einem einzelnen Element sind ebenso möglich wie Serien für ganze Geschosse. Sagen Sie uns, wie viele Elemente Sie brauchen und bis wann. Wir sagen Ihnen ehrlich, ob wir den Termin halten können.</p>"},{"title":"Lieferung und Termine","text":"<p>Die Elemente werden montagefertig angeliefert und nach Absprache abgeladen. Den Liefertermin halten wir in der Offerte fest, damit Ihre Bauleitung damit planen kann. Verschiebt sich Ihr Bauprogramm, melden Sie sich frühzeitig, dann suchen wir einen neuen Termin. Wie schnell wir fertigen können, hängt von Stückzahl und Auslastung ab. Fragen Sie früh an, dann sagen wir Ihnen verbindlich, was möglich ist.</p>"}]}', 20, 1
FROM DUAL
WHERE @pid IS NOT NULL
  AND NOT EXISTS (SELECT 1 FROM sections WHERE page_id = @pid AND sort_order = 20);

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'faq', '{"heading":"Fragen und Antworten","subtitle":"","items":[{"question":"Kann ich einzelne GIS Elemente bestellen oder nur ganze Serien?","answer":"<p>Beides ist möglich. Wir fertigen einzelne Elemente für Umbauten ebenso wie Serien für Neubauten. Nennen Sie uns die Stückzahl bei der Anfrage.</p>"},{"question":"Muss ich das Material selber liefern?","answer":"<p>Das klären wir vor der Offerte, je nach Projekt und Verfügbarkeit. Sagen Sie uns bei der Anfrage, ob Sie Material beistellen möchten, dann rechnen wir die Offerte entsprechend.</p>"},{"question":"Übernehmen Sie auch die Montage auf der Baustelle?","answer":"<p>Ja, wir montieren die Elemente direkt auf Ihrer Baustelle. Auf Wunsch beplanken und spachteln wir die Wand anschliessend. Sie bestellen also nur die Vorfabrikation oder den ganzen Ablauf bis zur fertigen Wand.</p>"}]}', 30, 1
FROM DUAL
WHERE @pid IS NOT NULL
  AND NOT EXISTS (SELECT 1 FROM sections WHERE page_id = @pid AND sort_order = 30);

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'cta-banner', '{"heading":"GIS Elemente anfragen","body":"Senden Sie uns Ihre Sanitärpläne über das Kontaktformular, wir melden uns mit Rückfragen und einer Offerte samt Terminvorschlag.","button_text":"Pläne einsenden","button_url":"/kontakt"}', 40, 1
FROM DUAL
WHERE @pid IS NOT NULL
  AND NOT EXISTS (SELECT 1 FROM sections WHERE page_id = @pid AND sort_order = 40);

-- ────────────────────────────────────────────────────────────
-- /sanitaer-vorwandelemente-bestellen
-- ────────────────────────────────────────────────────────────
INSERT INTO pages (title, slug, meta_title, meta_desc, is_active, is_homepage, sort_order)
SELECT 'Vorwandelemente bestellen', 'sanitaer-vorwandelemente-bestellen', 'Sanitär Vorwandelemente bestellen | SUI Innova', 'Sanitär Vorwandelemente bestellen bei SUI Innova in Pfäffikon: GIS-Elemente fertig verrohrt, auf Mass vorfabriziert, montiert und beplankt. Jetzt anfragen.', 0, 0, @next_sort + 30
FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE slug = 'sanitaer-vorwandelemente-bestellen');

SET @pid = (SELECT id FROM pages WHERE slug = 'sanitaer-vorwandelemente-bestellen' LIMIT 1);

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'parallax-image', '{"image_id":0,"height":"medium","overlay_text":""}', 10, 1
FROM DUAL
WHERE @pid IS NOT NULL
  AND NOT EXISTS (SELECT 1 FROM sections WHERE page_id = @pid AND sort_order = 10);

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'content-grid', '{"heading":"Sanitär Vorwandelemente bestellen: vorfabriziert aus Pfäffikon","lead":"<p>Sie können bei SUI Innova Sanitär Vorwandelemente bestellen, die bereits verrohrt aus unserer Werkstatt kommen. Wir fertigen GIS-Elemente nach Ihren Plänen vor, prüfen die Leitungsführung im Voraus und liefern die Elemente auf die Baustelle. Auf Wunsch übernehmen wir auch die Montage, die Beplankung mit AquaPanel und die Spachtelung, bis die Wand fertig ist. Für Sie heisst das: weniger Schnittstellen, weniger Nacharbeit, ein Ansprechpartner für Vorfabrikation und Einbau. Wir arbeiten für Sanitärbetriebe, Generalunternehmen und Bauherrschaften in der Region Pfäffikon und darüber hinaus. Sagen Sie uns, welche Apparate, welche Wandtypen und welchen Liefertermin Sie brauchen. Sie erhalten eine Offerte mit Positionen, Massen und Liefertermin, damit Sie die Kosten Ihres Projekts sauber rechnen können.</p>","style":"light","items":[{"title":"Was Sie bei uns bestellen: GIS-Elemente, fertig verrohrt","text":"<p>Wir bauen die Vorwandelemente in unserer Werkstatt auf, montieren die Sanitärapparate-Träger und verrohren sie komplett. Auf der Baustelle wird das Element nur noch gesetzt und angeschlossen. Das verkürzt die Zeit auf dem Bau und verlagert die Präzisionsarbeit in eine trockene, eingerichtete Werkstatt. Sie bestellen einzelne Elemente oder ganze Geschosse. Welches System zum Einsatz kommt, richtet sich nach Ihrer Ausschreibung. Nennen Sie es uns bei der Anfrage.</p>"},{"title":"So läuft die Bestellung ab, Schritt für Schritt","text":"<p>Sie senden uns die Sanitärpläne oder eine Skizze mit den gewünschten Apparaten. Wir prüfen Masse, Wandaufbau und Leitungsführung und melden uns bei Unklarheiten vorgängig. Danach erhalten Sie eine Offerte mit Stückliste und Liefertermin. Nach Ihrer Freigabe fertigen wir vor und liefern die Elemente auf die Baustelle. Den Vorlauf zwischen Freigabe und Lieferung halten wir in der Offerte fest, damit Ihre Bauleitung damit planen kann.</p>"},{"title":"Montage und Beplankung dazubestellen statt koordinieren","text":"<p>Sie können die Elemente ab Werkstatt beziehen oder die Montage gleich mitbestellen. Unser Team setzt die Elemente auf Ihrer Baustelle, richtet sie aus und befestigt sie. Anschliessend beplanken wir mit AquaPanel für Feuchträume und Nasszellen und spachteln die Flächen. So übergeben wir Ihnen die Wand malerfertig.</p>"},{"title":"Schallschutz und Ausflockung für Nasszellen","text":"<p>Wasserleitungen und Spülungen übertragen Geräusche in angrenzende Räume. Wir flocken die Vorwandelemente aus und arbeiten mit SilentPanel, damit die Wand ruhiger bleibt. Wir klären mit Ihnen vorgängig, welche Anforderung Ihr Projekt hat. Massgebend ist, was in Ausschreibung oder Schallschutznachweis steht. Danach richten wir den Aufbau aus.</p>"},{"title":"Sondermasse und Kleinserien sind möglich","text":"<p>Nicht jede Nasszelle passt in ein Standardmass. Wir fertigen Elemente für schräge Wände, tiefe Nischen und Grundrisse mit mehreren Apparaten in einer Wand. Bei Wiederholungen, etwa bei gleichen Wohnungstypen, fertigen wir in Serie und halten die Masse über alle Elemente gleich. Fragen Sie uns an, bevor Sie eine Lösung ausschliessen.</p>"},{"title":"Lieferung und Zwischenlagerung","text":"<p>Wir liefern die Elemente termingerecht auf die Baustelle, damit Sie sie nicht wochenlang lagern müssen. Bei Verzögerungen im Bauprogramm lagern wir vorfabrizierte Elemente in Absprache zwischen. Sagen Sie uns bei der Bestellung, wie die Zufahrt und die Abladesituation aussehen. Lieferung und Abladen halten wir in der Offerte fest, damit später nichts dazukommt.</p>"}]}', 20, 1
FROM DUAL
WHERE @pid IS NOT NULL
  AND NOT EXISTS (SELECT 1 FROM sections WHERE page_id = @pid AND sort_order = 20);

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'faq', '{"heading":"Fragen und Antworten","subtitle":"","items":[{"question":"Ab welcher Menge kann ich Sanitär Vorwandelemente bestellen?","answer":"<p>Wir fertigen sowohl einzelne Elemente als auch Serien für ganze Überbauungen. Melden Sie uns Ihr Projekt, wir sagen Ihnen, was in Ihrem Fall sinnvoll ist.</p>"},{"question":"Kommen die Elemente bereits verrohrt?","answer":"<p>Ja, wir verrohren die GIS-Elemente in unserer Werkstatt fertig. Auf der Baustelle wird das Element gesetzt und angeschlossen, die Verteilarbeit ist bereits erledigt.</p>"},{"question":"Was brauchen Sie von mir für eine Offerte?","answer":"<p>Am schnellsten geht es mit den Sanitärplänen oder einer Skizze mit Massen und den gewünschten Apparaten. Nützlich sind zudem der Wandaufbau, der gewünschte Liefertermin und die Adresse der Baustelle.</p>"}]}', 30, 1
FROM DUAL
WHERE @pid IS NOT NULL
  AND NOT EXISTS (SELECT 1 FROM sections WHERE page_id = @pid AND sort_order = 30);

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'cta-banner', '{"heading":"Offerte für Vorwandelemente anfragen","body":"Senden Sie uns Ihre Sanitärpläne oder rufen Sie uns an, Sie erhalten eine Offerte mit Stückliste, Massen und Liefertermin.","button_text":"Pläne einsenden","button_url":"/kontakt"}', 40, 1
FROM DUAL
WHERE @pid IS NOT NULL
  AND NOT EXISTS (SELECT 1 FROM sections WHERE page_id = @pid AND sort_order = 40);

-- ────────────────────────────────────────────────────────────
-- /gis-elemente-beplanken
-- ────────────────────────────────────────────────────────────
INSERT INTO pages (title, slug, meta_title, meta_desc, is_active, is_homepage, sort_order)
SELECT 'GIS-Elemente beplanken', 'gis-elemente-beplanken', 'GIS Elemente beplanken | SUI Innova GmbH', 'GIS Elemente beplanken in Werkstatt und auf der Baustelle: verrohrt, beplankt, gespachtelt. Nennen Sie Stückzahl und Termin, wir rechnen Ihnen eine Offerte.', 0, 0, @next_sort + 40
FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE slug = 'gis-elemente-beplanken');

SET @pid = (SELECT id FROM pages WHERE slug = 'gis-elemente-beplanken' LIMIT 1);

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'parallax-image', '{"image_id":0,"height":"medium","overlay_text":""}', 10, 1
FROM DUAL
WHERE @pid IS NOT NULL
  AND NOT EXISTS (SELECT 1 FROM sections WHERE page_id = @pid AND sort_order = 10);

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'content-grid', '{"heading":"GIS Elemente beplanken: von der Vorfabrikation bis zur fertigen Wand","lead":"<p>Wir beplanken GIS Elemente, in unserer Werkstatt in Pfäffikon und direkt auf Ihrer Baustelle. Sie erhalten die Elemente verrohrt, beplankt und gespachtelt, bereit für Plättli, Farbe oder SilentPanel. In Nasszellen setzen wir AquaPanel ein, in trockenen Bereichen Gipsplatten nach Ihren Vorgaben. Wir arbeiten mit Sanitärfirmen, Generalunternehmen und Bauleitungen zusammen und richten uns nach Ihrem Bauprogramm. Nennen Sie uns Stückzahl, Wandaufbau und Termin, dann rechnen wir Ihnen eine Offerte. Vorfabrikation, Montage und Beplankung kommen bei uns aus einer Hand. Das spart Schnittstellen, Rückfragen und Wartezeiten auf der Baustelle.</p>","style":"light","items":[{"title":"Beplankung in der Werkstatt spart Zeit auf der Baustelle","text":"<p>Wir verrohren und beplanken die GIS Elemente vorgängig in unserer Werkstatt. Auf der Baustelle wird das Element nur noch versetzt und angeschlossen. So verkürzt sich die Zeit, in der andere Handwerker warten müssen. Transport und Anlieferung stimmen wir auf Ihren Bauablauf ab. Wie gross ein Element werden darf, klären wir anhand von Zufahrt und Abladesituation.</p>"},{"title":"AquaPanel für Nasszellen, Gipsplatten für trockene Räume","text":"<p>In Duschen, Bädern und Nasszellen beplanken wir mit AquaPanel, weil die Platte Feuchtigkeit verträgt. In trockenen Bereichen arbeiten wir mit Gipsplatten. Welche Platte wo zum Einsatz kommt, halten wir vor Baubeginn schriftlich fest. Sagen Sie uns, ob Sie Plättli, Verputz oder eine Beschichtung planen, danach richtet sich der Aufbau.</p>"},{"title":"Spachteln bis zur gewünschten Qualitätsstufe","text":"<p>Nach der Beplankung verspachteln wir Fugen, Kanten und Schraubenköpfe. Sie geben die Qualitätsstufe vor, wir liefern die Fläche entsprechend ab. Damit übernimmt der Maler oder Plattenleger eine Wand, an der er direkt weiterarbeiten kann. Welche Stufe gilt, halten wir vor Arbeitsbeginn schriftlich fest.</p>"},{"title":"Ausflockung und SilentPanel gegen Schall","text":"<p>Auf Wunsch flocken wir die Elemente aus und montieren SilentPanel. Beides reduziert die Schallübertragung von Leitungen in angrenzende Räume. Sinnvoll ist das vor allem bei Wohnungstrennwänden und bei Bädern neben Schlafzimmern. Klären Sie die Anforderung frühzeitig mit uns, denn sie beeinflusst den Wandaufbau.</p>"},{"title":"Ein Ansprechpartner für Vorfabrikation, Montage und Beplankung","text":"<p>Sie beauftragen eine Firma statt drei. Wir montieren die Elemente selbst und beplanken sie anschliessend, deshalb gibt es keine Diskussion über Vorleistungen. Bei Änderungen auf der Baustelle passen wir die Elemente an. Den Stand melden wir Ihnen laufend, damit Ihre Terminplanung hält.</p>"},{"title":"So läuft ein Auftrag ab","text":"<p>Sie senden uns Pläne, Stückzahlen und den gewünschten Termin. Wir prüfen die Unterlagen und stellen Ihnen eine Offerte mit Positionen und Preisen zu. Nach der Freigabe fixieren wir die Produktions- und Montagetermine. Zum Schluss übergeben wir die beplankten Wände und melden Ihnen, was noch offen ist.</p>"}]}', 20, 1
FROM DUAL
WHERE @pid IS NOT NULL
  AND NOT EXISTS (SELECT 1 FROM sections WHERE page_id = @pid AND sort_order = 20);

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'faq', '{"heading":"Fragen und Antworten","subtitle":"","items":[{"question":"Beplanken Sie auch GIS Elemente, die wir selbst montiert haben?","answer":"<p>Ja, wir übernehmen die Beplankung auch dann, wenn Vorfabrikation und Montage bei Ihnen liegen. Wir prüfen vor dem Start, ob die Elemente ausgerichtet und die Leitungen abgedrückt sind. Mängel melden wir Ihnen schriftlich, bevor wir die Platten setzen.</p>"},{"question":"Welche Platten verwenden Sie in Nasszellen?","answer":"<p>In Nasszellen und Feuchträumen beplanken wir mit AquaPanel. Für trockene Bereiche kommen Gipsplatten zum Einsatz. Weichen Ihre Vorgaben davon ab, halten wir uns an Ihr Devis.</p>"},{"question":"Wie schnell können Sie mit der Beplankung beginnen?","answer":"<p>Das hängt von der aktuellen Auslastung und der Stückzahl ab. Melden Sie sich mit Ihrem Bauprogramm, dann nennen wir Ihnen einen verbindlichen Termin.</p>"}]}', 30, 1
FROM DUAL
WHERE @pid IS NOT NULL
  AND NOT EXISTS (SELECT 1 FROM sections WHERE page_id = @pid AND sort_order = 30);

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'cta-banner', '{"heading":"Offerte für die Beplankung anfragen","body":"Senden Sie uns Pläne, Stückzahl und Wunschtermin, Sie erhalten von uns eine Offerte mit Positionen und Preisen.","button_text":"Pläne einsenden","button_url":"/kontakt"}', 40, 1
FROM DUAL
WHERE @pid IS NOT NULL
  AND NOT EXISTS (SELECT 1 FROM sections WHERE page_id = @pid AND sort_order = 40);

-- ────────────────────────────────────────────────────────────
-- /sanitaer-vorwandelemente-beplanken
-- ────────────────────────────────────────────────────────────
INSERT INTO pages (title, slug, meta_title, meta_desc, is_active, is_homepage, sort_order)
SELECT 'Vorwandelemente beplanken', 'sanitaer-vorwandelemente-beplanken', 'Sanitär Vorwandelemente beplanken | SUI Innova', 'Sanitär Vorwandelemente beplanken: SUI Innova beplankt GIS-Elemente mit AquaPanel oder Gipsplatten, inklusive Spachtelung. Projekt anfragen und Termin klären.', 0, 0, @next_sort + 50
FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE slug = 'sanitaer-vorwandelemente-beplanken');

SET @pid = (SELECT id FROM pages WHERE slug = 'sanitaer-vorwandelemente-beplanken' LIMIT 1);

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'parallax-image', '{"image_id":0,"height":"medium","overlay_text":""}', 10, 1
FROM DUAL
WHERE @pid IS NOT NULL
  AND NOT EXISTS (SELECT 1 FROM sections WHERE page_id = @pid AND sort_order = 10);

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'content-grid', '{"heading":"Sanitär Vorwandelemente beplanken: von der Montage bis zur spachtelfertigen Wand","lead":"<p>Sanitär Vorwandelemente beplanken heisst: Das verrohrte GIS-Element bekommt seine Hülle, und die Wand ist bereit für Platten oder Farbe. Wir übernehmen diesen Schritt auf Ihrer Baustelle, im Neubau wie im Umbau. Dazu gehört die Plattenwahl je nach Raum, der Zuschnitt um Rohrdurchführungen und Revisionsöffnungen, die Befestigung im vorgegebenen Raster und auf Wunsch die Spachtelung. In Nasszellen setzen wir AquaPanel ein, in trockenen Bereichen die passende Gipsplatte. Wir kommen auch dann, wenn die Elemente von einem anderen Betrieb gesetzt wurden. Sie erhalten eine Offerte mit Angaben zu Fläche, Plattentyp und Termin, damit Sie Ihre Folgegewerke planen können. Rufen Sie uns an oder schicken Sie uns Ihre Pläne.</p>","style":"light","items":[{"title":"Die Plattenwahl entscheidet über die Lebensdauer der Nasszelle","text":"<p>In Duschen, Bädern und WC-Anlagen beplanken wir mit AquaPanel. Die Platte nimmt kaum Wasser auf und bleibt auch bei dauernder Feuchte formstabil. In angrenzenden Trockenbereichen genügt in der Regel eine Gipsplatte, was Material und Kosten spart. Welche Kombination sinnvoll ist, klären wir vorgängig anhand Ihrer Pläne.</p>"},{"title":"Wir beplanken auch Elemente, die wir nicht gesetzt haben","text":"<p>Viele Anfragen erreichen uns mitten im Bauablauf, wenn die Sanitärinstallation steht und der Trockenbau stockt. Wir prüfen die gesetzten GIS-Elemente auf Fluchten, Befestigung und Rohrlage, bevor wir die erste Platte anschrauben. Abweichungen melden wir Ihnen, statt sie zuzudecken. So vermeiden Sie Nacharbeiten, wenn später die Sanitärapparate montiert werden.</p>"},{"title":"Revisionsöffnungen und Durchführungen werden vor dem Zuschnitt festgelegt","text":"<p>Spülkästen, Absperrventile und Verteiler brauchen dauerhaft Zugang. Wir markieren die Öffnungen anhand der Sanitärpläne und schneiden sie sauber aus, statt nachträglich zu stemmen. Rohrdurchführungen werden dicht und passgenau ausgeführt. Damit bleibt die Wand geschlossen und der Unterhalt trotzdem möglich.</p>"},{"title":"Beplankung und Spachtelung aus einer Hand sparen eine Schnittstelle","text":"<p>Auf Wunsch spachteln wir die beplankten Flächen bis zum vereinbarten Qualitätsniveau. Sie koordinieren dann einen Betrieb weniger und haben eine Ansprechperson für das Ergebnis. Das Niveau der Spachtelung halten wir in der Offerte fest, damit Maler oder Plattenleger wissen, was sie übernehmen.</p>"},{"title":"Ausflockung und SilentPanel für ruhigere Nasszellen","text":"<p>Wo Schallschutz gefragt ist, kombinieren wir die Beplankung mit Ausflockung oder SilentPanel. Der Hohlraum hinter der Vorwand wird gefüllt, bevor die zweite Plattenlage geschlossen wird. Das dämpft Spül- und Fliessgeräusche spürbar, besonders bei Wänden zu Schlaf- und Wohnräumen. Diese Massnahme muss vor der Beplankung entschieden werden.</p>"},{"title":"So läuft eine Anfrage bei uns ab","text":"<p>Sie senden uns Grundrisse, Sanitärpläne und den gewünschten Termin. Wir schätzen die Fläche, legen Plattentyp und Aufbau fest und stellen Ihnen eine Offerte zu. Nach Ihrer Freigabe reservieren wir das Zeitfenster und stimmen die Anlieferung mit der Bauleitung ab.</p>"}]}', 20, 1
FROM DUAL
WHERE @pid IS NOT NULL
  AND NOT EXISTS (SELECT 1 FROM sections WHERE page_id = @pid AND sort_order = 20);

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'faq', '{"heading":"Fragen und Antworten","subtitle":"","items":[{"question":"Womit werden Sanitär Vorwandelemente in Nasszellen beplankt?","answer":"<p>In Duschen und Bädern verwenden wir AquaPanel, weil die Platte auf Feuchtigkeit unempfindlich reagiert. In trockenen Zonen derselben Wohnung setzen wir Gipsplatten ein. Die Abgrenzung legen wir vor Arbeitsbeginn anhand Ihrer Pläne fest.</p>"},{"question":"Beplanken Sie auch Elemente, die ein anderer Betrieb montiert hat?","answer":"<p>Ja, das ist ein grosser Teil unserer Arbeit. Wir prüfen vorgängig Fluchten, Befestigung und Rohrlage und melden Ihnen allfällige Abweichungen. Erst danach beginnen wir mit der Beplankung.</p>"},{"question":"Übernehmen Sie auch die Spachtelung nach der Beplankung?","answer":"<p>Ja, Beplankung und Spachtelung erhalten Sie bei uns zusammen. Das vereinbarte Niveau halten wir in der Offerte fest, damit Maler und Plattenleger sauber anschliessen können.</p>"}]}', 30, 1
FROM DUAL
WHERE @pid IS NOT NULL
  AND NOT EXISTS (SELECT 1 FROM sections WHERE page_id = @pid AND sort_order = 30);

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'cta-banner', '{"heading":"Beplankung anfragen","body":"Senden Sie uns Ihre Sanitärpläne und den Wunschtermin, wir melden uns mit einer Offerte zu Fläche, Plattentyp und Zeitfenster.","button_text":"Pläne einsenden","button_url":"/kontakt"}', 40, 1
FROM DUAL
WHERE @pid IS NOT NULL
  AND NOT EXISTS (SELECT 1 FROM sections WHERE page_id = @pid AND sort_order = 40);

-- ────────────────────────────────────────────────────────────
-- Kontrolle
-- ────────────────────────────────────────────────────────────
-- SELECT slug, is_active, sort_order FROM pages ORDER BY sort_order;
-- SELECT p.slug, COUNT(s.id) AS sektionen FROM pages p
--   LEFT JOIN sections s ON s.page_id = p.id GROUP BY p.slug;


-- ════════════════════════════════════════════════════════════
-- D) SEITEN AUF DEN AKTUELLEN AUFBAU BRINGEN
-- ════════════════════════════════════════════════════════════

-- ────────────────────────────────────────────────────────────
-- /sanitaer-vorwandelemente
-- ────────────────────────────────────────────────────────────
SET @pid = (SELECT id FROM pages WHERE slug = 'sanitaer-vorwandelemente' LIMIT 1);

-- Gewaehltes Kopfbild merken, bevor die Sektionen fallen
SET @img = (
    SELECT JSON_UNQUOTE(JSON_EXTRACT(content, '$.image_id'))
    FROM sections
    WHERE page_id = @pid AND type = 'parallax-image' AND JSON_VALID(content)
    ORDER BY sort_order ASC LIMIT 1
);

DELETE FROM sections WHERE page_id = @pid AND @pid IS NOT NULL;

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid,
       'parallax-image',
       JSON_SET('{"image_id":0,"height":"medium","overlay_text":""}', '$.image_id', CAST(COALESCE(@img, 0) AS UNSIGNED)),
       10, 1
FROM DUAL WHERE @pid IS NOT NULL;

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'content-grid', '{"heading":"Sanitär Vorwandelemente: Aufbau, Montage und Beplankung erklärt","lead":"<p>Sanitär Vorwandelemente tragen WC, Waschtisch, Dusche oder Urinal und nehmen Zu- und Ablaufleitungen auf, ohne dass jemand die Rohre sieht. Sie bestehen aus einem verzinkten Stahlrahmen, der am Boden und an der Rohbauwand verschraubt wird, und werden anschliessend beplankt und gespachtelt. Auf dieser Seite lesen Sie, wie ein solches Element aufgebaut ist, welche Masse üblich sind, warum die Beplankung im Nassbereich eine eigene Rolle spielt und wo im Bauablauf die Schallentkopplung entschieden wird. SUI Innova aus Pfäffikon fertigt GIS-Elemente in der eigenen Werkstatt fix und fertig verrohrt vor, montiert sie auf der Baustelle und übernimmt Beplankung, Spachtelung und Ausflockung. Sie erhalten die Wand also nicht in Teilen, sondern als eine Leistung.</p>","style":"light","items":[{"title":"Ein Vorwandelement ist Tragwerk und Installationsraum zugleich","text":"<p>Das Element nimmt die Lasten von WC, Waschtisch oder Stützgriffen auf und leitet sie in Boden und Rohbauwand ab. Gleichzeitig läuft im Innenraum alles, was nicht sichtbar sein soll: Kalt- und Warmwasser, Abwasser, teilweise Elektro. Deshalb wird die Position jeder Leitung festgelegt, bevor die erste Platte montiert wird. Fehler in dieser Phase kosten später Aufbruch und Zeit.</p>"},{"title":"Vorfabrikation verlagert die knifflige Arbeit von der Baustelle in die Werkstatt","text":"<p>In der Werkstatt lassen sich Elemente auf dem Tisch verrohren, ausrichten und prüfen. Auf der Baustelle wird das fertige Element nur noch gestellt, befestigt und angeschlossen. Das verkürzt die Zeit, in der andere Gewerke warten müssen, und reduziert Anpassungen vor Ort. SUI Innova liefert GIS-Elemente fix und fertig verrohrt aus der eigenen Werkstatt an.</p>"},{"title":"Masse und Höhen ergeben sich aus dem Apparat, nicht aus dem Gefühl","text":"<p>Übliche Bauhöhen sind das halbhohe Element für die freistehende Vorwand und das raumhohe Element bis zur Decke. Die Fertighöhe der WC-Keramik und die Lage der Spülkasten-Betätigung richten sich nach Herstellerangaben und nach der geplanten Bodenaufbauhöhe. Wird der Bodenaufbau später geändert, stimmt die Höhe nicht mehr. Klären Sie die Aufbauhöhe deshalb vorgängig mit Architektur und Plattenleger. Welche Höhe und welches System für Ihre Nasszelle passen, legen wir anhand der Pläne und der gewählten Apparate fest.</p>"},{"title":"Im Nassbereich entscheidet die Beplankung über die Lebensdauer","text":"<p>Hinter Dusche und Badewanne gehört eine Platte, die Feuchtigkeit verträgt. AquaPanel wird in Feuchträumen und Nasszellen eingesetzt und bildet den Untergrund für Abdichtung und Plättli. Die Fugen und Anschlüsse werden gespachtelt, damit die Fläche ohne Absatz weitergeht. SUI Innova übernimmt Beplankung und Spachtelung im gleichen Auftrag wie die Montage.</p>"},{"title":"Schall wird an der Befestigung entschieden, nicht am Rohr","text":"<p>Spülgeräusche wandern über Körperschall in angrenzende Räume, wenn Element und Rohre starr mit der Rohbauwand verbunden sind. Entkoppelte Befestigungen, Schallschutzsets und eine Ausflockung des Hohlraums dämpfen diesen Weg. Besonders wichtig ist das bei Wänden zu Schlafräumen und in Mehrfamilienhäusern. Welche Anforderung für Ihr Projekt gilt, steht im Schallschutznachweis. Nennen Sie uns die Vorgabe, wir richten den Aufbau danach aus.</p>"},{"title":"Von der Planung bis zur spachtelfertigen Wand aus einer Hand","text":"<p>Sie schicken uns Pläne oder Schemas, wir klären die Apparatepositionen und fertigen die Elemente vor. Danach montieren wir auf der Baustelle, beplanken und spachteln. Sie haben eine Ansprechperson für Vorfabrikation, Montage und Beplankung statt drei Schnittstellen. Was das für Ihr Projekt konkret heisst, klären wir am besten anhand Ihrer Unterlagen.</p>"}]}', 20, 1
FROM DUAL WHERE @pid IS NOT NULL;

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'faq', '{"heading":"Fragen und Antworten","subtitle":"","items":[{"question":"Wie tief ist eine Sanitärvorwand üblicherweise?","answer":"<p>Die Tiefe richtet sich nach dem Spülkasten und den Leitungen dahinter. Für ein WC-Element rechnet man mit rund 15 bis 20 Zentimetern Rahmentiefe plus Beplankung. Bei zusätzlichen Steigleitungen oder Lüftungen wird die Vorwand entsprechend tiefer.</p>"},{"question":"Kann ich später etwas an der Wand befestigen?","answer":"<p>Nur dort, wo Traversen oder Verstärkungen eingebaut sind. Spiegelschrank, Handtuchhalter oder Stützgriffe sollten Sie deshalb vor der Beplankung anmelden. Nachträglich befestigt man in einer beplankten Vorwand nur leichte Lasten.</p>"},{"question":"Wer koordiniert Sanitär, Trockenbau und Plattenleger?","answer":"<p>Bei getrennten Aufträgen liegt die Koordination bei der Bauleitung. Wenn Vorfabrikation, Montage und Beplankung in einer Hand liegen, entfällt ein Teil dieser Abstimmung. SUI Innova übergibt die Wand spachtelfertig an das Folgegewerk.</p>"}]}', 30, 1
FROM DUAL WHERE @pid IS NOT NULL;

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'cta-banner', '{"heading":"Pläne einsenden, Offerte erhalten","body":"Senden Sie uns Ihre Pläne, wir melden uns mit Rückfragen zu Apparatepositionen und einer Offerte für Vorfabrikation, Montage und Beplankung.","button_text":"Pläne einsenden","button_url":"/kontakt"}', 40, 1
FROM DUAL WHERE @pid IS NOT NULL;

-- ────────────────────────────────────────────────────────────
-- /sanitaer-vorwaende
-- ────────────────────────────────────────────────────────────
SET @pid = (SELECT id FROM pages WHERE slug = 'sanitaer-vorwaende' LIMIT 1);

-- Gewaehltes Kopfbild merken, bevor die Sektionen fallen
SET @img = (
    SELECT JSON_UNQUOTE(JSON_EXTRACT(content, '$.image_id'))
    FROM sections
    WHERE page_id = @pid AND type = 'parallax-image' AND JSON_VALID(content)
    ORDER BY sort_order ASC LIMIT 1
);

DELETE FROM sections WHERE page_id = @pid AND @pid IS NOT NULL;

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid,
       'parallax-image',
       JSON_SET('{"image_id":0,"height":"medium","overlay_text":""}', '$.image_id', CAST(COALESCE(@img, 0) AS UNSIGNED)),
       10, 1
FROM DUAL WHERE @pid IS NOT NULL;

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'content-grid', '{"heading":"Sanitär Vorwände: vorfabriziert, montiert, beplankt","lead":"<p>Sanitär Vorwände liefern wir fix und fertig verrohrt auf Ihre Baustelle. In unserer Werkstatt in Pfäffikon bauen wir GIS-Elemente auf Mass zusammen, montieren sie vor Ort und beplanken sie bis zur spachtelfertigen Wand. So verlagern Sie einen grossen Teil der Sanitärinstallation von der Baustelle in die Halle: weniger Schnittstellen, weniger Wartezeit für die Folgegewerke, planbare Abläufe. Sie erhalten Vorfabrikation, Montage und Beplankung aus einer Hand und haben einen Ansprechpartner für den ganzen Ablauf. Für Nasszellen und Feuchträume setzen wir AquaPanel ein, für Schallschutzanforderungen SilentPanel und Ausflockung. Senden Sie uns Ihre Pläne mit der Adresse der Baustelle, wir prüfen sie und melden uns mit einer Offerte.</p>","style":"light","items":[{"title":"GIS-Elemente verlassen unsere Werkstatt fertig verrohrt","text":"<p>Wir konfektionieren die Vorwandelemente nach Ihren Plänen und verrohren sie komplett. Auf der Baustelle wird das Element gesetzt und angeschlossen, nicht mehr zusammengebaut. Das verkürzt die Zeit im Rohbau und senkt das Risiko von Fehlern in engen Platzverhältnissen. Änderungen klären wir vorgängig am Plan, nicht improvisiert vor Ort.</p>"},{"title":"Montage und Beplankung kommen vom gleichen Team","text":"<p>Unsere Monteure setzen die Vorwände auf Ihrer Baustelle und richten sie aus. Anschliessend beplanken wir die Wände und spachteln sie, sodass der Maler oder Plattenleger direkt weiterarbeiten kann. Weil Vorfabrikation und Montage im gleichen Haus liegen, entfällt die Abstimmung zwischen mehreren Firmen. Bei Terminverschiebungen reagieren wir mit Ihnen zusammen auf den aktuellen Bauablauf.</p>"},{"title":"AquaPanel für Nasszellen, SilentPanel gegen Schall","text":"<p>In Bädern und Duschen beplanken wir mit AquaPanel, das für dauerhafte Feuchtebelastung ausgelegt ist. Wo Schallschutz gefordert ist, arbeiten wir mit SilentPanel und Ausflockung der Hohlräume. Welche Kombination sinnvoll ist, hängt von der Nutzung und den Anforderungen im Bauprojekt ab. Sagen Sie uns, welche Werte gefordert sind, wir schlagen den Aufbau vor.</p>"},{"title":"Für Neubau, Umbau und Sanierung im Wohnungsbau","text":"<p>Wir arbeiten für Sanitärinstallateure, Generalunternehmen und Bauherrschaften. Bei Mehrfamilienhäusern fertigen wir gleiche Elemente in Serie, bei Umbauten passen wir jedes Element an den Bestand an. Für Sanierungen im bewohnten Objekt kürzt die Vorfabrikation die Zeit, in der das Bad nicht nutzbar ist. Ausgeführte Arbeiten sehen Sie unter <a href=\\"/referenzen\\">Referenzen</a>.</p>"},{"title":"So läuft eine Anfrage ab","text":"<p>Sie senden uns Grundrisse und Sanitärpläne. Wir prüfen die Unterlagen, klären offene Punkte mit Ihnen und stellen eine Offerte mit Positionen und Terminen. Nach Ihrer Freigabe fertigen wir die Elemente und vereinbaren den Montagetermin. Sie erhalten von uns eine Ansprechperson, die das Projekt bis zur fertigen Wand begleitet.</p>"}]}', 20, 1
FROM DUAL WHERE @pid IS NOT NULL;

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'faq', '{"heading":"Fragen und Antworten","subtitle":"","items":[{"question":"Was ist eine Sanitär Vorwand?","answer":"<p>Eine Sanitär Vorwand ist eine vorgesetzte Ständerkonstruktion, in der Zuleitungen, Abläufe und Befestigungen für WC, Waschtisch oder Dusche liegen. Sie wird vor die Rohbauwand gestellt und danach beplankt. Sichtbar bleibt später nur die fertige Wandfläche.</p>"},{"question":"Was ist der Vorteil von vorfabrizierten Vorwänden gegenüber dem Bau auf der Baustelle?","answer":"<p>Die Elemente entstehen in der Werkstatt unter gleichbleibenden Bedingungen und kommen fertig verrohrt auf die Baustelle. Vor Ort bleibt das Setzen und Anschliessen, das verkürzt die Bauzeit und reduziert Nacharbeiten. Zudem koordinieren Sie weniger Beteiligte.</p>"},{"question":"Übernehmen Sie auch die Beplankung und Spachtelung?","answer":"<p>Ja, wir beplanken die montierten Vorwände und spachteln sie auf Wunsch fertig. In Feuchträumen setzen wir AquaPanel ein. Damit übergeben wir eine Wand, an der das nächste Gewerk direkt weiterarbeiten kann.</p>"}]}', 30, 1
FROM DUAL WHERE @pid IS NOT NULL;

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'cta-banner', '{"heading":"Pläne einsenden und Offerte anfragen","body":"Senden Sie uns Ihre Sanitär- und Grundrisspläne, wir prüfen sie und schicken Ihnen eine Offerte mit Terminen.","button_text":"Pläne einsenden","button_url":"/kontakt"}', 40, 1
FROM DUAL WHERE @pid IS NOT NULL;

-- ────────────────────────────────────────────────────────────
-- /sanitaer-gis-elemente-bestellen
-- ────────────────────────────────────────────────────────────
SET @pid = (SELECT id FROM pages WHERE slug = 'sanitaer-gis-elemente-bestellen' LIMIT 1);

-- Gewaehltes Kopfbild merken, bevor die Sektionen fallen
SET @img = (
    SELECT JSON_UNQUOTE(JSON_EXTRACT(content, '$.image_id'))
    FROM sections
    WHERE page_id = @pid AND type = 'parallax-image' AND JSON_VALID(content)
    ORDER BY sort_order ASC LIMIT 1
);

DELETE FROM sections WHERE page_id = @pid AND @pid IS NOT NULL;

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid,
       'parallax-image',
       JSON_SET('{"image_id":0,"height":"medium","overlay_text":""}', '$.image_id', CAST(COALESCE(@img, 0) AS UNSIGNED)),
       10, 1
FROM DUAL WHERE @pid IS NOT NULL;

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'content-grid', '{"heading":"Sanitär GIS Elemente bestellen bei SUI Innova","lead":"<p>Sie wollen Sanitär GIS Elemente bestellen, die auf der Baustelle nur noch gestellt und angeschlossen werden müssen. Genau das liefern wir. In unserer Werkstatt in Pfäffikon bauen wir GIS Elemente nach Ihren Plänen auf, verrohren sie fix und fertig und bereiten sie für den Transport vor. Auf Wunsch übernehmen wir auch Montage, Beplankung mit AquaPanel, Spachtelung und Ausflockung mit SilentPanel. Sie erhalten alles aus einer Hand und haben eine Ansprechperson für den ganzen Ablauf. Schicken Sie uns Ihre Sanitärpläne oder eine Skizze mit Apparateliste. Wir prüfen die Unterlagen, melden uns bei offenen Punkten und erstellen Ihnen eine Offerte mit Preis und möglichem Liefertermin.</p>","style":"light","items":[{"title":"So läuft die Bestellung ab","text":"<p>Sie senden uns Ihre Sanitärpläne, die Apparateliste und den gewünschten Liefertermin. Wir prüfen die Unterlagen und klären offene Punkte direkt mit Ihnen oder mit dem Planer. Danach erhalten Sie eine Offerte mit Positionen, Preis und Terminvorschlag. Nach Ihrer Freigabe starten wir die Vorfabrikation in der Werkstatt.</p>"},{"title":"Fix und fertig verrohrt aus der Werkstatt","text":"<p>Wir bauen die GIS Elemente auf und verrohren sie komplett, bevor sie die Werkstatt verlassen. Dadurch verschieben Sie Arbeitsstunden von der Baustelle in eine Umgebung mit festen Arbeitsplätzen und Material zur Hand. Auf der Baustelle bleibt das Stellen, Fixieren und Anschliessen. Das verkürzt die Zeit, in der andere Gewerke warten müssen.</p>"},{"title":"Was Sie zusätzlich zum Element bestellen können","text":"<p>Viele Kunden bestellen nicht nur das nackte Element. Wir montieren die Elemente direkt auf Ihrer Baustelle, beplanken sie mit AquaPanel für Feuchträume und Nasszellen und spachteln die Flächen. Für den Schallschutz flocken wir die Vorwand mit SilentPanel aus. Sie entscheiden, wo unsere Arbeit endet und Ihre beginnt.</p>"},{"title":"Angaben, die wir für eine Offerte brauchen","text":"<p>Für eine belastbare Offerte brauchen wir den Sanitärplan oder eine bemasste Skizze, die Anzahl und Art der Apparate und die Höhen der Vorwand. Nützlich sind zudem Angaben zum Wandaufbau, zur gewünschten Beplankung und zu Anforderungen an den Schallschutz. Nennen Sie uns auch die Zufahrt und die Etage, das beeinflusst Anlieferung und Handling. Fehlt etwas, fragen wir nach, bevor wir rechnen.</p>"},{"title":"Für Sanitärunternehmen, Generalunternehmer und Bauherren","text":"<p>Wir arbeiten für Sanitärbetriebe, die Kapazität in der Werkstatt brauchen, und für Bauleitungen, die einen fixen Liefertermin wollen. Kleine Umbauten mit einem einzelnen Element sind ebenso möglich wie Serien für ganze Geschosse. Sagen Sie uns, wie viele Elemente Sie brauchen und bis wann. Wir sagen Ihnen ehrlich, ob wir den Termin halten können.</p>"},{"title":"Lieferung und Termine","text":"<p>Die Elemente werden montagefertig angeliefert und nach Absprache abgeladen. Den Liefertermin halten wir in der Offerte fest, damit Ihre Bauleitung damit planen kann. Verschiebt sich Ihr Bauprogramm, melden Sie sich frühzeitig, dann suchen wir einen neuen Termin. Wie schnell wir fertigen können, hängt von Stückzahl und Auslastung ab. Fragen Sie früh an, dann sagen wir Ihnen verbindlich, was möglich ist.</p>"}]}', 20, 1
FROM DUAL WHERE @pid IS NOT NULL;

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'faq', '{"heading":"Fragen und Antworten","subtitle":"","items":[{"question":"Kann ich einzelne GIS Elemente bestellen oder nur ganze Serien?","answer":"<p>Beides ist möglich. Wir fertigen einzelne Elemente für Umbauten ebenso wie Serien für Neubauten. Nennen Sie uns die Stückzahl bei der Anfrage.</p>"},{"question":"Muss ich das Material selber liefern?","answer":"<p>Das klären wir vor der Offerte, je nach Projekt und Verfügbarkeit. Sagen Sie uns bei der Anfrage, ob Sie Material beistellen möchten, dann rechnen wir die Offerte entsprechend.</p>"},{"question":"Übernehmen Sie auch die Montage auf der Baustelle?","answer":"<p>Ja, wir montieren die Elemente direkt auf Ihrer Baustelle. Auf Wunsch beplanken und spachteln wir die Wand anschliessend. Sie bestellen also nur die Vorfabrikation oder den ganzen Ablauf bis zur fertigen Wand.</p>"}]}', 30, 1
FROM DUAL WHERE @pid IS NOT NULL;

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'cta-banner', '{"heading":"GIS Elemente anfragen","body":"Senden Sie uns Ihre Sanitärpläne über das Kontaktformular, wir melden uns mit Rückfragen und einer Offerte samt Terminvorschlag.","button_text":"Pläne einsenden","button_url":"/kontakt"}', 40, 1
FROM DUAL WHERE @pid IS NOT NULL;

-- ────────────────────────────────────────────────────────────
-- /sanitaer-vorwandelemente-bestellen
-- ────────────────────────────────────────────────────────────
SET @pid = (SELECT id FROM pages WHERE slug = 'sanitaer-vorwandelemente-bestellen' LIMIT 1);

-- Gewaehltes Kopfbild merken, bevor die Sektionen fallen
SET @img = (
    SELECT JSON_UNQUOTE(JSON_EXTRACT(content, '$.image_id'))
    FROM sections
    WHERE page_id = @pid AND type = 'parallax-image' AND JSON_VALID(content)
    ORDER BY sort_order ASC LIMIT 1
);

DELETE FROM sections WHERE page_id = @pid AND @pid IS NOT NULL;

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid,
       'parallax-image',
       JSON_SET('{"image_id":0,"height":"medium","overlay_text":""}', '$.image_id', CAST(COALESCE(@img, 0) AS UNSIGNED)),
       10, 1
FROM DUAL WHERE @pid IS NOT NULL;

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'content-grid', '{"heading":"Sanitär Vorwandelemente bestellen: vorfabriziert aus Pfäffikon","lead":"<p>Sie können bei SUI Innova Sanitär Vorwandelemente bestellen, die bereits verrohrt aus unserer Werkstatt kommen. Wir fertigen GIS-Elemente nach Ihren Plänen vor, prüfen die Leitungsführung im Voraus und liefern die Elemente auf die Baustelle. Auf Wunsch übernehmen wir auch die Montage, die Beplankung mit AquaPanel und die Spachtelung, bis die Wand fertig ist. Für Sie heisst das: weniger Schnittstellen, weniger Nacharbeit, ein Ansprechpartner für Vorfabrikation und Einbau. Wir arbeiten für Sanitärbetriebe, Generalunternehmen und Bauherrschaften in der Region Pfäffikon und darüber hinaus. Sagen Sie uns, welche Apparate, welche Wandtypen und welchen Liefertermin Sie brauchen. Sie erhalten eine Offerte mit Positionen, Massen und Liefertermin, damit Sie die Kosten Ihres Projekts sauber rechnen können.</p>","style":"light","items":[{"title":"Was Sie bei uns bestellen: GIS-Elemente, fertig verrohrt","text":"<p>Wir bauen die Vorwandelemente in unserer Werkstatt auf, montieren die Sanitärapparate-Träger und verrohren sie komplett. Auf der Baustelle wird das Element nur noch gesetzt und angeschlossen. Das verkürzt die Zeit auf dem Bau und verlagert die Präzisionsarbeit in eine trockene, eingerichtete Werkstatt. Sie bestellen einzelne Elemente oder ganze Geschosse. Welches System zum Einsatz kommt, richtet sich nach Ihrer Ausschreibung. Nennen Sie es uns bei der Anfrage.</p>"},{"title":"So läuft die Bestellung ab, Schritt für Schritt","text":"<p>Sie senden uns die Sanitärpläne oder eine Skizze mit den gewünschten Apparaten. Wir prüfen Masse, Wandaufbau und Leitungsführung und melden uns bei Unklarheiten vorgängig. Danach erhalten Sie eine Offerte mit Stückliste und Liefertermin. Nach Ihrer Freigabe fertigen wir vor und liefern die Elemente auf die Baustelle. Den Vorlauf zwischen Freigabe und Lieferung halten wir in der Offerte fest, damit Ihre Bauleitung damit planen kann.</p>"},{"title":"Montage und Beplankung dazubestellen statt koordinieren","text":"<p>Sie können die Elemente ab Werkstatt beziehen oder die Montage gleich mitbestellen. Unser Team setzt die Elemente auf Ihrer Baustelle, richtet sie aus und befestigt sie. Anschliessend beplanken wir mit AquaPanel für Feuchträume und Nasszellen und spachteln die Flächen. So übergeben wir Ihnen die Wand malerfertig.</p>"},{"title":"Schallschutz und Ausflockung für Nasszellen","text":"<p>Wasserleitungen und Spülungen übertragen Geräusche in angrenzende Räume. Wir flocken die Vorwandelemente aus und arbeiten mit SilentPanel, damit die Wand ruhiger bleibt. Wir klären mit Ihnen vorgängig, welche Anforderung Ihr Projekt hat. Massgebend ist, was in Ausschreibung oder Schallschutznachweis steht. Danach richten wir den Aufbau aus.</p>"},{"title":"Sondermasse und Kleinserien sind möglich","text":"<p>Nicht jede Nasszelle passt in ein Standardmass. Wir fertigen Elemente für schräge Wände, tiefe Nischen und Grundrisse mit mehreren Apparaten in einer Wand. Bei Wiederholungen, etwa bei gleichen Wohnungstypen, fertigen wir in Serie und halten die Masse über alle Elemente gleich. Fragen Sie uns an, bevor Sie eine Lösung ausschliessen.</p>"},{"title":"Lieferung und Zwischenlagerung","text":"<p>Wir liefern die Elemente termingerecht auf die Baustelle, damit Sie sie nicht wochenlang lagern müssen. Bei Verzögerungen im Bauprogramm lagern wir vorfabrizierte Elemente in Absprache zwischen. Sagen Sie uns bei der Bestellung, wie die Zufahrt und die Abladesituation aussehen. Lieferung und Abladen halten wir in der Offerte fest, damit später nichts dazukommt.</p>"}]}', 20, 1
FROM DUAL WHERE @pid IS NOT NULL;

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'faq', '{"heading":"Fragen und Antworten","subtitle":"","items":[{"question":"Ab welcher Menge kann ich Sanitär Vorwandelemente bestellen?","answer":"<p>Wir fertigen sowohl einzelne Elemente als auch Serien für ganze Überbauungen. Melden Sie uns Ihr Projekt, wir sagen Ihnen, was in Ihrem Fall sinnvoll ist.</p>"},{"question":"Kommen die Elemente bereits verrohrt?","answer":"<p>Ja, wir verrohren die GIS-Elemente in unserer Werkstatt fertig. Auf der Baustelle wird das Element gesetzt und angeschlossen, die Verteilarbeit ist bereits erledigt.</p>"},{"question":"Was brauchen Sie von mir für eine Offerte?","answer":"<p>Am schnellsten geht es mit den Sanitärplänen oder einer Skizze mit Massen und den gewünschten Apparaten. Nützlich sind zudem der Wandaufbau, der gewünschte Liefertermin und die Adresse der Baustelle.</p>"}]}', 30, 1
FROM DUAL WHERE @pid IS NOT NULL;

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'cta-banner', '{"heading":"Offerte für Vorwandelemente anfragen","body":"Senden Sie uns Ihre Sanitärpläne oder rufen Sie uns an, Sie erhalten eine Offerte mit Stückliste, Massen und Liefertermin.","button_text":"Pläne einsenden","button_url":"/kontakt"}', 40, 1
FROM DUAL WHERE @pid IS NOT NULL;

-- ────────────────────────────────────────────────────────────
-- /gis-elemente-beplanken
-- ────────────────────────────────────────────────────────────
SET @pid = (SELECT id FROM pages WHERE slug = 'gis-elemente-beplanken' LIMIT 1);

-- Gewaehltes Kopfbild merken, bevor die Sektionen fallen
SET @img = (
    SELECT JSON_UNQUOTE(JSON_EXTRACT(content, '$.image_id'))
    FROM sections
    WHERE page_id = @pid AND type = 'parallax-image' AND JSON_VALID(content)
    ORDER BY sort_order ASC LIMIT 1
);

DELETE FROM sections WHERE page_id = @pid AND @pid IS NOT NULL;

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid,
       'parallax-image',
       JSON_SET('{"image_id":0,"height":"medium","overlay_text":""}', '$.image_id', CAST(COALESCE(@img, 0) AS UNSIGNED)),
       10, 1
FROM DUAL WHERE @pid IS NOT NULL;

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'content-grid', '{"heading":"GIS Elemente beplanken: von der Vorfabrikation bis zur fertigen Wand","lead":"<p>Wir beplanken GIS Elemente, in unserer Werkstatt in Pfäffikon und direkt auf Ihrer Baustelle. Sie erhalten die Elemente verrohrt, beplankt und gespachtelt, bereit für Plättli, Farbe oder SilentPanel. In Nasszellen setzen wir AquaPanel ein, in trockenen Bereichen Gipsplatten nach Ihren Vorgaben. Wir arbeiten mit Sanitärfirmen, Generalunternehmen und Bauleitungen zusammen und richten uns nach Ihrem Bauprogramm. Nennen Sie uns Stückzahl, Wandaufbau und Termin, dann rechnen wir Ihnen eine Offerte. Vorfabrikation, Montage und Beplankung kommen bei uns aus einer Hand. Das spart Schnittstellen, Rückfragen und Wartezeiten auf der Baustelle.</p>","style":"light","items":[{"title":"Beplankung in der Werkstatt spart Zeit auf der Baustelle","text":"<p>Wir verrohren und beplanken die GIS Elemente vorgängig in unserer Werkstatt. Auf der Baustelle wird das Element nur noch versetzt und angeschlossen. So verkürzt sich die Zeit, in der andere Handwerker warten müssen. Transport und Anlieferung stimmen wir auf Ihren Bauablauf ab. Wie gross ein Element werden darf, klären wir anhand von Zufahrt und Abladesituation.</p>"},{"title":"AquaPanel für Nasszellen, Gipsplatten für trockene Räume","text":"<p>In Duschen, Bädern und Nasszellen beplanken wir mit AquaPanel, weil die Platte Feuchtigkeit verträgt. In trockenen Bereichen arbeiten wir mit Gipsplatten. Welche Platte wo zum Einsatz kommt, halten wir vor Baubeginn schriftlich fest. Sagen Sie uns, ob Sie Plättli, Verputz oder eine Beschichtung planen, danach richtet sich der Aufbau.</p>"},{"title":"Spachteln bis zur gewünschten Qualitätsstufe","text":"<p>Nach der Beplankung verspachteln wir Fugen, Kanten und Schraubenköpfe. Sie geben die Qualitätsstufe vor, wir liefern die Fläche entsprechend ab. Damit übernimmt der Maler oder Plattenleger eine Wand, an der er direkt weiterarbeiten kann. Welche Stufe gilt, halten wir vor Arbeitsbeginn schriftlich fest.</p>"},{"title":"Ausflockung und SilentPanel gegen Schall","text":"<p>Auf Wunsch flocken wir die Elemente aus und montieren SilentPanel. Beides reduziert die Schallübertragung von Leitungen in angrenzende Räume. Sinnvoll ist das vor allem bei Wohnungstrennwänden und bei Bädern neben Schlafzimmern. Klären Sie die Anforderung frühzeitig mit uns, denn sie beeinflusst den Wandaufbau.</p>"},{"title":"Ein Ansprechpartner für Vorfabrikation, Montage und Beplankung","text":"<p>Sie beauftragen eine Firma statt drei. Wir montieren die Elemente selbst und beplanken sie anschliessend, deshalb gibt es keine Diskussion über Vorleistungen. Bei Änderungen auf der Baustelle passen wir die Elemente an. Den Stand melden wir Ihnen laufend, damit Ihre Terminplanung hält.</p>"},{"title":"So läuft ein Auftrag ab","text":"<p>Sie senden uns Pläne, Stückzahlen und den gewünschten Termin. Wir prüfen die Unterlagen und stellen Ihnen eine Offerte mit Positionen und Preisen zu. Nach der Freigabe fixieren wir die Produktions- und Montagetermine. Zum Schluss übergeben wir die beplankten Wände und melden Ihnen, was noch offen ist.</p>"}]}', 20, 1
FROM DUAL WHERE @pid IS NOT NULL;

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'faq', '{"heading":"Fragen und Antworten","subtitle":"","items":[{"question":"Beplanken Sie auch GIS Elemente, die wir selbst montiert haben?","answer":"<p>Ja, wir übernehmen die Beplankung auch dann, wenn Vorfabrikation und Montage bei Ihnen liegen. Wir prüfen vor dem Start, ob die Elemente ausgerichtet und die Leitungen abgedrückt sind. Mängel melden wir Ihnen schriftlich, bevor wir die Platten setzen.</p>"},{"question":"Welche Platten verwenden Sie in Nasszellen?","answer":"<p>In Nasszellen und Feuchträumen beplanken wir mit AquaPanel. Für trockene Bereiche kommen Gipsplatten zum Einsatz. Weichen Ihre Vorgaben davon ab, halten wir uns an Ihr Devis.</p>"},{"question":"Wie schnell können Sie mit der Beplankung beginnen?","answer":"<p>Das hängt von der aktuellen Auslastung und der Stückzahl ab. Melden Sie sich mit Ihrem Bauprogramm, dann nennen wir Ihnen einen verbindlichen Termin.</p>"}]}', 30, 1
FROM DUAL WHERE @pid IS NOT NULL;

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'cta-banner', '{"heading":"Offerte für die Beplankung anfragen","body":"Senden Sie uns Pläne, Stückzahl und Wunschtermin, Sie erhalten von uns eine Offerte mit Positionen und Preisen.","button_text":"Pläne einsenden","button_url":"/kontakt"}', 40, 1
FROM DUAL WHERE @pid IS NOT NULL;

-- ────────────────────────────────────────────────────────────
-- /sanitaer-vorwandelemente-beplanken
-- ────────────────────────────────────────────────────────────
SET @pid = (SELECT id FROM pages WHERE slug = 'sanitaer-vorwandelemente-beplanken' LIMIT 1);

-- Gewaehltes Kopfbild merken, bevor die Sektionen fallen
SET @img = (
    SELECT JSON_UNQUOTE(JSON_EXTRACT(content, '$.image_id'))
    FROM sections
    WHERE page_id = @pid AND type = 'parallax-image' AND JSON_VALID(content)
    ORDER BY sort_order ASC LIMIT 1
);

DELETE FROM sections WHERE page_id = @pid AND @pid IS NOT NULL;

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid,
       'parallax-image',
       JSON_SET('{"image_id":0,"height":"medium","overlay_text":""}', '$.image_id', CAST(COALESCE(@img, 0) AS UNSIGNED)),
       10, 1
FROM DUAL WHERE @pid IS NOT NULL;

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'content-grid', '{"heading":"Sanitär Vorwandelemente beplanken: von der Montage bis zur spachtelfertigen Wand","lead":"<p>Sanitär Vorwandelemente beplanken heisst: Das verrohrte GIS-Element bekommt seine Hülle, und die Wand ist bereit für Platten oder Farbe. Wir übernehmen diesen Schritt auf Ihrer Baustelle, im Neubau wie im Umbau. Dazu gehört die Plattenwahl je nach Raum, der Zuschnitt um Rohrdurchführungen und Revisionsöffnungen, die Befestigung im vorgegebenen Raster und auf Wunsch die Spachtelung. In Nasszellen setzen wir AquaPanel ein, in trockenen Bereichen die passende Gipsplatte. Wir kommen auch dann, wenn die Elemente von einem anderen Betrieb gesetzt wurden. Sie erhalten eine Offerte mit Angaben zu Fläche, Plattentyp und Termin, damit Sie Ihre Folgegewerke planen können. Rufen Sie uns an oder schicken Sie uns Ihre Pläne.</p>","style":"light","items":[{"title":"Die Plattenwahl entscheidet über die Lebensdauer der Nasszelle","text":"<p>In Duschen, Bädern und WC-Anlagen beplanken wir mit AquaPanel. Die Platte nimmt kaum Wasser auf und bleibt auch bei dauernder Feuchte formstabil. In angrenzenden Trockenbereichen genügt in der Regel eine Gipsplatte, was Material und Kosten spart. Welche Kombination sinnvoll ist, klären wir vorgängig anhand Ihrer Pläne.</p>"},{"title":"Wir beplanken auch Elemente, die wir nicht gesetzt haben","text":"<p>Viele Anfragen erreichen uns mitten im Bauablauf, wenn die Sanitärinstallation steht und der Trockenbau stockt. Wir prüfen die gesetzten GIS-Elemente auf Fluchten, Befestigung und Rohrlage, bevor wir die erste Platte anschrauben. Abweichungen melden wir Ihnen, statt sie zuzudecken. So vermeiden Sie Nacharbeiten, wenn später die Sanitärapparate montiert werden.</p>"},{"title":"Revisionsöffnungen und Durchführungen werden vor dem Zuschnitt festgelegt","text":"<p>Spülkästen, Absperrventile und Verteiler brauchen dauerhaft Zugang. Wir markieren die Öffnungen anhand der Sanitärpläne und schneiden sie sauber aus, statt nachträglich zu stemmen. Rohrdurchführungen werden dicht und passgenau ausgeführt. Damit bleibt die Wand geschlossen und der Unterhalt trotzdem möglich.</p>"},{"title":"Beplankung und Spachtelung aus einer Hand sparen eine Schnittstelle","text":"<p>Auf Wunsch spachteln wir die beplankten Flächen bis zum vereinbarten Qualitätsniveau. Sie koordinieren dann einen Betrieb weniger und haben eine Ansprechperson für das Ergebnis. Das Niveau der Spachtelung halten wir in der Offerte fest, damit Maler oder Plattenleger wissen, was sie übernehmen.</p>"},{"title":"Ausflockung und SilentPanel für ruhigere Nasszellen","text":"<p>Wo Schallschutz gefragt ist, kombinieren wir die Beplankung mit Ausflockung oder SilentPanel. Der Hohlraum hinter der Vorwand wird gefüllt, bevor die zweite Plattenlage geschlossen wird. Das dämpft Spül- und Fliessgeräusche spürbar, besonders bei Wänden zu Schlaf- und Wohnräumen. Diese Massnahme muss vor der Beplankung entschieden werden.</p>"},{"title":"So läuft eine Anfrage bei uns ab","text":"<p>Sie senden uns Grundrisse, Sanitärpläne und den gewünschten Termin. Wir schätzen die Fläche, legen Plattentyp und Aufbau fest und stellen Ihnen eine Offerte zu. Nach Ihrer Freigabe reservieren wir das Zeitfenster und stimmen die Anlieferung mit der Bauleitung ab.</p>"}]}', 20, 1
FROM DUAL WHERE @pid IS NOT NULL;

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'faq', '{"heading":"Fragen und Antworten","subtitle":"","items":[{"question":"Womit werden Sanitär Vorwandelemente in Nasszellen beplankt?","answer":"<p>In Duschen und Bädern verwenden wir AquaPanel, weil die Platte auf Feuchtigkeit unempfindlich reagiert. In trockenen Zonen derselben Wohnung setzen wir Gipsplatten ein. Die Abgrenzung legen wir vor Arbeitsbeginn anhand Ihrer Pläne fest.</p>"},{"question":"Beplanken Sie auch Elemente, die ein anderer Betrieb montiert hat?","answer":"<p>Ja, das ist ein grosser Teil unserer Arbeit. Wir prüfen vorgängig Fluchten, Befestigung und Rohrlage und melden Ihnen allfällige Abweichungen. Erst danach beginnen wir mit der Beplankung.</p>"},{"question":"Übernehmen Sie auch die Spachtelung nach der Beplankung?","answer":"<p>Ja, Beplankung und Spachtelung erhalten Sie bei uns zusammen. Das vereinbarte Niveau halten wir in der Offerte fest, damit Maler und Plattenleger sauber anschliessen können.</p>"}]}', 30, 1
FROM DUAL WHERE @pid IS NOT NULL;

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'cta-banner', '{"heading":"Beplankung anfragen","body":"Senden Sie uns Ihre Sanitärpläne und den Wunschtermin, wir melden uns mit einer Offerte zu Fläche, Plattentyp und Zeitfenster.","button_text":"Pläne einsenden","button_url":"/kontakt"}', 40, 1
FROM DUAL WHERE @pid IS NOT NULL;

-- ────────────────────────────────────────────────────────────
-- Kontrolle: je Seite muessen vier Sektionen stehen
-- ────────────────────────────────────────────────────────────
-- SELECT p.slug, COUNT(s.id) AS sektionen, GROUP_CONCAT(s.type ORDER BY s.sort_order) AS aufbau
-- FROM pages p JOIN sections s ON s.page_id = p.id
-- WHERE p.slug LIKE 'sanitaer-%' OR p.slug LIKE 'gis-%'
-- GROUP BY p.slug;


-- ════════════════════════════════════════════════════════════
-- E) TEXTE DER STARTSEITE
-- ════════════════════════════════════════════════════════════

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


-- ════════════════════════════════════════════════════════════
-- F) HARTE ZEILENUMBRUECHE IN DEN WERTE-KARTEN
-- ════════════════════════════════════════════════════════════

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


-- ════════════════════════════════════════════════════════════
-- G) HERO-TITEL KUERZEN
-- ════════════════════════════════════════════════════════════

UPDATE sections s
JOIN pages p ON p.id = s.page_id
SET s.content = JSON_SET(
        s.content,
        '$.heading', 'GIS Elemente Vorfabrikation',
        '$.tagline', 'Vorfabrikation und Montage von GIS-Elementen aus Pfäffikon SZ'
    )
WHERE p.is_homepage = 1
  AND s.type = 'hero'
  AND JSON_VALID(s.content);

-- Kontrolle
-- SELECT JSON_UNQUOTE(JSON_EXTRACT(content,'$.heading')) AS ueberschrift,
--        JSON_UNQUOTE(JSON_EXTRACT(content,'$.tagline'))  AS tagline
-- FROM sections s JOIN pages p ON p.id=s.page_id
-- WHERE p.is_homepage=1 AND s.type='hero';


-- ════════════════════════════════════════════════════════════
-- H) GANZE SCHWEIZ WIRD GANZE DEUTSCHSCHWEIZ
-- ════════════════════════════════════════════════════════════

UPDATE sections
SET content = REPLACE(REPLACE(content,
        'ganzen Schweiz', 'ganzen Deutschschweiz'),
        'ganze Schweiz',  'ganze Deutschschweiz')
WHERE content LIKE '%ganzen Schweiz%' OR content LIKE '%ganze Schweiz%';

UPDATE pages
SET meta_desc = REPLACE(REPLACE(meta_desc,
        'ganzen Schweiz', 'ganzen Deutschschweiz'),
        'ganze Schweiz',  'ganze Deutschschweiz')
WHERE meta_desc LIKE '%ganzen Schweiz%' OR meta_desc LIKE '%ganze Schweiz%';

UPDATE pages
SET meta_title = REPLACE(REPLACE(meta_title,
        'ganzen Schweiz', 'ganzen Deutschschweiz'),
        'ganze Schweiz',  'ganze Deutschschweiz')
WHERE meta_title LIKE '%ganzen Schweiz%' OR meta_title LIKE '%ganze Schweiz%';

UPDATE settings
SET setting_val = REPLACE(REPLACE(setting_val,
        'ganzen Schweiz', 'ganzen Deutschschweiz'),
        'ganze Schweiz',  'ganze Deutschschweiz')
WHERE setting_val LIKE '%ganzen Schweiz%' OR setting_val LIKE '%ganze Schweiz%';

UPDATE ref_items
SET description = REPLACE(REPLACE(description,
        'ganzen Schweiz', 'ganzen Deutschschweiz'),
        'ganze Schweiz',  'ganze Deutschschweiz')
WHERE description LIKE '%ganzen Schweiz%' OR description LIKE '%ganze Schweiz%';


-- ------------------------------------------------------------
-- Falls die Ersetzung doppelt lief: "DeutschDeutschschweiz"
-- gaebe es dann. Vorsichtshalber zurueckdrehen.
-- ------------------------------------------------------------
UPDATE sections SET content     = REPLACE(content,     'DeutschDeutschschweiz', 'Deutschschweiz') WHERE content     LIKE '%DeutschDeutschschweiz%';
UPDATE pages    SET meta_desc   = REPLACE(meta_desc,   'DeutschDeutschschweiz', 'Deutschschweiz') WHERE meta_desc   LIKE '%DeutschDeutschschweiz%';
UPDATE settings SET setting_val = REPLACE(setting_val, 'DeutschDeutschschweiz', 'Deutschschweiz') WHERE setting_val LIKE '%DeutschDeutschschweiz%';
UPDATE ref_items SET description= REPLACE(description, 'DeutschDeutschschweiz', 'Deutschschweiz') WHERE description LIKE '%DeutschDeutschschweiz%';


-- ------------------------------------------------------------
-- Kontrolle: muss 0 ergeben
-- ------------------------------------------------------------
-- SELECT COUNT(*) FROM sections WHERE content LIKE '%ganzen Schweiz%' OR content LIKE '%ganze Schweiz%';


-- ════════════════════════════════════════════════════════════
-- I) GEDANKENSTRICHE ENTFERNEN (zum Schluss)
-- ════════════════════════════════════════════════════════════

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


-- ════════════════════════════════════════════════════════════
-- FERTIG
--
-- Naechste Schritte, keiner davon in dieser Datei:
--
--   1. Im CMS unter Medien auf "Bilder jetzt umwandeln"
--   2. Im CMS unter Einstellungen, Kontakt die Oeffnungszeiten
--      eintragen: Mo-Do 07:00-17:30; Fr 07:00-16:30
--   3. Die sechs neuen Seiten anschauen, Kopfbilder waehlen
--   4. Erst dann 2-SEITEN-ONLINE-SCHALTEN.sql einspielen
-- ════════════════════════════════════════════════════════════
