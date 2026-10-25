-- ============================================================
-- SUI Innova GmbH
-- Nachtrag fuer eine Seite: /gis-elemente-beplanken
--
-- ERZEUGT VON dist/scripts/build_plan_0918.php seite gis-elemente-beplanken
-- Nicht von Hand bearbeiten, sondern den Generator anpassen.
--
-- Baut nur diese eine Seite neu auf. Das gewaehlte Kopfbild
-- bleibt, alle anderen Seiten bleiben unberuehrt.
--
-- Gefahrlos mehrfach ausfuehrbar.
-- ============================================================

SET NAMES utf8mb4;

SET @next_sort = (SELECT COALESCE(MAX(sort_order), 0) + 10 FROM pages);

-- ════════════════════════════════════════════════════════════
-- /gis-elemente-beplanken
-- Suchbegriff: gis elemente beplanken, gis beplankung, gis elemente montieren
-- ════════════════════════════════════════════════════════════

SET @pid = (SELECT id FROM pages WHERE slug = 'gis-elemente-beplanken' LIMIT 1);

UPDATE pages SET meta_title = 'GIS Beplankung: GIS Elemente beplanken | SUI Innova',
                 meta_desc  = 'GIS Elemente beplanken in der Werkstatt oder auf der Baustelle: AquaPanel, Gipsplatten, spachtelfertig. Pläne senden, Offerte erhalten.'
WHERE id = @pid AND @pid IS NOT NULL;

-- Gewaehltes Kopfbild merken, bevor die Sektionen fallen.
SET @img = (
    SELECT JSON_UNQUOTE(JSON_EXTRACT(content, '$.image_id'))
    FROM sections
    WHERE page_id = @pid AND type = 'parallax-image' AND JSON_VALID(content)
    ORDER BY sort_order ASC LIMIT 1
);

DELETE FROM sections WHERE page_id = @pid AND @pid IS NOT NULL;

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'parallax-image',
       JSON_SET('{"image_id":0,"height":"medium","overlay_text":"","alt":"Mit AquaPanel beplanktes GIS Element in der Werkstatt in Pfäffikon SZ"}', '$.image_id', CAST(COALESCE(@img, 0) AS UNSIGNED)),
       10, 1
FROM DUAL WHERE @pid IS NOT NULL;

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'content-grid', '{"items":[],"heading":"GIS Elemente beplanken: von der Vorfabrikation bis zur fertigen Wand","lead":"<p>GIS Elemente beplanken wir in unserer Werkstatt in Pfäffikon SZ oder direkt auf Ihrer Baustelle, je nachdem, was zu Ihrem Bauablauf passt. Nach der GIS Beplankung ist das Element verrohrt, beplankt und auf Wunsch gespachtelt, bereit für Plättli, Farbe oder SilentPanel. In Nasszellen setzen wir AquaPanel als Untergrund für Abdichtung und Plättli ein, in trockenen Bereichen Gipsplatten nach Ihrem Wandaufbau. Wir arbeiten mit Generalunternehmen, Totalunternehmen, Sanitärunternehmen, Bauleitungen und Architekten zusammen und richten uns nach Ihrem Bauprogramm. <a href=\\"/sanitaerelemente-vorfabrizieren\\">Vorfabrikation, Montage und Beplankung</a> kommen aus einer Hand. Das spart Schnittstellen auf der Baustelle: Sie koordinieren nicht mehr zwischen Sanitär, Schreiner und Gipser, sondern sprechen mit einem Ansprechpartner. Nennen Sie uns Stückzahl, Wandaufbau und Termin, dann rechnen wir Ihnen eine Offerte.</p>","style":"light"}', 20, 1
FROM DUAL WHERE @pid IS NOT NULL;

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'text-block', '{"heading":"GIS Beplankung: Was dazugehört","body":"<p>Zur GIS Beplankung gehören vier Punkte, die wir vorab mit Ihnen festlegen:</p><ul><li><strong>Plattenart je Bereich:</strong> AquaPanel in Duschen, Bädern und WC-Anlagen, Gipsplatten im trockenen Bereich nach Ihrem Wandaufbau.</li><li><strong>Schriftlich festgehalten:</strong> Plattenart und Stärke halten wir vor Produktionsstart schriftlich fest.</li><li><strong>Spachtelstufe nach Belag:</strong> Plättli, Farbe und SilentPanel verlangen unterschiedliche Stufen. Sie nennen uns den Belag, wir legen die Spachtelstufe fest.</li><li><strong>Ort nach Wunsch:</strong> Wir beplanken in unserer Werkstatt in Pfäffikon SZ oder auf Ihrer Baustelle.</li></ul>","alignment":"left"}', 30, 1
FROM DUAL WHERE @pid IS NOT NULL;

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'content-grid', '{"heading":"","lead":"","style":"light","items":[{"title":"In der Werkstatt beplankt, auf der Baustelle nur noch versetzt","text":"<p>Wir <a href=\\"/sanitaer-gis-elemente-bestellen\\">verrohren und beplanken die GIS Elemente</a> vorgängig in unserer Werkstatt in Pfäffikon SZ. Auf der Baustelle wird das Element versetzt, angeschlossen und fertig gespachtelt. Das verkürzt die Zeit, in der Ihre Leute im Rohbau gebunden sind. Zudem arbeiten wir witterungsunabhängig, auch wenn die Baustelle noch nicht geschlossen ist. Den Liefertermin halten wir in der Offerte fest.</p>"},{"title":"AquaPanel in der Nasszelle, Gipsplatten im trockenen Bereich","text":"<p>In Duschen, Bädern und WC-Anlagen beplanken wir mit AquaPanel. Die Platte bleibt formstabil, wenn Feuchtigkeit auf sie trifft, und dient als Untergrund für Abdichtung und Plättli. In trockenen Bereichen verwenden wir Gipsplatten nach Ihrem Wandaufbau. Welche Plattenart und welche Stärke wo zum Einsatz kommt, halten wir vor Produktionsstart schriftlich fest.</p>"},{"title":"Spachtelqualität nach Ihrem Ausbaustandard","text":"<p>Wir spachteln die Stösse und Schraubstellen so weit, wie es der nachfolgende Belag verlangt. Für Plättli genügt eine andere Stufe als für eine gestrichene Wand oder für SilentPanel. Sagen Sie uns, was auf die Wand kommt, dann legen wir die Spachtelstufe fest. So vermeiden Sie Nacharbeiten, wenn der Maler oder Plattenleger übernimmt.</p>"},{"title":"Vorbereitung entscheidet über das Montagetempo","text":"<p>Vor der Montage prüfen wir Achsmasse, Bodenaufbau und Anschlusspunkte am Plan. Passen die Masse nicht, klären wir das vorgängig mit Ihnen und nicht erst mit dem Element an der Wand. Wir markieren die Positionen auf dem Rohboden und kontrollieren, ob Rohrdurchführungen und Schächte frei sind. So steht das erste Element kurz nach Anlieferung an seinem Platz.</p>"},{"title":"So montieren wir GIS Elemente auf der Baustelle","text":"<p>Wir stellen das Element auf, richten es lot- und waagrecht aus und verschrauben die Ständer mit Boden und Wand. Anschliessend verbinden wir die vorfabrizierten Rohrstränge mit der Steigzone und setzen Befestigungen für Keramik und Armaturen. Abflüsse und Wasserleitungen werden gefasst, damit später keine Schallbrücken entstehen. Auf Wunsch führen wir die Dichtheitsprüfung durch und protokollieren sie.</p>"},{"title":"Ein Team statt drei Schnittstellen","text":"<p>Vorfabrikation, Montage und Beplankung laufen bei uns über dieselbe Ansprechperson. Sie melden Änderungen an einer Stelle, nicht an drei. Verschiebt sich Ihr Bauprogramm, planen wir die Montagetage um. Das reduziert Rückfragen auf der Baustelle und Wartezeiten zwischen den Gewerken.</p>"}]}', 40, 1
FROM DUAL WHERE @pid IS NOT NULL;

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'text-block', '{"heading":"Vom Plan zur beplankten Wand in vier Schritten","body":"<ol><li>Sie senden uns die Sanitärpläne, die Stückzahl der Elemente, den gewünschten Wandaufbau, den Montagetermin und den Belag, der auf die Beplankung kommt.</li><li>Wir rechnen Ihnen eine Offerte mit Positionen für Vorfabrikation, Montage und Beplankung. Fehlen Angaben, fragen wir nach, bevor wir eine Zahl nennen.</li><li>Vor Produktionsstart halten wir Plattenart, Stärke und Liefertermin schriftlich fest.</li><li>Wir beplanken in unserer Werkstatt, und Sie erhalten das Element bereit zum Versetzen. Oder wir beplanken direkt auf Ihrer Baustelle.</li></ol>","alignment":"left"}', 50, 1
FROM DUAL WHERE @pid IS NOT NULL;

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'text-block', '{"heading":"Nur die Beplankung: auch für Elemente anderer Lieferanten","body":"<p>Sind die GIS Elemente bereits gesetzt oder von einer anderen Firma geliefert, übernehmen wir nur die Beplankung. Unser Team kommt in der ganzen Deutschschweiz auf Ihre Baustelle und arbeitet nach Ihrem Terminplan. Vorgängig schauen wir uns Pläne oder Fotos an und klären den Wandaufbau.</p>","alignment":"left"}', 60, 1
FROM DUAL WHERE @pid IS NOT NULL;

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'faq', '{"heading":"Fragen und Antworten","subtitle":"","items":[{"question":"Welche Platten verwenden Sie bei der GIS Beplankung?","answer":"<p>In Duschen, Bädern und WC-Anlagen beplanken wir mit AquaPanel. Die Platte bleibt formstabil, wenn Feuchtigkeit auf sie trifft, und dient als Untergrund für Abdichtung und Plättli. In trockenen Bereichen verwenden wir Gipsplatten nach Ihrem Wandaufbau. Plattenart und Stärke halten wir vor Produktionsstart schriftlich fest.</p>"},{"question":"Beplanken Sie GIS Elemente auch direkt auf der Baustelle?","answer":"<p>Ja. Wir beplanken in unserer Werkstatt in Pfäffikon SZ oder vor Ort auf Ihrer Baustelle. Welche Variante sinnvoll ist, hängt von Zugang, Bauprogramm und Stückzahl ab.</p>"},{"question":"Wie weit spachteln Sie die beplankten Elemente?","answer":"<p>Wir spachteln Stösse und Schraubstellen so weit, wie es der nachfolgende Belag verlangt. Für Plättli genügt eine andere Stufe als für eine gestrichene Wand oder für SilentPanel. Sie sagen uns, was auf die Wand kommt, wir legen die Spachtelstufe fest.</p>"},{"question":"Können Sie auch GIS Elemente beplanken, die nicht von Ihnen stammen?","answer":"<p>Ja. Sind die Elemente bereits gesetzt oder von einer anderen Firma geliefert, übernehmen wir nur die Beplankung. Wir kommen dafür in der ganzen Deutschschweiz auf Ihre Baustelle. Elemente, die Sie selber bestellt haben, versetzen wir auf Wunsch auch. Senden Sie uns vorgängig den Wandaufbau und die Anschlusspläne, damit wir richtig kalkulieren. Bei fremden Elementen prüfen wir vor Ort den Zustand der Verrohrung.</p>"},{"question":"Was brauchen Sie für die Offerte?","answer":"<p>Wir brauchen die Sanitärpläne, die Stückzahl der Elemente und den gewünschten Wandaufbau. Dazu nennen Sie uns den Montagetermin und den Belag, der auf die Beplankung kommt. Fehlen Angaben, fragen wir nach, bevor wir eine Zahl nennen.</p>"},{"question":"Wie lange dauert die Montage eines GIS Elements?","answer":"<p>Das hängt von Grösse, Anzahl Anschlüsse und Zugang zur Baustelle ab. Weil die Elemente verrohrt ankommen, bleibt auf der Baustelle vor allem Versetzen, Ausrichten und Anschliessen. Nach Sichtung Ihrer Pläne weisen wir die Montagezeit pro Element in der Offerte aus.</p>"},{"question":"In welcher Region montieren Sie?","answer":"<p>Unsere Werkstatt steht in Pfäffikon SZ, von dort fahren unsere Monteure in der ganzen Deutschschweiz auf die Baustellen. Fragen Sie mit Ihrer Ortschaft an, dann sagen wir Ihnen, ob wir den Auftrag übernehmen.</p>"}]}', 70, 1
FROM DUAL WHERE @pid IS NOT NULL;

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'link-list', '{"heading":"Passend dazu","items":[{"slug":"leistungen","text":"Sanitär Vorfabrikation: alle Leistungen"},{"slug":"sanitaer-gis-elemente-bestellen","text":"GIS Elemente verrohrt bestellen"},{"slug":"sanitaerelemente-vorfabrizieren","text":"Sanitärelemente vorfabrizieren lassen"},{"slug":"sanitaerelemente-montieren","text":"Sanitärelemente montieren"},{"slug":"sanitaer-vorwaende","text":"Sanitär Vorwände vorfabriziert und montiert"},{"slug":"sanitaer-vorwandelemente-beplanken","text":"Sanitär Vorwandelemente beplanken"}]}', 80, 1
FROM DUAL WHERE @pid IS NOT NULL;

INSERT INTO sections (page_id, type, content, sort_order, is_active)
SELECT @pid, 'cta-banner', '{"heading":"GIS Beplankung anfragen","body":"Senden Sie uns Ihre Sanitärpläne mit Stückzahl, Wandaufbau und Termin, wir rechnen Ihnen eine Offerte für die Beplankung.","button_text":"Pläne senden, Offerte erhalten","button_url":"/kontakt"}', 90, 1
FROM DUAL WHERE @pid IS NOT NULL;

-- ────────────────────────────────────────────────────────────
-- Kontrolle
-- ────────────────────────────────────────────────────────────
-- SELECT slug, is_active, LEFT(meta_title, 60) FROM pages ORDER BY sort_order;
-- SELECT p.slug, COUNT(s.id) AS sektionen,
--        GROUP_CONCAT(s.type ORDER BY s.sort_order) AS aufbau
-- FROM pages p LEFT JOIN sections s ON s.page_id = p.id
-- GROUP BY p.slug ORDER BY p.sort_order;
