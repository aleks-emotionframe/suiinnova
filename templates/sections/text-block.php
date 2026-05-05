<?php
/**
 * Textblock Section
 *
 * Body unterstuetzt HTML (h2, h3, p, a, ul/ol, strong, em).
 * Rendering ueber renderRichtext() — Inline-Styles sorgen fuer saubere
 * Typografie auch ohne Tailwind-Prose-Plugin im CSS-Bundle.
 */
$heading   = $content['heading'] ?? '';
$body      = $content['body'] ?? '';
$alignment = $content['alignment'] ?? 'left';
$isCenter  = ($alignment === 'center');
?>

<section class="section bg-white">
    <div class="section-container <?= $isCenter ? 'text-center' : '' ?>">
        <div class="<?= $isCenter ? 'max-w-3xl mx-auto' : 'max-w-none' ?> fade-in">
            <?php if ($heading): ?>
                <h2 class="section-heading mb-6"><?= e($heading) ?></h2>
            <?php endif; ?>
            <?php if ($body): ?>
                <div class="text-block-body">
                    <?= renderRichtext($body) ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<style>
    /* Saubere Typografie fuer Text-Block-Inhalte (Impressum, Datenschutz, etc.) */
    .text-block-body {
        color: #374151;
        font-size: var(--fs-body, 16px);
        line-height: 1.75;
        max-width: 56rem;
    }
    .text-block-body h2 {
        color: #111;
        font-size: calc(var(--fs-card-title, 24px) * 0.95);
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        line-height: 1.25;
        margin: 2.25em 0 0.75em 0;
        padding-top: 1em;
        border-top: 1px solid #E5E7EB;
    }
    .text-block-body h2:first-child {
        margin-top: 0;
        padding-top: 0;
        border-top: 0;
    }
    .text-block-body h3 {
        color: #111;
        font-size: calc(var(--fs-card-title, 24px) * 0.8);
        font-weight: 600;
        margin: 1.5em 0 0.5em 0;
    }
    .text-block-body p {
        margin: 0 0 1em 0;
        font-size: inherit !important;
        line-height: inherit !important;
    }
    .text-block-body p:last-child { margin-bottom: 0; }
    .text-block-body a {
        color: #C41018;
        text-decoration: underline;
        text-underline-offset: 3px;
        transition: opacity 0.15s;
    }
    .text-block-body a:hover { opacity: 0.7; }
    .text-block-body strong, .text-block-body b { font-weight: 600; color: #111; }
    .text-block-body ul, .text-block-body ol {
        margin: 0.5em 0 1em 1.5em;
        padding: 0;
    }
    .text-block-body li { margin-bottom: 0.4em; }
    .text-block-body br { display: block; content: ''; margin-top: 0.25em; }
</style>

