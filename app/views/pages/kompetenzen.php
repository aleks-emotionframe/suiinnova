    <?php $hero = $blockMap['hero'] ?? null; ?>

    <!-- Page Hero -->
    <section class="page-hero" aria-label="Kompetenzen">
        <div class="page-hero-bg"></div>
        <div class="container">
            <div class="page-hero-content" data-reveal>
                <span class="section-label">Kompetenzen</span>
                <h1 class="page-hero-title"><?= e($hero['title'] ?? 'Unsere Kompetenzen') ?></h1>
                <p class="page-hero-desc"><?= e($hero['content'] ?? '') ?></p>
            </div>
        </div>
    </section>

    <!-- Vorfabrikation Section -->
    <section class="section section-kompetenz" id="vorfabrikation" aria-labelledby="vorfab-heading">
        <div class="container">
            <?php $vfIntro = $blockMap['vorfabrikation_intro'] ?? null; ?>
            <div class="kompetenz-header" data-reveal>
                <div class="kompetenz-number" aria-hidden="true">01</div>
                <div class="kompetenz-intro">
                    <span class="section-label"><?= e($vfIntro['subtitle'] ?? 'Präzision aus der Werkstatt') ?></span>
                    <h2 class="section-title" id="vorfab-heading"><?= e($vfIntro['title'] ?? 'Vorfabrikation') ?></h2>
                    <div class="kompetenz-text">
                        <?= nl2p($vfIntro['content'] ?? '') ?>
                    </div>
                </div>
            </div>

            <div class="kompetenz-cards">
                <?php
                $vorfabItems = [
                    ['key' => 'vorfab_gis', 'default' => 'GIS-Elemente'],
                    ['key' => 'vorfab_rohr', 'default' => 'Rohrleitungsbau'],
                    ['key' => 'vorfab_sto', 'default' => 'STOClick'],
                ];
                foreach ($vorfabItems as $i => $item):
                    $block = $blockMap[$item['key']] ?? null;
                ?>
                <article class="kompetenz-card" data-reveal data-delay="<?= $i ?>">
                    <div class="kompetenz-card-accent"></div>
                    <h3 class="kompetenz-card-title"><?= e($block['title'] ?? $item['default']) ?></h3>
                    <div class="kompetenz-card-content">
                        <?= nl2p($block['content'] ?? '') ?>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Divider -->
    <div class="section-divider" aria-hidden="true">
        <div class="container"><div class="divider-line"></div></div>
    </div>

    <!-- Montage Section -->
    <section class="section section-kompetenz" id="montage" aria-labelledby="montage-heading">
        <div class="container">
            <?php $mIntro = $blockMap['montage_intro'] ?? null; ?>
            <div class="kompetenz-header kompetenz-header-reverse" data-reveal>
                <div class="kompetenz-intro">
                    <span class="section-label"><?= e($mIntro['subtitle'] ?? 'Fachgerecht und termingerecht') ?></span>
                    <h2 class="section-title" id="montage-heading"><?= e($mIntro['title'] ?? 'Montage vor Ort') ?></h2>
                    <div class="kompetenz-text">
                        <?= nl2p($mIntro['content'] ?? '') ?>
                    </div>
                </div>
                <div class="kompetenz-number" aria-hidden="true">02</div>
            </div>

            <div class="kompetenz-cards kompetenz-cards-wide">
                <?php
                $montageItems = [
                    ['key' => 'montage_gis', 'default' => 'GIS-Elemente'],
                    ['key' => 'montage_duofix', 'default' => 'Duofix & Vorwandsysteme'],
                    ['key' => 'montage_beplan', 'default' => 'Beplankungen'],
                    ['key' => 'montage_aqua', 'default' => 'Geberit AquaPanel'],
                    ['key' => 'montage_spachtel', 'default' => 'Spachtelungen & Ausflockungen'],
                ];
                foreach ($montageItems as $i => $item):
                    $block = $blockMap[$item['key']] ?? null;
                ?>
                <article class="kompetenz-card" data-reveal data-delay="<?= $i ?>">
                    <div class="kompetenz-card-accent"></div>
                    <h3 class="kompetenz-card-title"><?= e($block['title'] ?? $item['default']) ?></h3>
                    <div class="kompetenz-card-content">
                        <?= nl2p($block['content'] ?? '') ?>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="section section-cta" aria-label="Kontakt aufnehmen">
        <div class="cta-bg"></div>
        <div class="container">
            <div class="cta-content" data-reveal>
                <h2 class="cta-title">Haben Sie ein Projekt?</h2>
                <p class="cta-text">Wir beraten Sie gerne zu den passenden Lösungen für Ihr Bauvorhaben.</p>
                <div class="cta-actions">
                    <a href="<?= pageUrl('kontakt') ?>" class="btn btn-primary btn-lg">Kontakt aufnehmen</a>
                </div>
            </div>
        </div>
    </section>
