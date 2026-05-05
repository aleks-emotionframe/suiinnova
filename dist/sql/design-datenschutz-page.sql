-- ============================================
-- SUI Innova GmbH — Datenschutz-Seite
-- ============================================
-- Inhalt: massgeschneidert auf das, was die Website tatsaechlich erhebt:
-- - Kontaktformular (contacts-Tabelle)
-- - Bewerbungen (applications-Tabelle, mit Datei-Uploads)
-- - DSGVO-konformes Visit-Tracking (gehashte IP)
-- - Nur Session-Cookies fuer Admin-Login (keine Tracker)
-- - Hosting bei Hostpoint AG (Schweiz)
--
-- ⚠️ Hinweis: Dies ist eine solide Basis-Datenschutzerklaerung.
-- Fuer rechtliche Vollstaendigkeit empfehlen wir eine Pruefung durch einen
-- Datenschutzberater oder die Verwendung eines Generators wie webkoenig.ch.
--
-- Idempotent: SQL kann beliebig oft ausgefuehrt werden.
-- ============================================

-- 1) Seite sicherstellen
INSERT INTO pages (title, slug, meta_title, meta_desc, is_active, is_homepage, sort_order, created_at, updated_at)
SELECT 'Datenschutz', 'datenschutz', 'Datenschutzerklärung',
       'Datenschutzerklärung der SUI Innova GmbH – Informationen zur Verarbeitung personenbezogener Daten gemäss DSG/DSGVO.',
       1, 0, 51, NOW(), NOW()
FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE slug = 'datenschutz');

SET @page_id = (SELECT id FROM pages WHERE slug = 'datenschutz' LIMIT 1);

-- 2) Sektionen ersetzen
DELETE FROM sections WHERE page_id = @page_id;

INSERT INTO sections (page_id, type, content, sort_order, is_active, created_at, updated_at) VALUES

-- ── 1) PARALLAX-BANNER ──────────────
(
    @page_id,
    'parallax-image',
    JSON_OBJECT(
        'image_id',     0,
        'image_url',    '/assets/img/parallax-werkstatt.jpg',
        'height',       'medium',
        'overlay_text', ''
    ),
    1, 1, NOW(), NOW()
),

-- ── 2) DATENSCHUTZ-TEXT ──────────────
(
    @page_id,
    'text-block',
    JSON_OBJECT(
        'heading',   'Datenschutzerklärung',
        'body',      '<h2>Allgemeines</h2><p>Diese Datenschutzerklärung informiert Sie darüber, welche Daten wir auf unserer Website erheben, zu welchem Zweck wir diese verwenden und welche Rechte Sie diesbezüglich haben. Wir behandeln Ihre persönlichen Daten vertraulich und gemäss dem Schweizer Datenschutzgesetz (DSG) sowie der EU-Datenschutz-Grundverordnung (DSGVO), soweit diese auf uns Anwendung findet.</p><h2>Verantwortliche Stelle</h2><p>Verantwortlich für die Verarbeitung der personenbezogenen Daten auf dieser Website ist:<br><br>SUI Innova GmbH<br>Talstrasse 31<br>8808 Pfäffikon SZ<br>Schweiz<br>info@sui-innova.ch<br>+41 55 420 19 90</p><h2>Server-Logfiles und Besuchsstatistik</h2><p>Beim Aufruf unserer Website werden technisch notwendige Daten verarbeitet (besuchte Seite, Browsertyp, Referrer-URL, anonymisierte IP-Adresse, Zeitpunkt des Zugriffs). Diese Daten werden ausschliesslich zur Sicherstellung des Betriebs und zur statistischen Auswertung verwendet.</p><p>Die IP-Adresse wird vor der Speicherung kryptographisch gehasht und kann nicht zurückgeführt werden. Eine Identifizierung einzelner Besucher ist damit nicht möglich.</p><h2>Kontaktformular</h2><p>Wenn Sie uns über das Kontaktformular eine Nachricht senden, werden die von Ihnen eingegebenen Daten (Name, E-Mail-Adresse, Telefon, Firma, Nachricht) zur Bearbeitung Ihrer Anfrage und für eventuelle Anschlussfragen gespeichert. Diese Daten werden nicht an Dritte weitergegeben.</p><p>Rechtsgrundlage ist Ihre Einwilligung sowie unser berechtigtes Interesse an der Beantwortung Ihrer Anfrage.</p><h2>Bewerbungen</h2><p>Wenn Sie sich über unser Bewerbungsformular bewerben, werden Ihre Angaben (Name, E-Mail, Telefon, Nachricht) sowie die hochgeladenen Dokumente (Lebenslauf, Zeugnisse, etc.) ausschliesslich zur Bearbeitung Ihrer Bewerbung verwendet.</p><p>Wir speichern Ihre Bewerbungsunterlagen für die Dauer des Bewerbungsverfahrens und löschen sie spätestens 6 Monate nach dessen Abschluss, sofern Sie nicht ausdrücklich einer längeren Aufbewahrung für künftige Stellenangebote zustimmen.</p><h2>Cookies</h2><p>Unsere Website verwendet ausschliesslich technisch notwendige Cookies. Konkret:</p><p><strong>Session-Cookie</strong> für eingeloggte Administratoren — wird beim Schliessen des Browsers oder spätestens nach 2 Stunden Inaktivität gelöscht.</p><p>Es werden keine Tracking-, Werbe- oder Analyse-Cookies eingesetzt. Es findet kein Profiling statt.</p><h2>Hosting</h2><p>Unsere Website wird gehostet bei:<br><br>Hostpoint AG<br>Neue Jonastrasse 60<br>8640 Rapperswil<br>Schweiz</p><p>Sämtliche Daten werden ausschliesslich auf Servern in der Schweiz gespeichert. Es findet keine Datenübermittlung in Drittländer statt.</p><h2>Weitergabe an Dritte</h2><p>Eine Weitergabe Ihrer persönlichen Daten an Dritte findet grundsätzlich nicht statt, ausser wir sind hierzu gesetzlich verpflichtet oder es ist zur Vertragserfüllung erforderlich (z.B. Versand einer Auftragsbestätigung).</p><h2>Rechte der betroffenen Personen</h2><p>Sie haben jederzeit das Recht auf:</p><p><strong>Auskunft</strong> über die zu Ihrer Person gespeicherten Daten<br><strong>Berichtigung</strong> unrichtiger Daten<br><strong>Löschung</strong> Ihrer Daten, soweit keine gesetzliche Aufbewahrungspflicht besteht<br><strong>Einschränkung der Verarbeitung</strong><br><strong>Widerspruch</strong> gegen die Verarbeitung<br><strong>Datenübertragbarkeit</strong></p><p>Bei Fragen oder zur Ausübung Ihrer Rechte wenden Sie sich an: info@sui-innova.ch</p><h2>Datensicherheit</h2><p>Die Übertragung von Daten zwischen Ihrem Browser und unserer Website erfolgt verschlüsselt via HTTPS (TLS). Wir treffen geeignete technische und organisatorische Massnahmen, um Ihre Daten vor unberechtigtem Zugriff, Verlust, Missbrauch oder Manipulation zu schützen.</p><h2>Änderungen dieser Datenschutzerklärung</h2><p>Wir behalten uns vor, diese Datenschutzerklärung jederzeit anzupassen, um sie an geänderte Rechtslagen oder bei Änderungen unserer Dienstleistungen zu aktualisieren. Es gilt jeweils die zum Zeitpunkt Ihres Besuches abrufbare Fassung.</p><h2>Kontakt bei Fragen zum Datenschutz</h2><p>Bei Fragen zur Verarbeitung Ihrer persönlichen Daten oder zu dieser Datenschutzerklärung wenden Sie sich bitte an:<br><br>SUI Innova GmbH<br>Talstrasse 31<br>8808 Pfäffikon SZ<br>info@sui-innova.ch<br>+41 55 420 19 90</p><h2>Stand</h2><p>Diese Datenschutzerklärung wurde zuletzt am 5. Mai 2026 aktualisiert.</p>',
        'alignment', 'left'
    ),
    2, 1, NOW(), NOW()
);

-- ============================================
-- Fertig! Aufruf https://sui-innova.ch/datenschutz
-- Footer-Link ist bereits vorhanden.
-- ============================================
