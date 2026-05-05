<?php
/**
 * Cookie-Banner mit echtem Consent (DSGVO/revDSG-konform).
 *
 * Responsive:
 * - Desktop/Tablet: kompakt in einer Reihe (Icon + Text + 2 Buttons)
 * - Mobile: gestackt, Buttons untereinander, kleinere Schrift
 */

$cookieVisible = setting('cookie_visible', '1') === '1';
$accepted = $_COOKIE['cookies_accepted'] ?? '';
$hasChoice = in_array($accepted, ['all', 'necessary'], true);
if (!$cookieVisible || $hasChoice) return;

$cookieText        = setting('cookie_text', 'Wir verwenden technisch notwendige Cookies und – mit Ihrer Einwilligung – Statistik-Cookies (Google Analytics) zur anonymen Analyse der Website-Nutzung.');
$cookieAcceptAll   = setting('cookie_btn_accept_all', 'Alle akzeptieren');
$cookieAcceptOnly  = setting('cookie_btn_accept_only', 'Nur notwendige');
$cookieLinkText    = setting('cookie_link_text', 'Datenschutzerklärung');
?>

<div id="cookie-banner" class="cookie-banner" role="dialog" aria-label="Cookie-Hinweis">
    <div class="cookie-banner-accent"></div>
    <div class="cookie-banner-inner">
        <!-- Icon + Text -->
        <div class="cookie-banner-content">
            <svg class="cookie-banner-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 12c0 1.5-.4 2.9-1.1 4.1m-9.4-13C5.5 3.9 2 7.5 2 12a10 10 0 0010 10c4.4 0 8-3.5 9-7.9-3.5-.4-6-3.4-5.7-7-3.5-.5-6.4-3.5-6.7-7m6.5 5.5h.01M9 16h.01M16 14h.01"/>
            </svg>
            <div class="cookie-banner-text">
                <?= e($cookieText) ?>
                <a href="<?= url('datenschutz') ?>" class="cookie-banner-link"><?= e($cookieLinkText) ?> →</a>
            </div>
        </div>

        <!-- Buttons -->
        <div class="cookie-banner-buttons">
            <button type="button" onclick="acceptCookies('necessary')" class="cookie-banner-btn cookie-banner-btn-secondary">
                <?= e($cookieAcceptOnly) ?>
            </button>
            <button type="button" onclick="acceptCookies('all')" class="cookie-banner-btn cookie-banner-btn-primary">
                <?= e($cookieAcceptAll) ?>
            </button>
        </div>
    </div>
</div>

<style>
.cookie-banner {
    position: fixed;
    left: 12px; right: 12px; bottom: 12px;
    z-index: 90;
    max-width: 920px;
    margin: 0 auto;
    background: #111827;
    color: #fff;
    border-radius: 6px;
    box-shadow: 0 20px 50px -10px rgba(0,0,0,0.4);
    overflow: hidden;
}
.cookie-banner-accent { height: 2px; background: #C41018; }
.cookie-banner-inner {
    padding: 14px 16px;
    display: flex;
    align-items: center;
    gap: 14px;
}
.cookie-banner-content {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    flex: 1;
    min-width: 0;
}
.cookie-banner-icon {
    width: 20px; height: 20px;
    flex-shrink: 0;
    color: #C41018;
    margin-top: 2px;
}
.cookie-banner-text {
    flex: 1;
    min-width: 0;
    font-size: 13px;
    line-height: 1.5;
    color: rgba(255,255,255,0.85);
}
.cookie-banner-link {
    color: #fff;
    text-decoration: underline;
    text-underline-offset: 3px;
    font-weight: 500;
    white-space: nowrap;
    margin-left: 4px;
}
.cookie-banner-buttons {
    display: flex;
    gap: 8px;
    flex-shrink: 0;
}
.cookie-banner-btn {
    height: 38px;
    padding: 0 16px;
    font-size: 11.5px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.15s;
    white-space: nowrap;
    font-family: inherit;
}
.cookie-banner-btn-secondary {
    background: transparent;
    color: rgba(255,255,255,0.9);
    border: 1px solid rgba(255,255,255,0.3);
}
.cookie-banner-btn-secondary:hover {
    background: rgba(255,255,255,0.1);
    border-color: rgba(255,255,255,0.5);
}
.cookie-banner-btn-primary {
    background: #C41018;
    color: #fff;
    border: 0;
}
.cookie-banner-btn-primary:hover { opacity: 0.9; }

/* Desktop / Tablet — etwas mehr Padding und Schrift */
@media (min-width: 768px) {
    .cookie-banner-inner { padding: 18px 22px; gap: 20px; }
    .cookie-banner-icon { width: 22px; height: 22px; }
    .cookie-banner-text { font-size: 14px; }
    .cookie-banner-btn { height: 40px; padding: 0 18px; font-size: 12px; }
}

/* Mobile — gestackt, Buttons full-width untereinander */
@media (max-width: 639px) {
    .cookie-banner { left: 8px; right: 8px; bottom: 8px; }
    .cookie-banner-inner {
        padding: 14px 14px;
        flex-direction: column;
        align-items: stretch;
        gap: 12px;
    }
    .cookie-banner-text { font-size: 12.5px; line-height: 1.5; }
    .cookie-banner-buttons {
        display: grid;
        grid-template-columns: 1fr;
        gap: 6px;
    }
    .cookie-banner-btn { width: 100%; height: 42px; }
    /* Reihenfolge tauschen — primary oben (besser fuer Daumen-Reichweite) */
    .cookie-banner-btn-primary { order: -1; }
}
</style>

<script>
function acceptCookies(level) {
    var maxAge = 365 * 24 * 60 * 60;
    var secure = (location.protocol === 'https:') ? '; Secure' : '';
    document.cookie = 'cookies_accepted=' + level + '; path=/; max-age=' + maxAge + '; SameSite=Lax' + secure;

    var banner = document.getElementById('cookie-banner');
    if (banner) {
        banner.style.transition = 'opacity 0.3s, transform 0.3s';
        banner.style.opacity = '0';
        banner.style.transform = 'translateY(20px)';
        setTimeout(function() { banner.remove(); }, 300);
    }

    if (level === 'all' && typeof window.loadAnalytics === 'function') {
        window.loadAnalytics();
    }
}

window.resetCookieConsent = function() {
    document.cookie = 'cookies_accepted=; path=/; expires=Thu, 01 Jan 1970 00:00:00 GMT';
    location.reload();
};
</script>
