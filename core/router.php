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
    $type = (string) $section['type'];
    $content = $section['content'];

    // Der Typ wird zu einem Dateipfad. Ueber das CMS kann nur eintragen
    // werden, was in config/sections.php steht — SQL-Migrationen schreiben
    // aber direkt in die Tabelle, und ein Tippfehler mit "../" wuerde hier
    // eine beliebige PHP-Datei einbinden. Nur Kleinbuchstaben, Ziffern und
    // Bindestrich zulassen.
    if (!preg_match('/^[a-z0-9-]+$/', $type)) {
        error_log('Ungueltiger Section-Typ verworfen: ' . $type);
        return;
    }

    $templateFile = BASE_PATH . '/templates/sections/' . $type . '.php';

    if (file_exists($templateFile)) {
        // $content steht im Template zur Verfuegung
        include $templateFile;
        return;
    }

    // Fehlende Vorlage: bisher wurde die Sektion stillschweigend verschluckt.
    // Wenn eine SQL-Migration einen Sektionstyp einfuehrt, dessen Datei noch
    // nicht hochgeladen ist, verschwindet damit der ganze Inhalt der Seite —
    // ohne Fehlermeldung, ohne Spur im Log. Genau so waere es beinahe
    // passiert, als content-grid in der Datenbank stand, aber nicht auf dem
    // Server.
    error_log('Section-Vorlage fehlt: templates/sections/' . $type . '.php');

    if (!isLoggedIn()) {
        return;
    }

    // Fuer eingeloggte Admins sichtbar machen, Besucher sehen weiterhin nichts
    echo '<div style="max-width:60rem;margin:24px auto;padding:18px 22px;'
       . 'background:#FEF3C7;border-left:4px solid #C41018;color:#713F12;'
       . 'font-size:14px;line-height:1.6;">'
       . '<strong style="display:block;margin-bottom:6px;color:#7F1D1D;">'
       . 'Vorlage fehlt: ' . e($type) . '</strong>'
       . 'Diese Sektion kann nicht dargestellt werden, weil die Datei '
       . '<code>templates/sections/' . e($type) . '.php</code> auf dem Server fehlt. '
       . 'Besucher sehen an dieser Stelle gar nichts. Laden Sie die Datei per FTP nach, '
       . 'dann erscheint der Inhalt wieder — er steht unveraendert in der Datenbank.'
       . '</div>';
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
