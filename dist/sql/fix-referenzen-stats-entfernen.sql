-- ============================================
-- SUI Innova GmbH — Referenzen-Seite: Stats-Bar entfernen
-- ============================================
-- Loescht die Zahlen-Sektion (150+ Projekte, 85+ Fachkraefte etc.)
-- von der Referenzen-Seite.
-- ============================================

SET @page_id = (SELECT id FROM pages WHERE slug = 'referenzen' LIMIT 1);

-- Stats-Bar-Sektion entfernen
DELETE FROM sections
WHERE page_id = @page_id
  AND type = 'stats-bar';

-- Sort-Order der verbleibenden Sektionen schliessen (ohne Luecke)
SET @order = 0;
UPDATE sections
SET sort_order = (@order := @order + 1)
WHERE page_id = @page_id
ORDER BY sort_order ASC;

-- ============================================
-- Fertig. Aufruf https://sui-innova.ch/referenzen
-- ============================================
