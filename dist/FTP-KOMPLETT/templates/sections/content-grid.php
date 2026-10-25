<?php
/**
 * Inhaltsraster
 *
 * Zeigt mehrere Titel-Text-Paare nebeneinander statt untereinander.
 *
 * Hintergrund: Die Keyword-Seiten bestehen aus fuenf bis sechs Abschnitten,
 * die als ein einziger Textblock untereinander standen — eine Textwand. Der
 * Suchbegriff steht zwar drin, aber ein Bauleiter liest das nicht. Als Raster
 * sieht er auf einen Blick, welche Themen die Seite abdeckt, und liest den
 * Abschnitt, der ihn betrifft.
 *
 * Bewusst ohne Bilder: den neuen Seiten ist kein Medium zugeordnet, und eine
 * Sektion, die ohne Bild zusammenbricht, waere hier nutzlos.
 *
 * Bewusst ohne Nummerierung: die Abschnitte sind Themen, keine Reihenfolge.
 * Eine 01/02/03-Leiste wuerde einen Ablauf behaupten, den es nicht gibt.
 */

$heading  = $content['heading'] ?? '';
$lead     = $content['lead'] ?? '';
$items    = $content['items'] ?? [];
$style    = $content['style'] ?? 'light';

$bgClass = $style === 'gray' ? 'bg-gray-50' : 'bg-white';

if (!$heading && !$lead && !$items) return;
?>

<section class="section <?= $bgClass ?>">
    <div class="section-container">

        <?php if ($heading): ?>
            <<?= $hTag = headingTag() ?> class="section-heading"><?= e($heading) ?></<?= $hTag ?>>
        <?php endif; ?>

        <?php if ($lead): ?>
            <div class="content-grid-lead">
                <?= renderRichtext($lead) ?>
            </div>
        <?php endif; ?>

        <?php if ($items): ?>
            <div class="content-grid">
                <?php foreach ($items as $item): ?>
                    <?php
                    $title = trim((string) ($item['title'] ?? ''));
                    $text  = (string) ($item['text'] ?? '');
                    if ($title === '' && trim(strip_tags($text)) === '') continue;
                    ?>
                    <article class="content-grid-item">
                        <?php if ($title): ?>
                            <h3 class="content-grid-title"><?= e($title) ?></h3>
                        <?php endif; ?>
                        <?php if ($text): ?>
                            <div class="content-grid-text"><?= renderRichtext($text) ?></div>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</section>

<style>
    /* Einleitung: groesser als Fliesstext, aber schmal genug zum Lesen.
       Rund 65 Zeichen pro Zeile, darueber wandert das Auge beim Zeilenwechsel
       zu weit und verliert die Zeile. */
    .content-grid-lead {
        max-width: 58rem;
        margin-top: 22px;
        color: #4B5563;
        font-size: calc(var(--fs-subtitle, 18px) * 1.05);
        line-height: 1.75;
    }
    .content-grid-lead p {
        margin: 0 0 1em 0;
        font-size: inherit !important;
        line-height: inherit !important;
    }
    .content-grid-lead p:last-child { margin-bottom: 0; }

    /* Links in der Einleitung.
       Fehlte diese Regel, waren die Links im Einleitungstext zwar im
       Quelltext vorhanden, sahen aber aus wie normaler Text: das
       CSS-Grundgeruest nimmt Links Farbe und Unterstreichung weg. */
    .content-grid-lead a,
    .content-grid-text a {
        color: #C41018;
        text-decoration: underline;
        text-underline-offset: 3px;
        text-decoration-thickness: 1px;
    }
    .content-grid-lead a:hover,
    .content-grid-text a:hover { opacity: 0.75; }

    /* Das Raster.
       Eine Spalte auf dem Telefon, zwei ab Tablet, drei ab grossem Monitor.
       Die dritte Spalte statt einer Breitenbegrenzung: mit Deckel bei 72rem
       endete das Raster auf einem breiten Bildschirm bei zwei Dritteln,
       waehrend Ueberschrift, Fragen und Abschluss durchliefen. Drei
       verschiedene rechte Kanten auf einer Seite. Jetzt laeuft alles gleich
       weit, und die Zeilen bleiben trotzdem lesbar kurz, weil eine Spalte
       dazukommt statt breiter zu werden. */
    .content-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 38px 56px;
        margin-top: 52px;
    }
    @media (min-width: 768px) {
        .content-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }
    @media (min-width: 1280px) {
        .content-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 44px 64px; }
    }

    /* Kein Kasten, sondern eine Linie oben mit rotem Anschnitt.
       Karten mit Rahmen und Schatten waeren hier vier Signale fuer
       "eigenes Objekt", wo eine Linie reicht. */
    .content-grid-item {
        position: relative;
        padding-top: 20px;
        border-top: 1px solid #E5E7EB;
    }
    .content-grid-item::before {
        content: "";
        position: absolute;
        top: -1px;
        left: 0;
        width: 40px;
        height: 2px;
        background: #C41018;
    }

    .content-grid-title {
        color: #111;
        font-size: calc(var(--fs-card-title, 24px) * 0.72) !important;
        font-weight: 700;
        line-height: 1.3;
        letter-spacing: 0.01em;
        margin: 0 0 12px 0;
        text-wrap: balance;
    }

    .content-grid-text {
        color: #4B5563;
        font-size: var(--fs-body, 16px);
        line-height: 1.75;
    }
    .content-grid-text p {
        margin: 0 0 0.9em 0;
        font-size: inherit !important;
        line-height: inherit !important;
    }
    .content-grid-text p:last-child { margin-bottom: 0; }

    @media (max-width: 767px) {
        .content-grid { gap: 30px; margin-top: 38px; }
        .content-grid-lead { margin-top: 16px; }
    }
</style>
