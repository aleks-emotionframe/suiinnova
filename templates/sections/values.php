<?php
/**
 * Werte / USPs Section
 *
 * Drei Karten nebeneinander, nummeriert, clean und modern.
 */
$heading = $content['heading'] ?? '';
$items   = $content['items'] ?? [];
?>

<section class="section bg-gray-900 text-white">
    <div class="section-container">
        <?php if ($heading): ?>
            <div class="mb-10 md:mb-14 fade-in">
                <h2 class="text-2xl md:text-3xl font-bold uppercase tracking-wider"><?= e($heading) ?></h2>
            </div>
        <?php endif; ?>

        <?php if ($items): ?>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">
                <?php foreach ($items as $i => $item): ?>
                    <div class="fade-in">
                        <!-- Nummer -->
                        <div class="text-5xl md:text-6xl font-bold text-white/10 mb-4">
                            0<?= $i + 1 ?>
                        </div>
                        <!-- Titel -->
                        <h3 class="text-base font-bold uppercase tracking-wider text-white mb-3">
                            <?= e($item['title'] ?? '') ?>
                        </h3>
                        <!-- Text -->
                        <div class="text-white/50 text-sm leading-relaxed">
                            <?= renderRichtext($item['desc'] ?? '') ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
