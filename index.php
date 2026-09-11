<?php
/**
 * SUI Innova GmbH — Front Controller
 *
 * Laedt Bootstrap, ermittelt die aktuelle Seite und rendert das Layout.
 */

define('BASE_PATH', __DIR__);

require_once BASE_PATH . '/core/bootstrap.php';
require_once BASE_PATH . '/core/router.php';
require_once BASE_PATH . '/core/contact.php';
require_once BASE_PATH . '/core/application.php';
require_once BASE_PATH . '/core/sitemap.php';

// Aktueller Pfad (ohne Query-String)
$requestPath = trim(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH), '/');
$requestSlug = $_GET['page'] ?? $requestPath;
$requestSlug = trim((string)$requestSlug, '/');

// ── Spezial-Routes ─────────────────────────────────

// Sitemap (wird dynamisch generiert)
if ($requestSlug === 'sitemap.xml' || $requestPath === 'sitemap.xml') {
    renderSitemap();
    exit;
}

// Kontaktformular-Submit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($requestSlug === 'kontakt/senden' || $requestPath === 'kontakt/senden')) {
    handleContactSubmit();
    exit;
}

// Bewerbungs-Submit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($requestSlug === 'karriere/bewerben' || $requestPath === 'karriere/bewerben')) {
    handleApplicationSubmit();
    exit;
}

// ── Wartungsmodus ─────────────────────────────────

if (setting('maintenance_mode') === '1' && !isLoggedIn()) {
    http_response_code(503);
    header('Retry-After: 3600');
    include BASE_PATH . '/templates/maintenance.php';
    exit;
}

// ── Normale Seite ─────────────────────────────────

$page = resolveCurrentPage();

if (!$page) {
    render404();
}

// Kanonische Adresse der Startseite erzwingen.
// Bisher lieferten / und /startseite denselben Inhalt und denselben Titel.
// Google sah zwei Seiten, wo eine gemeint ist, und verteilte alles, was die
// Startseite an Autoritaet aufbaut, auf zwei Adressen. Der Redirect buendelt
// das wieder. Die .htaccess faengt den Fall schon vorher ab — dieser Guard
// greift zusaetzlich, falls mod_rewrite auf dem Server nicht aktiv ist.
if (!empty($page['is_homepage']) && $requestSlug !== '') {
    header('Location: ' . url(), true, 301);
    exit;
}

// Inaktive Seiten: Besucher werden zur Startseite weitergeleitet, Admins sehen die Seite weiter
if ((int)($page['is_active'] ?? 1) === 0 && !isLoggedIn()) {
    header('Location: ' . url(), true, 302);
    exit;
}

// Seiten-Meta fuers Layout bereitstellen
// Wichtig: Die Spalten in `pages` heissen meta_title / meta_desc.
// Frueher wurde hier meta_description gelesen — eine Spalte, die es nicht
// gibt. Dadurch blieb die Meta-Description auf jeder Seite leer, obwohl sie
// im CMS gepflegt war.
$pageTitle     = $page['title'] ?? '';
$pageMetaTitle = $page['meta_title'] ?? '';
$pageDesc      = $page['meta_desc'] ?? '';
$pageH1        = $page['h1'] ?? '';
$currentSlug   = $page['slug'] ?? '';
$isHomepage    = !empty($page['is_homepage']);
$sections      = loadSections((int)$page['id']);

// Besuch tracken (DSGVO-konform)
trackVisit($page['slug'] ?? '');

// Layout rendern
include BASE_PATH . '/templates/layout.php';
