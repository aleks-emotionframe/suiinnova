<?php
/**
 * Footer
 *
 * Design: Dunkelgrauer Hintergrund, weisse Schrift, dezenter roter Akzent oben.
 */
?>

<!-- Footer -->
<footer class="bg-gray-900 text-white">
    <!-- Roter Akzent-Strich oben (2px) -->
    <div class="h-0.5 bg-brand-accent"></div>

    <div class="max-w-container mx-auto px-4 md:px-6 py-12 md:py-16">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10 md:gap-12">

            <!-- Spalte 1: Firma -->
            <div>
                <img
                    src="<?= e(setting('footer_logo_url', asset('img/SUI-Innova_Logo_white.webp'))) ?>"
                    alt="<?= e(setting('site_name', SITE_NAME)) ?>"
                    class="h-8 mb-6 brightness-0 invert"
                >
                <p class="text-gray-400 text-sm leading-relaxed">
                    <?= e(setting('footer_text', 'Vorfabrikation und Montage von GIS-Elementen. Unkompliziert, transparent, flexibel.')) ?>
                </p>
            </div>

            <!-- Spalte 2: Navigation -->
            <div>
                <h3 class="text-xs font-medium uppercase tracking-widest text-gray-400 mb-4">Navigation</h3>
                <nav class="flex flex-col gap-2">
                    <?php foreach ($navigation as $item): ?>
                        <a
                            href="<?= e($item['url'] ?: url($item['page_slug'] ?? '')) ?>"
                            class="text-sm text-gray-300 hover:text-white transition-colors duration-200"
                        >
                            <?= e($item['label']) ?>
                        </a>
                    <?php endforeach; ?>
                </nav>
            </div>

            <!-- Spalte 3: Kontakt -->
            <div>
                <h3 class="text-xs font-medium uppercase tracking-widest text-gray-400 mb-4">Kontakt</h3>
                <address class="not-italic text-sm text-gray-300 space-y-2">
                    <p><?= e(setting('company_name', 'SUI Innova GmbH')) ?></p>
                    <p><?= e(setting('address_street', 'Talstrasse 31')) ?></p>
                    <p><?= e(setting('address_city', '8808 Pfäffikon')) ?></p>
                    <?php if ($phone = setting('phone')): ?>
                        <p class="pt-2">
                            <a href="tel:<?= e(preg_replace('/\s+/', '', $phone)) ?>" class="hover:text-white transition-colors duration-200">
                                <?= e($phone) ?>
                            </a>
                        </p>
                    <?php endif; ?>
                    <?php if ($email = setting('contact_email', 'info@sui-innova.ch')): ?>
                        <p>
                            <a href="mailto:<?= e($email) ?>" class="hover:text-white transition-colors duration-200">
                                <?= e($email) ?>
                            </a>
                        </p>
                    <?php endif; ?>
                </address>
            </div>
        </div>

        <!-- Copyright -->
        <div class="mt-12 pt-6 border-t border-white/10 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-xs text-gray-500">
                &copy; <?= date('Y') ?> <?= e(setting('site_name', SITE_NAME)) ?>. Alle Rechte vorbehalten.
            </p>
            <div class="flex items-center gap-4 text-xs text-gray-500">
                <a href="<?= url('datenschutz') ?>" class="hover:text-gray-300 transition-colors duration-200">Datenschutz</a>
                <a href="<?= url('impressum') ?>" class="hover:text-gray-300 transition-colors duration-200">Impressum</a>
                <span class="text-gray-600">·</span>
                <a href="<?= e(setting('created_by_url', 'https://emotionframe.ch')) ?>" target="_blank" rel="noopener" class="hover:text-gray-300 transition-colors duration-200">
                    Created by <?= e(setting('created_by', 'EmotionFrame')) ?>
                </a>
            </div>
        </div>
    </div>
</footer>
