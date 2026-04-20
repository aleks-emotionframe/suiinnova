<?php
/**
 * Bild + Text Section
 */
$heading = $content['heading'] ?? '';
$body    = $content['body'] ?? '';
$imageId = (int) ($content['image_id'] ?? 0);
$layout  = $content['layout'] ?? 'image-left';
$imgUrl  = $imageId ? mediaUrl($imageId) : ($content['image_url'] ?? '');
$isRight = ($layout === 'image-right');
?>

<section class="section bg-white">
    <div class="section-container">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12 items-center">
            <!-- Bild -->
            <div class="<?= $isRight ? 'md:order-2' : '' ?> fade-in">
                <div class="aspect-[4/3] bg-gray-100 overflow-hidden rounded-lg">
                    <?php if ($imgUrl): ?>
                        <img src="<?= e($imgUrl) ?>" alt="<?= e($heading) ?>"
                             class="w-full h-full object-cover" loading="lazy">
                    <?php endif; ?>
                </div>
            </div>
            <!-- Text -->
            <div class="<?= $isRight ? 'md:order-1' : '' ?> fade-in">
                <?php if ($heading): ?>
                    <h2 class="section-heading mb-6"><?= e($heading) ?></h2>
                <?php endif; ?>
                <?php if ($body): ?>
                    <div class="text-gray-600 leading-relaxed space-y-4"><?= renderRichtext($body) ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
