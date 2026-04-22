<?php
/**
 * CTA Banner Section
 *
 * Kraftvoller dunkler CTA mit rotem Akzent — bricht den weissen Seitenfluss auf
 * und zieht die Aufmerksamkeit auf die naechste Aktion.
 */

$heading  = $content['heading'] ?? '';
$body     = $content['body'] ?? '';
$btnText  = $content['button_text'] ?? '';
$btnUrl   = $content['button_url'] ?? '';
$kicker   = $content['kicker'] ?? 'Nächster Schritt';
?>

<section class="cta-section relative overflow-hidden" style="background:#111827;">
    <!-- Roter Akzent-Balken links (volle Hoehe) -->
    <div style="position:absolute;top:0;bottom:0;left:0;width:6px;background:linear-gradient(to bottom,#C41018 0%,#9e0c12 100%);"></div>

    <!-- Subtiler roter Glow -->
    <div aria-hidden="true" style="position:absolute;inset:0;background:radial-gradient(ellipse 800px 400px at 15% 60%, rgba(196,16,24,0.15) 0%, transparent 60%);pointer-events:none;"></div>

    <!-- Ghost-Pfeil-Dekoration rechts -->
    <div aria-hidden="true" style="position:absolute;right:-40px;bottom:-60px;font-size:420px;line-height:1;color:rgba(255,255,255,0.02);font-weight:900;pointer-events:none;letter-spacing:-0.1em;user-select:none;">→</div>

    <div class="section-container relative" style="padding-top:80px;padding-bottom:80px;">
        <div class="cta-inner">
            <!-- Links: Text -->
            <div style="max-width:40rem;">
                <?php if ($kicker): ?>
                    <div style="display:inline-flex;align-items:center;gap:10px;margin-bottom:20px;">
                        <span style="width:32px;height:2px;background:#C41018;"></span>
                        <span style="color:#C41018;font-size:11px;font-weight:700;letter-spacing:0.28em;text-transform:uppercase;">
                            <?= e($kicker) ?>
                        </span>
                    </div>
                <?php endif; ?>

                <?php if ($heading): ?>
                    <h2 class="cta-heading" style="color:#fff;font-weight:800;text-transform:uppercase;letter-spacing:0.01em;line-height:1.1;margin-bottom:16px;">
                        <?= e($heading) ?>
                    </h2>
                <?php endif; ?>

                <?php if ($body): ?>
                    <p class="cta-body" style="color:rgba(255,255,255,0.65);line-height:1.7;margin:0;">
                        <?= renderRichtext($body) ?>
                    </p>
                <?php endif; ?>
            </div>

            <!-- Rechts: Button -->
            <?php if ($btnText && $btnUrl): ?>
                <a href="<?= e($btnUrl) ?>" class="cta-btn group"
                   style="display:inline-flex;align-items:center;gap:14px;background:#C41018;color:#fff;padding:18px 36px;border-radius:6px;font-size:14px;font-weight:700;letter-spacing:0.15em;text-transform:uppercase;text-decoration:none;transition:all 0.3s ease;box-shadow:0 10px 30px -10px rgba(196,16,24,0.5);white-space:nowrap;"
                   onmouseover="this.style.background='#9e0c12';this.style.transform='translateY(-2px)';this.style.boxShadow='0 15px 40px -10px rgba(196,16,24,0.7)';this.querySelector('.cta-arrow').style.transform='translateX(6px)';"
                   onmouseout="this.style.background='#C41018';this.style.transform='translateY(0)';this.style.boxShadow='0 10px 30px -10px rgba(196,16,24,0.5)';this.querySelector('.cta-arrow').style.transform='translateX(0)';">
                    <?= e($btnText) ?>
                    <svg class="cta-arrow" style="width:20px;height:20px;transition:transform 0.3s ease;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
            <?php endif; ?>
        </div>
    </div>
</section>

<style>
    .cta-section .cta-inner {
        display: flex; flex-direction: column; align-items: flex-start;
        gap: 32px;
    }
    .cta-section .cta-heading {
        font-size: calc(var(--fs-heading, 48px) * 0.65);
    }
    .cta-section .cta-body {
        font-size: calc(var(--fs-subtitle, 18px) * 0.95);
    }
    @media (min-width: 768px) {
        .cta-section .cta-inner {
            flex-direction: row; align-items: center; justify-content: space-between;
            gap: 48px;
        }
        .cta-section .cta-heading {
            font-size: calc(var(--fs-heading, 48px) * 0.8);
        }
        .cta-section .cta-body {
            font-size: var(--fs-subtitle, 18px);
        }
    }
    @media (min-width: 1024px) {
        .cta-section .cta-heading {
            font-size: calc(var(--fs-heading, 48px) * 0.95);
        }
    }
</style>
