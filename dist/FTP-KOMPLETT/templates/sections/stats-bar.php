<?php
/**
 * Zahlen & Fakten Streifen
 *
 * Horizontale Reihe mit grossen Zahlen + Labels.
 */

$items = $content['items'] ?? [];
$style = $content['style'] ?? 'light';
$isDark = ($style === 'dark');

if (empty($items)) return;
?>

<section class="<?= $isDark ? 'bg-gray-900 text-white' : 'bg-gray-50' ?> py-12 md:py-16">
    <div class="max-w-container mx-auto px-4 md:px-6">
        <div class="grid grid-cols-2 md:grid-cols-<?= min(count($items), 4) ?> gap-8 md:gap-4 text-center">
            <?php foreach ($items as $item): ?>
                <div class="fade-in">
                    <div class="text-3xl md:text-4xl lg:text-5xl font-bold <?= $isDark ? 'text-white' : 'text-gray-900' ?> mb-1">
                        <?= e($item['number'] ?? '') ?>
                    </div>
                    <div class="text-xs md:text-sm uppercase tracking-wider <?= $isDark ? 'text-white/50' : 'text-gray-500' ?>">
                        <?= e($item['label'] ?? '') ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
