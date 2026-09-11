-- ============================================================
-- SUI Innova GmbH — SEO Paket 1
-- Seitentitel, Meta-Descriptions und Hauptueberschriften
--
-- Quelle der Texte: Keyword-Plan vom 08.09.2026 (EmotionFrame)
-- Behebt die Audit-Befunde 2, 3 und 4 vom 03.09.2026:
--   - 6 von 8 Seiten ohne Hauptueberschrift
--   - Firmenname zweimal im Titel, Suchbegriff gar nicht
--   - 0 von 8 Seiten mit Meta-Description
--
-- Gefahrlos mehrfach ausfuehrbar.
-- ============================================================

-- ------------------------------------------------------------
-- 1) Title-Suffix leeren
--
-- Der Suffix stand auf dem Firmennamen und wurde zusaetzlich zum
-- Site-Namen angehaengt. Ergebnis war "Leistungen – SUI Innova GmbH
-- | SUI Innova GmbH": von 46 Zeichen gingen 32 fuer den doppelten
-- Namen drauf. Die Titel unten bringen die Firma selbst mit.
-- ------------------------------------------------------------
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
-- einander. "gis elemente" (70 Suchen/Monat, Schwierigkeit 0) liegt
-- deshalb hier auf /leistungen — die Seite existiert, passt thematisch
-- und hat dadurch erstmals ein eigenes Thema.
-- ------------------------------------------------------------

-- Startseite → sanitär vorfabrikation
UPDATE pages SET
    meta_title = 'Sanitär Vorfabrikation | SUI Innova GmbH',
    meta_desc  = 'Sanitär Vorfabrikation aus Pfäffikon SZ: GIS-Elemente fertig verrohrt, Montage, Beplankung und Spachtelung. Senden Sie uns Ihre Pläne für eine Offerte.'
WHERE is_homepage = 1;

-- Leistungen → gis elemente
UPDATE pages SET
    meta_title = 'GIS Elemente: Vorfabrikation und Montage | SUI Innova',
    meta_desc  = 'GIS Elemente fix verrohrt aus der Werkstatt in Pfäffikon SZ, inklusive Montage, Beplankung und Ausflockung. Projekt schildern und Offerte anfordern.'
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
    meta_desc  = 'Wie die SUI Innova GmbH Personendaten bearbeitet: Kontaktformular, Bewerbungen, Cookies und Google Analytics — nach revDSG und DSGVO.'
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
        WHEN 'leistungen'  THEN 'GIS Elemente: von der Werkstatt bis zur fertigen Wand'
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
-- Der Suchbegriff und der Ort stehen trotzdem drin.
UPDATE sections s
JOIN pages p ON p.id = s.page_id
SET s.content = JSON_SET(s.content, '$.heading', 'Sanitär Vorfabrikation aus Pfäffikon SZ')
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
