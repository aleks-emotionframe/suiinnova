-- ============================================================
-- SUI Innova GmbH — "ganze Schweiz" zu "ganze Deutschschweiz"
--
-- Das Google-Unternehmensprofil sagt Deutschschweiz, die Website
-- sagte an mehreren Stellen ganze Schweiz. Zwei verschiedene
-- Aussagen ueber dasselbe Einzugsgebiet, und Google liest beide.
--
-- Betroffene Stellen, soweit auffindbar:
--   - Ueber-uns-Teaser auf der Startseite
--   - Beschreibung der Referenzseite fuers Suchergebnis
--   - alles Weitere, was den Wortlaut enthaelt
--
-- Ersetzt wird nur die Wortfolge "ganze(n) Schweiz". Ein
-- alleinstehendes "Schweiz" bleibt, damit Adressen wie
-- "8808 Pfäffikon, Schweiz" unveraendert bleiben.
--
-- Gefahrlos mehrfach ausfuehrbar: "ganzen Deutschschweiz"
-- enthaelt die gesuchte Wortfolge nicht mehr.
-- ============================================================

SET NAMES utf8mb4;

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
