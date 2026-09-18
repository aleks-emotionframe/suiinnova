<?php
/**
 * Generator: Umsetzung des Keyword-Plans vom 18.09.2026
 *
 * Quelle: "Keyword-Plan fuer sui-innova.ch", EmotionFrame GmbH, 18.09.2026.
 * Zwoelf Suchbegriffe auf neun Seiten, davon zwei neu.
 *
 * Uebernommen sind je Seite: Seitentitel, Meta-Description, Haupt-
 * ueberschrift, Bild-Alt-Text, Einleitung, die Abschnitte unter "Aufbau
 * der Seite", die Fragen und Antworten, die Handlungsaufforderung und
 * die interne Verlinkung.
 *
 * ZWEI WIDERSPRUECHE IM PLAN
 *
 *   /sanitaer-gis-elemente-bestellen bekommt drei verschiedene Titel und
 *   H1 zugewiesen (Seiten 8, 11 und 25 des Plans). Eine Seite traegt
 *   einen Titel. Genommen ist der Vorschlag von Seite 25, weil die Seite
 *   damit heute auf Position 2 steht und in der KI-Uebersicht zitiert
 *   wird. Die Inhalte der beiden anderen Abschnitte stehen als eigene
 *   Zwischentitel auf derselben Seite.
 *
 *   /gis-elemente-beplanken bekommt zwei Titel (Seiten 14 und 33).
 *   Genommen ist Seite 33, passend zur Adresse der Seite. Die
 *   Montage-Abschnitte von Seite 14 stehen als Zwischentitel dazu.
 *
 * PLATZHALTER
 *
 *   Der Plan setzt 25 Mal [ANGABE FEHLT: ...] in den Text. Diese Saetze
 *   sind umformuliert, nicht mit erfundenen Zahlen gefuellt. Ausnahme:
 *   das Einsatzgebiet ist bekannt und steht als "ganze Deutschschweiz".
 *
 * Aufrufe:
 *   php dist/scripts/build_plan_0918.php            SQL
 *   php dist/scripts/build_plan_0918.php checkliste Fragen an den Kunden
 *   php dist/scripts/build_plan_0918.php pruefen    Selbstkontrolle
 */

// ─────────────────────────────────────────────────────────────
// Bausteine, die mehrfach vorkommen
// ─────────────────────────────────────────────────────────────

const CTA_BUTTON = 'Pläne einsenden';
const CTA_URL    = '/kontakt';

/** Linktexte, mit denen auf eine Seite verwiesen wird. */
$anker = [
    'leistungen'                         => 'Sanitär Vorfabrikation: alle Leistungen',
    'sanitaer-gis-elemente-bestellen'    => 'Sanitär GIS Elemente bestellen',
    'gis-elemente-beplanken'             => 'GIS Elemente beplanken und montieren',
    'sanitaer-vorwandelemente'           => 'Sanitär Vorwandelemente: Aufbau und Montage',
    'sanitaer-vorwandelemente-bestellen' => 'Sanitär Vorwandelemente bestellen',
    'sanitaer-vorwaende'                 => 'Sanitär Vorwände vorfabriziert und montiert',
    'sanitaer-vorwandelemente-beplanken' => 'Sanitär Vorwandelemente beplanken',
    'sanitaerelemente-vorfabrizieren'    => 'Sanitärelemente vorfabrizieren lassen',
    'sanitaerelemente-montieren'         => 'Sanitärelemente montieren',
];

/**
 * Ankertexte, die im Plan von einer bestimmten Quellseite aus abweichen.
 *
 * Die Tabelle oben nennt je Zielseite einen Standardtext. Wo der Plan von
 * einer Quellseite aus einen anderen Text vorschlaegt UND dieser Text die
 * Zielseite beschreibt, gilt der Text aus dem Plan. Abwechslung im
 * Ankertext ist ausserdem natuerlicher als derselbe Satz auf acht Seiten.
 *
 *   [Quellseite][Zielseite] => Text aus dem Plan
 */
$ankerAusnahmen = [
    'sanitaer-gis-elemente-bestellen' => [
        'gis-elemente-beplanken' => 'GIS Elemente montieren lassen',
    ],
    'gis-elemente-beplanken' => [
        'sanitaer-gis-elemente-bestellen' => 'GIS Elemente verrohrt bestellen',
    ],
    'sanitaer-vorwandelemente' => [
        'sanitaerelemente-montieren' => 'Montage von Sanitär Vorwandelementen',
    ],
    'sanitaer-vorwandelemente-bestellen' => [
        'sanitaer-gis-elemente-bestellen' => 'GIS Elemente bestellen',
    ],
    'sanitaer-vorwandelemente-beplanken' => [
        'gis-elemente-beplanken' => 'Beplankung von GIS Elementen',
    ],
    'referenzen' => [
        'sanitaer-gis-elemente-bestellen' => 'vorfabrizierte GIS Elemente bestellen',
        'gis-elemente-beplanken'          => 'beplankte GIS Elemente aus unserer Werkstatt',
    ],
];

$seiten = [];


// ═════════════════════════════════════════════════════════════
// 1) /leistungen — Suchbegriff "sanitär vorfabrikation"
//    Plan Seite 5 bis 7. Position heute: nicht in den Top 20.
//    Modus "ergaenzen": die Seite hat ein eigenes Layout mit
//    Leistungskarten. Das bleibt, Einleitung und Abschnitte kommen
//    dazu.
// ═════════════════════════════════════════════════════════════
$seiten[] = [
    'slug'       => 'leistungen',
    'modus'      => 'ergaenzen',
    'keyword'    => 'sanitär vorfabrikation',
    'nav_label'  => 'Leistungen',
    'meta_title' => 'Sanitär Vorfabrikation: Leistungen | SUI Innova',
    'meta_desc'  => 'Sanitär Vorfabrikation aus Pfäffikon SZ: verrohrte GIS-Elemente, Beplankung, Aqua Panel und Montage. Pläne einsenden und Offerte erhalten.',
    'h1'         => 'Sanitär Vorfabrikation: verrohrte GIS-Elemente aus unserer Werkstatt',
    'alt'        => 'Verrohrtes GIS-Element in der Werkstatt von SUI Innova in Pfäffikon SZ',
    'intro'      => 'Sie erhalten von uns GIS-Elemente, die bereits verrohrt auf die Baustelle kommen. Unsere Sanitär Vorfabrikation umfasst Trinkwasser- und Abwasserleitungen, die wir in der Werkstatt in Pfäffikon SZ am Element montieren. Auf Wunsch beplanken und spachteln wir die Elemente vorgängig, mit Gipsplatten oder mit Aqua Panel für Nasszellen. Danach montiert unser eigenes Team die Elemente direkt bei Ihnen auf der Baustelle. Sie koordinieren also nicht vier Firmen, sondern sprechen mit einer. Das verkürzt die Zeit auf der Baustelle, weil das Verrohren nicht mehr am Gerüst oder im Rohbau stattfindet. Senden Sie uns Ihre Sanitärpläne, wir prüfen sie und melden uns mit einer Offerte.',
    'body' => [
        ['Wir verrohren die Elemente, bevor sie die Werkstatt verlassen',
         'Trinkwasser- und Abwasserleitungen installieren wir direkt am GIS-Element. Das Element kommt einbaufertig auf die Baustelle. Ihre Monteure setzen es, schliessen an und sind fertig. Arbeiten in der Werkstatt lassen sich besser kontrollieren als Arbeiten im Rohbau bei Wind und Wetter.'],
        ['Beplankung und Spachtelung sparen einen Handwerkerwechsel',
         'Auf Wunsch verkleiden wir die Elemente mit Gipsplatten und spachteln sie fertig. Die Wand ist dann bereit für Plättli oder Anstrich. So entfällt ein zusätzlicher Termin mit dem Gipser. Welche Spachtelstufe nötig ist, richtet sich nach dem Belag, der auf die Wand kommt. Nennen Sie uns Plättli, Anstrich oder SilentPanel, dann legen wir die Stufe vor Produktionsstart fest.'],
        ['Aqua Panel für Duschen und Nassräume',
         'In Nasszellen setzen wir Aqua Panel als Untergrund für Abdichtung und Plättli ein. Die Platten vertragen Feuchtigkeit deutlich besser als Standard-Gipsplatten. Wir verwenden sie in Bädern, Duschen und in industriellen Nassräumen. Sagen Sie uns beim Anfragen, welche Räume nass werden, dann planen wir den Aufbau entsprechend.'],
        ['Unser eigenes Team montiert auf Ihrer Baustelle',
         'Die Montage übernehmen unsere Monteure, nicht ein zugekaufter Subunternehmer. Sie haben damit denselben Ansprechpartner wie für die Vorfabrikation. Termine stimmen wir vorgängig mit Ihrer Bauleitung ab. Wenn auf der Baustelle etwas ändert, passen wir in der Werkstatt an.'],
        ['So läuft eine Anfrage ab',
         'Sie senden uns die Sanitär- und Grundrisspläne. Wir prüfen die Elemente, klären offene Punkte mit Ihnen und stellen eine Offerte. Nach Ihrer Freigabe legen wir den Liefertermin fest und starten die Vorfabrikation. Den verbindlichen Termin halten wir in der Offerte schriftlich fest, damit Ihre Bauleitung damit planen kann.'],
        ['Für wen wir arbeiten',
         'Wir liefern an Sanitärinstallateure, Generalunternehmer und Bauleitungen. Typisch sind Wohnbauten mit wiederkehrenden Nasszellen, wo sich die Vorfabrikation rechnet. Einzelne Elemente für kleinere Umbauten fertigen wir ebenfalls. Nennen Sie uns die Stückzahl, dann rechnen wir die Offerte darauf.'],
    ],
    'faq' => [
        ['Was kostet ein vorfabriziertes GIS-Element?',
         'Der Preis hängt von Grösse, Anzahl Anschlüsse und Beplankung ab. Wir rechnen die Elemente anhand Ihrer Pläne und schicken Ihnen eine Offerte mit einzelnen Positionen.'],
        ['Liefern Sie auch ausserhalb der Region Pfäffikon SZ?',
         'Unsere Werkstatt steht in Pfäffikon SZ, von dort liefern wir in der ganzen Deutschschweiz auf die Baustelle. Nennen Sie uns die Adresse der Baustelle, dann halten wir Anlieferung und Transport in der Offerte fest.'],
        ['Müssen die Pläne fertig sein, damit Sie offerieren können?',
         'Für eine verbindliche Offerte brauchen wir die Sanitärpläne mit Anschlusspositionen. Für eine grobe Einschätzung genügen Grundrisse und die Anzahl Nasszellen. Offene Punkte klären wir vorgängig mit Ihnen.'],
    ],
    'cta_heading' => 'Pläne einsenden, Offerte erhalten',
    'cta_text'    => 'Senden Sie uns Ihre Sanitärpläne über das Kontaktformular, wir prüfen sie und melden uns mit einer Offerte.',
    'textlinks' => [
        ['beplanken und spachteln wir die Elemente vorgängig', 'gis-elemente-beplanken'],
        ['montiert unser eigenes Team die Elemente', 'sanitaerelemente-montieren'],
    ],
    'links' => [
        'sanitaer-gis-elemente-bestellen',
        'gis-elemente-beplanken',
        'sanitaerelemente-vorfabrizieren',
        'sanitaerelemente-montieren',
        'sanitaer-vorwandelemente',
        'sanitaer-vorwandelemente-bestellen',
        'sanitaer-vorwaende',
        'sanitaer-vorwandelemente-beplanken',
    ],
];


// ═════════════════════════════════════════════════════════════
// 2) /sanitaer-gis-elemente-bestellen
//    Drei Suchbegriffe: "sanitär gis elemente bestellen" (Position 2,
//    mit KI-Zitat), "gis elemente bestellen" (Position 11) und
//    "gis elemente vorfabrizieren". Plan Seiten 8, 11 und 25.
// ═════════════════════════════════════════════════════════════
$seiten[] = [
    'slug'       => 'sanitaer-gis-elemente-bestellen',
    'modus'      => 'neubau',
    'keyword'    => 'sanitär gis elemente bestellen, gis elemente bestellen, gis elemente vorfabrizieren',
    'nav_label'  => 'GIS-Elemente bestellen',
    'meta_title' => 'Sanitär GIS Elemente bestellen | SUI Innova',
    'meta_desc'  => 'GIS Elemente fix und fertig verrohrt aus Pfäffikon SZ, auf der Baustelle nur noch stellen und anschliessen. Pläne senden, Offerte mit Termin erhalten.',
    'h1'         => 'Sanitär GIS Elemente bestellen: verrohrt ab Werkstatt Pfäffikon',
    'alt'        => 'Fertig verrohrtes Sanitär GIS Element in der Werkstatt von SUI Innova in Pfäffikon SZ',
    'intro'      => 'Wer Sanitär GIS Elemente bestellen will, braucht sie fertig verrohrt, richtig bemasst und termingerecht auf der Baustelle. Genau das liefern wir aus unserer Werkstatt in Pfäffikon SZ. Wir bauen die Elemente nach Ihren Plänen auf, verrohren sie komplett und bereiten sie für den Transport vor. Auf der Baustelle werden sie nur noch gestellt und angeschlossen. Auf Wunsch übernehmen wir zusätzlich die Montage, die Beplankung mit AquaPanel, die Spachtelung und die Ausflockung mit SilentPanel. Sie haben dabei eine Ansprechperson für den ganzen Ablauf. Senden Sie uns Ihre Sanitärpläne oder eine Skizze mit Apparateliste. Wir prüfen die Unterlagen, klären offene Punkte direkt mit Ihnen und erstellen eine Offerte mit Preis und möglichem Liefertermin.',
    'body' => [
        ['So läuft die Bestellung ab: vier Schritte bis zur Lieferung',
         'Sie senden uns die Sanitärpläne, die Apparateliste und den gewünschten Liefertermin. Wir prüfen die Unterlagen und melden uns bei Unklarheiten, bevor wir rechnen. Nach Ihrer Freigabe der Offerte planen wir die Produktion ein und bestätigen den Termin. Dann bauen und verrohren wir die Elemente und liefern sie auf die Baustelle.'],
        ['Was wir für die Offerte von Ihnen brauchen',
         'Am schnellsten geht es mit Sanitärplänen im Massstab, einer Apparateliste und Angaben zu Wandhöhe und Anschlusssituation. Auch eine saubere Handskizze reicht für einen ersten Preis. Nennen Sie uns dazu den Wunschtermin und den Ort der Baustelle. Fehlt etwas, fragen wir vorgängig nach, statt Annahmen zu treffen.'],
        ['Fix und fertig verrohrt statt auf der Baustelle zusammenbauen',
         'In der Werkstatt arbeiten wir witterungsunabhängig und an einem eingerichteten Platz. Die Leitungen werden montiert, befestigt und für die Druckprobe vorbereitet. Auf der Baustelle entfällt damit ein grosser Teil der Installationszeit. Das entlastet den Bauablauf besonders bei mehreren gleichen Nasszellen.'],
        ['GIS Elemente vorfabrizieren lassen: für welche Projekte es sich rechnet',
         'Sinnvoll wird die Vorfabrikation, sobald sich Nasszellen wiederholen, etwa im Wohnungsbau, in Überbauungen oder bei Sanierungen ganzer Steigzonen. Gleiche Elemente lassen sich in Serie aufbauen, das verkürzt die Zeit auf der Baustelle. Auch bei engen Platzverhältnissen ist die Vorfertigung ein Vorteil, weil weniger Material und weniger Arbeitsschritte vor Ort nötig sind. Bei Einzelstücken prüfen wir gerne, ob sich der Aufwand lohnt.'],
        ['GIS Elemente bestellen: Einzelelemente und ganze Nasszellen',
         'Wir montieren die GIS Ständer, setzen die Elemente für WC, Waschtisch, Dusche und Badewanne ein und verrohren Wasser und Abwasser vollständig. Die Elemente verlassen unsere Werkstatt in einem Zustand, in dem sie nur noch gestellt, befestigt und angeschlossen werden. Das verkürzt die Arbeitszeit auf der Baustelle und reduziert Schnittstellen. Sanitärinstallateure, Generalunternehmen und Bauherrschaften bestellen bei uns Einzelelemente ebenso wie ganze Nasszellen.'],
        ['Montage, Beplankung und Spachtelung auf Wunsch dazu',
         'Unser eigenes Team stellt die Elemente auf der Baustelle und richtet sie aus. Danach beplanken wir mit AquaPanel als Untergrund für Abdichtung und Plättli. Auf Wunsch spachteln wir die Flächen und flocken mit SilentPanel aus. Sie entscheiden, ob Sie nur die Lieferung oder die fertige Wand bestellen.'],
        ['Lieferung und Transport in der ganzen Deutschschweiz',
         'Die Elemente werden transportsicher vorbereitet und nach Absprache angeliefert. Wir liefern ab Werkstatt Pfäffikon SZ in der ganzen Deutschschweiz. Sagen Sie uns vorgängig, wie die Zufahrt aussieht und ob ein Kran oder Stapler vor Ort ist. So planen wir die Abladung passend zur Baustelle.'],
    ],
    'faq' => [
        ['Wie lange dauert es, bis ich die GIS Elemente erhalte?',
         'Die Dauer hängt von Stückzahl, Ausführung und aktueller Auslastung ab. Nach Prüfung Ihrer Pläne nennen wir Ihnen in der Offerte einen konkreten Liefertermin.'],
        ['Kann ich auch einzelne Elemente bestellen?',
         'Ja, wir fertigen sowohl Einzelelemente als auch Serien für mehrere gleiche Nasszellen. Sagen Sie uns die Stückzahl, dann rechnen wir Ihnen den Preis entsprechend.'],
        ['Muss ich die Montage bei Ihnen bestellen?',
         'Nein, Sie können die Elemente auch nur liefern lassen und selbst stellen. Wenn Sie die Montage, die Beplankung und die Spachtelung dazunehmen, kommt alles aus einer Hand.'],
        ['Reicht eine Skizze statt eines fertigen Sanitärplans?',
         'Für eine erste Einschätzung und eine Richtofferte genügt eine Skizze mit Apparateliste. Für die Produktion brauchen wir danach verbindliche Masse und Anschlusspositionen. Offene Punkte klären wir vorgängig mit Ihnen.'],
    ],
    'cta_heading' => 'GIS Elemente anfragen',
    'cta_text'    => 'Senden Sie uns Ihre Sanitärpläne oder eine Skizze mit Apparateliste, wir prüfen die Unterlagen und schicken Ihnen eine Offerte mit Preis und Liefertermin.',
    'textlinks' => [
        ['die Beplankung mit AquaPanel', 'gis-elemente-beplanken'],
        ['die Montage', 'sanitaerelemente-montieren'],
    ],
    'links' => [
        'gis-elemente-beplanken',
        'sanitaerelemente-vorfabrizieren',
    ],
];


// ═════════════════════════════════════════════════════════════
// 3) /gis-elemente-beplanken
//    Zwei Suchbegriffe: "gis elemente beplanken" und "gis elemente
//    montieren". Plan Seiten 14 und 33.
// ═════════════════════════════════════════════════════════════
$seiten[] = [
    'slug'       => 'gis-elemente-beplanken',
    'modus'      => 'neubau',
    'keyword'    => 'gis elemente beplanken, gis elemente montieren',
    'nav_label'  => 'GIS-Elemente beplanken',
    'meta_title' => 'GIS Elemente beplanken in Pfäffikon SZ | SUI Innova',
    'meta_desc'  => 'GIS Elemente beplanken lassen: verrohrt, beplankt und gespachtelt aus der Werkstatt in Pfäffikon SZ oder direkt auf Ihrer Baustelle. Senden Sie uns Ihre Pläne.',
    'h1'         => 'GIS Elemente beplanken: von der Vorfabrikation bis zur fertigen Wand',
    'alt'        => 'Mit AquaPanel beplanktes GIS Element in der Werkstatt in Pfäffikon SZ',
    'intro'      => 'Wir beplanken GIS Elemente in unserer Werkstatt in Pfäffikon SZ und direkt auf Ihrer Baustelle. Sie erhalten die Elemente verrohrt, beplankt und gespachtelt, bereit für Plättli, Farbe oder SilentPanel. In Nasszellen setzen wir AquaPanel als Untergrund für Abdichtung und Plättli ein, in trockenen Bereichen Gipsplatten nach Ihrem Wandaufbau. Wir arbeiten mit Sanitärfirmen, Generalunternehmen und Bauleitungen zusammen und richten uns nach Ihrem Bauprogramm. Vorfabrikation, Montage und Beplankung kommen aus einer Hand. Das spart Schnittstellen auf der Baustelle: Sie koordinieren nicht mehr zwischen Sanitär, Schreiner und Gipser, sondern sprechen mit einem Ansprechpartner. Nennen Sie uns Stückzahl, Wandaufbau und Termin, dann rechnen wir Ihnen eine Offerte.',
    'body' => [
        ['In der Werkstatt beplankt, auf der Baustelle nur noch versetzt',
         'Wir verrohren und beplanken die GIS Elemente vorgängig in unserer Werkstatt in Pfäffikon SZ. Auf der Baustelle wird das Element versetzt, angeschlossen und fertig gespachtelt. Das verkürzt die Zeit, in der Ihre Leute im Rohbau gebunden sind. Zudem arbeiten wir witterungsunabhängig, auch wenn die Baustelle noch nicht geschlossen ist. Den Liefertermin halten wir in der Offerte fest.'],
        ['AquaPanel in der Nasszelle, Gipsplatten im trockenen Bereich',
         'In Duschen, Bädern und WC-Anlagen beplanken wir mit AquaPanel. Die Platte bleibt formstabil, wenn Feuchtigkeit auf sie trifft, und dient als Untergrund für Abdichtung und Plättli. In trockenen Bereichen verwenden wir Gipsplatten nach Ihrem Wandaufbau. Welche Plattenart und welche Stärke wo zum Einsatz kommt, halten wir vor Produktionsstart schriftlich fest.'],
        ['Spachtelqualität nach Ihrem Ausbaustandard',
         'Wir spachteln die Stösse und Schraubstellen so weit, wie es der nachfolgende Belag verlangt. Für Plättli genügt eine andere Stufe als für eine gestrichene Wand oder für SilentPanel. Sagen Sie uns, was auf die Wand kommt, dann legen wir die Spachtelstufe fest. So vermeiden Sie Nacharbeiten, wenn der Maler oder Plattenleger übernimmt.'],
        ['Vorbereitung entscheidet über das Montagetempo',
         'Vor der Montage prüfen wir Achsmasse, Bodenaufbau und Anschlusspunkte am Plan. Passen die Masse nicht, klären wir das vorgängig mit Ihnen und nicht erst mit dem Element an der Wand. Wir markieren die Positionen auf dem Rohboden und kontrollieren, ob Rohrdurchführungen und Schächte frei sind. So steht das erste Element kurz nach Anlieferung an seinem Platz.'],
        ['So montieren wir GIS Elemente auf der Baustelle',
         'Wir stellen das Element auf, richten es lot- und waagrecht aus und verschrauben die Ständer mit Boden und Wand. Anschliessend verbinden wir die vorfabrizierten Rohrstränge mit der Steigzone und setzen Befestigungen für Keramik und Armaturen. Abflüsse und Wasserleitungen werden gefasst, damit später keine Schallbrücken entstehen. Auf Wunsch führen wir die Dichtheitsprüfung durch und protokollieren sie.'],
        ['Ein Team statt drei Schnittstellen',
         'Vorfabrikation, Montage und Beplankung laufen bei uns über dieselbe Ansprechperson. Sie melden Änderungen an einer Stelle, nicht an drei. Verschiebt sich Ihr Bauprogramm, planen wir die Montagetage um. Das reduziert Rückfragen auf der Baustelle und Wartezeiten zwischen den Gewerken.'],
        ['Wir beplanken auch Elemente, die nicht von uns kommen',
         'Sind die GIS Elemente bereits gesetzt oder von einer anderen Firma geliefert, übernehmen wir nur die Beplankung. Unser Team kommt in der ganzen Deutschschweiz auf Ihre Baustelle und arbeitet nach Ihrem Terminplan. Vorgängig schauen wir uns Pläne oder Fotos an und klären den Wandaufbau.'],
        ['Was wir für die Offerte brauchen',
         'Schicken Sie uns die Sanitärpläne, die Stückzahl der Elemente und den gewünschten Wandaufbau. Nennen Sie zusätzlich den Montagetermin und den Belag, der auf die Beplankung kommt. Darauf rechnen wir Ihnen eine Offerte mit Positionen für Vorfabrikation, Montage und Beplankung. Fehlen Angaben, fragen wir nach, bevor wir eine Zahl nennen.'],
    ],
    'faq' => [
        ['Beplanken Sie GIS Elemente auch direkt auf der Baustelle?',
         'Ja. Wir beplanken in unserer Werkstatt in Pfäffikon SZ oder vor Ort auf Ihrer Baustelle. Welche Variante sinnvoll ist, hängt von Zugang, Bauprogramm und Stückzahl ab.'],
        ['Welche Platten verwenden Sie für Nasszellen?',
         'In Nasszellen beplanken wir mit AquaPanel, weil die Platte als Untergrund für Abdichtung und Plättli geeignet ist. In trockenen Bereichen setzen wir Gipsplatten ein. Den Aufbau legen wir vor der Produktion mit Ihnen fest.'],
        ['Übernehmen Sie auch das Spachteln?',
         'Ja, wir spachteln die beplankten Elemente bis zu der Stufe, die Ihr Belag verlangt. Für Plättli, Farbe oder SilentPanel gelten unterschiedliche Anforderungen. Teilen Sie uns den geplanten Belag mit, dann stimmen wir die Spachtelung darauf ab.'],
        ['Montieren Sie auch GIS Elemente, die nicht von Ihnen vorfabriziert wurden?',
         'Ja, wir versetzen und beplanken auch Elemente, die Sie selber bestellt haben. Senden Sie uns vorgängig den Wandaufbau und die Anschlusspläne, damit wir die Montage richtig kalkulieren. Bei fremden Elementen prüfen wir vor Ort den Zustand der Verrohrung.'],
        ['Wie lange dauert die Montage eines GIS Elements?',
         'Das hängt von Grösse, Anzahl Anschlüsse und Zugang zur Baustelle ab. Weil die Elemente verrohrt ankommen, bleibt auf der Baustelle vor allem Versetzen, Ausrichten und Anschliessen. Nach Sichtung Ihrer Pläne weisen wir die Montagezeit pro Element in der Offerte aus.'],
        ['In welcher Region montieren Sie?',
         'Unsere Werkstatt steht in Pfäffikon SZ, von dort fahren unsere Monteure in der ganzen Deutschschweiz auf die Baustellen. Fragen Sie mit Ihrer Ortschaft an, dann sagen wir Ihnen, ob wir den Auftrag übernehmen.'],
    ],
    'cta_heading' => 'Beplankung anfragen',
    'cta_text'    => 'Senden Sie uns Ihre Sanitärpläne mit Stückzahl, Wandaufbau und Termin, wir rechnen Ihnen eine Offerte für die Beplankung.',
    'textlinks' => [
        ['Vorfabrikation, Montage und Beplankung', 'sanitaerelemente-vorfabrizieren'],
        ['verrohren und beplanken die GIS Elemente', 'sanitaer-gis-elemente-bestellen'],
    ],
    'links' => [
        'leistungen',
        'sanitaer-gis-elemente-bestellen',
        'sanitaerelemente-vorfabrizieren',
        'sanitaerelemente-montieren',
        'sanitaer-vorwaende',
        'sanitaer-vorwandelemente-beplanken',
    ],
];


// ═════════════════════════════════════════════════════════════
// 4) /sanitaer-vorwandelemente — "sanitär vorwandelemente"
//    Plan Seite 22 bis 24. Position heute: 9.
// ═════════════════════════════════════════════════════════════
$seiten[] = [
    'slug'       => 'sanitaer-vorwandelemente',
    'modus'      => 'neubau',
    'keyword'    => 'sanitär vorwandelemente',
    'nav_label'  => 'Sanitär Vorwandelemente',
    'meta_title' => 'Sanitär Vorwandelemente: Aufbau, Montage | SUI Innova',
    'meta_desc'  => 'Sanitär Vorwandelemente: So sind sie aufgebaut, so werden sie montiert, beplankt und schallentkoppelt. SUI Innova aus Pfäffikon SZ erklärt es.',
    'h1'         => 'Sanitär Vorwandelemente: Aufbau, Montage und Beplankung erklärt',
    'alt'        => 'Verzinktes Sanitär Vorwandelement mit verrohrtem Spülkasten in der Werkstatt von SUI Innova in Pfäffikon SZ',
    'intro'      => 'Sanitär Vorwandelemente tragen WC, Waschtisch, Dusche oder Urinal und nehmen Zu- und Ablaufleitungen auf, ohne dass die Rohre sichtbar bleiben. Der Kern ist ein verzinkter Stahlrahmen, der am Boden und an der Rohbauwand verschraubt wird. Danach folgen Beplankung, Spachtelung und im Nassbereich die Abdichtung. Auf dieser Seite lesen Sie, wie ein solches Element aufgebaut ist, welche Masse die Planung bestimmen, warum die Beplankung im Nassbereich anderen Regeln folgt und an welcher Stelle im Bauablauf über die Schallentkopplung entschieden wird. SUI Innova aus Pfäffikon SZ fertigt GIS-Elemente in der eigenen Werkstatt fix und fertig verrohrt vor, montiert sie auf der Baustelle und übernimmt Beplankung und Spachtelung. Sie erhalten die Wand als eine Leistung, nicht in Einzelteilen.',
    'body' => [
        ['Ein Vorwandelement ist Tragwerk und Installationsraum zugleich',
         'Der Stahlrahmen nimmt die Lasten von WC, Waschtisch oder Stützgriff auf und leitet sie in Boden und Rohbauwand. Gleichzeitig entsteht zwischen Rahmen und Beplankung der Raum für Spülkasten, Wasserleitungen und Abwasserrohre. Beide Funktionen hängen zusammen: Wer die Leitungsführung ändert, verändert auch die Befestigungspunkte. Deshalb wird ein Element geplant, bevor es gebaut wird, und nicht erst auf der Baustelle zurechtgeschnitten.'],
        ['Die Masse ergeben sich aus Apparat, Raumhöhe und Plättliraster',
         'Höhe und Breite eines Elements richten sich nach dem gewählten Apparat, der Sitzhöhe des WCs und der gewünschten Ablagekante. Die Bautiefe bestimmt, wie viel Platz Spülkasten und Abwasserrohr brauchen. Halbhohe Vorwände enden auf Ablagehöhe, raumhohe Varianten laufen bis zur Decke durch. Sinnvoll ist, die Höhe früh mit dem Plättliraster abzugleichen, damit oben keine schmale Schnittreihe entsteht. Halbhoch und raumhoch fertigen wir beide; welches Mass für Ihre Nasszelle passt, legen wir anhand der Pläne und der gewählten Apparate fest.'],
        ['Vorfabrikation verlegt die Arbeit von der Baustelle in die Werkstatt',
         'In der Werkstatt wird das Element auf der Lehre gebaut, verrohrt und kontrolliert. Auf der Baustelle bleibt das Versetzen, Ausrichten und Anschliessen. Das verkürzt die Zeit, in der andere Gewerke auf dem gleichen Quadratmeter warten. Bei Serien mit gleichen Nasszellen wirkt sich das besonders stark aus, weil jedes Element gleich aufgebaut ist.'],
        ['Im Nassbereich entscheidet die Beplankung über die Abdichtung',
         'Gipskarton eignet sich für trockene Zonen, im Spritzwasserbereich braucht es eine feuchtebeständige Platte als Untergrund. SUI Innova setzt dort AquaPanel als Träger für Abdichtung und Plättli ein. Die Plattenstösse liegen versetzt zu den Profilen, die Fugen werden gespachtelt und armiert. Erst danach folgt die Verbundabdichtung, dann der Belag.'],
        ['Schallentkopplung wird beim Versetzen entschieden, nicht nachträglich',
         'Trittschall und Körperschall wandern über starre Verbindungen in die Rohdecke und in Nachbarräume. Deshalb kommen Dämmstreifen unter die Bodenprofile, die Rohre werden in Schellen mit Einlage geführt und der Apparat wird vom Baukörper getrennt befestigt. Wird das beim Versetzen übersehen, lässt es sich nach der Plättliarbeit kaum noch korrigieren. Klären Sie die Anforderung vorgängig mit der Bauleitung.'],
        ['So läuft ein Auftrag bei SUI Innova ab',
         'Sie senden uns die Sanitär- und Grundrisspläne. Wir prüfen die Elemente, klären offene Punkte und erstellen eine Offerte. Nach Freigabe fertigen wir in Pfäffikon SZ vor, liefern nach Termin und montieren mit dem eigenen Team. Beplankung und Spachtelung übernehmen wir auf Wunsch gleich mit. Den verbindlichen Liefertermin halten wir in der Offerte fest.'],
    ],
    'faq' => [
        ['Was ist der Unterschied zwischen einem Vorwandelement und einer Vorwand?',
         'Das Vorwandelement ist der tragende Rahmen samt Installation für einen Apparat. Die Vorwand ist die fertige Wandfläche, die aus einem oder mehreren Elementen, der Beplankung und der Spachtelung entsteht.'],
        ['Braucht es im Bad zwingend eine feuchtebeständige Platte?',
         'Im Spritzwasserbereich von Dusche und Badewanne ja, dort dient eine Platte wie AquaPanel als Untergrund für die Abdichtung. In trockenen Zonen des gleichen Raums genügt in der Regel Gipskarton. Die Zoneneinteilung legt die Bauleitung fest.'],
        ['Kann ein Vorwandelement auch vor einer Leichtbauwand stehen?',
         'Ja, sofern die Befestigung auf ein tragfähiges Profil oder eine Auswechslung trifft. Die Lasten aus WC und Ablagen müssen sauber in Boden und Wand eingeleitet werden. Wir prüfen das anhand Ihrer Pläne.'],
    ],
    'cta_heading' => 'Pläne einsenden, Offerte erhalten',
    'cta_text'    => 'Senden Sie uns Ihre Sanitärpläne, wir prüfen die Elemente und schicken Ihnen eine Offerte mit Stückzahl, Terminen und Preis.',
    'textlinks' => [
        ['GIS-Elemente', 'sanitaer-gis-elemente-bestellen'],
        ['Beplankung und Spachtelung', 'sanitaer-vorwandelemente-beplanken'],
    ],
    'links' => [
        'leistungen',
        'sanitaer-gis-elemente-bestellen',
        'gis-elemente-beplanken',
        'sanitaerelemente-montieren',
        'sanitaer-vorwandelemente-bestellen',
        'sanitaer-vorwaende',
        'sanitaer-vorwandelemente-beplanken',
    ],
];


// ═════════════════════════════════════════════════════════════
// 5) /sanitaer-vorwandelemente-bestellen
//    "sanitär vorwandelemente bestellen". Plan Seite 28 bis 29.
// ═════════════════════════════════════════════════════════════
$seiten[] = [
    'slug'       => 'sanitaer-vorwandelemente-bestellen',
    'modus'      => 'neubau',
    'keyword'    => 'sanitär vorwandelemente bestellen',
    'nav_label'  => 'Vorwandelemente bestellen',
    'meta_title' => 'Sanitär Vorwandelemente bestellen | SUI Innova GmbH',
    'meta_desc'  => 'Sanitär Vorwandelemente bestellen: verrohrte GIS-Elemente aus Pfäffikon SZ, auf Mass vorfabriziert. Pläne einsenden, Offerte mit Liefertermin erhalten.',
    'h1'         => 'Sanitär Vorwandelemente bestellen: verrohrt ab Werkstatt Pfäffikon',
    'alt'        => 'Verrohrtes GIS-Vorwandelement für WC und Waschtisch in der Werkstatt in Pfäffikon SZ',
    'intro'      => 'Sie können bei SUI Innova Sanitär Vorwandelemente bestellen, die fertig verrohrt aus unserer Werkstatt in Pfäffikon SZ auf Ihre Baustelle kommen. Wir fertigen die GIS-Elemente nach Ihren Plänen, prüfen die Leitungsführung vorgängig und liefern nach Absprache auf den vereinbarten Termin. Auf Wunsch montiert unser eigenes Team die Elemente, beplankt sie mit AquaPanel und spachtelt, bis die Wand bereit für Abdichtung und Plättli ist. Für Sie bedeutet das weniger Schnittstellen und eine Ansprechperson für Vorfabrikation und Einbau. Wir arbeiten für Sanitärbetriebe, Generalunternehmen und Bauherrschaften. Sagen Sie uns, welche Apparate, welche Wandtypen und welchen Liefertermin Sie brauchen. Sie erhalten eine Offerte mit Positionen, Massen und Liefertermin, damit Sie die Kosten sauber rechnen können.',
    'body' => [
        ['So läuft eine Bestellung ab',
         'Sie senden uns Ihre Grundriss- und Sanitärpläne, per Mail oder über das Kontaktformular. Wir klären Apparatetypen, Wandhöhen, Wandstärken und die Anschlusspunkte und melden uns bei Unklarheiten direkt bei Ihnen. Danach erhalten Sie eine Offerte mit Positionen, Massen und Liefertermin. Nach Ihrer Freigabe produzieren wir die Elemente und liefern sie auf den abgesprochenen Termin.'],
        ['Was Sie bei uns bestellen können',
         'Wir fertigen GIS-Elemente für WC, Waschtisch, Dusche, Badewanne, Urinal und Küche. Die Elemente kommen verrohrt, mit gesetzten Apparateträgern und beschrifteten Anschlüssen. Auf Wunsch liefern wir komplette Nasszellenwände statt einzelner Elemente. Welche Systeme und Fabrikate wir für Ihr Projekt verbauen, richtet sich nach Ihrer Ausschreibung. Nennen Sie sie uns bei der Anfrage.'],
        ['Montage und Beplankung dazu bestellen',
         'Sie müssen die Elemente nicht selbst einbauen. Unser Team montiert sie auf der Baustelle, richtet sie aus und befestigt sie am Rohbau. Anschliessend beplanken wir mit AquaPanel, dem üblichen Untergrund für Abdichtung und Plättli in Nasszellen, und spachteln die Flächen. So übergeben wir Ihnen die Wand in einem Zug.'],
        ['Angaben, die wir für eine Offerte brauchen',
         'Am schnellsten geht es, wenn Sie uns die Pläne mit Massen, die Apparateliste und den gewünschten Liefertermin schicken. Nennen Sie auch die Wandstärke, die Deckenhöhe und ob es sich um eine Trennwand oder eine Vorwand handelt. Sagen Sie uns, ob Sie nur die Elemente oder auch Montage und Beplankung wollen. Fehlende Angaben klären wir telefonisch, bevor wir rechnen.'],
        ['Liefergebiet und Termine',
         'Wir liefern von Pfäffikon SZ aus in der ganzen Deutschschweiz auf Ihre Baustelle. Den Liefertermin halten wir in der Offerte fest, damit Sie Ihre Bauetappen darauf abstimmen können. Bei mehreren Etappen liefern wir gestaffelt nach Ihrem Bauprogramm.'],
    ],
    'faq' => [
        ['Wie lange dauert es von der Bestellung bis zur Lieferung?',
         'Der Vorlauf hängt von der Stückzahl und von den Apparaten ab. Den verbindlichen Termin nennen wir in der Offerte, bevor Sie freigeben.'],
        ['Kann ich auch nur ein einzelnes Vorwandelement bestellen?',
         'Ja. Wir fertigen einzelne Elemente für Umbauten ebenso wie Serien für ganze Geschosse. Nennen Sie uns die Stückzahl, dann rechnen wir die Position.'],
        ['Was kostet ein vorfabriziertes Sanitär Vorwandelement?',
         'Der Preis richtet sich nach Grösse, Apparaten, Verrohrung und danach, ob Montage und Beplankung dazukommen. Sie erhalten eine Offerte mit einzelnen Positionen.'],
    ],
    'cta_heading' => 'Vorwandelemente anfragen',
    'cta_text'    => 'Senden Sie uns Ihre Pläne und die Apparateliste, Sie erhalten eine Offerte mit Positionen, Massen und Liefertermin.',
    // Der Plan nennt nur das erste Ziel. Eine Seite mit einem einzigen
    // ausgehenden Link ist eine Sackgasse, die beiden anderen sind die
    // naechstliegenden Schritte fuer jemanden, der hier landet.
    'textlinks' => [
        ['GIS-Elemente', 'sanitaer-gis-elemente-bestellen'],
        ['beplankt sie mit AquaPanel', 'sanitaer-vorwandelemente-beplanken'],
    ],
    'links' => [
        'sanitaer-gis-elemente-bestellen',
        'sanitaer-vorwandelemente',
        'sanitaer-vorwandelemente-beplanken',
    ],
];


// ═════════════════════════════════════════════════════════════
// 6) /sanitaer-vorwaende — "sanitär vorwände"
//    Plan Seite 30 bis 32.
// ═════════════════════════════════════════════════════════════
$seiten[] = [
    'slug'       => 'sanitaer-vorwaende',
    'modus'      => 'neubau',
    'keyword'    => 'sanitär vorwände',
    'nav_label'  => 'Sanitär Vorwände',
    'meta_title' => 'Sanitär Vorwände vorfabriziert | SUI Innova GmbH',
    'meta_desc'  => 'Sanitär Vorwände fertig verrohrt aus unserer Werkstatt in Pfäffikon SZ, dazu Montage und Beplankung. Pläne einsenden, Sie erhalten eine Offerte.',
    'h1'         => 'Sanitär Vorwände: vorfabriziert, montiert, beplankt',
    'alt'        => 'Vorfabrizierte Sanitär Vorwand mit verrohrten GIS-Elementen in der Werkstatt in Pfäffikon SZ',
    'intro'      => 'Sanitär Vorwände liefern wir fertig verrohrt auf Ihre Baustelle. In unserer Werkstatt in Pfäffikon SZ bauen wir die GIS-Elemente nach Ihren Plänen auf Mass zusammen, danach montiert sie unser eigenes Team vor Ort und beplankt sie bis zur spachtelfertigen Wand. Damit wandert ein grosser Teil der Sanitärinstallation von der Baustelle in die Halle. Das spart Schnittstellen, verkürzt die Wartezeit für die Folgegewerke und macht den Bauablauf planbar. Für Nasszellen und Feuchträume setzen wir AquaPanel ein, bei Schallschutzanforderungen SilentPanel und Ausflockung. Sie haben eine Ansprechperson für Vorfabrikation, Montage und Beplankung, vom ersten Plan bis zur übergebenen Wand. Senden Sie uns Ihre Pläne mit der Adresse der Baustelle. Wir prüfen sie und melden uns mit einer Offerte.',
    'body' => [
        ['Die Elemente verlassen unsere Werkstatt fertig verrohrt',
         'Wir konfektionieren die Vorwandelemente nach Ihren Plänen und verrohren sie in der Halle. Wasser- und Abwasserleitungen sind gesetzt, die Anschlüsse sitzen dort, wo der Plan sie vorsieht. Auf der Baustelle wird das Element nur noch gestellt, ausgerichtet und angeschlossen. So verlagern Sie Arbeitsstunden aus dem engen Rohbau in die Werkstatt.'],
        ['Unser Team montiert die Vorwände selbst',
         'Montiert wird von den gleichen Leuten, die für den Ablauf verantwortlich sind. Das heisst: keine Übergabe an eine dritte Firma und keine Diskussion darüber, wer welches Detail geplant hat. Wir richten die Wände aus, befestigen sie am Rohbau und kontrollieren die Anschlusspunkte. Abweichungen auf der Baustelle klären wir direkt mit Ihrer Bauleitung.'],
        ['AquaPanel in der Nasszelle, SilentPanel beim Schallschutz',
         'In Feuchträumen beplanken wir mit AquaPanel als Untergrund für Abdichtung und Plättli. Wo Schallschutzwerte gefordert sind, arbeiten wir mit SilentPanel und Ausflockung der Hohlräume. Welcher Aufbau nötig ist, lesen wir aus Ihren Plänen und dem Schallschutznachweis heraus. Sie erhalten die Wand spachtelfertig, das Folgegewerk kann direkt weiterarbeiten.'],
        ['Ein Ansprechpartner statt drei Gewerke',
         'Vorfabrikation, Montage und Beplankung kommen von uns. Damit fällt die klassische Lücke zwischen Sanitär und Trockenbau weg, an der Termine sonst kippen. Sie koordinieren eine Firma und erhalten eine Rechnung für den ganzen Umfang. Für Rückfragen während der Ausführung haben Sie eine feste Kontaktperson.'],
        ['So läuft eine Anfrage ab',
         'Sie senden uns die Sanitär- und Grundrisspläne mit der Adresse der Baustelle. Wir prüfen Stückzahlen, Aufbauten und Zugänglichkeit und stellen Ihnen eine Offerte zu. Nach der Freigabe vereinbaren wir den Liefer- und Montagetermin mit Ihrer Bauleitung und halten ihn schriftlich fest.'],
        ['Wohin wir liefern',
         'Unsere Werkstatt steht in Pfäffikon SZ, geliefert und montiert wird in der ganzen Deutschschweiz. Für grössere Bauvorhaben teilen wir die Lieferung in Etappen, damit auf der Baustelle kein Lagerplatz blockiert wird. Wir stimmen Kranzeiten und Zufahrt vorgängig mit Ihnen ab. Bei knappen Platzverhältnissen legen wir die Elementgrössen entsprechend fest.'],
    ],
    'faq' => [
        ['Was ist der Unterschied zwischen Sanitär Vorwänden und einzelnen Vorwandelementen?',
         'Ein Vorwandelement trägt ein einzelnes Objekt, etwa ein WC oder ein Lavabo. Eine Sanitär Vorwand ist die zusammengesetzte, verrohrte und beplankte Wand für die ganze Nasszelle. Wir liefern beides, vom Einzelelement bis zur spachtelfertigen Wand.'],
        ['Müssen die Pläne bereits definitiv sein?',
         'Für eine Offerte genügen Pläne im aktuellen Stand, wir weisen Sie auf offene Punkte hin. Für die Vorfabrikation brauchen wir freigegebene Masse und Anschlusspunkte, weil die Verrohrung in der Werkstatt fix gesetzt wird. Änderungen danach kosten Zeit und Geld.'],
        ['Übernehmen Sie auch nur die Beplankung?',
         'Ja, wir beplanken auch Elemente, die eine andere Firma gestellt hat. Wir schauen vorgängig an, ob Aufbau und Befestigung für AquaPanel oder SilentPanel geeignet sind. Melden Sie sich mit den Plänen und dem gewünschten Termin.'],
    ],
    'cta_heading' => 'Sanitär Vorwände anfragen',
    'cta_text'    => 'Senden Sie uns Ihre Pläne mit der Adresse der Baustelle, wir prüfen sie und melden uns mit einer Offerte.',
    // Der Plan nennt nur das erste Ziel, und das ist bis zur Freischaltung
    // offline. Ohne die beiden anderen haette die Seite bis dahin gar
    // keinen ausgehenden Link.
    'textlinks' => [
        ['GIS-Elemente', 'sanitaer-gis-elemente-bestellen'],
        ['beplankt sie bis zur spachtelfertigen Wand', 'gis-elemente-beplanken'],
    ],
    'links' => [
        'sanitaerelemente-vorfabrizieren',
        'leistungen',
        'sanitaer-vorwandelemente',
    ],
];


// ═════════════════════════════════════════════════════════════
// 7) /sanitaer-vorwandelemente-beplanken
//    "sanitär vorwandelemente beplanken". Plan Seite 36 bis 38.
//    Position heute: 1, mit KI-Zitat. Titel und H1 bleiben deshalb
//    unveraendert, der Plan schlaegt genau die heutigen vor.
// ═════════════════════════════════════════════════════════════
$seiten[] = [
    'slug'       => 'sanitaer-vorwandelemente-beplanken',
    'modus'      => 'neubau',
    'keyword'    => 'sanitär vorwandelemente beplanken',
    'nav_label'  => 'Vorwandelemente beplanken',
    'meta_title' => 'Sanitär Vorwandelemente beplanken | SUI Innova',
    'meta_desc'  => 'Sanitär Vorwandelemente beplanken: in Nasszellen mit AquaPanel, in trockenen Räumen mit Gipsplatten, auf Wunsch spachtelfertig. Pläne einsenden.',
    'h1'         => 'Sanitär Vorwandelemente beplanken: von der Montage bis zur spachtelfertigen Wand',
    'alt'        => 'Mit AquaPanel beplanktes Sanitär Vorwandelement mit ausgeschnittener Revisionsöffnung',
    'intro'      => 'Sanitär Vorwandelemente beplanken heisst: Das verrohrte Element bekommt seine Hülle, und die Wand ist bereit für Plättli oder Farbe. Diesen Schritt übernehmen wir auf Ihrer Baustelle, im Neubau wie im Umbau. Wir wählen die Platte nach Raum, schneiden um Rohrdurchführungen und Revisionsöffnungen zu, befestigen im vorgegebenen Raster und spachteln auf Wunsch. In Nasszellen arbeiten wir mit AquaPanel, in trockenen Bereichen mit der passenden Gipsplatte. Wir kommen auch dann, wenn ein anderer Betrieb die Elemente gesetzt hat. Sie erhalten eine Offerte mit Fläche, Plattentyp und Termin, damit Sie Ihre Folgegewerke planen können. Senden Sie uns Ihre Pläne, wir melden uns mit einem Terminvorschlag.',
    'body' => [
        ['Die Plattenwahl entscheidet über die Lebensdauer der Nasszelle',
         'In Duschen, Bädern und WC-Anlagen verbauen wir AquaPanel als Untergrund für Abdichtung und Plättli. Die Platte nimmt Feuchtigkeit nicht auf und bleibt auch bei Spritzwasser formstabil. In Korridoren, Küchen und trockenen Räumen genügt die passende Gipsplatte. Wir halten die Vorgaben des Elementherstellers und des Plattenlieferanten ein, damit Ihre Garantie bestehen bleibt.'],
        ['Zuschnitt um Rohrdurchführungen und Revisionsöffnungen',
         'Jede Durchführung wird gebohrt oder gefräst, nicht gebrochen. Revisionsöffnungen halten wir so aus, dass der Rahmen später ohne Nacharbeit passt. Wir markieren die Lage der Leitungen auf der Platte, bevor wir schrauben, damit kein Rohr getroffen wird. So bleibt die Wand dicht und die Sanitärinstallation zugänglich.'],
        ['Befestigung im vorgegebenen Raster',
         'Die Schraubabstände richten sich nach Plattentyp und Untergrund. Wir arbeiten im Raster des Ständerwerks und setzen die Schrauben bündig, ohne das Papier oder die Deckschicht zu verletzen. Stösse werden versetzt angeordnet, damit später keine Risse durchschlagen. Auf Wunsch spachteln wir Fugen und Schraubenköpfe bis zur Weiterbearbeitung durch den Maler oder Plattenleger.'],
        ['Auch wenn ein anderer Betrieb die Elemente gesetzt hat',
         'Wir übernehmen die Beplankung als einzelne Leistung. Vorgängig prüfen wir, ob die Elemente lot- und fluchtrecht stehen und ob die Verrohrung abgedrückt ist. Abweichungen melden wir Ihnen schriftlich, bevor wir die Platten montieren. Damit verschieben sich keine Verantwortlichkeiten auf unsere Arbeit.'],
        ['Von der Vorfabrikation bis zur fertigen Wand aus einer Hand',
         'Wir fabrizieren GIS-Elemente in unserer Werkstatt in Pfäffikon SZ vor, montieren sie mit dem eigenen Team und beplanken sie anschliessend. Sie koordinieren damit eine Schnittstelle weniger. Wenn Sie nur einen Teilschritt brauchen, buchen Sie nur diesen. Wie viele Nasszellen pro Tag beplankt werden, hängt von Fläche und Zugang ab; die Montagetage halten wir in der Offerte fest.'],
        ['So läuft die Offerte ab',
         'Sie senden uns Grundrisse, Schnitte und die Elementliste. Wir rechnen die Fläche aus, halten den Plattentyp je Raum fest und nennen einen Montagetermin. Änderungen auf der Baustelle bestätigen wir vor der Ausführung schriftlich.'],
    ],
    'faq' => [
        ['Welche Platten verwenden Sie in der Nasszelle?',
         'In Duschen, Bädern und WC-Anlagen setzen wir AquaPanel als Untergrund für Abdichtung und Plättli ein. In trockenen Räumen verbauen wir die passende Gipsplatte. Die Wahl halten wir in der Offerte pro Raum fest.'],
        ['Beplanken Sie auch Elemente, die wir selbst gesetzt haben?',
         'Ja. Wir prüfen vorgängig Lot, Flucht und den Zustand der Verrohrung und melden Ihnen allfällige Abweichungen schriftlich. Danach montieren wir die Platten.'],
        ['Spachteln Sie die Wand auch?',
         'Auf Wunsch spachteln wir Fugen und Schraubenköpfe, sodass der Maler oder Plattenleger direkt weiterarbeiten kann. Sie entscheiden, ob Sie die Wand beplankt oder spachtelfertig übernehmen möchten. Der Umfang steht in der Offerte.'],
    ],
    'cta_heading' => 'Beplankung anfragen',
    'cta_text'    => 'Senden Sie uns Ihre Grundrisse und die Elementliste, wir rechnen die Fläche aus und melden uns mit Offerte und Montagetermin.',
    'textlinks' => [
        ['Wir fabrizieren GIS-Elemente', 'sanitaerelemente-vorfabrizieren'],
        ['montieren sie mit dem eigenen Team', 'sanitaerelemente-montieren'],
    ],
    'links' => [
        'sanitaer-vorwandelemente',
        'sanitaer-vorwandelemente-bestellen',
        'gis-elemente-beplanken',
    ],
];


// ═════════════════════════════════════════════════════════════
// 8) NEU: /sanitaerelemente-vorfabrizieren
//    "sanitärelemente vorfabrizieren". Plan Seite 17 bis 18.
// ═════════════════════════════════════════════════════════════
$seiten[] = [
    'slug'       => 'sanitaerelemente-vorfabrizieren',
    'modus'      => 'neu',
    'keyword'    => 'sanitärelemente vorfabrizieren',
    'nav_label'  => 'Sanitärelemente vorfabrizieren',
    'meta_title' => 'Sanitärelemente vorfabrizieren | SUI Innova GmbH',
    'meta_desc'  => 'Sanitärelemente vorfabrizieren lassen: verrohrte GIS-Elemente aus der Werkstatt in Pfäffikon SZ, geliefert und montiert. Pläne senden, Offerte erhalten.',
    'h1'         => 'Sanitärelemente vorfabrizieren: verrohrt aus der Werkstatt in Pfäffikon SZ',
    'alt'        => 'Vorfabriziertes und verrohrtes Sanitärelement in der Werkstatt von SUI Innova in Pfäffikon SZ',
    'intro'      => 'Wenn Sie Sanitärelemente vorfabrizieren lassen, verlagern Sie Arbeit von der Baustelle in unsere Werkstatt in Pfäffikon SZ. Wir bauen die GIS-Elemente nach Ihren Plänen auf, verrohren sie und liefern sie einbaufertig an. Auf der Baustelle bleibt das Versetzen, Anschliessen und bei Bedarf das Beplanken mit AquaPanel. Das spart Wege, reduziert Koordination zwischen den Handwerkern und hält den Bauablauf ruhiger. Wir arbeiten für Sanitärunternehmen, Generalunternehmer und Bauherrschaften, von der einzelnen Nasszelle bis zu Serien für ganze Geschosse. Montage und Beplankung übernimmt unser eigenes Team, Sie haben also einen Ansprechpartner statt drei. Senden Sie uns Ihre Grundrisse und Sanitärpläne, wir rechnen die Elemente aus und melden uns mit einer Offerte.',
    'body' => [
        ['Was wir unter Vorfabrikation verstehen',
         'Wir bauen die GIS-Elemente im Gestell auf, setzen Spülkästen, Halter und Befestigungen und verrohren Zuleitungen und Abläufe. Geprüft und beschriftet verlassen die Elemente unsere Werkstatt. Auf der Baustelle werden sie versetzt und an die Steigzonen angeschlossen. So entsteht aus vielen Einzelschritten ein Element, das in kurzer Zeit steht.'],
        ['Ihre Pläne sind die Grundlage',
         'Wir arbeiten nach Ihren Sanitär- und Architekturplänen. Aus den Grundrissen leiten wir Höhen, Achsmasse und Anschlusspunkte ab und klären offene Punkte vorgängig mit Ihnen ab. Änderungen vor Produktionsstart nehmen wir auf, ohne dass die Baustelle stillsteht. Sie erhalten vor der Fertigung die Freigabeunterlagen zur Kontrolle.'],
        ['Weniger Arbeitsgänge auf der Baustelle',
         'In der Werkstatt arbeiten wir auf gleicher Höhe, mit fixen Arbeitsplätzen und ohne Wetter. Das macht die Arbeit schneller und die Qualität gleichmässiger als am Bau. Auf der Baustelle sinkt die Zahl der Handwerker, die gleichzeitig im gleichen Schacht arbeiten. Für Sie heisst das eine kürzere Belegung der Nasszellen im Terminprogramm.'],
        ['Montage und Beplankung aus derselben Hand',
         'Unser Team liefert die Elemente an und montiert sie vor Ort. Auf Wunsch beplanken wir anschliessend mit AquaPanel als Untergrund für Abdichtung und Plättli und spachteln die Flächen. Sie koordinieren also nicht zwischen Lieferant, Sanitär und Trockenbau. Was wir übernehmen, halten wir vorgängig schriftlich fest.'],
        ['Von der Einzelwohnung bis zur Serie',
         'Bei wiederkehrenden Grundrissen fertigen wir die Elemente in Serie, was Aufbau und Kontrolle vereinfacht. Bei Umbauten und einzelnen Nasszellen bauen wir die Elemente auf das bestehende Mass. Sprechen Sie uns früh an, dann planen wir die Produktion in Ihr Terminprogramm ein.'],
    ],
    'faq' => [
        ['Welche Unterlagen brauchen Sie für eine Offerte?',
         'Grundrisse mit den Nasszellen und, falls vorhanden, den Sanitärplan mit Apparateliste. Fehlt etwas, klären wir die offenen Punkte telefonisch. Auf dieser Basis rechnen wir die Elemente aus und senden Ihnen eine Offerte.'],
        ['Übernehmen Sie auch die Montage auf der Baustelle?',
         'Ja, unser eigenes Team versetzt und befestigt die Elemente vor Ort. Auf Wunsch beplanken wir anschliessend mit AquaPanel und spachteln die Flächen. Sie entscheiden, wo unsere Arbeit endet.'],
        ['Lohnt sich Vorfabrikation auch bei wenigen Nasszellen?',
         'Auch bei kleinen Mengen entlastet die Vorfabrikation den Bauablauf, weil die Verrohrung bereits fertig ist. Bei Serien wird der Vorteil grösser, weil sich der Aufbau wiederholt. Wir sagen Ihnen nach Sichtung der Pläne offen, ob es sich für Ihr Projekt rechnet.'],
    ],
    'cta_heading' => 'Vorfabrikation anfragen',
    'cta_text'    => 'Senden Sie uns Ihre Grundrisse und Sanitärpläne, wir prüfen sie und melden uns mit einer Offerte.',
    'textlinks' => [
        ['das Beplanken mit AquaPanel', 'gis-elemente-beplanken'],
        ['Montage und Beplankung übernimmt unser eigenes Team', 'sanitaerelemente-montieren'],
    ],
    'links' => [
        'leistungen',
        'sanitaer-gis-elemente-bestellen',
        'sanitaerelemente-montieren',
    ],
];


// ═════════════════════════════════════════════════════════════
// 9) NEU: /sanitaerelemente-montieren
//    "sanitärelemente montieren". Plan Seite 19 bis 21.
// ═════════════════════════════════════════════════════════════
$seiten[] = [
    'slug'       => 'sanitaerelemente-montieren',
    'modus'      => 'neu',
    'keyword'    => 'sanitärelemente montieren',
    'nav_label'  => 'Sanitärelemente montieren',
    'meta_title' => 'Sanitärelemente montieren | SUI Innova GmbH',
    'meta_desc'  => 'Sanitärelemente montieren lassen: Unser Team aus Pfäffikon SZ setzt GIS- und Vorwandelemente auf Ihrer Baustelle. Pläne senden, Offerte erhalten.',
    'h1'         => 'Sanitärelemente montieren: Unser Team kommt auf Ihre Baustelle',
    'alt'        => 'Monteur richtet ein vorfabriziertes GIS-Element in einer Nasszelle im Rohbau aus',
    'intro'      => 'Sie wollen Sanitärelemente montieren lassen, ohne dass Ihr Bauprogramm ins Rutschen kommt. Wir übernehmen diesen Schritt: Unser eigenes Montageteam stellt die GIS- und Vorwandelemente auf Ihrer Baustelle auf, richtet sie aus, befestigt sie und verbindet die Rohrführungen. Die Elemente kommen fix und fertig verrohrt aus unserer Werkstatt in Pfäffikon SZ, deshalb bleibt die Arbeit vor Ort kurz. Auf Wunsch beplanken wir die Wände direkt anschliessend mit AquaPanel, damit Abdichtung und Plättli folgen können. Sie erhalten vorgängig eine Offerte auf Basis Ihrer Pläne, mit klarer Abgrenzung, was wir ausführen und was bei Ihnen bleibt. Senden Sie uns Ihre Grundrisse und Sanitärpläne, wir melden uns mit Terminvorschlag und Preis.',
    'body' => [
        ['Vorfabriziert montieren heisst weniger Zeit auf der Baustelle',
         'Wir verrohren die Elemente in der Werkstatt, nicht im Rohbau. Auf der Baustelle bleiben Aufstellen, Ausrichten, Befestigen und das Verbinden der Anschlüsse. Das verkürzt die Zeit, in der Ihre Nasszellen für andere Gewerke blockiert sind. Gleichzeitig arbeiten wir in der Werkstatt unter gleichbleibenden Bedingungen, was Nachbesserungen vor Ort reduziert.'],
        ['So läuft die Montage bei uns ab',
         'Sie senden Grundrisse und Sanitärpläne, wir prüfen Masse, Achsen und Anschlusspunkte. Danach erhalten Sie eine Offerte mit Leistungsumfang und Termin. Wir fabrizieren die Elemente vor, liefern sie auf die Baustelle und montieren sie mit unserem eigenen Team. Zum Abschluss übergeben wir die Wände im vereinbarten Zustand, entweder montiert oder bereits beplankt.'],
        ['GIS-Elemente und Vorwandelemente aus einer Hand',
         'Wir montieren GIS-Elemente und Sanitär Vorwandelemente für Bad, Dusche, WC und Küche. Weil Vorfabrikation und Montage bei uns im gleichen Haus liegen, klärt sich eine Rückfrage zur Verrohrung mit einem Telefonat. Sie brauchen keine Schnittstelle zwischen Lieferant und Monteur zu koordinieren. Änderungen im letzten Moment nehmen wir auf, solange sie technisch machbar sind.'],
        ['Beplankung mit AquaPanel direkt im Anschluss',
         'Nach der Montage beplanken wir die Vorwände auf Wunsch mit AquaPanel. Das ergibt einen Untergrund, auf dem Abdichtung und Plättli aufgebaut werden können. Fugen und Übergänge spachteln wir nach Absprache. So wandert Ihre Nasszelle in einem Durchgang vom Rohbau zum plättlibereiten Zustand.'],
        ['Wer mit uns arbeitet',
         'Wir arbeiten für Sanitärunternehmen, Generalunternehmer und Bauleitungen in der ganzen Deutschschweiz. Bei Serien mit gleichen Nasszellen lohnt sich die Vorfabrikation besonders, weil sich der Aufbau wiederholt. Auch einzelne Umbauten führen wir aus, sofern die Zugänglichkeit passt.'],
        ['Was Sie für die Offerte bereitstellen',
         'Am schnellsten geht es mit Grundriss, Sanitärplan und Angaben zur Wandkonstruktion. Nützlich sind zudem der gewünschte Montagetermin und die Information, ob wir beplanken sollen. Fehlt etwas, fragen wir nach, bevor wir rechnen. Sie erhalten eine Offerte, die Vorfabrikation, Lieferung, Montage und allfällige Beplankung getrennt ausweist.'],
    ],
    'faq' => [
        ['Montieren Sie auch Sanitärelemente, die wir selbst geliefert haben?',
         'Sprechen Sie uns darauf an. Wir prüfen das anhand Ihrer Pläne und Produktangaben und sagen Ihnen, ob wir die Montage übernehmen.'],
        ['Wie lange dauert die Montage der Elemente vor Ort?',
         'Das hängt von Anzahl, Zugänglichkeit und Vorbereitung des Rohbaus ab. Weil die Elemente verrohrt ankommen, entfällt die Verrohrung auf der Baustelle. Nach Sichtung Ihrer Pläne nennen wir Ihnen eine Dauer in der Offerte.'],
        ['Übernehmen Sie nach der Montage auch die Beplankung?',
         'Ja, wir beplanken die Vorwände mit AquaPanel als Untergrund für Abdichtung und Plättli. Spachtelarbeiten führen wir nach Absprache aus. Sie entscheiden, in welchem Zustand wir übergeben.'],
    ],
    'cta_heading' => 'Montage anfragen',
    'cta_text'    => 'Senden Sie uns Ihre Grundrisse und Sanitärpläne über das Kontaktformular, wir prüfen die Masse und melden uns mit Offerte und Terminvorschlag.',
    'textlinks' => [
        ['fix und fertig verrohrt', 'sanitaerelemente-vorfabrizieren'],
        ['beplanken wir die Wände direkt anschliessend mit AquaPanel', 'gis-elemente-beplanken'],
    ],
    'links' => [
        'leistungen',
        'sanitaerelemente-vorfabrizieren',
        'gis-elemente-beplanken',
    ],
];


// ═════════════════════════════════════════════════════════════
// Seiten, die im Plan nur als Linkquelle vorkommen
// ═════════════════════════════════════════════════════════════
$nurLinks = [
    'referenzen' => [
        'leistungen',
        'sanitaer-gis-elemente-bestellen',
        'gis-elemente-beplanken',
    ],
    'kontakt' => [
        'leistungen',
        'sanitaer-gis-elemente-bestellen',
        'sanitaer-vorwandelemente',
        'sanitaer-vorwandelemente-bestellen',
        'sanitaer-vorwaende',
        'sanitaer-vorwandelemente-beplanken',
        'sanitaerelemente-montieren',
    ],
];


// ─────────────────────────────────────────────────────────────
// Hilfsfunktionen
// ─────────────────────────────────────────────────────────────

/** SQL-Zeichenkette. */
function q(string $s): string
{
    return "'" . str_replace(["\\", "'"], ["\\\\", "''"], $s) . "'";
}

/** JSON als SQL-Zeichenkette, Umlaute bleiben Umlaute. */
function j(array $data): string
{
    return q(json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
}

/**
 * Der Linkblock einer Seite.
 *
 * Als Sektion link-list, nicht als fertiges HTML in einem Textblock: die
 * Vorlage prueft beim Ausliefern, ob die Zielseite online ist, und laesst
 * sie sonst weg. Die zwei neuen Seiten gehen deaktiviert online, ein fest
 * geschriebener Link zeigte bis zur Freischaltung auf einen 404.
 */
function linkBlock(array $ziele, array $anker, string $eigenerSlug): ?array
{
    global $ankerAusnahmen;

    $items = [];
    foreach ($ziele as $slug) {
        if ($slug === $eigenerSlug) continue;
        if (!isset($anker[$slug])) continue;
        $text = $ankerAusnahmen[$eigenerSlug][$slug] ?? $anker[$slug];
        $items[] = ['slug' => $slug, 'text' => $text];
    }
    if (!$items) return null;

    return ['link-list', [
        'heading' => 'Passend dazu',
        'items'   => $items,
    ]];
}

/**
 * Links im Fliesstext setzen.
 *
 * Die Linkliste am Seitenende ist sauber, aber ein Link mitten im Satz
 * wiegt bei Google mehr und wird oefter geklickt. Hier wird je Seite das
 * ERSTE Vorkommen einer Formulierung zum Link auf die passende Seite.
 *
 * Nur das erste Vorkommen: derselbe Link dreimal auf einer Seite bringt
 * nichts und liest sich wie eine Werbeflaeche.
 *
 * $gesetzt merkt sich seitenweit, was schon verlinkt ist, damit Einleitung
 * und Abschnitte nicht denselben Link doppelt setzen.
 */
function textlinkSetzen(string $html, array $paare, array &$gesetzt): string
{
    foreach ($paare as [$suchtext, $ziel]) {
        if (isset($gesetzt[$ziel])) continue;
        $stelle = mb_strpos($html, $suchtext);
        if ($stelle === false) continue;

        $html = mb_substr($html, 0, $stelle)
              . '<a href="/' . $ziel . '">' . $suchtext . '</a>'
              . mb_substr($html, $stelle + mb_strlen($suchtext));
        $gesetzt[$ziel] = true;
    }
    return $html;
}

/**
 * Das Inhaltsraster einer Seite: Einleitung plus Abschnitte, mit den
 * Links im Fliesstext. Eine Stelle fuer alle drei Aufrufer, sonst laufen
 * SQL und Vorschau auseinander.
 */
function inhaltsRaster(array $p, string $heading): array
{
    $gesetzt = [];
    $paare   = $p['textlinks'] ?? [];

    $lead  = textlinkSetzen('<p>' . $p['intro'] . '</p>', $paare, $gesetzt);
    $items = [];
    foreach ($p['body'] as $b) {
        $items[] = [
            'title' => $b[0],
            'text'  => textlinkSetzen('<p>' . $b[1] . '</p>', $paare, $gesetzt),
        ];
    }

    return [
        'heading' => $heading,
        'lead'    => $lead,
        'style'   => 'light',
        'items'   => $items,
    ];
}

/** Die vier bis fuenf Sektionen einer Keyword-Seite. */
function sektionen(array $p, array $anker): array
{
    $s = [];

    // Kopfbild. Ohne Bild rendert die Sektion nichts, das Bild waehlt
    // der Admin im CMS. Der Alt-Text aus dem Plan steht schon hier.
    $s[] = ['parallax-image', [
        'image_id'     => 0,
        'height'       => 'medium',
        'overlay_text' => '',
        'alt'          => $p['alt'],
    ]];

    $s[] = ['content-grid', inhaltsRaster($p, $p['h1'])];

    $s[] = ['faq', [
        'heading'  => 'Fragen und Antworten',
        'subtitle' => '',
        'items'    => array_map(
            fn($f) => ['question' => $f[0], 'answer' => '<p>' . $f[1] . '</p>'],
            $p['faq']
        ),
    ]];

    $lb = linkBlock($p['links'] ?? [], $anker, $p['slug']);
    if ($lb) $s[] = $lb;

    $s[] = ['cta-banner', [
        'heading'     => $p['cta_heading'],
        'body'        => $p['cta_text'],
        'button_text' => CTA_BUTTON,
        'button_url'  => CTA_URL,
    ]];

    return $s;
}


// ─────────────────────────────────────────────────────────────
// Modus: Selbstkontrolle
// ─────────────────────────────────────────────────────────────

if (($argv[1] ?? '') === 'pruefen') {
    $fehler = [];

    foreach ($seiten as $p) {
        $alles = $p['meta_title'] . ' ' . $p['meta_desc'] . ' ' . $p['h1'] . ' '
               . $p['alt'] . ' ' . $p['intro'] . ' ' . $p['cta_heading'] . ' ' . $p['cta_text'];
        foreach ($p['body'] as $b) $alles .= ' ' . $b[0] . ' ' . $b[1];
        foreach ($p['faq']  as $f) $alles .= ' ' . $f[0] . ' ' . $f[1];

        // Gedankenstriche
        if (preg_match('/[\x{2012}-\x{2015}]/u', $alles)) {
            $fehler[] = $p['slug'] . ': Gedankenstrich im Text';
        }
        // Offene Platzhalter
        if (str_contains($alles, 'ANGABE FEHLT')) {
            $fehler[] = $p['slug'] . ': offener Platzhalter';
        }
        // Laengen
        $tl = mb_strlen($p['meta_title']);
        if ($tl > 62) $fehler[] = $p['slug'] . ": Titel $tl Zeichen, zu lang";
        $dl = mb_strlen($p['meta_desc']);
        if ($dl < 100 || $dl > 170) $fehler[] = $p['slug'] . ": Beschreibung $dl Zeichen";
        // Keyword muss in H1 vorkommen
        $kw = explode(',', $p['keyword'])[0];
        $norm = fn($s) => mb_strtolower(str_replace(['-', 'ä', 'ö', 'ü'], [' ', 'ä', 'ö', 'ü'], $s));
        if (!str_contains($norm($p['h1']), $norm(trim($kw)))) {
            $fehler[] = $p['slug'] . ": Hauptkeyword \"$kw\" fehlt in der H1";
        }
        // Ziele der Links muessen existieren
        foreach ($p['links'] ?? [] as $z) {
            if (!isset($anker[$z])) $fehler[] = $p['slug'] . ": Linkziel /$z unbekannt";
        }

        // Fliesstext-Links: die Formulierung muss im Text stehen, sonst
        // faellt der Link stillschweigend weg und niemand merkt es.
        $volltext = $p['intro'];
        foreach ($p['body'] as $b) $volltext .= ' ' . $b[1];
        foreach ($p['textlinks'] ?? [] as [$suchtext, $ziel]) {
            if (!isset($anker[$ziel])) {
                $fehler[] = $p['slug'] . ": Fliesstext-Link auf unbekanntes /$ziel";
            }
            if ($ziel === $p['slug']) {
                $fehler[] = $p['slug'] . ": Fliesstext-Link zeigt auf die Seite selbst";
            }
            if (mb_strpos($volltext, $suchtext) === false) {
                $fehler[] = $p['slug'] . ": Formulierung \"$suchtext\" steht nicht im Text";
            }
        }
    }

    foreach ($nurLinks as $quelle => $ziele) {
        foreach ($ziele as $z) {
            if (!isset($anker[$z])) $fehler[] = "$quelle: Linkziel /$z unbekannt";
        }
    }

    if ($fehler) {
        echo "NICHT IN ORDNUNG:\n";
        foreach ($fehler as $f) echo "  " . $f . "\n";
        exit(1);
    }

    echo "In Ordnung: " . count($seiten) . " Seiten, keine Gedankenstriche, "
       . "keine offenen Platzhalter, Titel und Beschreibungen in der Laenge,\n"
       . "Hauptkeyword in jeder Hauptueberschrift, alle Linkziele bekannt.\n";
    exit(0);
}


// ─────────────────────────────────────────────────────────────
// Modus: Daten fuer die Vorschau
// Aufruf: php dist/scripts/build_plan_0918.php daten > dist/vorschau/daten.json
// ─────────────────────────────────────────────────────────────

if (($argv[1] ?? '') === 'daten') {
    $raus = [];
    foreach ($seiten as $p) {
        // Auf /leistungen bleibt das bestehende Layout stehen. In der
        // Vorschau wird nur gezeigt, was neu dazukommt, sonst faelschte
        // die Vorschau eine Seite vor, die es so nicht gibt.
        if ($p['modus'] === 'ergaenzen') {
            $sek = [
                ['type' => 'content-grid', 'content' => inhaltsRaster($p, $p['h1'])],
                ['type' => 'faq', 'content' => [
                    'heading'  => 'Fragen und Antworten',
                    'subtitle' => '',
                    'items'    => array_map(
                        fn($f) => ['question' => $f[0], 'answer' => '<p>' . $f[1] . '</p>'],
                        $p['faq']
                    ),
                ]],
            ];
            $lb = linkBlock($p['links'], $anker, $p['slug']);
            if ($lb) $sek[] = ['type' => $lb[0], 'content' => $lb[1]];
            $sek[] = ['type' => 'cta-banner', 'content' => [
                'heading'     => $p['cta_heading'],
                'body'        => $p['cta_text'],
                'button_text' => CTA_BUTTON,
                'button_url'  => CTA_URL,
            ]];
        } else {
            $sek = array_map(
                fn($s) => ['type' => $s[0], 'content' => $s[1]],
                sektionen($p, $anker)
            );
        }

        $raus[] = [
            'slug'       => $p['slug'],
            'nav_label'  => $p['nav_label'],
            'meta_title' => $p['meta_title'],
            'meta_desc'  => $p['meta_desc'],
            'sektionen'  => $sek,
        ];
    }

    echo json_encode($raus, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . "\n";
    exit;
}


// ─────────────────────────────────────────────────────────────
// SQL erzeugen
// ─────────────────────────────────────────────────────────────

$o = [];
$o[] = "-- ============================================================";
$o[] = "-- SUI Innova GmbH";
$o[] = "-- Umsetzung des Keyword-Plans vom 18.09.2026";
$o[] = "--";
$o[] = "-- ERZEUGT VON dist/scripts/build_plan_0918.php";
$o[] = "-- Nicht von Hand bearbeiten, sondern den Generator anpassen.";
$o[] = "--";
$o[] = "-- Zwoelf Suchbegriffe auf neun Seiten, davon zwei neu.";
$o[] = "--";
$o[] = "-- WICHTIG: ZUERST die Dateien hochladen, DANN diese SQL.";
$o[] = "-- Die Sektion parallax-image bekommt ein Feld fuer den";
$o[] = "-- Bild-Alt-Text. Ohne die neue Vorlage bleibt er wirkungslos.";
$o[] = "--";
$o[] = "-- Die beiden neuen Seiten werden DEAKTIVIERT angelegt.";
$o[] = "-- Freischalten mit 2-NEUE-SEITEN-ONLINE.sql.";
$o[] = "--";
$o[] = "-- Gefahrlos mehrfach ausfuehrbar.";
$o[] = "-- ============================================================";
$o[] = "";
$o[] = "SET NAMES utf8mb4;";
$o[] = "";
$o[] = "SET @next_sort = (SELECT COALESCE(MAX(sort_order), 0) + 10 FROM pages);";
$o[] = "";

$neuZaehler = 0;

foreach ($seiten as $p) {
    $slug = $p['slug'];

    $o[] = "-- ════════════════════════════════════════════════════════════";
    $o[] = "-- /" . $slug;
    $o[] = "-- Suchbegriff: " . $p['keyword'];
    $o[] = "-- ════════════════════════════════════════════════════════════";
    $o[] = "";

    // ── Seite anlegen, falls neu ──
    if ($p['modus'] === 'neu') {
        $o[] = "INSERT INTO pages (title, slug, meta_title, meta_desc, is_active, is_homepage, sort_order)";
        $o[] = "SELECT " . q($p['nav_label']) . ", " . q($slug) . ", " . q($p['meta_title']) . ", "
             . q($p['meta_desc']) . ", 0, 0, @next_sort + " . $neuZaehler;
        $o[] = "FROM DUAL";
        $o[] = "WHERE NOT EXISTS (SELECT 1 FROM pages WHERE slug = " . q($slug) . ");";
        $o[] = "";
        $neuZaehler += 10;
    }

    $o[] = "SET @pid = (SELECT id FROM pages WHERE slug = " . q($slug) . " LIMIT 1);";
    $o[] = "";

    // ── Titel und Beschreibung ──
    $o[] = "UPDATE pages SET meta_title = " . q($p['meta_title']) . ",";
    $o[] = "                 meta_desc  = " . q($p['meta_desc']);
    $o[] = "WHERE id = @pid AND @pid IS NOT NULL;";
    $o[] = "";

    if ($p['modus'] === 'ergaenzen') {
        // ── /leistungen: eigenes Layout, wird nur ergaenzt ──
        $o[] = "-- Die Seite hat ein eigenes Layout mit Leistungskarten.";
        $o[] = "-- Das bleibt. Die Hauptueberschrift wird gesetzt, Einleitung,";
        $o[] = "-- Abschnitte, Fragen und der Linkblock kommen dazu.";
        $o[] = "";
        $o[] = "-- Die alte Linkliste aus Paket 3b faellt weg. Sie stand als";
        $o[] = "-- Textblock mit fest geschriebenen Links in der Seite und";
        $o[] = "-- wird durch die neue Sektion link-list ersetzt.";
        $o[] = "DELETE FROM sections";
        $o[] = "WHERE page_id = @pid AND @pid IS NOT NULL AND type = 'text-block'";
        $o[] = "  AND (content LIKE '%Leistungen im Detail%' OR content LIKE '%Passend dazu%');";
        $o[] = "";
        $o[] = "-- Die drei Sektionen, die dieses Skript selbst anlegt, fallen";
        $o[] = "-- vorher weg und werden gleich neu geschrieben. Sonst bliebe";
        $o[] = "-- beim zweiten Durchlauf die aeltere Textfassung stehen: die";
        $o[] = "-- Seite hat ihr eigenes Layout, sie wird nicht komplett neu";
        $o[] = "-- aufgebaut wie die anderen. Leistungskarten, Kopfbilder und";
        $o[] = "-- Handlungsaufforderung bleiben unberuehrt.";
        $o[] = "DELETE FROM sections";
        $o[] = "WHERE page_id = @pid AND @pid IS NOT NULL";
        $o[] = "  AND type IN ('content-grid', 'faq', 'link-list');";
        $o[] = "";
        $o[] = "-- Sortierung auf Zehnerschritte bringen, damit dazwischen Platz ist.";
        $o[] = "-- Mehrfach ausgefuehrt kommt dasselbe Ergebnis heraus.";
        $o[] = "SET @r = 0;";
        $o[] = "UPDATE sections SET sort_order = (@r := @r + 10)";
        $o[] = "WHERE page_id = @pid AND @pid IS NOT NULL ORDER BY sort_order, id;";
        $o[] = "";
        $o[] = "-- Hauptueberschrift: die erste Sektion mit Ueberschrift wird zur H1.";
        $o[] = "UPDATE sections s";
        $o[] = "JOIN (";
        $o[] = "    SELECT MIN(sort_order) AS ers FROM sections";
        $o[] = "    WHERE page_id = @pid AND is_active = 1 AND JSON_VALID(content)";
        $o[] = "      AND JSON_UNQUOTE(JSON_EXTRACT(content, '$.heading')) IS NOT NULL";
        $o[] = "      AND JSON_UNQUOTE(JSON_EXTRACT(content, '$.heading')) <> ''";
        $o[] = ") f ON f.ers = s.sort_order";
        $o[] = "SET s.content = JSON_SET(s.content, '$.heading', " . q($p['h1']) . ")";
        $o[] = "WHERE s.page_id = @pid AND @pid IS NOT NULL;";
        $o[] = "";
        $o[] = "-- Bild-Alt-Text auf dem Kopfbanner.";
        $o[] = "UPDATE sections SET content = JSON_SET(content, '$.alt', " . q($p['alt']) . ")";
        $o[] = "WHERE page_id = @pid AND @pid IS NOT NULL";
        $o[] = "  AND type = 'parallax-image' AND JSON_VALID(content)";
        $o[] = "  AND sort_order = (SELECT ers FROM (";
        $o[] = "      SELECT MIN(sort_order) AS ers FROM sections";
        $o[] = "      WHERE page_id = @pid AND type = 'parallax-image') x);";
        $o[] = "";
        $o[] = "-- Handlungsaufforderung auf den Wortlaut aus dem Plan.";
        $o[] = "UPDATE sections SET content = JSON_SET(content,";
        $o[] = "        '$.heading', " . q($p['cta_heading']) . ",";
        $o[] = "        '$.body',    " . q($p['cta_text']) . ")";
        $o[] = "WHERE page_id = @pid AND @pid IS NOT NULL";
        $o[] = "  AND type = 'cta-banner' AND JSON_VALID(content);";
        $o[] = "";

        $zusatz = [
            [25, 'content-grid', inhaltsRaster($p, '')],
            [26, 'faq', [
                'heading'  => 'Fragen und Antworten',
                'subtitle' => '',
                'items'    => array_map(
                    fn($f) => ['question' => $f[0], 'answer' => '<p>' . $f[1] . '</p>'],
                    $p['faq']
                ),
            ]],
        ];
        $lb = linkBlock($p['links'], $anker, $slug);
        if ($lb) $zusatz[] = [27, $lb[0], $lb[1]];

        foreach ($zusatz as [$sort, $typ, $inhalt]) {
            $o[] = "INSERT INTO sections (page_id, type, content, sort_order, is_active)";
            $o[] = "SELECT @pid, " . q($typ) . ", " . j($inhalt) . ", " . $sort . ", 1";
            $o[] = "FROM DUAL WHERE @pid IS NOT NULL;";
            $o[] = "";
        }

        continue;
    }

    // ── Alle anderen: Sektionen neu aufbauen ──
    $o[] = "-- Gewaehltes Kopfbild merken, bevor die Sektionen fallen.";
    $o[] = "SET @img = (";
    $o[] = "    SELECT JSON_UNQUOTE(JSON_EXTRACT(content, '$.image_id'))";
    $o[] = "    FROM sections";
    $o[] = "    WHERE page_id = @pid AND type = 'parallax-image' AND JSON_VALID(content)";
    $o[] = "    ORDER BY sort_order ASC LIMIT 1";
    $o[] = ");";
    $o[] = "";
    $o[] = "DELETE FROM sections WHERE page_id = @pid AND @pid IS NOT NULL;";
    $o[] = "";

    $sort = 10;
    foreach (sektionen($p, $anker) as [$typ, $inhalt]) {
        if ($typ === 'parallax-image') {
            $o[] = "INSERT INTO sections (page_id, type, content, sort_order, is_active)";
            $o[] = "SELECT @pid, 'parallax-image',";
            $o[] = "       JSON_SET(" . j($inhalt) . ", '$.image_id', CAST(COALESCE(@img, 0) AS UNSIGNED)),";
            $o[] = "       " . $sort . ", 1";
            $o[] = "FROM DUAL WHERE @pid IS NOT NULL;";
        } else {
            $o[] = "INSERT INTO sections (page_id, type, content, sort_order, is_active)";
            $o[] = "SELECT @pid, " . q($typ) . ", " . j($inhalt) . ", " . $sort . ", 1";
            $o[] = "FROM DUAL WHERE @pid IS NOT NULL;";
        }
        $o[] = "";
        $sort += 10;
    }
}


// ── Linkbloecke auf Seiten, die sonst unveraendert bleiben ──
foreach ($nurLinks as $quelle => $ziele) {
    $lb = linkBlock($ziele, $anker, $quelle);
    if (!$lb) continue;

    $o[] = "-- ════════════════════════════════════════════════════════════";
    $o[] = "-- /" . $quelle . " — nur der Linkblock";
    $o[] = "-- ════════════════════════════════════════════════════════════";
    $o[] = "SET @pid = (SELECT id FROM pages WHERE slug = " . q($quelle) . " LIMIT 1);";
    $o[] = "";
    $o[] = "-- Vorhandenen Block ersetzen, sonst anhaengen. Die zweite";
    $o[] = "-- Bedingung raeumt die alte Fassung als Textblock mit weg.";
    $o[] = "DELETE FROM sections";
    $o[] = "WHERE page_id = @pid AND @pid IS NOT NULL";
    $o[] = "  AND (type = 'link-list' OR (type = 'text-block' AND content LIKE '%Passend dazu%'));";
    $o[] = "";
    $o[] = "-- Erst nach dem Loeschen zaehlen, sonst waechst die Sortierung";
    $o[] = "-- bei jedem Durchlauf um zehn.";
    $o[] = "SET @sort = (SELECT COALESCE(MAX(sort_order), 0) + 10 FROM sections WHERE page_id = @pid);";
    $o[] = "";
    $o[] = "INSERT INTO sections (page_id, type, content, sort_order, is_active)";
    $o[] = "SELECT @pid, 'link-list', " . j($lb[1]) . ", @sort, 1";
    $o[] = "FROM DUAL WHERE @pid IS NOT NULL;";
    $o[] = "";
}


// ── Startseite: Linkblock auf alle neun Leistungsseiten ──
//
// Die Startseite ist die staerkste Seite der Website. Bisher zeigte sie
// auf die Leistungsseiten nur ueber den Footer, und der steht auf jeder
// Seite gleich. Ein Link im Inhalt der Startseite wiegt deutlich mehr.
//
// Die Startseite wird ueber is_homepage gefunden, nicht ueber den Slug:
// welcher Slug die Startseite ist, kann sich aendern.
$startseiteZiele = array_keys($anker);
$sb = linkBlock($startseiteZiele, $anker, '');
if ($sb) {
    $sb[1]['heading'] = 'Unsere Leistungen im Detail';

    $o[] = "-- ════════════════════════════════════════════════════════════";
    $o[] = "-- Startseite — Linkblock auf die neun Leistungsseiten";
    $o[] = "-- ════════════════════════════════════════════════════════════";
    $o[] = "SET @pid = (SELECT id FROM pages WHERE is_homepage = 1 LIMIT 1);";
    $o[] = "";
    $o[] = "DELETE FROM sections";
    $o[] = "WHERE page_id = @pid AND @pid IS NOT NULL AND type = 'link-list';";
    $o[] = "";
    $o[] = "-- Sortierung auf Zehnerschritte, damit dazwischen Platz bleibt.";
    $o[] = "SET @r = 0;";
    $o[] = "UPDATE sections SET sort_order = (@r := @r + 10)";
    $o[] = "WHERE page_id = @pid AND @pid IS NOT NULL ORDER BY sort_order, id;";
    $o[] = "";
    $o[] = "-- Der Block gehoert hinter den Inhalt und vor die letzte";
    $o[] = "-- Handlungsaufforderung. Gibt es keine, kommt er ganz unten hin.";
    $o[] = "SET @cta = (SELECT MAX(sort_order) FROM sections";
    $o[] = "            WHERE page_id = @pid AND type = 'cta-banner');";
    $o[] = "SET @sort = COALESCE(@cta - 5,";
    $o[] = "            (SELECT COALESCE(MAX(sort_order), 0) + 10 FROM sections WHERE page_id = @pid));";
    $o[] = "";
    $o[] = "INSERT INTO sections (page_id, type, content, sort_order, is_active)";
    $o[] = "SELECT @pid, 'link-list', " . j($sb[1]) . ", @sort, 1";
    $o[] = "FROM DUAL WHERE @pid IS NOT NULL;";
    $o[] = "";
}


$o[] = "-- ────────────────────────────────────────────────────────────";
$o[] = "-- Kontrolle";
$o[] = "-- ────────────────────────────────────────────────────────────";
$o[] = "-- SELECT slug, is_active, LEFT(meta_title, 60) FROM pages ORDER BY sort_order;";
$o[] = "-- SELECT p.slug, COUNT(s.id) AS sektionen,";
$o[] = "--        GROUP_CONCAT(s.type ORDER BY s.sort_order) AS aufbau";
$o[] = "-- FROM pages p LEFT JOIN sections s ON s.page_id = p.id";
$o[] = "-- GROUP BY p.slug ORDER BY p.sort_order;";

echo implode("\n", $o) . "\n";
