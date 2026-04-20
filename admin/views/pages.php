<?php
/**
 * Admin — Seitenübersicht
 */
$pages = $db->fetchAll("SELECT * FROM pages ORDER BY sort_order ASC");
?>

<div class="admin-card" x-data="pagesToggle()">
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
                    <tr class="border-b border-gray-50" :class="inactiveIds.includes(<?= (int)$page['id'] ?>) ? 'opacity-60' : ''" data-page-id="<?= (int)$page['id'] ?>">
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
                            <span x-show="!inactiveIds.includes(<?= (int)$page['id'] ?>)"
                                  class="inline-flex items-center px-1.5 py-0.5 bg-gray-900 text-white text-[10px] font-medium"
                                  <?= !$page['is_active'] ? 'style="display:none"' : '' ?>>ONLINE</span>
                            <span x-show="inactiveIds.includes(<?= (int)$page['id'] ?>)"
                                  class="inline-flex items-center px-1.5 py-0.5 bg-amber-500 text-white text-[10px] font-medium"
                                  <?= $page['is_active'] ? 'style="display:none"' : '' ?>>OFFLINE</span>
                        </td>
                        <td class="py-3 text-gray-500"><?= $sectionCount ?></td>
                        <td class="py-3 text-gray-400 text-xs"><?= formatDateTime($page['updated_at']) ?></td>
                        <td class="py-3 text-right">
                            <div class="inline-flex items-center gap-2">
                                <?php if ($page['is_homepage']): ?>
                                    <span class="inline-flex items-center text-[11px] text-gray-400 px-2" title="Die Startseite ist immer online">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 11c0-1.105.895-2 2-2s2 .895 2 2v2H8v-2c0-1.105.895-2 2-2zm0 0V9a4 4 0 118 0v2M5 13h14v8H5z"/></svg>
                                        Immer online
                                    </span>
                                <?php else: ?>
                                    <button type="button"
                                            @click="togglePage(<?= (int)$page['id'] ?>, $event)"
                                            class="text-xs h-7 px-3 inline-flex items-center font-medium uppercase tracking-wider border transition-colors"
                                            :class="inactiveIds.includes(<?= (int)$page['id'] ?>)
                                                ? 'bg-green-600 text-white border-green-600 hover:bg-green-700'
                                                : 'bg-amber-500 text-white border-amber-500 hover:bg-amber-600'">
                                        <span x-show="!inactiveIds.includes(<?= (int)$page['id'] ?>)" <?= !$page['is_active'] ? 'style="display:none"' : '' ?>>Offline nehmen</span>
                                        <span x-show="inactiveIds.includes(<?= (int)$page['id'] ?>)" <?= $page['is_active'] ? 'style="display:none"' : '' ?>>Online stellen</span>
                                    </button>
                                <?php endif; ?>
                                <a href="<?= url('admin/pages/edit/' . $page['id']) ?>" class="admin-btn-secondary text-xs h-7 px-3">
                                    Bearbeiten
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Toast -->
    <div x-show="toast.show" x-transition x-cloak
         class="fixed bottom-6 right-6 px-4 py-3 text-sm font-medium shadow-lg z-50"
         :class="toast.type === 'error' ? 'bg-red-600 text-white' : 'bg-gray-900 text-white'"
         x-text="toast.message"></div>
</div>

<script>
function pagesToggle() {
    return {
        inactiveIds: <?= json_encode(array_values(array_map(fn($p) => (int)$p['id'], array_filter($pages, fn($p) => !$p['is_active'])))) ?>,
        toast: { show: false, type: 'success', message: '' },

        async togglePage(pageId, event) {
            const btn = event.currentTarget;
            btn.disabled = true;
            btn.style.opacity = '0.6';

            const formData = new FormData();
            formData.append('page_id', pageId);
            formData.append('csrf_token', CSRF_TOKEN);

            try {
                const resp = await fetch('/admin/api/toggle-page.php', { method: 'POST', body: formData });
                const data = await resp.json();

                if (data.error) {
                    this.showToast(data.error, 'error');
                } else {
                    if (data.is_active === 1) {
                        this.inactiveIds = this.inactiveIds.filter(id => id !== pageId);
                    } else {
                        if (!this.inactiveIds.includes(pageId)) this.inactiveIds.push(pageId);
                    }
                    this.showToast(data.message, 'success');
                }
            } catch (e) {
                this.showToast('Netzwerkfehler', 'error');
            } finally {
                btn.disabled = false;
                btn.style.opacity = '1';
            }
        },

        showToast(message, type) {
            this.toast = { show: true, type, message };
            setTimeout(() => { this.toast.show = false; }, 3500);
        }
    };
}
</script>
