<?php
/**
 * Cookie-Banner (Schweizer Stil — minimal).
 *
 * Wird nur angezeigt wenn:
 * 1. Setting cookie_visible aktiv ist (default: 1)
 * 2. Der Besucher noch nicht akzeptiert hat (Cookie cookies_accepted=1)
 *
 * Texte und Sichtbarkeit sind im CMS unter Einstellungen → Cookie-Banner editierbar.
 */

$cookieVisible = setting('cookie_visible', '1') === '1';
$cookieAccepted = isset($_COOKIE['cookies_accepted']) && $_COOKIE['cookies_accepted'] === '1';
if (!$cookieVisible || $cookieAccepted) return;

$cookieText      = setting('cookie_text', 'Diese Website verwendet ausschliesslich technisch notwendige Cookies. Es findet kein Tracking statt.');
$cookieBtnText   = setting('cookie_button_text', 'Verstanden');
$cookieLinkText  = setting('cookie_link_text', 'Mehr erfahren');
?>

<div id="cookie-banner" role="dialog" aria-label="Cookie-Hinweis"
     style="position:fixed;left:16px;right:16px;bottom:16px;z-index:90;max-width:880px;margin:0 auto;background:#111827;color:#fff;border-radius:6px;box-shadow:0 20px 50px -10px rgba(0,0,0,0.4);overflow:hidden;">
    <!-- Roter Akzent-Strich oben (Brand-Konsistenz) -->
    <div style="height:2px;background:#C41018;"></div>

    <div style="padding:18px 22px;display:flex;align-items:center;gap:18px;flex-wrap:wrap;">
        <!-- Cookie-Icon -->
        <svg style="width:22px;height:22px;flex-shrink:0;color:#C41018;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12c0 1.5-.4 2.9-1.1 4.1m-9.4-13C5.5 3.9 2 7.5 2 12a10 10 0 0010 10c4.4 0 8-3.5 9-7.9-3.5-.4-6-3.4-5.7-7-3.5-.5-6.4-3.5-6.7-7m6.5 5.5h.01M9 16h.01M16 14h.01"/>
        </svg>

        <!-- Text + Link -->
        <div style="flex:1;min-width:240px;font-size:14px;line-height:1.55;color:rgba(255,255,255,0.85);">
            <?= e($cookieText) ?>
            <a href="<?= url('datenschutz') ?>" style="color:#fff;text-decoration:underline;text-underline-offset:3px;margin-left:6px;font-weight:500;">
                <?= e($cookieLinkText) ?> →
            </a>
        </div>

        <!-- Akzeptieren-Button -->
        <button type="button" onclick="acceptCookies()"
                style="flex-shrink:0;display:inline-flex;align-items:center;height:40px;padding:0 22px;background:#C41018;color:#fff;font-size:12px;font-weight:600;text-transform:uppercase;letter-spacing:0.1em;text-decoration:none;border:0;border-radius:4px;cursor:pointer;transition:opacity 0.15s;"
                onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
            <?= e($cookieBtnText) ?>
        </button>
    </div>
</div>

<script>
function acceptCookies() {
    var maxAge = 365 * 24 * 60 * 60;
    var secure = (location.protocol === 'https:') ? '; Secure' : '';
    document.cookie = 'cookies_accepted=1; path=/; max-age=' + maxAge + '; SameSite=Lax' + secure;
    var banner = document.getElementById('cookie-banner');
    if (banner) {
        banner.style.transition = 'opacity 0.3s, transform 0.3s';
        banner.style.opacity = '0';
        banner.style.transform = 'translateY(20px)';
        setTimeout(function() { banner.remove(); }, 300);
    }
}
</script>
