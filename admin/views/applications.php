<?php
/**
 * Admin — Bewerbungen
 */
$applications = $db->fetchAll("SELECT * FROM applications ORDER BY created_at DESC");
?>

<div x-data="applicationsManager()">
    <?php if ($applications): ?>
        <div class="space-y-3">
            <?php foreach ($applications as $app): ?>
                <?php $files = json_decode($app['files'] ?? '[]', true) ?: []; ?>
                <div class="admin-card <?= !$app['is_read'] ? 'border-l-2 border-l-brand-accent' : '' ?>"
                     x-data="{ expanded: false }">

                    <!-- Header -->
                    <div class="flex items-center justify-between cursor-pointer" @click="expanded = !expanded; <?= !$app['is_read'] ? "markAsRead({$app['id']})" : '' ?>">
                        <div class="flex items-center gap-4">
                            <?php if (!$app['is_read']): ?>
                                <span class="w-2 h-2 bg-brand-accent rounded-full flex-shrink-0"></span>
                            <?php else: ?>
                                <span class="w-2 h-2 bg-gray-200 rounded-full flex-shrink-0"></span>
                            <?php endif; ?>

                            <div>
                                <span class="text-sm font-medium text-gray-900"><?= e($app['name']) ?></span>
                                <?php if ($app['position']): ?>
                                    <span class="text-xs text-gray-500 ml-2"><?= e($app['position']) ?></span>
                                <?php endif; ?>
                            </div>

                            <?php if (count($files) > 0): ?>
                                <span class="inline-flex items-center gap-1 text-xs text-gray-500">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                    </svg>
                                    <?= count($files) ?> Datei<?= count($files) !== 1 ? 'en' : '' ?>
                                </span>
                            <?php endif; ?>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-xs text-gray-400"><?= formatDateTime($app['created_at']) ?></span>
                            <svg class="w-4 h-4 text-gray-400 transition-transform duration-200"
                                 :class="{ 'rotate-180': expanded }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>

                    <!-- Body -->
                    <div x-show="expanded" x-collapse class="mt-4 pt-4 border-t border-gray-100 space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                            <div>
                                <div class="text-[10px] uppercase tracking-wider text-gray-400 mb-1">E-Mail</div>
                                <a href="mailto:<?= e($app['email']) ?>" class="text-gray-900 hover:text-brand-accent"><?= e($app['email']) ?></a>
                            </div>
                            <?php if ($app['phone']): ?>
                                <div>
                                    <div class="text-[10px] uppercase tracking-wider text-gray-400 mb-1">Telefon</div>
                                    <a href="tel:<?= e(preg_replace('/\s+/', '', $app['phone'])) ?>" class="text-gray-900 hover:text-brand-accent"><?= e($app['phone']) ?></a>
                                </div>
                            <?php endif; ?>
                            <?php if ($app['position']): ?>
                                <div>
                                    <div class="text-[10px] uppercase tracking-wider text-gray-400 mb-1">Position</div>
                                    <div class="text-gray-900"><?= e($app['position']) ?></div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <?php if ($app['message']): ?>
                            <div>
                                <div class="text-[10px] uppercase tracking-wider text-gray-400 mb-2">Nachricht</div>
                                <div class="text-sm text-gray-700 whitespace-pre-line"><?= e($app['message']) ?></div>
                            </div>
                        <?php endif; ?>

                        <?php if ($files): ?>
                            <div>
                                <div class="text-[10px] uppercase tracking-wider text-gray-400 mb-2">Dokumente</div>
                                <div class="space-y-1.5">
                                    <?php foreach ($files as $f): ?>
                                        <a href="<?= e(uploadUrl($f['path'])) ?>" target="_blank"
                                           class="flex items-center gap-2 px-3 py-2 border border-gray-200 hover:border-gray-900 transition-colors text-sm group">
                                            <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            <span class="flex-1 text-gray-900"><?= e($f['name']) ?></span>
                                            <span class="text-xs text-gray-400"><?= formatFileSize((int)($f['size'] ?? 0)) ?></span>
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3"/>
                                            </svg>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="admin-card text-center py-10">
            <p class="text-sm text-gray-500">Noch keine Bewerbungen eingegangen.</p>
        </div>
    <?php endif; ?>
</div>

<script>
function applicationsManager() {
    return {
        async markAsRead(id) {
            const formData = new FormData();
            formData.append('application_id', id);
            formData.append('csrf_token', CSRF_TOKEN);
            try {
                await fetch('/admin/api/mark-application-read.php', { method: 'POST', body: formData });
            } catch (e) {}
        }
    };
}
</script>
