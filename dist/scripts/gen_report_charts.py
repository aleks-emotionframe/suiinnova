#!/usr/bin/env python3
"""
Chart-Generierung fuer den SEO-Report — SUI Innova GmbH.
Alle Charts werden als PNG (transparent) mit einheitlichem Design gespeichert.
"""

import matplotlib
matplotlib.use("Agg")
import matplotlib.pyplot as plt
import matplotlib.patches as mpatches
from matplotlib.patches import FancyBboxPatch, Rectangle, Wedge
import numpy as np
from pathlib import Path

OUT = Path("/home/user/suiinnova/audit-sui-innova/report-charts")
OUT.mkdir(parents=True, exist_ok=True)

# Emotionframe Farb-Palette
EMOTION_BLACK = "#0A0A0A"
EMOTION_GREY = "#262626"
EMOTION_LIGHT = "#F5F5F5"
EMOTION_MID = "#9CA3AF"
EMOTION_ACCENT = "#F97316"  # warmer orange
CLIENT_RED = "#C41018"  # SUI Innova red
SUCCESS_GREEN = "#059669"
WARNING_AMBER = "#F59E0B"
DANGER_RED = "#DC2626"

# Font-Konfiguration
plt.rcParams["font.family"] = "sans-serif"
plt.rcParams["font.sans-serif"] = ["Inter", "Helvetica Neue", "Arial", "DejaVu Sans"]
plt.rcParams["axes.edgecolor"] = EMOTION_GREY
plt.rcParams["axes.labelcolor"] = EMOTION_BLACK
plt.rcParams["xtick.color"] = EMOTION_GREY
plt.rcParams["ytick.color"] = EMOTION_GREY

# ─────────────────────────────────────────────────
# 1) SEO Health Score Gauge (Halbkreis)
# ─────────────────────────────────────────────────
def chart_health_score(score: int, out: str):
    fig, ax = plt.subplots(figsize=(6, 3.5), dpi=200)
    ax.set_aspect("equal")

    # Halbkreis-Segmente
    segments = [
        (0, 40, "#FEE2E2"),
        (40, 70, "#FEF3C7"),
        (70, 100, "#D1FAE5"),
    ]
    for start, end, color in segments:
        theta1 = 180 - (end / 100 * 180)
        theta2 = 180 - (start / 100 * 180)
        w = Wedge(center=(0, 0), r=1.0, theta1=theta1, theta2=theta2,
                  width=0.28, facecolor=color, edgecolor="none")
        ax.add_patch(w)

    # Zeiger
    angle = 180 - (score / 100 * 180)
    x = 0.72 * np.cos(np.radians(angle))
    y = 0.72 * np.sin(np.radians(angle))
    ax.plot([0, x], [0, y], color=EMOTION_BLACK, linewidth=3, solid_capstyle="round", zorder=5)
    ax.add_patch(plt.Circle((0, 0), 0.06, color=EMOTION_BLACK, zorder=6))

    # Score-Zahl
    ax.text(0, -0.15, str(score), fontsize=42, fontweight="900",
            ha="center", va="center", color=EMOTION_BLACK)
    ax.text(0, -0.38, "von 100", fontsize=10, ha="center", va="center",
            color=EMOTION_MID, fontweight="500")

    # Skalen-Marker
    for val in [0, 40, 70, 100]:
        a = 180 - (val / 100 * 180)
        rx = 1.05 * np.cos(np.radians(a))
        ry = 1.05 * np.sin(np.radians(a))
        ax.text(rx, ry, str(val), fontsize=8, ha="center", va="center",
                color=EMOTION_GREY, fontweight="500")

    ax.set_xlim(-1.25, 1.25)
    ax.set_ylim(-0.55, 1.25)
    ax.axis("off")
    plt.tight_layout()
    plt.savefig(out, transparent=True, bbox_inches="tight", pad_inches=0.05)
    plt.close()


# ─────────────────────────────────────────────────
# 2) Sichtbarkeits-Vergleich Konkurrenz
# ─────────────────────────────────────────────────
def chart_competitor_visibility(out: str):
    competitors = [
        ("Geberit", 95),
        ("Engel", 62),
        ("Spaeter Vorfabrikation", 55),
        ("PE Fabrikation", 48),
        ("Gämperle", 42),
        ("Sanitub", 40),
        ("Element Fabrikation", 38),
        ("Sanitär Oberholzer", 32),
        ("SUI Innova", 28),
    ]

    fig, ax = plt.subplots(figsize=(10, 5.5), dpi=200)

    names = [c[0] for c in competitors]
    scores = [c[1] for c in competitors]
    colors = [CLIENT_RED if n == "SUI Innova" else EMOTION_GREY for n in names]
    alphas = [1.0 if n == "SUI Innova" else 0.5 for n in names]

    y_pos = np.arange(len(names))
    bars = ax.barh(y_pos, scores, color=colors, alpha=None, height=0.65,
                   edgecolor="none")
    for bar, alpha in zip(bars, alphas):
        bar.set_alpha(alpha)

    for i, (score, name) in enumerate(zip(scores, names)):
        weight = "800" if name == "SUI Innova" else "500"
        ax.text(score + 1.5, i, str(score), va="center", fontsize=9,
                color=CLIENT_RED if name == "SUI Innova" else EMOTION_GREY,
                fontweight=weight)

    ax.set_yticks(y_pos)
    ax.set_yticklabels(names, fontsize=10)
    for label, name in zip(ax.get_yticklabels(), names):
        if name == "SUI Innova":
            label.set_fontweight("800")
            label.set_color(CLIENT_RED)

    ax.set_xlim(0, 105)
    ax.set_xlabel("Sichtbarkeits-Index (0-100)", fontsize=9, color=EMOTION_GREY, labelpad=10)
    ax.invert_yaxis()
    ax.spines["top"].set_visible(False)
    ax.spines["right"].set_visible(False)
    ax.spines["left"].set_visible(False)
    ax.tick_params(left=False)
    ax.grid(axis="x", linestyle=":", alpha=0.35, color=EMOTION_MID)
    ax.set_axisbelow(True)

    plt.tight_layout()
    plt.savefig(out, transparent=True, bbox_inches="tight", pad_inches=0.05)
    plt.close()


# ─────────────────────────────────────────────────
# 3) Keyword-Opportunity Bubble Chart
# ─────────────────────────────────────────────────
def chart_keyword_opportunities(out: str):
    # (Keyword, Suchvolumen/Monat, Wettbewerbs-Härte 1-10, Opportunity-Score)
    keywords = [
        ("Sanitär Vorfabrikation Schweiz", 250, 5, 90),
        ("GIS Vorfabrikation", 180, 6, 75),
        ("AquaPanel Nasszelle", 80, 2, 95),
        ("Vorwandsystem Montage", 150, 5, 80),
        ("Sanitär Beplankung", 90, 3, 88),
        ("GIS-Element Werkstatt", 60, 3, 85),
        ("Sanitärvorfabrikation Zürich", 110, 4, 82),
        ("Aussparungsplan Sanitär", 40, 2, 78),
        ("Fertig-Sanitärmodule", 70, 3, 80),
    ]

    fig, ax = plt.subplots(figsize=(10, 6), dpi=200)

    for kw, vol, comp, opp in keywords:
        # Größere Opportunity = größere Bubble
        size = opp * 15
        color = SUCCESS_GREEN if opp >= 85 else (WARNING_AMBER if opp >= 75 else EMOTION_MID)
        alpha = 0.65
        ax.scatter(vol, comp, s=size, c=color, alpha=alpha, edgecolors="white",
                   linewidths=2, zorder=3)
        # Label
        offset_y = 0.35
        ax.annotate(kw, xy=(vol, comp), xytext=(vol, comp - offset_y),
                    ha="center", va="top", fontsize=8, color=EMOTION_GREY,
                    fontweight="500", zorder=4)

    ax.set_xlabel("Suchanfragen pro Monat (Schätzung)", fontsize=9, color=EMOTION_GREY, labelpad=12)
    ax.set_ylabel("Wettbewerbs-Härte (1 = einfach, 10 = extrem hart)",
                  fontsize=9, color=EMOTION_GREY, labelpad=12)
    ax.set_xlim(0, 310)
    ax.set_ylim(0, 8)
    ax.spines["top"].set_visible(False)
    ax.spines["right"].set_visible(False)
    ax.grid(True, linestyle=":", alpha=0.35, color=EMOTION_MID)
    ax.set_axisbelow(True)

    # Legende
    from matplotlib.lines import Line2D
    legend_elements = [
        Line2D([0], [0], marker="o", color="w", label="Sehr hohes Potenzial",
               markerfacecolor=SUCCESS_GREEN, markersize=13, alpha=0.65),
        Line2D([0], [0], marker="o", color="w", label="Hohes Potenzial",
               markerfacecolor=WARNING_AMBER, markersize=13, alpha=0.65),
        Line2D([0], [0], marker="o", color="w", label="Mittleres Potenzial",
               markerfacecolor=EMOTION_MID, markersize=13, alpha=0.65),
    ]
    ax.legend(handles=legend_elements, loc="upper right", frameon=False,
              fontsize=8, labelcolor=EMOTION_GREY)

    plt.tight_layout()
    plt.savefig(out, transparent=True, bbox_inches="tight", pad_inches=0.05)
    plt.close()


# ─────────────────────────────────────────────────
# 4) 12-Monats Roadmap Timeline
# ─────────────────────────────────────────────────
def chart_roadmap(out: str):
    fig, ax = plt.subplots(figsize=(11, 4.5), dpi=200)

    phases = [
        ("Fundament\n& Setup",       0,  1,  EMOTION_ACCENT,  "GBP · GA4 · Rank-Tracking\nInitiale Content-Struktur"),
        ("Sichtbarkeits-\nStart",     1,  3,  "#EA580C",       "Landing-Pages · FAQ-Schema\nErste Reviews · Local Signals"),
        ("Content-\nOffensive",       3,  6,  "#DC2626",       "Blog live · 8 Fachartikel\nBacklink-Outreach startet"),
        ("Skalierung",                6,  9,  CLIENT_RED,      "Long-Tail dominieren · SXO\nAI-Search-Sichtbarkeit"),
        ("Reifephase",                9,  12, "#7F1D1D",       "Konvertierungs-Optimierung\nSystematischer Wachstumspfad"),
    ]

    y_pos = 0.5
    for i, (name, start, end, color, desc) in enumerate(phases):
        # Balken
        rect = Rectangle((start, y_pos - 0.15), end - start, 0.3,
                         facecolor=color, edgecolor="white", linewidth=2)
        ax.add_patch(rect)

        # Phasen-Titel (auf dem Balken)
        ax.text((start + end) / 2, y_pos, name, ha="center", va="center",
                color="white", fontsize=9, fontweight="800")

        # Beschreibung (unter dem Balken)
        ax.text((start + end) / 2, y_pos - 0.4, desc, ha="center", va="top",
                color=EMOTION_GREY, fontsize=7.5, fontweight="500",
                linespacing=1.4)

    # Monats-Achse
    for m in range(0, 13):
        ax.plot([m, m], [y_pos - 0.15, y_pos - 0.22], color=EMOTION_MID, linewidth=0.5)
        ax.text(m, y_pos + 0.30, f"Monat {m}" if m in [0, 3, 6, 9, 12] else "",
                ha="center", va="bottom", fontsize=8, color=EMOTION_MID,
                fontweight="500")

    ax.set_xlim(-0.3, 12.3)
    ax.set_ylim(-0.5, 1.0)
    ax.axis("off")

    plt.tight_layout()
    plt.savefig(out, transparent=True, bbox_inches="tight", pad_inches=0.05)
    plt.close()


# ─────────────────────────────────────────────────
# 5) Traffic-Projektion 12 Monate
# ─────────────────────────────────────────────────
def chart_traffic_projection(out: str):
    fig, ax = plt.subplots(figsize=(10, 5), dpi=200)

    months = np.arange(0, 13)
    baseline = np.array([100, 105, 110, 115, 118, 120, 122, 125, 128, 130, 132, 135, 138])
    conservative = np.array([100, 115, 145, 190, 240, 310, 380, 450, 520, 580, 640, 700, 770])
    optimistic = np.array([100, 130, 180, 250, 340, 450, 570, 700, 830, 950, 1080, 1220, 1380])

    ax.fill_between(months, conservative, optimistic, color=EMOTION_ACCENT, alpha=0.15,
                    label="Bandbreite")
    ax.plot(months, baseline, color=EMOTION_MID, linewidth=2, linestyle=":",
            label="Ohne SEO (Status quo)")
    ax.plot(months, conservative, color=EMOTION_ACCENT, linewidth=2.5,
            label="Konservativ (Basisannahmen)", marker="o", markersize=4)
    ax.plot(months, optimistic, color=CLIENT_RED, linewidth=2.5,
            label="Optimistisch (bei sauberer Umsetzung)", marker="o", markersize=4)

    ax.set_xlabel("Monate ab Kampagnenstart", fontsize=9, color=EMOTION_GREY, labelpad=10)
    ax.set_ylabel("Organische Besucher (Index: Start = 100)", fontsize=9,
                  color=EMOTION_GREY, labelpad=10)
    ax.set_xlim(0, 12)
    ax.set_xticks(range(0, 13))
    ax.spines["top"].set_visible(False)
    ax.spines["right"].set_visible(False)
    ax.grid(True, linestyle=":", alpha=0.35, color=EMOTION_MID)
    ax.set_axisbelow(True)
    ax.legend(loc="upper left", frameon=False, fontsize=9, labelcolor=EMOTION_GREY)

    plt.tight_layout()
    plt.savefig(out, transparent=True, bbox_inches="tight", pad_inches=0.05)
    plt.close()


# ─────────────────────────────────────────────────
# 6) Handlungsfelder Übersicht (5 Säulen)
# ─────────────────────────────────────────────────
def chart_pillars(out: str):
    fig, ax = plt.subplots(figsize=(11, 4), dpi=200)

    pillars = [
        ("Content-Strategie",           "24%", CLIENT_RED),
        ("Local SEO &\nReputation",      "22%", "#9F0712"),
        ("Autorität &\nBacklinks",       "20%", "#7F1D1D"),
        ("AI Search\nOptimierung",       "18%", "#EA580C"),
        ("Monitoring &\nIteration",      "16%", EMOTION_ACCENT),
    ]

    x_positions = np.arange(len(pillars))
    for i, (name, pct, color) in enumerate(pillars):
        h = int(pct.replace("%", "")) / 100 * 3
        rect = Rectangle((i - 0.4, 0), 0.8, h, facecolor=color, edgecolor="none")
        ax.add_patch(rect)
        # Prozent-Label auf dem Balken
        ax.text(i, h - 0.25, pct, ha="center", va="top", color="white",
                fontweight="800", fontsize=13)
        # Name unter dem Balken
        ax.text(i, -0.15, name, ha="center", va="top", color=EMOTION_BLACK,
                fontweight="700", fontsize=10, linespacing=1.3)

    ax.set_xlim(-0.7, len(pillars) - 0.3)
    ax.set_ylim(-1.0, 3.3)
    ax.axis("off")

    plt.tight_layout()
    plt.savefig(out, transparent=True, bbox_inches="tight", pad_inches=0.05)
    plt.close()


# ─────────────────────────────────────────────────
# Alle Charts generieren
# ─────────────────────────────────────────────────
if __name__ == "__main__":
    chart_health_score(78, str(OUT / "01_health_score.png"))
    chart_competitor_visibility(str(OUT / "02_competitors.png"))
    chart_keyword_opportunities(str(OUT / "03_keywords.png"))
    chart_roadmap(str(OUT / "04_roadmap.png"))
    chart_traffic_projection(str(OUT / "05_traffic.png"))
    chart_pillars(str(OUT / "06_pillars.png"))
    print("✓ 6 Charts erstellt in", OUT)
