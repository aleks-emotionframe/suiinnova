<?php
/**
 * Info-Streifen Section
 */

$text      = $content['text'] ?? '';
$linkText  = $content['link_text'] ?? '';
$linkUrl   = $content['link_url'] ?? '';
$isVisible = (bool) ($content['is_visible'] ?? true);

if (!$isVisible || !$text) return;
?>

<div class="bg-gray-50">
    <!-- Roter Streifen -->
    <div class="w-full py-3 md:py-3.5" style="background-color: #C41018;">
        <div class="max-w-container mx-auto px-4 md:px-6 flex items-center justify-center gap-3 flex-wrap text-center">
            <p class="text-white text-xs md:text-sm font-medium">
                <?= e($text) ?>
            </p>
            <?php if ($linkText && $linkUrl): ?>
                <a href="<?= e($linkUrl) ?>"
                   class="inline-flex items-center gap-1 text-xs font-bold text-white underline underline-offset-2 hover:text-white/80 transition-colors duration-200">
                    <?= e($linkText) ?>
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            <?php endif; ?>
        </div>
    </div>
    <!-- Grauer Abstand -->
    <div class="h-10 md:h-14"></div>
</div>
