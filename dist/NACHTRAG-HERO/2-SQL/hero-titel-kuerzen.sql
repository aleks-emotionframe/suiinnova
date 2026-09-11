-- ============================================================
-- SUI Innova GmbH — Hero-Titel der Startseite kuerzen
--
-- "GIS ELEMENTE VORFABRIKATION AUS PFÄFFIKON SZ" sind 44 Zeichen.
-- In Grossbuchstaben bei 64 Pixeln passt das in keine Hero-Spalte,
-- ohne entweder ueber das halbe Bild zu laufen oder auf drei bis
-- vier Zeilen zu brechen.
--
-- Der Suchbegriff bleibt vollstaendig in der Ueberschrift. Der Ort
-- rutscht eine Zeile tiefer in die Tagline und steht ausserdem
-- weiterhin im Seitentitel, in der Beschreibung, in den
-- strukturierten Daten, im Footer und auf der Kontaktseite.
--
-- Gefahrlos mehrfach ausfuehrbar.
-- ============================================================

SET NAMES utf8mb4;

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
