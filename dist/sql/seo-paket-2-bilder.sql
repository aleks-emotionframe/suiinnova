-- ============================================================
-- SUI Innova GmbH — SEO Paket 2
-- Groessenvarianten fuer Bilder
--
-- Behebt die Audit-Befunde 03 und 06 vom 03.09.2026:
--   - Referenzen laedt 8,1 Sekunden, Leistungen 6,6 Sekunden
--   - 57 von 59 Bildern werden zu gross geladen, kein srcset
--   - Kein Bild hat width und height im Markup
--
-- Gefahrlos mehrfach ausfuehrbar.
-- ============================================================

-- ------------------------------------------------------------
-- Spalte fuer die Groessenvarianten
--
-- Haelt ein JSON-Objekt der Form {"400":"images/variants/abc-400.webp", ...}.
-- Das CMS legt die Spalte beim ersten Upload notfalls selbst an, aber hier
-- ist es sauberer und laeuft nicht in ein Zeitlimit.
--
-- Hinweis: Aeltere MySQL-Versionen kennen "ADD COLUMN IF NOT EXISTS" nicht.
-- Wirft die Zeile den Fehler "Duplicate column name", ist die Spalte bereits
-- da — dann ist nichts zu tun und der Fehler kann ignoriert werden.
-- ------------------------------------------------------------

-- Zeichensatz der Verbindung festnageln.
-- Ohne diese Zeile interpretiert der Server die Datei je nach Client als
-- latin1, und aus "Pfäffikon" wird "PfÃ¤ffikon" — in jedem Titel, jeder
-- Beschreibung und jedem Seitentext. Getestet und genau so passiert.
SET NAMES utf8mb4;

ALTER TABLE media ADD COLUMN variants TEXT NULL AFTER thumb_path;


-- ------------------------------------------------------------
-- Kontrolle: Wie viele Bilder haben noch keine Varianten?
--
-- Nach dem Upload der Dateien im CMS unter Medien auf
-- "Bilder jetzt umwandeln" klicken. Danach muss diese Abfrage 0 liefern.
-- ------------------------------------------------------------
-- SELECT COUNT(*) AS ohne_varianten FROM media
-- WHERE (variants IS NULL OR variants = '' OR variants = '{}')
--   AND mime_type LIKE 'image/%'
--   AND mime_type <> 'image/svg+xml';

-- Und wo fehlt noch ein Alternativtext?
-- SELECT id, original FROM media
-- WHERE (alt_text IS NULL OR TRIM(alt_text) = '')
--   AND mime_type LIKE 'image/%';
