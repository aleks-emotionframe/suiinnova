<?php
/**
 * Sitemap-Generator — dynamisch aus DB.
 *
 * Erzeugt XML fuer /sitemap.xml. Listet alle aktiven Seiten.
 * Startseite wird als Root-URL ausgegeben, alle anderen unter ihrem Slug.
 */

function renderSitemap(): void
{
    global $db;

    try {
        $pages = $db->fetchAll(
            "SELECT slug, is_homepage, updated_at FROM pages WHERE is_active = 1 ORDER BY is_homepage DESC, sort_order ASC"
        );
    } catch (Exception $e) {
        $pages = [];
    }

    header('Content-Type: application/xml; charset=utf-8');
    header('Cache-Control: public, max-age=3600');

    echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

    foreach ($pages as $p) {
        $isHome = (int)$p['is_homepage'] === 1;
        $loc = $isHome ? rtrim(SITE_URL, '/') . '/' : url($p['slug']);

        // Letzte Änderung im W3C-Format
        $lastmod = !empty($p['updated_at'])
            ? date('Y-m-d', strtotime($p['updated_at']))
            : date('Y-m-d');

        $priority = $isHome ? '1.0' : '0.8';
        $changefreq = $isHome ? 'weekly' : 'monthly';

        echo "  <url>\n";
        echo "    <loc>" . htmlspecialchars($loc, ENT_QUOTES, 'UTF-8') . "</loc>\n";
        echo "    <lastmod>{$lastmod}</lastmod>\n";
        echo "    <changefreq>{$changefreq}</changefreq>\n";
        echo "    <priority>{$priority}</priority>\n";
        echo "  </url>\n";
    }

    echo '</urlset>' . "\n";
}
