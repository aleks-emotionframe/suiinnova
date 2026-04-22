<?php
/**
 * Werte / USPs Section
 *
 * Drei Karten nebeneinander, clean und modern.
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
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-10">
                <?php foreach ($items as $i => $item): ?>
                    <div class="fade-in">
                        <!-- Roter Akzent-Strich -->
                        <div style="width:40px;height:2px;background:#C41018;margin-bottom:18px;"></div>
                        <!-- Titel (groesser) -->
                        <h3 class="font-bold uppercase tracking-wider text-white mb-4" style="font-size:22px;line-height:1.2;">
                            <?= e($item['title'] ?? '') ?>
                        </h3>
                        <!-- Text -->
                        <div class="text-white/60 text-sm leading-relaxed">
                            <?= renderRichtext($item['desc'] ?? '') ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
