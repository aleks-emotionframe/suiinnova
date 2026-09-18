<?php
define("BASE_PATH", dirname(dirname(__DIR__)));
require_once BASE_PATH . "/core/bootstrap.php";
requireAuth();
/**
 * AJAX: Statistiken holen
 */

header('Content-Type: application/json');

$period = $_GET['period'] ?? 'week';

$dateFrom = match($period) {
    'today' => date('Y-m-d'),
    'week'  => date('Y-m-d', strtotime('-7 days')),
    'month' => date('Y-m-d', strtotime('-30 days')),
    default => date('Y-m-d', strtotime('-7 days')),
};

$views = (int) $db->fetchColumn(
    "SELECT COUNT(*) FROM visits WHERE visited_at >= :d", ['d' => $dateFrom]
);
$visitors = (int) $db->fetchColumn(
    "SELECT COUNT(DISTINCT ip_hash) FROM visits WHERE visited_at >= :d", ['d' => $dateFrom]
);
$contacts = (int) $db->fetchColumn(
    "SELECT COUNT(*) FROM contacts WHERE is_read = 0"
);

echo json_encode([
    'views'    => $views,
    'visitors' => $visitors,
    'contacts' => $contacts,
    'period'   => $period,
]);
