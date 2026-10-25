-- ============================================================
-- SUI Innova GmbH
-- SEO-Aufgaben vom 15.10.2026
--
-- Quelle: SEO Kompass, Stand 15.10.2026.
--
-- Diese Datei enthaelt, was nicht aus dem Keyword-Generator
-- kommt: Startseite, Kontaktseite, Freischaltung der Seite
-- Ausflockung. Die Texte der Leistungsseiten stehen in
-- plan-0918-alles.sql.
--
-- Gefahrlos mehrfach ausfuehrbar.
-- ============================================================

SET NAMES utf8mb4;


-- ════════════════════════════════════════════════════════════
-- Startseite
--
-- Der Bericht schlaegt den Titel "Sanitär in Pfäffikon SZ | SUI
-- Innova GmbH" vor, gestuetzt auf 10 Impressionen fuer "sanitär
-- pfäffikon sz". Damit fiele "GIS Elemente Vorfabrikation" aus
-- dem Titel, das im September als Hauptkeyword der Startseite
-- festgelegt wurde. Nach Ruecksprache: beides, der Ort kommt
-- dazu, das Keyword bleibt.
-- ════════════════════════════════════════════════════════════

UPDATE pages
SET meta_title = 'GIS Elemente Vorfabrikation Pfäffikon SZ | SUI Innova',
    meta_desc  = 'Die SUI Innova GmbH in Pfäffikon SZ fertigt GIS-Elemente verrohrt vor, montiert sie auf Ihrer Baustelle und beplankt sie. Pläne senden, Offerte erhalten.'
WHERE is_homepage = 1;


-- ------------------------------------------------------------
-- Hauptueberschrift und Zeile darunter
--
-- Die H1 nimmt den Ort auf.
--
-- Die Zeile darunter stand kurzzeitig auf "Sanitär in Pfäffikon
-- SZ", weil der Bericht den Begriff verlangt hat. Zurueckgestellt
-- nach Pruefung der Suchanfragen: "sanitär pfäffikon" und
-- "badumbau pfäffikon" stehen auf Position 1 und bringen null
-- Klicks, ueber alle Anfragen dieser Art 35 Impressionen und
-- kein einziger Klick. Wer so sucht, will einen Installateur fuer
-- die eigene Wohnung, nicht einen Vorfertiger fuer Bauleitungen.
-- Mehr Sichtbarkeit dort bringt nur Besucher, die sofort wieder
-- gehen.
--
-- "Sanitär" bleibt stehen, das stimmt ja. Es ist "Sanitär plus
-- Ort allein", das die falschen Leute anzieht.
--
-- Laenge beachtet: Der Hero-Titel stand schon einmal zu lang in
-- der Seite und brach mitten im Wort um. Gemessen bei 375, 414
-- und 1920 Pixel: kein Wort zerrissen.
-- ------------------------------------------------------------
UPDATE sections s
JOIN pages p ON p.id = s.page_id
SET s.content = JSON_SET(
        s.content,
        '$.heading', 'GIS Elemente Vorfabrikation in Pfäffikon SZ',
        '$.tagline', 'Sanitär Vorfabrikation und Montage aus Pfäffikon SZ'
    )
WHERE p.is_homepage = 1
  AND s.type = 'hero'
  AND JSON_VALID(s.content);


-- ------------------------------------------------------------
-- Absatz mit Firmenname, Standort und Leistungen
--
-- Der Bericht: fuer "innova gmbh" steht die Startseite auf
-- Position 4.9 mit 19 Impressionen und keinem Klick. Es fehlt
-- ein Satz, den Google als Beschreibung des Unternehmens nehmen
-- kann.
--
-- Die Angaben stammen aus dem Impressum und dem Footer, nichts
-- davon ist neu erfunden.
--
-- Die Pruefung auf den bisherigen Wortlaut verhindert, dass ein
-- spaeter von Hand geaenderter Text ueberschrieben wird.
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
      'nicht nachgearbeitet werden.</p>',
      '<p>Sie finden uns an der Talstrasse 31 in 8808 Pfäffikon SZ. Unsere Leistungen: ',
      'Vorfabrikation von GIS-Elementen, Montage auf der Baustelle, Beplankung mit ',
      'AquaPanel und Spachtelung bis zur fertigen Wand.</p>'
    ))
WHERE p.is_homepage = 1
  AND s.type = 'about-teaser'
  AND JSON_VALID(s.content)
  AND JSON_UNQUOTE(JSON_EXTRACT(s.content, '$.body')) LIKE '%über 25 Fachkräfte%'
  AND JSON_UNQUOTE(JSON_EXTRACT(s.content, '$.body')) NOT LIKE '%Talstrasse 31%';


-- ════════════════════════════════════════════════════════════
-- Kontaktseite
--
-- Position 2.3, 128 Impressionen, 3 Klicks. Der bisherige Titel
-- sagte, was man tun soll, nicht wen man erreicht. Telefonnummer
-- und Adresse im Suchergebnis sind bei einer Kontaktseite der
-- Grund, warum jemand klickt.
-- ════════════════════════════════════════════════════════════

UPDATE pages SET
    meta_title = 'Kontakt: SUI Innova GmbH in Pfäffikon SZ | Telefon, Mail',
    meta_desc  = 'SUI Innova GmbH, Talstrasse 31, 8808 Pfäffikon SZ. Telefon 055 420 19 90, info@sui-innova.ch. Sanitärpläne einsenden und Offerte erhalten.'
WHERE slug = 'kontakt';


-- ════════════════════════════════════════════════════════════
-- Ueber uns
--
-- Nachtrag vom 15.10.2026, zweiter Durchlauf des Berichts:
-- Position 3, Impressionen von 134 auf 164 gestiegen, Klicks von
-- 10 auf 8 gefallen. Die alte Beschreibung sagte "Lernen Sie
-- Team, Ablauf und Anspruch kennen" und damit nichts, was jemand
-- wissen will. Jetzt stehen die drei Zahlen und Fakten darin,
-- die den Unterschied zu einem Zwischenhaendler ausmachen.
--
-- Die Angabe "ueber 25 Fachkraefte" steht bereits auf der
-- Startseite, sie ist nicht neu erfunden.
-- ════════════════════════════════════════════════════════════

UPDATE pages SET
    meta_title = 'Über uns: Werkstatt und Team in Pfäffikon SZ | SUI Innova',
    meta_desc  = 'Über 25 Fachkräfte, eigene Werkstatt in Pfäffikon SZ, eigenes Montageteam. So entsteht bei SUI Innova ein verrohrtes GIS-Element, vom Plan bis zur Wand.'
WHERE slug = 'ueber-uns';


-- ════════════════════════════════════════════════════════════
-- Seite Ausflockung Nasszellen freischalten
--
-- Der Bericht meldet sie als nicht indexiert und in keiner
-- Sitemap. Beides, weil sie noch deaktiviert war. Mit dem
-- Freischalten steht sie in der sitemap.xml, erscheint im Footer
-- und in den Linkbloecken von vier Seiten. Alles automatisch.
-- ════════════════════════════════════════════════════════════

UPDATE pages SET is_active = 1 WHERE slug = 'ausflockung-nasszellen';


-- ------------------------------------------------------------
-- Kontrolle
-- ------------------------------------------------------------
-- SELECT slug, is_active, CHAR_LENGTH(meta_title) AS t,
--        CHAR_LENGTH(meta_desc) AS b, meta_title
-- FROM pages ORDER BY sort_order;
--
-- SELECT JSON_UNQUOTE(JSON_EXTRACT(content, '$.heading')) AS h1,
--        JSON_UNQUOTE(JSON_EXTRACT(content, '$.tagline')) AS zeile
-- FROM sections s JOIN pages p ON p.id = s.page_id
-- WHERE p.is_homepage = 1 AND s.type = 'hero';
