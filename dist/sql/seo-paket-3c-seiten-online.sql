-- ============================================================
-- SUI Innova GmbH — SEO Paket 3c
-- Die sechs neuen Seiten online schalten
--
-- Separat gehalten, weil es der einzige Schritt ist, der die
-- Website oeffentlich veraendert. Die Texte sind vollstaendig,
-- es ist keine Stelle mehr offen — aber neue oeffentliche Seiten
-- gehen erst online, wenn ein Mensch sie gesehen hat.
--
-- Vorher anschauen (als Admin eingeloggt, auch offline sichtbar):
--   sui-innova.ch/sanitaer-vorwandelemente
--   sui-innova.ch/sanitaer-gis-elemente-bestellen
--   sui-innova.ch/sanitaer-vorwandelemente-bestellen
--   sui-innova.ch/sanitaer-vorwaende
--   sui-innova.ch/gis-elemente-beplanken
--   sui-innova.ch/sanitaer-vorwandelemente-beplanken
--
-- Dasselbe geht auch im CMS unter Seiten mit einem Klick je Seite.
--
-- Danach: seo-paket-3b-interne-links.sql einspielen.
-- ============================================================

-- Zeichensatz der Verbindung festnageln.
-- Ohne diese Zeile interpretiert der Server die Datei je nach Client als
-- latin1, und aus "Pfäffikon" wird "PfÃ¤ffikon" — in jedem Titel, jeder
-- Beschreibung und jedem Seitentext. Getestet und genau so passiert.
SET NAMES utf8mb4;

UPDATE pages SET is_active = 1
WHERE slug IN (
    'sanitaer-vorwandelemente',
    'sanitaer-gis-elemente-bestellen',
    'sanitaer-vorwandelemente-bestellen',
    'sanitaer-vorwaende',
    'gis-elemente-beplanken',
    'sanitaer-vorwandelemente-beplanken'
);

-- Rueckgaengig machen, falls doch noch etwas auffaellt:
-- UPDATE pages SET is_active = 0 WHERE slug IN ( ... dieselbe Liste ... );

-- Kontrolle: alle sechs muessen jetzt 1 zeigen
-- SELECT slug, is_active FROM pages WHERE slug LIKE 'sanitaer-%' OR slug LIKE 'gis-%';
