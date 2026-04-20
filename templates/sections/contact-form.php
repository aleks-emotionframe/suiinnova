<?php
/**
 * Kontaktformular Section
 *
 * 2-Spalten Layout: Formular links, Kontaktinfos rechts.
 * DESIGN.md: Bottom-Border Inputs, Square Button, dezente Gestaltung.
 */

$heading     = $content['heading'] ?? '';
$subtitle    = $content['subtitle'] ?? '';
$showAddress = (bool) ($content['show_address'] ?? true);
$showPhone   = (bool) ($content['show_phone'] ?? true);

$flash = getFlash();
$formData = $_SESSION['form_data'] ?? [];
unset($_SESSION['form_data']);
?>

<section class="section bg-gray-50" id="kontakt">
    <div class="section-container">
        <!-- Header -->
        <div class="mb-12 md:mb-16 fade-in">
            <?php if ($heading): ?>
                <h2 class="section-heading"><?= e($heading) ?></h2>
            <?php endif; ?>
            <?php if ($subtitle): ?>
                <div class="section-subtitle"><?= renderRichtext($subtitle) ?></div>
            <?php endif; ?>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-10 lg:gap-16">
            <!-- Formular (3/5) -->
            <div class="lg:col-span-3 fade-in">
                <!-- Flash Message -->
                <?php if ($flash): ?>
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                         class="mb-6 px-4 py-3 text-sm font-medium
                                <?= $flash['type'] === 'success' ? 'bg-gray-900 text-white' : 'bg-brand-accent text-white' ?>">
                        <?= e($flash['message']) ?>
                    </div>
                <?php endif; ?>

                <form action="<?= url('kontakt/senden') ?>" method="POST" class="space-y-6"
                      x-data="{ sending: false }" @submit="sending = true">

                    <?= csrfField() ?>
                    <input type="hidden" name="page_source" value="<?= e($currentSlug ?? 'startseite') ?>">

                    <!-- Honeypot (versteckt, Spam-Schutz) -->
                    <div class="absolute -left-[9999px]" aria-hidden="true">
                        <input type="text" name="website_url" tabindex="-1" autocomplete="off">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div>
                            <label for="name" class="form-label">Name *</label>
                            <input type="text" name="name" id="name"
                                   value="<?= e($formData['name'] ?? '') ?>"
                                   placeholder="Ihr Name" required
                                   class="form-input">
                        </div>

                        <!-- E-Mail -->
                        <div>
                            <label for="email" class="form-label">E-Mail *</label>
                            <input type="email" name="email" id="email"
                                   value="<?= e($formData['email'] ?? '') ?>"
                                   placeholder="ihre@email.ch" required
                                   class="form-input">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Telefon -->
                        <div>
                            <label for="phone" class="form-label">Telefon</label>
                            <input type="tel" name="phone" id="phone"
                                   value="<?= e($formData['phone'] ?? '') ?>"
                                   placeholder="+41 44 000 00 00"
                                   class="form-input">
                        </div>

                        <!-- Firma -->
                        <div>
                            <label for="company" class="form-label">Firma</label>
                            <input type="text" name="company" id="company"
                                   value="<?= e($formData['company'] ?? '') ?>"
                                   placeholder="Ihre Firma"
                                   class="form-input">
                        </div>
                    </div>

                    <!-- Nachricht -->
                    <div>
                        <label for="message" class="form-label">Nachricht *</label>
                        <textarea name="message" id="message" rows="4"
                                  placeholder="Ihre Nachricht..." required
                                  class="form-textarea"><?= e($formData['message'] ?? '') ?></textarea>
                    </div>

                    <!-- Submit -->
                    <div>
                        <button type="submit" class="btn-primary" :disabled="sending">
                            <span x-show="!sending">Nachricht senden</span>
                            <span x-show="sending" x-cloak>Wird gesendet...</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Kontaktinfos (2/5) -->
            <div class="lg:col-span-2 fade-in">
                <div class="space-y-8">
                    <!-- Adresse -->
                    <?php if ($showAddress): ?>
                        <div>
                            <h3 class="text-xs font-medium uppercase tracking-widest text-gray-500 mb-3">Adresse</h3>
                            <address class="not-italic text-gray-600 text-sm space-y-1">
                                <p class="font-medium text-gray-900"><?= e(setting('company_name', 'SUI Innova GmbH')) ?></p>
                                <p><?= e(setting('address_street', 'Talstrasse 31')) ?></p>
                                <p><?= e(setting('address_city', '8808 Pfäffikon')) ?></p>
                            </address>
                        </div>
                    <?php endif; ?>

                    <!-- Telefon -->
                    <?php if ($showPhone && $phone = setting('phone')): ?>
                        <div>
                            <h3 class="text-xs font-medium uppercase tracking-widest text-gray-500 mb-3">Telefon</h3>
                            <a href="tel:<?= e(preg_replace('/\s+/', '', $phone)) ?>"
                               class="text-sm text-gray-900 hover:text-brand-accent transition-colors duration-200">
                                <?= e($phone) ?>
                            </a>
                        </div>
                    <?php endif; ?>

                    <!-- E-Mail -->
                    <?php if ($email = setting('contact_email', 'info@sui-innova.ch')): ?>
                        <div>
                            <h3 class="text-xs font-medium uppercase tracking-widest text-gray-500 mb-3">E-Mail</h3>
                            <a href="mailto:<?= e($email) ?>"
                               class="text-sm text-gray-900 hover:text-brand-accent transition-colors duration-200">
                                <?= e($email) ?>
                            </a>
                        </div>
                    <?php endif; ?>

                    <!-- Werte -->
                    <div class="pt-6 border-t border-black/[0.08]">
                        <div class="flex flex-wrap gap-3">
                            <span class="px-3 py-1.5 bg-brand-accent-muted text-xs font-medium uppercase tracking-wider text-gray-700">Unkompliziert</span>
                            <span class="px-3 py-1.5 bg-brand-accent-muted text-xs font-medium uppercase tracking-wider text-gray-700">Flexibel</span>
                            <span class="px-3 py-1.5 bg-brand-accent-muted text-xs font-medium uppercase tracking-wider text-gray-700">Transparent</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
