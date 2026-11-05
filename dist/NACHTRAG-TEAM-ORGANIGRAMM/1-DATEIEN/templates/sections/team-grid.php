<?php
/**
 * Team Grid Section
 *
 * Fotos im eigenen Seitenverhaeltnis: Vorher sass jedes Foto in einem
 * festen 3:4-Rahmen und wurde oben und unten beschnitten, sobald es ein
 * anderes Format hatte. Jetzt ist immer das ganze Bild zu sehen. Nur der
 * Platzhalter "Foto folgt" behaelt das 3:4-Format.
 *
 * Darunter optional ein Organigramm, als Bild oder als PDF aus der
 * Mediathek. Das Bild laeuft ueber die volle Breite und oeffnet sich per
 * Klick in Originalgroesse, damit auch kleine Schrift lesbar bleibt.
 *
 * Eigenes CSS statt Tailwind-Klassen: das Stylesheet ist ein fertig
 * gebautes Paket, neue Klassen wie h-auto stehen nicht darin.
 */
$heading = $content['heading'] ?? '';
$items   = $content['items'] ?? [];

$orgHeading = trim((string) ($content['org_heading'] ?? ''));
$orgId      = (int) ($content['org_image_id'] ?? 0);
$orgMedia   = $orgId ? getMedia($orgId) : null;
$orgIsPdf   = $orgMedia && ($orgMedia['mime_type'] ?? '') === 'application/pdf';
$orgUrl     = $orgMedia ? uploadUrl($orgMedia['path']) : '';
?>

<section class="section bg-white">
    <div class="section-container">
        <?php if ($heading): ?>
            <div class="mb-10 md:mb-14 fade-in">
                <<?= $hTag = headingTag() ?> class="section-heading"><?= e($heading) ?></<?= $hTag ?>>
            </div>
        <?php endif; ?>

        <?php if ($items): ?>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 md:gap-8 items-start">
                <?php foreach ($items as $member): ?>
                    <?php $memberImgId = (int) ($member['image_id'] ?? 0); ?>
                    <div class="group fade-in">
                        <?php if ($memberImgId): ?>
                            <div class="team-photo bg-gray-100 rounded-lg overflow-hidden mb-4">
                                <?= responsiveImg($memberImgId, [
                                    'alt'   => $member['name'] ?? '',
                                    'sizes' => '(min-width: 1024px) 25vw, (min-width: 768px) 33vw, 50vw',
                                    'class' => 'team-photo-img transition-transform duration-500 group-hover:scale-105',
                                ]) ?>
                            </div>
                        <?php else: ?>
                            <div class="aspect-[3/4] bg-gray-100 rounded-lg overflow-hidden mb-4">
                                <!-- Platzhalter -->
                                <div class="w-full h-full flex flex-col items-center justify-center text-gray-300">
                                    <svg class="w-16 h-16 mb-3 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="0.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                                    </svg>
                                    <span class="text-[12px] text-gray-300 uppercase tracking-wider">Foto folgt</span>
                                </div>
                            </div>
                        <?php endif; ?>
                        <h3 class="text-sm font-bold text-gray-900"><?= e($member['name'] ?? '') ?></h3>
                        <p class="text-xs text-gray-500 mt-0.5"><?= e($member['role'] ?? '') ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ($orgMedia): ?>
            <div class="team-org fade-in">
                <?php if ($orgHeading): ?>
                    <div class="mb-10 md:mb-14">
                        <<?= $hTag = headingTag() ?> class="section-heading"><?= e($orgHeading) ?></<?= $hTag ?>>
                    </div>
                <?php endif; ?>

                <?php if ($orgIsPdf): ?>
                    <a href="<?= e($orgUrl) ?>" target="_blank" rel="noopener"
                       class="inline-flex items-center gap-3 h-12 px-7 rounded-md text-white text-sm font-medium uppercase tracking-wider transition-all duration-200 hover:opacity-90"
                       style="background:#C41018;letter-spacing:0.1em;">
                        Organigramm öffnen (PDF)
                    </a>
                <?php else: ?>
                    <a href="<?= e($orgUrl) ?>" target="_blank" rel="noopener" class="team-org-link"
                       title="Organigramm in Originalgrösse öffnen">
                        <?= responsiveImg($orgId, [
                            'alt'   => $orgHeading !== '' ? $orgHeading . ' der SUI Innova GmbH' : 'Organigramm der SUI Innova GmbH',
                            'sizes' => '(min-width: 1792px) 1700px, 100vw',
                            'class' => 'team-org-img',
                        ]) ?>
                    </a>
                    <p class="text-xs text-gray-500 team-org-hint">Zum Vergrössern auf das Organigramm klicken.</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<style>
    /* Ganzes Foto, keine feste Hoehe. width/height am <img> halten den
       Platz frei, bis das Bild geladen ist. */
    .team-photo-img {
        display: block;
        width: 100%;
        height: auto;
    }

    .team-org { margin-top: 64px; }
    @media (min-width: 768px) { .team-org { margin-top: 96px; } }

    .team-org-link {
        display: block;
        border: 1px solid #E5E7EB;
        border-radius: 8px;
        overflow: hidden;
        background: #fff;
    }
    .team-org-img {
        display: block;
        width: 100%;
        height: auto;
    }
    .team-org-hint { margin-top: 10px; }
</style>
