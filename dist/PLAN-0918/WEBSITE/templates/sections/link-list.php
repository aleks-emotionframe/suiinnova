<?php
/**
 * Liste interner Links
 *
 * Bewusst keine feste Liste im Text, sondern Slugs mit Linktext. Vor der
 * Ausgabe wird geprueft, welche Zielseiten online sind. Eine Seite, die
 * noch deaktiviert ist, faellt aus der Liste. Ist keine mehr uebrig,
 * verschwindet der ganze Block.
 *
 * Damit koennen interne Links zusammen mit den Seiten eingespielt werden,
 * auf die sie zeigen, ohne dass in der Zwischenzeit ein Link ins Leere
 * fuehrt.
 *
 * Der Linktext beschreibt immer die ZIELSEITE, nicht die Seite, auf der er
 * steht. Google liest ihn als Beschreibung des Ziels.
 */

$heading = trim((string) ($content['heading'] ?? ''));
$items   = $content['items'] ?? [];

if (!is_array($items) || !$items) return;

// Nur Ziele, die es gibt und die online sind
$gewuenscht = [];
foreach ($items as $i) {
    $slug = trim((string) ($i['slug'] ?? ''));
    $text = trim((string) ($i['text'] ?? ''));
    if ($slug === '' || $text === '') continue;
    $gewuenscht[$slug] = $text;
}
if (!$gewuenscht) return;

$sichtbar = getLivePageSlugs(array_keys($gewuenscht));
if (!$sichtbar) return;
?>

<section class="section bg-white">
    <div class="section-container">
        <?php if ($heading): ?>
            <<?= $hTag = headingTag() ?> class="link-list-heading"><?= e($heading) ?></<?= $hTag ?>>
        <?php endif; ?>

        <ul class="link-list">
            <?php foreach ($sichtbar as $slug): ?>
                <li class="link-list-item">
                    <a href="<?= e(url($slug)) ?>"><?= e($gewuenscht[$slug]) ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>

<style>
    /* Kleiner gesetzt als eine Abschnittsueberschrift: der Block ist ein
       Wegweiser am Seitenende, keine eigene Station. */
    .link-list-heading {
        color: #111;
        font-size: calc(var(--fs-card-title, 24px) * 0.82) !important;
        font-weight: 700;
        line-height: 1.25;
        letter-spacing: 0.01em;
        margin: 0 0 22px 0;
    }

    .link-list {
        list-style: none;
        margin: 0;
        padding: 0;
        display: grid;
        grid-template-columns: 1fr;
        gap: 0;
        max-width: 72rem;
        border-top: 1px solid #E5E7EB;
    }
    @media (min-width: 768px) {
        .link-list { grid-template-columns: repeat(2, minmax(0, 1fr)); column-gap: 56px; }
    }

    .link-list-item {
        border-bottom: 1px solid #E5E7EB;
    }

    .link-list-item a {
        display: block;
        position: relative;
        padding: 15px 28px 15px 0;
        color: #111;
        font-size: var(--fs-body, 16px);
        line-height: 1.45;
        font-weight: 500;
        text-decoration: none;
        transition: color 0.2s ease;
    }

    /* Winkel statt Pfeilgrafik: zwei Linien, kein zusaetzlicher Request. */
    .link-list-item a::after {
        content: "";
        position: absolute;
        right: 6px;
        top: 50%;
        width: 7px;
        height: 7px;
        margin-top: -4px;
        border-right: 2px solid #C41018;
        border-top: 2px solid #C41018;
        transform: rotate(45deg);
        transition: right 0.2s ease;
    }

    .link-list-item a:hover { color: #C41018; }
    .link-list-item a:hover::after { right: 0; }
</style>
