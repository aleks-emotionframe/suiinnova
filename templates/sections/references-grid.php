<?php
/**
 * Referenzen Grid Section
 *
 * Responsive Grid mit Projekt-Karten (Bild + Titel + Beschreibung).
 * DESIGN.md: 1 col mobile → 2 col tablet → 3 col desktop, Background-Tint Cards.
 */

$heading  = $content['heading'] ?? '';
$subtitle = $content['subtitle'] ?? '';
$items    = $content['items'] ?? [];
$btnText  = $content['button_text'] ?? '';
$btnUrl   = $content['button_url'] ?? '';
$limit    = (int) ($content['limit'] ?? 0);

// Wenn keine Items manuell gesetzt sind → globale Referenzen aus DB laden
// → eine Aenderung wirkt auf allen Seiten gleichzeitig
if (empty($items)) {
    $items = getGlobalReferences($limit > 0 ? $limit : null);
}
?>

<section class="section bg-white" id="referenzen">
    <div class="section-container">
        <!-- Header -->
        <div class="mb-12 md:mb-16 fade-in">
            <?php if ($heading): ?>
                <h2 class="section-heading"><?= e($heading) ?></h2>
            <?php endif; ?>
            <?php if ($subtitle): ?>
                <div class="section-subtitle"><?= renderRichtext($subtitle) ?></div>
            <?php endif; ?>
        </div>

        <!-- References Grid -->
        <?php if ($items): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12 md:gap-6">
                <?php foreach ($items as $item): ?>
                    <div class="group fade-in">
                        <!-- Image -->
                        <div class="aspect-[4/3] bg-gray-100 overflow-hidden rounded-lg mb-4">
                            <?php
                            $imgId = (int) ($item['image_id'] ?? 0);
                            $imgUrl = $imgId ? mediaUrl($imgId) : ($item['image_url'] ?? '');
                            ?>
                            <?php if ($imgUrl): ?>
                                <img
                                    src="<?= e($imgUrl) ?>"
                                    alt="<?= e($item['title'] ?? '') ?>"
                                    class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-[1.03]"
                                    loading="lazy"
                                >
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center text-gray-300">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v13.5A1.5 1.5 0 003.75 21z"/>
                                    </svg>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Info -->
                        <div>
                            <?php if (!empty($item['title'])): ?>
                                <h3 class="text-base font-medium uppercase tracking-wider text-gray-900 mb-1">
                                    <?= e($item['title']) ?>
                                </h3>
                            <?php endif; ?>

                            <div class="flex items-center gap-3 text-xs text-gray-500 mb-2">
                                <?php if (!empty($item['location'])): ?>
                                    <span><?= e($item['location']) ?></span>
                                <?php endif; ?>
                                <?php if (!empty($item['year'])): ?>
                                    <span>&middot;</span>
                                    <span><?= e($item['year']) ?></span>
                                <?php endif; ?>
                            </div>

                            <?php if (!empty($item['desc'])): ?>
                                <div class="text-gray-600 text-sm leading-relaxed">
                                    <?= renderRichtext($item['desc']) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Button -->
        <?php if ($btnText && $btnUrl): ?>
            <div class="mt-10 text-center fade-in">
                <a href="<?= e($btnUrl) ?>" class="btn-secondary">
                    <?= e($btnText) ?>
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>
