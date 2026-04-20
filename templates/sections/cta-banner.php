<?php
/**
 * CTA Banner Section
 *
 * Leichter, eleganter CTA — kein schwerer Block, sondern fliessend integriert.
 */

$heading  = $content['heading'] ?? '';
$body     = $content['body'] ?? '';
$btnText  = $content['button_text'] ?? '';
$btnUrl   = $content['button_url'] ?? '';
$style    = $content['style'] ?? 'dark';
?>

<section class="py-16 md:py-20">
    <div class="max-w-container mx-auto px-4 md:px-6">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6 md:gap-12">
            <!-- Text -->
            <div class="flex-1">
                <?php if ($heading): ?>
                    <h2 class="text-xl md:text-2xl font-bold text-gray-900 leading-snug mb-2">
                        <?= e($heading) ?>
                    </h2>
                <?php endif; ?>
                <?php if ($body): ?>
                    <p class="text-gray-500 text-sm md:text-base">
                        <?= renderRichtext($body) ?>
                    </p>
                <?php endif; ?>
            </div>

            <!-- Button -->
            <?php if ($btnText && $btnUrl): ?>
                <a href="<?= e($btnUrl) ?>"
                   class="flex-shrink-0 inline-flex items-center h-11 px-7 rounded-md bg-brand-accent text-white text-sm font-medium hover:bg-brand-accent-hover transition-colors duration-200">
                    <?= e($btnText) ?>
                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            <?php endif; ?>
        </div>
    </div>
</section>
