-- ============================================================
-- SUI Innova GmbH
-- Die zwei neuen Seiten aus dem Plan vom 18.09.2026 freischalten
--
-- ERST AUSFUEHREN, WENN:
--   1. plan-0918-alles.sql gelaufen ist
--   2. beide Seiten im CMS kontrolliert wurden
--   3. beide ein Kopfbild haben
--
-- Danach sind sie oeffentlich, stehen in der sitemap.xml und
-- erscheinen im Footer. Beides passiert automatisch.
--
-- Gefahrlos mehrfach ausfuehrbar.
-- ============================================================

SET NAMES utf8mb4;

UPDATE pages SET is_active = 1
WHERE slug IN (
    'sanitaerelemente-vorfabrizieren',
    'sanitaerelemente-montieren'
);

-- ────────────────────────────────────────────────────────────
-- Kontrolle: beide muessen is_active = 1 sein
-- ────────────────────────────────────────────────────────────
-- SELECT slug, is_active, meta_title FROM pages
-- WHERE slug IN ('sanitaerelemente-vorfabrizieren', 'sanitaerelemente-montieren');
