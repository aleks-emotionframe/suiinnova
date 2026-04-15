<?php
/**
 * Helper functions used throughout the application.
 */

/**
 * Get CMS content with fallback to default.
 */
function cms(array $blockMap, string $key, string $field = 'content', string $default = ''): string
{
    if (isset($blockMap[$key][$field]) && $blockMap[$key][$field] !== '') {
        return $blockMap[$key][$field];
    }
    return $default;
}

/**
 * Output data-cms attributes for inline editing (admin only).
 */
function cmsAttr(array $blockMap, string $key, string $field): string
{
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) return '';
    $id = $blockMap[$key]['id'] ?? '';
    if (!$id) return '';
    return ' data-cms-id="' . (int)$id . '" data-cms-field="' . htmlspecialchars($field, ENT_QUOTES, 'UTF-8') . '"';
}

/**
 * Get a setting value from the database.
 */
function setting(string $key, string $default = ''): string
{
    static $cache = [];

    if (empty($cache)) {
        try {
            $db = Database::getInstance();
            $stmt = $db->query('SELECT setting_key, setting_value FROM settings');
            while ($row = $stmt->fetch()) {
                $cache[$row['setting_key']] = $row['setting_value'];
            }
        } catch (Exception $e) {
            return $default;
        }
    }

    return $cache[$key] ?? $default;
}

/**
 * Get content blocks for a page by section key.
 */
function getContentBlock(int $pageId, string $sectionKey): ?array
{
    try {
        $db = Database::getInstance();
        $stmt = $db->prepare(
            'SELECT * FROM content_blocks WHERE page_id = ? AND section_key = ? AND is_active = 1 LIMIT 1'
        );
        $stmt->execute([$pageId, $sectionKey]);
        return $stmt->fetch() ?: null;
    } catch (Exception $e) {
        return null;
    }
}

/**
 * Get all content blocks for a page.
 */
function getContentBlocks(int $pageId, ?string $sectionPrefix = null): array
{
    try {
        $db = Database::getInstance();
        if ($sectionPrefix) {
            $stmt = $db->prepare(
                'SELECT * FROM content_blocks WHERE page_id = ? AND section_key LIKE ? AND is_active = 1 ORDER BY sort_order'
            );
            $stmt->execute([$pageId, $sectionPrefix . '%']);
        } else {
            $stmt = $db->prepare(
                'SELECT * FROM content_blocks WHERE page_id = ? AND is_active = 1 ORDER BY sort_order'
            );
            $stmt->execute([$pageId]);
        }
        return $stmt->fetchAll();
    } catch (Exception $e) {
        return [];
    }
}

/**
 * Get page data by slug.
 */
function getPage(string $slug): ?array
{
    try {
        $db = Database::getInstance();
        $stmt = $db->prepare('SELECT * FROM pages WHERE slug = ? AND is_active = 1 LIMIT 1');
        $stmt->execute([$slug]);
        return $stmt->fetch() ?: null;
    } catch (Exception $e) {
        return null;
    }
}

/**
 * Get navigation pages.
 */
function getNavPages(): array
{
    try {
        $db = Database::getInstance();
        $stmt = $db->query('SELECT slug, title FROM pages WHERE is_active = 1 AND is_in_nav = 1 ORDER BY sort_order');
        return $stmt->fetchAll();
    } catch (Exception $e) {
        return [];
    }
}

/**
 * Escape HTML output.
 */
function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

/**
 * Render newlines as <br>.
 */
function nl2p(string $text): string
{
    $paragraphs = array_filter(array_map('trim', explode("\n\n", $text)));
    if (count($paragraphs) <= 1) {
        return '<p>' . nl2br(e($text)) . '</p>';
    }
    return implode('', array_map(fn($p) => '<p>' . nl2br(e($p)) . '</p>', $paragraphs));
}

/**
 * Generate a URL for a page.
 */
function pageUrl(string $slug): string
{
    if ($slug === 'startseite') {
        return SITE_URL . '/';
    }
    return SITE_URL . '/' . $slug;
}

/**
 * Create a slug from a string.
 */
function slugify(string $text): string
{
    $text = transliterator_transliterate('Any-Latin; Latin-ASCII; Lower()', $text);
    $text = preg_replace('/[^a-z0-9]+/', '-', $text);
    return trim($text, '-');
}

/**
 * Flash messages.
 */
function setFlash(string $type, string $message): void
{
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function getFlash(): ?array
{
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

/**
 * Redirect to URL.
 */
function redirect(string $url): void
{
    header('Location: ' . $url);
    exit;
}

/**
 * Get current URI path.
 */
function currentPath(): string
{
    return strtok($_SERVER['REQUEST_URI'] ?? '/', '?');
}

/**
 * Check if current page matches slug.
 */
function isActivePage(string $slug): bool
{
    $path = trim(currentPath(), '/');
    if ($slug === 'startseite') {
        return $path === '' || $path === 'startseite';
    }
    return $path === $slug;
}
