-- ============================================================
-- SUI Innova GmbH
-- Die Seite "Ausflockung Nasszellen" freischalten
--
-- ERST AUSFUEHREN, WENN:
--   1. plan-0918-alles.sql gelaufen ist
--   2. Sie die Seite im CMS gelesen haben
--   3. die Seite ein Kopfbild hat
--
-- Warum diese Seite:
-- Die Search Console zeigt fuer "ausflockung nasszellen" 28
-- Impressionen in drei Monaten auf Position 34, ohne dass eine
-- einzige Seite das Thema behandelt. Google zeigt die Website
-- trotzdem, weil das Wort im Text der Leistungsseiten vorkommt.
--
-- Die Seite nennt bewusst keine Dezibelwerte. Welcher Wert gilt,
-- steht im Schallschutznachweis des Projekts. Eine Zahl auf der
-- Website waere bei einer Reklamation ein Versprechen.
--
-- Nach dem Freischalten steht sie in der sitemap.xml, erscheint
-- im Footer und wird von vier Seiten verlinkt. Alles automatisch.
--
-- Gefahrlos mehrfach ausfuehrbar.
-- ============================================================

SET NAMES utf8mb4;

UPDATE pages SET is_active = 1 WHERE slug = 'ausflockung-nasszellen';

-- ------------------------------------------------------------
-- Kontrolle
-- ------------------------------------------------------------
-- SELECT slug, is_active, meta_title FROM pages
-- WHERE slug = 'ausflockung-nasszellen';
