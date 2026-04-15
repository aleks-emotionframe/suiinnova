
    <!-- Page Title -->
    <section class="section page-title-section" aria-label="Kompetenzen">
        <div class="container">
            <div class="page-title-content" data-reveal>
                <span class="section-label">Kompetenzen</span>
                <h1 class="page-title"<?= cmsAttr($blockMap, 'page_title', 'title') ?>><?= e(cms($blockMap, 'page_title', 'title', 'Vorfabrikation & Montage')) ?></h1>
                <p class="page-title-desc"<?= cmsAttr($blockMap, 'page_title', 'content') ?>><?= e(cms($blockMap, 'page_title', 'content', 'Ein Ansprechpartner, durchgängige Qualität, optimierte Abläufe – von der Werkstatt bis zur fertigen Oberfläche.')) ?></p>
            </div>
        </div>
    </section>

    <!-- Vorfabrikation: Bild links, Text rechts -->
    <section class="section" id="vorfabrikation" aria-labelledby="vorfab-heading">
        <div class="container">
            <div class="komp-split" data-reveal>
                <div class="komp-split-img">
                    <img src="<?= e(cms($blockMap, 'vorfab_header', 'image_path', 'https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=800&q=80')) ?>" alt="Vorfabrikation" loading="lazy"<?= cmsAttr($blockMap, 'vorfab_header', 'image_path') ?>>
                </div>
                <div class="komp-split-body">
                    <span class="section-label">01 — Vorfabrikation</span>
                    <h2 class="section-title" id="vorfab-heading"<?= cmsAttr($blockMap, 'vorfab_header', 'title') ?>><?= e(cms($blockMap, 'vorfab_header', 'title', 'Präzision aus der Werkstatt')) ?></h2>
                    <p<?= cmsAttr($blockMap, 'vorfab_header', 'content') ?>><?= e(cms($blockMap, 'vorfab_header', 'content', 'In unserer Werkstatt fertigen wir massgeschneiderte Komponenten, die auf der Baustelle effizient installiert werden. Das spart Zeit, senkt Kosten und garantiert gleichbleibende Qualität.')) ?></p>
                    <div class="komp-services">
                        <div class="komp-service">
                            <h3<?= cmsAttr($blockMap, 'vorfab_gis', 'title') ?>><?= e(cms($blockMap, 'vorfab_gis', 'title', 'GIS-Elemente')) ?></h3>
                            <p<?= cmsAttr($blockMap, 'vorfab_gis', 'content') ?>><?= e(cms($blockMap, 'vorfab_gis', 'content', 'Geberit Installationssysteme massgenau vorfabriziert – bereit für die schnelle Montage.')) ?></p>
                        </div>
                        <div class="komp-service">
                            <h3<?= cmsAttr($blockMap, 'vorfab_rohr', 'title') ?>><?= e(cms($blockMap, 'vorfab_rohr', 'title', 'Rohrleitungsbau')) ?></h3>
                            <p<?= cmsAttr($blockMap, 'vorfab_rohr', 'content') ?>><?= e(cms($blockMap, 'vorfab_rohr', 'content', 'Trinkwasser, Heizung, Abwasser – alle Materialien und Verbindungstechniken nach SIA-Normen.')) ?></p>
                        </div>
                        <div class="komp-service">
                            <h3<?= cmsAttr($blockMap, 'vorfab_sto', 'title') ?>><?= e(cms($blockMap, 'vorfab_sto', 'title', 'STOClick')) ?></h3>
                            <p<?= cmsAttr($blockMap, 'vorfab_sto', 'content') ?>><?= e(cms($blockMap, 'vorfab_sto', 'content', 'Schnellmontage-System für sichere Befestigung und optimierte Baustellenabläufe.')) ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Montage: Text links, Bild rechts -->
    <section class="section" id="montage" aria-labelledby="montage-heading">
        <div class="container">
            <div class="komp-split komp-split-reverse" data-reveal>
                <div class="komp-split-img">
                    <img src="<?= e(cms($blockMap, 'montage_header', 'image_path', 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?w=800&q=80')) ?>" alt="Montage" loading="lazy"<?= cmsAttr($blockMap, 'montage_header', 'image_path') ?>>
                </div>
                <div class="komp-split-body">
                    <span class="section-label">02 — Montage vor Ort</span>
                    <h2 class="section-title" id="montage-heading"<?= cmsAttr($blockMap, 'montage_header', 'title') ?>><?= e(cms($blockMap, 'montage_header', 'title', 'Fachgerecht auf der Baustelle')) ?></h2>
                    <p<?= cmsAttr($blockMap, 'montage_header', 'content') ?>><?= e(cms($blockMap, 'montage_header', 'content', 'Unser erfahrenes Team montiert direkt vor Ort – von der Vorwandinstallation bis zur fertigen Oberfläche, koordiniert mit allen Gewerken.')) ?></p>
                    <div class="komp-services">
                        <div class="komp-service">
                            <h3<?= cmsAttr($blockMap, 'montage_duofix', 'title') ?>><?= e(cms($blockMap, 'montage_duofix', 'title', 'Duofix & Vorwände')) ?></h3>
                            <p<?= cmsAttr($blockMap, 'montage_duofix', 'content') ?>><?= e(cms($blockMap, 'montage_duofix', 'content', 'Geberit Duofix, geschweisste Vorwände und alle gängigen Sanitärvorwandsysteme.')) ?></p>
                        </div>
                        <div class="komp-service">
                            <h3<?= cmsAttr($blockMap, 'montage_beplan', 'title') ?>><?= e(cms($blockMap, 'montage_beplan', 'title', 'Beplankungen & AquaPanel')) ?></h3>
                            <p<?= cmsAttr($blockMap, 'montage_beplan', 'content') ?>><?= e(cms($blockMap, 'montage_beplan', 'content', '1x 18mm oder 2x 12.5mm Platten. AquaPanel 2x 12mm für Feuchträume.')) ?></p>
                        </div>
                        <div class="komp-service">
                            <h3<?= cmsAttr($blockMap, 'montage_spachtel', 'title') ?>><?= e(cms($blockMap, 'montage_spachtel', 'title', 'Spachtelungen')) ?></h3>
                            <p<?= cmsAttr($blockMap, 'montage_spachtel', 'content') ?>><?= e(cms($blockMap, 'montage_spachtel', 'content', 'Fachgerechte Spachtelungen und Ausflockungen – bereit für Fliesen oder Anstrich.')) ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Alle Leistungen im Detail -->
    <section class="section" aria-labelledby="detail-heading">
        <div class="container">
            <div class="section-header section-header-center" data-reveal>
                <span class="section-label">Im Detail</span>
                <h2 class="section-title" id="detail-heading"<?= cmsAttr($blockMap, 'details_header', 'title') ?>><?= e(cms($blockMap, 'details_header', 'title', 'Alle Leistungen auf einen Blick')) ?></h2>
            </div>
            <div class="details-grid" data-reveal>
                <div class="detail-card">
                    <div class="detail-card-icon">
                        <!-- GIS vorfabrizieren: Rahmen/Modul in Werkstatt -->
                        <svg viewBox="0 0 48 48" fill="none"><rect x="6" y="10" width="36" height="28" rx="2" stroke="currentColor" stroke-width="2"/><path d="M6 20h36M20 10v28M34 10v28" stroke="currentColor" stroke-width="2"/><circle cx="13" cy="15" r="2" fill="currentColor"/><circle cx="27" cy="15" r="2" fill="currentColor"/></svg>
                    </div>
                    <h3 class="detail-card-title"<?= cmsAttr($blockMap, 'detail_gis', 'title') ?>><?= e(cms($blockMap, 'detail_gis', 'title', 'GIS-Elemente vorfabrizieren')) ?></h3>
                    <p class="detail-card-desc"<?= cmsAttr($blockMap, 'detail_gis', 'content') ?>><?= e(cms($blockMap, 'detail_gis', 'content', 'Geberit Installationssysteme massgenau in der Werkstatt vorbereiten. Qualitätskontrolle vor Auslieferung, termingerechte Lieferung.')) ?></p>
                </div>
                <div class="detail-card">
                    <div class="detail-card-icon">
                        <!-- GIS montieren: Schraubenschlüssel -->
                        <svg viewBox="0 0 48 48" fill="none"><path d="M30 6a12 12 0 00-11.3 16.1L6 34.8 13.2 42l12.7-12.7A12 12 0 1030 6z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/><circle cx="30" cy="18" r="4" stroke="currentColor" stroke-width="2"/></svg>
                    </div>
                    <h3 class="detail-card-title"<?= cmsAttr($blockMap, 'detail_gis_montage', 'title') ?>><?= e(cms($blockMap, 'detail_gis_montage', 'title', 'GIS-Elemente montieren')) ?></h3>
                    <p class="detail-card-desc"<?= cmsAttr($blockMap, 'detail_gis_montage', 'content') ?>><?= e(cms($blockMap, 'detail_gis_montage', 'content', 'Fachgerechte Montage nach Herstellervorgaben direkt auf der Baustelle. Koordiniert mit allen beteiligten Gewerken.')) ?></p>
                </div>
                <div class="detail-card">
                    <div class="detail-card-icon">
                        <!-- Rohrleitungsbau: Rohr mit Verbindung -->
                        <svg viewBox="0 0 48 48" fill="none"><path d="M4 20h12v8H4zM32 20h12v8H32z" stroke="currentColor" stroke-width="2"/><path d="M16 16h16v16H16z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/><path d="M16 24h-4M36 24h-4" stroke="currentColor" stroke-width="2"/><circle cx="24" cy="24" r="3" stroke="currentColor" stroke-width="2"/></svg>
                    </div>
                    <h3 class="detail-card-title"<?= cmsAttr($blockMap, 'detail_rohr', 'title') ?>><?= e(cms($blockMap, 'detail_rohr', 'title', 'Rohrleitungsbau')) ?></h3>
                    <p class="detail-card-desc"<?= cmsAttr($blockMap, 'detail_rohr', 'content') ?>><?= e(cms($blockMap, 'detail_rohr', 'content', 'Trinkwasser-, Heizungs- und Abwasserleitungen. Edelstahl, Kupfer, Kunststoff – alle Verbindungstechniken nach SIA-Normen.')) ?></p>
                </div>
                <div class="detail-card">
                    <div class="detail-card-icon">
                        <!-- STOClick: Klick-Befestigung -->
                        <svg viewBox="0 0 48 48" fill="none"><path d="M24 4v16M16 12l8 8 8-8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><rect x="8" y="24" width="32" height="20" rx="2" stroke="currentColor" stroke-width="2"/><path d="M18 32h12M18 38h8" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    </div>
                    <h3 class="detail-card-title"<?= cmsAttr($blockMap, 'detail_sto', 'title') ?>><?= e(cms($blockMap, 'detail_sto', 'title', 'STOClick')) ?></h3>
                    <p class="detail-card-desc"<?= cmsAttr($blockMap, 'detail_sto', 'content') ?>><?= e(cms($blockMap, 'detail_sto', 'content', 'Schnellmontage-System für sichere Befestigung. Effiziente Vorfabrikation verkürzt Montagezeiten auf der Baustelle.')) ?></p>
                </div>
                <div class="detail-card">
                    <div class="detail-card-icon">
                        <!-- Duofix/Vorwände: Wandinstallation mit WC -->
                        <svg viewBox="0 0 48 48" fill="none"><rect x="8" y="4" width="32" height="40" rx="2" stroke="currentColor" stroke-width="2"/><path d="M8 4h32v12H8z" stroke="currentColor" stroke-width="2"/><circle cx="24" cy="28" r="6" stroke="currentColor" stroke-width="2"/><path d="M24 34v6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    </div>
                    <h3 class="detail-card-title"<?= cmsAttr($blockMap, 'detail_duofix', 'title') ?>><?= e(cms($blockMap, 'detail_duofix', 'title', 'Duofix & Vorwände')) ?></h3>
                    <p class="detail-card-desc"<?= cmsAttr($blockMap, 'detail_duofix', 'content') ?>><?= e(cms($blockMap, 'detail_duofix', 'content', 'Geberit Duofix und alle gängigen Sanitärvorwandsysteme – auch geschweisst. Für Wohnbau, Gewerbe und Spitäler.')) ?></p>
                </div>
                <div class="detail-card">
                    <div class="detail-card-icon">
                        <!-- Beplankungen: Platten übereinander -->
                        <svg viewBox="0 0 48 48" fill="none"><rect x="4" y="6" width="40" height="12" rx="2" stroke="currentColor" stroke-width="2"/><rect x="4" y="22" width="40" height="12" rx="2" stroke="currentColor" stroke-width="2"/><path d="M4 38h40" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M14 6v12M30 6v12M14 22v12M30 22v12" stroke="currentColor" stroke-width="1.5" stroke-dasharray="2 2"/></svg>
                    </div>
                    <h3 class="detail-card-title"<?= cmsAttr($blockMap, 'detail_beplan', 'title') ?>><?= e(cms($blockMap, 'detail_beplan', 'title', 'Beplankungen')) ?></h3>
                    <p class="detail-card-desc"<?= cmsAttr($blockMap, 'detail_beplan', 'content') ?>><?= e(cms($blockMap, 'detail_beplan', 'content', 'Vorwände beplanken mit 1x 18mm oder 2x 12.5mm Platten. Saubere Ausführung für perfekte Oberflächen.')) ?></p>
                </div>
                <div class="detail-card">
                    <div class="detail-card-icon">
                        <!-- AquaPanel: Wassertropfen + Platte -->
                        <svg viewBox="0 0 48 48" fill="none"><rect x="6" y="14" width="36" height="28" rx="2" stroke="currentColor" stroke-width="2"/><path d="M24 4c-3 4-6 7-6 10a6 6 0 0012 0c0-3-3-6-6-10z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/><path d="M14 28h20M14 34h12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    </div>
                    <h3 class="detail-card-title"<?= cmsAttr($blockMap, 'detail_aqua', 'title') ?>><?= e(cms($blockMap, 'detail_aqua', 'title', 'AquaPanel')) ?></h3>
                    <p class="detail-card-desc"<?= cmsAttr($blockMap, 'detail_aqua', 'content') ?>><?= e(cms($blockMap, 'detail_aqua', 'content', 'Geberit AquaPanel 2x 12mm für Feuchträume. Zementgebundene Bauplatten – wasserfest, schimmelfrei, dauerhaft.')) ?></p>
                </div>
                <div class="detail-card">
                    <div class="detail-card-icon">
                        <!-- Spachtelungen: Spachtel/Kelle -->
                        <svg viewBox="0 0 48 48" fill="none"><path d="M8 40l6-6M14 34l20-20a4 4 0 00-5.6-5.6L8 28.4V40h6z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/><path d="M28 14l6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M4 44h40" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    </div>
                    <h3 class="detail-card-title"<?= cmsAttr($blockMap, 'detail_spachtel', 'title') ?>><?= e(cms($blockMap, 'detail_spachtel', 'title', 'Spachtelungen')) ?></h3>
                    <p class="detail-card-desc"<?= cmsAttr($blockMap, 'detail_spachtel', 'content') ?>><?= e(cms($blockMap, 'detail_spachtel', 'content', 'Fachgerechte Spachtelungen an Vorwänden für perfekte, glatte Oberflächen. Bereit für Fliesen, Putz oder Anstrich.')) ?></p>
                </div>
                <div class="detail-card">
                    <div class="detail-card-icon">
                        <!-- Ausflockungen: Füllung/Isolierung -->
                        <svg viewBox="0 0 48 48" fill="none"><rect x="8" y="4" width="12" height="40" rx="1" stroke="currentColor" stroke-width="2"/><rect x="28" y="4" width="12" height="40" rx="1" stroke="currentColor" stroke-width="2"/><path d="M20 12h8M20 20h8M20 28h8M20 36h8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-dasharray="2 3"/><circle cx="24" cy="16" r="2" fill="currentColor" opacity="0.4"/><circle cx="24" cy="24" r="2" fill="currentColor" opacity="0.4"/><circle cx="24" cy="32" r="2" fill="currentColor" opacity="0.4"/></svg>
                    </div>
                    <h3 class="detail-card-title"<?= cmsAttr($blockMap, 'detail_ausflockung', 'title') ?>><?= e(cms($blockMap, 'detail_ausflockung', 'title', 'Ausflockungen')) ?></h3>
                    <p class="detail-card-desc"<?= cmsAttr($blockMap, 'detail_ausflockung', 'content') ?>><?= e(cms($blockMap, 'detail_ausflockung', 'content', 'Ausflockungen an Installationswänden für einen sauberen Abschluss. Belegfertige Oberflächen für jeden Belag.')) ?></p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="section section-cta" aria-label="Kontakt aufnehmen">
        <div class="cta-bg"></div>
        <div class="container">
            <div class="cta-content" data-reveal>
                <h2 class="cta-title"<?= cmsAttr($blockMap, 'cta', 'title') ?>><?= e(cms($blockMap, 'cta', 'title', 'Haben Sie ein Projekt?')) ?></h2>
                <p class="cta-text"<?= cmsAttr($blockMap, 'cta', 'content') ?>><?= e(cms($blockMap, 'cta', 'content', 'Wir beraten Sie gerne – von der Vorfabrikation bis zur Montage.')) ?></p>
                <div class="cta-actions"><a href="<?= pageUrl('kontakt') ?>" class="btn btn-primary btn-lg"<?= cmsAttr($blockMap, 'cta', 'link_text') ?>><?= e(cms($blockMap, 'cta', 'link_text', 'Kontakt aufnehmen')) ?></a></div>
            </div>
        </div>
    </section>

