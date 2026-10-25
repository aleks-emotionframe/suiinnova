-- ============================================================
-- SUI Innova GmbH — SEO Paket 3
-- Sechs neue Seiten aus dem Keyword-Plan vom 08.09.2026
--
-- ERZEUGT VON dist/scripts/build_keyword_pages.php — nicht von Hand
-- bearbeiten, sondern den Generator anpassen und neu erzeugen.
--
-- Die Texte sind vollstaendig, es ist keine Stelle mehr offen.
--
-- Trotzdem werden alle Seiten DEAKTIVIERT angelegt (is_active = 0):
-- sie sind im CMS vorhanden und bearbeitbar, aber weder fuer Besucher
-- noch fuer Google sichtbar. Neue oeffentliche Seiten auf einer
-- Kundenwebsite schaltet ein Mensch frei, nicht ein SQL-Import.
--
-- Freischalten: im CMS unter Seiten je Seite auf Online stellen,
-- oder alle auf einmal mit seo-paket-3c-seiten-online.sql.
--
-- Gefahrlos mehrfach ausfuehrbar: bestehende Seiten werden an ihrem
-- Slug erkannt und nicht doppelt angelegt.
-- ============================================================

-- Zeichensatz festnageln: sonst wird aus "Pfaeffikon" mit Umlaut
-- je nach Client ein Zeichensalat.
SET NAMES utf8mb4;

SET @next_sort = (SELECT COALESCE(MAX(sort_order), 0) + 10 FROM pages);

-- ────────────────────────────────────────────────────────────
-- /sanitaer-vorwandelemente
-- ────────────────────────────────────────────────────────────
INSERT INTO pages (title, slug, meta_title, meta_desc, is_active, is_homepage, sort_order)
SELECT 'Sanitär Vorwandelemente', 'sanitaer-vorwandelemente', 'Sanitär Vorwandelemente: Aufbau, Montage | SUI Innova', 'Sanitär Vorwandelemente: Aufbau, Masse, Beplankung und Montage einfach erklärt. Lesen Sie, worauf es ankommt, und fragen Sie Ihr Projekt bei SUI Innova an.', 0, 0, @next_sort + 0
FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE slug = 'sanitaer-vorwandelemente');

SET @pid = (SELECT id FROM pages WHERE slug = 'sanitaer-vorwandelemente' LIMIT 1);

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'parallax-image', '{"image_id":0,"height":"medium","overlay_text":""}', 10, 1
FROM DUAL
WHERE @pid IS NOT NULL
  AND NOT EXISTS (SELECT 1 FROM sections WHERE page_id = @pid AND sort_order = 10);

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'content-grid', '{"heading":"Sanitär Vorwandelemente: Aufbau, Montage und Beplankung erklärt","lead":"<p>Sanitär Vorwandelemente tragen WC, Waschtisch, Dusche oder Urinal und nehmen Zu- und Ablaufleitungen auf, ohne dass jemand die Rohre sieht. Sie bestehen aus einem verzinkten Stahlrahmen, der am Boden und an der Rohbauwand verschraubt wird, und werden anschliessend beplankt und gespachtelt. Auf dieser Seite lesen Sie, wie ein solches Element aufgebaut ist, welche Masse üblich sind, warum die Beplankung im Nassbereich eine eigene Rolle spielt und wo im Bauablauf die Schallentkopplung entschieden wird. SUI Innova aus Pfäffikon fertigt GIS-Elemente in der eigenen Werkstatt fix und fertig verrohrt vor, montiert sie auf der Baustelle und übernimmt Beplankung, Spachtelung und Ausflockung. Sie erhalten die Wand also nicht in Teilen, sondern als eine Leistung.</p>","style":"light","items":[{"title":"Ein Vorwandelement ist Tragwerk und Installationsraum zugleich","text":"<p>Das Element nimmt die Lasten von WC, Waschtisch oder Stützgriffen auf und leitet sie in Boden und Rohbauwand ab. Gleichzeitig läuft im Innenraum alles, was nicht sichtbar sein soll: Kalt- und Warmwasser, Abwasser, teilweise Elektro. Deshalb wird die Position jeder Leitung festgelegt, bevor die erste Platte montiert wird. Fehler in dieser Phase kosten später Aufbruch und Zeit.</p>"},{"title":"Vorfabrikation verlagert die knifflige Arbeit von der Baustelle in die Werkstatt","text":"<p>In der Werkstatt lassen sich Elemente auf dem Tisch verrohren, ausrichten und prüfen. Auf der Baustelle wird das fertige Element nur noch gestellt, befestigt und angeschlossen. Das verkürzt die Zeit, in der andere Gewerke warten müssen, und reduziert Anpassungen vor Ort. SUI Innova liefert GIS-Elemente fix und fertig verrohrt aus der eigenen Werkstatt an.</p>"},{"title":"Masse und Höhen ergeben sich aus dem Apparat, nicht aus dem Gefühl","text":"<p>Übliche Bauhöhen sind das halbhohe Element für die freistehende Vorwand und das raumhohe Element bis zur Decke. Die Fertighöhe der WC-Keramik und die Lage der Spülkasten-Betätigung richten sich nach Herstellerangaben und nach der geplanten Bodenaufbauhöhe. Wird der Bodenaufbau später geändert, stimmt die Höhe nicht mehr. Klären Sie die Aufbauhöhe deshalb vorgängig mit Architektur und Plattenleger. Welche Höhe und welches System für Ihre Nasszelle passen, legen wir anhand der Pläne und der gewählten Apparate fest.</p>"},{"title":"Im Nassbereich entscheidet die Beplankung über die Lebensdauer","text":"<p>Hinter Dusche und Badewanne gehört eine Platte, die Feuchtigkeit verträgt. AquaPanel wird in Feuchträumen und Nasszellen eingesetzt und bildet den Untergrund für Abdichtung und Plättli. Die Fugen und Anschlüsse werden gespachtelt, damit die Fläche ohne Absatz weitergeht. SUI Innova übernimmt Beplankung und Spachtelung im gleichen Auftrag wie die Montage.</p>"},{"title":"Schall wird an der Befestigung entschieden, nicht am Rohr","text":"<p>Spülgeräusche wandern über Körperschall in angrenzende Räume, wenn Element und Rohre starr mit der Rohbauwand verbunden sind. Entkoppelte Befestigungen, Schallschutzsets und eine Ausflockung des Hohlraums dämpfen diesen Weg. Besonders wichtig ist das bei Wänden zu Schlafräumen und in Mehrfamilienhäusern. Welche Anforderung für Ihr Projekt gilt, steht im Schallschutznachweis. Nennen Sie uns die Vorgabe, wir richten den Aufbau danach aus.</p>"},{"title":"Von der Planung bis zur spachtelfertigen Wand aus einer Hand","text":"<p>Sie schicken uns Pläne oder Schemas, wir klären die Apparatepositionen und fertigen die Elemente vor. Danach montieren wir auf der Baustelle, beplanken und spachteln. Sie haben eine Ansprechperson für Vorfabrikation, Montage und Beplankung statt drei Schnittstellen. Was das für Ihr Projekt konkret heisst, klären wir am besten anhand Ihrer Unterlagen.</p>"}]}', 20, 1
FROM DUAL
WHERE @pid IS NOT NULL
  AND NOT EXISTS (SELECT 1 FROM sections WHERE page_id = @pid AND sort_order = 20);

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'faq', '{"heading":"Fragen und Antworten","subtitle":"","items":[{"question":"Wie tief ist eine Sanitärvorwand üblicherweise?","answer":"<p>Die Tiefe richtet sich nach dem Spülkasten und den Leitungen dahinter. Für ein WC-Element rechnet man mit rund 15 bis 20 Zentimetern Rahmentiefe plus Beplankung. Bei zusätzlichen Steigleitungen oder Lüftungen wird die Vorwand entsprechend tiefer.</p>"},{"question":"Kann ich später etwas an der Wand befestigen?","answer":"<p>Nur dort, wo Traversen oder Verstärkungen eingebaut sind. Spiegelschrank, Handtuchhalter oder Stützgriffe sollten Sie deshalb vor der Beplankung anmelden. Nachträglich befestigt man in einer beplankten Vorwand nur leichte Lasten.</p>"},{"question":"Wer koordiniert Sanitär, Trockenbau und Plattenleger?","answer":"<p>Bei getrennten Aufträgen liegt die Koordination bei der Bauleitung. Wenn Vorfabrikation, Montage und Beplankung in einer Hand liegen, entfällt ein Teil dieser Abstimmung. SUI Innova übergibt die Wand spachtelfertig an das Folgegewerk.</p>"}]}', 30, 1
FROM DUAL
WHERE @pid IS NOT NULL
  AND NOT EXISTS (SELECT 1 FROM sections WHERE page_id = @pid AND sort_order = 30);

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'cta-banner', '{"heading":"Pläne einsenden, Offerte erhalten","body":"Senden Sie uns Ihre Pläne, wir melden uns mit Rückfragen zu Apparatepositionen und einer Offerte für Vorfabrikation, Montage und Beplankung.","button_text":"Pläne einsenden","button_url":"/kontakt"}', 40, 1
FROM DUAL
WHERE @pid IS NOT NULL
  AND NOT EXISTS (SELECT 1 FROM sections WHERE page_id = @pid AND sort_order = 40);

-- ────────────────────────────────────────────────────────────
-- /sanitaer-vorwaende
-- ────────────────────────────────────────────────────────────
INSERT INTO pages (title, slug, meta_title, meta_desc, is_active, is_homepage, sort_order)
SELECT 'Sanitär Vorwände', 'sanitaer-vorwaende', 'Sanitär Vorwände vorfabriziert | SUI Innova GmbH', 'Sanitär Vorwände vorfabriziert, montiert und beplankt: GIS-Elemente fix verrohrt aus der Werkstatt von SUI Innova in Pfäffikon. Jetzt Offerte anfragen.', 0, 0, @next_sort + 10
FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE slug = 'sanitaer-vorwaende');

SET @pid = (SELECT id FROM pages WHERE slug = 'sanitaer-vorwaende' LIMIT 1);

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'parallax-image', '{"image_id":0,"height":"medium","overlay_text":""}', 10, 1
FROM DUAL
WHERE @pid IS NOT NULL
  AND NOT EXISTS (SELECT 1 FROM sections WHERE page_id = @pid AND sort_order = 10);

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'content-grid', '{"heading":"Sanitär Vorwände: vorfabriziert, montiert, beplankt","lead":"<p>Sanitär Vorwände liefern wir fix und fertig verrohrt auf Ihre Baustelle. In unserer Werkstatt in Pfäffikon bauen wir GIS-Elemente auf Mass zusammen, montieren sie vor Ort und beplanken sie bis zur spachtelfertigen Wand. So verlagern Sie einen grossen Teil der Sanitärinstallation von der Baustelle in die Halle: weniger Schnittstellen, weniger Wartezeit für die Folgegewerke, planbare Abläufe. Sie erhalten Vorfabrikation, Montage und Beplankung aus einer Hand und haben einen Ansprechpartner für den ganzen Ablauf. Für Nasszellen und Feuchträume setzen wir AquaPanel ein, für Schallschutzanforderungen SilentPanel und Ausflockung. Senden Sie uns Ihre Pläne mit der Adresse der Baustelle, wir prüfen sie und melden uns mit einer Offerte.</p>","style":"light","items":[{"title":"GIS-Elemente verlassen unsere Werkstatt fertig verrohrt","text":"<p>Wir konfektionieren die Vorwandelemente nach Ihren Plänen und verrohren sie komplett. Auf der Baustelle wird das Element gesetzt und angeschlossen, nicht mehr zusammengebaut. Das verkürzt die Zeit im Rohbau und senkt das Risiko von Fehlern in engen Platzverhältnissen. Änderungen klären wir vorgängig am Plan, nicht improvisiert vor Ort.</p>"},{"title":"Montage und Beplankung kommen vom gleichen Team","text":"<p>Unsere Monteure setzen die Vorwände auf Ihrer Baustelle und richten sie aus. Anschliessend beplanken wir die Wände und spachteln sie, sodass der Maler oder Plattenleger direkt weiterarbeiten kann. Weil Vorfabrikation und Montage im gleichen Haus liegen, entfällt die Abstimmung zwischen mehreren Firmen. Bei Terminverschiebungen reagieren wir mit Ihnen zusammen auf den aktuellen Bauablauf.</p>"},{"title":"AquaPanel für Nasszellen, SilentPanel gegen Schall","text":"<p>In Bädern und Duschen beplanken wir mit AquaPanel, das für dauerhafte Feuchtebelastung ausgelegt ist. Wo Schallschutz gefordert ist, arbeiten wir mit SilentPanel und Ausflockung der Hohlräume. Welche Kombination sinnvoll ist, hängt von der Nutzung und den Anforderungen im Bauprojekt ab. Sagen Sie uns, welche Werte gefordert sind, wir schlagen den Aufbau vor.</p>"},{"title":"Für Neubau, Umbau und Sanierung im Wohnungsbau","text":"<p>Wir arbeiten für Sanitärinstallateure, Generalunternehmen und Bauherrschaften. Bei Mehrfamilienhäusern fertigen wir gleiche Elemente in Serie, bei Umbauten passen wir jedes Element an den Bestand an. Für Sanierungen im bewohnten Objekt kürzt die Vorfabrikation die Zeit, in der das Bad nicht nutzbar ist. Ausgeführte Arbeiten sehen Sie unter <a href=\\"/referenzen\\">Referenzen</a>.</p>"},{"title":"So läuft eine Anfrage ab","text":"<p>Sie senden uns Grundrisse und Sanitärpläne. Wir prüfen die Unterlagen, klären offene Punkte mit Ihnen und stellen eine Offerte mit Positionen und Terminen. Nach Ihrer Freigabe fertigen wir die Elemente und vereinbaren den Montagetermin. Sie erhalten von uns eine Ansprechperson, die das Projekt bis zur fertigen Wand begleitet.</p>"}]}', 20, 1
FROM DUAL
WHERE @pid IS NOT NULL
  AND NOT EXISTS (SELECT 1 FROM sections WHERE page_id = @pid AND sort_order = 20);

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'faq', '{"heading":"Fragen und Antworten","subtitle":"","items":[{"question":"Was ist eine Sanitär Vorwand?","answer":"<p>Eine Sanitär Vorwand ist eine vorgesetzte Ständerkonstruktion, in der Zuleitungen, Abläufe und Befestigungen für WC, Waschtisch oder Dusche liegen. Sie wird vor die Rohbauwand gestellt und danach beplankt. Sichtbar bleibt später nur die fertige Wandfläche.</p>"},{"question":"Was ist der Vorteil von vorfabrizierten Vorwänden gegenüber dem Bau auf der Baustelle?","answer":"<p>Die Elemente entstehen in der Werkstatt unter gleichbleibenden Bedingungen und kommen fertig verrohrt auf die Baustelle. Vor Ort bleibt das Setzen und Anschliessen, das verkürzt die Bauzeit und reduziert Nacharbeiten. Zudem koordinieren Sie weniger Beteiligte.</p>"},{"question":"Übernehmen Sie auch die Beplankung und Spachtelung?","answer":"<p>Ja, wir beplanken die montierten Vorwände und spachteln sie auf Wunsch fertig. In Feuchträumen setzen wir AquaPanel ein. Damit übergeben wir eine Wand, an der das nächste Gewerk direkt weiterarbeiten kann.</p>"}]}', 30, 1
FROM DUAL
WHERE @pid IS NOT NULL
  AND NOT EXISTS (SELECT 1 FROM sections WHERE page_id = @pid AND sort_order = 30);

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'cta-banner', '{"heading":"Pläne einsenden und Offerte anfragen","body":"Senden Sie uns Ihre Sanitär- und Grundrisspläne, wir prüfen sie und schicken Ihnen eine Offerte mit Terminen.","button_text":"Pläne einsenden","button_url":"/kontakt"}', 40, 1
FROM DUAL
WHERE @pid IS NOT NULL
  AND NOT EXISTS (SELECT 1 FROM sections WHERE page_id = @pid AND sort_order = 40);

-- ────────────────────────────────────────────────────────────
-- /sanitaer-gis-elemente-bestellen
-- ────────────────────────────────────────────────────────────
INSERT INTO pages (title, slug, meta_title, meta_desc, is_active, is_homepage, sort_order)
SELECT 'GIS-Elemente bestellen', 'sanitaer-gis-elemente-bestellen', 'Sanitär GIS Elemente bestellen | SUI Innova GmbH', 'Sanitär GIS Elemente bestellen: vorfabriziert, verrohrt und auf Wunsch beplankt. Senden Sie uns Ihre Pläne, wir erstellen eine Offerte.', 0, 0, @next_sort + 20
FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE slug = 'sanitaer-gis-elemente-bestellen');

SET @pid = (SELECT id FROM pages WHERE slug = 'sanitaer-gis-elemente-bestellen' LIMIT 1);

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'parallax-image', '{"image_id":0,"height":"medium","overlay_text":""}', 10, 1
FROM DUAL
WHERE @pid IS NOT NULL
  AND NOT EXISTS (SELECT 1 FROM sections WHERE page_id = @pid AND sort_order = 10);

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'content-grid', '{"heading":"Sanitär GIS Elemente bestellen bei SUI Innova","lead":"<p>Sie wollen Sanitär GIS Elemente bestellen, die auf der Baustelle nur noch gestellt und angeschlossen werden müssen. Genau das liefern wir. In unserer Werkstatt in Pfäffikon bauen wir GIS Elemente nach Ihren Plänen auf, verrohren sie fix und fertig und bereiten sie für den Transport vor. Auf Wunsch übernehmen wir auch Montage, Beplankung mit AquaPanel, Spachtelung und Ausflockung mit SilentPanel. Sie erhalten alles aus einer Hand und haben eine Ansprechperson für den ganzen Ablauf. Schicken Sie uns Ihre Sanitärpläne oder eine Skizze mit Apparateliste. Wir prüfen die Unterlagen, melden uns bei offenen Punkten und erstellen Ihnen eine Offerte mit Preis und möglichem Liefertermin.</p>","style":"light","items":[{"title":"So läuft die Bestellung ab","text":"<p>Sie senden uns Ihre Sanitärpläne, die Apparateliste und den gewünschten Liefertermin. Wir prüfen die Unterlagen und klären offene Punkte direkt mit Ihnen oder mit dem Planer. Danach erhalten Sie eine Offerte mit Positionen, Preis und Terminvorschlag. Nach Ihrer Freigabe starten wir die Vorfabrikation in der Werkstatt.</p>"},{"title":"Fix und fertig verrohrt aus der Werkstatt","text":"<p>Wir bauen die GIS Elemente auf und verrohren sie komplett, bevor sie die Werkstatt verlassen. Dadurch verschieben Sie Arbeitsstunden von der Baustelle in eine Umgebung mit festen Arbeitsplätzen und Material zur Hand. Auf der Baustelle bleibt das Stellen, Fixieren und Anschliessen. Das verkürzt die Zeit, in der andere Gewerke warten müssen.</p>"},{"title":"Was Sie zusätzlich zum Element bestellen können","text":"<p>Viele Kunden bestellen nicht nur das nackte Element. Wir montieren die Elemente direkt auf Ihrer Baustelle, beplanken sie mit AquaPanel für Feuchträume und Nasszellen und spachteln die Flächen. Für den Schallschutz flocken wir die Vorwand mit SilentPanel aus. Sie entscheiden, wo unsere Arbeit endet und Ihre beginnt.</p>"},{"title":"Angaben, die wir für eine Offerte brauchen","text":"<p>Für eine belastbare Offerte brauchen wir den Sanitärplan oder eine bemasste Skizze, die Anzahl und Art der Apparate und die Höhen der Vorwand. Nützlich sind zudem Angaben zum Wandaufbau, zur gewünschten Beplankung und zu Anforderungen an den Schallschutz. Nennen Sie uns auch die Zufahrt und die Etage, das beeinflusst Anlieferung und Handling. Fehlt etwas, fragen wir nach, bevor wir rechnen.</p>"},{"title":"Für Sanitärunternehmen, Generalunternehmer und Bauherren","text":"<p>Wir arbeiten für Sanitärbetriebe, die Kapazität in der Werkstatt brauchen, und für Bauleitungen, die einen fixen Liefertermin wollen. Kleine Umbauten mit einem einzelnen Element sind ebenso möglich wie Serien für ganze Geschosse. Sagen Sie uns, wie viele Elemente Sie brauchen und bis wann. Wir sagen Ihnen ehrlich, ob wir den Termin halten können.</p>"},{"title":"Lieferung und Termine","text":"<p>Die Elemente werden montagefertig angeliefert und nach Absprache abgeladen. Den Liefertermin halten wir in der Offerte fest, damit Ihre Bauleitung damit planen kann. Verschiebt sich Ihr Bauprogramm, melden Sie sich frühzeitig, dann suchen wir einen neuen Termin. Wie schnell wir fertigen können, hängt von Stückzahl und Auslastung ab. Fragen Sie früh an, dann sagen wir Ihnen verbindlich, was möglich ist.</p>"}]}', 20, 1
FROM DUAL
WHERE @pid IS NOT NULL
  AND NOT EXISTS (SELECT 1 FROM sections WHERE page_id = @pid AND sort_order = 20);

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'faq', '{"heading":"Fragen und Antworten","subtitle":"","items":[{"question":"Kann ich einzelne GIS Elemente bestellen oder nur ganze Serien?","answer":"<p>Beides ist möglich. Wir fertigen einzelne Elemente für Umbauten ebenso wie Serien für Neubauten. Nennen Sie uns die Stückzahl bei der Anfrage.</p>"},{"question":"Muss ich das Material selber liefern?","answer":"<p>Das klären wir vor der Offerte, je nach Projekt und Verfügbarkeit. Sagen Sie uns bei der Anfrage, ob Sie Material beistellen möchten, dann rechnen wir die Offerte entsprechend.</p>"},{"question":"Übernehmen Sie auch die Montage auf der Baustelle?","answer":"<p>Ja, wir montieren die Elemente direkt auf Ihrer Baustelle. Auf Wunsch beplanken und spachteln wir die Wand anschliessend. Sie bestellen also nur die Vorfabrikation oder den ganzen Ablauf bis zur fertigen Wand.</p>"}]}', 30, 1
FROM DUAL
WHERE @pid IS NOT NULL
  AND NOT EXISTS (SELECT 1 FROM sections WHERE page_id = @pid AND sort_order = 30);

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'cta-banner', '{"heading":"GIS Elemente anfragen","body":"Senden Sie uns Ihre Sanitärpläne über das Kontaktformular, wir melden uns mit Rückfragen und einer Offerte samt Terminvorschlag.","button_text":"Pläne einsenden","button_url":"/kontakt"}', 40, 1
FROM DUAL
WHERE @pid IS NOT NULL
  AND NOT EXISTS (SELECT 1 FROM sections WHERE page_id = @pid AND sort_order = 40);

-- ────────────────────────────────────────────────────────────
-- /sanitaer-vorwandelemente-bestellen
-- ────────────────────────────────────────────────────────────
INSERT INTO pages (title, slug, meta_title, meta_desc, is_active, is_homepage, sort_order)
SELECT 'Vorwandelemente bestellen', 'sanitaer-vorwandelemente-bestellen', 'Sanitär Vorwandelemente bestellen | SUI Innova', 'Sanitär Vorwandelemente bestellen bei SUI Innova in Pfäffikon: GIS-Elemente fertig verrohrt, auf Mass vorfabriziert, montiert und beplankt. Jetzt anfragen.', 0, 0, @next_sort + 30
FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE slug = 'sanitaer-vorwandelemente-bestellen');

SET @pid = (SELECT id FROM pages WHERE slug = 'sanitaer-vorwandelemente-bestellen' LIMIT 1);

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'parallax-image', '{"image_id":0,"height":"medium","overlay_text":""}', 10, 1
FROM DUAL
WHERE @pid IS NOT NULL
  AND NOT EXISTS (SELECT 1 FROM sections WHERE page_id = @pid AND sort_order = 10);

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'content-grid', '{"heading":"Sanitär Vorwandelemente bestellen: vorfabriziert aus Pfäffikon","lead":"<p>Sie können bei SUI Innova Sanitär Vorwandelemente bestellen, die bereits verrohrt aus unserer Werkstatt kommen. Wir fertigen GIS-Elemente nach Ihren Plänen vor, prüfen die Leitungsführung im Voraus und liefern die Elemente auf die Baustelle. Auf Wunsch übernehmen wir auch die Montage, die Beplankung mit AquaPanel und die Spachtelung, bis die Wand fertig ist. Für Sie heisst das: weniger Schnittstellen, weniger Nacharbeit, ein Ansprechpartner für Vorfabrikation und Einbau. Wir arbeiten für Sanitärbetriebe, Generalunternehmen und Bauherrschaften in der Region Pfäffikon und darüber hinaus. Sagen Sie uns, welche Apparate, welche Wandtypen und welchen Liefertermin Sie brauchen. Sie erhalten eine Offerte mit Positionen, Massen und Liefertermin, damit Sie die Kosten Ihres Projekts sauber rechnen können.</p>","style":"light","items":[{"title":"Was Sie bei uns bestellen: GIS-Elemente, fertig verrohrt","text":"<p>Wir bauen die Vorwandelemente in unserer Werkstatt auf, montieren die Sanitärapparate-Träger und verrohren sie komplett. Auf der Baustelle wird das Element nur noch gesetzt und angeschlossen. Das verkürzt die Zeit auf dem Bau und verlagert die Präzisionsarbeit in eine trockene, eingerichtete Werkstatt. Sie bestellen einzelne Elemente oder ganze Geschosse. Welches System zum Einsatz kommt, richtet sich nach Ihrer Ausschreibung. Nennen Sie es uns bei der Anfrage.</p>"},{"title":"So läuft die Bestellung ab, Schritt für Schritt","text":"<p>Sie senden uns die Sanitärpläne oder eine Skizze mit den gewünschten Apparaten. Wir prüfen Masse, Wandaufbau und Leitungsführung und melden uns bei Unklarheiten vorgängig. Danach erhalten Sie eine Offerte mit Stückliste und Liefertermin. Nach Ihrer Freigabe fertigen wir vor und liefern die Elemente auf die Baustelle. Den Vorlauf zwischen Freigabe und Lieferung halten wir in der Offerte fest, damit Ihre Bauleitung damit planen kann.</p>"},{"title":"Montage und Beplankung dazubestellen statt koordinieren","text":"<p>Sie können die Elemente ab Werkstatt beziehen oder die Montage gleich mitbestellen. Unser Team setzt die Elemente auf Ihrer Baustelle, richtet sie aus und befestigt sie. Anschliessend beplanken wir mit AquaPanel für Feuchträume und Nasszellen und spachteln die Flächen. So übergeben wir Ihnen die Wand malerfertig.</p>"},{"title":"Schallschutz und Ausflockung für Nasszellen","text":"<p>Wasserleitungen und Spülungen übertragen Geräusche in angrenzende Räume. Wir flocken die Vorwandelemente aus und arbeiten mit SilentPanel, damit die Wand ruhiger bleibt. Wir klären mit Ihnen vorgängig, welche Anforderung Ihr Projekt hat. Massgebend ist, was in Ausschreibung oder Schallschutznachweis steht. Danach richten wir den Aufbau aus.</p>"},{"title":"Sondermasse und Kleinserien sind möglich","text":"<p>Nicht jede Nasszelle passt in ein Standardmass. Wir fertigen Elemente für schräge Wände, tiefe Nischen und Grundrisse mit mehreren Apparaten in einer Wand. Bei Wiederholungen, etwa bei gleichen Wohnungstypen, fertigen wir in Serie und halten die Masse über alle Elemente gleich. Fragen Sie uns an, bevor Sie eine Lösung ausschliessen.</p>"},{"title":"Lieferung und Zwischenlagerung","text":"<p>Wir liefern die Elemente termingerecht auf die Baustelle, damit Sie sie nicht wochenlang lagern müssen. Bei Verzögerungen im Bauprogramm lagern wir vorfabrizierte Elemente in Absprache zwischen. Sagen Sie uns bei der Bestellung, wie die Zufahrt und die Abladesituation aussehen. Lieferung und Abladen halten wir in der Offerte fest, damit später nichts dazukommt.</p>"}]}', 20, 1
FROM DUAL
WHERE @pid IS NOT NULL
  AND NOT EXISTS (SELECT 1 FROM sections WHERE page_id = @pid AND sort_order = 20);

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'faq', '{"heading":"Fragen und Antworten","subtitle":"","items":[{"question":"Ab welcher Menge kann ich Sanitär Vorwandelemente bestellen?","answer":"<p>Wir fertigen sowohl einzelne Elemente als auch Serien für ganze Überbauungen. Melden Sie uns Ihr Projekt, wir sagen Ihnen, was in Ihrem Fall sinnvoll ist.</p>"},{"question":"Kommen die Elemente bereits verrohrt?","answer":"<p>Ja, wir verrohren die GIS-Elemente in unserer Werkstatt fertig. Auf der Baustelle wird das Element gesetzt und angeschlossen, die Verteilarbeit ist bereits erledigt.</p>"},{"question":"Was brauchen Sie von mir für eine Offerte?","answer":"<p>Am schnellsten geht es mit den Sanitärplänen oder einer Skizze mit Massen und den gewünschten Apparaten. Nützlich sind zudem der Wandaufbau, der gewünschte Liefertermin und die Adresse der Baustelle.</p>"}]}', 30, 1
FROM DUAL
WHERE @pid IS NOT NULL
  AND NOT EXISTS (SELECT 1 FROM sections WHERE page_id = @pid AND sort_order = 30);

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'cta-banner', '{"heading":"Offerte für Vorwandelemente anfragen","body":"Senden Sie uns Ihre Sanitärpläne oder rufen Sie uns an, Sie erhalten eine Offerte mit Stückliste, Massen und Liefertermin.","button_text":"Pläne einsenden","button_url":"/kontakt"}', 40, 1
FROM DUAL
WHERE @pid IS NOT NULL
  AND NOT EXISTS (SELECT 1 FROM sections WHERE page_id = @pid AND sort_order = 40);

-- ────────────────────────────────────────────────────────────
-- /gis-elemente-beplanken
-- ────────────────────────────────────────────────────────────
INSERT INTO pages (title, slug, meta_title, meta_desc, is_active, is_homepage, sort_order)
SELECT 'GIS-Elemente beplanken', 'gis-elemente-beplanken', 'GIS Elemente beplanken | SUI Innova GmbH', 'GIS Elemente beplanken in Werkstatt und auf der Baustelle: verrohrt, beplankt, gespachtelt. Nennen Sie Stückzahl und Termin, wir rechnen Ihnen eine Offerte.', 0, 0, @next_sort + 40
FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE slug = 'gis-elemente-beplanken');

SET @pid = (SELECT id FROM pages WHERE slug = 'gis-elemente-beplanken' LIMIT 1);

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'parallax-image', '{"image_id":0,"height":"medium","overlay_text":""}', 10, 1
FROM DUAL
WHERE @pid IS NOT NULL
  AND NOT EXISTS (SELECT 1 FROM sections WHERE page_id = @pid AND sort_order = 10);

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'content-grid', '{"heading":"GIS Elemente beplanken: von der Vorfabrikation bis zur fertigen Wand","lead":"<p>Wir beplanken GIS Elemente, in unserer Werkstatt in Pfäffikon und direkt auf Ihrer Baustelle. Sie erhalten die Elemente verrohrt, beplankt und gespachtelt, bereit für Plättli, Farbe oder SilentPanel. In Nasszellen setzen wir AquaPanel ein, in trockenen Bereichen Gipsplatten nach Ihren Vorgaben. Wir arbeiten mit Sanitärfirmen, Generalunternehmen und Bauleitungen zusammen und richten uns nach Ihrem Bauprogramm. Nennen Sie uns Stückzahl, Wandaufbau und Termin, dann rechnen wir Ihnen eine Offerte. Vorfabrikation, Montage und Beplankung kommen bei uns aus einer Hand. Das spart Schnittstellen, Rückfragen und Wartezeiten auf der Baustelle.</p>","style":"light","items":[{"title":"Beplankung in der Werkstatt spart Zeit auf der Baustelle","text":"<p>Wir verrohren und beplanken die GIS Elemente vorgängig in unserer Werkstatt. Auf der Baustelle wird das Element nur noch versetzt und angeschlossen. So verkürzt sich die Zeit, in der andere Handwerker warten müssen. Transport und Anlieferung stimmen wir auf Ihren Bauablauf ab. Wie gross ein Element werden darf, klären wir anhand von Zufahrt und Abladesituation.</p>"},{"title":"AquaPanel für Nasszellen, Gipsplatten für trockene Räume","text":"<p>In Duschen, Bädern und Nasszellen beplanken wir mit AquaPanel, weil die Platte Feuchtigkeit verträgt. In trockenen Bereichen arbeiten wir mit Gipsplatten. Welche Platte wo zum Einsatz kommt, halten wir vor Baubeginn schriftlich fest. Sagen Sie uns, ob Sie Plättli, Verputz oder eine Beschichtung planen, danach richtet sich der Aufbau.</p>"},{"title":"Spachteln bis zur gewünschten Qualitätsstufe","text":"<p>Nach der Beplankung verspachteln wir Fugen, Kanten und Schraubenköpfe. Sie geben die Qualitätsstufe vor, wir liefern die Fläche entsprechend ab. Damit übernimmt der Maler oder Plattenleger eine Wand, an der er direkt weiterarbeiten kann. Welche Stufe gilt, halten wir vor Arbeitsbeginn schriftlich fest.</p>"},{"title":"Ausflockung und SilentPanel gegen Schall","text":"<p>Auf Wunsch flocken wir die Elemente aus und montieren SilentPanel. Beides reduziert die Schallübertragung von Leitungen in angrenzende Räume. Sinnvoll ist das vor allem bei Wohnungstrennwänden und bei Bädern neben Schlafzimmern. Klären Sie die Anforderung frühzeitig mit uns, denn sie beeinflusst den Wandaufbau.</p>"},{"title":"Ein Ansprechpartner für Vorfabrikation, Montage und Beplankung","text":"<p>Sie beauftragen eine Firma statt drei. Wir montieren die Elemente selbst und beplanken sie anschliessend, deshalb gibt es keine Diskussion über Vorleistungen. Bei Änderungen auf der Baustelle passen wir die Elemente an. Den Stand melden wir Ihnen laufend, damit Ihre Terminplanung hält.</p>"},{"title":"So läuft ein Auftrag ab","text":"<p>Sie senden uns Pläne, Stückzahlen und den gewünschten Termin. Wir prüfen die Unterlagen und stellen Ihnen eine Offerte mit Positionen und Preisen zu. Nach der Freigabe fixieren wir die Produktions- und Montagetermine. Zum Schluss übergeben wir die beplankten Wände und melden Ihnen, was noch offen ist.</p>"}]}', 20, 1
FROM DUAL
WHERE @pid IS NOT NULL
  AND NOT EXISTS (SELECT 1 FROM sections WHERE page_id = @pid AND sort_order = 20);

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'faq', '{"heading":"Fragen und Antworten","subtitle":"","items":[{"question":"Beplanken Sie auch GIS Elemente, die wir selbst montiert haben?","answer":"<p>Ja, wir übernehmen die Beplankung auch dann, wenn Vorfabrikation und Montage bei Ihnen liegen. Wir prüfen vor dem Start, ob die Elemente ausgerichtet und die Leitungen abgedrückt sind. Mängel melden wir Ihnen schriftlich, bevor wir die Platten setzen.</p>"},{"question":"Welche Platten verwenden Sie in Nasszellen?","answer":"<p>In Nasszellen und Feuchträumen beplanken wir mit AquaPanel. Für trockene Bereiche kommen Gipsplatten zum Einsatz. Weichen Ihre Vorgaben davon ab, halten wir uns an Ihr Devis.</p>"},{"question":"Wie schnell können Sie mit der Beplankung beginnen?","answer":"<p>Das hängt von der aktuellen Auslastung und der Stückzahl ab. Melden Sie sich mit Ihrem Bauprogramm, dann nennen wir Ihnen einen verbindlichen Termin.</p>"}]}', 30, 1
FROM DUAL
WHERE @pid IS NOT NULL
  AND NOT EXISTS (SELECT 1 FROM sections WHERE page_id = @pid AND sort_order = 30);

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'cta-banner', '{"heading":"Offerte für die Beplankung anfragen","body":"Senden Sie uns Pläne, Stückzahl und Wunschtermin, Sie erhalten von uns eine Offerte mit Positionen und Preisen.","button_text":"Pläne einsenden","button_url":"/kontakt"}', 40, 1
FROM DUAL
WHERE @pid IS NOT NULL
  AND NOT EXISTS (SELECT 1 FROM sections WHERE page_id = @pid AND sort_order = 40);

-- ────────────────────────────────────────────────────────────
-- /sanitaer-vorwandelemente-beplanken
-- ────────────────────────────────────────────────────────────
INSERT INTO pages (title, slug, meta_title, meta_desc, is_active, is_homepage, sort_order)
SELECT 'Vorwandelemente beplanken', 'sanitaer-vorwandelemente-beplanken', 'Sanitär Vorwandelemente beplanken | SUI Innova', 'Sanitär Vorwandelemente beplanken: SUI Innova beplankt GIS-Elemente mit AquaPanel oder Gipsplatten, inklusive Spachtelung. Projekt anfragen und Termin klären.', 0, 0, @next_sort + 50
FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE slug = 'sanitaer-vorwandelemente-beplanken');

SET @pid = (SELECT id FROM pages WHERE slug = 'sanitaer-vorwandelemente-beplanken' LIMIT 1);

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'parallax-image', '{"image_id":0,"height":"medium","overlay_text":""}', 10, 1
FROM DUAL
WHERE @pid IS NOT NULL
  AND NOT EXISTS (SELECT 1 FROM sections WHERE page_id = @pid AND sort_order = 10);

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'content-grid', '{"heading":"Sanitär Vorwandelemente beplanken: von der Montage bis zur spachtelfertigen Wand","lead":"<p>Sanitär Vorwandelemente beplanken heisst: Das verrohrte GIS-Element bekommt seine Hülle, und die Wand ist bereit für Platten oder Farbe. Wir übernehmen diesen Schritt auf Ihrer Baustelle, im Neubau wie im Umbau. Dazu gehört die Plattenwahl je nach Raum, der Zuschnitt um Rohrdurchführungen und Revisionsöffnungen, die Befestigung im vorgegebenen Raster und auf Wunsch die Spachtelung. In Nasszellen setzen wir AquaPanel ein, in trockenen Bereichen die passende Gipsplatte. Wir kommen auch dann, wenn die Elemente von einem anderen Betrieb gesetzt wurden. Sie erhalten eine Offerte mit Angaben zu Fläche, Plattentyp und Termin, damit Sie Ihre Folgegewerke planen können. Rufen Sie uns an oder schicken Sie uns Ihre Pläne.</p>","style":"light","items":[{"title":"Die Plattenwahl entscheidet über die Lebensdauer der Nasszelle","text":"<p>In Duschen, Bädern und WC-Anlagen beplanken wir mit AquaPanel. Die Platte nimmt kaum Wasser auf und bleibt auch bei dauernder Feuchte formstabil. In angrenzenden Trockenbereichen genügt in der Regel eine Gipsplatte, was Material und Kosten spart. Welche Kombination sinnvoll ist, klären wir vorgängig anhand Ihrer Pläne.</p>"},{"title":"Wir beplanken auch Elemente, die wir nicht gesetzt haben","text":"<p>Viele Anfragen erreichen uns mitten im Bauablauf, wenn die Sanitärinstallation steht und der Trockenbau stockt. Wir prüfen die gesetzten GIS-Elemente auf Fluchten, Befestigung und Rohrlage, bevor wir die erste Platte anschrauben. Abweichungen melden wir Ihnen, statt sie zuzudecken. So vermeiden Sie Nacharbeiten, wenn später die Sanitärapparate montiert werden.</p>"},{"title":"Revisionsöffnungen und Durchführungen werden vor dem Zuschnitt festgelegt","text":"<p>Spülkästen, Absperrventile und Verteiler brauchen dauerhaft Zugang. Wir markieren die Öffnungen anhand der Sanitärpläne und schneiden sie sauber aus, statt nachträglich zu stemmen. Rohrdurchführungen werden dicht und passgenau ausgeführt. Damit bleibt die Wand geschlossen und der Unterhalt trotzdem möglich.</p>"},{"title":"Beplankung und Spachtelung aus einer Hand sparen eine Schnittstelle","text":"<p>Auf Wunsch spachteln wir die beplankten Flächen bis zum vereinbarten Qualitätsniveau. Sie koordinieren dann einen Betrieb weniger und haben eine Ansprechperson für das Ergebnis. Das Niveau der Spachtelung halten wir in der Offerte fest, damit Maler oder Plattenleger wissen, was sie übernehmen.</p>"},{"title":"Ausflockung und SilentPanel für ruhigere Nasszellen","text":"<p>Wo Schallschutz gefragt ist, kombinieren wir die Beplankung mit Ausflockung oder SilentPanel. Der Hohlraum hinter der Vorwand wird gefüllt, bevor die zweite Plattenlage geschlossen wird. Das dämpft Spül- und Fliessgeräusche spürbar, besonders bei Wänden zu Schlaf- und Wohnräumen. Diese Massnahme muss vor der Beplankung entschieden werden.</p>"},{"title":"So läuft eine Anfrage bei uns ab","text":"<p>Sie senden uns Grundrisse, Sanitärpläne und den gewünschten Termin. Wir schätzen die Fläche, legen Plattentyp und Aufbau fest und stellen Ihnen eine Offerte zu. Nach Ihrer Freigabe reservieren wir das Zeitfenster und stimmen die Anlieferung mit der Bauleitung ab.</p>"}]}', 20, 1
FROM DUAL
WHERE @pid IS NOT NULL
  AND NOT EXISTS (SELECT 1 FROM sections WHERE page_id = @pid AND sort_order = 20);

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'faq', '{"heading":"Fragen und Antworten","subtitle":"","items":[{"question":"Womit werden Sanitär Vorwandelemente in Nasszellen beplankt?","answer":"<p>In Duschen und Bädern verwenden wir AquaPanel, weil die Platte auf Feuchtigkeit unempfindlich reagiert. In trockenen Zonen derselben Wohnung setzen wir Gipsplatten ein. Die Abgrenzung legen wir vor Arbeitsbeginn anhand Ihrer Pläne fest.</p>"},{"question":"Beplanken Sie auch Elemente, die ein anderer Betrieb montiert hat?","answer":"<p>Ja, das ist ein grosser Teil unserer Arbeit. Wir prüfen vorgängig Fluchten, Befestigung und Rohrlage und melden Ihnen allfällige Abweichungen. Erst danach beginnen wir mit der Beplankung.</p>"},{"question":"Übernehmen Sie auch die Spachtelung nach der Beplankung?","answer":"<p>Ja, Beplankung und Spachtelung erhalten Sie bei uns zusammen. Das vereinbarte Niveau halten wir in der Offerte fest, damit Maler und Plattenleger sauber anschliessen können.</p>"}]}', 30, 1
FROM DUAL
WHERE @pid IS NOT NULL
  AND NOT EXISTS (SELECT 1 FROM sections WHERE page_id = @pid AND sort_order = 30);

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'cta-banner', '{"heading":"Beplankung anfragen","body":"Senden Sie uns Ihre Sanitärpläne und den Wunschtermin, wir melden uns mit einer Offerte zu Fläche, Plattentyp und Zeitfenster.","button_text":"Pläne einsenden","button_url":"/kontakt"}', 40, 1
FROM DUAL
WHERE @pid IS NOT NULL
  AND NOT EXISTS (SELECT 1 FROM sections WHERE page_id = @pid AND sort_order = 40);

-- ────────────────────────────────────────────────────────────
-- Kontrolle
-- ────────────────────────────────────────────────────────────
-- SELECT slug, is_active, sort_order FROM pages ORDER BY sort_order;
-- SELECT p.slug, COUNT(s.id) AS sektionen FROM pages p
--   LEFT JOIN sections s ON s.page_id = p.id GROUP BY p.slug;
