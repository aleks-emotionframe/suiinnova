<?php
/**
 * Admin Dashboard
 *
 * Statistiken: Seitenaufrufe, Besucher, Kontaktanfragen
 */

// Zeitraeume
$today = date('Y-m-d');
$weekAgo = date('Y-m-d', strtotime('-7 days'));
$monthAgo = date('Y-m-d', strtotime('-30 days'));

// Stats berechnen
try {
    $viewsToday = (int) $db->fetchColumn(
        "SELECT COUNT(*) FROM visits WHERE DATE(visited_at) = :d", ['d' => $today]
    );
    $viewsWeek = (int) $db->fetchColumn(
        "SELECT COUNT(*) FROM visits WHERE visited_at >= :d", ['d' => $weekAgo]
    );
    $viewsMonth = (int) $db->fetchColumn(
        "SELECT COUNT(*) FROM visits WHERE visited_at >= :d", ['d' => $monthAgo]
    );

    $visitorsToday = (int) $db->fetchColumn(
        "SELECT COUNT(DISTINCT ip_hash) FROM visits WHERE DATE(visited_at) = :d", ['d' => $today]
    );
    $visitorsWeek = (int) $db->fetchColumn(
        "SELECT COUNT(DISTINCT ip_hash) FROM visits WHERE visited_at >= :d", ['d' => $weekAgo]
    );

    $unreadContacts = (int) $db->fetchColumn("SELECT COUNT(*) FROM contacts WHERE is_read = 0");
    $totalContacts = (int) $db->fetchColumn("SELECT COUNT(*) FROM contacts");

    // Aufrufe pro Seite (Top 5)
    $pageViews = $db->fetchAll(
        "SELECT page_slug, COUNT(*) as views
         FROM visits WHERE visited_at >= :d
         GROUP BY page_slug ORDER BY views DESC LIMIT 5",
        ['d' => $monthAgo]
    );

    // Letzte Kontaktanfragen
    $recentContacts = $db->fetchAll(
        "SELECT id, name, email, company, is_read, created_at
         FROM contacts ORDER BY created_at DESC LIMIT 5"
    );

    // Aufrufe letzte 7 Tage (fuer Chart)
    $dailyViews = $db->fetchAll(
        "SELECT DATE(visited_at) as day, COUNT(*) as views
         FROM visits WHERE visited_at >= :d
         GROUP BY DATE(visited_at) ORDER BY day ASC",
        ['d' => $weekAgo]
    );

} catch (Exception $e) {
    $viewsToday = $viewsWeek = $viewsMonth = 0;
    $visitorsToday = $visitorsWeek = 0;
    $unreadContacts = $totalContacts = 0;
    $pageViews = $recentContacts = $dailyViews = [];
}

$maxDailyViews = max(array_column($dailyViews, 'views') ?: [1]);
?>

<!-- Stat Cards -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <div class="stat-card">
        <div class="stat-value"><?= $viewsToday ?></div>
        <div class="stat-label">Aufrufe heute</div>
    </div>
    <div class="stat-card">
        <div class="stat-value"><?= $viewsWeek ?></div>
        <div class="stat-label">Aufrufe (7 Tage)</div>
    </div>
    <div class="stat-card">
        <div class="stat-value"><?= $visitorsToday ?></div>
        <div class="stat-label">Besucher heute</div>
    </div>
    <div class="stat-card">
        <div class="stat-value <?= $unreadContacts > 0 ? 'text-brand-accent' : '' ?>">
            <?= $unreadContacts ?>
        </div>
        <div class="stat-label">Neue Anfragen</div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Aufrufe Chart (2/3) -->
    <div class="lg:col-span-2 admin-card">
        <h2 class="text-xs font-medium uppercase tracking-wider text-gray-500 mb-4">Seitenaufrufe (letzte 7 Tage)</h2>

        <?php if ($dailyViews): ?>
            <div class="flex items-end gap-2 h-40">
                <?php foreach ($dailyViews as $day): ?>
                    <?php $heightPercent = ($day['views'] / $maxDailyViews) * 100; ?>
                    <div class="flex-1 flex flex-col items-center gap-1">
                        <span class="text-[10px] text-gray-500"><?= $day['views'] ?></span>
                        <div class="w-full bg-gray-900 transition-all duration-300"
                             style="height: <?= max($heightPercent, 4) ?>%;">
                        </div>
                        <span class="text-[10px] text-gray-400"><?= date('d.m.', strtotime($day['day'])) ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-sm text-gray-400 py-8 text-center">Noch keine Daten vorhanden.</p>
        <?php endif; ?>
    </div>

    <!-- Top Seiten (1/3) -->
    <div class="admin-card">
        <h2 class="text-xs font-medium uppercase tracking-wider text-gray-500 mb-4">Top Seiten (30 Tage)</h2>

        <?php if ($pageViews): ?>
            <div class="space-y-3">
                <?php foreach ($pageViews as $pv): ?>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-700 truncate">/<?= e($pv['page_slug']) ?></span>
                        <span class="text-sm font-medium text-gray-900 ml-2"><?= $pv['views'] ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-sm text-gray-400 py-4 text-center">Noch keine Daten.</p>
        <?php endif; ?>
    </div>
</div>

<!-- Letzte Kontaktanfragen -->
<div class="admin-card mt-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xs font-medium uppercase tracking-wider text-gray-500">Letzte Kontaktanfragen</h2>
        <a href="<?= url('admin/contacts') ?>" class="text-xs text-gray-500 hover:text-gray-900 transition-colors duration-200">
            Alle anzeigen →
        </a>
    </div>

    <?php if ($recentContacts): ?>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="text-left text-[10px] uppercase tracking-wider text-gray-400 font-medium pb-2">Name</th>
                        <th class="text-left text-[10px] uppercase tracking-wider text-gray-400 font-medium pb-2">E-Mail</th>
                        <th class="text-left text-[10px] uppercase tracking-wider text-gray-400 font-medium pb-2">Firma</th>
                        <th class="text-left text-[10px] uppercase tracking-wider text-gray-400 font-medium pb-2">Datum</th>
                        <th class="text-left text-[10px] uppercase tracking-wider text-gray-400 font-medium pb-2">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recentContacts as $contact): ?>
                        <tr class="border-b border-gray-50 <?= !$contact['is_read'] ? 'font-medium' : 'text-gray-600' ?>">
                            <td class="py-2.5"><?= e($contact['name']) ?></td>
                            <td class="py-2.5"><?= e($contact['email']) ?></td>
                            <td class="py-2.5"><?= e($contact['company'] ?? '—') ?></td>
                            <td class="py-2.5"><?= formatDateTime($contact['created_at']) ?></td>
                            <td class="py-2.5">
                                <?php if (!$contact['is_read']): ?>
                                    <span class="inline-flex items-center px-1.5 py-0.5 bg-brand-accent text-white text-[10px] font-medium">NEU</span>
                                <?php else: ?>
                                    <span class="text-gray-400 text-xs">Gelesen</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="text-sm text-gray-400 py-4 text-center">Noch keine Kontaktanfragen.</p>
    <?php endif; ?>
</div>
