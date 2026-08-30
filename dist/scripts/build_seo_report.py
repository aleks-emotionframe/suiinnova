#!/usr/bin/env python3
"""
Baut den finalen SEO-Report als PDF fuer SUI Innova GmbH.
Wiederverwendbar als Vorlage fuer weitere Kunden.
"""

import base64
import os
import subprocess
from datetime import date
from pathlib import Path

# ─────────────────────────────────────────────────
# KUNDEN-KONFIGURATION (aendere hier fuer neue Kunden)
# ─────────────────────────────────────────────────
CLIENT = {
    "name": "SUI Innova GmbH",
    "contact_person": "Riad Ljatifi",
    "location": "Pfäffikon SZ",
    "industry": "Sanitär-Vorfabrikation und Montage",
    "domain": "sui-innova.ch",
    "target_market": "Schweiz",
    "target_audience": "Architekten, Generalunternehmer, Totalunternehmer, Bauleiter, Sanitärunternehmen",
}

AGENCY = {
    "name": "Emotionframe",
    "url": "emotionframe.ch",
    "email": "aleks@emotionframe.ch",
    "tagline": "Digital-Strategie · Web · SEO",
}

TODAY = date.today().strftime("%d.%m.%Y")

# ─────────────────────────────────────────────────
# Charts als Base64 einbetten (garantiert im PDF)
# ─────────────────────────────────────────────────
CHART_DIR = Path("/home/user/suiinnova/audit-sui-innova/report-charts")

def b64(name: str) -> str:
    data = (CHART_DIR / name).read_bytes()
    return "data:image/png;base64," + base64.b64encode(data).decode("ascii")

CHARTS = {
    "score":       b64("01_health_score.png"),
    "competitors": b64("02_competitors.png"),
    "keywords":    b64("03_keywords.png"),
    "roadmap":     b64("04_roadmap.png"),
    "traffic":     b64("05_traffic.png"),
    "pillars":     b64("06_pillars.png"),
}

# ─────────────────────────────────────────────────
# HTML-TEMPLATE
# ─────────────────────────────────────────────────
HTML = f"""<!DOCTYPE html>
<html lang="de-CH">
<head>
<meta charset="utf-8">
<title>SEO-Strategie · {CLIENT['name']}</title>
<style>
    @page {{
        size: A4;
        margin: 22mm 20mm 24mm 20mm;
        @bottom-left {{
            content: "{AGENCY['name']} · SEO-Strategie für {CLIENT['name']}";
            font-family: Inter, Helvetica, sans-serif;
            font-size: 8pt;
            color: #6B7280;
            letter-spacing: 0.05em;
        }}
        @bottom-right {{
            content: "Seite " counter(page) " / " counter(pages);
            font-family: Inter, Helvetica, sans-serif;
            font-size: 8pt;
            color: #6B7280;
        }}
    }}
    @page cover {{
        margin: 0;
        @bottom-left {{ content: ""; }}
        @bottom-right {{ content: ""; }}
    }}
    * {{ box-sizing: border-box; }}
    html, body {{
        font-family: Inter, -apple-system, "Segoe UI", Helvetica, Arial, sans-serif;
        color: #0A0A0A;
        font-size: 10.5pt;
        line-height: 1.6;
        margin: 0;
        padding: 0;
        -webkit-font-smoothing: antialiased;
    }}

    /* ─── Cover Page ────────────────────────────── */
    .cover {{
        page: cover;
        page-break-after: always;
        width: 100%;
        height: 297mm;
        background: #0A0A0A;
        color: #fff;
        padding: 26mm 22mm 22mm 22mm;
        position: relative;
        overflow: hidden;
    }}
    .cover::before {{
        content: "";
        position: absolute;
        top: -10%; right: -20%;
        width: 90%; height: 90%;
        background: radial-gradient(circle, rgba(249,115,22,0.20) 0%, transparent 60%);
        pointer-events: none;
    }}
    .cover::after {{
        content: "";
        position: absolute;
        left: 22mm; bottom: 22mm;
        width: 30mm; height: 3pt;
        background: #F97316;
    }}
    .cover-brand {{
        font-size: 13pt;
        font-weight: 800;
        letter-spacing: -0.01em;
        color: #fff;
        display: flex;
        align-items: baseline;
        gap: 10pt;
    }}
    .cover-brand::before {{
        content: "";
        width: 22pt; height: 3pt;
        background: #F97316;
        display: inline-block;
    }}
    .cover-tagline {{
        margin-top: 4pt;
        font-size: 8.5pt;
        letter-spacing: 0.25em;
        text-transform: uppercase;
        color: rgba(255,255,255,0.55);
        font-weight: 500;
    }}
    .cover-body {{
        position: absolute;
        left: 22mm; right: 22mm;
        bottom: 45mm;
    }}
    .cover-eyebrow {{
        font-size: 9pt;
        letter-spacing: 0.28em;
        text-transform: uppercase;
        color: #F97316;
        font-weight: 700;
        margin-bottom: 14pt;
    }}
    .cover-title {{
        font-size: 46pt;
        font-weight: 900;
        letter-spacing: -0.02em;
        line-height: 1.02;
        color: #fff;
        margin: 0;
    }}
    .cover-subtitle {{
        font-size: 15pt;
        color: rgba(255,255,255,0.75);
        font-weight: 400;
        margin-top: 8pt;
        letter-spacing: -0.005em;
    }}
    .cover-client-block {{
        margin-top: 34pt;
        padding-top: 20pt;
        border-top: 1px solid rgba(255,255,255,0.15);
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        font-size: 9.5pt;
    }}
    .cover-client-block .label {{
        text-transform: uppercase;
        letter-spacing: 0.15em;
        color: rgba(255,255,255,0.5);
        font-size: 7.5pt;
        margin-bottom: 4pt;
    }}
    .cover-client-block .value {{ color: #fff; font-weight: 500; }}

    /* ─── Section Divider ─────────────────────── */
    .section-header {{
        margin: 0 0 22pt 0;
        padding-bottom: 12pt;
        border-bottom: 2px solid #0A0A0A;
        display: flex;
        align-items: baseline;
        gap: 18pt;
    }}
    .section-num {{
        font-size: 34pt;
        font-weight: 800;
        color: #F97316;
        letter-spacing: -0.02em;
        line-height: 1;
    }}
    .section-title {{
        font-size: 22pt;
        font-weight: 800;
        color: #0A0A0A;
        letter-spacing: -0.015em;
        line-height: 1.1;
        margin: 0;
        flex: 1;
    }}
    .section-block {{ page-break-before: always; }}
    .section-block:first-of-type {{ page-break-before: auto; }}

    /* ─── Typography ──────────────────────────── */
    h2 {{
        font-size: 15pt;
        font-weight: 800;
        color: #0A0A0A;
        letter-spacing: -0.01em;
        margin: 22pt 0 8pt 0;
        padding: 0;
        page-break-after: avoid;
    }}
    h3 {{
        font-size: 10pt;
        font-weight: 700;
        color: #F97316;
        text-transform: uppercase;
        letter-spacing: 0.15em;
        margin: 16pt 0 6pt 0;
        page-break-after: avoid;
    }}
    h4 {{
        font-size: 11pt;
        font-weight: 700;
        color: #0A0A0A;
        margin: 10pt 0 4pt 0;
    }}
    p {{ margin: 0 0 9pt 0; }}
    strong, b {{ font-weight: 700; color: #0A0A0A; }}
    em, i {{ font-style: italic; color: #262626; }}

    /* Lead paragraph */
    .lead {{
        font-size: 12pt;
        line-height: 1.55;
        color: #262626;
        margin-bottom: 14pt;
    }}
    .lead strong {{ color: #0A0A0A; }}

    /* Kicker */
    .kicker {{
        font-size: 8.5pt;
        letter-spacing: 0.2em;
        text-transform: uppercase;
        color: #F97316;
        font-weight: 700;
        margin-bottom: 6pt;
    }}

    /* Client-highlight */
    .client-accent {{ color: #C41018; font-weight: 700; }}

    /* ─── Grid & Cards ────────────────────────── */
    .grid-2 {{
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14pt;
        margin: 12pt 0;
    }}
    .grid-3 {{
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 10pt;
        margin: 12pt 0;
    }}
    .card {{
        background: #FAFAFA;
        border-left: 3px solid #F97316;
        padding: 12pt 14pt;
        page-break-inside: avoid;
    }}
    .card h4 {{
        margin-top: 0;
        font-size: 10.5pt;
    }}
    .card-num {{
        font-size: 22pt;
        font-weight: 900;
        color: #0A0A0A;
        letter-spacing: -0.02em;
        line-height: 1;
        margin-bottom: 4pt;
    }}
    .card-label {{
        font-size: 8pt;
        text-transform: uppercase;
        letter-spacing: 0.15em;
        color: #6B7280;
        font-weight: 600;
    }}

    /* KPI row */
    .kpi-row {{
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12pt;
        margin: 14pt 0 20pt 0;
        page-break-inside: avoid;
    }}
    .kpi {{
        background: #0A0A0A;
        color: #fff;
        padding: 14pt 12pt;
        border-left: 3px solid #F97316;
    }}
    .kpi-value {{
        font-size: 24pt;
        font-weight: 900;
        letter-spacing: -0.02em;
        line-height: 1;
        margin-bottom: 4pt;
    }}
    .kpi-label {{
        font-size: 7.5pt;
        text-transform: uppercase;
        letter-spacing: 0.15em;
        color: rgba(255,255,255,0.65);
        font-weight: 600;
    }}

    /* ─── Tabellen ─────────────────────────────── */
    table {{
        width: 100%;
        border-collapse: collapse;
        margin: 10pt 0 14pt 0;
        font-size: 9.5pt;
        page-break-inside: avoid;
    }}
    thead th {{
        background: #0A0A0A;
        color: #fff;
        text-align: left;
        padding: 8pt 10pt;
        font-weight: 700;
        font-size: 8pt;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        border: none;
    }}
    tbody td {{
        padding: 8pt 10pt;
        border-bottom: 1px solid #E5E7EB;
        vertical-align: top;
    }}
    tbody tr:last-child td {{ border-bottom: 2px solid #0A0A0A; }}

    /* Package-Tabelle (Pricing) */
    .packages {{
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 0;
        margin: 16pt 0 20pt 0;
        page-break-inside: avoid;
    }}
    .package {{
        border: 1px solid #E5E7EB;
        padding: 16pt 14pt;
        background: #fff;
    }}
    .package.featured {{
        background: #0A0A0A;
        color: #fff;
        border-color: #0A0A0A;
        position: relative;
        transform: scale(1.02);
        z-index: 2;
    }}
    .package.featured::before {{
        content: "EMPFOHLEN";
        position: absolute;
        top: -1px; left: 0; right: 0;
        background: #F97316;
        color: #0A0A0A;
        text-align: center;
        font-size: 7pt;
        font-weight: 800;
        letter-spacing: 0.2em;
        padding: 3pt 0;
    }}
    .package.featured {{ padding-top: 26pt; }}
    .package-name {{
        font-size: 10pt;
        text-transform: uppercase;
        letter-spacing: 0.18em;
        font-weight: 700;
        margin-bottom: 8pt;
    }}
    .package.featured .package-name {{ color: #F97316; }}
    .package:not(.featured) .package-name {{ color: #6B7280; }}
    .package-price {{
        font-size: 22pt;
        font-weight: 900;
        letter-spacing: -0.02em;
        line-height: 1;
        margin-bottom: 2pt;
    }}
    .package-price small {{
        font-size: 10pt;
        font-weight: 500;
        letter-spacing: 0;
    }}
    .package-setup {{
        font-size: 8.5pt;
        color: #6B7280;
        margin-bottom: 12pt;
    }}
    .package.featured .package-setup {{ color: rgba(255,255,255,0.65); }}
    .package-features {{
        list-style: none;
        padding: 0;
        margin: 8pt 0 0 0;
        font-size: 9pt;
        line-height: 1.55;
    }}
    .package-features li {{
        padding: 3pt 0 3pt 14pt;
        position: relative;
    }}
    .package-features li::before {{
        content: "→";
        position: absolute;
        left: 0;
        color: #F97316;
        font-weight: 700;
    }}

    /* ─── Lists ────────────────────────────────── */
    ul, ol {{ margin: 4pt 0 12pt 0; padding-left: 16pt; }}
    li {{ margin-bottom: 3pt; }}
    ul.clean {{ list-style: none; padding-left: 0; }}
    ul.clean li {{
        padding: 4pt 0 4pt 18pt;
        position: relative;
        border-bottom: 1px solid #F3F4F6;
    }}
    ul.clean li:last-child {{ border-bottom: none; }}
    ul.clean li::before {{
        content: "▸";
        position: absolute;
        left: 0;
        color: #F97316;
        font-weight: 700;
    }}

    /* Callout box */
    .callout {{
        background: #FFF7ED;
        border-left: 3px solid #F97316;
        padding: 12pt 14pt;
        margin: 12pt 0;
        font-size: 10pt;
        page-break-inside: avoid;
    }}
    .callout-title {{
        font-weight: 800;
        color: #0A0A0A;
        margin-bottom: 4pt;
    }}

    /* Chart image */
    .chart {{
        width: 100%;
        margin: 10pt 0 16pt 0;
        page-break-inside: avoid;
    }}
    .chart img {{ width: 100%; height: auto; }}
    .chart-caption {{
        font-size: 8pt;
        color: #6B7280;
        text-align: center;
        letter-spacing: 0.05em;
        margin-top: 4pt;
        font-style: italic;
    }}

    /* Two-column body */
    .col2 {{
        column-count: 2;
        column-gap: 18pt;
    }}
    .col2 p {{ margin-bottom: 8pt; }}

    /* Footer contact block */
    .contact-block {{
        margin-top: 30pt;
        padding: 20pt 22pt;
        background: #0A0A0A;
        color: #fff;
        page-break-inside: avoid;
    }}
    .contact-block h2 {{ color: #fff; margin: 0 0 8pt 0; }}
    .contact-block a {{ color: #F97316; text-decoration: none; }}

    /* Toc */
    .toc {{
        list-style: none;
        padding: 0;
        margin: 20pt 0;
        font-size: 11pt;
    }}
    .toc li {{
        padding: 10pt 0;
        border-bottom: 1px solid #E5E7EB;
        display: flex;
        justify-content: space-between;
    }}
    .toc li span:first-child {{
        display: flex;
        align-items: baseline;
        gap: 12pt;
    }}
    .toc li .num {{
        color: #F97316;
        font-weight: 800;
        min-width: 22pt;
    }}
    .toc li .page {{
        color: #6B7280;
        font-weight: 500;
    }}

    .divider {{
        height: 1px;
        background: #E5E7EB;
        margin: 18pt 0;
        border: none;
    }}

    /* Page-break helpers */
    .keep {{ page-break-inside: avoid; }}
    .break {{ page-break-before: always; }}
</style>
</head>
<body>

<!-- ═════════════════════════════════════ COVER ═════════════════════════════════════ -->
<div class="cover">
    <div class="cover-brand">{AGENCY['name']}</div>
    <div class="cover-tagline">{AGENCY['tagline']}</div>

    <div class="cover-body">
        <div class="cover-eyebrow">— SEO-Strategie & Wachstumsplan</div>
        <h1 class="cover-title">Sichtbar<br>werden.</h1>
        <p class="cover-subtitle">Analyse und Strategiepapier für {CLIENT['name']}</p>

        <div class="cover-client-block">
            <div>
                <div class="label">Für</div>
                <div class="value">{CLIENT['name']}</div>
                <div class="value" style="opacity:0.65;">{CLIENT['location']} · {CLIENT['industry']}</div>
            </div>
            <div>
                <div class="label">Vorbereitet am</div>
                <div class="value">{TODAY}</div>
            </div>
            <div>
                <div class="label">Vertraulich</div>
                <div class="value">Ausschliesslich für internen Gebrauch</div>
            </div>
        </div>
    </div>
</div>

<!-- ═════════════════════════════════════ INHALT ═════════════════════════════════════ -->
<h1 style="font-size:24pt;font-weight:900;letter-spacing:-0.015em;margin:0 0 20pt 0;">Inhalt</h1>
<ul class="toc">
    <li><span><span class="num">01</span>Vorwort</span><span class="page">03</span></li>
    <li><span><span class="num">02</span>Ausgangslage & aktuelle Sichtbarkeit</span><span class="page">04</span></li>
    <li><span><span class="num">03</span>Marktumfeld und Wettbewerb</span><span class="page">06</span></li>
    <li><span><span class="num">04</span>Wachstums-Chancen</span><span class="page">08</span></li>
    <li><span><span class="num">05</span>Unsere Strategie</span><span class="page">10</span></li>
    <li><span><span class="num">06</span>Umsetzungs-Roadmap</span><span class="page">13</span></li>
    <li><span><span class="num">07</span>Erwartete Wirkung</span><span class="page">14</span></li>
    <li><span><span class="num">08</span>Investition & Pakete</span><span class="page">15</span></li>
    <li><span><span class="num">09</span>Zusammenarbeit & nächste Schritte</span><span class="page">17</span></li>
    <li><span><span class="num">10</span>Über {AGENCY['name']}</span><span class="page">18</span></li>
</ul>

<!-- ═════════════════════════════════════ 01 VORWORT ═════════════════════════════════════ -->
<div class="section-block">
    <div class="section-header">
        <div class="section-num">01</div>
        <h1 class="section-title">Vorwort</h1>
    </div>

    <p class="lead"><strong>{CLIENT['name']}</strong> hat sich in den letzten Jahren als spezialisierter Anbieter für Sanitär-Vorfabrikation und Montage in der Deutschschweiz etabliert. Der Auftritt online spiegelt diese Position noch nicht in voller Breite wider — genau hier setzen wir an.</p>

    <p>Dieses Dokument ist keine allgemeine SEO-Checkliste. Wir haben die Situation von {CLIENT['name']} konkret analysiert: das Wettbewerbsumfeld, die aktuellen Rankings, die Zielgruppen ({CLIENT['target_audience']}) und die Chancen, die in dieser Nische ungenutzt liegen. Daraus entstand die Strategie auf den folgenden Seiten.</p>

    <p>Der Bericht ist bewusst so aufgebaut, dass Sie ihn ohne Vorwissen verstehen — jede Fachpassage ist eingebettet in den geschäftlichen Kontext. Unser Ziel ist Transparenz vor Impressionismus: Sie sollen nicht nur wissen <em>was</em> wir tun, sondern <em>warum</em>.</p>

    <div class="kpi-row">
        <div class="kpi">
            <div class="kpi-value">~10</div>
            <div class="kpi-label">Direkte Wettbewerber<br>in der Schweiz</div>
        </div>
        <div class="kpi">
            <div class="kpi-value">78</div>
            <div class="kpi-label">SEO-Grundlagen-Score<br>(technisches Fundament)</div>
        </div>
        <div class="kpi">
            <div class="kpi-value">3 – 6</div>
            <div class="kpi-label">Monate bis<br>messbare Ergebnisse</div>
        </div>
        <div class="kpi">
            <div class="kpi-value">6 – 10x</div>
            <div class="kpi-label">Erwartetes Wachstum<br>organischer Sichtbarkeit</div>
        </div>
    </div>

    <h2>Die Kurzfassung</h2>
    <p>Ihre Website hat ein solides technisches Fundament. Was fehlt, ist die inhaltliche und kommunikative Bespielung: <strong>Sie werden von den falschen Suchbegriffen gefunden und von den richtigen nicht.</strong> In einem Marktumfeld mit begrenzter Konkurrenz ist das gute Nachrichten — die Nische ist mit einer strukturierten Strategie in 6 bis 12 Monaten erobert-bar.</p>

    <p>Auf den nächsten Seiten zeigen wir Ihnen erstens wo Sie stehen, zweitens welche Chancen konkret vorhanden sind, drittens wie unsere Strategie diese Chancen adressiert, und viertens welche Investition dafür realistisch ist.</p>
</div>

<!-- ═════════════════════════════════════ 02 AUSGANGSLAGE ═════════════════════════════════════ -->
<div class="section-block">
    <div class="section-header">
        <div class="section-num">02</div>
        <h1 class="section-title">Ausgangslage & aktuelle Sichtbarkeit</h1>
    </div>

    <p class="lead">Bevor wir über Wachstum sprechen, halten wir fest, wo Sie heute stehen. Nach dem technischen Fundament-Update erreicht Ihre Website einen Grundlagen-Score von 78 von 100. Das heisst: die Basis stimmt, die inhaltliche Aufwertung ist der nächste logische Schritt.</p>

    <div class="grid-2">
        <div>
            <h3>Grundlagen-Score</h3>
            <div class="chart">
                <img src="{CHARTS['score']}" alt="SEO Grundlagen-Score">
            </div>
            <p style="font-size:9pt;color:#6B7280;">Bewertet werden 7 Dimensionen: Technik, Content, On-Page, strukturierte Daten, Performance, AI-Search-Bereitschaft, Bildoptimierung.</p>
        </div>
        <div>
            <h3>Was bereits funktioniert</h3>
            <ul class="clean">
                <li>Suchmaschinen-freundliches technisches Setup (Meta-Tags, Sitemap, Schema.org)</li>
                <li>Mobile Darstellung optimiert und schnell</li>
                <li>DSGVO-konform (Cookie-Consent, IP-Anonymisierung)</li>
                <li>Verifiziert in Google Search Console</li>
                <li>Eintrag auf Schweizer Directories (search.ch, local.ch, moneyhouse.ch)</li>
                <li>Klare URL-Struktur, saubere Weiterleitungen</li>
            </ul>
        </div>
    </div>

    <h2>Aktuelle Sichtbarkeit in Google</h2>

    <p>{CLIENT['name']} wird für einige generische Begriffe bereits gefunden, aber selten in Positionen, die für {CLIENT['industry']} zu Aufträgen führen. Konkret:</p>

    <table>
        <thead>
            <tr>
                <th style="width:52%;">Suchbegriff</th>
                <th style="width:20%;">Suchvolumen / Monat</th>
                <th style="width:14%;">Position</th>
                <th style="width:14%;">Bewertung</th>
            </tr>
        </thead>
        <tbody>
            <tr><td>„Sanitär Vorfabrikation Schweiz"</td><td>100 – 300</td><td>4 – 5</td><td>Solide</td></tr>
            <tr><td>„GIS Vorfabrikation"</td><td>150 – 250</td><td>&gt; 20</td><td>Ausbaufähig</td></tr>
            <tr><td>„AquaPanel Nasszelle Schweiz"</td><td>50 – 100</td><td>Nicht platziert</td><td class="client-accent">Chance</td></tr>
            <tr><td>„Vorwandsystem Montage"</td><td>100 – 200</td><td>&gt; 20</td><td>Ausbaufähig</td></tr>
            <tr><td>„Beplankung Sanitär"</td><td>60 – 120</td><td>Nicht platziert</td><td class="client-accent">Chance</td></tr>
            <tr><td>„Sanitärvorfabrikation Zürich"</td><td>80 – 150</td><td>Nicht platziert</td><td class="client-accent">Chance</td></tr>
        </tbody>
    </table>

    <div class="callout">
        <div class="callout-title">Was diese Zahlen bedeuten</div>
        <p style="margin:0;">Sie sind für einen Kernbegriff gut sichtbar, aber verpassen 5 weitere Themen, wo Sie fachlich stark sind. Das ist typisch für Firmen, die noch nie mit SEO gearbeitet haben — und es ist gleichzeitig die grösste Chance im ganzen Projekt.</p>
    </div>
</div>

<!-- ═════════════════════════════════════ 03 MARKTUMFELD ═════════════════════════════════════ -->
<div class="section-block">
    <div class="section-header">
        <div class="section-num">03</div>
        <h1 class="section-title">Marktumfeld und Wettbewerb</h1>
    </div>

    <p class="lead">Für den Zielmarkt <strong>Schweiz</strong> haben wir die Wettbewerber analysiert. Die Nische ist übersichtlich: rund zehn Anbieter konkurrieren um die gleichen Suchbegriffe. Kein Wettbewerber dominiert alle Themen.</p>

    <h3>Sichtbarkeits-Index — die relevantesten Wettbewerber</h3>
    <div class="chart">
        <img src="{CHARTS['competitors']}" alt="Wettbewerbs-Sichtbarkeit im Vergleich">
        <div class="chart-caption">Index basiert auf: Ranking-Positionen für Kern-Keywords, Domain-Autorität, Content-Umfang, Local-SEO-Signale · Quelle: Emotionframe-Analyse {TODAY}</div>
    </div>

    <h2>Beobachtungen</h2>
    <div class="grid-2">
        <div class="card">
            <h4>Geberit setzt den Rahmen</h4>
            <p style="margin:0;font-size:9.5pt;">Als Hersteller dominiert Geberit die Brand-Suche. Als Installations-Partner konkurrieren Sie nicht direkt, sondern positionieren sich als lokaler, kompetenter Umsetzer.</p>
        </div>
        <div class="card">
            <h4>Engel und Spaeter sind Referenzen</h4>
            <p style="margin:0;font-size:9.5pt;">Beide haben klare Landing-Pages für ihre Kernthemen. Ihr strategisches Vorbild: fokussierte Inhalte statt breite Übersichten.</p>
        </div>
        <div class="card">
            <h4>Kein Anbieter dominiert AI-Search</h4>
            <p style="margin:0;font-size:9.5pt;">In Antworten von ChatGPT und Google AI Overviews ist die gesamte Nische noch fast leer. Ein früher Auftritt hier bringt strukturellen Vorteil.</p>
        </div>
        <div class="card">
            <h4>Local SEO wird unterschätzt</h4>
            <p style="margin:0;font-size:9.5pt;">Nur wenige Wettbewerber pflegen Google Business Profile aktiv. Für die geografische Positionierung ein grosses ungenutztes Feld.</p>
        </div>
    </div>

    <h2>Strategische Positionierung</h2>
    <p>{CLIENT['name']} ist heute im Mittelfeld sichtbar. Der Anspruch für die nächsten 12 Monate: <strong>Top 3 in mindestens fünf Kern-Suchbegriffen</strong>, zusätzlich Reichweite in AI-generierten Antworten. Erreicht wird das nicht über mehr Werbung, sondern über bessere Inhalte, klare Struktur und lokale Präsenz.</p>
</div>

<!-- ═════════════════════════════════════ 04 CHANCEN ═════════════════════════════════════ -->
<div class="section-block">
    <div class="section-header">
        <div class="section-num">04</div>
        <h1 class="section-title">Wachstums-Chancen</h1>
    </div>

    <p class="lead">In Ihrer Nische gibt es einen klaren Zusammenhang zwischen Suchvolumen und Wettbewerbs-Härte. Wir haben neun Keyword-Bereiche identifiziert, die mit realistischem Aufwand erobert werden können.</p>

    <div class="chart">
        <img src="{CHARTS['keywords']}" alt="Keyword-Opportunities">
        <div class="chart-caption">Grössere Kreise = höheres Wachstums-Potenzial. Grüne Kreise = Themen, wo praktisch keine Konkurrenz besteht.</div>
    </div>

    <h2>Vier konkrete Chancen-Cluster</h2>

    <h3>Cluster 1 — Materialspezifische Themen (grün)</h3>
    <p>Suchanfragen wie „AquaPanel Nasszelle", „Beplankung Sanitär" oder „Aussparungsplan Sanitär" haben moderates Volumen aber praktisch keine Fachkonkurrenz. Nur Herstellerseiten ranken hier. Mit fundierten Landing-Pages ist Position 1-3 in 3-4 Monaten realistisch.</p>

    <h3>Cluster 2 — Geografische Kombinationen (grün-gelb)</h3>
    <p>„Sanitär Vorfabrikation Zürich", „GIS-Elemente Zentralschweiz", „Sanitärmodule Ostschweiz" — regionale Long-Tails, die von Ihrer Konkurrenz kaum bespielt werden. Diese Anfragen kommen von Bauleitern in konkreten Projekten mit klarer Kaufabsicht.</p>

    <h3>Cluster 3 — Zielgruppen-spezifische Fragen (gelb)</h3>
    <p>„Vorfabrikation für Generalunternehmen", „Sanitärplanung für Architekten", „Terminvorteil Vorfabrikation" — Anfragen mit klarer Perspektive. Wer so sucht, ist wahrscheinlich in Vergabe-Prozessen involviert.</p>

    <h3>Cluster 4 — AI-Search & Generative Answers (offenes Feld)</h3>
    <p>ChatGPT, Perplexity und Google AI Overviews werden zunehmend als Erst-Recherche genutzt. Wenn Ihre Inhalte hier zitiert werden, gewinnen Sie Präsenz bei Entscheidern, die traditionelle Suchmaschinen kaum noch nutzen. Diese Positionierung ist heute technisch und inhaltlich vorbereitet — <strong>morgen ist sie besetzt</strong>.</p>

    <div class="callout">
        <div class="callout-title">Warum jetzt der richtige Moment ist</div>
        <p style="margin:0;">In stärker umkämpften Branchen (E-Commerce, Software) sind SEO-Investitionen heute ein Marathon gegen etablierte Grössen. In der Sanitär-Vorfabrikations-Nische sind die Positionen noch weitgehend frei. Wer jetzt startet, sichert sich Rankings für die nächsten Jahre.</p>
    </div>
</div>

<!-- ═════════════════════════════════════ 05 STRATEGIE ═════════════════════════════════════ -->
<div class="section-block">
    <div class="section-header">
        <div class="section-num">05</div>
        <h1 class="section-title">Unsere Strategie</h1>
    </div>

    <p class="lead">Wir arbeiten mit fünf strategischen Handlungsfeldern. Die Prozent-Angaben zeigen, wie sich unser monatlicher Arbeitsaufwand über die fünf Felder verteilt.</p>

    <div class="chart">
        <img src="{CHARTS['pillars']}" alt="Fünf Handlungsfelder mit Zeitanteil">
    </div>

    <h2>1 · Content-Strategie & Redaktion <span style="color:#F97316;">— 24%</span></h2>
    <p>Wir schreiben Fachinhalte, die für Ihre Zielgruppen relevant sind: Landing-Pages pro Leistung, ein aktivierter Blog mit Fachartikeln, dedizierte Anwendungsfälle. Ziel: Positionen für Long-Tail-Suchen erobern und Fachkompetenz sichtbar machen.</p>

    <h2>2 · Local SEO & Reputation <span style="color:#F97316;">— 22%</span></h2>
    <p>Google Business Profile aktiv pflegen, Kunden-Reviews systematisch generieren, NAP-Konsistenz über Directories sichern. Ziel: Präsenz im Google Maps Local Pack und in geografisch angereicherten Suchen.</p>

    <h2>3 · Autorität & Backlinks <span style="color:#F97316;">— 20%</span></h2>
    <p>Verlinkungen von Fachverbänden (suissetec, VSSH), Partnern (Architekten, Generalunternehmer), Baustellen-Reportagen. Ziel: Domain-Autorität erhöhen, damit auch schwierigere Rankings erreichbar werden.</p>

    <h2>4 · AI Search Optimierung <span style="color:#F97316;">— 18%</span></h2>
    <p>Strukturierte Q&A-Blöcke, FAQ-Schemas, klare faktische Inhalte, die von ChatGPT, Perplexity und Google AI Overviews zitiert werden können. Ziel: In generativen Antworten mitgenannt werden.</p>

    <h2>5 · Monitoring & Iteration <span style="color:#F97316;">— 16%</span></h2>
    <p>Regelmässige Auswertung von Search Console, Analytics, Rank-Tracking. Erkennung von Chancen und Regressionen. Monatliches Reporting an Sie mit konkreten Handlungs-Empfehlungen.</p>

    <div class="callout">
        <div class="callout-title">Was diese Aufteilung bewusst NICHT enthält</div>
        <p style="margin:0;">Keine bezahlte Werbung (Google Ads), keine Social-Media-Kampagnen, keine Video-Produktion. Diese Kanäle können ergänzend sinnvoll sein — aber die organische Sichtbarkeit über Google ist für Ihre B2B-Zielgruppe der Kanal mit dem besten Kosten-Nutzen-Verhältnis.</p>
    </div>
</div>

<!-- ═════════════════════════════════════ 06 ROADMAP ═════════════════════════════════════ -->
<div class="section-block">
    <div class="section-header">
        <div class="section-num">06</div>
        <h1 class="section-title">Umsetzungs-Roadmap</h1>
    </div>

    <p class="lead">Von der ersten Woche bis zum zwölften Monat — so sieht der Weg aus.</p>

    <div class="chart">
        <img src="{CHARTS['roadmap']}" alt="12-Monats Roadmap Timeline">
    </div>

    <h3>Meilensteine</h3>
    <ul class="clean">
        <li><strong>Ende Monat 1</strong> — Fundament fertig: Google Business Profile aktiv, GA4 & Rank-Tracking laufen, initiale Content-Struktur steht</li>
        <li><strong>Ende Monat 3</strong> — Erste neue Rankings erscheinen (Long-Tail), erste Reviews eingegangen, 2-3 Fachartikel publiziert</li>
        <li><strong>Ende Monat 6</strong> — Blog etabliert (8 Artikel), Backlink-Aufbau in aktiver Phase, messbarer Anstieg der Suchanfragen</li>
        <li><strong>Ende Monat 9</strong> — Kernbegriffe in Top 10, AI-Search-Sichtbarkeit dokumentiert, Konvertierungs-Optimierung startet</li>
        <li><strong>Ende Monat 12</strong> — Zwei bis fünf Kern-Suchbegriffe in Top 3, systematisch wachsender organischer Traffic, dokumentierbare Anfragen aus SEO</li>
    </ul>
</div>

<!-- ═════════════════════════════════════ 07 WIRKUNG ═════════════════════════════════════ -->
<div class="section-block">
    <div class="section-header">
        <div class="section-num">07</div>
        <h1 class="section-title">Erwartete Wirkung</h1>
    </div>

    <p class="lead">SEO ist ein Zinseszins-Effekt. Anfangs geschieht wenig sichtbar, dann kommt Bewegung, dann Wachstum. Diese Kurve ist typisch — und aus unseren früheren Projekten belegbar.</p>

    <div class="chart">
        <img src="{CHARTS['traffic']}" alt="Traffic-Projektion 12 Monate">
        <div class="chart-caption">Konservatives Szenario basiert auf durchschnittlichen Resultaten vergleichbarer B2B-Projekte in der Schweiz. Der Statusquo-Pfad zeigt was passiert wenn nichts unternommen wird — moderates natürliches Wachstum ohne aktive Steuerung.</div>
    </div>

    <h2>Was Sie realistisch erwarten dürfen</h2>
    <table>
        <thead>
            <tr>
                <th>Zeitraum</th>
                <th>Sichtbare Effekte</th>
                <th>Geschäfts-Impact</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Monat 1-3</strong></td>
                <td>Erste Bewegung in Search Console. Neue Impressionen aber wenig Klicks.</td>
                <td>Fundamente werden gelegt. Noch keine spürbare Anfragen-Steigerung.</td>
            </tr>
            <tr>
                <td><strong>Monat 3-6</strong></td>
                <td>Erste neue Rankings. Klicks aus organischer Suche steigen um Faktor 1,5 – 2.</td>
                <td>Erste zusätzliche Anfragen aus SEO. Direkt zurechen-bar.</td>
            </tr>
            <tr>
                <td><strong>Monat 6-12</strong></td>
                <td>Kernbegriffe in Top 10. Organischer Traffic 5 – 10× höher als Start.</td>
                <td>SEO wird zum verlässlichen Anfragen-Kanal. Planbar.</td>
            </tr>
            <tr>
                <td><strong>Monat 12+</strong></td>
                <td>Positionierung als Fachautorität. Rankings selbstverstärkend.</td>
                <td>Marktführerposition in der Nische wird ausbau-bar.</td>
            </tr>
        </tbody>
    </table>

    <div class="callout">
        <div class="callout-title">Ehrliche Grenzen</div>
        <p style="margin:0;">SEO ist keine Schalter-Umlegung. Sie werden im ersten Monat wenig Konkretes sehen — technische Basis wird gelegt. Google braucht Zeit um Änderungen zu bewerten. Erst ab Monat 3 wird es messbar spannend. Wer garantierte Rankings verspricht, ist unseriös. Wir garantieren stattdessen: konkrete Umsetzung, transparentes Reporting, klare KPIs.</p>
    </div>
</div>

<!-- ═════════════════════════════════════ 08 INVESTITION ═════════════════════════════════════ -->
<div class="section-block">
    <div class="section-header">
        <div class="section-num">08</div>
        <h1 class="section-title">Investition & Pakete</h1>
    </div>

    <p class="lead">Drei Paketstufen — von der schlanken Basis bis zur systematischen Skalierung. Alle Preise verstehen sich exkl. MWST. Sechs Monate Mindestlaufzeit für die Retainer-Pakete, danach monatlich kündbar mit einem Monat Frist.</p>

    <div class="packages">
        <div class="package">
            <div class="package-name">Basis</div>
            <div class="package-price">CHF 1'800</div>
            <div class="package-setup">Einmalig · kein Retainer</div>
            <ul class="package-features">
                <li>Google Business Profile Setup</li>
                <li>Google Analytics 4 Einrichtung</li>
                <li>Search Console Onboarding</li>
                <li>Erste Landing-Pages optimiert</li>
                <li>Übergabe-Report + Beratung (1h)</li>
                <li>Danach eigenständige Umsetzung</li>
            </ul>
        </div>
        <div class="package featured">
            <div class="package-name">Solid</div>
            <div class="package-price">CHF 1'400 <small>/Monat</small></div>
            <div class="package-setup">Setup CHF 4'500 einmalig · 6 Monate Mindestlaufzeit</div>
            <ul class="package-features">
                <li>Alles aus Basis</li>
                <li>4 Fachartikel im Setup</li>
                <li>Schema.org Erweiterung</li>
                <li>Rank-Tracking für 25 Keywords</li>
                <li>1 neuer Beitrag pro Monat</li>
                <li>Monatliches Reporting</li>
                <li>Reviews-Aktivierung</li>
                <li>Technisches Monitoring</li>
            </ul>
        </div>
        <div class="package">
            <div class="package-name">Wachstum</div>
            <div class="package-price">CHF 1'900 <small>/Monat</small></div>
            <div class="package-setup">Setup CHF 6'800 einmalig · 6 Monate Mindestlaufzeit</div>
            <ul class="package-features">
                <li>Alles aus Solid</li>
                <li>Blog vollständig aktiviert</li>
                <li>2 Backlinks pro Monat aktiv</li>
                <li>AI-Search Content-Optimierung</li>
                <li>Konkurrenz-Monitoring</li>
                <li>Konvertierungs-Analyse</li>
                <li>Quartals-Strategie-Sessions</li>
                <li>Priorisierter Support</li>
            </ul>
        </div>
    </div>

    <h2>Unsere Empfehlung für {CLIENT['name']}</h2>
    <p>Für Ihre aktuelle Ausgangslage empfehlen wir das Paket <strong>Solid</strong>. Es kombiniert die notwendige Setup-Tiefe mit einem realistischen monatlichen Umfang. Nach den ersten sechs Monaten haben wir gemeinsam eine klare Datenbasis, um zu entscheiden ob eine Skalierung auf <strong>Wachstum</strong> sinnvoll ist oder ob Solid weiterläuft.</p>

    <h2>Was nicht enthalten ist</h2>
    <p>Externe Kosten (z.B. Werkzeug-Lizenzen, sofern nicht in unseren Paketen berücksichtigt), grafische Neuentwürfe (Bilder, Grafiken), Video- und Fotografie-Produktion, Website-Umbauten die über SEO-Optimierung hinausgehen. Solche Themen besprechen wir bei Bedarf separat und stellen sie auf Aufwand in Rechnung.</p>
</div>

<!-- ═════════════════════════════════════ 09 ZUSAMMENARBEIT ═════════════════════════════════════ -->
<div class="section-block">
    <div class="section-header">
        <div class="section-num">09</div>
        <h1 class="section-title">Zusammenarbeit & nächste Schritte</h1>
    </div>

    <p class="lead">Wenn Sie sich für die Zusammenarbeit entscheiden, sind die ersten Wochen entscheidend. Hier der konkrete Ablauf.</p>

    <h2>Woche 0 — Vor dem Start</h2>
    <ul class="clean">
        <li>Vertragsunterzeichnung und Kickoff-Termin (60 – 90 Minuten, vor Ort oder Video)</li>
        <li>Freigabe der Zugänge: Google Search Console, Analytics, Google Business Profile, Hostpoint (bei Bedarf)</li>
        <li>Kurze Abstimmung zu Zielprojekten und Referenzen, die wir hervorheben sollen</li>
    </ul>

    <h2>Woche 1-4 — Setup-Phase</h2>
    <ul class="clean">
        <li>Vollständiges technisches Onboarding aller Tools und Tracking-Systeme</li>
        <li>Erste Landing-Pages und Content-Erweiterungen live</li>
        <li>Google Business Profile aktiv, erste Fotos und Kategorien gesetzt</li>
        <li>Rank-Tracking für alle Ziel-Keywords eingerichtet</li>
        <li>Kurzes Status-Update nach zwei Wochen (E-Mail, ~5 Minuten Lesezeit)</li>
    </ul>

    <h2>Ab Monat 2 — Regelbetrieb</h2>
    <ul class="clean">
        <li>Monatliches Reporting: 2 Seiten PDF, klare Zahlen, konkrete nächste Schritte</li>
        <li>Ein neuer Fachartikel oder eine neue Landing-Page pro Monat</li>
        <li>Kontinuierliche Optimierung basierend auf Search-Console-Daten</li>
        <li>Bei Bedarf: telefonisches Update, keine Zusatzkosten für kurze Fragen</li>
    </ul>

    <h2>Was wir von Ihnen brauchen</h2>
    <ul>
        <li><strong>Zugänge freigeben</strong> (siehe Woche 0)</li>
        <li><strong>Fachliches Sparring</strong> — wir müssen nicht Sanitär-Experten werden, aber Ihre Expertise brauchen wir für glaubwürdige Inhalte. Rechnen Sie mit ~1 Stunde Ihrer Zeit pro Monat</li>
        <li><strong>Projekt-Freigaben</strong> für Referenzen — welche Objekte dürfen wir öffentlich nennen und welche nicht</li>
        <li><strong>Aktive Kunden-Akquise für Reviews</strong> — nach Projektabschluss die Nachfrage nach einer Google-Bewertung ist Ihr Job (wir liefern Vorlagen und Prozess)</li>
    </ul>
</div>

<!-- ═════════════════════════════════════ 10 ÜBER UNS ═════════════════════════════════════ -->
<div class="section-block">
    <div class="section-header">
        <div class="section-num">10</div>
        <h1 class="section-title">Über {AGENCY['name']}</h1>
    </div>

    <p class="lead">Wir sind {AGENCY['name']} — eine unabhängige Schweizer Agentur für Digital-Strategie und SEO. Wir arbeiten mit KMU, die ihren Auftritt professionell und messbar entwickeln wollen.</p>

    <div class="grid-2">
        <div>
            <h3>Unser Ansatz</h3>
            <p>Wir bevorzugen Klartext gegenüber Buzzwords, faktische Belege gegenüber Marketing-Versprechen, und ein monatliches Reporting, das Sie in fünf Minuten versteht.</p>
            <p>SEO ist ein Handwerk. Es gibt keine Abkürzungen, keine Zauberei, keine Rankings-Garantien. Was es gibt: strukturiertes Arbeiten, Datenbasis, Iteration. Genau das liefern wir.</p>
        </div>
        <div>
            <h3>Warum wir zu {CLIENT['name']} passen</h3>
            <p>Wir kennen Ihre Website bereits im Detail — wir haben sie mit aufgebaut. Damit sparen Sie sich die Onboarding-Phase, in der eine externe Agentur zuerst verstehen muss, wie Ihre Website funktioniert.</p>
            <p>Sie erreichen uns direkt, ohne Account-Manager-Zwischenschicht. Änderungen an der Website setzen wir selbst um — kein Wartungs-Ping-Pong mit externen Entwicklern.</p>
        </div>
    </div>

    <div class="contact-block">
        <div class="kicker" style="color:#F97316;">— Kontakt & Ansprechpartner</div>
        <h2>{AGENCY['name']}</h2>
        <p style="color:rgba(255,255,255,0.85);font-size:11pt;margin-bottom:14pt;">Wir freuen uns auf Ihre Rückmeldung. Idealerweise vereinbaren wir einen kurzen Termin zur Klärung offener Fragen — dann können wir mit dem Vertrag und dem Kickoff starten.</p>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:14pt;font-size:10pt;color:rgba(255,255,255,0.85);">
            <div>
                <div class="kicker" style="color:rgba(255,255,255,0.5);font-size:8pt;">Web</div>
                <div style="color:#fff;font-weight:500;"><a href="https://{AGENCY['url']}">{AGENCY['url']}</a></div>
            </div>
            <div>
                <div class="kicker" style="color:rgba(255,255,255,0.5);font-size:8pt;">E-Mail</div>
                <div style="color:#fff;font-weight:500;"><a href="mailto:{AGENCY['email']}">{AGENCY['email']}</a></div>
            </div>
        </div>
    </div>

    <p style="margin-top:24pt;font-size:8pt;color:#9CA3AF;text-align:center;letter-spacing:0.1em;">
        Dieses Dokument wurde erstellt am {TODAY} für {CLIENT['name']}. Vertraulich. Version 1.0.
    </p>
</div>

</body>
</html>
"""

# ─────────────────────────────────────────────────
# PDF generieren
# ─────────────────────────────────────────────────
OUT_DIR = Path("/home/user/suiinnova/audit-sui-innova/pdf")
OUT_DIR.mkdir(parents=True, exist_ok=True)

html_file = OUT_DIR / "seo-strategie-sui-innova.html"
pdf_file = OUT_DIR / "SEO-Strategie_SUI-Innova.pdf"

html_file.write_text(HTML, encoding="utf-8")

chromium_paths = [
    "/opt/pw-browsers/chromium-1194/chrome-linux/chrome",
    "chromium",
    "google-chrome",
]

for chrome in chromium_paths:
    try:
        r = subprocess.run(
            [
                chrome,
                "--headless",
                "--no-sandbox",
                "--disable-gpu",
                "--print-to-pdf-no-header",
                f"--print-to-pdf={pdf_file}",
                f"file://{html_file.absolute()}",
            ],
            capture_output=True, text=True, timeout=90,
        )
        if r.returncode == 0 and pdf_file.exists():
            print(f"✓ Erstellt: {pdf_file} ({pdf_file.stat().st_size // 1024} KB)")
            break
    except (FileNotFoundError, subprocess.TimeoutExpired) as e:
        print(f"Chromium {chrome} fehlgeschlagen: {e}")
        continue
else:
    raise RuntimeError("Konnte kein Chromium finden")

# HTML aufraeumen
html_file.unlink(missing_ok=True)
