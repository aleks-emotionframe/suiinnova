
    <!-- Page Title -->
    <section class="section page-title-section" aria-label="Kompetenzen">
        <div class="container">
            <div class="page-title-content" data-reveal>
                <span class="section-label">Kompetenzen</span>
                <h1 class="page-title"><?= e(cms($blockMap, 'page_title', 'title', 'Vorfabrikation & Montage')) ?></h1>
                <p class="page-title-desc"><?= e(cms($blockMap, 'page_title', 'content', 'Ein Ansprechpartner, durchgängige Qualität, optimierte Abläufe – von der Werkstatt bis zur fertigen Oberfläche.')) ?></p>
            </div>
        </div>
    </section>

    <!-- Vorfabrikation: Bild links, Text rechts -->
    <section class="section" id="vorfabrikation" aria-labelledby="vorfab-heading">
        <div class="container">
            <div class="komp-split" data-reveal>
                <div class="komp-split-img">
                    <img src="<?= e(cms($blockMap, 'vorfab_header', 'image_path', 'https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=800&q=80')) ?>" alt="Vorfabrikation" loading="lazy">
                </div>
                <div class="komp-split-body">
                    <span class="section-label">01 — Vorfabrikation</span>
                    <h2 class="section-title" id="vorfab-heading"><?= e(cms($blockMap, 'vorfab_header', 'title', 'Präzision aus der Werkstatt')) ?></h2>
                    <p><?= e(cms($blockMap, 'vorfab_header', 'content', 'In unserer Werkstatt fertigen wir massgeschneiderte Komponenten, die auf der Baustelle effizient installiert werden. Das spart Zeit, senkt Kosten und garantiert gleichbleibende Qualität.')) ?></p>
                    <div class="komp-services">
                        <div class="komp-service">
                            <h3><?= e(cms($blockMap, 'vorfab_gis', 'title', 'GIS-Elemente')) ?></h3>
                            <p><?= e(cms($blockMap, 'vorfab_gis', 'content', 'Geberit Installationssysteme massgenau vorfabriziert – bereit für die schnelle Montage.')) ?></p>
                        </div>
                        <div class="komp-service">
                            <h3><?= e(cms($blockMap, 'vorfab_rohr', 'title', 'Rohrleitungsbau')) ?></h3>
                            <p><?= e(cms($blockMap, 'vorfab_rohr', 'content', 'Trinkwasser, Heizung, Abwasser – alle Materialien und Verbindungstechniken nach SIA-Normen.')) ?></p>
                        </div>
                        <div class="komp-service">
                            <h3><?= e(cms($blockMap, 'vorfab_sto', 'title', 'STOClick')) ?></h3>
                            <p><?= e(cms($blockMap, 'vorfab_sto', 'content', 'Schnellmontage-System für sichere Befestigung und optimierte Baustellenabläufe.')) ?></p>
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
                    <img src="<?= e(cms($blockMap, 'montage_header', 'image_path', 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?w=800&q=80')) ?>" alt="Montage" loading="lazy">
                </div>
                <div class="komp-split-body">
                    <span class="section-label">02 — Montage vor Ort</span>
                    <h2 class="section-title" id="montage-heading"><?= e(cms($blockMap, 'montage_header', 'title', 'Fachgerecht auf der Baustelle')) ?></h2>
                    <p><?= e(cms($blockMap, 'montage_header', 'content', 'Unser erfahrenes Team montiert direkt vor Ort – von der Vorwandinstallation bis zur fertigen Oberfläche, koordiniert mit allen Gewerken.')) ?></p>
                    <div class="komp-services">
                        <div class="komp-service">
                            <h3><?= e(cms($blockMap, 'montage_duofix', 'title', 'Duofix & Vorwände')) ?></h3>
                            <p><?= e(cms($blockMap, 'montage_duofix', 'content', 'Geberit Duofix, geschweisste Vorwände und alle gängigen Sanitärvorwandsysteme.')) ?></p>
                        </div>
                        <div class="komp-service">
                            <h3><?= e(cms($blockMap, 'montage_beplan', 'title', 'Beplankungen & AquaPanel')) ?></h3>
                            <p><?= e(cms($blockMap, 'montage_beplan', 'content', '1x 18mm oder 2x 12.5mm Platten. AquaPanel 2x 12mm für Feuchträume.')) ?></p>
                        </div>
                        <div class="komp-service">
                            <h3><?= e(cms($blockMap, 'montage_spachtel', 'title', 'Spachtelungen')) ?></h3>
                            <p><?= e(cms($blockMap, 'montage_spachtel', 'content', 'Fachgerechte Spachtelungen und Ausflockungen – bereit für Fliesen oder Anstrich.')) ?></p>
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
                <h2 class="section-title" id="detail-heading"><?= e(cms($blockMap, 'details_header', 'title', 'Alle Leistungen auf einen Blick')) ?></h2>
            </div>
            <div class="details-grid" data-reveal>
                <div class="detail-card">
                    <div class="detail-card-icon">
                        <svg viewBox="0 0 48 48" fill="none"><rect x="4" y="22" width="40" height="22" rx="3" stroke="currentColor" stroke-width="2"/><path d="M14 22V12a10 10 0 0120 0v10" stroke="currentColor" stroke-width="2"/><path d="M20 33h8" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    </div>
                    <h3 class="detail-card-title"><?= e(cms($blockMap, 'detail_gis', 'title', 'GIS-Elemente vorfabrizieren')) ?></h3>
                    <p class="detail-card-desc"><?= e(cms($blockMap, 'detail_gis', 'content', 'Geberit Installationssysteme massgenau in der Werkstatt vorbereiten. Qualitätskontrolle vor Auslieferung, termingerechte Lieferung.')) ?></p>
                </div>
                <div class="detail-card">
                    <div class="detail-card-icon">
                        <svg viewBox="0 0 48 48" fill="none"><circle cx="24" cy="24" r="18" stroke="currentColor" stroke-width="2"/><path d="M24 12v12l8 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <h3 class="detail-card-title"><?= e(cms($blockMap, 'detail_gis_montage', 'title', 'GIS-Elemente montieren')) ?></h3>
                    <p class="detail-card-desc"><?= e(cms($blockMap, 'detail_gis_montage', 'content', 'Fachgerechte Montage nach Herstellervorgaben direkt auf der Baustelle. Koordiniert mit allen beteiligten Gewerken.')) ?></p>
                </div>
                <div class="detail-card">
                    <div class="detail-card-icon">
                        <svg viewBox="0 0 48 48" fill="none"><path d="M8 44V4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M8 12h20a4 4 0 010 8H8" stroke="currentColor" stroke-width="2"/><path d="M8 28h28a4 4 0 010 8H8" stroke="currentColor" stroke-width="2"/></svg>
                    </div>
                    <h3 class="detail-card-title"><?= e(cms($blockMap, 'detail_rohr', 'title', 'Rohrleitungsbau')) ?></h3>
                    <p class="detail-card-desc"><?= e(cms($blockMap, 'detail_rohr', 'content', 'Trinkwasser-, Heizungs- und Abwasserleitungen. Edelstahl, Kupfer, Kunststoff – alle Verbindungstechniken nach SIA-Normen.')) ?></p>
                </div>
                <div class="detail-card">
                    <div class="detail-card-icon">
                        <svg viewBox="0 0 48 48" fill="none"><rect x="6" y="6" width="36" height="36" rx="4" stroke="currentColor" stroke-width="2"/><path d="M6 18h36M18 6v36" stroke="currentColor" stroke-width="2"/><circle cx="12" cy="12" r="2" fill="currentColor"/></svg>
                    </div>
                    <h3 class="detail-card-title"><?= e(cms($blockMap, 'detail_sto', 'title', 'STOClick')) ?></h3>
                    <p class="detail-card-desc"><?= e(cms($blockMap, 'detail_sto', 'content', 'Schnellmontage-System für sichere Befestigung. Effiziente Vorfabrikation verkürzt Montagezeiten auf der Baustelle.')) ?></p>
                </div>
                <div class="detail-card">
                    <div class="detail-card-icon">
                        <svg viewBox="0 0 48 48" fill="none"><path d="M12 44V14a2 2 0 012-2h20a2 2 0 012 2v30" stroke="currentColor" stroke-width="2"/><path d="M4 44h40" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M20 12V6h8v6" stroke="currentColor" stroke-width="2"/></svg>
                    </div>
                    <h3 class="detail-card-title"><?= e(cms($blockMap, 'detail_duofix', 'title', 'Duofix & Vorwände')) ?></h3>
                    <p class="detail-card-desc"><?= e(cms($blockMap, 'detail_duofix', 'content', 'Geberit Duofix und alle gängigen Sanitärvorwandsysteme – auch geschweisst. Für Wohnbau, Gewerbe und Spitäler.')) ?></p>
                </div>
                <div class="detail-card">
                    <div class="detail-card-icon">
                        <svg viewBox="0 0 48 48" fill="none"><rect x="2" y="8" width="44" height="32" rx="3" stroke="currentColor" stroke-width="2"/><path d="M2 20h44" stroke="currentColor" stroke-width="2"/></svg>
                    </div>
                    <h3 class="detail-card-title"><?= e(cms($blockMap, 'detail_beplan', 'title', 'Beplankungen')) ?></h3>
                    <p class="detail-card-desc"><?= e(cms($blockMap, 'detail_beplan', 'content', 'Vorwände beplanken mit 1x 18mm oder 2x 12.5mm Platten. Saubere Ausführung für perfekte Oberflächen.')) ?></p>
                </div>
                <div class="detail-card">
                    <div class="detail-card-icon">
                        <svg viewBox="0 0 48 48" fill="none"><rect x="2" y="4" width="44" height="40" rx="4" stroke="currentColor" stroke-width="2"/><circle cx="24" cy="24" r="10" stroke="currentColor" stroke-width="2"/><path d="M24 18v12M18 24h12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    </div>
                    <h3 class="detail-card-title"><?= e(cms($blockMap, 'detail_aqua', 'title', 'AquaPanel')) ?></h3>
                    <p class="detail-card-desc"><?= e(cms($blockMap, 'detail_aqua', 'content', 'Geberit AquaPanel 2x 12mm für Feuchträume. Zementgebundene Bauplatten – wasserfest, schimmelfrei, dauerhaft.')) ?></p>
                </div>
                <div class="detail-card">
                    <div class="detail-card-icon">
                        <svg viewBox="0 0 48 48" fill="none"><path d="M6 38h36" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M10 38V18l14-10 14 10v20" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/><path d="M18 38v-10h12v10" stroke="currentColor" stroke-width="2"/></svg>
                    </div>
                    <h3 class="detail-card-title"><?= e(cms($blockMap, 'detail_spachtel', 'title', 'Spachtelungen & Ausflockungen')) ?></h3>
                    <p class="detail-card-desc"><?= e(cms($blockMap, 'detail_spachtel', 'content', 'Fachgerechte Spachtelungen an Vorwänden. Perfekte Oberflächen, bereit für Fliesen, Putz oder Anstrich.')) ?></p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="section section-cta" aria-label="Kontakt aufnehmen">
        <div class="cta-bg"></div>
        <div class="container">
            <div class="cta-content" data-reveal>
                <h2 class="cta-title"><?= e(cms($blockMap, 'cta', 'title', 'Haben Sie ein Projekt?')) ?></h2>
                <p class="cta-text"><?= e(cms($blockMap, 'cta', 'content', 'Wir beraten Sie gerne – von der Vorfabrikation bis zur Montage.')) ?></p>
                <div class="cta-actions"><a href="<?= pageUrl('kontakt') ?>" class="btn btn-primary btn-lg">Kontakt aufnehmen</a></div>
            </div>
        </div>
    </section>

