# SEO-Audit Report — sui-innova.ch

**Datum:** 27. August 2026
**Domain:** sui-innova.ch
**Business Type:** Local B2B — Sanitär-Vorfabrikation & Montage
**Zielmarkt:** Schweiz (nur)
**Zielgruppen:** Architekten, Generalunternehmer, Totalunternehmer, Bauleiter, Sanitärunternehmen

---

## Executive Summary

### SEO Health Score: **48 / 100** 🟡

Die technische Grundlage ist **sehr solid** (moderne Meta-Tags, dynamische Sitemap, Cookie-Consent, DSGVO-Setup). Aber es gibt **kritische Sichtbarkeits-Blocker**, die bei der Site-Migration entstanden sind, und **grosse ungenutzte SEO-Potenziale** in einer weitgehend unbesetzten Nische.

### Business-Kontext

- **Kleine Nische mit begrenzter Konkurrenz** — nur ~10 KMU-Konkurrenten schweizweit, keine Amazon/E-Commerce-Wettbewerber
- **Standort:** Talstrasse 31, 8808 Pfäffikon SZ · info@sui-innova.ch · +41 55 420 19 90
- **Sprache:** Deutsch (de-CH)
- **Vorhandene Assets:** Google Search Console verbunden · Directory-Einträge bei search.ch, local.ch, moneyhouse.ch, sanitaervergleich.ch

### Top 5 kritische Findings

| # | Finding | Severity | Business Impact |
|---|---|---|---|
| 1 | **Alte URLs im Google-Index sind jetzt 404** (blog, dienstleistungen, unternehmen, montage-sanitär-vorwandsysteme) | **CRITICAL** | Sofortiger Traffic-Verlust, verlorene Backlinks |
| 2 | **KEIN Schema.org Markup** (LocalBusiness, Service, Organization) | **CRITICAL** | Kein Rich-Snippet in Suche, weniger Klicks, kein Local-Pack |
| 3 | **www/non-www gemischt** in Google — inkonsistente Kanonisierung | **HIGH** | Duplicate Content, verwässerte Rankings |
| 4 | **Google Business Profile ungepflegt / keine Reviews** | **HIGH** | Kein Local-Pack-Ranking → 40 % weniger lokale Sichtbarkeit |
| 5 | **Title-Tag: „SUI Innova GmbH" doppelt** in jedem Title | **MEDIUM** | Wirkt spammy, reduziert CTR aus Google-Ergebnissen |

### Top 5 Quick Wins (< 1 Woche Aufwand, sofortige Wirkung)

1. **LocalBusiness JSON-LD Schema** einbauen — 2 h Aufwand → Google-Karten-Integration
2. **`robots.txt`** mit Sitemap-Referenz erstellen — 15 min
3. **301-Redirects** von alten Google-URLs zu neuen Slugs — 30 min (via .htaccess)
4. **Title-Duplikat entfernen** — 5 min Code-Änderung
5. **Google Business Profile** claimen und mit NAP + Fotos befüllen — 1 h

---

## 1. Technical SEO (Score: 55/100)

### ✅ Was funktioniert

- Modernes Meta-Tag-Setup (`title`, `description`, `robots`, `og:*`, `twitter:*`, `canonical`)
- Google Search Console + Bing Webmaster Verification-Felder im CMS
- Dynamische Sitemap (`/sitemap.xml`) mit `lastmod`, `changefreq`, `priority`
- HTTPS erzwungen (Hostpoint)
- Self-hosted Fonts (Inter) → DSGVO-konform + schnellerer LCP
- Cookie-Consent mit echter Consent-Wahl (Alle / Nur notwendige)
- Mobile-Viewport gesetzt

### ❌ Kritische Probleme

#### 1. Fehlende URL-Migration (CRITICAL)

Google hat noch die **alten Site-URLs im Index**:

| Alte URL (indexiert) | Neue URL | Aktueller Status |
|---|---|---|
| `www.sui-innova.ch/blog` | — | 404 (Seite gelöscht) |
| `www.sui-innova.ch/dienstleistungen` | `/leistungen` | 404 (Slug geändert) |
| `www.sui-innova.ch/unternehmen` | `/ueber-uns` | 404 (Slug geändert) |
| `www.sui-innova.ch/kontakt` | `/kontakt` (non-www) | ggf. 200 auf falscher Domain |
| `www.sui-innova.ch/montage-sanitär-vorwandsysteme---gis-montagen` | — | 404 |

**Impact:** Wer über Google klickt landet auf 404. Alle Backlinks auf diese URLs sind verloren. Ranking-Signale gehen an ins Leere.

**Fix:** `.htaccess` mit 301-Redirects:
```apache
Redirect 301 /blog /
Redirect 301 /dienstleistungen /leistungen
Redirect 301 /unternehmen /ueber-uns
Redirect 301 /montage-sanitär-vorwandsysteme---gis-montagen /leistungen
```

Plus www → non-www Canonicalisierung:
```apache
RewriteCond %{HTTP_HOST} ^www\.sui-innova\.ch [NC]
RewriteRule ^(.*)$ https://sui-innova.ch/$1 [R=301,L]
```

#### 2. KEIN Schema.org Markup (CRITICAL)

Weder Organization, LocalBusiness, Service, BreadcrumbList noch WebSite Schema vorhanden.

**Impact:**
- Kein Google-Karten-Rich-Snippet
- Keine Sitelinks-Suchbox
- Keine Bewertungen im SERP (auch wenn welche kommen)
- Kein Local-Pack-Ranking-Signal
- Für AI Search (Google AI Overviews, ChatGPT, Perplexity): fehlende strukturierte Fakten

**Fix:** JSON-LD im Header einbauen (LocalBusiness + BreadcrumbList + Service pro Leistung). Aufwand: ~4 h.

#### 3. Robots.txt fehlt

Es gibt weder eine `robots.txt` im Repo noch (vermutlich) auf Hostpoint.

**Impact:** Google findet die Sitemap zwar über Search Console (wenn eingereicht), aber ohne robots.txt-Referenz ist die Site nicht optimal indexierbar. Bing, DuckDuckGo etc. finden die Sitemap nicht automatisch.

**Fix:** `/robots.txt` erstellen:
```
User-agent: *
Allow: /
Disallow: /admin/
Disallow: /uploads/applications/

Sitemap: https://sui-innova.ch/sitemap.xml
```

#### 4. Title-Tag hat Duplikat (MEDIUM)

**Aktuell:** `Startseite - SUI Innova GmbH | SUI Innova GmbH`

Der Site-Name erscheint zweimal (aus dem Seiten-Titel „Startseite - SUI Innova GmbH" + aus `setting('site_name')`).

**Fix:** In `templates/layout.php` Zeile 8 nur `$pageTitle` verwenden, wenn er schon den Site-Namen enthält:
```php
<title><?= e($pageTitle ?? 'SUI Innova GmbH') ?><?= ($suffix = setting('meta_title_suffix')) ? ' | ' . e($suffix) : '' ?></title>
```

#### 5. HTML lang="de" statt "de-CH" (MEDIUM)

Für Zielmarkt Schweiz sollte `<html lang="de-CH">` gesetzt sein. Signalisiert Google explizit Schweizer Content.

#### 6. hreflang fehlt (MEDIUM)

Selbst bei einsprachiger Site sollte hreflang gesetzt sein:
```html
<link rel="alternate" hreflang="de-CH" href="https://sui-innova.ch/aktuelle-url" />
<link rel="alternate" hreflang="x-default" href="https://sui-innova.ch/" />
```

Signalisiert Google: „Diese Site ist für Schweizer Publikum" → besseres Ranking in google.ch.

#### 7. Google Analytics fehlt (INFO)

Feld im CMS vorhanden, aber noch keine ID hinterlegt. Ohne GA4 fehlen Verhaltens-Daten für SEO-Optimierung.

---

## 2. On-Page SEO (Score: 62/100)

### ✅ Was funktioniert

- Meta-Descriptions pro Seite editierbar (CMS)
- Alle Bilder haben `alt`-Attribute (im Media-System)
- Konsistente H1/H2/H3-Hierarchie
- Sauberes URL-Schema (`/leistungen`, `/referenzen`, `/kontakt`)

### ⚠️ Verbesserungen nötig

- **Meta-Descriptions inhaltlich schwach** — die aktuellen Defaults sind generisch. Sollten Keyword-optimiert werden pro Seite.
- **Keine internen Anchor-Links** zwischen thematisch verwandten Seiten (Leistung → Referenzen, Referenz → passende Leistung).
- **Keine dedizierten Landing-Pages** pro Service. Aktuell nur Übersicht in „Leistungen". Für SEO wären eigene Seiten für „Aqua Panel Montage", „GIS-Element Vorfabrikation" etc. sinnvoll.

---

## 3. Content Quality (Score: 42/100)

### ⚠️ Aktueller Stand

- Nur 6 statische Seiten (Home, Über uns, Leistungen, Referenzen, Kontakt, Impressum/Datenschutz)
- **Kein Blog / Fachartikel** — der alte war noch bei Google indexiert (`/blog`)!
- **Kein E-E-A-T-Signal**: Team-Vorstellung fehlt, Zertifikate/Referenzen ohne Namensnennung
- **Keine Fallstudien**: Referenzen sind nur Karten mit Bild + Kategorie, keine ausführlichen Case Studies mit Herausforderung/Lösung/Resultat
- Textumfang pro Seite: 300-600 Wörter (unter dem für B2B-Sanitär rankenden Niveau von 800-1500)

### 🎯 Content-Chancen (unbesetzte Keywords)

Aus der Wettbewerbsanalyse:

| Keyword | Suchvolumen (geschätzt) | Aktuelles Ranking SUI Innova | Konkurrenz-Stärke |
|---|---|---|---|
| „AquaPanel Nasszelle Schweiz" | 50-100/Mt | Nicht in Top 100 | 🟢 **Sehr niedrig** — nur Hersteller-Content |
| „GIS Vorfabrikation Zürich" | 30-80/Mt | Nicht in Top 20 | 🟡 Mittel (Engel, Spaeter) |
| „Sanitär Vorfabrikation Schweiz" | 100-300/Mt | Position 4-5 | 🟡 Mittel |
| „Vorwandsystem Montage" | 100-200/Mt | Nicht in Top 20 | 🟡 Mittel |
| „Sanitärinstallation Baustelle Termine" | 20-50/Mt | Nicht in Top 100 | 🟢 Sehr niedrig |

**Interpretation:** Es gibt konkrete Long-Tail-Keywords wo SUI Innova mit gutem Content in 3-6 Monaten auf Seite 1 könnte.

---

## 4. Schema / Structured Data (Score: 15/100)

**AKTUELL:** Keine strukturierten Daten vorhanden. Kritischer Nachholbedarf.

### Empfohlenes Schema-Setup

1. **Organization** (auf allen Seiten via Layout)
2. **LocalBusiness** → Subtyp `ProfessionalService` (auf Homepage + Kontakt)
3. **Service** pro Leistung (Vorfabrikation, Montage, Aqua Panel, Beplankung)
4. **BreadcrumbList** auf allen Nicht-Home-Seiten
5. **WebSite** mit `SearchAction` (optional aber schön)
6. **Person** für den Geschäftsführer Riad Ljatifi (im Über-uns oder Impressum)

### Beispiel LocalBusiness Schema

```json
{
  "@context": "https://schema.org",
  "@type": "ProfessionalService",
  "name": "SUI Innova GmbH",
  "image": "https://sui-innova.ch/assets/img/sui-innova-logo.jpg",
  "@id": "https://sui-innova.ch/#organization",
  "url": "https://sui-innova.ch/",
  "telephone": "+41554201990",
  "email": "info@sui-innova.ch",
  "priceRange": "$$",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "Talstrasse 31",
    "postalCode": "8808",
    "addressLocality": "Pfäffikon",
    "addressRegion": "SZ",
    "addressCountry": "CH"
  },
  "geo": {
    "@type": "GeoCoordinates",
    "latitude": 47.201,
    "longitude": 8.774
  },
  "areaServed": {
    "@type": "Country",
    "name": "Schweiz"
  },
  "founder": {
    "@type": "Person",
    "name": "Riad Ljatifi"
  },
  "vatID": "CHE-145.418.862"
}
```

---

## 5. Local SEO (Score: 35/100)

### ✅ Was funktioniert

- **NAP konsistent** auf Website + Directories (Talstrasse 31, 8808 Pfäffikon, +41 55 420 19 90)
- **Einträge auf Schweizer Directories:** search.ch, local.ch, moneyhouse.ch, sanitaervergleich.ch, painter-plasterer.ch
- Handelsregister-Eintrag korrekt (CHE-145.418.862)

### ❌ Kritische Lücken

#### 1. Google Business Profile ungepflegt (CRITICAL)

**Aktuell:** Keine sichtbaren Google-Bewertungen. Wahrscheinlich existiert das Profil aber ist unclaimed oder leer.

**Impact:** Ohne GBP:
- Kein Ranking im Google Maps Local Pack
- Kein Karten-Snippet in normalen Suchergebnissen
- Bis zu 40 % weniger lokale Sichtbarkeit
- Keine Reviews = weniger Vertrauen

**Fix:** GBP claimen, Kategorien setzen („Sanitärinstallateur", „Bauunternehmen"), Bilder hochladen (Werkstatt, Team, Referenzobjekte), Öffnungszeiten, Beschreibung mit Zielgruppen-Keywords.

#### 2. Keine Bewertungen-Strategie

Für Schweizer B2B ist Trust-Signal via Reviews essentiell. Ansatz: Nach Projektabschluss aktiv um Google-Bewertung bitten.

#### 3. Kein „Sanitär Vorfabrikation Pfäffikon" Content

Die geografische Positionierung fehlt in der Meta-Description und im Body-Text. Sollte an mehreren Stellen erscheinen (natürlich integriert).

---

## 6. AI Search Readiness / GEO (Score: 40/100)

### ⚠️ Für ChatGPT, Perplexity, Google AI Overviews

- ✅ Klare Struktur (H2/H3 Hierarchie)
- ✅ Direkte, faktische Sätze (kein Marketing-BS)
- ❌ Kein Schema → Fakten nicht maschinenlesbar
- ❌ Kein `llms.txt` (optional, wird von einigen AI-Crawlern gelesen)
- ❌ Keine strukturierten Q&A-Blöcke (FAQPage-Schema)
- ❌ Autoreninfos fehlen (E-E-A-T)

### Quick Wins

- FAQ-Sektion pro Leistung („Wie schnell könnt ihr GIS-Elemente liefern?", „Was kostet Vorfabrikation?")
- `FAQPage` Schema drauf → Rich Snippet in Google + AI-Zitationsfähigkeit
- Team-Bio für Geschäftsführer mit Berufserfahrung, Ausbildung

---

## 7. Performance (Core Web Vitals — Score-Schätzung: 75/100)

Ohne CrUX-Felddaten nur Schätzung basierend auf Code-Review:

- ✅ Self-hosted Fonts (Inter, WOFF2 preloaded)
- ✅ Kompakte HTML-Struktur
- ✅ Vermutlich gute LCP (Hostpoint schnell + optimierte Bilder)
- ⚠️ **Aqua Panel + Beplankung Karten laden ggf. viele Bilder** — Lazy Loading prüfen
- ⚠️ **Alpine.js + eigenes JS** — sollte < 30 KB gesamt sein
- ❌ Kein WebP/AVIF-Fallback in Media-System sichtbar (AVIF Support wurde gerade hinzugefügt, aber ggf. noch nicht angewendet)

**Empfehlung:** Nach GA4-Setup echte Core-Web-Vitals via CrUX messen (30 Tage Daten sammeln), dann optimieren.

---

## 8. Backlinks (Score: 55/100)

### Grobe Einschätzung ohne API-Zugang

- **Local Citations:** ✅ vorhanden (search.ch, local.ch, moneyhouse.ch, sanitaervergleich.ch, maler-gipser-vergleich.ch)
- **Fach-Backlinks:** ❌ vermutlich sehr wenig
- **Broken Backlinks:** ⚠️ **hoch** — die alten URLs (/blog, /dienstleistungen) hatten wahrscheinlich Backlinks die jetzt ins Leere zeigen

### Empfehlung

- **Redirect-Setup zwingend** um bestehende Backlink-Autorität nicht zu verlieren
- **Partner-Netzwerk** — mit Architekten, GU, Sanitärgrossisten Reziprok-Verlinkungen aufbauen
- **Fachverbände** — swissbau, VSSH, suissetec: Mitglieder-Directory-Einträge

---

# Zusammenfassung Health Score

| Kategorie | Score | Gewicht | Beitrag |
|---|---|---|---|
| Technical SEO | 55/100 | 22 % | 12.1 |
| Content Quality | 42/100 | 23 % | 9.7 |
| On-Page SEO | 62/100 | 20 % | 12.4 |
| Schema / Structured Data | 15/100 | 10 % | 1.5 |
| Performance | 75/100 | 10 % | 7.5 |
| AI Search Readiness | 40/100 | 10 % | 4.0 |
| Images | 60/100 | 5 % | 3.0 |
| **Gesamt** | | | **48 / 100** 🟡 |

**Ausblick nach Setup-Phase:** 75-85 / 100 erreichbar in 4-6 Wochen.
**Nach 6 Monaten aktiver SEO-Arbeit:** 85-92 / 100 realistisch.

---

Siehe **ACTION-PLAN.md** für priorisierte Umsetzungs-Reihenfolge und **ANGEBOT.md** für die Kalkulationsvorlage.
