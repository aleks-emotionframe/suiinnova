<?php
/**
 * Cookie-Banner mit echtem Consent (DSGVO/revDSG-konform).
 *
 * Zwei Optionen:
 * - „Alle akzeptieren" → cookies_accepted=all → Analytics wird geladen
 * - „Nur notwendige"  → cookies_accepted=necessary → keine Tracker
 *
 * Wird nur angezeigt wenn:
 * 1. cookie_visible aktiv (default: 1)
 * 2. Besucher noch keine Wahl getroffen hat
 *
 * Texte sind im CMS editierbar (Einstellungen → Cookie-Banner).
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

<div id="cookie-banner" role="dialog" aria-label="Cookie-Hinweis"
     style="position:fixed;left:16px;right:16px;bottom:16px;z-index:90;max-width:920px;margin:0 auto;background:#111827;color:#fff;border-radius:6px;box-shadow:0 20px 50px -10px rgba(0,0,0,0.4);overflow:hidden;">
    <div style="height:2px;background:#C41018;"></div>

    <div style="padding:20px 24px;display:flex;align-items:center;gap:20px;flex-wrap:wrap;">
        <!-- Cookie-Icon -->
        <svg style="width:24px;height:24px;flex-shrink:0;color:#C41018;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12c0 1.5-.4 2.9-1.1 4.1m-9.4-13C5.5 3.9 2 7.5 2 12a10 10 0 0010 10c4.4 0 8-3.5 9-7.9-3.5-.4-6-3.4-5.7-7-3.5-.5-6.4-3.5-6.7-7m6.5 5.5h.01M9 16h.01M16 14h.01"/>
        </svg>

        <!-- Text + Link -->
        <div style="flex:1;min-width:260px;font-size:14px;line-height:1.55;color:rgba(255,255,255,0.85);">
            <?= e($cookieText) ?>
            <a href="<?= url('datenschutz') ?>" style="color:#fff;text-decoration:underline;text-underline-offset:3px;margin-left:6px;font-weight:500;">
                <?= e($cookieLinkText) ?> →
            </a>
        </div>

        <!-- Buttons -->
        <div style="display:flex;gap:8px;flex-wrap:wrap;">
            <button type="button" onclick="acceptCookies('necessary')"
                    style="display:inline-flex;align-items:center;height:40px;padding:0 18px;background:transparent;color:rgba(255,255,255,0.9);font-size:12px;font-weight:600;text-transform:uppercase;letter-spacing:0.08em;border:1px solid rgba(255,255,255,0.3);border-radius:4px;cursor:pointer;transition:all 0.15s;"
                    onmouseover="this.style.background='rgba(255,255,255,0.1)';this.style.borderColor='rgba(255,255,255,0.5)'" onmouseout="this.style.background='transparent';this.style.borderColor='rgba(255,255,255,0.3)'">
                <?= e($cookieAcceptOnly) ?>
            </button>
            <button type="button" onclick="acceptCookies('all')"
                    style="display:inline-flex;align-items:center;height:40px;padding:0 22px;background:#C41018;color:#fff;font-size:12px;font-weight:600;text-transform:uppercase;letter-spacing:0.1em;border:0;border-radius:4px;cursor:pointer;transition:opacity 0.15s;"
                    onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                <?= e($cookieAcceptAll) ?>
            </button>
        </div>
    </div>
</div>

<script>
function acceptCookies(level) {
    var maxAge = 365 * 24 * 60 * 60;
    var secure = (location.protocol === 'https:') ? '; Secure' : '';
    document.cookie = 'cookies_accepted=' + level + '; path=/; max-age=' + maxAge + '; SameSite=Lax' + secure;

    // Banner schliessen
    var banner = document.getElementById('cookie-banner');
    if (banner) {
        banner.style.transition = 'opacity 0.3s, transform 0.3s';
        banner.style.opacity = '0';
        banner.style.transform = 'translateY(20px)';
        setTimeout(function() { banner.remove(); }, 300);
    }

    // Bei „Alle akzeptieren" → Analytics nachladen
    if (level === 'all' && typeof window.loadAnalytics === 'function') {
        window.loadAnalytics();
    }
}

// Cookie-Einstellungen zuruecksetzen (vom Footer-Link aufrufbar)
window.resetCookieConsent = function() {
    document.cookie = 'cookies_accepted=; path=/; expires=Thu, 01 Jan 1970 00:00:00 GMT';
    location.reload();
};
</script>
