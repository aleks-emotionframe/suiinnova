<?php
/**
 * Vorschau der neuen Keyword-Seiten als eine HTML-Datei
 *
 * Rendert die echten Section-Templates mit den Inhalten aus der erzeugten
 * SQL — ohne Datenbank, ohne Hostpoint, ohne dass irgendetwas live geht.
 * Gedacht zum Gegenlesen, bevor hochgeladen wird.
 *
 * Aufruf: php dist/scripts/build_preview.php > dist/vorschau/index.html
 *
 * Wichtig: Jede Seite wird in einem EIGENEN PHP-Prozess gerendert. headingTag()
 * merkt sich pro Prozess, ob das h1 schon vergeben ist — im Betrieb ist das
 * ein Seitenaufruf, hier waeren es sonst sechs Seiten mit einem einzigen h1.
 * Der Unterprozess-Aufruf bildet also genau die Wirklichkeit ab.
 */

$root = dirname(__DIR__, 2);

// ── Minimale Umgebung, damit die Templates laufen ──────────────
define('BASE_PATH', $root);
define('SITE_URL', 'https://sui-innova.ch');
define('UPLOADS_URL', 'https://sui-innova.ch/uploads');
define('SITE_NAME', 'SUI Innova GmbH');
define('IP_HASH_SALT', 'vorschau');

$settings = [];

require_once $root . '/core/helpers.php';

/** Bilder gibt es in der Vorschau nicht — Sektionen blenden sich selbst aus */
function getMediaStub(int $id): ?array { return null; }

/**
 * Ersatz fuer die Anmeldung. In der Vorschau ist niemand eingeloggt.
 * Die echte Funktion steht in core/auth.php, das hier nicht geladen wird.
 */
if (!function_exists('isLoggedIn')) {
    function isLoggedIn(): bool { return false; }
}

/**
 * Ersatz fuer die Datenbank.
 *
 * Nur getLivePageSlugs() fragt aus einer Sektionsvorlage heraus die
 * Datenbank ab: sie prueft, welche Zielseiten online sind. In der Vorschau
 * sollen alle Links sichtbar sein, auch die auf die noch nicht
 * freigeschalteten Seiten — sonst laege genau das nicht vor, was
 * gegengelesen werden soll.
 */
$db = new class {
    public function fetchAll(string $sql, array $params = []): array
    {
        return array_map(fn($s) => ['slug' => $s], $params);
    }
    public function fetch(string $sql, array $params = []): ?array { return null; }
};

// ── Inhalte laden ──────────────────────────────────────────────
//
// Erste Wahl ist dist/vorschau/daten.json. Die Datei schreibt der
// jeweils aktuelle Generator mit dem Aufruf "daten" und liefert Seiten
// und Sektionen fertig aufbereitet. Fehlt sie, faellt die Vorschau auf
// das alte Verfahren zurueck und liest die Inhalte aus der erzeugten
// SQL heraus.
$datenFile = $root . '/dist/vorschau/daten.json';
if (is_file($datenFile)) {
    $seiten = json_decode((string) file_get_contents($datenFile), true);
    if (!is_array($seiten) || !$seiten) {
        fwrite(STDERR, "dist/vorschau/daten.json ist leer oder kaputt.\n");
        exit(1);
    }
    goto gerendert;
}

$sqlFile = $root . '/dist/sql/seo-paket-3-keyword-seiten.sql';
if (!is_file($sqlFile)) {
    fwrite(STDERR, "SQL nicht gefunden. Erst build_keyword_pages.php laufen lassen.\n");
    exit(1);
}
$sql = file_get_contents($sqlFile);

// Seiten samt Metadaten
preg_match_all(
    "/-- \/([a-z-]+)\n-- ─.*?SELECT '([^']*)', '([a-z-]+)', '((?:[^']|'')*)', '((?:[^']|'')*)', 0, 0/s",
    $sql,
    $pageMatches,
    PREG_SET_ORDER
);

/** MySQL-Escaping rueckgaengig machen */
function unq(string $v): string
{
    return str_replace(["''", "\\\\"], ["'", "\\"], $v);
}

// Sektionen je Seite in Reihenfolge einsammeln
$blocks = preg_split('/-- ────────────────────────────────────────────────────────────\n-- \//', $sql);

$seiten = [];
foreach ($pageMatches as $i => $pm) {
    $slug = $pm[1];
    $sektionen = [];

    // Zum passenden Block springen und dessen Sektionen lesen
    foreach ($blocks as $b) {
        if (!str_starts_with($b, $slug . "\n")) continue;
        preg_match_all("/SELECT \@pid, '([a-z-]+)', '((?:[^']|'')*)', (\d+), 1/s", $b, $sm, PREG_SET_ORDER);
        foreach ($sm as $s) {
            $sektionen[] = ['type' => $s[1], 'content' => json_decode(unq($s[2]), true) ?: []];
        }
        break;
    }

    $seiten[] = [
        'slug'       => $slug,
        'nav_label'  => unq($pm[2]),
        'meta_title' => unq($pm[4]),
        'meta_desc'  => unq($pm[5]),
        'sektionen'  => $sektionen,
    ];
}

gerendert:

// ── Unterprozess-Modus: genau eine Seite rendern ───────────────
// Wird vom Hauptlauf pro Seite einmal aufgerufen, damit headingTag()
// je Seite frisch bei h1 beginnt — so wie bei einem echten Seitenaufruf.
if (isset($argv[1]) && $argv[1] === '--seite' && isset($argv[2])) {
    $idx = (int) $argv[2];
    if (!isset($seiten[$idx])) { exit(1); }
    foreach ($seiten[$idx]['sektionen'] as $sek) {
        echo renderOne($sek['type'], $sek['content'], $root);
    }
    exit;
}

// ── Rendern ────────────────────────────────────────────────────

/** Eine Sektion rendern, Fehler abfangen damit die Vorschau nicht abbricht */
function renderOne(string $type, array $content, string $root): string
{
    $file = $root . '/templates/sections/' . $type . '.php';
    if (!is_file($file)) return '';

    // Bild-Helfer stumm schalten: ohne DB gibt es keine Medien
    ob_start();
    try {
        include $file;
    } catch (Throwable $e) {
        ob_end_clean();
        return '<!-- Sektion ' . htmlspecialchars($type) . ' uebersprungen: '
             . htmlspecialchars($e->getMessage()) . ' -->';
    }
    return (string) ob_get_clean();
}

$css = file_get_contents($root . '/assets/css/style.css');

// Typografie-Variablen wie im echten Layout
$typo = <<<CSS
:root {
  --fs-h1: 64px; --fs-heading: 48px; --fs-subtitle: 18px;
  --fs-card-title: 24px; --fs-body: 16px; --fs-small: 14px;
}
.section-container { max-width: 112rem; padding-left: 1.5rem; padding-right: 1.5rem; margin: 0 auto; }
@media (min-width: 768px) { .section-container { padding-left: 2.5rem; padding-right: 2.5rem; } }
.section-heading { font-size: calc(var(--fs-heading) * 0.6); line-height: 1.15; letter-spacing: 0.02em; }
@media (min-width: 768px) { .section-heading { font-size: calc(var(--fs-heading) * 0.8); } }
@media (min-width: 1024px) { .section-heading { font-size: var(--fs-heading); line-height: 1.1; } }
.section-subtitle { font-size: var(--fs-subtitle); line-height: 1.7; max-width: 60rem; }
main .section p, main section p { font-size: var(--fs-body); line-height: 1.7; }
mark.angabe-fehlt {
  background: #FEF08A; color: #713F12; border-bottom: 2px solid #C41018;
  padding: 1px 5px; border-radius: 2px; font-style: italic;
}
mark.angabe-fehlt::before {
  content: "fehlt: "; font-weight: 700; font-style: normal; text-transform: uppercase;
  font-size: 0.8em; letter-spacing: 0.04em; color: #C41018;
}
CSS;

// Jede Seite vorab in einem eigenen Prozess rendern und die tatsaechlich
// markierten Stellen zaehlen. Die Zahl aus dem Keyword-Plan ($x['offen'])
// ist eine andere: sie zaehlt, was wir den Kunden fragen muessen, und fasst
// mehrere Textstellen zu einem Punkt zusammen. Im Korrekturlauf interessiert
// aber, wie oft im Text etwas gelb markiert ist.
foreach ($seiten as $i => $unused) {
    $cmd = escapeshellarg(PHP_BINARY) . ' ' . escapeshellarg(__FILE__) . ' --seite ' . (int) $i;
    $html = (string) shell_exec($cmd);
    $seiten[$i]['html']   = $html;
    $seiten[$i]['marken'] = substr_count($html, '<mark class="angabe-fehlt"');
    $seiten[$i]['woerter'] = str_word_count(strip_tags($html), 0, 'äöüÄÖÜßéèàç');
}

$gesamtMarken  = array_sum(array_map(fn($x) => $x['marken'], $seiten));
$gesamtWoerter = array_sum(array_map(fn($x) => $x['woerter'], $seiten));
$gesamtFaq   = 0;
foreach ($seiten as $s2) {
    foreach ($s2['sektionen'] as $sk) {
        if ($sk['type'] === 'faq') $gesamtFaq += count($sk['content']['items'] ?? []);
    }
}

$out = [];
$out[] = '<title>Korrekturlauf Keyword-Seiten</title>';
$out[] = '<link rel="preconnect" href="https://fonts.googleapis.com">';
$out[] = '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
$out[] = '<link rel="stylesheet" href="https://fonts.googleapis.com/css2?'
       . 'family=IBM+Plex+Mono:wght@400;500;600&'
       . 'family=IBM+Plex+Sans:wght@400;500;600;700&display=swap">';
$out[] = '<style>' . $css . "\n" . $typo . "\n" . previewChrome() . '</style>';

// ── Kopf ───────────────────────────────────────────────────────
$out[] = '<header class="pf-kopf">';
$out[] = '  <div class="pf-kopf-zeile">';
$out[] = '    <div class="pf-marke">';
$out[] = '      <span class="pf-marke-titel">Korrekturlauf</span>';
$out[] = '      <span class="pf-marke-sub">SUI Innova · ' . count($seiten)
       . ' Seiten · noch nicht hochgeladen</span>';
$out[] = '    </div>';
$out[] = '    <dl class="pf-kennzahlen">';
$out[] = '      <div><dt>Seiten</dt><dd>' . count($seiten) . '</dd></div>';
$out[] = '      <div><dt>Fragen</dt><dd>' . $gesamtFaq . '</dd></div>';
$out[] = '      <div><dt>Wörter</dt><dd>' . number_format($gesamtWoerter, 0, ',', "'") . '</dd></div>';
$out[] = '    </dl>';
$out[] = '  </div>';

$out[] = '  <nav class="pf-nav" aria-label="Seiten">';
foreach ($seiten as $i => $s2) {
    $out[] = '    <a href="#' . $s2['slug'] . '"><span class="pf-nav-nr">'
           . str_pad((string)($i + 1), 2, '0', STR_PAD_LEFT) . '</span>'
           . htmlspecialchars($s2['nav_label']) . '</a>';
}
$out[] = '    <button type="button" id="pf-sprung" class="pf-sprung">'
       . 'Nächste offene Stelle <span class="pf-sprung-zaehler" id="pf-sprung-zaehler"></span></button>';
$out[] = '  </nav>';
$out[] = '</header>';

// ── Hinweis ────────────────────────────────────────────────────
$out[] = '<div class="pf-hinweis">';
$out[] = '  <p><strong>Das ist eine Vorschau, nicht die Live-Website.</strong> Gerendert aus den '
       . 'echten Vorlagen mit den Texten aus dem Keyword-Plan. Es ist nichts hochgeladen und '
       . 'nichts in der Datenbank geändert.</p>';
$out[] = '  <ul>';
$out[] = '    <li>Die Texte sind vollständig — keine offene Stelle mehr. Wo im Keyword-Plan eine '
       . 'Zahl fehlte, verweist der Satz jetzt auf Ausschreibung, Schallschutznachweis oder '
       . 'Offerte, statt eine Zahl zu behaupten.</li>';
$out[] = '    <li>Bilder fehlen — dafür bräuchte die Vorschau die Datenbank. Der Kopfbanner '
       . 'jeder Seite blendet sich deshalb aus.</li>';
$out[] = '    <li>Die Hausschrift fehlt ebenfalls, die Seiten laufen hier auf der Systemschrift.</li>';
$out[] = '  </ul>';
$out[] = '</div>';

// ── Seiten ─────────────────────────────────────────────────────
foreach ($seiten as $i => $s2) {
    $nr = str_pad((string)($i + 1), 2, '0', STR_PAD_LEFT);

    $out[] = '<article class="pf-seite" id="' . $s2['slug'] . '">';

    // Revisionsstempel
    $out[] = '<div class="pf-stempel">';
    $out[] = '  <div class="pf-stempel-kopf">';
    $out[] = '    <span class="pf-nr">' . $nr . '</span>';
    $out[] = '    <span class="pf-pfad">/' . $s2['slug'] . '</span>';
    $out[] = '    <span class="pf-status' . ($s2['marken'] ? ' pf-status-warn' : ' pf-status-ok') . '">'
           . ($s2['marken'] ? $s2['marken'] . ' offene Stellen' : 'vollständig') . '</span>';
    $out[] = '    <span class="pf-woerter">' . $s2['woerter'] . ' Wörter</span>';
    $out[] = '  </div>';

    $out[] = '  <div class="pf-stempel-raster">';

    // Google-Vorschau
    $out[] = '    <div class="pf-feld pf-feld-serp">';
    $out[] = '      <span class="pf-feld-label">So sieht es bei Google aus</span>';
    $out[] = '      <div class="pf-serp">';
    $out[] = '        <div class="pf-serp-url">sui-innova.ch › ' . htmlspecialchars($s2['slug']) . '</div>';
    $out[] = '        <div class="pf-serp-titel">' . htmlspecialchars($s2['meta_title']) . '</div>';
    $out[] = '        <div class="pf-serp-text">' . htmlspecialchars($s2['meta_desc']) . '</div>';
    $out[] = '      </div>';
    $out[] = '    </div>';

    // Messwerte
    $tl = mb_strlen($s2['meta_title']);
    $dl = mb_strlen($s2['meta_desc']);
    $out[] = '    <div class="pf-feld pf-feld-mass">';
    $out[] = '      <span class="pf-feld-label">Zeichen</span>';
    $out[] = '      <table class="pf-mass"><tbody>';
    $out[] = '        <tr><th scope="row">Titel</th><td>' . $tl . '</td>'
           . '<td class="pf-soll">max 60</td></tr>';
    $out[] = '        <tr><th scope="row">Beschreibung</th><td>' . $dl . '</td>'
           . '<td class="pf-soll">120–160</td></tr>';
    $out[] = '      </tbody></table>';
    $out[] = '    </div>';

    $out[] = '  </div>';
    $out[] = '</div>';

    // Die gerenderte Seite
    $out[] = '<main class="pf-blatt">';
    $out[] = $s2['html'];
    $out[] = '</main>';
    $out[] = '</article>';
}

$out[] = <<<'JS'
<script>
(function () {
  var stellen = Array.prototype.slice.call(
    document.querySelectorAll('mark.angabe-fehlt:not(.angabe-legende)')
  );
  var knopf   = document.getElementById('pf-sprung');
  var zaehler = document.getElementById('pf-sprung-zaehler');
  var pos     = -1;

  if (!stellen.length) {
    if (knopf) { knopf.disabled = true; knopf.textContent = 'Keine offene Stelle'; }
    return;
  }

  function anzeigen() {
    zaehler.textContent = (pos + 1) + '/' + stellen.length;
  }

  knopf.addEventListener('click', function () {
    if (pos >= 0) stellen[pos].classList.remove('angabe-aktiv');
    pos = (pos + 1) % stellen.length;
    var ziel = stellen[pos];
    ziel.classList.add('angabe-aktiv');
    ziel.scrollIntoView({ block: 'center', behavior: 'smooth' });
    anzeigen();
  });

  zaehler.textContent = stellen.length + ' offen';
})();
</script>
JS;

function previewChrome(): string
{
    return <<<'CSS'
/* ══════════════════════════════════════════════════════════════
   Rahmen des Korrekturlaufs.

   Bewusst eine eigene Bildsprache: dunkler Planrahmen mit
   Schreibmaschinenschrift aussen, weisses Blatt innen. So ist auf
   einen Blick klar, was Werkzeug ist und was die Website.
   ══════════════════════════════════════════════════════════════ */

:root {
  --pf-grund:    #E4E7EB;
  --pf-stempel:  #171C24;
  --pf-stempel2: #212832;
  --pf-linie:    #333C48;
  --pf-blatt:    #FFFFFF;
  --pf-text:     #F2F4F7;
  --pf-text-mat: #939DAB;
  --pf-rot:      #C41018;
  --pf-flagge:   #E8A33D;
  --pf-gruen:    #4ADE80;
  --pf-sans: "IBM Plex Sans", system-ui, -apple-system, sans-serif;
  --pf-mono: "IBM Plex Mono", ui-monospace, "SF Mono", Menlo, monospace;
}

body { margin: 0; background: var(--pf-grund); }

/* ── Kopf ───────────────────────────────────────────────────── */
.pf-kopf {
  position: sticky; top: 0; z-index: 60;
  background: var(--pf-stempel);
  border-bottom: 1px solid var(--pf-linie);
}
.pf-kopf-zeile {
  display: flex; flex-wrap: wrap; gap: 20px 32px;
  align-items: flex-end; justify-content: space-between;
  padding: 18px 24px 14px;
  max-width: 1400px; margin: 0 auto;
}
.pf-marke { display: flex; flex-direction: column; gap: 4px; }
.pf-marke-titel {
  font-family: var(--pf-sans); font-weight: 700; font-size: 19px;
  letter-spacing: -0.01em; color: var(--pf-text);
}
.pf-marke-sub {
  font-family: var(--pf-mono); font-size: 12px; color: var(--pf-text-mat);
}

.pf-kennzahlen {
  display: flex; gap: 28px; margin: 0;
}
.pf-kennzahlen div { display: flex; flex-direction: column; gap: 2px; }
.pf-kennzahlen dt {
  font-family: var(--pf-mono); font-size: 10px; text-transform: uppercase;
  letter-spacing: 0.12em; color: var(--pf-text-mat);
}
.pf-kennzahlen dd {
  margin: 0; font-family: var(--pf-mono); font-size: 22px; font-weight: 600;
  color: var(--pf-text); font-variant-numeric: tabular-nums; line-height: 1;
}
.pf-kennzahl-warn dd { color: var(--pf-flagge); }

/* ── Sprungleiste ───────────────────────────────────────────── */
.pf-nav {
  display: flex; flex-wrap: wrap; align-items: center; gap: 2px 4px;
  padding: 0 24px 12px; max-width: 1400px; margin: 0 auto;
}
.pf-nav a {
  display: inline-flex; align-items: baseline; gap: 7px;
  font-family: var(--pf-sans); font-size: 13px; color: var(--pf-text-mat);
  text-decoration: none; padding: 6px 11px; border-radius: 3px;
  border: 1px solid transparent;
}
.pf-nav a:hover { color: var(--pf-text); background: var(--pf-stempel2); }
.pf-nav a:focus-visible { outline: 2px solid var(--pf-flagge); outline-offset: 1px; }
.pf-nav-nr {
  font-family: var(--pf-mono); font-size: 10px; color: var(--pf-rot);
  font-weight: 600;
}

.pf-sprung {
  margin-left: auto;
  display: inline-flex; align-items: center; gap: 9px;
  font-family: var(--pf-sans); font-size: 13px; font-weight: 500;
  color: var(--pf-stempel); background: var(--pf-flagge);
  border: 0; border-radius: 3px; padding: 8px 14px; cursor: pointer;
}
.pf-sprung:hover { filter: brightness(1.08); }
.pf-sprung:focus-visible { outline: 2px solid var(--pf-text); outline-offset: 2px; }
.pf-sprung:disabled { background: var(--pf-stempel2); color: var(--pf-text-mat); cursor: default; }
.pf-sprung-zaehler {
  font-family: var(--pf-mono); font-size: 11px; font-variant-numeric: tabular-nums;
  background: rgba(23,28,36,0.22); padding: 2px 6px; border-radius: 2px;
}

/* ── Hinweisblock ───────────────────────────────────────────── */
.pf-hinweis {
  max-width: 1400px; margin: 0 auto; padding: 22px 24px 4px;
  font-family: var(--pf-sans); color: #2D333D;
}
.pf-hinweis p { margin: 0 0 10px; font-size: 15px; line-height: 1.6; max-width: 62ch; }
.pf-hinweis ul { margin: 0; padding-left: 18px; max-width: 68ch; }
.pf-hinweis li { font-size: 13.5px; line-height: 1.65; margin-bottom: 5px; color: #4A515C; }

/* ── Eine Seite ─────────────────────────────────────────────── */
.pf-seite {
  max-width: 1400px; margin: 0 auto 40px; padding: 28px 24px 0;
  scroll-margin-top: 130px;
}

.pf-stempel {
  background: var(--pf-stempel);
  border: 1px solid var(--pf-linie);
  border-bottom: 0;
}
.pf-stempel-kopf {
  display: flex; flex-wrap: wrap; align-items: center; gap: 14px;
  padding: 11px 18px; border-bottom: 1px solid var(--pf-linie);
}
.pf-nr {
  font-family: var(--pf-mono); font-size: 12px; font-weight: 600;
  color: var(--pf-stempel); background: var(--pf-rot);
  padding: 3px 8px; border-radius: 2px; color: #fff;
}
.pf-pfad {
  font-family: var(--pf-mono); font-size: 14px; color: var(--pf-text);
}
.pf-status {
  margin-left: auto; font-family: var(--pf-mono); font-size: 11px;
  text-transform: uppercase; letter-spacing: 0.1em;
  padding: 4px 9px; border-radius: 2px;
}
.pf-status-warn { color: var(--pf-flagge); border: 1px solid rgba(232,163,61,0.4); }
.pf-status-ok   { color: var(--pf-gruen);  border: 1px solid rgba(74,222,128,0.4); }
.pf-woerter {
  font-family: var(--pf-mono); font-size: 11px; color: var(--pf-text-mat);
  font-variant-numeric: tabular-nums;
}

.pf-stempel-raster {
  display: grid; grid-template-columns: minmax(0,1fr) auto;
  gap: 1px; background: var(--pf-linie);
}
.pf-feld { background: var(--pf-stempel); padding: 14px 18px 16px; }
.pf-feld-label {
  display: block; font-family: var(--pf-mono); font-size: 10px;
  text-transform: uppercase; letter-spacing: 0.12em;
  color: var(--pf-text-mat); margin-bottom: 10px;
}

/* Google-Nachbau */
.pf-serp { max-width: 600px; }
.pf-serp-url   { font-family: var(--pf-sans); font-size: 12px; color: #9AA4B2; margin-bottom: 3px; }
.pf-serp-titel { font-family: var(--pf-sans); font-size: 19px; line-height: 1.3; color: #8AB4F8; margin-bottom: 3px; }
.pf-serp-text  { font-family: var(--pf-sans); font-size: 13.5px; line-height: 1.58; color: #BDC1C6; }

/* Messwerte */
.pf-mass { border-collapse: collapse; font-family: var(--pf-mono); font-size: 12px; }
.pf-mass th, .pf-mass td { padding: 3px 0; text-align: left; font-weight: 400; }
.pf-mass th { color: var(--pf-text-mat); padding-right: 18px; }
.pf-mass td { color: var(--pf-text); font-variant-numeric: tabular-nums; padding-right: 12px; }
.pf-soll { color: var(--pf-text-mat) !important; font-size: 11px; }

/* Das Blatt mit der gerenderten Seite */
.pf-blatt {
  display: block; background: var(--pf-blatt);
  border: 1px solid var(--pf-linie); border-top: 0;
}
.pf-blatt .section { padding: 44px 0; }

/* Aktive Fundstelle beim Durchspringen */
mark.angabe-aktiv {
  box-shadow: 0 0 0 3px var(--pf-rot);
  scroll-margin-top: 150px;
}

@media (max-width: 780px) {
  .pf-stempel-raster { grid-template-columns: minmax(0,1fr); }
  .pf-kennzahlen { gap: 18px; }
  .pf-kennzahlen dd { font-size: 18px; }
  .pf-seite { padding: 18px 12px 0; }
  .pf-kopf-zeile, .pf-nav, .pf-hinweis { padding-left: 16px; padding-right: 16px; }
  .pf-sprung { margin-left: 0; width: 100%; justify-content: center; }
  .pf-nav a { padding: 5px 8px; font-size: 12.5px; }
}

@media (prefers-reduced-motion: reduce) {
  * { scroll-behavior: auto !important; }
}
CSS;
}

echo implode("\n", $out) . "\n";
