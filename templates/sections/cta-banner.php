<?php
/**
 * CTA Banner Section
 *
 * Minimal und konsistent zum Rest der Site:
 * - dunkler Hintergrund (wie die Werte-Sektion)
 * - sauberes Swiss-Design
 * - roter 40px-Strich als einziger Akzent
 */

$heading  = $content['heading'] ?? '';
$body     = $content['body'] ?? '';
$btnText  = $content['button_text'] ?? '';
$btnUrl   = $content['button_url'] ?? '';
?>

<section class="section bg-gray-900">
    <div class="section-container">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-8 md:gap-10 items-start md:items-center">

            <!-- Text (links, 8 Spalten) -->
            <div class="md:col-span-8 fade-in">
                <!-- Roter Akzent-Strich (wie Werte-Sektion) -->
                <div style="width:40px;height:2px;background:#C41018;margin-bottom:20px;"></div>

                <?php if ($heading): ?>
                    <h2 class="section-heading" style="color:#fff;margin-bottom:12px;">
                        <?= e($heading) ?>
                    </h2>
                <?php endif; ?>

                <?php if ($body): ?>
                    <p style="color:rgba(255,255,255,0.55);line-height:1.7;margin:0;max-width:44rem;font-size:var(--fs-subtitle,18px);">
                        <?= renderRichtext($body) ?>
                    </p>
                <?php endif; ?>
            </div>

            <!-- Button (rechts, 4 Spalten) -->
            <?php if ($btnText && $btnUrl): ?>
                <div class="md:col-span-4 md:text-right fade-in">
                    <a href="<?= e($btnUrl) ?>"
                       class="inline-flex items-center gap-3 h-12 px-7 rounded-md text-white text-sm font-medium uppercase tracking-wider transition-all duration-200 hover:opacity-90"
                       style="background:#C41018;letter-spacing:0.1em;">
                        <?= e($btnText) ?>
                        <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                </div>
            <?php endif; ?>

        </div>
    </div>
</section>
