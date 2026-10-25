#!/usr/bin/env python3
"""
Baut den finalen SEO-Report als PDF fuer SUI Innova GmbH.
Emotionframe-Design: Bricolage Grotesque + Montserrat, warmer Gold-Gradient.
Wiederverwendbar als Vorlage fuer weitere Kunden.
"""

import base64
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
    "name": "EmotionFrame",
    "company": "EmotionFrame GmbH",
    "url": "emotionframe.ch",
    "email": "hello@emotionframe.ch",
    "address": "Loorenstrasse 4, 5443 Niederrohrdorf",
    "tagline": "Kreativstudio für Bild, Bewegung und Marke",
}

TODAY = date.today().strftime("%d.%m.%Y")

# ─────────────────────────────────────────────────
# Fonts + Charts als Base64 einbetten
# ─────────────────────────────────────────────────
CHART_DIR = Path("/home/user/suiinnova/audit-sui-innova/report-charts")
FONT_DIR = Path("/home/user/suiinnova/audit-sui-innova/fonts")

def b64_img(name: str) -> str:
    data = (CHART_DIR / name).read_bytes()
    return "data:image/png;base64," + base64.b64encode(data).decode("ascii")

def b64_font(name: str) -> str:
    data = (FONT_DIR / name).read_bytes()
    return "data:font/ttf;base64," + base64.b64encode(data).decode("ascii")

# EmotionFrame Logo als SVG (Frame + Wortmarke). Wird zweimal gerendert:
# einmal mit weissem Text (fuer dunkle Hintergruende), einmal mit schwarzem.
LOGO_SVG_TEMPLATE = (Path("/home/user/suiinnova/audit-sui-innova/logos/emotionframe-logo.svg")
                     .read_text(encoding="utf-8"))

def logo_svg(text_color: str) -> str:
    svg = LOGO_SVG_TEMPLATE.replace("__TEXT_COLOR__", text_color)
    return "data:image/svg+xml;base64," + base64.b64encode(svg.encode("utf-8")).decode("ascii")

LOGO_LIGHT = logo_svg("#1A1A1A")   # dunkler Text fuer helle Hintergruende
LOGO_DARK  = logo_svg("#FFFFFF")   # heller Text fuer dunkle Hintergruende

CHARTS = {
    "score":       b64_img("01_health_score.png"),
    "competitors": b64_img("02_competitors.png"),
    "keywords":    b64_img("03_keywords.png"),
    "roadmap":     b64_img("04_roadmap.png"),
    "traffic":     b64_img("05_traffic.png"),
    "pillars":     b64_img("06_pillars.png"),
}

FONT_CSS = f"""
@font-face {{ font-family: 'Montserrat'; font-weight: 300; font-style: normal; src: url({b64_font('Montserrat-300.ttf')}) format('truetype'); font-display: swap; }}
@font-face {{ font-family: 'Montserrat'; font-weight: 400; font-style: normal; src: url({b64_font('Montserrat-400.ttf')}) format('truetype'); font-display: swap; }}
@font-face {{ font-family: 'Montserrat'; font-weight: 500; font-style: normal; src: url({b64_font('Montserrat-500.ttf')}) format('truetype'); font-display: swap; }}
@font-face {{ font-family: 'Montserrat'; font-weight: 600; font-style: normal; src: url({b64_font('Montserrat-600.ttf')}) format('truetype'); font-display: swap; }}
@font-face {{ font-family: 'Montserrat'; font-weight: 700; font-style: normal; src: url({b64_font('Montserrat-700.ttf')}) format('truetype'); font-display: swap; }}
@font-face {{ font-family: 'Montserrat'; font-weight: 800; font-style: normal; src: url({b64_font('Montserrat-800.ttf')}) format('truetype'); font-display: swap; }}
@font-face {{ font-family: 'Bricolage Grotesque'; font-weight: 500; font-style: normal; src: url({b64_font('Bricolage-500.ttf')}) format('truetype'); font-display: swap; }}
@font-face {{ font-family: 'Bricolage Grotesque'; font-weight: 800; font-style: normal; src: url({b64_font('Bricolage-800.ttf')}) format('truetype'); font-display: swap; }}
"""

# ─────────────────────────────────────────────────
# HTML-TEMPLATE (Emotionframe-Design)
# ─────────────────────────────────────────────────
HTML = f"""<!DOCTYPE html>
<html lang="de-CH">
<head>
<meta charset="utf-8">
<title>SEO-Strategie · {CLIENT['name']}</title>
<style>
    {FONT_CSS}

    @page {{
        size: A4;
        margin: 22mm 20mm 24mm 20mm;
        @bottom-left {{
            content: "{AGENCY['name']} · SEO-Strategie für {CLIENT['name']}";
            font-family: 'Montserrat', sans-serif;
            font-size: 8pt;
            color: #A8A29E;
            letter-spacing: 0.06em;
        }}
        @bottom-right {{
            content: counter(page) " / " counter(pages);
            font-family: 'Montserrat', sans-serif;
            font-size: 8pt;
            color: #A8A29E;
        }}
    }}
    @page cover {{
        margin: 0;
        @bottom-left {{ content: ""; }}
        @bottom-right {{ content: ""; }}
    }}
    * {{ box-sizing: border-box; }}
    html, body {{
        font-family: 'Montserrat', -apple-system, sans-serif;
        color: #1A1A1A;
        font-size: 10.5pt;
        line-height: 1.65;
        font-weight: 400;
        margin: 0;
        padding: 0;
        -webkit-font-smoothing: antialiased;
    }}

    /* ─── Cover Page ────────────────────────────── */
    .cover {{
        page: cover;
        page-break-after: always;
        break-after: page;
        width: 100%;
        height: 297mm;
        background: #1A1A1A;
        color: #fff;
        padding: 26mm 22mm;
        position: relative;
        overflow: hidden;
    }}
    /* Spektrum-Glow im Emotionframe-Stil */
    .cover::before {{
        content: "";
        position: absolute;
        top: -25%; right: -20%;
        width: 90%; height: 90%;
        background: radial-gradient(circle, rgba(104,218,200,0.22) 0%, rgba(90,160,240,0.15) 35%, rgba(124,107,232,0.08) 60%, transparent 78%);
        pointer-events: none;
    }}
    /* Zusaetzlicher Pink/Violett-Glow links unten */
    .cover .aux-glow {{
        position: absolute;
        bottom: -15%; left: -15%;
        width: 60%; height: 60%;
        background: radial-gradient(circle, rgba(245,165,181,0.14) 0%, rgba(124,107,232,0.08) 45%, transparent 70%);
        pointer-events: none;
    }}
    /* Feiner Rahmen als Design-Element (Frame) */
    .cover::after {{
        content: "";
        position: absolute;
        top: 15mm; right: 15mm; bottom: 15mm; left: 15mm;
        border: 1px solid rgba(255,255,255,0.08);
        pointer-events: none;
    }}
    .cover-brand {{
        position: relative;
        font-family: 'Bricolage Grotesque', sans-serif;
        font-size: 15pt;
        font-weight: 800;
        letter-spacing: -0.01em;
        color: #fff;
        display: flex;
        align-items: baseline;
        gap: 12pt;
    }}
    .cover-brand::before {{
        content: "";
        width: 24pt; height: 3pt;
        background: linear-gradient(90deg, #F5A5B5 0%, #68DAC8 25%, #5AA0F0 55%, #7C6BE8 100%);
        display: inline-block;
    }}
    .cover-tagline {{
        margin-top: 5pt;
        font-size: 8.5pt;
        letter-spacing: 0.25em;
        text-transform: uppercase;
        color: rgba(255,255,255,0.5);
        font-weight: 500;
    }}
    .cover-body {{
        position: absolute;
        left: 22mm; right: 22mm;
        bottom: 45mm;
    }}
    .cover-eyebrow {{
        font-family: 'Montserrat', sans-serif;
        font-size: 9pt;
        letter-spacing: 0.28em;
        text-transform: uppercase;
        background: linear-gradient(90deg, #F5A5B5 0%, #68DAC8 25%, #5AA0F0 55%, #7C6BE8 100%);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        font-weight: 700;
        margin-bottom: 18pt;
    }}
    .cover-title {{
        font-family: 'Bricolage Grotesque', sans-serif;
        font-size: 56pt;
        font-weight: 800;
        letter-spacing: -0.03em;
        line-height: 0.98;
        color: #fff;
        margin: 0;
    }}
    .cover-title .accent {{
        background: linear-gradient(90deg, #68DAC8 0%, #5AA0F0 60%);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
    }}
    .cover-subtitle {{
        font-family: 'Montserrat', sans-serif;
        font-size: 14pt;
        color: rgba(255,255,255,0.72);
        font-weight: 300;
        margin-top: 12pt;
        letter-spacing: -0.005em;
    }}
    .cover-client-block {{
        margin-top: 38pt;
        padding-top: 22pt;
        border-top: 1px solid rgba(255,255,255,0.15);
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        font-size: 9.5pt;
        gap: 18pt;
    }}
    .cover-client-block .label {{
        text-transform: uppercase;
        letter-spacing: 0.18em;
        color: rgba(255,255,255,0.45);
        font-size: 7.5pt;
        margin-bottom: 5pt;
        font-weight: 500;
    }}
    .cover-client-block .value {{ color: #fff; font-weight: 500; }}

    /* ─── Section Divider ─────────────────────── */
    .section-block {{
        page-break-before: always;
        break-before: page;
    }}
    .section-block:first-of-type {{
        page-break-before: auto;
        break-before: auto;
    }}
    .section-header {{
        margin: 0 0 26pt 0;
        padding-bottom: 14pt;
        border-bottom: 2px solid #1A1A1A;
        display: flex;
        align-items: baseline;
        gap: 20pt;
    }}
    .section-num {{
        font-family: 'Bricolage Grotesque', sans-serif;
        font-size: 38pt;
        font-weight: 800;
        background: linear-gradient(135deg, #F5A5B5 0%, #68DAC8 30%, #5AA0F0 60%, #7C6BE8 100%);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        letter-spacing: -0.02em;
        line-height: 1;
    }}
    .section-title {{
        font-family: 'Bricolage Grotesque', sans-serif;
        font-size: 26pt;
        font-weight: 800;
        color: #1A1A1A;
        letter-spacing: -0.02em;
        line-height: 1.05;
        margin: 0;
        flex: 1;
    }}

    /* ─── Typography ──────────────────────────── */
    h1, h2, h3, h4 {{ font-family: 'Bricolage Grotesque', sans-serif; }}
    h2 {{
        font-size: 16pt;
        font-weight: 800;
        color: #1A1A1A;
        letter-spacing: -0.015em;
        margin: 24pt 0 10pt 0;
        padding: 0;
        page-break-after: avoid;
        break-after: avoid;
    }}
    h3 {{
        font-family: 'Montserrat', sans-serif;
        font-size: 9.5pt;
        font-weight: 700;
        background: linear-gradient(90deg, #0891B2 0%, #7C3AED 100%);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        text-transform: uppercase;
        letter-spacing: 0.18em;
        margin: 18pt 0 8pt 0;
        page-break-after: avoid;
        break-after: avoid;
    }}
    h4 {{
        font-size: 11.5pt;
        font-weight: 800;
        color: #1A1A1A;
        margin: 12pt 0 5pt 0;
        letter-spacing: -0.01em;
    }}
    p {{ margin: 0 0 10pt 0; orphans: 3; widows: 3; }}
    strong, b {{ font-weight: 700; color: #1A1A1A; }}
    em, i {{ font-style: italic; color: #3D3D3D; }}

    /* Warmer Akzent-Text (Gold-Gradient wie im EmotionFrame-Logo) */
    .accent {{
        background: linear-gradient(90deg, #F5A5B5 0%, #68DAC8 25%, #5AA0F0 55%, #7C6BE8 100%);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        font-weight: 700;
    }}
    .client-accent {{ color: #C41018; font-weight: 700; }}

    /* Lead paragraph */
    .lead {{
        font-family: 'Montserrat', sans-serif;
        font-size: 12pt;
        line-height: 1.55;
        color: #3D3D3D;
        font-weight: 400;
        margin-bottom: 16pt;
    }}
    .lead strong {{ color: #1A1A1A; font-weight: 600; }}

    /* Kicker */
    .kicker {{
        font-family: 'Montserrat', sans-serif;
        font-size: 8.5pt;
        letter-spacing: 0.22em;
        text-transform: uppercase;
        color: #0891B2;
        font-weight: 700;
        margin-bottom: 8pt;
    }}

    /* ─── Grid & Cards ────────────────────────── */
    .grid-2 {{
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14pt;
        margin: 14pt 0;
        page-break-inside: avoid;
        break-inside: avoid;
    }}
    .grid-3 {{
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 12pt;
        margin: 14pt 0;
        page-break-inside: avoid;
        break-inside: avoid;
    }}
    .card {{
        background: #FAFAFA;
        border-left: 2px solid #0891B2;
        padding: 13pt 15pt;
        page-break-inside: avoid;
        break-inside: avoid;
    }}
    .card h4 {{ margin-top: 0; font-size: 11pt; }}
    .card p {{ margin-bottom: 0; font-size: 9.5pt; }}

    /* KPI row */
    .kpi-row {{
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 10pt;
        margin: 18pt 0 22pt 0;
        page-break-inside: avoid;
        break-inside: avoid;
    }}
    .kpi {{
        background: #1A1A1A;
        color: #fff;
        padding: 16pt 13pt;
        border-top: 2pt solid #0891B2;
    }}
    .kpi-value {{
        font-family: 'Bricolage Grotesque', sans-serif;
        font-size: 26pt;
        font-weight: 800;
        letter-spacing: -0.03em;
        line-height: 1;
        margin-bottom: 6pt;
    }}
    .kpi-label {{
        font-family: 'Montserrat', sans-serif;
        font-size: 7.5pt;
        text-transform: uppercase;
        letter-spacing: 0.15em;
        color: rgba(255,255,255,0.68);
        font-weight: 500;
        line-height: 1.4;
    }}

    /* ─── Tabellen ─────────────────────────────── */
    table {{
        width: 100%;
        border-collapse: collapse;
        margin: 12pt 0 16pt 0;
        font-size: 9.5pt;
        page-break-inside: avoid;
        break-inside: avoid;
    }}
    thead th {{
        background: #1A1A1A;
        color: #fff;
        text-align: left;
        padding: 9pt 11pt;
        font-family: 'Montserrat', sans-serif;
        font-weight: 700;
        font-size: 8pt;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        border: none;
    }}
    tbody td {{
        padding: 9pt 11pt;
        border-bottom: 1px solid #E5E7EB;
        vertical-align: top;
    }}
    tbody tr:last-child td {{ border-bottom: 2px solid #1A1A1A; }}

    /* Package-Karten (Pricing) */
    .packages {{
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 0;
        margin: 18pt 0 22pt 0;
        page-break-inside: avoid;
        break-inside: avoid;
    }}
    .package {{
        border: 1px solid #E5E7EB;
        padding: 18pt 16pt;
        background: #fff;
    }}
    .package.featured {{
        background: #1A1A1A;
        color: #fff;
        border-color: #1A1A1A;
        position: relative;
        transform: scale(1.03);
        z-index: 2;
        box-shadow: 0 8pt 24pt rgba(0,0,0,0.15);
    }}
    .package.featured::before {{
        content: "EMPFOHLEN";
        position: absolute;
        top: -1px; left: 0; right: 0;
        background: linear-gradient(90deg, #F5A5B5 0%, #68DAC8 25%, #5AA0F0 55%, #7C6BE8 100%);
        color: #1A1A1A;
        text-align: center;
        font-family: 'Montserrat', sans-serif;
        font-size: 7pt;
        font-weight: 800;
        letter-spacing: 0.25em;
        padding: 4pt 0;
    }}
    .package.featured {{ padding-top: 28pt; }}
    .package-name {{
        font-family: 'Bricolage Grotesque', sans-serif;
        font-size: 12pt;
        text-transform: uppercase;
        letter-spacing: 0.15em;
        font-weight: 800;
        margin-bottom: 10pt;
    }}
    .package.featured .package-name {{
        background: linear-gradient(90deg, #68DAC8 0%, #5AA0F0 50%);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
    }}
    .package:not(.featured) .package-name {{ color: #6B6B6B; }}
    .package-price {{
        font-family: 'Bricolage Grotesque', sans-serif;
        font-size: 26pt;
        font-weight: 800;
        letter-spacing: -0.025em;
        line-height: 1;
        margin-bottom: 4pt;
    }}
    .package-price small {{
        font-family: 'Montserrat', sans-serif;
        font-size: 10pt;
        font-weight: 500;
        letter-spacing: 0;
        opacity: 0.7;
    }}
    .package-setup {{
        font-size: 8.5pt;
        color: #6B6B6B;
        margin-bottom: 14pt;
    }}
    .package.featured .package-setup {{ color: rgba(255,255,255,0.65); }}
    .package-features {{
        list-style: none;
        padding: 0;
        margin: 10pt 0 0 0;
        font-size: 9pt;
        line-height: 1.55;
    }}
    .package-features li {{
        padding: 4pt 0 4pt 15pt;
        position: relative;
    }}
    .package-features li::before {{
        content: "→";
        position: absolute;
        left: 0;
        color: #0891B2;
        font-weight: 700;
    }}
    .package.featured .package-features li::before {{
        background: linear-gradient(90deg, #68DAC8 0%, #5AA0F0 100%);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
    }}

    /* ─── Lists ────────────────────────────────── */
    ul, ol {{ margin: 6pt 0 12pt 0; padding-left: 18pt; }}
    li {{ margin-bottom: 4pt; }}
    ul.clean {{ list-style: none; padding-left: 0; }}
    ul.clean li {{
        padding: 6pt 0 6pt 20pt;
        position: relative;
        border-bottom: 1px solid #F1F5F9;
    }}
    ul.clean li:last-child {{ border-bottom: none; }}
    ul.clean li::before {{
        content: "▸";
        position: absolute;
        left: 0;
        color: #0891B2;
        font-weight: 700;
    }}

    /* Callout box */
    .callout {{
        background: linear-gradient(135deg, #F0FDFA 0%, #ECFEFF 100%);
        border-left: 2px solid #0891B2;
        padding: 14pt 16pt;
        margin: 14pt 0;
        font-size: 10pt;
        page-break-inside: avoid;
        break-inside: avoid;
    }}
    .callout-title {{
        font-family: 'Bricolage Grotesque', sans-serif;
        font-weight: 800;
        color: #1A1A1A;
        margin-bottom: 6pt;
        font-size: 11pt;
    }}
    .callout p {{ margin-bottom: 0; }}

    /* Chart image */
    .chart {{
        width: 100%;
        margin: 12pt 0 18pt 0;
        page-break-inside: avoid;
        break-inside: avoid;
    }}
    .chart img {{ width: 100%; height: auto; display: block; }}
    .chart-caption {{
        font-size: 8pt;
        color: #6B6B6B;
        text-align: center;
        letter-spacing: 0.05em;
        margin-top: 6pt;
        font-style: italic;
    }}

    /* Footer contact block */
    .contact-block {{
        margin-top: 30pt;
        padding: 24pt 24pt;
        background: #1A1A1A;
        color: #fff;
        page-break-inside: avoid;
        break-inside: avoid;
        border-top: 3pt solid transparent;
        border-image: linear-gradient(90deg, #F5A5B5 0%, #68DAC8 25%, #5AA0F0 55%, #7C6BE8 100%) 1;
    }}
    .contact-block h2 {{
        font-family: 'Bricolage Grotesque', sans-serif;
        color: #fff;
        margin: 0 0 8pt 0;
        font-size: 20pt;
    }}
    .contact-block a {{
        background: linear-gradient(90deg, #68DAC8 0%, #5AA0F0 100%);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        text-decoration: none;
        font-weight: 600;
    }}

    /* Toc */
    .toc-heading {{
        font-family: 'Bricolage Grotesque', sans-serif;
        font-size: 28pt;
        font-weight: 800;
        letter-spacing: -0.02em;
        margin: 0 0 24pt 0;
        color: #1A1A1A;
    }}
    .toc {{
        list-style: none;
        padding: 0;
        margin: 20pt 0;
        font-size: 11.5pt;
        font-family: 'Montserrat', sans-serif;
    }}
    .toc li {{
        padding: 12pt 0;
        border-bottom: 1px solid #E5E7EB;
        display: flex;
        justify-content: space-between;
        align-items: baseline;
    }}
    .toc li:first-child {{ border-top: 2px solid #1A1A1A; }}
    .toc-left {{
        display: flex;
        align-items: baseline;
        gap: 14pt;
    }}
    .toc-num {{
        font-family: 'Bricolage Grotesque', sans-serif;
        background: linear-gradient(135deg, #68DAC8 0%, #0891B2 100%);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        font-weight: 800;
        min-width: 24pt;
        font-size: 12pt;
    }}
    .toc-page {{
        color: #A8A29E;
        font-weight: 500;
        font-size: 10pt;
    }}

    /* Page-break helpers */
    .keep, .no-break {{
        page-break-inside: avoid;
        break-inside: avoid;
    }}
    .break {{
        page-break-before: always;
        break-before: page;
    }}

    /* Zwei-Spalten Text (auf Deutsch: nicht zu schmal, Silbentrennung) */
    .col2 {{
        column-count: 2;
        column-gap: 22pt;
    }}
    .col2 p {{ margin-bottom: 9pt; }}
</style>
</head>
<body>

<!-- ═════════════════════════════════════ COVER ═════════════════════════════════════ -->
<div class="cover">
    <div class="aux-glow"></div>
    <img src="{LOGO_DARK}" alt="EmotionFrame" style="position:relative;height:52pt;width:auto;display:block;margin-bottom:6pt;">
    <div class="cover-tagline" style="position:relative;">{AGENCY['tagline']}</div>

    <div class="cover-body">
        <div class="cover-eyebrow">— SEO-Strategie & Wachstumsplan</div>
        <h1 class="cover-title">Sichtbar<br><span class="accent">werden.</span></h1>
        <p class="cover-subtitle">Analyse und Strategiepapier für {CLIENT['name']}</p>

        <div class="cover-client-block">
            <div>
                <div class="label">Für</div>
                <div class="value">{CLIENT['name']}</div>
                <div class="value" style="opacity:0.6;">{CLIENT['location']} · {CLIENT['industry']}</div>
            </div>
            <div>
                <div class="label">Vorbereitet am</div>
                <div class="value">{TODAY}</div>
            </div>
            <div>
                <div class="label">Vertraulich</div>
                <div class="value">Für internen Gebrauch</div>
            </div>
        </div>
    </div>
</div>

<!-- ═════════════════════════════════════ INHALT ═════════════════════════════════════ -->
<h1 class="toc-heading">Inhalt</h1>
<ul class="toc">
    <li><span class="toc-left"><span class="toc-num">01</span>Vorwort</span><span class="toc-page">03</span></li>
    <li><span class="toc-left"><span class="toc-num">02</span>Ausgangslage & aktuelle Sichtbarkeit</span><span class="toc-page">04</span></li>
    <li><span class="toc-left"><span class="toc-num">03</span>Marktumfeld und Wettbewerb</span><span class="toc-page">06</span></li>
    <li><span class="toc-left"><span class="toc-num">04</span>Wachstums-Chancen</span><span class="toc-page">08</span></li>
    <li><span class="toc-left"><span class="toc-num">05</span>Unsere Strategie</span><span class="toc-page">10</span></li>
    <li><span class="toc-left"><span class="toc-num">06</span>Umsetzungs-Roadmap</span><span class="toc-page">12</span></li>
    <li><span class="toc-left"><span class="toc-num">07</span>Erwartete Wirkung</span><span class="toc-page">13</span></li>
    <li><span class="toc-left"><span class="toc-num">08</span>Investition & Pakete</span><span class="toc-page">14</span></li>
    <li><span class="toc-left"><span class="toc-num">09</span>Zusammenarbeit & nächste Schritte</span><span class="toc-page">16</span></li>
    <li><span class="toc-left"><span class="toc-num">10</span>Über EmotionFrame</span><span class="toc-page">18</span></li>
</ul>

<!-- ═════════════════════════════════════ 01 VORWORT ═════════════════════════════════════ -->
<div class="section-block">
    <div class="section-header">
        <div class="section-num">01</div>
        <h1 class="section-title">Vorwort</h1>
    </div>

    <p class="lead"><strong>{CLIENT['name']}</strong> hat sich in den letzten Jahren als spezialisierter Anbieter für Sanitär-Vorfabrikation und Montage in der Deutschschweiz etabliert. Der Auftritt online spiegelt diese Position noch nicht in voller Breite wider — <span class="accent">genau hier setzen wir an.</span></p>

    <p>Dieses Dokument ist keine allgemeine SEO-Checkliste. Wir haben die Situation von {CLIENT['name']} konkret analysiert: das Wettbewerbsumfeld, die aktuellen Rankings, die Zielgruppen und die Chancen, die in dieser Nische ungenutzt liegen. Daraus entstand die Strategie auf den folgenden Seiten.</p>

    <p>Der Bericht ist bewusst so aufgebaut, dass Sie ihn ohne Vorwissen verstehen — jede Fachpassage ist eingebettet in den geschäftlichen Kontext. Unser Ziel ist Transparenz vor Impressionismus: Sie sollen nicht nur wissen <em>was</em> wir tun, sondern <em>warum</em>.</p>

    <div class="kpi-row">
        <div class="kpi">
            <div class="kpi-value">~10</div>
            <div class="kpi-label">Direkte Wettbewerber<br>in der Schweiz</div>
        </div>
        <div class="kpi">
            <div class="kpi-value">78</div>
            <div class="kpi-label">Grundlagen-Score<br>(technisches Fundament)</div>
        </div>
        <div class="kpi">
            <div class="kpi-value">3 – 6</div>
            <div class="kpi-label">Monate bis<br>messbare Ergebnisse</div>
        </div>
        <div class="kpi">
            <div class="kpi-value">6 – 10×</div>
            <div class="kpi-label">Erwartetes Wachstum<br>organischer Sichtbarkeit</div>
        </div>
    </div>

    <h2>Die Kurzfassung</h2>
    <p>Ihre Website hat ein solides technisches Fundament. Was fehlt, ist die inhaltliche und kommunikative Bespielung: <strong>Sie werden von den falschen Suchbegriffen gefunden und von den richtigen nicht.</strong> In einem Marktumfeld mit begrenzter Konkurrenz sind das gute Nachrichten — die Nische ist mit einer strukturierten Strategie in 6 bis 12 Monaten erobert-bar.</p>

    <p>Auf den nächsten Seiten zeigen wir Ihnen erstens wo Sie stehen, zweitens welche Chancen konkret vorhanden sind, drittens wie unsere Strategie diese Chancen adressiert, und viertens welche Investition dafür realistisch ist.</p>
</div>

<!-- ═════════════════════════════════════ 02 AUSGANGSLAGE ═════════════════════════════════════ -->
<div class="section-block">
    <div class="section-header">
        <div class="section-num">02</div>
        <h1 class="section-title">Ausgangslage & aktuelle Sichtbarkeit</h1>
    </div>

    <p class="lead">Bevor wir über Wachstum sprechen, halten wir fest, wo Sie heute stehen. Nach dem technischen Fundament-Update erreicht Ihre Website einen Grundlagen-Score von <strong>78 von 100</strong>. Das heisst: die Basis stimmt, die inhaltliche Aufwertung ist der nächste logische Schritt.</p>

    <div class="grid-2">
        <div>
            <h3>Grundlagen-Score</h3>
            <div class="chart">
                <img src="{CHARTS['score']}" alt="SEO Grundlagen-Score">
            </div>
            <p style="font-size:9pt;color:#6B6B6B;">Bewertet werden sieben Dimensionen: Technik, Content, On-Page, strukturierte Daten, Performance, AI-Search-Bereitschaft und Bildoptimierung.</p>
        </div>
        <div>
            <h3>Was bereits funktioniert</h3>
            <ul class="clean">
                <li>Suchmaschinen-freundliches technisches Setup</li>
                <li>Mobile Darstellung optimiert und schnell</li>
                <li>DSGVO-konform (Cookie-Consent, IP-Anonymisierung)</li>
                <li>Verifiziert in Google Search Console</li>
                <li>Einträge auf Schweizer Directories (search.ch, local.ch)</li>
                <li>Klare URL-Struktur, saubere Weiterleitungen</li>
            </ul>
        </div>
    </div>

    <h2>Aktuelle Sichtbarkeit in Google</h2>

    <p>{CLIENT['name']} wird für einige generische Begriffe bereits gefunden, aber selten in Positionen, die für {CLIENT['industry']} zu Aufträgen führen. Konkret:</p>

    <table>
        <thead>
            <tr>
                <th style="width:48%;">Suchbegriff</th>
                <th style="width:18%;">Suchvolumen / Monat</th>
                <th style="width:14%;">Position</th>
                <th style="width:20%;">Bewertung</th>
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
        <p>Sie sind für einen Kernbegriff gut sichtbar, aber verpassen fünf weitere Themen, wo Sie fachlich stark sind. Das ist typisch für Firmen, die noch nie mit SEO gearbeitet haben — und es ist gleichzeitig die grösste Chance im ganzen Projekt.</p>
    </div>
</div>

<!-- ═════════════════════════════════════ 03 MARKTUMFELD ═════════════════════════════════════ -->
<div class="section-block">
    <div class="section-header">
        <div class="section-num">03</div>
        <h1 class="section-title">Marktumfeld und Wettbewerb</h1>
    </div>

    <p class="lead">Für den Zielmarkt <strong>Schweiz</strong> haben wir die Wettbewerber analysiert. Die Nische ist übersichtlich: rund zehn Anbieter konkurrieren um die gleichen Suchbegriffe. <span class="accent">Kein Wettbewerber dominiert alle Themen.</span></p>

    <h3>Sichtbarkeits-Index — die relevantesten Wettbewerber</h3>
    <div class="chart">
        <img src="{CHARTS['competitors']}" alt="Wettbewerbs-Sichtbarkeit im Vergleich">
        <div class="chart-caption">Index basiert auf Ranking-Positionen, Domain-Autorität, Content-Umfang und Local-SEO-Signalen · Quelle: EmotionFrame-Analyse {TODAY}</div>
    </div>

    <h2>Vier Beobachtungen</h2>
    <div class="grid-2">
        <div class="card">
            <h4>Geberit setzt den Rahmen</h4>
            <p>Als Hersteller dominiert Geberit die Brand-Suche. Als Installations-Partner konkurrieren Sie nicht direkt, sondern positionieren sich als lokaler, kompetenter Umsetzer.</p>
        </div>
        <div class="card">
            <h4>Engel und Spaeter sind Referenzen</h4>
            <p>Beide haben klare Landing-Pages für ihre Kernthemen. Ihr strategisches Vorbild: fokussierte Inhalte statt breite Übersichten.</p>
        </div>
        <div class="card">
            <h4>Niemand dominiert AI-Search</h4>
            <p>In Antworten von ChatGPT und Google AI Overviews ist die gesamte Nische noch fast leer. Ein früher Auftritt bringt strukturellen Vorteil.</p>
        </div>
        <div class="card">
            <h4>Local SEO wird unterschätzt</h4>
            <p>Nur wenige Wettbewerber pflegen Google Business Profile aktiv. Für die geografische Positionierung ein grosses ungenutztes Feld.</p>
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

    <h3>Cluster 1 — Materialspezifische Themen</h3>
    <p>Suchanfragen wie „AquaPanel Nasszelle", „Beplankung Sanitär" oder „Aussparungsplan Sanitär" haben moderates Volumen aber praktisch keine Fachkonkurrenz. Nur Herstellerseiten ranken hier. Mit fundierten Landing-Pages ist Position 1 – 3 in drei bis vier Monaten realistisch.</p>

    <h3>Cluster 2 — Geografische Kombinationen</h3>
    <p>„Sanitär Vorfabrikation Zürich", „GIS-Elemente Zentralschweiz", „Sanitärmodule Ostschweiz" — regionale Long-Tails, die von Ihrer Konkurrenz kaum bespielt werden. Diese Anfragen kommen von Bauleitern in konkreten Projekten mit klarer Kaufabsicht.</p>

    <h3>Cluster 3 — Zielgruppen-spezifische Fragen</h3>
    <p>„Vorfabrikation für Generalunternehmen", „Sanitärplanung für Architekten", „Terminvorteil Vorfabrikation" — Anfragen mit klarer Perspektive. Wer so sucht, ist wahrscheinlich in Vergabe-Prozessen involviert.</p>

    <h3>Cluster 4 — AI-Search & Generative Answers</h3>
    <p>ChatGPT, Perplexity und Google AI Overviews werden zunehmend als Erst-Recherche genutzt. Wenn Ihre Inhalte hier zitiert werden, gewinnen Sie Präsenz bei Entscheidern, die traditionelle Suchmaschinen kaum noch nutzen. Diese Positionierung ist heute noch offen — <strong>morgen ist sie besetzt.</strong></p>

    <div class="callout">
        <div class="callout-title">Warum jetzt der richtige Moment ist</div>
        <p>In stärker umkämpften Branchen sind SEO-Investitionen ein Marathon gegen etablierte Grössen. In der Sanitär-Vorfabrikations-Nische sind die Positionen noch weitgehend frei. Wer jetzt startet, sichert sich Rankings für die nächsten Jahre.</p>
    </div>
</div>

<!-- ═════════════════════════════════════ 05 STRATEGIE ═════════════════════════════════════ -->
<div class="section-block">
    <div class="section-header">
        <div class="section-num">05</div>
        <h1 class="section-title">Unsere Strategie</h1>
    </div>

    <p class="lead">Wir arbeiten mit fünf strategischen Handlungsfeldern. Die Prozent-Angaben zeigen, wie sich unser monatlicher Arbeitsaufwand über diese fünf Felder verteilt.</p>

    <div class="chart">
        <img src="{CHARTS['pillars']}" alt="Fünf Handlungsfelder mit Zeitanteil">
    </div>

    <h2>1 · Content-Strategie & Redaktion <span class="accent">— 24 %</span></h2>
    <p>Wir schreiben Fachinhalte, die für Ihre Zielgruppen relevant sind: Landing-Pages pro Leistung, ein aktivierter Blog mit Fachartikeln, dedizierte Anwendungsfälle. Ziel: Positionen für Long-Tail-Suchen erobern und Fachkompetenz sichtbar machen.</p>

    <h2>2 · Local SEO & Reputation <span class="accent">— 22 %</span></h2>
    <p>Google Business Profile aktiv pflegen, Kunden-Reviews systematisch generieren, NAP-Konsistenz über Directories sichern. Ziel: Präsenz im Google Maps Local Pack und in geografisch angereicherten Suchen.</p>

    <h2>3 · Autorität & Backlinks <span class="accent">— 20 %</span></h2>
    <p>Verlinkungen von Fachverbänden (suissetec, VSSH), Partnern (Architekten, Generalunternehmer), Baustellen-Reportagen. Ziel: Domain-Autorität erhöhen, damit auch schwierigere Rankings erreichbar werden.</p>

    <h2>4 · AI Search Optimierung <span class="accent">— 18 %</span></h2>
    <p>Strukturierte Q&A-Blöcke, FAQ-Schemas, klare faktische Inhalte, die von ChatGPT, Perplexity und Google AI Overviews zitiert werden können. Ziel: In generativen Antworten mitgenannt werden.</p>

    <h2>5 · Monitoring & Iteration <span class="accent">— 16 %</span></h2>
    <p>Regelmässige Auswertung von Search Console, Analytics, Rank-Tracking. Erkennung von Chancen und Regressionen. Monatliches Reporting an Sie mit konkreten Handlungs-Empfehlungen.</p>

    <div class="callout">
        <div class="callout-title">Was diese Aufteilung bewusst nicht enthält</div>
        <p>Keine bezahlte Werbung (Google Ads), keine Social-Media-Kampagnen, keine Video-Produktion. Diese Kanäle können ergänzend sinnvoll sein — aber die organische Sichtbarkeit über Google ist für Ihre B2B-Zielgruppe der Kanal mit dem besten Kosten-Nutzen-Verhältnis.</p>
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
        <li><strong>Ende Monat 3</strong> — Erste neue Rankings erscheinen (Long-Tail), erste Reviews eingegangen, zwei bis drei Fachartikel publiziert</li>
        <li><strong>Ende Monat 6</strong> — Blog etabliert (acht Artikel), Backlink-Aufbau in aktiver Phase, messbarer Anstieg der Suchanfragen</li>
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
        <div class="chart-caption">Das konservative Szenario basiert auf durchschnittlichen Resultaten vergleichbarer B2B-Projekte in der Schweiz. Der Statusquo-Pfad zeigt, was passiert wenn nichts unternommen wird.</div>
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
                <td><strong>Monat 1 – 3</strong></td>
                <td>Erste Bewegung in Search Console. Neue Impressionen aber wenig Klicks.</td>
                <td>Fundamente werden gelegt. Noch keine spürbare Anfragen-Steigerung.</td>
            </tr>
            <tr>
                <td><strong>Monat 3 – 6</strong></td>
                <td>Erste neue Rankings. Klicks aus organischer Suche steigen um Faktor 1,5 – 2.</td>
                <td>Erste zusätzliche Anfragen aus SEO. Direkt zurechen-bar.</td>
            </tr>
            <tr>
                <td><strong>Monat 6 – 12</strong></td>
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
        <p>SEO ist keine Schalter-Umlegung. Sie werden im ersten Monat wenig Konkretes sehen — technische Basis wird gelegt. Google braucht Zeit um Änderungen zu bewerten. Erst ab Monat 3 wird es messbar spannend. Wer garantierte Rankings verspricht, ist unseriös. Wir garantieren stattdessen: konkrete Umsetzung, transparentes Reporting, klare KPIs.</p>
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
                <li>Übergabe-Report + Beratung (1 h)</li>
                <li>Danach eigenständige Umsetzung</li>
            </ul>
        </div>
        <div class="package featured">
            <div class="package-name">Solid</div>
            <div class="package-price">CHF 1'400 <small>/Monat</small></div>
            <div class="package-setup">Setup CHF 4'500 einmalig · 6 Monate Mindestlaufzeit</div>
            <ul class="package-features">
                <li>Alles aus Basis</li>
                <li>Vier Fachartikel im Setup</li>
                <li>Schema.org Erweiterung</li>
                <li>Rank-Tracking für 25 Keywords</li>
                <li>Ein neuer Beitrag pro Monat</li>
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
                <li>Zwei Backlinks pro Monat aktiv</li>
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
    <p>Externe Kosten (Werkzeug-Lizenzen, sofern nicht in unseren Paketen berücksichtigt), grafische Neuentwürfe, Video- und Fotografie-Produktion, Website-Umbauten die über SEO-Optimierung hinausgehen. Solche Themen besprechen wir bei Bedarf separat.</p>
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

    <h2>Woche 1 – 4 — Setup-Phase</h2>
    <ul class="clean">
        <li>Vollständiges technisches Onboarding aller Tools und Tracking-Systeme</li>
        <li>Erste Landing-Pages und Content-Erweiterungen live</li>
        <li>Google Business Profile aktiv, erste Fotos und Kategorien gesetzt</li>
        <li>Rank-Tracking für alle Ziel-Keywords eingerichtet</li>
        <li>Kurzes Status-Update nach zwei Wochen</li>
    </ul>

    <h2>Ab Monat 2 — Regelbetrieb</h2>
    <ul class="clean">
        <li>Monatliches Reporting: zwei Seiten PDF, klare Zahlen, konkrete nächste Schritte</li>
        <li>Ein neuer Fachartikel oder eine neue Landing-Page pro Monat</li>
        <li>Kontinuierliche Optimierung basierend auf Search-Console-Daten</li>
        <li>Bei Bedarf: telefonisches Update, keine Zusatzkosten für kurze Fragen</li>
    </ul>

    <h2>Was wir von Ihnen brauchen</h2>
    <ul>
        <li><strong>Zugänge freigeben</strong> (siehe Woche 0)</li>
        <li><strong>Fachliches Sparring</strong> — wir müssen nicht Sanitär-Experten werden, aber Ihre Expertise brauchen wir für glaubwürdige Inhalte. Rechnen Sie mit rund einer Stunde Ihrer Zeit pro Monat.</li>
        <li><strong>Projekt-Freigaben</strong> für Referenzen — welche Objekte dürfen wir öffentlich nennen und welche nicht</li>
        <li><strong>Aktive Kunden-Akquise für Reviews</strong> — nach Projektabschluss die Nachfrage nach einer Google-Bewertung ist Ihr Job (wir liefern Vorlagen und Prozess)</li>
    </ul>
</div>

<!-- ═════════════════════════════════════ 10 ÜBER UNS ═════════════════════════════════════ -->
<div class="section-block">
    <div class="section-header">
        <div class="section-num">10</div>
        <h1 class="section-title">Über EmotionFrame</h1>
    </div>

    <p class="lead">Wir sind <strong>EmotionFrame</strong> — ein Kreativstudio aus Niederrohrdorf im Aargau. Familienunternehmen, inhabergeführt. Wer Ihr Projekt übernimmt, bleibt auch dabei.</p>

    <div class="grid-2">
        <div>
            <h3>Unser Ansatz</h3>
            <p>Wir bevorzugen Klartext gegenüber Buzzwords, faktische Belege gegenüber Marketing-Versprechen, und ein Reporting, das Sie in fünf Minuten versteht.</p>
            <p>SEO ist ein Handwerk. Es gibt keine Abkürzungen, keine Zauberei, keine Rankings-Garantien. Was es gibt: strukturiertes Arbeiten, Datenbasis, Iteration. Genau das liefern wir.</p>
        </div>
        <div>
            <h3>Warum wir zu {CLIENT['name']} passen</h3>
            <p>Wir kennen Ihre Website bereits im Detail — wir haben sie mit aufgebaut. Damit sparen Sie sich die Onboarding-Phase, in der eine externe Agentur zuerst verstehen muss, wie Ihre Website funktioniert.</p>
            <p>Sie erreichen uns direkt, ohne Account-Manager-Zwischenschicht. Änderungen an der Website setzen wir selbst um — kein Wartungs-Ping-Pong mit externen Entwicklern.</p>
        </div>
    </div>

    <div class="contact-block">
        <img src="{LOGO_DARK}" alt="EmotionFrame" style="height:38pt;width:auto;display:block;margin-bottom:14pt;">
        <div class="kicker" style="background:linear-gradient(90deg,#68DAC8 0%,#7C6BE8 100%);-webkit-background-clip:text;background-clip:text;color:transparent;">— Kontakt</div>
        <h2>Sagen Sie kurz Hallo.</h2>
        <p style="color:rgba(255,255,255,0.75);font-size:11pt;margin-bottom:16pt;">Wir freuen uns auf Ihre Rückmeldung. Idealerweise vereinbaren wir einen kurzen Termin zur Klärung offener Fragen — dann können wir mit dem Vertrag und dem Kickoff starten.</p>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16pt;font-size:10pt;color:rgba(255,255,255,0.85);">
            <div>
                <div class="kicker" style="color:rgba(255,255,255,0.4);font-size:7.5pt;background:none;-webkit-background-clip:initial;background-clip:initial;">Adresse</div>
                <div style="color:#fff;font-weight:500;">{AGENCY['company']}<br>{AGENCY['address']}</div>
            </div>
            <div>
                <div class="kicker" style="color:rgba(255,255,255,0.4);font-size:7.5pt;background:none;-webkit-background-clip:initial;background-clip:initial;">Kontakt</div>
                <div style="color:#fff;font-weight:500;">
                    <a href="mailto:{AGENCY['email']}">{AGENCY['email']}</a><br>
                    <a href="https://{AGENCY['url']}">{AGENCY['url']}</a>
                </div>
            </div>
        </div>
    </div>

    <p style="margin-top:24pt;font-size:8pt;color:#A8A29E;text-align:center;letter-spacing:0.1em;">
        Dieses Dokument wurde erstellt am {TODAY} für {CLIENT['name']}. Vertraulich. Version 2.0.
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

chromium = "/opt/pw-browsers/chromium-1194/chrome-linux/chrome"
r = subprocess.run(
    [
        chromium,
        "--headless",
        "--no-sandbox",
        "--disable-gpu",
        "--print-to-pdf-no-header",
        f"--print-to-pdf={pdf_file}",
        f"file://{html_file.absolute()}",
    ],
    capture_output=True, text=True, timeout=120,
)

if pdf_file.exists() and pdf_file.stat().st_size > 100000:
    print(f"✓ Erstellt: {pdf_file} ({pdf_file.stat().st_size // 1024} KB)")
    html_file.unlink(missing_ok=True)
else:
    print("stderr:", r.stderr[-500:])
    raise RuntimeError("PDF konnte nicht erstellt werden")
