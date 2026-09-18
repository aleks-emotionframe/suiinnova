-- ============================================================
-- SUI Innova GmbH — DIAGNOSE
--
-- Aendert nichts. Liest nur aus und sagt, was in der Datenbank
-- wirklich steht.
--
-- In phpMyAdmin einspielen wie die anderen Dateien. Es kommen
-- fuenf Ergebnistabellen. Schicken Sie mir davon einen
-- Bildschirmausschnitt oder tippen Sie ab, was dort steht.
-- ============================================================

SET NAMES utf8mb4;


-- ────────────────────────────────────────────────────────────
-- 1) Sind die Texte angekommen?
--
-- SOLL: neun Zeilen, Spalte laenge_beschreibung zwischen 138
--       und 159, Spalte fliesstext_links ueberall 2.
-- ────────────────────────────────────────────────────────────
SELECT '1) TEXTE' AS pruefung;

SELECT
    p.slug,
    p.is_active                              AS online,
    CHAR_LENGTH(p.meta_title)                AS laenge_titel,
    CHAR_LENGTH(p.meta_desc)                 AS laenge_beschreibung,
    COALESCE((
        SELECT (LENGTH(s.content) - LENGTH(REPLACE(s.content, '<a href=', ''))) / 8
        FROM sections s
        WHERE s.page_id = p.id AND s.type = 'content-grid'
        LIMIT 1
    ), 0)                                    AS fliesstext_links
FROM pages p
WHERE p.slug IN (
    'leistungen',
    'sanitaer-gis-elemente-bestellen',
    'gis-elemente-beplanken',
    'sanitaer-vorwandelemente',
    'sanitaer-vorwandelemente-bestellen',
    'sanitaer-vorwaende',
    'sanitaer-vorwandelemente-beplanken',
    'sanitaerelemente-vorfabrizieren',
    'sanitaerelemente-montieren'
)
ORDER BY p.sort_order;


-- ────────────────────────────────────────────────────────────
-- 2) Steht der Linkblock auf der Startseite?
--
-- SOLL: eine Zeile mit type = link-list, und sie muss VOR der
--       Zeile mit cta-banner stehen.
-- ────────────────────────────────────────────────────────────
SELECT '2) STARTSEITE' AS pruefung;

SELECT s.sort_order, s.type
FROM sections s
JOIN pages p ON p.id = s.page_id
WHERE p.is_homepage = 1
ORDER BY s.sort_order;


-- ────────────────────────────────────────────────────────────
-- 3) Wie viele Linkblöcke gibt es insgesamt?
--
-- SOLL: 12 Zeilen. Kommt hier 0, ist die SQL nicht durchgelaufen.
-- ────────────────────────────────────────────────────────────
SELECT '3) LINKBLOECKE' AS pruefung;

SELECT p.slug, COUNT(*) AS bloecke
FROM sections s
JOIN pages p ON p.id = s.page_id
WHERE s.type = 'link-list'
GROUP BY p.slug
ORDER BY p.sort_order;


-- ────────────────────────────────────────────────────────────
-- 4) Text auf den Bildstreifen
--
-- SOLL: Spalte text_auf_bild ueberall leer.
-- ────────────────────────────────────────────────────────────
SELECT '4) BILDSTREIFEN' AS pruefung;

SELECT
    p.slug,
    s.sort_order,
    JSON_UNQUOTE(JSON_EXTRACT(s.content, '$.overlay_text')) AS text_auf_bild,
    JSON_UNQUOTE(JSON_EXTRACT(s.content, '$.image_id'))     AS bild_gewaehlt,
    LEFT(COALESCE(JSON_UNQUOTE(JSON_EXTRACT(s.content, '$.alt')), ''), 40) AS bildbeschreibung
FROM sections s
JOIN pages p ON p.id = s.page_id
WHERE s.type = 'parallax-image'
ORDER BY p.sort_order, s.sort_order;


-- ────────────────────────────────────────────────────────────
-- 5) Datenbank und Zeitpunkt
--
-- Zeigt, in welche Datenbank Sie gerade schauen und wann die
-- Seiten zuletzt geaendert wurden. Liegt zuletzt_geaendert vor
-- heute, ist die SQL nie angekommen.
-- ────────────────────────────────────────────────────────────
SELECT '5) DATENBANK' AS pruefung;

SELECT
    DATABASE()                AS datenbank,
    VERSION()                 AS server,
    NOW()                     AS jetzt,
    (SELECT MAX(updated_at) FROM pages)    AS seiten_zuletzt_geaendert,
    (SELECT MAX(updated_at) FROM sections) AS sektionen_zuletzt_geaendert;
