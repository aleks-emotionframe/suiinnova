<?php
/**
 * Bildergalerie Section
 */
$heading = $content['heading'] ?? '';
$columns = (int) ($content['columns'] ?? 3);
$images  = $content['images'] ?? [];

$gridCols = match($columns) {
    2 => 'md:grid-cols-2',
    4 => 'md:grid-cols-2 lg:grid-cols-4',
    default => 'md:grid-cols-2 lg:grid-cols-3',
};
?>

<section class="section bg-white">
    <div class="section-container">
        <?php if ($heading): ?>
            <div class="mb-12 fade-in">
                <h2 class="section-heading"><?= e($heading) ?></h2>
            </div>
        <?php endif; ?>

        <?php if ($images): ?>
            <div class="grid grid-cols-1 <?= $gridCols ?> gap-4">
                <?php foreach ($images as $img): ?>
                    <?php $imgUrl = mediaUrl((int)($img['image_id'] ?? 0)); ?>
                    <div class="group overflow-hidden fade-in">
                        <div class="aspect-[4/3] bg-gray-100 overflow-hidden rounded-lg">
                            <?php if ($imgUrl): ?>
                                <img src="<?= e($imgUrl) ?>" alt="<?= e($img['caption'] ?? '') ?>"
                                     class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-[1.03]"
                                     loading="lazy">
                            <?php endif; ?>
                        </div>
                        <?php if (!empty($img['caption'])): ?>
                            <p class="text-xs text-gray-500 mt-2"><?= e($img['caption']) ?></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
