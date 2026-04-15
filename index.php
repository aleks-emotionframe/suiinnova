<?php
/**
 * SUI Innova GmbH — Front Controller
 * All requests are routed through this file.
 */

define('APP_PATH', __DIR__ . '/app');
require_once APP_PATH . '/bootstrap.php';
require_once APP_PATH . '/controllers/PageController.php';
require_once APP_PATH . '/controllers/AdminController.php';

// Check maintenance mode before routing
checkMaintenance();

$router = new Router();
$pages = new PageController();
$admin = new AdminController();

// ── Public Routes ──
$router->get('/', [$pages, 'home']);
$router->get('/startseite', [$pages, 'home']);
$router->get('/kompetenzen', [$pages, 'kompetenzen']);
$router->get('/referenzen', [$pages, 'referenzen']);
$router->get('/unternehmen', [$pages, 'unternehmen']);
$router->get('/kontakt', [$pages, 'kontakt']);
$router->post('/kontakt', [$pages, 'kontaktSubmit']);

// ── Admin Routes ──
$router->post('/admin/api/save', [$admin, 'apiSave']);
$router->post('/admin/api/upload', [$admin, 'apiUpload']);

$router->get('/admin', [$admin, 'dashboard']);
$router->get('/admin/login', [$admin, 'loginForm']);
$router->post('/admin/login', [$admin, 'loginSubmit']);
$router->get('/admin/logout', [$admin, 'logout']);

$router->get('/admin/pages', [$admin, 'pagesList']);
$router->get('/admin/pages/new', [$admin, 'pageCreate']);
$router->post('/admin/pages/new', [$admin, 'pageStore']);
$router->get('/admin/pages/{id}', [$admin, 'pageEdit']);
$router->post('/admin/pages/{id}', [$admin, 'pageUpdate']);
$router->post('/admin/pages/{id}/delete', [$admin, 'pageDelete']);

$router->get('/admin/content/{id}', [$admin, 'contentEdit']);
$router->post('/admin/content/{id}', [$admin, 'contentUpdate']);
$router->get('/admin/pages/{pageId}/content/new', [$admin, 'contentCreate']);
$router->post('/admin/pages/{pageId}/content/new', [$admin, 'contentStore']);
$router->post('/admin/content/{id}/delete', [$admin, 'contentDelete']);

$router->get('/admin/references', [$admin, 'referencesList']);
$router->get('/admin/references/new', [$admin, 'referenceCreate']);
$router->post('/admin/references/new', [$admin, 'referenceStore']);
$router->get('/admin/references/{id}', [$admin, 'referenceEdit']);
$router->post('/admin/references/{id}', [$admin, 'referenceUpdate']);
$router->post('/admin/references/{id}/delete', [$admin, 'referenceDelete']);

$router->get('/admin/messages', [$admin, 'messagesList']);
$router->get('/admin/messages/{id}', [$admin, 'messageView']);
$router->post('/admin/messages/{id}/delete', [$admin, 'messageDelete']);

$router->get('/admin/settings', [$admin, 'settings']);
$router->post('/admin/settings', [$admin, 'settingsUpdate']);

$router->get('/admin/password', [$admin, 'passwordForm']);
$router->post('/admin/password', [$admin, 'passwordUpdate']);

// Dispatch
$router->dispatch($_SERVER['REQUEST_URI'] ?? '/', $_SERVER['REQUEST_METHOD'] ?? 'GET');
