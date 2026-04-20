<?php
/**
 * SUI Innova GmbH — Front Controller
 *
 * Laedt Bootstrap, ermittelt die aktuelle Seite und rendert das Layout.
 */

define('BASE_PATH', __DIR__);

require_once BASE_PATH . '/core/bootstrap.php';
require_once BASE_PATH . '/core/router.php';

// Wartungsmodus (Admin wird bereits in bootstrap.php erkannt und umgangen)
if (setting('maintenance_mode') === '1' && !isLoggedIn()) {
    http_response_code(503);
    header('Retry-After: 3600');
    include BASE_PATH . '/templates/maintenance.php';
    exit;
}

// Aktuelle Seite ermitteln
$page = resolveCurrentPage();

if (!$page) {
    render404();
}

// Seiten-Meta fuers Layout bereitstellen
$pageTitle   = $page['title'] ?? '';
$pageDesc    = $page['meta_description'] ?? '';
$currentSlug = $page['slug'] ?? '';
$isHomepage  = !empty($page['is_homepage']);
$sections    = loadSections((int)$page['id']);

// Besuch tracken (DSGVO-konform)
trackVisit($page['slug'] ?? '');

// Layout rendern
include BASE_PATH . '/templates/layout.php';
