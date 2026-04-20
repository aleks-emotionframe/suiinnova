<?php
define("BASE_PATH", dirname(dirname(__DIR__)));
require_once BASE_PATH . "/core/bootstrap.php";
requireAuth();
/**
 * AJAX: Section speichern
 */

header('Content-Type: application/json');
requireCsrf();

$sectionId = (int) ($_POST['section_id'] ?? 0);
if (!$sectionId) {
    echo json_encode(['error' => 'Keine Section-ID']);
    exit;
}

// Section laden
$section = $db->fetch("SELECT * FROM sections WHERE id = :id", ['id' => $sectionId]);
if (!$section) {
    echo json_encode(['error' => 'Section nicht gefunden']);
    exit;
}

// Section-Typ-Definition laden
$sectionTypes = require BASE_PATH . '/config/sections.php';
$typeDef = $sectionTypes[$section['type']] ?? null;

if (!$typeDef) {
    echo json_encode(['error' => 'Unbekannter Section-Typ']);
    exit;
}

// Bestehenden Content laden (um nicht-definierte Felder wie image_url zu behalten)
$content = json_decode($section['content'], true) ?: [];

// Definierte Felder aus POST aktualisieren
foreach ($typeDef['fields'] as $fieldKey => $fieldDef) {
    if ($fieldDef['type'] === 'repeater') {
        $jsonKey = $fieldKey . '_json';
        if (isset($_POST[$jsonKey])) {
            $content[$fieldKey] = json_decode($_POST[$jsonKey], true) ?: [];
        } elseif (isset($_POST[$fieldKey])) {
            $content[$fieldKey] = $_POST[$fieldKey];
        }
    } elseif ($fieldDef['type'] === 'checkbox') {
        $content[$fieldKey] = isset($_POST[$fieldKey]) ? true : false;
    } elseif ($fieldDef['type'] === 'media') {
        $content[$fieldKey] = (int) ($_POST[$fieldKey] ?? $content[$fieldKey] ?? 0);
    } else {
        if (isset($_POST[$fieldKey])) {
            $content[$fieldKey] = $_POST[$fieldKey];
        }
    }
}

// Speichern
$db->update('sections', [
    'content' => json_encode($content, JSON_UNESCAPED_UNICODE),
], 'id = :id', ['id' => $sectionId]);

echo json_encode(['success' => true, 'message' => 'Gespeichert']);
