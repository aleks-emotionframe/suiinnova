<?php
/**
 * Hero Banner Section
 *
 * Style wie Referenz: Titel gross, Tagline, Beschreibung, 2 Buttons (rot + outline).
 * Text links, Bild rechts sichtbar.
 */

$heading    = $content['heading'] ?? '';
$tagline    = $content['tagline'] ?? '';
$subheading = $content['subheading'] ?? '';
$imageId    = (int) ($content['image_id'] ?? 0);
$btnText    = $content['button_text'] ?? '';
$btnUrl     = $content['button_url'] ?? '';
$btn2Text   = $content['button2_text'] ?? '';
$btn2Url    = $content['button2_url'] ?? '';
$opacity    = $content['overlay_opacity'] ?? '0.7';

$bgImage = $imageId ? mediaUrl($imageId) : asset('img/hero-placeholder.jpg');
?>

<section class="relative w-full overflow-hidden bg-gray-900" style="height: 100svh; height: 100vh;">
    <!-- Hintergrundbild -->
    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" style="background-image: url('<?= e($bgImage) ?>');">
    </div>

    <!-- Gradient Overlay: Mobile stärker, Desktop links dunkel rechts hell -->
    <div class="absolute inset-0 md:hidden" style="background: rgba(0,0,0,0.7);"></div>
    <div class="absolute inset-0 hidden md:block" style="background: linear-gradient(105deg, rgba(0,0,0,0.82) 0%, rgba(0,0,0,0.65) 40%, rgba(0,0,0,0.2) 75%, rgba(0,0,0,0.1) 100%);"></div>

    <!-- Content: links unten -->
    <div class="relative z-10 flex items-end h-full px-5 md:px-12 lg:px-20 pb-10 md:pb-20 lg:pb-24">
        <div class="max-w-2xl">
            <!-- Heading -->
            <?php if ($heading): ?>
                <h1 class="text-[1.6rem] md:text-4xl lg:text-5xl font-bold uppercase tracking-wider leading-tight mb-3 md:mb-4 fade-in"
                    style="
                        background: linear-gradient(180deg, #FFFFFF 0%, #E0E0E0 40%, #FFFFFF 55%, rgba(255,255,255,0.7) 100%);
                        -webkit-background-clip: text;
                        -webkit-text-fill-color: transparent;
                        background-clip: text;
                        filter: drop-shadow(0 4px 12px rgba(0,0,0,0.5)) drop-shadow(0 1px 2px rgba(255,255,255,0.15));
                    ">
                    <?= strip_tags($heading, '<strong><b><em><i>') ?>
                </h1>
            <?php endif; ?>

            <!-- Tagline -->
            <?php if ($tagline): ?>
                <p class="text-[11px] md:text-sm text-white/80 font-medium uppercase tracking-wider mb-4 md:mb-5 fade-in">
                    <?= strip_tags($tagline, '<strong><b><em><i>') ?>
                </p>
            <?php endif; ?>

            <!-- Beschreibung -->
            <?php if ($subheading): ?>
                <p class="text-xs md:text-sm text-white/60 max-w-lg mb-6 md:mb-8 leading-relaxed fade-in">
                    <?= renderRichtext($subheading) ?>
                </p>
            <?php endif; ?>

            <!-- Buttons -->
            <div class="flex flex-wrap items-center gap-3 fade-in">
                <?php if ($btnText && $btnUrl): ?>
                    <a href="<?= e($btnUrl) ?>"
                       class="inline-flex items-center h-11 px-6 rounded-md bg-brand-accent text-white text-sm font-medium hover:bg-brand-accent-hover transition-colors duration-200">
                        <?= e($btnText) ?>
                    </a>
                <?php endif; ?>

                <?php if ($btn2Text && $btn2Url): ?>
                    <a href="<?= e($btn2Url) ?>"
                       class="inline-flex items-center h-11 px-6 rounded-md bg-transparent text-white text-sm font-medium border border-white/30 hover:bg-white/10 hover:border-white/50 transition-all duration-200">
                        <?= e($btn2Text) ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
