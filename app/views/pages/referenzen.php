    <!-- Page Hero -->
    <section class="page-hero" aria-label="Referenzen">
        <div class="page-hero-bg"></div>
        <div class="container">
            <div class="page-hero-content" data-reveal>
                <span class="section-label">Referenzen</span>
                <h1 class="page-hero-title">Unsere Projekte</h1>
                <p class="page-hero-desc">Qualitätsarbeit, die überzeugt – eine Auswahl unserer erfolgreich realisierten Projekte.</p>
            </div>
        </div>
    </section>

    <!-- Filter -->
    <?php if (!empty($categories)): ?>
    <section class="section section-filter" aria-label="Projektfilter">
        <div class="container">
            <div class="filter-bar" data-reveal>
                <button class="filter-btn is-active" data-filter="all">Alle</button>
                <?php foreach ($categories as $cat): ?>
                <button class="filter-btn" data-filter="<?= e(slugify($cat)) ?>"><?= e($cat) ?></button>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Projects Grid -->
    <section class="section section-projects" aria-label="Projektliste">
        <div class="container">
            <?php if (empty($projects)): ?>
                <p class="no-results">Aktuell sind keine Referenzen verfügbar.</p>
            <?php else: ?>
            <div class="projects-grid">
                <?php foreach ($projects as $i => $ref): ?>
                <article class="project-card" data-category="<?= e(slugify($ref['category'] ?? '')) ?>" data-reveal data-delay="<?= $i % 3 ?>">
                    <div class="project-card-image">
                        <?php if (!empty($ref['image_path'])): ?>
                            <img src="<?= e($ref['image_path']) ?>" alt="<?= e($ref['title']) ?>" loading="lazy">
                        <?php else: ?>
                            <div class="project-card-placeholder">
                                <svg viewBox="0 0 120 80" fill="none" aria-hidden="true"><rect width="120" height="80" fill="currentColor" opacity="0.08"/><path d="M35 55l18-24 14 18 10-10 14 16H21z" fill="currentColor" opacity="0.15"/><circle cx="88" cy="24" r="8" fill="currentColor" opacity="0.12"/></svg>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="project-card-body">
                        <span class="project-card-category"><?= e($ref['category'] ?? '') ?></span>
                        <h2 class="project-card-title"><?= e($ref['title']) ?></h2>
                        <p class="project-card-desc"><?= e(mb_strimwidth($ref['description'] ?? '', 0, 150, '...')) ?></p>
                        <div class="project-card-meta">
                            <?php if (!empty($ref['client'])): ?>
                            <span class="project-meta-item">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="M2 14V4a1 1 0 011-1h4a1 1 0 011 1v10M8 14V7a1 1 0 011-1h4a1 1 0 011 1v7M1 14h14" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                <?= e($ref['client']) ?>
                            </span>
                            <?php endif; ?>
                            <?php if (!empty($ref['location'])): ?>
                            <span class="project-meta-item">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="M8 1C5.24 1 3 3.24 3 6c0 3.75 5 9 5 9s5-5.25 5-9c0-2.76-2.24-5-5-5z" stroke="currentColor" stroke-width="1.2"/><circle cx="8" cy="6" r="2" stroke="currentColor" stroke-width="1.2"/></svg>
                                <?= e($ref['location']) ?>
                            </span>
                            <?php endif; ?>
                            <?php if (!empty($ref['year'])): ?>
                            <span class="project-meta-item"><?= e($ref['year']) ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- CTA -->
    <section class="section section-cta" aria-label="Kontakt aufnehmen">
        <div class="cta-bg"></div>
        <div class="container">
            <div class="cta-content" data-reveal>
                <h2 class="cta-title">Werden Sie unsere nächste Referenz</h2>
                <p class="cta-text">Wir realisieren auch Ihr Projekt mit Präzision und Leidenschaft.</p>
                <div class="cta-actions">
                    <a href="<?= pageUrl('kontakt') ?>" class="btn btn-primary btn-lg">Projekt besprechen</a>
                </div>
            </div>
        </div>
    </section>
