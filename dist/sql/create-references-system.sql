-- ============================================
-- SUI Innova GmbH — Zentrale Referenz-Verwaltung
-- ============================================
-- 1) Neue Tabelle ref_items (alle Referenzen zentral)
-- 2) Seed mit 6 Default-Referenzen (nur wenn leer)
-- 3) Bestehende references-grid-Sektionen: items leeren
--    → sie ziehen automatisch aus ref_items
-- ============================================

-- 1) Tabelle anlegen
CREATE TABLE IF NOT EXISTS ref_items (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    title       VARCHAR(255) NOT NULL,
    description TEXT         DEFAULT NULL,
    category    VARCHAR(100) DEFAULT NULL,   -- z.B. "Wohnbau"
    city        VARCHAR(100) DEFAULT NULL,   -- z.B. "Zuerich"
    year        INT          DEFAULT NULL,   -- optional
    image_id    INT          DEFAULT NULL,   -- FK auf media
    is_active   TINYINT(1)   NOT NULL DEFAULT 1,
    sort_order  INT          NOT NULL DEFAULT 0,
    created_at  DATETIME     DEFAULT CURRENT_TIMESTAMP,
    updated_at  DATETIME     DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_sort (sort_order),
    INDEX idx_active (is_active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2) Default-Referenzen einfuegen (nur wenn Tabelle leer)
INSERT INTO ref_items (title, description, category, city, year, sort_order, is_active)
SELECT * FROM (
    SELECT 'Wohnüberbauung Limmatfeld' AS title, 'Sanitär-Vorfabrikation und Montage für 120 Wohneinheiten. GIS-Elemente, Vorwandsysteme, Beplankungen – komplett aus einer Hand.' AS description, 'Wohnbau' AS category, 'Dietikon ZH' AS city, 2024 AS year, 1 AS sort_order, 1 AS is_active UNION ALL
    SELECT 'Geschäftshaus Europaallee', 'Vorfabrikation und Montage von Sanitärinstallationen im modernen Geschäftshaus. Enge Terminplanung, präzise Umsetzung.', 'Gewerbebau', 'Zürich', 2023, 2, 1 UNION ALL
    SELECT 'Spital Limmattal Erweiterung', 'Spezialisierte Sanitärinstallationen im Spitalbau. AquaPanel-Montage und Vorwandsysteme in Nassräumen und OP-Bereichen.', 'Spitalbau', 'Schlieren ZH', 2023, 3, 1 UNION ALL
    SELECT 'Schulanlage Leutschenbach', 'Sanitär-Vorfabrikation für den Neubau einer modernen Schulanlage. Effiziente GIS-Montage in enger Terminplanung.', 'Bildungsbau', 'Zürich', 2024, 4, 1 UNION ALL
    SELECT 'Alterszentrum Grünau', 'Barrierefreie Sanitärinstallationen für 80 Pflegezimmer. Duofix-Systeme und spezielle Anforderungen an die Zugänglichkeit.', 'Gesundheitsbau', 'Winterthur ZH', 2022, 5, 1 UNION ALL
    SELECT 'Industriepark Glattbrugg', 'Rohrleitungsbau und Sanitärmontage für einen modernen Industriekomplex. STOClick-Systeme und komplexe Leitungsführung.', 'Industriebau', 'Glattbrugg ZH', 2024, 6, 1
) AS seed
WHERE NOT EXISTS (SELECT 1 FROM ref_items LIMIT 1);

-- 3) Bestehende Sektionen vom Typ "references-grid" zuruecksetzen:
--    items auf leeres Array → Template faellt auf Global-Pool zurueck
UPDATE sections
SET content = JSON_SET(COALESCE(content, JSON_OBJECT()), '$.items', JSON_ARRAY())
WHERE type = 'references-grid';

-- ============================================
-- Fertig! Verwaltung unter /admin/references
-- Die gleichen Referenzen erscheinen auf Startseite, Referenzen und ueberall,
-- wo eine references-grid-Sektion eingebunden ist.
-- ============================================
