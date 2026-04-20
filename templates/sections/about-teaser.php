<?php
/**
 * Über uns Teaser Section
 *
 * 50/50 Layout: Bild + Text mit CTA Button.
 * DESIGN.md: Image-Text Split, Square Corners, generous spacing.
 */

$heading  = $content['heading'] ?? '';
$body     = $content['body'] ?? '';
$imageId  = (int) ($content['image_id'] ?? 0);
$layout   = $content['layout'] ?? 'image-left';
$btnText  = $content['button_text'] ?? '';
$btnUrl   = $content['button_url'] ?? '';

$bgImage = $imageId ? mediaUrl($imageId) : ($content['image_url'] ?? '');
$isImageRight = ($layout === 'image-right');
?>

<section class="section bg-gray-50" id="ueber-uns">
    <div class="section-container">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12 items-center">

            <!-- Bild -->
            <div class="<?= $isImageRight ? 'md:order-2' : '' ?> fade-in">
                <?php if ($bgImage): ?>
                    <div class="aspect-[4/3] bg-gray-200 overflow-hidden rounded-lg">
                        <img
                            src="<?= e($bgImage) ?>"
                            alt="<?= e($heading) ?>"
                            class="w-full h-full object-cover transition-transform duration-300 hover:scale-[1.03]"
                            loading="lazy"
                        >
                    </div>
                <?php else: ?>
                    <div class="aspect-[4/3] bg-gray-200 flex items-center justify-center">
                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v13.5A1.5 1.5 0 003.75 21z"/>
                        </svg>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Text -->
            <div class="<?= $isImageRight ? 'md:order-1' : '' ?> fade-in">

                <?php if ($heading): ?>
                    <h2 class="section-heading mb-6"><?= e($heading) ?></h2>
                <?php endif; ?>

                <?php if ($body): ?>
                    <div class="text-gray-600 leading-relaxed space-y-4 mb-8">
                        <?= renderRichtext($body) ?>
                    </div>
                <?php endif; ?>

                <?php if ($btnText && $btnUrl): ?>
                    <a href="<?= e($btnUrl) ?>" class="btn-link">
                        <?= e($btnText) ?>
                        <svg class="w-4 h-4 arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
