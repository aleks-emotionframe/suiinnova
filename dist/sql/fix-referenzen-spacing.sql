-- ============================================
-- SUI Innova GmbH — Referenzen-Seite: Abstand fix
-- ============================================
-- Problem: Text-Block + References-Grid hatten beide eigene vertikale Paddings
-- → Abstand zwischen Titel und Bildern zu gross
--
-- Fix: Titel + Intro direkt in die References-Grid-Sektion packen,
--      den extra Text-Block loeschen.
-- ============================================

SET @page_id = (SELECT id FROM pages WHERE slug = 'referenzen' LIMIT 1);

-- 1) Intro-Text-Block oberhalb des Grids loeschen
DELETE FROM sections
WHERE page_id = @page_id
  AND type = 'text-block'
  AND sort_order = 2
  AND JSON_UNQUOTE(JSON_EXTRACT(content, '$.heading')) = 'Unsere Referenzen';

-- 2) References-Grid bekommt Heading + Subtitle direkt
UPDATE sections
SET content = JSON_SET(
        COALESCE(content, JSON_OBJECT()),
        '$.heading',  'Unsere Referenzen',
        '$.subtitle', 'Qualität zeigt sich erst in der Umsetzung. Ein Auszug aus Projekten, bei denen wir in den letzten Jahren mit Vorfabrikation und Montage beteiligt waren.'
    )
WHERE page_id = @page_id
  AND type = 'references-grid';

-- 3) Sort-Order neu vergeben (Banner=1, Grid=2, Stats=3, Parallax=4, CTA=5)
UPDATE sections SET sort_order = 1 WHERE page_id = @page_id AND type = 'parallax-image' AND sort_order <= 2;
UPDATE sections SET sort_order = 2 WHERE page_id = @page_id AND type = 'references-grid';
UPDATE sections SET sort_order = 3 WHERE page_id = @page_id AND type = 'stats-bar';
UPDATE sections SET sort_order = 4 WHERE page_id = @page_id AND type = 'parallax-image' AND sort_order > 2;
UPDATE sections SET sort_order = 5 WHERE page_id = @page_id AND type = 'cta-banner';

-- ============================================
-- Fertig! Aufruf https://sui-innova.ch/referenzen
-- ============================================
