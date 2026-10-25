# SUI Innova GmbH

Website sui-innova.ch. PHP ohne Framework, Inhalte als JSON in
`sections.content`. Hostpoint, kein SSH, keine Pipeline: Auslieferung
ist ein ZIP, das der Kunde per FTP hochlädt, plus SQL für phpMyAdmin.

**Lokal und live teilen dieselbe Datenbank** (`bifitudo_suinnova`). Es
gibt keine Testumgebung. Jede SQL wirkt sofort auf der Live-Website.
Deshalb: jede Migration mehrfach ausführbar schreiben und vorher gegen
eine lokale MariaDB mit Fixture prüfen.

`SET NAMES utf8mb4;` als erste Anweisung in jeder SQL-Datei, sonst
werden alle Umlaute zu Zeichensalat.

---

## Wer der Kunde ist, und wer nicht

Das ist der wichtigste Abschnitt dieser Datei. Er verhindert einen
Fehler, der am 15.10.2026 schon einmal passiert ist.

| | |
| --- | --- |
| **Geschäft** | Vorfabrikation von GIS-Elementen: in der Werkstatt in Pfäffikon SZ aufgebaut, verrohrt, auf Wunsch beplankt und gespachtelt, vom eigenen Team montiert |
| **Kunden** | Generalunternehmen, Totalunternehmen, Bauleiter, Architekten, Sanitärunternehmen |
| **Ausdrücklich NICHT** | Private, Badumbau, Sanitärservice |
| **Hauptkeyword Startseite** | GIS Elemente Vorfabrikation (Kundenentscheid, fliegt nicht aus dem Titel) |
| **Einsatzgebiet** | ganze Deutschschweiz, nicht "ganze Schweiz" |

Quelle: Geschäftsprofil im Export des SEO Kompass vom 15.10.2026, vom
Kunden selbst ausgefüllt. Es hat Vorrang vor jedem To-do und vor dem,
was in älteren Texten steht.

### Begriffe, die passend klingen und es nicht sind

Finger weg, auch wenn ein Werkzeug sie empfiehlt:

    sanitär pfäffikon        Position 1,  0 Klicks
    badumbau pfäffikon       Position 1,  0 Klicks
    sanitär horgen           Position 1,  0 Klicks
    sanitär pfäffikon sz     Position 8,  0 Klicks
    trockenbau pfäffikon     Position 47, 0 Klicks
    reinigung pfäffikon sz   Position 48, 0 Klicks

Über alle zusammen: 35 Impressionen, null Klicks. Position 1 ohne Klick
heisst, dass die Suchabsicht nicht passt, nicht dass der Titel schlecht
ist.

"Sanitär" allein ist richtig und wertvoll, die besten Begriffe der
Website heissen "sanitär vorwandelemente" und "sanitär gis elemente
bestellen". Es ist **"Sanitär plus Ort allein"**, das die falschen
Leute anzieht.

---

## Vor jeder Umsetzung aus einem SEO-Werkzeug

Vier Tests. Fällt ein Vorschlag durch einen davon, wird er nicht
umgesetzt, sondern dem Kunden mit Zahlen vorgelegt.

1. **Absicht** Ist der Mensch, der so sucht, ein möglicher Auftraggeber?
   Siehe Tabelle oben.
2. **Tausch** Was verdrängt die Änderung? Ein Begriff fliegt nur aus dem
   Titel, wenn der neue mindestens gleich viele Impressionen bringt.
3. **Datenmenge** Unter 30 Impressionen ist Rauschen, über 100 belastbar.
4. **Zeit** Kennzahlen über "letzte 28 Tage" können eine Änderung von
   heute nicht zeigen. Ein To-do, das stehen bleibt, ist oft nur zu früh.

Ausführlich samt Fallbeispiel:
https://claude.ai/code/artifact/4dcfeaea-5666-45aa-9e17-83951a501762

---

## Schreibregeln für sichtbaren Text

- Hochdeutsch mit Schweizer Schreibweise, ss statt ß
- **Keine Gedankenstriche**, weder – noch —, auch nicht in Vorgabewerten
  im PHP-Code
- Keine Floskeln, keine Adjektive statt Argumente
- Keine erfundenen Zahlen: keine Lieferfristen, Mindestmengen,
  Spachtelstufen, Schallschutzwerte oder Preise ohne Angabe des Kunden.
  Stattdessen umformulieren auf das, was immer stimmt
  ("halten wir in der Offerte fest")
- Der Kunde schreibt keine Texte selbst

## Stolperstellen

- `pages` hat `meta_title` und `meta_desc`, nicht `meta_description`
- Der Hero-Titel darf nicht mitten im Wort umbrechen. Nach jeder Änderung
  bei 375, 414 und 1920 Pixel nachmessen
- Die Seite ist von der Arbeitsumgebung aus **nicht erreichbar**, der
  Netzwerkfilter blockt sui-innova.ch. Nie behaupten, etwas live geprüft
  zu haben
- Sektionen ohne vorhandene Vorlage rendern nichts. Vorlage und SQL immer
  zusammen ausliefern, Dateien zuerst
- Interne Links gehören in eine `link-list`-Sektion, nie als fest
  geschriebenes HTML. Die Vorlage prüft, ob die Zielseite online ist

## Generatoren

    dist/scripts/build_plan_0918.php            Keyword-Seiten, SQL
    dist/scripts/build_plan_0918.php pruefen    Selbstkontrolle
    dist/scripts/build_plan_0918.php seite <slug>  SQL nur fuer eine Seite
    dist/scripts/build_plan_0918.php daten      Daten für die Vorschau
    dist/scripts/build_preview.php              Vorschau als HTML

SQL nie von Hand ändern, immer den Generator anpassen und neu erzeugen.
