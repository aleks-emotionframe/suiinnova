<?php
/**
 * SUI Innova GmbH — Admin CMS Front-Controller
 */

define('BASE_PATH', dirname(__DIR__));
require_once BASE_PATH . '/core/bootstrap.php';

// --- Routing ---
$requestUri = $_SERVER['REQUEST_URI'] ?? '';
$path = parse_url($requestUri, PHP_URL_PATH);
$path = preg_replace('#^/admin/?#', '', $path);
$path = trim($path, '/');

// API-Requests (AJAX)
if (str_starts_with($path, 'api/')) {
    $apiFile = BASE_PATH . '/admin/' . $path . '.php';
    if (file_exists($apiFile)) {
        requireAuth();
        require $apiFile;
        exit;
    }
    http_response_code(404);
    echo json_encode(['error' => 'API endpoint not found']);
    exit;
}

// --- Login/Logout ---
if ($path === 'login') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if (login($username, $password)) {
            header('Location: ' . url('admin'));
            exit;
        }

        $loginError = 'Benutzername oder Passwort falsch.';
    }

    if (isLoggedIn()) {
        header('Location: ' . url('admin'));
        exit;
    }

    $adminView = 'login';
    include BASE_PATH . '/admin/views/login.php';
    exit;
}

if ($path === 'logout') {
    logout();
    header('Location: ' . url('admin/login'));
    exit;
}

// --- Auth erforderlich fuer alles andere ---
requireAuth();

// --- Admin Pages ---
$adminView = match ($path) {
    '', 'dashboard'   => 'dashboard',
    'pages'           => 'pages',
    'references'      => 'references',
    'media'           => 'media',
    'seo'             => 'seo',
    'settings'        => 'settings',
    'contacts'        => 'contacts',
    'applications'    => 'applications',
    default           => null,
};

// Seiten-Editor (dynamische Route)
if (str_starts_with($path, 'pages/edit/')) {
    $editPageId = (int) str_replace('pages/edit/', '', $path);
    $adminView = 'page-editor';
}

if ($adminView === null) {
    http_response_code(404);
    $adminView = '404';
}

// View laden
$viewFile = BASE_PATH . '/admin/views/' . $adminView . '.php';
if (file_exists($viewFile)) {
    include BASE_PATH . '/admin/views/layout.php';
} else {
    echo 'View not found: ' . htmlspecialchars($adminView);
}
