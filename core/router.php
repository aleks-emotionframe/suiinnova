<?php
/**
 * Router — URL zu Seite zuordnen
 */

/**
 * Aktuelle Seite ermitteln
 */
function resolveCurrentPage(): ?array
{
    global $db;

    $slug = $_GET['page'] ?? '';
    $slug = trim($slug, '/');

    // Admins duerfen auch inaktive Seiten oeffnen (zum Bearbeiten)
    $activeFilter = isLoggedIn() ? '' : ' AND is_active = 1';

    // Leerer Slug = Startseite
    if ($slug === '' || $slug === 'index.php') {
        $page = $db->fetch("SELECT * FROM pages WHERE is_homepage = 1{$activeFilter} LIMIT 1");
    } else {
        $page = $db->fetch(
            "SELECT * FROM pages WHERE slug = :slug{$activeFilter}",
            ['slug' => $slug]
        );
    }

    return $page;
}

/**
 * Sektionen fuer eine Seite laden
 */
function loadSections(int $pageId): array
{
    global $db;

    $rows = $db->fetchAll(
        "SELECT * FROM sections WHERE page_id = :pid AND is_active = 1 ORDER BY sort_order ASC",
        ['pid' => $pageId]
    );

    // JSON-Content dekodieren
    foreach ($rows as &$row) {
        $row['content'] = jsonDecode($row['content']);
    }

    return $rows;
}

/**
 * Besuch tracken (DSGVO-konform)
 */
function trackVisit(string $pageSlug): void
{
    global $db;

    try {
        $db->insert('visits', [
            'page_slug'  => $pageSlug,
            'referrer'   => substr($_SERVER['HTTP_REFERER'] ?? '', 0, 500),
            'user_agent' => substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 500),
            'ip_hash'    => hashIp($_SERVER['REMOTE_ADDR'] ?? ''),
        ]);
    } catch (Exception $e) {
        // Tracking-Fehler ignorieren (nicht kritisch)
    }
}

/**
 * Section-Template rendern
 */
function renderSection(array $section): void
{
    $type = $section['type'];
    $content = $section['content'];
    $templateFile = BASE_PATH . '/templates/sections/' . $type . '.php';

    if (file_exists($templateFile)) {
        // $content steht im Template zur Verfuegung
        include $templateFile;
    }
}

/**
 * 404-Seite anzeigen
 */
function render404(): void
{
    http_response_code(404);
    $pageTitle = 'Seite nicht gefunden';
    include BASE_PATH . '/templates/layout.php';
    exit;
}
