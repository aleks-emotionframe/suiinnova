# Stand: Umsetzung Keyword-Plan vom 18.09.2026

Arbeitsstand beim Pausieren. Nichts davon ist eingespielt, die Website
ist unveraendert. Alles Bisherige (Abschlusspaket) bleibt gueltig.

## Was schon feststeht

Der Plan enthaelt 12 Suchbegriffe. Sie verteilen sich auf 7 bestehende
Seiten und 2 neue Seiten:

| Suchbegriff | Seite | Position heute |
|---|---|---|
| sanitaer vorfabrikation | /leistungen | nicht in Top 20 |
| gis elemente vorfabrizieren | /sanitaer-gis-elemente-bestellen | nicht in Top 20 |
| gis elemente bestellen | /sanitaer-gis-elemente-bestellen | 11 |
| sanitaer gis elemente bestellen | /sanitaer-gis-elemente-bestellen | **2**, mit KI-Zitat |
| gis elemente montieren | /gis-elemente-beplanken | nicht in Top 20 |
| gis elemente beplanken | /gis-elemente-beplanken | nicht in Top 20 |
| sanitaer vorwandelemente | /sanitaer-vorwandelemente | 9 |
| sanitaer vorwandelemente bestellen | /sanitaer-vorwandelemente-bestellen | nicht in Top 20 |
| sanitaer vorwaende | /sanitaer-vorwaende | nicht in Top 20 |
| sanitaer vorwandelemente beplanken | /sanitaer-vorwandelemente-beplanken | **1**, mit KI-Zitat |
| sanitaerelemente vorfabrizieren | NEU /sanitaerelemente-vorfabrizieren | nicht in Top 20 |
| sanitaerelemente montieren | NEU /sanitaerelemente-montieren | nicht in Top 20 |

## Zwei Widersprueche im Plan, Entscheid getroffen

**/sanitaer-gis-elemente-bestellen** bekommt im Plan drei verschiedene
Seitentitel und drei verschiedene Hauptueberschriften (bei den Begriffen
"gis elemente vorfabrizieren", "gis elemente bestellen" und "sanitaer gis
elemente bestellen"). Eine Seite kann nur einen Titel tragen.

Entscheid: Titel und H1 aus dem Abschnitt "sanitaer gis elemente
bestellen" (Seite 25 im Plan). Diese Seite steht damit heute auf Position
2 und wird in der KI-Uebersicht zitiert. Die Inhalte der beiden anderen
Abschnitte kommen als eigene Zwischentitel auf dieselbe Seite, damit die
Begriffe trotzdem im Text stehen.

Drei fast gleiche Seiten waeren die Alternative gewesen. Die Texte im Plan
ueberschneiden sich zu rund siebzig Prozent, drei solche Seiten wuerden
gegeneinander ranken und die Position 2 gefaehrden.

**/gis-elemente-beplanken** bekommt im Plan zwei Titel ("GIS Elemente
montieren" und "GIS Elemente beplanken in Pfaeffikon SZ").

Entscheid: Titel und H1 aus "gis elemente beplanken", passend zur Adresse
der Seite. Die Montage-Abschnitte kommen als Zwischentitel dazu.

## Ankertexte der internen Verlinkung

Der Plan nennt an mehreren Stellen einen Linktext, der die Quellseite
beschreibt statt das Ziel. Beispiel: von /gis-elemente-beplanken soll auf
/leistungen verlinkt werden, mit dem Linktext "GIS Elemente beplanken
lassen". Der Linktext ist ein Rankingsignal fuer die Zielseite, hier waere
er wirkungslos.

Vorgehen: Quelle und Ziel jedes Links genau wie im Plan, Linktext aus dem
Plan uebernehmen, wo er das Ziel benennt. Sonst der Suchbegriff der
Zielseite. Jede Abweichung kommt in die Schlusscheckliste.

## Platzhalter

Der Plan setzt rund 25 Mal `[ANGABE FEHLT: ...]` in den Text. Wie beim
letzten Mal werden diese Saetze umformuliert statt mit erfundenen Zahlen
gefuellt. Ausnahme: das Einsatzgebiet ist bekannt und wird als "in der
ganzen Deutschschweiz" ausgeschrieben.

## Noch zu tun

1. `dist/scripts/build_plan_0918.php` schreiben, mit allen Texten
2. Feld `alt` fuer die Sektion `parallax-image`, damit je Seite der im Plan
   vorgegebene Bild-Alt-Text steht
3. `getFooterServicePages()` in `core/helpers.php` um die zwei neuen Slugs
   ergaenzen
4. SQL lokal gegen MariaDB pruefen, zweimal laufen lassen, Umlaute und
   Sektionszahl kontrollieren
5. Paket schnueren, dazu die Schlusscheckliste mit Begruendungen

## Hinweise fuer die Fortsetzung

- Die Datenbank ist von hier aus nicht erreichbar, der Proxy blockt
  Hostpoint. Alles SQL wird blind erzeugt und muss mehrfach ausfuehrbar
  sein.
- `SET NAMES utf8mb4;` als erste Anweisung in jeder SQL-Datei, sonst
  Zeichensalat bei den Umlauten.
- Keine Gedankenstriche im sichtbaren Text.
- Der Plan liegt als Text unter `dist/kunde/` nicht vor, er kam als PDF
  ueber den Chat. Bei Bedarf neu einlesen.
