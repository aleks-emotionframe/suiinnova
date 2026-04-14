-- SUI Innova GmbH - Database Schema
-- For MySQL 5.7+ / MariaDB 10.3+

SET NAMES utf8mb4;
SET CHARACTER SET utf8mb4;

CREATE DATABASE IF NOT EXISTS `suiinnova` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `suiinnova`;

-- Admin users
CREATE TABLE IF NOT EXISTS `users` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(50) NOT NULL UNIQUE,
    `email` VARCHAR(100) NOT NULL UNIQUE,
    `password_hash` VARCHAR(255) NOT NULL,
    `display_name` VARCHAR(100) DEFAULT NULL,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `last_login` DATETIME DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Pages
CREATE TABLE IF NOT EXISTS `pages` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `slug` VARCHAR(100) NOT NULL UNIQUE,
    `title` VARCHAR(200) NOT NULL,
    `meta_description` VARCHAR(300) DEFAULT NULL,
    `meta_keywords` VARCHAR(200) DEFAULT NULL,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `is_in_nav` TINYINT(1) NOT NULL DEFAULT 1,
    `sort_order` INT NOT NULL DEFAULT 0,
    `template` VARCHAR(50) DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Content blocks (flexible content per page section)
CREATE TABLE IF NOT EXISTS `content_blocks` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `page_id` INT UNSIGNED NOT NULL,
    `section_key` VARCHAR(50) NOT NULL,
    `title` VARCHAR(300) DEFAULT NULL,
    `subtitle` VARCHAR(300) DEFAULT NULL,
    `content` TEXT DEFAULT NULL,
    `image_path` VARCHAR(500) DEFAULT NULL,
    `link_url` VARCHAR(500) DEFAULT NULL,
    `link_text` VARCHAR(100) DEFAULT NULL,
    `extra_data` JSON DEFAULT NULL,
    `sort_order` INT NOT NULL DEFAULT 0,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`page_id`) REFERENCES `pages`(`id`) ON DELETE CASCADE,
    INDEX `idx_page_section` (`page_id`, `section_key`),
    INDEX `idx_sort` (`sort_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- References / Projects
CREATE TABLE IF NOT EXISTS `references_projects` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(200) NOT NULL,
    `slug` VARCHAR(200) NOT NULL UNIQUE,
    `description` TEXT DEFAULT NULL,
    `client` VARCHAR(200) DEFAULT NULL,
    `location` VARCHAR(200) DEFAULT NULL,
    `year` YEAR DEFAULT NULL,
    `category` VARCHAR(100) DEFAULT NULL,
    `image_path` VARCHAR(500) DEFAULT NULL,
    `gallery_images` JSON DEFAULT NULL,
    `is_featured` TINYINT(1) NOT NULL DEFAULT 0,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `sort_order` INT NOT NULL DEFAULT 0,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_category` (`category`),
    INDEX `idx_featured` (`is_featured`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Site settings (key-value)
CREATE TABLE IF NOT EXISTS `settings` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `setting_key` VARCHAR(100) NOT NULL UNIQUE,
    `setting_value` TEXT DEFAULT NULL,
    `setting_group` VARCHAR(50) DEFAULT 'general',
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Contact form messages
CREATE TABLE IF NOT EXISTS `contact_messages` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `phone` VARCHAR(30) DEFAULT NULL,
    `company` VARCHAR(100) DEFAULT NULL,
    `subject` VARCHAR(200) DEFAULT NULL,
    `message` TEXT NOT NULL,
    `is_read` TINYINT(1) NOT NULL DEFAULT 0,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================
-- Default Data
-- =====================

-- Default admin user (password: SuiInnova2024! — CHANGE IMMEDIATELY)
INSERT INTO `users` (`username`, `email`, `password_hash`, `display_name`) VALUES
('admin', 'info@suiinnova.ch', '$2y$12$LJ3m4yPnVMDZYEYMvqSXneUBMbCR2JtMbVJKfGE0XGYrYK4qCzNDi', 'Administrator');

-- Default pages
INSERT INTO `pages` (`slug`, `title`, `meta_description`, `is_in_nav`, `sort_order`, `template`) VALUES
('startseite', 'Startseite', 'SUI Innova GmbH – Ihr Partner für Vorfabrikation und Montage im Sanitärbereich. Qualität, Präzision und Zuverlässigkeit.', 1, 1, 'home'),
('kompetenzen', 'Kompetenzen', 'Unsere Kompetenzen: Vorfabrikation von GIS-Elementen, Rohrleitungsbau, STOClick sowie Montage vor Ort.', 1, 2, 'kompetenzen'),
('referenzen', 'Referenzen', 'Ausgewählte Referenzprojekte der SUI Innova GmbH – Qualitätsarbeit in der ganzen Schweiz.', 1, 3, 'referenzen'),
('unternehmen', 'Unternehmen', 'Über die SUI Innova GmbH – Erfahrung, Kompetenz und Leidenschaft für Gebäudetechnik.', 1, 4, 'unternehmen'),
('kontakt', 'Kontakt', 'Kontaktieren Sie die SUI Innova GmbH – Wir freuen uns auf Ihre Anfrage.', 1, 5, 'kontakt');

-- Default content blocks for Startseite
INSERT INTO `content_blocks` (`page_id`, `section_key`, `title`, `subtitle`, `content`, `sort_order`) VALUES
(1, 'hero', 'Präzision in jeder Verbindung', 'Vorfabrikation & Montage für die Gebäudetechnik', 'Wir sind Ihr zuverlässiger Partner für die Vorfabrikation und Montage von Sanitärinstallationen – termingerecht, qualitätsbewusst und effizient.', 1),
(1, 'intro', 'SUI Innova GmbH', 'Ihr Spezialist für Sanitär-Vorfabrikation', 'Mit langjähriger Erfahrung und einem eingespielten Team realisieren wir anspruchsvolle Projekte in der ganzen Schweiz. Von der Vorfabrikation in unserer Werkstatt bis zur Montage auf der Baustelle – alles aus einer Hand.', 2),
(1, 'service_1', 'Vorfabrikation', NULL, 'GIS-Elemente, Rohrleitungsbau und STOClick – präzise vorgefertigt in unserer Werkstatt für höchste Qualität und Effizienz auf der Baustelle.', 3),
(1, 'service_2', 'Montage vor Ort', NULL, 'Fachgerechte Montage von GIS-Elementen, Duofix, Vorwandsystemen, Beplankungen, AquaPanel und Spachtelarbeiten – alles aus einer Hand.', 4),
(1, 'service_3', 'Qualität & Termintreue', NULL, 'Zuverlässige Ausführung, termingerechte Lieferung und höchste Qualitätsstandards – darauf können Sie sich verlassen.', 5),
(1, 'figures_employees', '85+', 'Fachkräfte', 'Erfahrene Spezialisten im Einsatz', 6),
(1, 'figures_projects', '500+', 'Projekte', 'Erfolgreich realisierte Projekte', 7),
(1, 'figures_years', '15+', 'Jahre', 'Erfahrung in der Branche', 8),
(1, 'cta', 'Ihr nächstes Projekt?', NULL, 'Kontaktieren Sie uns für eine unverbindliche Beratung. Wir freuen uns auf Ihre Anfrage.', 9);

-- Content for Kompetenzen
INSERT INTO `content_blocks` (`page_id`, `section_key`, `title`, `subtitle`, `content`, `sort_order`) VALUES
(2, 'hero', 'Unsere Kompetenzen', NULL, 'Von der Werkstatt auf die Baustelle – wir beherrschen das gesamte Spektrum der Sanitär-Vorfabrikation und -Montage.', 1),
(2, 'vorfabrikation_intro', 'Vorfabrikation', 'Präzision aus der Werkstatt', 'In unserer modern ausgestatteten Werkstatt fertigen wir Komponenten vor, die auf der Baustelle zeit- und kostensparend installiert werden können. Höchste Qualitätsstandards und massgeschneiderte Lösungen sind dabei selbstverständlich.', 2),
(2, 'vorfab_gis', 'GIS-Elemente', NULL, 'Vorfabrikation von GIS-Installationssystemen für eine effiziente und normgerechte Sanitärinstallation. Unsere vorgefertigten GIS-Elemente garantieren eine schnelle Montage und gleichbleibend hohe Qualität.', 3),
(2, 'vorfab_rohr', 'Rohrleitungsbau', NULL, 'Professioneller Rohrleitungsbau für Trinkwasser-, Heizungs- und Abwasserleitungen. Wir verarbeiten alle gängigen Materialien und Verbindungstechniken nach aktuellen Normen und Vorschriften.', 4),
(2, 'vorfab_sto', 'STOClick', NULL, 'STOClick Montagesystem für eine schnelle und sichere Befestigung. Effiziente Vorfabrikation für optimierte Baustellenabläufe.', 5),
(2, 'montage_intro', 'Montage vor Ort', 'Fachgerecht und termingerecht', 'Unser erfahrenes Montageteam sorgt für die fachgerechte Installation direkt auf der Baustelle. Von der Vorwandinstallation bis zur fertigen Spachtelung – wir liefern Qualität aus einer Hand.', 6),
(2, 'montage_gis', 'GIS-Elemente', NULL, 'Fachgerechte Montage von GIS-Installationselementen nach Herstellervorgaben. Schnell, präzise und zuverlässig.', 7),
(2, 'montage_duofix', 'Duofix & Vorwandsysteme', NULL, 'Montage von Geberit Duofix und allen gängigen Sanitärvorwandsystemen – auch geschweisste Ausführungen. Für jede Anforderung die passende Lösung.', 8),
(2, 'montage_beplan', 'Beplankungen', NULL, 'Professionelle Beplankung von Vorwandinstallationen mit 1x 18mm oder 2x 12.5mm Platten. Saubere Ausführung für perfekte Oberflächen.', 9),
(2, 'montage_aqua', 'Geberit AquaPanel', NULL, 'Montage von Geberit AquaPanel und AquaPanel 2x 12mm – die ideale Lösung für Feuchträume. Zementgebundene Bauplatten für dauerhafte Qualität.', 10),
(2, 'montage_spachtel', 'Spachtelungen & Ausflockungen', NULL, 'Fachgerechte Spachtelungen an Vorwänden und Ausflockungen für eine perfekte Oberfläche. Bereit für Fliesen, Putz oder Anstrich.', 11);

-- Content for Unternehmen
INSERT INTO `content_blocks` (`page_id`, `section_key`, `title`, `subtitle`, `content`, `sort_order`) VALUES
(4, 'hero', 'Unser Unternehmen', NULL, 'Qualität, Zuverlässigkeit und Leidenschaft für die Gebäudetechnik – das ist SUI Innova.', 1),
(4, 'about', 'Über uns', 'SUI Innova GmbH', 'Die SUI Innova GmbH ist ein spezialisiertes Unternehmen im Bereich der Sanitär-Vorfabrikation und -Montage. Mit einem Team aus erfahrenen Fachkräften realisieren wir Projekte jeder Grösse – von Wohnbauten bis zu komplexen Gewerbebauten. Unser Anspruch: höchste Qualität, termingerechte Ausführung und eine partnerschaftliche Zusammenarbeit mit unseren Kunden.', 2),
(4, 'values', 'Unsere Werte', NULL, 'Qualität, Zuverlässigkeit, Innovation und Teamarbeit bilden das Fundament unseres Unternehmens. Wir investieren kontinuierlich in die Weiterbildung unserer Mitarbeitenden und in moderne Fertigungstechnologien.', 3),
(4, 'quality', 'Qualitätsmanagement', NULL, 'Strenge Qualitätskontrollen in jeder Projektphase garantieren die Einhaltung aller relevanten Normen und Standards. Von der Vorfabrikation bis zur finalen Abnahme – Qualität ist bei uns kein Zufall.', 4),
(4, 'team', 'Unser Team', NULL, 'Unser grösstes Kapital sind unsere Mitarbeitenden. Erfahrene Projektleiter, qualifizierte Monteure und engagierte Fachkräfte arbeiten Hand in Hand für den Erfolg jedes Projekts.', 5);

-- Content for Kontakt
INSERT INTO `content_blocks` (`page_id`, `section_key`, `title`, `subtitle`, `content`, `sort_order`) VALUES
(5, 'hero', 'Kontakt', NULL, 'Wir freuen uns auf Ihre Anfrage. Kontaktieren Sie uns für eine unverbindliche Beratung.', 1),
(5, 'address', 'SUI Innova GmbH', 'Standort', 'Musterstrasse 42\n8000 Zürich\nSchweiz', 2),
(5, 'phone', 'Telefon', NULL, '+41 44 000 00 00', 3),
(5, 'email', 'E-Mail', NULL, 'info@suiinnova.ch', 4),
(5, 'hours', 'Öffnungszeiten', NULL, 'Montag – Freitag: 07:00 – 17:00 Uhr', 5);

-- Default references/projects
INSERT INTO `references_projects` (`title`, `slug`, `description`, `client`, `location`, `year`, `category`, `is_featured`, `sort_order`) VALUES
('Wohnüberbauung Limmatfeld', 'wohnueberbauung-limmatfeld', 'Komplette Sanitär-Vorfabrikation und Montage für eine Grossüberbauung mit 120 Wohneinheiten. GIS-Elemente, Vorwandsysteme und Beplankungen.', 'Implenia AG', 'Dietikon ZH', 2024, 'Wohnbau', 1, 1),
('Geschäftshaus Europaallee', 'geschaeftshaus-europaallee', 'Vorfabrikation und Montage von Sanitärinstallationen im modernen Geschäftshaus. Hohe Anforderungen an Termintreue und Koordination.', 'HRS Real Estate AG', 'Zürich', 2023, 'Gewerbebau', 1, 2),
('Spital Limmattal Erweiterung', 'spital-limmattal-erweiterung', 'Spezialisierte Sanitärinstallationen im Spitalbau. AquaPanel-Montage und Vorwandsysteme in Nassräumen und OP-Bereichen.', 'Spital Limmattal', 'Schlieren ZH', 2023, 'Spitalbau', 1, 3),
('Schulanlage Leutschenbach', 'schulanlage-leutschenbach', 'Sanitär-Vorfabrikation für den Neubau einer modernen Schulanlage. Effiziente GIS-Montage in enger Terminplanung.', 'Stadt Zürich', 'Zürich', 2024, 'Bildungsbau', 0, 4),
('Alterszentrum Grünau', 'alterszentrum-gruenau', 'Barrierefreie Sanitärinstallationen für 80 Pflegezimmer. Duofix-Systeme und spezielle Anforderungen an die Zugänglichkeit.', 'Stiftung Alterszentrum', 'Winterthur ZH', 2022, 'Gesundheitsbau', 0, 5),
('Industriepark Glattbrugg', 'industriepark-glattbrugg', 'Rohrleitungsbau und Sanitärmontage für einen modernen Industriekomplex. STOClick-Systeme und komplexe Leitungsführung.', 'Swiss Prime Site AG', 'Glattbrugg ZH', 2024, 'Industriebau', 1, 6);

-- Default settings
INSERT INTO `settings` (`setting_key`, `setting_value`, `setting_group`) VALUES
('site_name', 'SUI Innova GmbH', 'general'),
('site_tagline', 'Vorfabrikation & Montage für die Gebäudetechnik', 'general'),
('site_email', 'info@suiinnova.ch', 'general'),
('site_phone', '+41 44 000 00 00', 'general'),
('site_address', 'Musterstrasse 42, 8000 Zürich', 'general'),
('footer_text', '© SUI Innova GmbH. Alle Rechte vorbehalten.', 'general'),
('contact_email', 'info@suiinnova.ch', 'contact'),
('google_maps_embed', '', 'contact'),
('maintenance_mode', '0', 'system'),
('maintenance_title', 'Wartungsarbeiten', 'system'),
('maintenance_message', 'Unsere Website wird gerade aktualisiert. Wir sind in Kürze wieder für Sie da.', 'system');
