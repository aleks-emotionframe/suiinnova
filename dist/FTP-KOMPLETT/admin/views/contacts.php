<?php
/**
 * Admin — Kontaktanfragen
 */
$contacts = $db->fetchAll("SELECT * FROM contacts ORDER BY created_at DESC");
?>

<div x-data="contactsManager()">
    <?php if ($contacts): ?>
        <div class="space-y-3">
            <?php foreach ($contacts as $contact): ?>
                <div class="admin-card <?= !$contact['is_read'] ? 'border-l-2 border-l-brand-accent' : '' ?>"
                     x-data="{ expanded: false }">

                    <!-- Header -->
                    <div class="flex items-center justify-between cursor-pointer" @click="expanded = !expanded; <?= !$contact['is_read'] ? "markAsRead({$contact['id']})" : '' ?>">
                        <div class="flex items-center gap-4">
                            <?php if (!$contact['is_read']): ?>
                                <span class="w-2 h-2 bg-brand-accent rounded-full flex-shrink-0"></span>
                            <?php else: ?>
                                <span class="w-2 h-2 bg-gray-200 rounded-full flex-shrink-0"></span>
                            <?php endif; ?>

                            <div>
                                <span class="text-sm font-medium text-gray-900"><?= e($contact['name']) ?></span>
                                <?php if ($contact['company']): ?>
                                    <span class="text-xs text-gray-400 ml-2"><?= e($contact['company']) ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-xs text-gray-400"><?= formatDateTime($contact['created_at']) ?></span>
                            <svg class="w-4 h-4 text-gray-400 transition-transform duration-200"
                                 :class="{ 'rotate-180': expanded }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>

                    <!-- Body -->
                    <div x-show="expanded" x-transition class="mt-4 pt-4 border-t border-gray-100">
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4 text-sm">
                            <div>
                                <span class="text-[10px] uppercase tracking-wider text-gray-400 block">E-Mail</span>
                                <a href="mailto:<?= e($contact['email']) ?>" class="text-gray-900 hover:text-brand-accent">
                                    <?= e($contact['email']) ?>
                                </a>
                            </div>
                            <?php if ($contact['phone']): ?>
                                <div>
                                    <span class="text-[10px] uppercase tracking-wider text-gray-400 block">Telefon</span>
                                    <?= e($contact['phone']) ?>
                                </div>
                            <?php endif; ?>
                            <?php if ($contact['company']): ?>
                                <div>
                                    <span class="text-[10px] uppercase tracking-wider text-gray-400 block">Firma</span>
                                    <?= e($contact['company']) ?>
                                </div>
                            <?php endif; ?>
                            <div>
                                <span class="text-[10px] uppercase tracking-wider text-gray-400 block">Quelle</span>
                                /<?= e($contact['page_source'] ?? '—') ?>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-4 text-sm text-gray-700 leading-relaxed">
                            <?= nl2br(e($contact['message'])) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="admin-card text-center py-12">
            <p class="text-sm text-gray-400">Noch keine Kontaktanfragen eingegangen.</p>
        </div>
    <?php endif; ?>
</div>
