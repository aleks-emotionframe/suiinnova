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
(1, 'hero', 'Präzision in jeder Verbindung', 'GIS-Elemente, Rohrleitungsbau, Sanitärvorwände & mehr', 'Ihr zuverlässiger Partner für die Vorfabrikation und Montage von GIS-Elementen, Duofix-Vorwänden, Beplankungen, AquaPanel und Rohrleitungsbau – termingerecht und in der ganzen Schweiz.', 1),
(1, 'intro', 'Ihr Spezialist für Sanitär-Vorfabrikation', 'Über uns', 'Mit langjähriger Erfahrung und einem eingespielten Team realisieren wir anspruchsvolle Projekte in der ganzen Schweiz. Von der Vorfabrikation in unserer Werkstatt bis zur Montage auf der Baustelle – alles aus einer Hand.\n\nUnsere Stärke liegt in der effizienten Vorfertigung, die Bauzeiten verkürzt und Kosten optimiert – ohne Kompromisse bei der Qualität.', 2),
(1, 'quote', NULL, NULL, '«Qualität ist kein Zufall – sie ist das Ergebnis von Erfahrung, Präzision und Leidenschaft.»', 3),
(1, 'services_header', 'Was wir für Sie tun', NULL, 'Von der Planung bis zur Fertigstellung – wir bieten Ihnen das komplette Leistungsspektrum im Bereich Sanitär-Vorfabrikation und Montage.', 4),
(1, 'service_vorfab', 'Vorfabrikation', NULL, 'In unserer Werkstatt fertigen wir massgeschneiderte Komponenten, die auf der Baustelle effizient und präzise installiert werden.', 5),
(1, 'service_montage', 'Montage vor Ort', NULL, 'Unser erfahrenes Team sorgt für die fachgerechte Installation direkt auf der Baustelle – von der Vorwand bis zur Spachtelung.', 6),
(1, 'details_header', 'Komplettlösungen aus einer Hand', NULL, 'Von der Vorfabrikation bis zur fertigen Oberfläche – wir decken alle Gewerke im Bereich Sanitärinstallation ab.', 7),
(1, 'detail_gis', 'GIS-Elemente', NULL, 'Vorfabrikation und Montage von Geberit Installationssystemen – normgerecht, präzise und bereit für die schnelle Baustellenmontage.', 8),
(1, 'detail_rohr', 'Rohrleitungsbau', NULL, 'Professioneller Leitungsbau für Trinkwasser, Heizung und Abwasser. Alle Materialien, alle Verbindungstechniken.', 9),
(1, 'detail_sto', 'STOClick', NULL, 'Schnell- und Sicherheitsbefestigung für optimierte Baustellenabläufe. Effizient vorgefertigt in unserer Werkstatt.', 10),
(1, 'detail_duofix', 'Duofix & Vorwände', NULL, 'Montage aller Sanitärvorwandsysteme – Geberit Duofix und weitere. Auch geschweisste Ausführungen.', 11),
(1, 'detail_beplan', 'Beplankungen', NULL, '1x 18mm oder 2x 12.5mm – professionelle Beplankung von Vorwandinstallationen für perfekte Oberflächen.', 12),
(1, 'detail_aqua', 'AquaPanel', NULL, 'Zementgebundene Bauplatten für Feuchträume. Geberit AquaPanel und AquaPanel 2x 12mm – dauerhaft und belastbar.', 13),
(1, 'why_header', 'Ihr Vorteil mit uns', NULL, 'Wir kombinieren handwerkliches Können mit effizienter Vorfabrikation. Das Ergebnis: kürzere Bauzeiten, tiefere Kosten und konstant hohe Qualität.', 14),
(1, 'why_1', 'Kostensicherheit', NULL, 'Transparente Preise und präzise Kalkulationen – keine Überraschungen.', 15),
(1, 'why_2', 'Termintreue', NULL, 'Durch Vorfabrikation verkürzen wir die Bauzeit um bis zu 40%.', 16),
(1, 'why_3', 'Erstklassige Qualität', NULL, 'Qualitätskontrolle in jeder Phase – von der Werkstatt bis zur Abnahme.', 17),
(1, 'why_4', 'Ein Team – ein Ansprechpartner', NULL, 'Von der Beratung bis zur Abnahme haben Sie einen persönlichen Projektleiter.', 18),
(1, 'karriere', '<strong>Werde Teil unseres Teams</strong> – und bewege Grosses', NULL, 'Unsere Mitarbeitenden sind das Fundament unseres Erfolgs. Wir bieten ein Arbeitsumfeld, in dem Respekt, Teamgeist und Eigenverantwortung gelebt werden – und in dem sich alle Mitarbeitenden wertgeschätzt fühlen.\n\nEntdecke die Chancen bei SUI Innova und gestalte die Zukunft der Gebäudetechnik aktiv mit. Wir suchen motivierte Fachkräfte, die mit Leidenschaft dabei sind.', 19),
(1, 'cta', 'Ihr nächstes Projekt?', NULL, 'Kontaktieren Sie uns für eine unverbindliche Beratung. Wir freuen uns auf Ihre Anfrage.', 20);

-- Content for Kompetenzen
INSERT INTO `content_blocks` (`page_id`, `section_key`, `title`, `subtitle`, `content`, `sort_order`) VALUES
(2, 'page_title', 'Vorfabrikation & Montage', NULL, 'Ein Ansprechpartner, durchgängige Qualität, optimierte Abläufe – von der Werkstatt bis zur fertigen Oberfläche.', 1),
(2, 'vorfab_header', 'Präzision aus der Werkstatt', NULL, 'In unserer Werkstatt fertigen wir massgeschneiderte Komponenten, die auf der Baustelle effizient installiert werden. Das spart Zeit, senkt Kosten und garantiert gleichbleibende Qualität.', 2),
(2, 'vorfab_gis', 'GIS-Elemente', NULL, 'Geberit Installationssysteme massgenau vorfabriziert – bereit für die schnelle Montage.', 3),
(2, 'vorfab_rohr', 'Rohrleitungsbau', NULL, 'Trinkwasser, Heizung, Abwasser – alle Materialien und Verbindungstechniken nach SIA-Normen.', 4),
(2, 'vorfab_sto', 'STOClick', NULL, 'Schnellmontage-System für sichere Befestigung und optimierte Baustellenabläufe.', 5),
(2, 'montage_header', 'Fachgerecht auf der Baustelle', NULL, 'Unser erfahrenes Team montiert direkt vor Ort – von der Vorwandinstallation bis zur fertigen Oberfläche, koordiniert mit allen Gewerken.', 6),
(2, 'montage_duofix', 'Duofix & Vorwände', NULL, 'Geberit Duofix, geschweisste Vorwände und alle gängigen Sanitärvorwandsysteme.', 7),
(2, 'montage_beplan', 'Beplankungen & AquaPanel', NULL, '1x 18mm oder 2x 12.5mm Platten. AquaPanel 2x 12mm für Feuchträume.', 8),
(2, 'montage_spachtel', 'Spachtelungen', NULL, 'Fachgerechte Spachtelungen und Ausflockungen – bereit für Fliesen oder Anstrich.', 9),
(2, 'details_header', 'Alle Leistungen auf einen Blick', NULL, NULL, 10),
(2, 'detail_gis', 'GIS-Elemente vorfabrizieren', NULL, 'Geberit Installationssysteme massgenau in der Werkstatt vorbereiten. Qualitätskontrolle vor Auslieferung, termingerechte Lieferung.', 11),
(2, 'detail_gis_montage', 'GIS-Elemente montieren', NULL, 'Fachgerechte Montage nach Herstellervorgaben direkt auf der Baustelle. Koordiniert mit allen beteiligten Gewerken.', 12),
(2, 'detail_rohr', 'Rohrleitungsbau', NULL, 'Trinkwasser-, Heizungs- und Abwasserleitungen. Edelstahl, Kupfer, Kunststoff – alle Verbindungstechniken nach SIA-Normen.', 13),
(2, 'detail_sto', 'STOClick', NULL, 'Schnellmontage-System für sichere Befestigung. Effiziente Vorfabrikation verkürzt Montagezeiten auf der Baustelle.', 14),
(2, 'detail_duofix', 'Duofix & Vorwände', NULL, 'Geberit Duofix und alle gängigen Sanitärvorwandsysteme – auch geschweisst. Für Wohnbau, Gewerbe und Spitäler.', 15),
(2, 'detail_beplan', 'Beplankungen', NULL, 'Vorwände beplanken mit 1x 18mm oder 2x 12.5mm Platten. Saubere Ausführung für perfekte Oberflächen.', 16),
(2, 'detail_aqua', 'AquaPanel', NULL, 'Geberit AquaPanel 2x 12mm für Feuchträume. Zementgebundene Bauplatten – wasserfest, schimmelfrei, dauerhaft.', 17),
(2, 'detail_spachtel', 'Spachtelungen & Ausflockungen', NULL, 'Fachgerechte Spachtelungen an Vorwänden. Perfekte Oberflächen, bereit für Fliesen, Putz oder Anstrich.', 18),
(2, 'cta', 'Haben Sie ein Projekt?', NULL, 'Wir beraten Sie gerne – von der Vorfabrikation bis zur Montage.', 19);

-- Content for Unternehmen
INSERT INTO `content_blocks` (`page_id`, `section_key`, `title`, `subtitle`, `content`, `sort_order`) VALUES
(4, 'page_title', 'Über die SUI Innova GmbH', NULL, 'Qualität, Zuverlässigkeit und Leidenschaft für die Gebäudetechnik – das ist SUI Innova.', 1),
(4, 'about', 'Über uns', 'SUI Innova GmbH', 'Die SUI Innova GmbH ist ein führendes Unternehmen im Bereich der Vorfabrikation und Montage von Sanitärinstallationen. Mit über 85 Fachkräften und langjähriger Erfahrung realisieren wir anspruchsvolle Projekte in der ganzen Schweiz.\n\nVon der Planung über die Vorfabrikation in unserer modernen Werkstatt bis zur fachgerechten Montage auf der Baustelle bieten wir alles aus einer Hand. Dabei setzen wir auf höchste Qualitätsstandards, termingerechte Ausführung und eine partnerschaftliche Zusammenarbeit mit unseren Kunden.', 2),
(4, 'values', 'Unsere Werte', NULL, 'Diese Grundsätze leiten unser tägliches Handeln und bilden das Fundament unserer Arbeit.', 3),
(4, 'value_1', 'Präzision', NULL, 'Höchste Genauigkeit in jeder Vorfabrikation und Montage – für dauerhaft zuverlässige Installationen.', 4),
(4, 'value_2', 'Zuverlässigkeit', NULL, 'Termingerecht und verantwortungsbewusst. Unsere Kunden können sich auf uns verlassen.', 5),
(4, 'value_3', 'Innovation', NULL, 'Moderne Fertigungstechnologien und effiziente Arbeitsabläufe für bessere Ergebnisse.', 6),
(4, 'value_4', 'Teamarbeit', NULL, 'Gemeinsam stark – unsere Teams arbeiten Hand in Hand für den Projekterfolg.', 7),
(4, 'quality', 'Qualitätsmanagement', NULL, 'Qualität ist kein Zufall, sondern das Ergebnis konsequenter Prozesse und hoher Ansprüche. Unser Qualitätsmanagement stellt sicher, dass jedes Projekt unseren Standards entspricht.', 8),
(4, 'team', 'Unser Team', NULL, 'Über 85 engagierte Fachkräfte bilden das Rückgrat unseres Unternehmens. Mit Erfahrung, Fachwissen und Teamgeist meistern wir jede Herausforderung.', 9),
(4, 'cta', 'Teil unseres Teams werden?', NULL, 'Wir suchen engagierte Fachkräfte. Kontaktieren Sie uns für offene Stellen.', 10);

-- Content for Kontakt
INSERT INTO `content_blocks` (`page_id`, `section_key`, `title`, `subtitle`, `content`, `sort_order`) VALUES
(5, 'page_title', 'Kontaktieren Sie uns', NULL, 'Wir freuen uns auf Ihre Anfrage. Kontaktieren Sie uns für eine unverbindliche Beratung.', 1),
(5, 'form_header', 'Schreiben Sie uns', NULL, NULL, 2),
(5, 'info_header', 'Kontaktdaten', NULL, NULL, 3);

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
('site_hours', 'Mo – Fr: 07:00 – 17:00 Uhr', 'general'),
('contact_email', 'info@suiinnova.ch', 'contact'),
('google_maps_embed', '', 'contact'),
('maintenance_mode', '0', 'system'),
('maintenance_title', 'Wartungsarbeiten', 'system'),
('maintenance_message', 'Unsere Website wird gerade aktualisiert. Wir sind in Kürze wieder für Sie da.', 'system');
