    </main>

    <footer class="site-footer">
        <div class="footer-top">
            <div class="container">
                <div class="footer-grid">
                    <div class="footer-col footer-brand">
                        <a href="<?= SITE_URL ?>/" class="footer-logo" aria-label="SUI Innova GmbH">
                            <img src="<?= SITE_URL ?>/assets/img/SUI-Innova_Logo.webp" alt="SUI Innova GmbH" class="footer-logo-img">
                        </a>
                        <p class="footer-tagline"><?= e(setting('site_tagline', 'Vorfabrikation & Montage für die Gebäudetechnik')) ?></p>
                    </div>

                    <div class="footer-col">
                        <h3 class="footer-heading">Navigation</h3>
                        <ul class="footer-links">
                            <?php foreach (($navPages ?? getNavPages()) as $navItem): ?>
                            <li><a href="<?= pageUrl($navItem['slug']) ?>"><?= e($navItem['title']) ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <div class="footer-col">
                        <h3 class="footer-heading">Kompetenzen</h3>
                        <ul class="footer-links">
                            <li><a href="<?= pageUrl('kompetenzen') ?>#vorfabrikation">Vorfabrikation</a></li>
                            <li><a href="<?= pageUrl('kompetenzen') ?>#montage">Montage vor Ort</a></li>
                            <li><a href="<?= pageUrl('kompetenzen') ?>">GIS-Elemente</a></li>
                            <li><a href="<?= pageUrl('kompetenzen') ?>">Rohrleitungsbau</a></li>
                        </ul>
                    </div>

                    <div class="footer-col">
                        <h3 class="footer-heading">Kontakt</h3>
                        <address class="footer-contact">
                            <p><?= nl2br(e(setting('site_address', 'Musterstrasse 42, 8000 Zürich'))) ?></p>
                            <p><a href="tel:<?= e(str_replace(' ', '', setting('site_phone', '+41 44 000 00 00'))) ?>"><?= e(setting('site_phone', '+41 44 000 00 00')) ?></a></p>
                            <p><a href="mailto:<?= e(setting('site_email', 'info@suiinnova.ch')) ?>"><?= e(setting('site_email', 'info@suiinnova.ch')) ?></a></p>
                        </address>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="container">
                <div class="footer-bottom-inner">
                    <p><?= e(setting('footer_text', '© ' . date('Y') . ' SUI Innova GmbH. Alle Rechte vorbehalten.')) ?></p>
                    <div class="footer-legal">
                        <a href="#">Impressum</a>
                        <a href="#">Datenschutz</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="<?= SITE_URL ?>/assets/js/main.js"></script>
    <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
    <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/inline-editor.css">
    <script src="<?= SITE_URL ?>/assets/js/inline-editor.js"></script>
    <?php endif; ?>
</body>
</html>
