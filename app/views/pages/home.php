    <?php
    $hero = $blockMap['hero'] ?? null;
    $intro = $blockMap['intro'] ?? null;
    ?>

    <!-- Hero -->
    <section class="hero" aria-label="Willkommen">
        <div class="hero-bg">
            <div class="hero-overlay"></div>
            <div class="hero-pattern"></div>
        </div>
        <div class="hero-content">
            <div class="container">
                <div class="hero-text">
                    <p class="hero-label" data-reveal>SUI Innova GmbH</p>
                    <h1 class="hero-title" data-reveal data-delay="1">
                        <?= e($hero['title'] ?? 'Präzision in jeder Verbindung') ?>
                    </h1>
                    <p class="hero-subtitle" data-reveal data-delay="2">
                        <?= e($hero['subtitle'] ?? 'Vorfabrikation & Montage für die Gebäudetechnik') ?>
                    </p>
                    <p class="hero-desc" data-reveal data-delay="3">
                        <?= e($hero['content'] ?? '') ?>
                    </p>
                    <div class="hero-actions" data-reveal data-delay="4">
                        <a href="<?= pageUrl('kompetenzen') ?>" class="btn btn-primary">Unsere Kompetenzen</a>
                        <a href="<?= pageUrl('kontakt') ?>" class="btn btn-outline">Kontakt aufnehmen</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="hero-scroll" aria-hidden="true">
            <span class="hero-scroll-line"></span>
        </div>
    </section>

    <!-- Intro Section -->
    <section class="section section-intro" aria-labelledby="intro-heading">
        <div class="container">
            <div class="intro-grid">
                <div class="intro-label" data-reveal>
                    <span class="section-label"><?= e($intro['subtitle'] ?? 'Ihr Spezialist für Sanitär-Vorfabrikation') ?></span>
                </div>
                <div class="intro-content" data-reveal data-delay="1">
                    <h2 class="section-title" id="intro-heading"><?= e($intro['title'] ?? 'SUI Innova GmbH') ?></h2>
                    <div class="intro-text">
                        <?= nl2p($intro['content'] ?? '') ?>
                    </div>
                    <a href="<?= pageUrl('unternehmen') ?>" class="link-arrow">
                        Mehr über uns
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M4 10h12m0 0l-4-4m4 4l-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Overview -->
    <section class="section section-services" aria-labelledby="services-heading">
        <div class="services-bg"></div>
        <div class="container">
            <div class="section-header" data-reveal>
                <span class="section-label">Leistungen</span>
                <h2 class="section-title" id="services-heading">Was wir für Sie tun</h2>
            </div>
            <div class="services-grid">
                <?php
                $services = [
                    ['key' => 'service_1', 'icon' => 'fabrication', 'default_title' => 'Vorfabrikation'],
                    ['key' => 'service_2', 'icon' => 'installation', 'default_title' => 'Montage vor Ort'],
                    ['key' => 'service_3', 'icon' => 'quality', 'default_title' => 'Qualität & Termintreue'],
                ];
                foreach ($services as $i => $svc):
                    $block = $blockMap[$svc['key']] ?? null;
                ?>
                <article class="service-card" data-reveal data-delay="<?= $i ?>">
                    <div class="service-card-inner">
                        <div class="service-icon" aria-hidden="true">
                            <?php if ($svc['icon'] === 'fabrication'): ?>
                            <svg viewBox="0 0 48 48" fill="none"><rect x="6" y="20" width="36" height="22" rx="2" stroke="currentColor" stroke-width="2"/><path d="M14 20V12a10 10 0 0120 0v8" stroke="currentColor" stroke-width="2"/><circle cx="24" cy="31" r="4" stroke="currentColor" stroke-width="2"/><path d="M24 35v3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                            <?php elseif ($svc['icon'] === 'installation'): ?>
                            <svg viewBox="0 0 48 48" fill="none"><path d="M20 8l-4 12h16L28 8" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/><path d="M16 20v20h16V20" stroke="currentColor" stroke-width="2"/><path d="M8 40h32" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M24 28v8M20 32h8" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                            <?php else: ?>
                            <svg viewBox="0 0 48 48" fill="none"><path d="M24 4l18 10v20L24 44 6 34V14L24 4z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/><path d="M24 4v40M6 14l18 10 18-10" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg>
                            <?php endif; ?>
                        </div>
                        <h3 class="service-title"><?= e($block['title'] ?? $svc['default_title']) ?></h3>
                        <p class="service-desc"><?= e($block['content'] ?? '') ?></p>
                        <a href="<?= pageUrl('kompetenzen') ?>" class="service-link" aria-label="Mehr zu <?= e($block['title'] ?? $svc['default_title']) ?>">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M5 12h14m0 0l-5-5m5 5l-5 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </a>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Key Figures -->
    <section class="section section-figures" aria-label="Kennzahlen">
        <div class="container">
            <div class="figures-grid">
                <?php
                $figures = [
                    ['key' => 'figures_employees', 'def_num' => '85+', 'def_label' => 'Fachkräfte'],
                    ['key' => 'figures_projects', 'def_num' => '500+', 'def_label' => 'Projekte'],
                    ['key' => 'figures_years', 'def_num' => '15+', 'def_label' => 'Jahre Erfahrung'],
                ];
                foreach ($figures as $i => $fig):
                    $block = $blockMap[$fig['key']] ?? null;
                ?>
                <div class="figure-item" data-reveal data-delay="<?= $i ?>">
                    <span class="figure-number"><?= e($block['title'] ?? $fig['def_num']) ?></span>
                    <span class="figure-label"><?= e($block['subtitle'] ?? $fig['def_label']) ?></span>
                    <span class="figure-desc"><?= e($block['content'] ?? '') ?></span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Featured References Teaser -->
    <section class="section section-refs-teaser" aria-labelledby="refs-heading">
        <div class="container">
            <div class="section-header section-header-split" data-reveal>
                <div>
                    <span class="section-label">Referenzen</span>
                    <h2 class="section-title" id="refs-heading">Ausgewählte Projekte</h2>
                </div>
                <a href="<?= pageUrl('referenzen') ?>" class="link-arrow">
                    Alle Referenzen
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M4 10h12m0 0l-4-4m4 4l-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </a>
            </div>
            <div class="refs-teaser-grid">
                <?php
                try {
                    $db = Database::getInstance();
                    $stmt = $db->query('SELECT * FROM references_projects WHERE is_featured = 1 AND is_active = 1 ORDER BY sort_order LIMIT 3');
                    $featured = $stmt->fetchAll();
                } catch (Exception $e) {
                    $featured = [];
                }
                foreach ($featured as $i => $ref):
                ?>
                <article class="ref-card" data-reveal data-delay="<?= $i ?>">
                    <div class="ref-card-image">
                        <?php if (!empty($ref['image_path'])): ?>
                            <img src="<?= e($ref['image_path']) ?>" alt="<?= e($ref['title']) ?>" loading="lazy">
                        <?php else: ?>
                            <div class="ref-card-placeholder">
                                <svg viewBox="0 0 80 60" fill="none" aria-hidden="true"><rect width="80" height="60" rx="4" fill="currentColor" opacity="0.1"/><path d="M30 40l10-14 8 10 6-6 8 10H18l12-16z" fill="currentColor" opacity="0.2"/><circle cx="58" cy="18" r="6" fill="currentColor" opacity="0.15"/></svg>
                            </div>
                        <?php endif; ?>
                        <div class="ref-card-overlay">
                            <span class="ref-card-category"><?= e($ref['category'] ?? '') ?></span>
                        </div>
                    </div>
                    <div class="ref-card-body">
                        <h3 class="ref-card-title"><?= e($ref['title']) ?></h3>
                        <p class="ref-card-meta">
                            <?= e($ref['location'] ?? '') ?>
                            <?php if (!empty($ref['year'])): ?> · <?= e($ref['year']) ?><?php endif; ?>
                        </p>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <?php $cta = $blockMap['cta'] ?? null; ?>
    <section class="section section-cta" aria-label="Kontakt aufnehmen">
        <div class="cta-bg"></div>
        <div class="container">
            <div class="cta-content" data-reveal>
                <h2 class="cta-title"><?= e($cta['title'] ?? 'Ihr nächstes Projekt?') ?></h2>
                <p class="cta-text"><?= e($cta['content'] ?? 'Kontaktieren Sie uns für eine unverbindliche Beratung.') ?></p>
                <div class="cta-actions">
                    <a href="<?= pageUrl('kontakt') ?>" class="btn btn-primary btn-lg">Jetzt anfragen</a>
                    <a href="tel:<?= e(str_replace(' ', '', setting('site_phone', '+41 44 000 00 00'))) ?>" class="btn btn-ghost btn-lg">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M3 5a2 2 0 012-2h2.28a1 1 0 01.95.68l1.05 3.16a1 1 0 01-.24 1.02l-1.3 1.3a10.06 10.06 0 004.1 4.1l1.3-1.3a1 1 0 011.02-.24l3.16 1.05a1 1 0 01.68.95V17a2 2 0 01-2 2A15 15 0 013 5z" stroke="currentColor" stroke-width="1.5"/></svg>
                        <?= e(setting('site_phone', '+41 44 000 00 00')) ?>
                    </a>
                </div>
            </div>
        </div>
    </section>
