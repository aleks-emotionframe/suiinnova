-- ============================================================
-- SUI Innova CMS: Alle fehlenden Content-Blöcke einfügen
-- In phpMyAdmin ausfuehren (Tab "SQL")
-- ============================================================

-- Zuerst alle alten content_blocks loeschen
DELETE FROM content_blocks;

-- ============================================================
-- STARTSEITE (page_id = 1)
-- ============================================================
INSERT INTO content_blocks (page_id, section_key, title, subtitle, content, sort_order, is_active) VALUES
(1, 'hero', 'Präzision in jeder Verbindung', 'GIS-Elemente, Rohrleitungsbau, Sanitärvorwände & mehr', 'Ihr zuverlässiger Partner für die Vorfabrikation und Montage von GIS-Elementen, Duofix-Vorwänden, Beplankungen, AquaPanel und Rohrleitungsbau – termingerecht und in der ganzen Schweiz.', 1, 1),
(1, 'intro', 'Ihr Spezialist für Sanitär-Vorfabrikation', 'Über uns', 'Mit langjähriger Erfahrung und einem eingespielten Team realisieren wir anspruchsvolle Projekte in der ganzen Schweiz. Von der Vorfabrikation in unserer Werkstatt bis zur Montage auf der Baustelle – alles aus einer Hand.', 2, 1),
(1, 'intro_highlights', NULL, NULL, 'Schweizweit im Einsatz\nAlles aus einer Hand\nTermingerecht & zuverlässig', 3, 1),
(1, 'quote', NULL, NULL, '«Qualität ist kein Zufall – sie ist das Ergebnis von Erfahrung, Präzision und Leidenschaft.»', 4, 1),
(1, 'services_header', 'Was wir für Sie tun', NULL, 'Von der Planung bis zur Fertigstellung – wir bieten Ihnen das komplette Leistungsspektrum im Bereich Sanitär-Vorfabrikation und Montage.', 5, 1),
(1, 'service_vorfab', 'Vorfabrikation', NULL, 'In unserer Werkstatt fertigen wir massgeschneiderte Komponenten, die auf der Baustelle effizient und präzise installiert werden.', 6, 1),
(1, 'service_montage', 'Montage vor Ort', NULL, 'Unser erfahrenes Team sorgt für die fachgerechte Installation direkt auf der Baustelle – von der Vorwand bis zur Spachtelung.', 7, 1),
(1, 'details_header', 'Komplettlösungen aus einer Hand', NULL, 'Von der Vorfabrikation bis zur fertigen Oberfläche – wir decken alle Gewerke im Bereich Sanitärinstallation ab.', 8, 1),
(1, 'detail_gis', 'GIS-Elemente', NULL, 'Vorfabrikation und Montage von Geberit Installationssystemen – normgerecht, präzise und bereit für die schnelle Baustellenmontage.', 9, 1),
(1, 'detail_rohr', 'Rohrleitungsbau', NULL, 'Professioneller Leitungsbau für Trinkwasser, Heizung und Abwasser. Alle Materialien, alle Verbindungstechniken.', 10, 1),
(1, 'detail_sto', 'STOClick', NULL, 'Schnell- und Sicherheitsbefestigung für optimierte Baustellenabläufe. Effizient vorgefertigt in unserer Werkstatt.', 11, 1),
(1, 'detail_duofix', 'Duofix & Vorwände', NULL, 'Montage aller Sanitärvorwandsysteme – Geberit Duofix und weitere. Auch geschweisste Ausführungen.', 12, 1),
(1, 'detail_beplan', 'Beplankungen', NULL, '1x 18mm oder 2x 12.5mm – professionelle Beplankung von Vorwandinstallationen für perfekte Oberflächen.', 13, 1),
(1, 'detail_aqua', 'AquaPanel', NULL, 'Zementgebundene Bauplatten für Feuchträume. Geberit AquaPanel und AquaPanel 2x 12mm – dauerhaft und belastbar.', 14, 1),
(1, 'why_header', 'Ihr Vorteil mit uns', NULL, 'Wir kombinieren handwerkliches Können mit effizienter Vorfabrikation. Das Ergebnis: kürzere Bauzeiten, tiefere Kosten und konstant hohe Qualität.', 15, 1),
(1, 'why_1', 'Kostensicherheit', NULL, 'Transparente Preise und präzise Kalkulationen – keine Überraschungen.', 16, 1),
(1, 'why_2', 'Termintreue', NULL, 'Durch Vorfabrikation verkürzen wir die Bauzeit um bis zu 40%.', 17, 1),
(1, 'why_3', 'Erstklassige Qualität', NULL, 'Qualitätskontrolle in jeder Phase – von der Werkstatt bis zur Abnahme.', 18, 1),
(1, 'why_4', 'Ein Team – ein Ansprechpartner', NULL, 'Von der Beratung bis zur Abnahme haben Sie einen persönlichen Projektleiter.', 19, 1),
(1, 'karriere', 'Werde Teil unseres Teams – und bewege Grosses', NULL, 'Unsere Mitarbeitenden sind das Fundament unseres Erfolgs. Wir bieten ein Arbeitsumfeld, in dem Respekt, Teamgeist und Eigenverantwortung gelebt werden.\n\nEntdecke die Chancen bei SUI Innova und gestalte die Zukunft der Gebäudetechnik aktiv mit.', 20, 1),
(1, 'cta', 'Ihr nächstes Projekt?', NULL, 'Kontaktieren Sie uns für eine unverbindliche Beratung. Wir freuen uns auf Ihre Anfrage.', 21, 1),
(1, 'faq_1', 'Was bedeutet GIS-Elemente vorfabrizieren?', NULL, 'Beim GIS-Elemente vorfabrizieren werden Geberit Installationssysteme in unserer Werkstatt massgenau vorbereitet. Die fertigen GIS-Elemente werden anschliessend auf die Baustelle geliefert und dort montiert.', 22, 1),
(1, 'faq_2', 'Wie läuft die Montage von GIS-Elementen vor Ort ab?', NULL, 'Unsere Fachkräfte montieren die vorgefertigten GIS-Elemente direkt auf der Baustelle nach Herstellervorgaben. Die Montage umfasst die Befestigung, den Anschluss an bestehende Leitungen und die Qualitätskontrolle.', 23, 1),
(1, 'faq_3', 'Was umfasst euer Rohrleitungsbau?', NULL, 'Unser Rohrleitungsbau deckt Trinkwasser-, Heizungs- und Abwasserleitungen ab. Wir verarbeiten alle gängigen Materialien wie Edelstahl, Kupfer und Kunststoff.', 24, 1),
(1, 'faq_4', 'Was ist STOClick und wofür wird es eingesetzt?', NULL, 'STOClick ist ein innovatives Montagesystem für die schnelle und sichere Befestigung im Sanitärbereich. Wir setzen STOClick für effiziente Vorfabrikation ein.', 25, 1),
(1, 'faq_5', 'Welche Vorwandsysteme montiert ihr (Duofix, etc.)?', NULL, 'Wir montieren alle gängigen Sanitärvorwandsysteme: Geberit Duofix und weitere Varianten, sowie geschweisste Vorwände. Inkl. Beplankung, AquaPanel und Spachtelung.', 26, 1),
(1, 'faq_6', 'Was bedeutet Vorwände beplanken?', NULL, 'Vorwände beplanken bedeutet, die Sanitärvorwand-Konstruktion mit Platten zu verkleiden. Wir bieten Beplankungen mit 1x 18mm oder 2x 12.5mm Gipskartonplatten sowie Geberit AquaPanel.', 27, 1),
(1, 'faq_7', 'Wann ist AquaPanel die richtige Wahl?', NULL, 'AquaPanel von Geberit ist die ideale Lösung für Feuchträume wie Bäder und Duschen. Die zementgebundenen Bauplatten sind wasserfest, schimmelfrei und extrem belastbar.', 28, 1),
(1, 'faq_8', 'Was ist der Vorteil einer Sanitärvorwand-Vorfabrikation?', NULL, 'Sanitärvorwand vorfabrizieren spart bis zu 40% Bauzeit auf der Baustelle. Die Elemente werden unter kontrollierten Bedingungen gefertigt, was zu höherer Qualität führt.', 29, 1);

-- ============================================================
-- KOMPETENZEN (page_id = 2)
-- ============================================================
INSERT INTO content_blocks (page_id, section_key, title, subtitle, content, sort_order, is_active) VALUES
(2, 'page_title', 'Vorfabrikation & Montage', NULL, 'Ein Ansprechpartner, durchgängige Qualität, optimierte Abläufe – von der Werkstatt bis zur fertigen Oberfläche.', 1, 1),
(2, 'vorfab_header', 'Präzision aus der Werkstatt', NULL, 'In unserer Werkstatt fertigen wir massgeschneiderte Komponenten, die auf der Baustelle effizient installiert werden. Das spart Zeit, senkt Kosten und garantiert gleichbleibende Qualität.', 2, 1),
(2, 'vorfab_gis', 'GIS-Elemente', NULL, 'Geberit Installationssysteme massgenau vorfabriziert – bereit für die schnelle Montage.', 3, 1),
(2, 'vorfab_rohr', 'Rohrleitungsbau', NULL, 'Trinkwasser, Heizung, Abwasser – alle Materialien und Verbindungstechniken nach SIA-Normen.', 4, 1),
(2, 'vorfab_sto', 'STOClick', NULL, 'Schnellmontage-System für sichere Befestigung und optimierte Baustellenabläufe.', 5, 1),
(2, 'montage_header', 'Fachgerecht auf der Baustelle', NULL, 'Unser erfahrenes Team montiert direkt vor Ort – von der Vorwandinstallation bis zur fertigen Oberfläche, koordiniert mit allen Gewerken.', 6, 1),
(2, 'montage_duofix', 'Duofix & Vorwände', NULL, 'Geberit Duofix, geschweisste Vorwände und alle gängigen Sanitärvorwandsysteme.', 7, 1),
(2, 'montage_beplan', 'Beplankungen & AquaPanel', NULL, '1x 18mm oder 2x 12.5mm Platten. AquaPanel 2x 12mm für Feuchträume.', 8, 1),
(2, 'montage_spachtel', 'Spachtelungen', NULL, 'Fachgerechte Spachtelungen und Ausflockungen – bereit für Fliesen oder Anstrich.', 9, 1),
(2, 'details_header', 'Alle Leistungen auf einen Blick', NULL, NULL, 10, 1),
(2, 'detail_gis', 'GIS-Elemente vorfabrizieren', NULL, 'Geberit Installationssysteme massgenau in der Werkstatt vorbereiten. Qualitätskontrolle vor Auslieferung, termingerechte Lieferung.', 11, 1),
(2, 'detail_gis_montage', 'GIS-Elemente montieren', NULL, 'Fachgerechte Montage nach Herstellervorgaben direkt auf der Baustelle. Koordiniert mit allen beteiligten Gewerken.', 12, 1),
(2, 'detail_rohr', 'Rohrleitungsbau', NULL, 'Trinkwasser-, Heizungs- und Abwasserleitungen. Edelstahl, Kupfer, Kunststoff – alle Verbindungstechniken nach SIA-Normen.', 13, 1),
(2, 'detail_sto', 'STOClick', NULL, 'Schnellmontage-System für sichere Befestigung. Effiziente Vorfabrikation verkürzt Montagezeiten auf der Baustelle.', 14, 1),
(2, 'detail_duofix', 'Duofix & Vorwände', NULL, 'Geberit Duofix und alle gängigen Sanitärvorwandsysteme – auch geschweisst. Für Wohnbau, Gewerbe und Spitäler.', 15, 1),
(2, 'detail_beplan', 'Beplankungen', NULL, 'Vorwände beplanken mit 1x 18mm oder 2x 12.5mm Platten. Saubere Ausführung für perfekte Oberflächen.', 16, 1),
(2, 'detail_aqua', 'AquaPanel', NULL, 'Geberit AquaPanel 2x 12mm für Feuchträume. Zementgebundene Bauplatten – wasserfest, schimmelfrei, dauerhaft.', 17, 1),
(2, 'detail_spachtel', 'Spachtelungen & Ausflockungen', NULL, 'Fachgerechte Spachtelungen an Vorwänden. Perfekte Oberflächen, bereit für Fliesen, Putz oder Anstrich.', 18, 1),
(2, 'cta', 'Haben Sie ein Projekt?', NULL, 'Wir beraten Sie gerne – von der Vorfabrikation bis zur Montage.', 19, 1);

-- ============================================================
-- UNTERNEHMEN (page_id = 4)
-- ============================================================
INSERT INTO content_blocks (page_id, section_key, title, subtitle, content, sort_order, is_active) VALUES
(4, 'page_title', 'Über die SUI Innova GmbH', NULL, 'Qualität, Zuverlässigkeit und Leidenschaft für die Gebäudetechnik – das ist SUI Innova.', 1, 1),
(4, 'about', 'Über uns', 'SUI Innova GmbH', 'Die SUI Innova GmbH ist ein führendes Unternehmen im Bereich der Vorfabrikation und Montage von Sanitärinstallationen. Mit über 85 Fachkräften und langjähriger Erfahrung realisieren wir anspruchsvolle Projekte in der ganzen Schweiz.\n\nVon der Planung über die Vorfabrikation in unserer modernen Werkstatt bis zur fachgerechten Montage auf der Baustelle bieten wir alles aus einer Hand.', 2, 1),
(4, 'values', 'Unsere Werte', NULL, 'Diese Grundsätze leiten unser tägliches Handeln und bilden das Fundament unserer Arbeit.', 3, 1),
(4, 'value_1', 'Präzision', NULL, 'Höchste Genauigkeit in jeder Vorfabrikation und Montage – für dauerhaft zuverlässige Installationen.', 4, 1),
(4, 'value_2', 'Zuverlässigkeit', NULL, 'Termingerecht und verantwortungsbewusst. Unsere Kunden können sich auf uns verlassen.', 5, 1),
(4, 'value_3', 'Innovation', NULL, 'Moderne Fertigungstechnologien und effiziente Arbeitsabläufe für bessere Ergebnisse.', 6, 1),
(4, 'value_4', 'Teamarbeit', NULL, 'Gemeinsam stark – unsere Teams arbeiten Hand in Hand für den Projekterfolg.', 7, 1),
(4, 'quality', 'Qualitätsmanagement', NULL, 'Qualität ist kein Zufall, sondern das Ergebnis konsequenter Prozesse und hoher Ansprüche. Unser Qualitätsmanagement stellt sicher, dass jedes Projekt unseren Standards entspricht.', 8, 1),
(4, 'team', 'Unser Team', NULL, 'Über 85 engagierte Fachkräfte bilden das Rückgrat unseres Unternehmens. Mit Erfahrung, Fachwissen und Teamgeist meistern wir jede Herausforderung.', 9, 1),
(4, 'cta', 'Teil unseres Teams werden?', NULL, 'Wir suchen engagierte Fachkräfte. Kontaktieren Sie uns für offene Stellen.', 10, 1);

-- ============================================================
-- KONTAKT (page_id = 5)
-- ============================================================
INSERT INTO content_blocks (page_id, section_key, title, subtitle, content, sort_order, is_active) VALUES
(5, 'page_title', 'Kontaktieren Sie uns', NULL, 'Wir freuen uns auf Ihre Anfrage. Kontaktieren Sie uns für eine unverbindliche Beratung.', 1, 1),
(5, 'form_header', 'Schreiben Sie uns', NULL, NULL, 2, 1),
(5, 'info_header', 'Kontaktdaten', NULL, NULL, 3, 1);
