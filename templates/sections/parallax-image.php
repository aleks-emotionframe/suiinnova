<?php
/**
 * Parallax Bildstreifen
 *
 * Desktop: background-attachment: fixed.
 * Mobile: JS-basierter Parallax (translateY beim Scrollen).
 */

$imageId    = (int) ($content['image_id'] ?? 0);
$imageUrl   = $imageId ? mediaUrl($imageId) : ($content['image_url'] ?? '');
$height     = $content['height'] ?? 'medium';
$overlayText = $content['overlay_text'] ?? '';

$heightClass = match($height) {
    'small'  => 'h-[300px] md:h-[400px] lg:h-[500px]',
    'large'  => 'h-[500px] md:h-[750px] lg:h-[800px]',
    default  => 'h-[400px] md:h-[600px] lg:h-[650px]',
};

if (!$imageUrl) return;
$uniqueId = 'parallax-' . uniqid();
?>

<section class="relative <?= $heightClass ?> overflow-hidden" id="<?= $uniqueId ?>">
    <!-- Bild (20% grösser als Container für Parallax-Bewegung) -->
    <img src="<?= e($imageUrl) ?>" alt=""
         class="absolute inset-0 w-full object-cover pointer-events-none parallax-img"
         style="height: 130%; top: -15%;"
         loading="lazy"
         data-parallax>

    <!-- Desktop: zusätzlich bg-fixed als Fallback -->
    <div class="absolute inset-0 hidden md:block bg-cover bg-center bg-no-repeat bg-fixed"
         style="background-image: url('<?= e($imageUrl) ?>');">
    </div>
    <!-- Bild auf Desktop verstecken (bg-fixed übernimmt) -->
    <style>
        @media (min-width: 768px) {
            #<?= $uniqueId ?> .parallax-img { display: none; }
        }
    </style>

    <?php $overlayText = trim(strip_tags($overlayText)); ?>
    <?php if ($overlayText): ?>
        <div class="absolute inset-0 bg-black/30"></div>
        <div class="relative z-10 flex items-center justify-center h-full px-6">
            <p class="text-white text-lg md:text-2xl lg:text-3xl font-bold uppercase tracking-wider text-center"
               style="text-shadow: 0 2px 12px rgba(0,0,0,0.4);">
                <?= e($overlayText) ?>
            </p>
        </div>
    <?php endif; ?>
</section>
