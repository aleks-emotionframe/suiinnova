<?php
/**
 * Team Grid Section
 */
$heading = $content['heading'] ?? '';
$items   = $content['items'] ?? [];
?>

<section class="section bg-white">
    <div class="section-container">
        <?php if ($heading): ?>
            <div class="mb-10 md:mb-14 fade-in">
                <h2 class="section-heading"><?= e($heading) ?></h2>
            </div>
        <?php endif; ?>

        <?php if ($items): ?>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 md:gap-8">
                <?php foreach ($items as $member): ?>
                    <?php $imgUrl = !empty($member['image_id']) ? mediaUrl((int)$member['image_id']) : ''; ?>
                    <div class="group fade-in">
                        <div class="aspect-[3/4] bg-gray-100 rounded-lg overflow-hidden mb-4">
                            <?php if ($imgUrl): ?>
                                <img src="<?= e($imgUrl) ?>" alt="<?= e($member['name'] ?? '') ?>"
                                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                     loading="lazy">
                            <?php else: ?>
                                <!-- Platzhalter -->
                                <div class="w-full h-full flex flex-col items-center justify-center text-gray-300">
                                    <svg class="w-16 h-16 mb-3 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="0.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                                    </svg>
                                    <span class="text-[10px] text-gray-300 uppercase tracking-wider">Foto folgt</span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <h3 class="text-sm font-bold text-gray-900"><?= e($member['name'] ?? '') ?></h3>
                        <p class="text-xs text-gray-500 mt-0.5"><?= e($member['role'] ?? '') ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
