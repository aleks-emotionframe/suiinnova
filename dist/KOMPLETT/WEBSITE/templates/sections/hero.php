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
    <!-- Hintergrundbild
         Frueher ein div mit background-image. Als <img> kann der Browser das
         Bild beim Einlesen des Markups entdecken und sofort laden, statt erst
         nach dem Auswerten der Stile. Das ist auf jeder Seite das groesste
         sichtbare Element und bestimmt damit die gemessene Ladezeit. -->
    <?php if ($imageId): ?>
        <?= responsiveImg($imageId, [
            'alt'           => '',
            'sizes'         => '100vw',
            'loading'       => 'eager',
            'fetchpriority' => 'high',
            'class'         => 'absolute inset-0 w-full h-full object-cover',
        ]) ?>
    <?php else: ?>
        <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" style="background-image: url('<?= e($bgImage) ?>');"></div>
    <?php endif; ?>

    <!-- Gradient Overlay: Mobile stärker, Desktop links dunkel rechts hell -->
    <div class="absolute inset-0 md:hidden" style="background: rgba(0,0,0,0.7);"></div>
    <!-- Dunkel genug ueber der Textspalte, rechts bleibt das Bild sichtbar.
         Der mittlere Stop liegt bei 50 statt 45 Prozent und der dritte bei 85
         statt 75: auf Tablet-Breiten reicht die Ueberschrift bis rund 90
         Prozent, und dort deckte der alte Verlauf nur noch 0,18 — weisse
         Schrift auf einem hellen Foto waere nicht mehr lesbar gewesen. -->
    <div class="absolute inset-0 hidden md:block" style="background: linear-gradient(105deg, rgba(0,0,0,0.84) 0%, rgba(0,0,0,0.70) 50%, rgba(0,0,0,0.42) 85%, rgba(0,0,0,0.12) 100%);"></div>

    <!-- Content: links unten -->
    <div class="relative z-10 flex items-end h-full px-5 md:px-12 lg:px-20 pb-10 md:pb-20 lg:pb-24">
        <div class="hero-text-col">
            <!-- Heading -->
            <?php if ($heading): ?>
                <<?= $hTag = headingTag() ?> class="page-hero-title text-[1.6rem] md:text-4xl lg:text-5xl font-bold uppercase tracking-wider leading-tight mb-3 md:mb-4 fade-in"
                    style="
                        background: linear-gradient(180deg, #FFFFFF 0%, #E0E0E0 40%, #FFFFFF 55%, rgba(255,255,255,0.7) 100%);
                        -webkit-background-clip: text;
                        -webkit-text-fill-color: transparent;
                        background-clip: text;
                        filter: drop-shadow(0 4px 12px rgba(0,0,0,0.5)) drop-shadow(0 1px 2px rgba(255,255,255,0.15));
                    ">
                    <?= strip_tags($heading, '<strong><b><em><i>') ?>
                </<?= $hTag ?>>
            <?php endif; ?>

            <!-- Tagline -->
            <?php if ($tagline): ?>
                <p class="text-[12px] md:text-sm text-white/80 font-medium uppercase tracking-wider mb-4 md:mb-5 fade-in">
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
