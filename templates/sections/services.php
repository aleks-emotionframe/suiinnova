<?php
/**
 * Leistungen Section
 *
 * Karten mit Bild: Bild links | Text rechts (weisser Hintergrund)
 * Karten ohne Bild: Dunkler Hintergrund, nur Text (weisse Schrift)
 * 2er-Reihen, linke Karte breiter (~60%), rechte schmaler (~40%)
 *
 * Beschreibungstext wird komplett gerendert (renderRichtext) → Absaetze, Bullets, etc. funktionieren.
 */

$heading  = $content['heading'] ?? '';
$subtitle = $content['subtitle'] ?? '';
$items    = $content['items'] ?? [];
?>

<section class="section bg-gray-50" id="leistungen">
    <div class="section-container">
        <!-- Header -->
        <div class="mb-10 md:mb-14 fade-in">
            <?php if ($heading): ?>
                <h2 class="section-heading"><?= e($heading) ?></h2>
            <?php endif; ?>
            <?php if ($subtitle): ?>
                <div class="section-subtitle"><?= renderRichtext($subtitle) ?></div>
            <?php endif; ?>
        </div>

        <!-- Cards in 2er-Reihen -->
        <?php if ($items): ?>
            <?php $chunks = array_chunk($items, 2); ?>
            <?php foreach ($chunks as $rowIdx => $row): ?>
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4 <?= $rowIdx > 0 ? 'mt-4' : '' ?> fade-in">
                    <?php foreach ($row as $colIdx => $item): ?>
                        <?php
                        $imgId    = (int) ($item['image_id'] ?? 0);
                        $imgUrl   = $imgId ? mediaUrl($imgId) : ($item['image_url'] ?? '');
                        $title    = $item['title'] ?? '';
                        $desc     = $item['desc'] ?? '';
                        $link     = $item['link'] ?? '';
                        $linkText = $item['link_text'] ?? 'Jetzt entdecken';

                        // Erste Karte = breiter (3/5), zweite = schmaler (2/5)
                        $colSpan  = ($colIdx === 0) ? 'md:col-span-3' : 'md:col-span-2';
                        $hasImage = !empty($imgUrl);
                        ?>

                        <?php if ($hasImage): ?>
                            <!-- Karte MIT Bild -->
                            <div class="group bg-white rounded-lg overflow-hidden <?= $colSpan ?>">
                                <div class="grid grid-cols-1 sm:grid-cols-2 h-full">
                                    <div class="aspect-[4/3] sm:aspect-auto overflow-hidden">
                                        <img src="<?= e($imgUrl) ?>" alt="<?= e($title) ?>"
                                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                             loading="lazy">
                                    </div>
                                    <div class="flex flex-col justify-center p-5 md:p-7">
                                        <p class="text-sm font-bold uppercase tracking-wider text-brand-accent mb-3"><?= e($title) ?></p>
                                        <?php if ($desc): ?>
                                            <div class="services-card-text" style="color:#1F2937;"><?= renderRichtext($desc) ?></div>
                                        <?php endif; ?>
                                        <?php if ($link): ?>
                                            <a href="<?= e($link) ?>" class="inline-flex items-center gap-1.5 text-[11px] font-medium text-gray-900 hover:text-brand-accent transition-colors duration-200 mt-3">
                                                → <?= e($linkText) ?>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                        <?php else: ?>
                            <!-- Karte OHNE Bild (dunkler Hintergrund) -->
                            <div class="group bg-gray-900 rounded-lg overflow-hidden <?= $colSpan ?>">
                                <div class="flex flex-col justify-center p-6 md:p-8 h-full min-h-[180px]">
                                    <p class="text-sm font-bold uppercase tracking-wider text-brand-accent mb-3"><?= e($title) ?></p>
                                    <?php if ($desc): ?>
                                        <div class="services-card-text services-card-text--dark" style="color:rgba(255,255,255,0.85);"><?= renderRichtext($desc) ?></div>
                                    <?php endif; ?>
                                    <?php if ($link): ?>
                                        <a href="<?= e($link) ?>" class="inline-flex items-center gap-1.5 text-[11px] font-medium transition-colors duration-200 mt-3" style="color:rgba(255,255,255,0.7);"
                                           onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(255,255,255,0.7)'">
                                            → <?= e($linkText) ?>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>

<style>
    /* Beschreibungstexte in den Service-Karten: normales Gewicht, gute Lesbarkeit, Absaetze */
    .services-card-text {
        font-size: 15px;
        line-height: 1.65;
        font-weight: 400;
    }
    @media (min-width: 768px) {
        .services-card-text { font-size: 16px; }
    }
    .services-card-text p {
        font-size: inherit !important;
        line-height: inherit !important;
        font-weight: inherit !important;
        color: inherit !important;
        margin: 0 0 0.85em 0;
    }
    .services-card-text p:last-child { margin-bottom: 0; }
    .services-card-text strong { font-weight: 600; }
    .services-card-text ul, .services-card-text ol {
        margin: 0.5em 0 0.85em 1.25em;
        padding: 0;
    }
    .services-card-text li { margin-bottom: 0.25em; }
</style>
