<?php
/**
 * Admin — Seitenübersicht
 */
$pages = $db->fetchAll("SELECT * FROM pages ORDER BY sort_order ASC");
?>

<div class="admin-card">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-200">
                    <th class="text-left text-[10px] uppercase tracking-wider text-gray-400 font-medium pb-3">Seite</th>
                    <th class="text-left text-[10px] uppercase tracking-wider text-gray-400 font-medium pb-3">Slug</th>
                    <th class="text-left text-[10px] uppercase tracking-wider text-gray-400 font-medium pb-3">Status</th>
                    <th class="text-left text-[10px] uppercase tracking-wider text-gray-400 font-medium pb-3">Sektionen</th>
                    <th class="text-left text-[10px] uppercase tracking-wider text-gray-400 font-medium pb-3">Geändert</th>
                    <th class="text-right text-[10px] uppercase tracking-wider text-gray-400 font-medium pb-3">Aktion</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pages as $page): ?>
                    <?php
                    $sectionCount = (int) $db->fetchColumn(
                        "SELECT COUNT(*) FROM sections WHERE page_id = :pid",
                        ['pid' => $page['id']]
                    );
                    ?>
                    <tr class="border-b border-gray-50">
                        <td class="py-3">
                            <div class="flex items-center gap-2">
                                <?php if ($page['is_homepage']): ?>
                                    <svg class="w-3.5 h-3.5 text-brand-accent" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                                    </svg>
                                <?php endif; ?>
                                <span class="font-medium text-gray-900"><?= e($page['title']) ?></span>
                            </div>
                        </td>
                        <td class="py-3 text-gray-500">/<?= e($page['slug']) ?></td>
                        <td class="py-3">
                            <?php if ($page['is_active']): ?>
                                <span class="inline-flex items-center px-1.5 py-0.5 bg-gray-900 text-white text-[10px] font-medium">AKTIV</span>
                            <?php else: ?>
                                <span class="inline-flex items-center px-1.5 py-0.5 bg-gray-200 text-gray-600 text-[10px] font-medium">ENTWURF</span>
                            <?php endif; ?>
                        </td>
                        <td class="py-3 text-gray-500"><?= $sectionCount ?></td>
                        <td class="py-3 text-gray-400 text-xs"><?= formatDateTime($page['updated_at']) ?></td>
                        <td class="py-3 text-right">
                            <a href="<?= url('admin/pages/edit/' . $page['id']) ?>" class="admin-btn-secondary text-xs h-7 px-3">
                                Bearbeiten
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
