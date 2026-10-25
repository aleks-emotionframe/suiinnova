-- ============================================
-- SUI Innova GmbH — Karriere-Modul
-- ============================================
-- 1) Roten Info-Streifen auf der Startseite deaktivieren
--    (Inhalt wandert in den Header)
-- 2) Neue Tabelle "applications" fuer Bewerbungen
-- 3) Default-Settings fuer den Karriere-Banner
-- ============================================

-- ── 1) Info-Banner auf der Startseite deaktivieren ──
UPDATE sections
SET is_active = 0
WHERE page_id = (SELECT id FROM pages WHERE is_homepage = 1 LIMIT 1)
  AND type = 'info-banner';

-- ── 2) Applications-Tabelle anlegen ──
CREATE TABLE IF NOT EXISTS applications (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(255) NOT NULL,
    email       VARCHAR(255) NOT NULL,
    phone       VARCHAR(50)  DEFAULT NULL,
    position    VARCHAR(255) DEFAULT NULL,
    message     TEXT         DEFAULT NULL,
    files       TEXT         DEFAULT NULL,   -- JSON-Array mit Datei-Pfaden
    is_read     TINYINT(1)   NOT NULL DEFAULT 0,
    created_at  DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_created (created_at DESC),
    INDEX idx_is_read (is_read)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── 3) Default-Settings ──
INSERT INTO settings (setting_key, setting_val, group_name)
SELECT 'career_visible', '1', 'career'
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM settings WHERE setting_key = 'career_visible');

INSERT INTO settings (setting_key, setting_val, group_name)
SELECT 'career_text', 'Wir suchen Verstärkung! GIS-Element-Monteur gesucht.', 'career'
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM settings WHERE setting_key = 'career_text');

INSERT INTO settings (setting_key, setting_val, group_name)
SELECT 'career_button_text', 'Jetzt bewerben', 'career'
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM settings WHERE setting_key = 'career_button_text');

INSERT INTO settings (setting_key, setting_val, group_name)
SELECT 'career_email', '', 'career'
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM settings WHERE setting_key = 'career_email');

INSERT INTO settings (setting_key, setting_val, group_name)
SELECT 'career_position', 'GIS-Element-Monteur (m/w/d)', 'career'
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM settings WHERE setting_key = 'career_position');

INSERT INTO settings (setting_key, setting_val, group_name)
SELECT 'career_intro', 'Schicken Sie uns Ihre Bewerbung – wir freuen uns darauf, Sie kennenzulernen. Bitte Lebenslauf und relevante Zeugnisse beilegen.', 'career'
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM settings WHERE setting_key = 'career_intro');

-- ============================================
-- Fertig!
-- ============================================
