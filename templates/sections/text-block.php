<?php
/**
 * Textblock Section
 */
$heading   = $content['heading'] ?? '';
$body      = $content['body'] ?? '';
$alignment = $content['alignment'] ?? 'left';
$isCenter  = ($alignment === 'center');
?>

<section class="section bg-white">
    <div class="section-container <?= $isCenter ? 'text-center' : '' ?>">
        <div class="<?= $isCenter ? 'max-w-3xl mx-auto' : 'max-w-none' ?> fade-in">
            <?php if ($heading): ?>
                <h2 class="section-heading mb-6"><?= e($heading) ?></h2>
            <?php endif; ?>
            <?php if ($body): ?>
                <div class="text-gray-600 leading-relaxed space-y-4 prose prose-gray max-w-none">
                    <?= renderRichtext($body) ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
