<?php
/**
 * Fragen und Antworten
 *
 * Aufklappbar ueber <details>/<summary> — das braucht kein JavaScript, ist
 * mit der Tastatur bedienbar und wird von Screenreadern korrekt angesagt.
 *
 * Gibt zusaetzlich FAQPage-Auszeichnung aus. Google darf solche Fragen direkt
 * im Suchergebnis aufklappen. JSON-LD im Body ist dafuer ausdruecklich
 * zulaessig — die Auszeichnung muss nicht in den <head>.
 *
 * Wichtig: Nur ausgezeichnet, was auch sichtbar auf der Seite steht. Fragen
 * mit offenen Platzhaltern bleiben deshalb aus der Auszeichnung draussen.
 */

$heading  = $content['heading'] ?? 'Fragen und Antworten';
$subtitle = $content['subtitle'] ?? '';
$items    = $content['items'] ?? [];

if (!$items) return;

$faqId = 'faq-' . substr(md5(json_encode($items)), 0, 8);

// Fuer die Auszeichnung: nur vollstaendig beantwortete Fragen
$schemaItems = [];
foreach ($items as $item) {
    $q = trim((string) ($item['question'] ?? ''));
    $a = trim(strip_tags((string) ($item['answer'] ?? '')));
    if ($q === '' || $a === '') continue;
    if (str_contains($a, 'ANGABE FEHLT')) continue;
    $schemaItems[] = ['q' => $q, 'a' => $a];
}
?>

<section class="section bg-gray-50">
    <div class="section-container">
        <div class="max-w-4xl">
            <?php if ($heading): ?>
                <<?= $hTag = headingTag() ?> class="section-heading mb-4"><?= e($heading) ?></<?= $hTag ?>>
            <?php endif; ?>

            <?php if ($subtitle): ?>
                <p class="section-subtitle text-gray-500 mb-8"><?= e($subtitle) ?></p>
            <?php endif; ?>

            <div class="faq-list" id="<?= e($faqId) ?>">
                <?php foreach ($items as $item): ?>
                    <?php
                    $question = trim((string) ($item['question'] ?? ''));
                    $answer   = (string) ($item['answer'] ?? '');
                    if ($question === '') continue;
                    ?>
                    <details class="faq-item">
                        <summary class="faq-question">
                            <span><?= e($question) ?></span>
                            <svg class="faq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </summary>
                        <div class="faq-answer"><?= renderRichtext($answer) ?></div>
                    </details>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<?php if ($schemaItems): ?>
<script type="application/ld+json">
<?= json_encode([
    '@context'   => 'https://schema.org',
    '@type'      => 'FAQPage',
    'mainEntity' => array_map(fn($i) => [
        '@type'          => 'Question',
        'name'           => $i['q'],
        'acceptedAnswer' => ['@type' => 'Answer', 'text' => $i['a']],
    ], $schemaItems),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>
</script>
<?php endif; ?>

<style>
    .faq-list { border-top: 1px solid #E5E7EB; }
    .faq-item { border-bottom: 1px solid #E5E7EB; }

    .faq-question {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        padding: 20px 0;
        cursor: pointer;
        list-style: none;
        font-size: calc(var(--fs-card-title, 24px) * 0.72);
        font-weight: 600;
        line-height: 1.4;
        color: #111;
        transition: color 0.15s;
    }
    .faq-question::-webkit-details-marker { display: none; }
    .faq-question:hover { color: #C41018; }

    /* Sichtbarer Fokusrahmen fuer Tastaturbedienung */
    .faq-question:focus-visible {
        outline: 2px solid #C41018;
        outline-offset: 3px;
    }

    .faq-icon {
        width: 20px;
        height: 20px;
        flex-shrink: 0;
        color: #C41018;
        transition: transform 0.2s ease;
    }
    .faq-item[open] .faq-icon { transform: rotate(180deg); }

    .faq-answer {
        padding: 0 0 22px 0;
        max-width: 52rem;
        color: #4B5563;
        font-size: var(--fs-body, 16px);
        line-height: 1.75;
    }
    .faq-answer p { margin: 0 0 0.9em 0; font-size: inherit !important; line-height: inherit !important; }
    .faq-answer p:last-child { margin-bottom: 0; }
    .faq-answer a { color: #C41018; text-decoration: underline; text-underline-offset: 3px; }

    @media (max-width: 640px) {
        .faq-question { padding: 16px 0; gap: 12px; }
        .faq-answer { padding-bottom: 18px; }
    }
</style>
