<?php
/**
 * Leistungen Section
 *
 * 1:1 Geberit-Style:
 * - Karten mit Bild: Bild links | Text rechts (weisser Hintergrund)
 * - Karten ohne Bild: Dunkler Hintergrund, nur Text (weisse Schrift)
 * - 2er-Reihen, linke Karte breiter (~60%), rechte schmaler (~40%)
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
                        $imgId = (int) ($item['image_id'] ?? 0);
                        $imgUrl = $imgId ? mediaUrl($imgId) : ($item['image_url'] ?? '');
                        $title = $item['title'] ?? '';
                        $desc = $item['desc'] ?? '';
                        $link = $item['link'] ?? '';
                        $linkText = $item['link_text'] ?? 'Jetzt entdecken';

                        // Intro extrahieren
                        $lines = preg_split('/\n|\r\n?/', $desc);
                        $intro = '';
                        foreach ($lines as $line) {
                            $line = trim($line);
                            if (!preg_match('/^[\x{2022}\x{2023}\x{25E6}\x{2043}\-\*•]/u', $line) && $line !== '') {
                                $intro = $line;
                                break;
                            }
                        }

                        // Erste Karte = breiter (3/5), zweite = schmaler (2/5)
                        $colSpan = ($colIdx === 0) ? 'md:col-span-3' : 'md:col-span-2';
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
                                        <p class="text-sm font-bold uppercase tracking-wider text-brand-accent mb-1"><?= e($title) ?></p>
                                        <?php if ($intro): ?>
                                            <h3 class="text-sm md:text-base font-bold text-gray-900 leading-snug mb-2"><?= renderRichtext($intro) ?></h3>
                                        <?php endif; ?>
                                        <?php if ($link): ?>
                                            <a href="<?= e($link) ?>" class="inline-flex items-center gap-1.5 text-[11px] font-medium text-gray-900 hover:text-brand-accent transition-colors duration-200 mt-1">
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
                                    <p class="text-sm font-bold uppercase tracking-wider text-brand-accent mb-1"><?= e($title) ?></p>
                                    <?php if ($intro): ?>
                                        <h3 class="text-sm md:text-base font-bold text-white leading-snug mb-2"><?= renderRichtext($intro) ?></h3>
                                    <?php endif; ?>
                                    <?php if ($link): ?>
                                        <a href="<?= e($link) ?>" class="inline-flex items-center gap-1.5 text-[11px] font-medium text-white/70 hover:text-white transition-colors duration-200 mt-1">
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
