
    <section class="section page-title-section" aria-label="Kontakt">
        <div class="container">
            <div class="page-title-content" data-reveal>
                <span class="section-label">Kontakt</span>
                <h1 class="page-title">Kontaktieren Sie uns</h1>
                <p class="page-title-desc">Wir freuen uns auf Ihre Anfrage. Kontaktieren Sie uns für eine unverbindliche Beratung.</p>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="section section-contact" aria-label="Kontaktformular und Informationen">
        <div class="container">
            <?php $flash = getFlash(); ?>
            <?php if ($flash): ?>
            <div class="alert alert-<?= e($flash['type']) ?>" role="alert"><?= e($flash['message']) ?></div>
            <?php endif; ?>

            <div class="contact-grid">
                <!-- Contact Form -->
                <div class="contact-form-col" data-reveal>
                    <h2 class="contact-form-title">Schreiben Sie uns</h2>
                    <form action="<?= pageUrl('kontakt') ?>" method="post" class="contact-form" novalidate>
                        <input type="hidden" name="<?= CSRF_TOKEN_NAME ?>" value="<?= Auth::generateCsrfToken() ?>">

                        <!-- Honeypot -->
                        <div class="form-field-hp" aria-hidden="true">
                            <label for="website">Website</label>
                            <input type="text" name="website" id="website" tabindex="-1" autocomplete="off">
                        </div>

                        <div class="form-row">
                            <div class="form-field">
                                <label for="name" class="form-label">Name <span class="required" aria-label="Pflichtfeld">*</span></label>
                                <input type="text" id="name" name="name" class="form-input" required autocomplete="name" placeholder="Ihr vollständiger Name">
                            </div>
                            <div class="form-field">
                                <label for="company" class="form-label">Firma</label>
                                <input type="text" id="company" name="company" class="form-input" autocomplete="organization" placeholder="Ihre Firma">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-field">
                                <label for="email" class="form-label">E-Mail <span class="required" aria-label="Pflichtfeld">*</span></label>
                                <input type="email" id="email" name="email" class="form-input" required autocomplete="email" placeholder="ihre@email.ch">
                            </div>
                            <div class="form-field">
                                <label for="phone" class="form-label">Telefon</label>
                                <input type="tel" id="phone" name="phone" class="form-input" autocomplete="tel" placeholder="+41 ...">
                            </div>
                        </div>

                        <div class="form-field">
                            <label for="subject" class="form-label">Betreff</label>
                            <input type="text" id="subject" name="subject" class="form-input" placeholder="Worum geht es?">
                        </div>

                        <div class="form-field">
                            <label for="message" class="form-label">Nachricht <span class="required" aria-label="Pflichtfeld">*</span></label>
                            <textarea id="message" name="message" class="form-input form-textarea" rows="6" required placeholder="Ihre Nachricht an uns..."></textarea>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary btn-lg">
                                Nachricht senden
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M4 10h12m0 0l-4-4m4 4l-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Contact Info -->
                <div class="contact-info-col" data-reveal data-delay="1">
                    <div class="contact-info-card">
                        <h2 class="contact-info-title">Kontaktdaten</h2>

                        <div class="contact-info-item">
                            <div class="contact-info-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/><path d="M9 22V12h6v10" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/></svg>
                            </div>
                            <div>
                                <h3 class="contact-info-label">Adresse</h3>
                                <address class="contact-info-value">
                                    Musterstrasse 42<br>8000 Zürich
                                </address>
                            </div>
                        </div>

                        <div class="contact-info-item">
                            <div class="contact-info-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none"><path d="M3 5a2 2 0 012-2h2.28a1 1 0 01.95.68l1.05 3.16a1 1 0 01-.24 1.02l-1.3 1.3a10.06 10.06 0 004.1 4.1l1.3-1.3a1 1 0 011.02-.24l3.16 1.05a1 1 0 01.68.95V19a2 2 0 01-2 2A15 15 0 013 5z" stroke="currentColor" stroke-width="1.5"/></svg>
                            </div>
                            <div>
                                <h3 class="contact-info-label">Telefon</h3>
                                <a href="tel:+41440000000" class="contact-info-value contact-info-link">
                                    +41 44 000 00 00
                                </a>
                            </div>
                        </div>

                        <div class="contact-info-item">
                            <div class="contact-info-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none"><rect x="2" y="4" width="20" height="16" rx="2" stroke="currentColor" stroke-width="1.5"/><path d="M2 7l10 7 10-7" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/></svg>
                            </div>
                            <div>
                                <h3 class="contact-info-label">E-Mail</h3>
                                <a href="mailto:info@suiinnova.ch" class="contact-info-value contact-info-link">
                                    info@suiinnova.ch
                                </a>
                            </div>
                        </div>

                        <div class="contact-info-item">
                            <div class="contact-info-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5"/><path d="M12 6v6l4 2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </div>
                            <div>
                                <h3 class="contact-info-label">Öffnungszeiten</h3>
                                <p class="contact-info-value">Mo – Fr: 07:00 – 17:00 Uhr</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

