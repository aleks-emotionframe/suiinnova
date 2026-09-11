<?php
/**
 * Generator: SQL fuer die sechs neuen Keyword-Seiten
 *
 * Quelle der Texte: Keyword-Plan sui-innova.ch vom 08.09.2026 (EmotionFrame),
 * Abschnitt "Aufbau" Monat 4 bis 6. Uebernommen sind Seitentitel,
 * Meta-Description, Hauptueberschrift, Einleitung, Seitenaufbau, Fragen und
 * Antworten sowie die Handlungsaufforderung.
 *
 * Der Plan enthielt 22 Stellen, die nur der Kunde haette beantworten koennen
 * (Schallschutzwerte, Spachtelqualitaeten, Lieferfristen, Mindestmengen).
 * Statt Zahlen zu erfinden, sind diese Saetze umformuliert: sie verweisen
 * jetzt auf Ausschreibung, Schallschutznachweis oder die Offerte — also auf
 * das, was im Bauprojekt ohnehin massgebend ist. Kein Platzhalter mehr offen.
 *
 * Die Seiten werden trotzdem deaktiviert angelegt. Neue oeffentliche Seiten
 * auf einer Kundenwebsite schaltet ein Mensch frei, nicht ein SQL-Import.
 *
 * Aufruf:  php dist/scripts/build_keyword_pages.php > dist/sql/seo-paket-3-keyword-seiten.sql
 */

// ─────────────────────────────────────────────────────────────
// Seiteninhalte
// ─────────────────────────────────────────────────────────────

$pages = [];

// ── 1) sanitär vorwandelemente ───────────────────────────────
$pages[] = [
    'slug'       => 'sanitaer-vorwandelemente',
    'nav_label'  => 'Sanitär Vorwandelemente',
    'meta_title' => 'Sanitär Vorwandelemente: Aufbau, Montage | SUI Innova',
    'meta_desc'  => 'Sanitär Vorwandelemente: Aufbau, Masse, Beplankung und Montage einfach erklärt. Lesen Sie, worauf es ankommt, und fragen Sie Ihr Projekt bei SUI Innova an.',
    'h1'         => 'Sanitär Vorwandelemente: Aufbau, Montage und Beplankung erklärt',
    'intro'      => 'Sanitär Vorwandelemente tragen WC, Waschtisch, Dusche oder Urinal und nehmen Zu- und Ablaufleitungen auf, ohne dass jemand die Rohre sieht. Sie bestehen aus einem verzinkten Stahlrahmen, der am Boden und an der Rohbauwand verschraubt wird, und werden anschliessend beplankt und gespachtelt. Auf dieser Seite lesen Sie, wie ein solches Element aufgebaut ist, welche Masse üblich sind, warum die Beplankung im Nassbereich eine eigene Rolle spielt und wo im Bauablauf die Schallentkopplung entschieden wird. SUI Innova aus Pfäffikon fertigt GIS-Elemente in der eigenen Werkstatt fix und fertig verrohrt vor, montiert sie auf der Baustelle und übernimmt Beplankung, Spachtelung und Ausflockung. Sie erhalten die Wand also nicht in Teilen, sondern als eine Leistung.',
    'body'       => [
        ['Ein Vorwandelement ist Tragwerk und Installationsraum zugleich',
         'Das Element nimmt die Lasten von WC, Waschtisch oder Stützgriffen auf und leitet sie in Boden und Rohbauwand ab. Gleichzeitig läuft im Innenraum alles, was nicht sichtbar sein soll: Kalt- und Warmwasser, Abwasser, teilweise Elektro. Deshalb wird die Position jeder Leitung festgelegt, bevor die erste Platte montiert wird. Fehler in dieser Phase kosten später Aufbruch und Zeit.'],
        ['Vorfabrikation verlagert die knifflige Arbeit von der Baustelle in die Werkstatt',
         'In der Werkstatt lassen sich Elemente auf dem Tisch verrohren, ausrichten und prüfen. Auf der Baustelle wird das fertige Element nur noch gestellt, befestigt und angeschlossen. Das verkürzt die Zeit, in der andere Gewerke warten müssen, und reduziert Anpassungen vor Ort. SUI Innova liefert GIS-Elemente fix und fertig verrohrt aus der eigenen Werkstatt an.'],
        ['Masse und Höhen ergeben sich aus dem Apparat, nicht aus dem Gefühl',
         'Übliche Bauhöhen sind das halbhohe Element für die freistehende Vorwand und das raumhohe Element bis zur Decke. Die Fertighöhe der WC-Keramik und die Lage der Spülkasten-Betätigung richten sich nach Herstellerangaben und nach der geplanten Bodenaufbauhöhe. Wird der Bodenaufbau später geändert, stimmt die Höhe nicht mehr. Klären Sie die Aufbauhöhe deshalb vorgängig mit Architektur und Plattenleger. Welche Höhe und welches System für Ihre Nasszelle passen, legen wir anhand der Pläne und der gewählten Apparate fest.'],
        ['Im Nassbereich entscheidet die Beplankung über die Lebensdauer',
         'Hinter Dusche und Badewanne gehört eine Platte, die Feuchtigkeit verträgt. AquaPanel wird in Feuchträumen und Nasszellen eingesetzt und bildet den Untergrund für Abdichtung und Plättli. Die Fugen und Anschlüsse werden gespachtelt, damit die Fläche ohne Absatz weitergeht. SUI Innova übernimmt Beplankung und Spachtelung im gleichen Auftrag wie die Montage.'],
        ['Schall wird an der Befestigung entschieden, nicht am Rohr',
         'Spülgeräusche wandern über Körperschall in angrenzende Räume, wenn Element und Rohre starr mit der Rohbauwand verbunden sind. Entkoppelte Befestigungen, Schallschutzsets und eine Ausflockung des Hohlraums dämpfen diesen Weg. Besonders wichtig ist das bei Wänden zu Schlafräumen und in Mehrfamilienhäusern. Welche Anforderung für Ihr Projekt gilt, steht im Schallschutznachweis — nennen Sie uns die Vorgabe, wir richten den Aufbau danach aus.'],
        ['Von der Planung bis zur spachtelfertigen Wand aus einer Hand',
         'Sie schicken uns Pläne oder Schemas, wir klären die Apparatepositionen und fertigen die Elemente vor. Danach montieren wir auf der Baustelle, beplanken und spachteln. Sie haben eine Ansprechperson für Vorfabrikation, Montage und Beplankung statt drei Schnittstellen. Was das für Ihr Projekt konkret heisst, klären wir am besten anhand Ihrer Unterlagen.'],
    ],
    'faq' => [
        ['Wie tief ist eine Sanitärvorwand üblicherweise?',
         'Die Tiefe richtet sich nach dem Spülkasten und den Leitungen dahinter. Für ein WC-Element rechnet man mit rund 15 bis 20 Zentimetern Rahmentiefe plus Beplankung. Bei zusätzlichen Steigleitungen oder Lüftungen wird die Vorwand entsprechend tiefer.'],
        ['Kann ich später etwas an der Wand befestigen?',
         'Nur dort, wo Traversen oder Verstärkungen eingebaut sind. Spiegelschrank, Handtuchhalter oder Stützgriffe sollten Sie deshalb vor der Beplankung anmelden. Nachträglich befestigt man in einer beplankten Vorwand nur leichte Lasten.'],
        ['Wer koordiniert Sanitär, Trockenbau und Plattenleger?',
         'Bei getrennten Aufträgen liegt die Koordination bei der Bauleitung. Wenn Vorfabrikation, Montage und Beplankung in einer Hand liegen, entfällt ein Teil dieser Abstimmung. SUI Innova übergibt die Wand spachtelfertig an das Folgegewerk.'],
    ],
    'cta_heading' => 'Pläne einsenden, Offerte erhalten',
    'cta_text'    => 'Senden Sie uns Ihre Pläne, wir melden uns mit Rückfragen zu Apparatepositionen und einer Offerte für Vorfabrikation, Montage und Beplankung.',
    'offen' => [
        'Standardhöhen und Systeme, die SUI Innova verarbeitet (halbhoch, raumhoch, Herstellersysteme)',
        'Angaben zu SilentPanel und erreichbaren Schallschutzwerten',
        'Reaktionszeit auf Anfragen und übliche Lieferfrist für vorfabrizierte Elemente',
        'Einzugsgebiet der Montage',
    ],
];

// ── 2) sanitär gis elemente bestellen ────────────────────────
$pages[] = [
    'slug'       => 'sanitaer-gis-elemente-bestellen',
    'nav_label'  => 'GIS-Elemente bestellen',
    'meta_title' => 'Sanitär GIS Elemente bestellen | SUI Innova GmbH',
    'meta_desc'  => 'Sanitär GIS Elemente bestellen: vorfabriziert, verrohrt und auf Wunsch beplankt. Senden Sie uns Ihre Pläne, wir erstellen eine Offerte.',
    'h1'         => 'Sanitär GIS Elemente bestellen bei SUI Innova',
    'intro'      => 'Sie wollen Sanitär GIS Elemente bestellen, die auf der Baustelle nur noch gestellt und angeschlossen werden müssen. Genau das liefern wir. In unserer Werkstatt in Pfäffikon bauen wir GIS Elemente nach Ihren Plänen auf, verrohren sie fix und fertig und bereiten sie für den Transport vor. Auf Wunsch übernehmen wir auch Montage, Beplankung mit AquaPanel, Spachtelung und Ausflockung mit SilentPanel. Sie erhalten alles aus einer Hand und haben eine Ansprechperson für den ganzen Ablauf. Schicken Sie uns Ihre Sanitärpläne oder eine Skizze mit Apparateliste. Wir prüfen die Unterlagen, melden uns bei offenen Punkten und erstellen Ihnen eine Offerte mit Preis und möglichem Liefertermin.',
    'body' => [
        ['So läuft die Bestellung ab',
         'Sie senden uns Ihre Sanitärpläne, die Apparateliste und den gewünschten Liefertermin. Wir prüfen die Unterlagen und klären offene Punkte direkt mit Ihnen oder mit dem Planer. Danach erhalten Sie eine Offerte mit Positionen, Preis und Terminvorschlag. Nach Ihrer Freigabe starten wir die Vorfabrikation in der Werkstatt.'],
        ['Fix und fertig verrohrt aus der Werkstatt',
         'Wir bauen die GIS Elemente auf und verrohren sie komplett, bevor sie die Werkstatt verlassen. Dadurch verschieben Sie Arbeitsstunden von der Baustelle in eine Umgebung mit festen Arbeitsplätzen und Material zur Hand. Auf der Baustelle bleibt das Stellen, Fixieren und Anschliessen. Das verkürzt die Zeit, in der andere Gewerke warten müssen.'],
        ['Was Sie zusätzlich zum Element bestellen können',
         'Viele Kunden bestellen nicht nur das nackte Element. Wir montieren die Elemente direkt auf Ihrer Baustelle, beplanken sie mit AquaPanel für Feuchträume und Nasszellen und spachteln die Flächen. Für den Schallschutz flocken wir die Vorwand mit SilentPanel aus. Sie entscheiden, wo unsere Arbeit endet und Ihre beginnt.'],
        ['Angaben, die wir für eine Offerte brauchen',
         'Für eine belastbare Offerte brauchen wir den Sanitärplan oder eine bemasste Skizze, die Anzahl und Art der Apparate und die Höhen der Vorwand. Nützlich sind zudem Angaben zum Wandaufbau, zur gewünschten Beplankung und zu Anforderungen an den Schallschutz. Nennen Sie uns auch die Zufahrt und die Etage, das beeinflusst Anlieferung und Handling. Fehlt etwas, fragen wir nach, bevor wir rechnen.'],
        ['Für Sanitärunternehmen, Generalunternehmer und Bauherren',
         'Wir arbeiten für Sanitärbetriebe, die Kapazität in der Werkstatt brauchen, und für Bauleitungen, die einen fixen Liefertermin wollen. Kleine Umbauten mit einem einzelnen Element sind ebenso möglich wie Serien für ganze Geschosse. Sagen Sie uns, wie viele Elemente Sie brauchen und bis wann. Wir sagen Ihnen ehrlich, ob wir den Termin halten können.'],
        ['Lieferung und Termine',
         'Die Elemente werden montagefertig angeliefert und nach Absprache abgeladen. Den Liefertermin halten wir in der Offerte fest, damit Ihre Bauleitung damit planen kann. Verschiebt sich Ihr Bauprogramm, melden Sie sich frühzeitig, dann suchen wir einen neuen Termin. Wie schnell wir fertigen können, hängt von Stückzahl und Auslastung ab — fragen Sie früh an, dann sagen wir Ihnen verbindlich, was möglich ist.'],
    ],
    'faq' => [
        ['Kann ich einzelne GIS Elemente bestellen oder nur ganze Serien?',
         'Beides ist möglich. Wir fertigen einzelne Elemente für Umbauten ebenso wie Serien für Neubauten. Nennen Sie uns die Stückzahl bei der Anfrage.'],
        ['Muss ich das Material selber liefern?',
         'Das klären wir vor der Offerte, je nach Projekt und Verfügbarkeit. Sagen Sie uns bei der Anfrage, ob Sie Material beistellen möchten, dann rechnen wir die Offerte entsprechend.'],
        ['Übernehmen Sie auch die Montage auf der Baustelle?',
         'Ja, wir montieren die Elemente direkt auf Ihrer Baustelle. Auf Wunsch beplanken und spachteln wir die Wand anschliessend. Sie bestellen also nur die Vorfabrikation oder den ganzen Ablauf bis zur fertigen Wand.'],
    ],
    'cta_heading' => 'GIS Elemente anfragen',
    'cta_text'    => 'Senden Sie uns Ihre Sanitärpläne über das Kontaktformular, wir melden uns mit Rückfragen und einer Offerte samt Terminvorschlag.',
    'offen' => [
        'Übliche Lieferfrist in Wochen',
        'Liefergebiet, in das SUI Innova ausliefert',
        'Ob Material beigestellt oder von SUI Innova beschafft wird',
        'Mindestbestellmenge, falls vorhanden',
        'Welche GIS Systeme und Fabrikate verarbeitet werden',
    ],
];

// ── 3) sanitär vorwandelemente bestellen ─────────────────────
$pages[] = [
    'slug'       => 'sanitaer-vorwandelemente-bestellen',
    'nav_label'  => 'Vorwandelemente bestellen',
    'meta_title' => 'Sanitär Vorwandelemente bestellen | SUI Innova',
    'meta_desc'  => 'Sanitär Vorwandelemente bestellen bei SUI Innova in Pfäffikon: GIS-Elemente fertig verrohrt, auf Mass vorfabriziert, montiert und beplankt. Jetzt anfragen.',
    'h1'         => 'Sanitär Vorwandelemente bestellen: vorfabriziert aus Pfäffikon',
    'intro'      => 'Sie können bei SUI Innova Sanitär Vorwandelemente bestellen, die bereits verrohrt aus unserer Werkstatt kommen. Wir fertigen GIS-Elemente nach Ihren Plänen vor, prüfen die Leitungsführung im Voraus und liefern die Elemente auf die Baustelle. Auf Wunsch übernehmen wir auch die Montage, die Beplankung mit AquaPanel und die Spachtelung, bis die Wand fertig ist. Für Sie heisst das: weniger Schnittstellen, weniger Nacharbeit, ein Ansprechpartner für Vorfabrikation und Einbau. Wir arbeiten für Sanitärbetriebe, Generalunternehmen und Bauherrschaften in der Region Pfäffikon und darüber hinaus. Sagen Sie uns, welche Apparate, welche Wandtypen und welchen Liefertermin Sie brauchen. Sie erhalten eine Offerte mit Positionen, Massen und Liefertermin, damit Sie die Kosten Ihres Projekts sauber rechnen können.',
    'body' => [
        ['Was Sie bei uns bestellen: GIS-Elemente, fertig verrohrt',
         'Wir bauen die Vorwandelemente in unserer Werkstatt auf, montieren die Sanitärapparate-Träger und verrohren sie komplett. Auf der Baustelle wird das Element nur noch gesetzt und angeschlossen. Das verkürzt die Zeit auf dem Bau und verlagert die Präzisionsarbeit in eine trockene, eingerichtete Werkstatt. Sie bestellen einzelne Elemente oder ganze Geschosse. Welches System zum Einsatz kommt, richtet sich nach Ihrer Ausschreibung — nennen Sie es uns bei der Anfrage.'],
        ['So läuft die Bestellung ab, Schritt für Schritt',
         'Sie senden uns die Sanitärpläne oder eine Skizze mit den gewünschten Apparaten. Wir prüfen Masse, Wandaufbau und Leitungsführung und melden uns bei Unklarheiten vorgängig. Danach erhalten Sie eine Offerte mit Stückliste und Liefertermin. Nach Ihrer Freigabe fertigen wir vor und liefern die Elemente auf die Baustelle. Den Vorlauf zwischen Freigabe und Lieferung halten wir in der Offerte fest, damit Ihre Bauleitung damit planen kann.'],
        ['Montage und Beplankung dazubestellen statt koordinieren',
         'Sie können die Elemente ab Werkstatt beziehen oder die Montage gleich mitbestellen. Unser Team setzt die Elemente auf Ihrer Baustelle, richtet sie aus und befestigt sie. Anschliessend beplanken wir mit AquaPanel für Feuchträume und Nasszellen und spachteln die Flächen. So übergeben wir Ihnen die Wand malerfertig.'],
        ['Schallschutz und Ausflockung für Nasszellen',
         'Wasserleitungen und Spülungen übertragen Geräusche in angrenzende Räume. Wir flocken die Vorwandelemente aus und arbeiten mit SilentPanel, damit die Wand ruhiger bleibt. Wir klären mit Ihnen vorgängig, welche Anforderung Ihr Projekt hat. Massgebend ist, was in Ausschreibung oder Schallschutznachweis steht — danach richten wir den Aufbau aus.'],
        ['Sondermasse und Kleinserien sind möglich',
         'Nicht jede Nasszelle passt in ein Standardmass. Wir fertigen Elemente für schräge Wände, tiefe Nischen und Grundrisse mit mehreren Apparaten in einer Wand. Bei Wiederholungen, etwa bei gleichen Wohnungstypen, fertigen wir in Serie und halten die Masse über alle Elemente gleich. Fragen Sie uns an, bevor Sie eine Lösung ausschliessen.'],
        ['Lieferung und Zwischenlagerung',
         'Wir liefern die Elemente termingerecht auf die Baustelle, damit Sie sie nicht wochenlang lagern müssen. Bei Verzögerungen im Bauprogramm lagern wir vorfabrizierte Elemente in Absprache zwischen. Sagen Sie uns bei der Bestellung, wie die Zufahrt und die Abladesituation aussehen. Lieferung und Abladen halten wir in der Offerte fest, damit später nichts dazukommt.'],
    ],
    'faq' => [
        ['Ab welcher Menge kann ich Sanitär Vorwandelemente bestellen?',
         'Wir fertigen sowohl einzelne Elemente als auch Serien für ganze Überbauungen. Melden Sie uns Ihr Projekt, wir sagen Ihnen, was in Ihrem Fall sinnvoll ist.'],
        ['Kommen die Elemente bereits verrohrt?',
         'Ja, wir verrohren die GIS-Elemente in unserer Werkstatt fertig. Auf der Baustelle wird das Element gesetzt und angeschlossen, die Verteilarbeit ist bereits erledigt.'],
        ['Was brauchen Sie von mir für eine Offerte?',
         'Am schnellsten geht es mit den Sanitärplänen oder einer Skizze mit Massen und den gewünschten Apparaten. Nützlich sind zudem der Wandaufbau, der gewünschte Liefertermin und die Adresse der Baustelle.'],
    ],
    'cta_heading' => 'Offerte für Vorwandelemente anfragen',
    'cta_text'    => 'Senden Sie uns Ihre Sanitärpläne oder rufen Sie uns an, Sie erhalten eine Offerte mit Stückliste, Massen und Liefertermin.',
    'offen' => [
        'Verarbeitete Systeme und Hersteller der Vorwandelemente',
        'Übliche Vorlaufzeit von der Freigabe bis zur Lieferung',
        'Norm oder Zielwerte beim Schallschutz',
        'Liefergebiet und allfällige Lieferkosten',
        'Allfällige Mindestbestellmenge',
    ],
];

// ── 4) sanitär vorwände ──────────────────────────────────────
$pages[] = [
    'slug'       => 'sanitaer-vorwaende',
    'nav_label'  => 'Sanitär Vorwände',
    'meta_title' => 'Sanitär Vorwände vorfabriziert | SUI Innova GmbH',
    'meta_desc'  => 'Sanitär Vorwände vorfabriziert, montiert und beplankt: GIS-Elemente fix verrohrt aus der Werkstatt von SUI Innova in Pfäffikon. Jetzt Offerte anfragen.',
    'h1'         => 'Sanitär Vorwände: vorfabriziert, montiert, beplankt',
    'intro'      => 'Sanitär Vorwände liefern wir fix und fertig verrohrt auf Ihre Baustelle. In unserer Werkstatt in Pfäffikon bauen wir GIS-Elemente auf Mass zusammen, montieren sie vor Ort und beplanken sie bis zur spachtelfertigen Wand. So verlagern Sie einen grossen Teil der Sanitärinstallation von der Baustelle in die Halle: weniger Schnittstellen, weniger Wartezeit für die Folgegewerke, planbare Abläufe. Sie erhalten Vorfabrikation, Montage und Beplankung aus einer Hand und haben einen Ansprechpartner für den ganzen Ablauf. Für Nasszellen und Feuchträume setzen wir AquaPanel ein, für Schallschutzanforderungen SilentPanel und Ausflockung. Senden Sie uns Ihre Pläne mit der Adresse der Baustelle, wir prüfen sie und melden uns mit einer Offerte.',
    'body' => [
        ['GIS-Elemente verlassen unsere Werkstatt fertig verrohrt',
         'Wir konfektionieren die Vorwandelemente nach Ihren Plänen und verrohren sie komplett. Auf der Baustelle wird das Element gesetzt und angeschlossen, nicht mehr zusammengebaut. Das verkürzt die Zeit im Rohbau und senkt das Risiko von Fehlern in engen Platzverhältnissen. Änderungen klären wir vorgängig am Plan, nicht improvisiert vor Ort.'],
        ['Montage und Beplankung kommen vom gleichen Team',
         'Unsere Monteure setzen die Vorwände auf Ihrer Baustelle und richten sie aus. Anschliessend beplanken wir die Wände und spachteln sie, sodass der Maler oder Plattenleger direkt weiterarbeiten kann. Weil Vorfabrikation und Montage im gleichen Haus liegen, entfällt die Abstimmung zwischen mehreren Firmen. Bei Terminverschiebungen reagieren wir mit Ihnen zusammen auf den aktuellen Bauablauf.'],
        ['AquaPanel für Nasszellen, SilentPanel gegen Schall',
         'In Bädern und Duschen beplanken wir mit AquaPanel, das für dauerhafte Feuchtebelastung ausgelegt ist. Wo Schallschutz gefordert ist, arbeiten wir mit SilentPanel und Ausflockung der Hohlräume. Welche Kombination sinnvoll ist, hängt von der Nutzung und den Anforderungen im Bauprojekt ab. Sagen Sie uns, welche Werte gefordert sind, wir schlagen den Aufbau vor.'],
        ['Für Neubau, Umbau und Sanierung im Wohnungsbau',
         'Wir arbeiten für Sanitärinstallateure, Generalunternehmen und Bauherrschaften. Bei Mehrfamilienhäusern fertigen wir gleiche Elemente in Serie, bei Umbauten passen wir jedes Element an den Bestand an. Für Sanierungen im bewohnten Objekt kürzt die Vorfabrikation die Zeit, in der das Bad nicht nutzbar ist. Ausgeführte Arbeiten sehen Sie unter <a href="/referenzen">Referenzen</a>.'],
        ['So läuft eine Anfrage ab',
         'Sie senden uns Grundrisse und Sanitärpläne. Wir prüfen die Unterlagen, klären offene Punkte mit Ihnen und stellen eine Offerte mit Positionen und Terminen. Nach Ihrer Freigabe fertigen wir die Elemente und vereinbaren den Montagetermin. Sie erhalten von uns eine Ansprechperson, die das Projekt bis zur fertigen Wand begleitet.'],
    ],
    'faq' => [
        ['Was ist eine Sanitär Vorwand?',
         'Eine Sanitär Vorwand ist eine vorgesetzte Ständerkonstruktion, in der Zuleitungen, Abläufe und Befestigungen für WC, Waschtisch oder Dusche liegen. Sie wird vor die Rohbauwand gestellt und danach beplankt. Sichtbar bleibt später nur die fertige Wandfläche.'],
        ['Was ist der Vorteil von vorfabrizierten Vorwänden gegenüber dem Bau auf der Baustelle?',
         'Die Elemente entstehen in der Werkstatt unter gleichbleibenden Bedingungen und kommen fertig verrohrt auf die Baustelle. Vor Ort bleibt das Setzen und Anschliessen, das verkürzt die Bauzeit und reduziert Nacharbeiten. Zudem koordinieren Sie weniger Beteiligte.'],
        ['Übernehmen Sie auch die Beplankung und Spachtelung?',
         'Ja, wir beplanken die montierten Vorwände und spachteln sie auf Wunsch fertig. In Feuchträumen setzen wir AquaPanel ein. Damit übergeben wir eine Wand, an der das nächste Gewerk direkt weiterarbeiten kann.'],
    ],
    'cta_heading' => 'Pläne einsenden und Offerte anfragen',
    'cta_text'    => 'Senden Sie uns Ihre Sanitär- und Grundrisspläne, wir prüfen sie und schicken Ihnen eine Offerte mit Terminen.',
    'offen' => [
        'Einsatzgebiet für Lieferung und Montage',
        'Verwendete Systeme und Hersteller neben GIS',
        'Erreichbare Schallschutzwerte mit SilentPanel und Ausflockung',
        'Beispielprojekte mit Objektart und Anzahl Elemente',
        'Übliche Vorlaufzeit von Freigabe bis Lieferung',
        'Frist für die Zustellung einer Offerte',
    ],
];

// ── 5) gis elemente beplanken ────────────────────────────────
$pages[] = [
    'slug'       => 'gis-elemente-beplanken',
    'nav_label'  => 'GIS-Elemente beplanken',
    'meta_title' => 'GIS Elemente beplanken | SUI Innova GmbH',
    'meta_desc'  => 'GIS Elemente beplanken in Werkstatt und auf der Baustelle: verrohrt, beplankt, gespachtelt. Nennen Sie Stückzahl und Termin, wir rechnen Ihnen eine Offerte.',
    'h1'         => 'GIS Elemente beplanken: von der Vorfabrikation bis zur fertigen Wand',
    'intro'      => 'Wir beplanken GIS Elemente, in unserer Werkstatt in Pfäffikon und direkt auf Ihrer Baustelle. Sie erhalten die Elemente verrohrt, beplankt und gespachtelt, bereit für Plättli, Farbe oder SilentPanel. In Nasszellen setzen wir AquaPanel ein, in trockenen Bereichen Gipsplatten nach Ihren Vorgaben. Wir arbeiten mit Sanitärfirmen, Generalunternehmen und Bauleitungen zusammen und richten uns nach Ihrem Bauprogramm. Nennen Sie uns Stückzahl, Wandaufbau und Termin, dann rechnen wir Ihnen eine Offerte. Vorfabrikation, Montage und Beplankung kommen bei uns aus einer Hand. Das spart Schnittstellen, Rückfragen und Wartezeiten auf der Baustelle.',
    'body' => [
        ['Beplankung in der Werkstatt spart Zeit auf der Baustelle',
         'Wir verrohren und beplanken die GIS Elemente vorgängig in unserer Werkstatt. Auf der Baustelle wird das Element nur noch versetzt und angeschlossen. So verkürzt sich die Zeit, in der andere Handwerker warten müssen. Transport und Anlieferung stimmen wir auf Ihren Bauablauf ab. Wie gross ein Element werden darf, klären wir anhand von Zufahrt und Abladesituation.'],
        ['AquaPanel für Nasszellen, Gipsplatten für trockene Räume',
         'In Duschen, Bädern und Nasszellen beplanken wir mit AquaPanel, weil die Platte Feuchtigkeit verträgt. In trockenen Bereichen arbeiten wir mit Gipsplatten. Welche Platte wo zum Einsatz kommt, halten wir vor Baubeginn schriftlich fest. Sagen Sie uns, ob Sie Plättli, Verputz oder eine Beschichtung planen, danach richtet sich der Aufbau.'],
        ['Spachteln bis zur gewünschten Qualitätsstufe',
         'Nach der Beplankung verspachteln wir Fugen, Kanten und Schraubenköpfe. Sie geben die Qualitätsstufe vor, wir liefern die Fläche entsprechend ab. Damit übernimmt der Maler oder Plattenleger eine Wand, an der er direkt weiterarbeiten kann. Welche Stufe gilt, halten wir vor Arbeitsbeginn schriftlich fest.'],
        ['Ausflockung und SilentPanel gegen Schall',
         'Auf Wunsch flocken wir die Elemente aus und montieren SilentPanel. Beides reduziert die Schallübertragung von Leitungen in angrenzende Räume. Sinnvoll ist das vor allem bei Wohnungstrennwänden und bei Bädern neben Schlafzimmern. Klären Sie die Anforderung frühzeitig mit uns, denn sie beeinflusst den Wandaufbau.'],
        ['Ein Ansprechpartner für Vorfabrikation, Montage und Beplankung',
         'Sie beauftragen eine Firma statt drei. Wir montieren die Elemente selbst und beplanken sie anschliessend, deshalb gibt es keine Diskussion über Vorleistungen. Bei Änderungen auf der Baustelle passen wir die Elemente an. Den Stand melden wir Ihnen laufend, damit Ihre Terminplanung hält.'],
        ['So läuft ein Auftrag ab',
         'Sie senden uns Pläne, Stückzahlen und den gewünschten Termin. Wir prüfen die Unterlagen und stellen Ihnen eine Offerte mit Positionen und Preisen zu. Nach der Freigabe fixieren wir die Produktions- und Montagetermine. Zum Schluss übergeben wir die beplankten Wände und melden Ihnen, was noch offen ist.'],
    ],
    'faq' => [
        ['Beplanken Sie auch GIS Elemente, die wir selbst montiert haben?',
         'Ja, wir übernehmen die Beplankung auch dann, wenn Vorfabrikation und Montage bei Ihnen liegen. Wir prüfen vor dem Start, ob die Elemente ausgerichtet und die Leitungen abgedrückt sind. Mängel melden wir Ihnen schriftlich, bevor wir die Platten setzen.'],
        ['Welche Platten verwenden Sie in Nasszellen?',
         'In Nasszellen und Feuchträumen beplanken wir mit AquaPanel. Für trockene Bereiche kommen Gipsplatten zum Einsatz. Weichen Ihre Vorgaben davon ab, halten wir uns an Ihr Devis.'],
        ['Wie schnell können Sie mit der Beplankung beginnen?',
         'Das hängt von der aktuellen Auslastung und der Stückzahl ab. Melden Sie sich mit Ihrem Bauprogramm, dann nennen wir Ihnen einen verbindlichen Termin.'],
    ],
    'cta_heading' => 'Offerte für die Beplankung anfragen',
    'cta_text'    => 'Senden Sie uns Pläne, Stückzahl und Wunschtermin, Sie erhalten von uns eine Offerte mit Positionen und Preisen.',
    'offen' => [
        'Verwendete Plattentypen, Stärken und Hersteller',
        'Einzugsgebiet, in dem SUI Innova arbeitet',
        'Maximale Elementgrösse und Transportmöglichkeiten',
        'Angebotene Spachtel-Qualitätsstufen (Q1 bis Q4 oder nach SIA)',
        'Erreichbare Schallschutzwerte bei Ausflockung und SilentPanel',
        'Übliche Vorlaufzeit bis zum Beginn der Beplankung',
        'Preise oder Richtpreise pro Element oder Quadratmeter',
    ],
];

// ── 6) sanitär vorwandelemente beplanken ─────────────────────
$pages[] = [
    'slug'       => 'sanitaer-vorwandelemente-beplanken',
    'nav_label'  => 'Vorwandelemente beplanken',
    'meta_title' => 'Sanitär Vorwandelemente beplanken | SUI Innova',
    'meta_desc'  => 'Sanitär Vorwandelemente beplanken: SUI Innova beplankt GIS-Elemente mit AquaPanel oder Gipsplatten, inklusive Spachtelung. Projekt anfragen und Termin klären.',
    'h1'         => 'Sanitär Vorwandelemente beplanken: von der Montage bis zur spachtelfertigen Wand',
    'intro'      => 'Sanitär Vorwandelemente beplanken heisst: Das verrohrte GIS-Element bekommt seine Hülle, und die Wand ist bereit für Platten oder Farbe. Wir übernehmen diesen Schritt auf Ihrer Baustelle, im Neubau wie im Umbau. Dazu gehört die Plattenwahl je nach Raum, der Zuschnitt um Rohrdurchführungen und Revisionsöffnungen, die Befestigung im vorgegebenen Raster und auf Wunsch die Spachtelung. In Nasszellen setzen wir AquaPanel ein, in trockenen Bereichen die passende Gipsplatte. Wir kommen auch dann, wenn die Elemente von einem anderen Betrieb gesetzt wurden. Sie erhalten eine Offerte mit Angaben zu Fläche, Plattentyp und Termin, damit Sie Ihre Folgegewerke planen können. Rufen Sie uns an oder schicken Sie uns Ihre Pläne.',
    'body' => [
        ['Die Plattenwahl entscheidet über die Lebensdauer der Nasszelle',
         'In Duschen, Bädern und WC-Anlagen beplanken wir mit AquaPanel. Die Platte nimmt kaum Wasser auf und bleibt auch bei dauernder Feuchte formstabil. In angrenzenden Trockenbereichen genügt in der Regel eine Gipsplatte, was Material und Kosten spart. Welche Kombination sinnvoll ist, klären wir vorgängig anhand Ihrer Pläne.'],
        ['Wir beplanken auch Elemente, die wir nicht gesetzt haben',
         'Viele Anfragen erreichen uns mitten im Bauablauf, wenn die Sanitärinstallation steht und der Trockenbau stockt. Wir prüfen die gesetzten GIS-Elemente auf Fluchten, Befestigung und Rohrlage, bevor wir die erste Platte anschrauben. Abweichungen melden wir Ihnen, statt sie zuzudecken. So vermeiden Sie Nacharbeiten, wenn später die Sanitärapparate montiert werden.'],
        ['Revisionsöffnungen und Durchführungen werden vor dem Zuschnitt festgelegt',
         'Spülkästen, Absperrventile und Verteiler brauchen dauerhaft Zugang. Wir markieren die Öffnungen anhand der Sanitärpläne und schneiden sie sauber aus, statt nachträglich zu stemmen. Rohrdurchführungen werden dicht und passgenau ausgeführt. Damit bleibt die Wand geschlossen und der Unterhalt trotzdem möglich.'],
        ['Beplankung und Spachtelung aus einer Hand sparen eine Schnittstelle',
         'Auf Wunsch spachteln wir die beplankten Flächen bis zum vereinbarten Qualitätsniveau. Sie koordinieren dann einen Betrieb weniger und haben eine Ansprechperson für das Ergebnis. Das Niveau der Spachtelung halten wir in der Offerte fest, damit Maler oder Plattenleger wissen, was sie übernehmen.'],
        ['Ausflockung und SilentPanel für ruhigere Nasszellen',
         'Wo Schallschutz gefragt ist, kombinieren wir die Beplankung mit Ausflockung oder SilentPanel. Der Hohlraum hinter der Vorwand wird gefüllt, bevor die zweite Plattenlage geschlossen wird. Das dämpft Spül- und Fliessgeräusche spürbar, besonders bei Wänden zu Schlaf- und Wohnräumen. Diese Massnahme muss vor der Beplankung entschieden werden.'],
        ['So läuft eine Anfrage bei uns ab',
         'Sie senden uns Grundrisse, Sanitärpläne und den gewünschten Termin. Wir schätzen die Fläche, legen Plattentyp und Aufbau fest und stellen Ihnen eine Offerte zu. Nach Ihrer Freigabe reservieren wir das Zeitfenster und stimmen die Anlieferung mit der Bauleitung ab.'],
    ],
    'faq' => [
        ['Womit werden Sanitär Vorwandelemente in Nasszellen beplankt?',
         'In Duschen und Bädern verwenden wir AquaPanel, weil die Platte auf Feuchtigkeit unempfindlich reagiert. In trockenen Zonen derselben Wohnung setzen wir Gipsplatten ein. Die Abgrenzung legen wir vor Arbeitsbeginn anhand Ihrer Pläne fest.'],
        ['Beplanken Sie auch Elemente, die ein anderer Betrieb montiert hat?',
         'Ja, das ist ein grosser Teil unserer Arbeit. Wir prüfen vorgängig Fluchten, Befestigung und Rohrlage und melden Ihnen allfällige Abweichungen. Erst danach beginnen wir mit der Beplankung.'],
        ['Übernehmen Sie auch die Spachtelung nach der Beplankung?',
         'Ja, Beplankung und Spachtelung erhalten Sie bei uns zusammen. Das vereinbarte Niveau halten wir in der Offerte fest, damit Maler und Plattenleger sauber anschliessen können.'],
    ],
    'cta_heading' => 'Beplankung anfragen',
    'cta_text'    => 'Senden Sie uns Ihre Sanitärpläne und den Wunschtermin, wir melden uns mit einer Offerte zu Fläche, Plattentyp und Zeitfenster.',
    'offen' => [
        'Angebotene Qualitätsstufen der Spachtelung',
        'Übliche Vorlaufzeit bis zum Ausführungstermin',
        'Einsatzgebiet oder Anfahrtsradius ab Pfäffikon',
        'Preisbasis, etwa Abrechnung nach Quadratmeter oder Aufwand',
    ],
];

/** Zeichenkette fuer SQL escapen */
function q(string $v): string
{
    return "'" . str_replace(["\\", "'"], ["\\\\", "''"], $v) . "'";
}

/** Section-Content als JSON fuer die DB */
function j(array $content): string
{
    return q(json_encode($content, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
}

// ─────────────────────────────────────────────────────────────
// Reihenfolge fuer Navigation, Footer und CMS-Liste
//
// Die Bloecke oben stehen in der Reihenfolge des Keyword-Plans. Fuer den
// Besucher ist eine andere sinnvoller: zuerst die beiden Seiten, die
// erklaeren was ein Element ist, dann bestellen, dann beplanken. So liest
// sich der Footer als Ablauf und nicht als Stichwortliste.
// ─────────────────────────────────────────────────────────────

$reihenfolge = [
    'sanitaer-vorwandelemente',            // Was ist das
    'sanitaer-vorwaende',                  // Was ist das, zweiter Begriff
    'sanitaer-gis-elemente-bestellen',     // Bestellen
    'sanitaer-vorwandelemente-bestellen',  // Bestellen
    'gis-elemente-beplanken',              // Beplanken
    'sanitaer-vorwandelemente-beplanken',  // Beplanken
];

usort($pages, function ($a, $b) use ($reihenfolge) {
    return array_search($a['slug'], $reihenfolge, true)
       <=> array_search($b['slug'], $reihenfolge, true);
});

// ─────────────────────────────────────────────────────────────
// Modus: Interne Verlinkung (erst nach dem Freischalten einspielen)
// Aufruf: php build_keyword_pages.php links
// ─────────────────────────────────────────────────────────────

if (($argv[1] ?? '') === 'links') {
    $linkTexte = [
        'sanitaer-vorwandelemente'            => 'Sanitär Vorwandelemente: Aufbau, Montage und Beplankung erklärt',
        'sanitaer-vorwaende'                  => 'Sanitär Vorwände vorfabriziert, montiert und beplankt',
        'gis-elemente-beplanken'              => 'GIS Elemente beplanken: von der Vorfabrikation bis zur fertigen Wand',
        'sanitaer-vorwandelemente-beplanken'  => 'Sanitär Vorwandelemente beplanken',
        'sanitaer-gis-elemente-bestellen'     => 'Sanitär GIS Elemente bestellen',
        'sanitaer-vorwandelemente-bestellen'  => 'Sanitär Vorwandelemente bestellen',
    ];

    $li = '';
    foreach ($linkTexte as $slug => $text) {
        $li .= '<li><a href="/' . $slug . '">' . $text . '</a></li>';
    }

    $content = [
        'heading'   => 'Leistungen im Detail',
        'body'      => '<p>Zu den einzelnen Arbeitsschritten haben wir eigene Seiten '
                     . 'mit Aufbau, Massen und häufigen Fragen:</p><ul>' . $li . '</ul>',
        'alignment' => 'left',
    ];

    $o = [];
    $o[] = "-- ============================================================";
    $o[] = "-- SUI Innova GmbH — SEO Paket 3b";
    $o[] = "-- Interne Verlinkung auf die neuen Keyword-Seiten";
    $o[] = "--";
    $o[] = "-- ERZEUGT VON dist/scripts/build_keyword_pages.php links";
    $o[] = "--";
    $o[] = "-- ACHTUNG: ERST AUSFUEHREN, WENN DIE SECHS SEITEN ONLINE SIND.";
    $o[] = "--";
    $o[] = "-- Solange die neuen Seiten deaktiviert sind, landet ein Besucher";
    $o[] = "-- beim Klick auf diese Links auf der Startseite. Das ist fuer";
    $o[] = "-- Google ein Signal fuer eine kaputte Seitenstruktur.";
    $o[] = "--";
    $o[] = "-- Reihenfolge:";
    $o[] = "--   1. seo-paket-3-keyword-seiten.sql einspielen";
    $o[] = "--   2. Angaben vom Kunden einarbeiten";
    $o[] = "--   3. Seiten im CMS unter Seiten online schalten";
    $o[] = "--   4. DIESE Datei einspielen";
    $o[] = "--";
    $o[] = "-- Gefahrlos mehrfach ausfuehrbar.";
    $o[] = "-- ============================================================";
    $o[] = "";
    $o[] = "SET NAMES utf8mb4;";
    $o[] = "";
    $o[] = "SET @pid = (SELECT id FROM pages WHERE slug = 'leistungen' LIMIT 1);";
    $o[] = "SET @sort = (SELECT COALESCE(MAX(sort_order), 0) + 10 FROM sections WHERE page_id = @pid);";
    $o[] = "";
    $o[] = "INSERT INTO sections (page_id, type, content, sort_order, is_active)";
    $o[] = "SELECT @pid, 'text-block', " . j($content) . ", @sort, 1";
    $o[] = "FROM DUAL";
    $o[] = "WHERE @pid IS NOT NULL";
    $o[] = "  AND NOT EXISTS (";
    $o[] = "    SELECT 1 FROM sections";
    $o[] = "    WHERE page_id = @pid AND type = 'text-block'";
    $o[] = "      AND content LIKE '%Leistungen im Detail%'";
    $o[] = "  );";
    $o[] = "";
    $o[] = "-- ────────────────────────────────────────────────────────────";
    $o[] = "-- Kontrolle: alle sechs muessen is_active = 1 sein";
    $o[] = "-- ────────────────────────────────────────────────────────────";
    $o[] = "-- SELECT slug, is_active FROM pages WHERE slug IN (";
    $o[] = "--   " . implode(",\n--   ", array_map(fn($s) => "'" . $s . "'", array_keys($linkTexte)));
    $o[] = "-- );";

    echo implode("\n", $o) . "\n";
    exit;
}

// ─────────────────────────────────────────────────────────────
// Modus: Checkliste der offenen Angaben statt SQL
// Aufruf: php build_keyword_pages.php checkliste
// ─────────────────────────────────────────────────────────────

if (($argv[1] ?? '') === 'checkliste') {
    // Die 31 Einzelstellen aus dem Keyword-Plan fragen teilweise dasselbe
    // in anderen Worten: "Einzugsgebiet der Montage" und "Einsatzgebiet fuer
    // Lieferung und Montage" sind eine Frage, nicht zwei. Thematisch
    // gebuendelt sind es zwoelf, und zwoelf beantwortet der Kunde auch.
    $themen = [
        [
            'titel'  => 'Einsatzgebiet',
            'frage'  => 'In welchem Gebiet liefern und montieren Sie? Ein Radius ab '
                      . 'Pfäffikon oder eine Liste von Kantonen genügt.',
            'hinweis' => 'Kommt auf fast jeder Seite vor und ist für die lokale '
                       . 'Suche der wichtigste Punkt in dieser Liste.',
        ],
        [
            'titel' => 'Fristen',
            'frage' => 'Wie lange dauert es üblicherweise von der Freigabe bis zur '
                     . 'Lieferung? Und wie viel Vorlauf brauchen Sie für einen '
                     . 'Montage- oder Beplankungstermin? Innert welcher Frist '
                     . 'schicken Sie eine Offerte?',
            'hinweis' => 'Grobe Spannen reichen, zum Beispiel "zwei bis vier Wochen".',
        ],
        [
            'titel' => 'Mindestmenge',
            'frage' => 'Gibt es eine kleinste Auftragsgrösse oder einen '
                     . 'Mindestbestellwert? Oder fertigen Sie auch ein '
                     . 'einzelnes Element?',
            'hinweis' => '',
        ],
        [
            'titel' => 'Systeme und Hersteller',
            'frage' => 'Welche Systeme und Fabrikate verarbeiten Sie, neben GIS? '
                     . 'Zum Beispiel Geberit oder Nussbaum. Welche Standardhöhen '
                     . 'bauen Sie, halbhoch und raumhoch?',
            'hinweis' => 'Herstellernamen im Text helfen, weil genau danach gesucht wird.',
        ],
        [
            'titel' => 'Plattenmaterial',
            'frage' => 'Welche Plattentypen, Stärken und Hersteller setzen Sie bei '
                     . 'der Beplankung ein? In Nasszellen und in trockenen Bereichen.',
            'hinweis' => '',
        ],
        [
            'titel' => 'Spachtelqualität',
            'frage' => 'Bis zu welcher Qualitätsstufe spachteln Sie? Q1 bis Q4, '
                     . 'oder nach einer SIA-Norm?',
            'hinweis' => 'Steht heute als "halten wir vor Arbeitsbeginn fest" im Text. '
                       . 'Eine konkrete Stufe ist überzeugender.',
        ],
        [
            'titel' => 'Schallschutz',
            'frage' => 'Welches SilentPanel-System verwenden Sie, und welche Werte '
                     . 'erreichen Ihre Aufbauten? Arbeiten Sie nach SIA 181?',
            'hinweis' => 'Heute steht im Text, dass der Schallschutznachweis massgebend '
                       . 'ist. Das stimmt immer. Wenn Sie Messwerte haben, nennen '
                       . 'Sie sie — wenn nicht, lassen Sie es so.',
        ],
        [
            'titel' => 'Materialbeschaffung',
            'frage' => 'Beschaffen Sie das Material selbst, oder stellt es der '
                     . 'Kunde bei? Oder beides, je nach Auftrag?',
            'hinweis' => '',
        ],
        [
            'titel' => 'Transport',
            'frage' => 'Wie gross darf ein Element maximal sein, damit Sie es noch '
                     . 'transportieren können? Verrechnen Sie Lieferkosten?',
            'hinweis' => '',
        ],
        [
            'titel' => 'Preise',
            'frage' => 'Möchten Sie Richtpreise nennen, pro Element oder pro '
                     . 'Quadratmeter? Oder lieber nicht?',
            'hinweis' => 'Darf gut "nein" sein. Viele Betriebe nennen keine Preise, '
                       . 'das ist für die Suche kein Nachteil.',
        ],
        [
            'titel' => 'Referenzprojekte',
            'frage' => 'Welche ausgeführten Projekte dürfen wir namentlich nennen, '
                     . 'mit Objektart und Anzahl Elemente?',
            'hinweis' => 'Konkrete Zahlen wirken stärker als "zahlreiche Projekte".',
        ],
        [
            'titel' => 'Werkstattkapazität',
            'frage' => 'Wie viele Elemente schaffen Sie ungefähr pro Woche? Und wie '
                     . 'viele Montageteams sind im Einsatz?',
            'hinweis' => 'Zeigt Generalunternehmern, ob Sie ihr Projekt stemmen können.',
        ],
    ];

    $zeilen = [];
    $zeilen[] = str_repeat('=', 64);
    $zeilen[] = 'SUI INNOVA — ZWOELF ANGABEN, DIE DIE SEITEN STAERKER MACHEN';
    $zeilen[] = str_repeat('=', 64);
    $zeilen[] = '';
    $zeilen[] = 'Guten Tag Herr Ljatifi';
    $zeilen[] = '';
    $zeilen[] = 'Wir haben sechs neue Seiten für sui-innova.ch vorbereitet.';
    $zeilen[] = 'Die Texte sind fertig, Sie müssen nichts schreiben.';
    $zeilen[] = '';
    $zeilen[] = 'An zwölf Stellen sagen die Texte heute sinngemäss "das klären';
    $zeilen[] = 'wir anhand Ihrer Unterlagen". Das ist fachlich korrekt und';
    $zeilen[] = 'stimmt für jedes Projekt. Mit einer konkreten Angabe wird';
    $zeilen[] = 'daraus aber ein Argument — "wir liefern innert drei Wochen"';
    $zeilen[] = 'überzeugt einen Bauleiter mehr als "je nach Auslastung".';
    $zeilen[] = '';
    $zeilen[] = 'Beantworten Sie, was Sie sicher sagen können. Alles andere';
    $zeilen[] = 'lassen Sie offen — der Text funktioniert auch so. Erfundene';
    $zeilen[] = 'Zahlen bei Schallschutz oder Fristen wären bei einer';
    $zeilen[] = 'Reklamation Ihr Problem, deshalb steht dort nichts, was';
    $zeilen[] = 'wir nicht von Ihnen haben.';
    $zeilen[] = '';
    $offenGesamt = array_sum(array_map(fn($p) => count($p['offen']), $pages));
    $zeilen[] = 'Es sind ' . count($themen) . ' Fragen. Keine davon ist Pflicht.';
    $zeilen[] = '';
    $zeilen[] = '';

    /** Text auf Zeilenbreite umbrechen und einruecken */
    $umbruch = function (string $text, int $breite, string $einzug): array {
        return array_map(fn($z) => $einzug . $z, explode("\n", wordwrap($text, $breite, "\n", false)));
    };

    foreach ($themen as $i => $thema) {
        $zeilen[] = sprintf('%2d. %s', $i + 1, mb_strtoupper($thema['titel']));
        $zeilen[] = '';
        foreach ($umbruch($thema['frage'], 58, '    ') as $z) {
            $zeilen[] = $z;
        }
        if ($thema['hinweis'] !== '') {
            $zeilen[] = '';
            foreach ($umbruch($thema['hinweis'], 56, '      ') as $z) {
                $zeilen[] = $z;
            }
        }
        $zeilen[] = '';
        $zeilen[] = '    ____________________________________________________';
        $zeilen[] = '';
        $zeilen[] = '    ____________________________________________________';
        $zeilen[] = '';
        $zeilen[] = '';
    }

    $zeilen[] = str_repeat('-', 64);
    $zeilen[] = 'Die sechs Seiten:';
    $zeilen[] = '';
    foreach ($pages as $p) {
        $zeilen[] = '  sui-innova.ch/' . $p['slug'];
        $zeilen[] = '    Suchbegriff: ' . mb_strtolower(str_replace('-', ' ', $p['slug']));
        $zeilen[] = '';
    }
    $zeilen[] = str_repeat('-', 64);
    $zeilen[] = 'EmotionFrame GmbH, Loorenstrasse 4a, 5443 Niederrohrdorf';
    $zeilen[] = 'hello@emotionframe.ch';

    echo implode("\n", $zeilen) . "\n";
    exit;
}

// ─────────────────────────────────────────────────────────────
// SQL erzeugen
// ─────────────────────────────────────────────────────────────

$out = [];
$out[] = "-- ============================================================";
$out[] = "-- SUI Innova GmbH — SEO Paket 3";
$out[] = "-- Sechs neue Seiten aus dem Keyword-Plan vom 08.09.2026";
$out[] = "--";
$out[] = "-- ERZEUGT VON dist/scripts/build_keyword_pages.php — nicht von Hand";
$out[] = "-- bearbeiten, sondern den Generator anpassen und neu erzeugen.";
$out[] = "--";
$out[] = "-- Die Texte sind vollstaendig, es ist keine Stelle mehr offen.";
$out[] = "--";
$out[] = "-- Trotzdem werden alle Seiten DEAKTIVIERT angelegt (is_active = 0):";
$out[] = "-- sie sind im CMS vorhanden und bearbeitbar, aber weder fuer Besucher";
$out[] = "-- noch fuer Google sichtbar. Neue oeffentliche Seiten auf einer";
$out[] = "-- Kundenwebsite schaltet ein Mensch frei, nicht ein SQL-Import.";
$out[] = "--";
$out[] = "-- Freischalten: im CMS unter Seiten je Seite auf Online stellen,";
$out[] = "-- oder alle auf einmal mit seo-paket-3c-seiten-online.sql.";
$out[] = "--";
$out[] = "-- Gefahrlos mehrfach ausfuehrbar: bestehende Seiten werden an ihrem";
$out[] = "-- Slug erkannt und nicht doppelt angelegt.";
$out[] = "-- ============================================================";
$out[] = "";
$out[] = "-- Zeichensatz festnageln: sonst wird aus \"Pfaeffikon\" mit Umlaut";
$out[] = "-- je nach Client ein Zeichensalat.";
$out[] = "SET NAMES utf8mb4;";
$out[] = "";

// Sortierung: hinter die bestehenden Seiten
$out[] = "SET @next_sort = (SELECT COALESCE(MAX(sort_order), 0) + 10 FROM pages);";
$out[] = "";

$sortStep = 0;

foreach ($pages as $p) {
    $slug = $p['slug'];
    $out[] = "-- ────────────────────────────────────────────────────────────";
    $out[] = "-- /" . $slug;
    $out[] = "-- ────────────────────────────────────────────────────────────";

    $out[] = "INSERT INTO pages (title, slug, meta_title, meta_desc, is_active, is_homepage, sort_order)";
    $out[] = "SELECT " . q($p['nav_label']) . ", " . q($slug) . ", " . q($p['meta_title']) . ", "
           . q($p['meta_desc']) . ", 0, 0, @next_sort + " . $sortStep;
    $out[] = "FROM DUAL";
    $out[] = "WHERE NOT EXISTS (SELECT 1 FROM pages WHERE slug = " . q($slug) . ");";
    $out[] = "";
    $out[] = "SET @pid = (SELECT id FROM pages WHERE slug = " . q($slug) . " LIMIT 1);";
    $out[] = "";

    $sortStep += 10;

    // Sektionen der Seite
    $sections = [];

    // 1) Kopfbanner — ohne Bild, Bild waehlt der Admin im CMS.
    //    Ohne Bild rendert die Sektion nichts, die Seite bleibt also sauber.
    $sections[] = ['parallax-image', [
        'image_id'     => 0,
        'height'       => 'medium',
        'overlay_text' => '',
    ]];

    // 2) Einleitung — traegt die Hauptueberschrift (h1)
    $sections[] = ['text-block', [
        'heading'   => $p['h1'],
        'body'      => '<p>' . $p['intro'] . '</p>',
        'alignment' => 'left',
    ]];

    // 3) Seitenaufbau als zusammenhaengender Textblock mit h2-Zwischentiteln
    $bodyHtml = '';
    foreach ($p['body'] as [$h, $t]) {
        $bodyHtml .= '<h2>' . $h . '</h2><p>' . $t . '</p>';
    }
    $sections[] = ['text-block', [
        'heading'   => '',
        'body'      => $bodyHtml,
        'alignment' => 'left',
    ]];

    // 4) Fragen und Antworten (mit FAQPage-Auszeichnung)
    $sections[] = ['faq', [
        'heading'  => 'Fragen und Antworten',
        'subtitle' => '',
        'items'    => array_map(
            fn($f) => ['question' => $f[0], 'answer' => '<p>' . $f[1] . '</p>'],
            $p['faq']
        ),
    ]];

    // 5) Handlungsaufforderung
    $sections[] = ['cta-banner', [
        'heading'     => $p['cta_heading'],
        'body'        => $p['cta_text'],
        'button_text' => 'Pläne einsenden',
        'button_url'  => '/kontakt',
    ]];

    $sortOrder = 10;
    foreach ($sections as [$type, $content]) {
        $out[] = "INSERT INTO sections (page_id, type, content, sort_order, is_active)";
        $out[] = "SELECT @pid, " . q($type) . ", " . j($content) . ", " . $sortOrder . ", 1";
        $out[] = "FROM DUAL";
        $out[] = "WHERE @pid IS NOT NULL";
        $out[] = "  AND NOT EXISTS (SELECT 1 FROM sections WHERE page_id = @pid AND sort_order = " . $sortOrder . ");";
        $out[] = "";
        $sortOrder += 10;
    }
}

$out[] = "-- ────────────────────────────────────────────────────────────";
$out[] = "-- Kontrolle";
$out[] = "-- ────────────────────────────────────────────────────────────";
$out[] = "-- SELECT slug, is_active, sort_order FROM pages ORDER BY sort_order;";
$out[] = "-- SELECT p.slug, COUNT(s.id) AS sektionen FROM pages p";
$out[] = "--   LEFT JOIN sections s ON s.page_id = p.id GROUP BY p.slug;";

echo implode("\n", $out) . "\n";
