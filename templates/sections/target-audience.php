<?php
/**
 * Zielgruppen Section
 *
 * Karten mit Icon/Nummer, Titel und Text für jede Zielgruppe.
 */

$heading = $content['heading'] ?? '';
$body    = $content['body'] ?? '';
$items   = $content['items'] ?? [];

// Falls kein Repeater, Text in Items parsen (Fallback für bestehende Daten)
if (empty($items) && $body) {
    // Versuche <strong>Titel</strong> Text Muster zu parsen
    preg_match_all('/<strong>([^<]+)<\/strong>\s*([^<]+(?:<[^s][^>]*>[^<]*<\/[^>]+>)*[^<]*)/u', $body, $matches, PREG_SET_ORDER);
    foreach ($matches as $m) {
        $items[] = ['title' => trim($m[1]), 'desc' => trim(strip_tags($m[2]))];
    }
}
?>

<section class="section bg-white">
    <div class="section-container">
        <?php if ($heading): ?>
            <div class="mb-10 md:mb-14 fade-in">
                <h2 class="section-heading"><?= e($heading) ?></h2>
            </div>
        <?php endif; ?>

        <?php if ($items): ?>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <?php foreach ($items as $i => $item): ?>
                    <div class="group p-6 md:p-8 bg-gray-50 rounded-lg hover:bg-gray-900 transition-all duration-300 fade-in">
                        <!-- Roter Akzent-Strich -->
                        <div style="width:40px;height:2px;background:#C41018;margin-bottom:18px;" class="group-hover:brightness-125 transition-all duration-300"></div>
                        <!-- Titel -->
                        <h3 class="font-bold uppercase tracking-wider text-gray-900 group-hover:text-white mb-3 transition-colors duration-300">
                            <?= e($item['title'] ?? '') ?>
                        </h3>
                        <!-- Text -->
                        <div class="text-gray-600 group-hover:text-white/60 text-sm leading-relaxed transition-colors duration-300">
                            <?= renderRichtext($item['desc'] ?? '') ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
