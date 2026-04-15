
    <section class="section page-title-section" aria-label="Unternehmen">
        <div class="container">
            <div class="page-title-content" data-reveal>
                <span class="section-label">Unternehmen</span>
                <h1 class="page-title"<?= cmsAttr($blockMap, 'page_title', 'title') ?>><?= e(cms($blockMap, 'page_title', 'title', 'Über die SUI Innova GmbH')) ?></h1>
                <p class="page-title-desc"<?= cmsAttr($blockMap, 'page_title', 'content') ?>><?= e(cms($blockMap, 'page_title', 'content', 'Qualität, Zuverlässigkeit und Leidenschaft für die Gebäudetechnik – das ist SUI Innova.')) ?></p>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="section section-about" aria-labelledby="about-heading">
        <div class="container">
            <div class="about-grid" data-reveal>
                <div class="about-image-col">
                    <div class="about-image-wrapper">
                        <div class="about-image-placeholder">
                            <svg viewBox="0 0 400 500" fill="none" aria-hidden="true">
                                <rect width="400" height="500" rx="8" fill="#1a2d42" opacity="0.06"/>
                                <rect x="40" y="300" width="320" height="160" rx="4" fill="#1a2d42" opacity="0.04"/>
                                <rect x="60" y="60" width="120" height="180" rx="4" fill="#c49a3c" opacity="0.08"/>
                                <rect x="200" y="100" width="140" height="140" rx="4" fill="#1a2d42" opacity="0.06"/>
                                <circle cx="120" cy="430" r="30" fill="#c49a3c" opacity="0.06"/>
                            </svg>
                        </div>
                        <div class="about-image-accent" aria-hidden="true"></div>
                    </div>
                </div>
                <div class="about-content-col">
                    <span class="section-label"<?= cmsAttr($blockMap, 'about', 'subtitle') ?>><?= e(cms($blockMap, 'about', 'subtitle', 'SUI Innova GmbH')) ?></span>
                    <h2 class="section-title" id="about-heading"<?= cmsAttr($blockMap, 'about', 'title') ?>><?= e(cms($blockMap, 'about', 'title', 'Über uns')) ?></h2>
                    <div class="about-text"<?= cmsAttr($blockMap, 'about', 'content') ?>>
                        <?= nl2p(cms($blockMap, 'about', 'content', "Die SUI Innova GmbH ist ein führendes Unternehmen im Bereich der Vorfabrikation und Montage von Sanitärinstallationen. Mit über 85 Fachkräften und langjähriger Erfahrung realisieren wir anspruchsvolle Projekte in der ganzen Schweiz.\n\nVon der Planung über die Vorfabrikation in unserer modernen Werkstatt bis zur fachgerechten Montage auf der Baustelle bieten wir alles aus einer Hand. Dabei setzen wir auf höchste Qualitätsstandards, termingerechte Ausführung und eine partnerschaftliche Zusammenarbeit mit unseren Kunden.")) ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Values -->
    <section class="section section-values" aria-labelledby="values-heading">
        <div class="values-bg"></div>
        <div class="container">
            <div class="section-header" data-reveal>
                <span class="section-label">Was uns antreibt</span>
                <h2 class="section-title" id="values-heading"<?= cmsAttr($blockMap, 'values', 'title') ?>><?= e(cms($blockMap, 'values', 'title', 'Unsere Werte')) ?></h2>
                <div class="section-desc">
                    <p<?= cmsAttr($blockMap, 'values', 'content') ?>><?= e(cms($blockMap, 'values', 'content', 'Diese Grundsätze leiten unser tägliches Handeln und bilden das Fundament unserer Arbeit.')) ?></p>
                </div>
            </div>
            <div class="values-grid">
                <div class="value-card" data-reveal data-delay="0">
                    <div class="value-icon" aria-hidden="true">
                        <svg viewBox="0 0 40 40" fill="none"><circle cx="20" cy="20" r="16" stroke="currentColor" stroke-width="1.5"/><circle cx="20" cy="20" r="8" stroke="currentColor" stroke-width="1.5"/><circle cx="20" cy="20" r="2" fill="currentColor"/><path d="M20 4v4M20 32v4M4 20h4M32 20h4" stroke="currentColor" stroke-width="1.5"/></svg>
                    </div>
                    <h3 class="value-title"<?= cmsAttr($blockMap, 'value_1', 'title') ?>><?= e(cms($blockMap, 'value_1', 'title', 'Präzision')) ?></h3>
                    <p class="value-desc"<?= cmsAttr($blockMap, 'value_1', 'content') ?>><?= e(cms($blockMap, 'value_1', 'content', 'Höchste Genauigkeit in jeder Vorfabrikation und Montage – für dauerhaft zuverlässige Installationen.')) ?></p>
                </div>
                <div class="value-card" data-reveal data-delay="1">
                    <div class="value-icon" aria-hidden="true">
                        <svg viewBox="0 0 40 40" fill="none"><path d="M20 4l14 6v10c0 8-6 14-14 18C12 34 6 28 6 20V10l14-6z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/><path d="M14 20l4 4 8-8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <h3 class="value-title"<?= cmsAttr($blockMap, 'value_2', 'title') ?>><?= e(cms($blockMap, 'value_2', 'title', 'Zuverlässigkeit')) ?></h3>
                    <p class="value-desc"<?= cmsAttr($blockMap, 'value_2', 'content') ?>><?= e(cms($blockMap, 'value_2', 'content', 'Termingerecht und verantwortungsbewusst. Unsere Kunden können sich auf uns verlassen.')) ?></p>
                </div>
                <div class="value-card" data-reveal data-delay="2">
                    <div class="value-icon" aria-hidden="true">
                        <svg viewBox="0 0 40 40" fill="none"><path d="M20 6a10 10 0 00-4 19.17V28a2 2 0 002 2h4a2 2 0 002-2v-2.83A10 10 0 0020 6z" stroke="currentColor" stroke-width="1.5"/><path d="M16 34h8M18 30v4M22 30v4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                    </div>
                    <h3 class="value-title"<?= cmsAttr($blockMap, 'value_3', 'title') ?>><?= e(cms($blockMap, 'value_3', 'title', 'Innovation')) ?></h3>
                    <p class="value-desc"<?= cmsAttr($blockMap, 'value_3', 'content') ?>><?= e(cms($blockMap, 'value_3', 'content', 'Moderne Fertigungstechnologien und effiziente Arbeitsabläufe für bessere Ergebnisse.')) ?></p>
                </div>
                <div class="value-card" data-reveal data-delay="3">
                    <div class="value-icon" aria-hidden="true">
                        <svg viewBox="0 0 40 40" fill="none"><circle cx="14" cy="14" r="6" stroke="currentColor" stroke-width="1.5"/><circle cx="26" cy="14" r="6" stroke="currentColor" stroke-width="1.5"/><path d="M6 32c0-4.42 3.58-8 8-8h2M24 24h2c4.42 0 8 3.58 8 8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/><circle cx="20" cy="26" r="6" stroke="currentColor" stroke-width="1.5"/></svg>
                    </div>
                    <h3 class="value-title"<?= cmsAttr($blockMap, 'value_4', 'title') ?>><?= e(cms($blockMap, 'value_4', 'title', 'Teamarbeit')) ?></h3>
                    <p class="value-desc"<?= cmsAttr($blockMap, 'value_4', 'content') ?>><?= e(cms($blockMap, 'value_4', 'content', 'Gemeinsam stark – unsere Teams arbeiten Hand in Hand für den Projekterfolg.')) ?></p>
                </div>
            </div>
        </div>
    </section>

    <!-- Quality -->
    <section class="section section-quality" aria-labelledby="quality-heading">
        <div class="container">
            <div class="quality-grid" data-reveal>
                <div class="quality-content">
                    <span class="section-label">Standards</span>
                    <h2 class="section-title" id="quality-heading"<?= cmsAttr($blockMap, 'quality', 'title') ?>><?= e(cms($blockMap, 'quality', 'title', 'Qualitätsmanagement')) ?></h2>
                    <div class="quality-text"<?= cmsAttr($blockMap, 'quality', 'content') ?>>
                        <?= nl2p(cms($blockMap, 'quality', 'content', 'Qualität ist kein Zufall, sondern das Ergebnis konsequenter Prozesse und hoher Ansprüche. Unser Qualitätsmanagement stellt sicher, dass jedes Projekt unseren Standards entspricht.')) ?>
                    </div>
                    <ul class="quality-list">
                        <li>Qualitätskontrolle in jeder Projektphase</li>
                        <li>Einhaltung aller relevanten SIA-Normen</li>
                        <li>Dokumentierte Prozesse und Abnahmen</li>
                        <li>Kontinuierliche Weiterbildung des Teams</li>
                    </ul>
                </div>
                <div class="quality-visual" aria-hidden="true">
                    <div class="quality-badge">
                        <svg viewBox="0 0 120 120" fill="none">
                            <circle cx="60" cy="60" r="56" stroke="currentColor" stroke-width="1" opacity="0.3"/>
                            <circle cx="60" cy="60" r="44" stroke="currentColor" stroke-width="1" opacity="0.2"/>
                            <circle cx="60" cy="60" r="32" stroke="currentColor" stroke-width="1.5"/>
                            <path d="M48 60l8 8 16-16" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span class="quality-badge-text">Geprüfte<br>Qualität</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Teaser -->
    <section class="section section-team" aria-labelledby="team-heading">
        <div class="container">
            <div class="section-header" data-reveal>
                <span class="section-label">Menschen</span>
                <h2 class="section-title" id="team-heading"<?= cmsAttr($blockMap, 'team', 'title') ?>><?= e(cms($blockMap, 'team', 'title', 'Unser Team')) ?></h2>
                <div class="section-desc">
                    <p<?= cmsAttr($blockMap, 'team', 'content') ?>><?= e(cms($blockMap, 'team', 'content', 'Über 85 engagierte Fachkräfte bilden das Rückgrat unseres Unternehmens. Mit Erfahrung, Fachwissen und Teamgeist meistern wir jede Herausforderung.')) ?></p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="section section-cta" aria-label="Kontakt aufnehmen">
        <div class="cta-bg"></div>
        <div class="container">
            <div class="cta-content" data-reveal>
                <h2 class="cta-title"<?= cmsAttr($blockMap, 'cta', 'title') ?>><?= e(cms($blockMap, 'cta', 'title', 'Teil unseres Teams werden?')) ?></h2>
                <p class="cta-text"<?= cmsAttr($blockMap, 'cta', 'content') ?>><?= e(cms($blockMap, 'cta', 'content', 'Wir suchen engagierte Fachkräfte. Kontaktieren Sie uns für offene Stellen.')) ?></p>
                <div class="cta-actions">
                    <a href="<?= pageUrl('kontakt') ?>" class="btn btn-primary btn-lg">Jetzt bewerben</a>
                </div>
            </div>
        </div>
    </section>

