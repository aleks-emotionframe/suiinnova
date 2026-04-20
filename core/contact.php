<?php
/**
 * Kontaktformular — Captcha & Handler
 *
 * Mathe-Captcha: zufaellige Addition, DSGVO-konform, kein externer Service.
 */

/**
 * Neues Captcha generieren und in Session speichern.
 * Rueckgabe: ['a' => 3, 'b' => 5] — im Template als "Was ist 3 + 5?" angezeigt.
 */
function generateCaptcha(): array
{
    $a = random_int(1, 9);
    $b = random_int(1, 9);
    $_SESSION['captcha_answer'] = $a + $b;
    $_SESSION['captcha_created'] = time();
    return ['a' => $a, 'b' => $b];
}

/**
 * Captcha validieren und danach loeschen (one-time use).
 */
function verifyCaptcha(string $answer): bool
{
    $expected = $_SESSION['captcha_answer'] ?? null;
    $created  = $_SESSION['captcha_created'] ?? 0;
    unset($_SESSION['captcha_answer'], $_SESSION['captcha_created']);

    if ($expected === null) return false;
    if (time() - $created > 1800) return false; // 30 Minuten Lebensdauer
    return (int)$answer === (int)$expected;
}

/**
 * Kontaktformular verarbeiten (POST /kontakt/senden).
 */
function handleContactSubmit(): void
{
    global $db;

    // CSRF
    if (!validateCsrf()) {
        setFlash('error', 'Sicherheitstoken abgelaufen. Bitte versuchen Sie es erneut.');
        redirectBack();
    }

    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $phone   = trim($_POST['phone'] ?? '');
    $company = trim($_POST['company'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Eingaben in Session speichern (falls wir mit Fehler zurueck redirecten)
    $_SESSION['form_data'] = [
        'name'    => $name,
        'email'   => $email,
        'phone'   => $phone,
        'company' => $company,
        'message' => $message,
    ];

    // Honeypot
    if (!empty($_POST['website_url'])) {
        // Still bleiben, keine Warnung — Bot denkt es hat geklappt
        $_SESSION['form_data'] = [];
        setFlash('success', 'Vielen Dank für Ihre Nachricht.');
        redirectBack();
    }

    // Zeit-Check: weniger als 2 Sekunden = Bot
    $formLoadedAt = (int)($_POST['form_loaded_at'] ?? 0);
    if ($formLoadedAt > 0 && (time() - $formLoadedAt) < 2) {
        $_SESSION['form_data'] = [];
        setFlash('success', 'Vielen Dank für Ihre Nachricht.');
        redirectBack();
    }

    // Pflichtfelder
    if ($name === '' || $email === '' || $message === '') {
        setFlash('error', 'Bitte füllen Sie alle Pflichtfelder aus.');
        redirectBack();
    }

    // E-Mail-Format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        setFlash('error', 'Bitte geben Sie eine gültige E-Mail-Adresse ein.');
        redirectBack();
    }

    // Captcha
    $captchaAnswer = trim($_POST['captcha_answer'] ?? '');
    if (!verifyCaptcha($captchaAnswer)) {
        setFlash('error', 'Die Rechen-Aufgabe wurde nicht korrekt beantwortet. Bitte versuchen Sie es erneut.');
        redirectBack();
    }

    // Laengenlimits gegen Spam
    if (mb_strlen($message) > 5000 || mb_strlen($name) > 200 || mb_strlen($company) > 200) {
        setFlash('error', 'Eingaben sind zu lang.');
        redirectBack();
    }

    // Link-Bomb-Schutz: viele URLs im Nachrichtenfeld = Spam
    if (preg_match_all('#https?://#i', $message, $m) && count($m[0]) > 3) {
        setFlash('error', 'Zu viele Links in der Nachricht.');
        redirectBack();
    }

    // In DB speichern
    try {
        $db->insert('contacts', [
            'name'       => $name,
            'email'      => $email,
            'phone'      => $phone,
            'company'    => $company,
            'message'    => $message,
            'is_read'    => 0,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    } catch (Exception $e) {
        setFlash('error', 'Ein technischer Fehler ist aufgetreten. Bitte versuchen Sie es später erneut.');
        redirectBack();
    }

    // E-Mail an Empfaenger
    $receiver = setting('contact_form_receiver', setting('contact_email', CONTACT_EMAIL));
    if ($receiver && filter_var($receiver, FILTER_VALIDATE_EMAIL)) {
        $subject = 'Neue Kontaktanfrage: ' . ($company ?: $name);
        $body    = "Name: {$name}\n"
                 . "E-Mail: {$email}\n"
                 . "Telefon: {$phone}\n"
                 . "Firma: {$company}\n\n"
                 . "Nachricht:\n{$message}\n";
        $headers = "From: noreply@sui-innova.ch\r\n"
                 . "Reply-To: {$email}\r\n"
                 . "Content-Type: text/plain; charset=UTF-8\r\n";
        @mail($receiver, $subject, $body, $headers);
    }

    // Erfolg — Formular-Daten loeschen, Erfolgs-Flash setzen
    $_SESSION['form_data'] = [];
    setFlash('success', 'Vielen Dank für Ihre Nachricht. Wir melden uns in Kürze bei Ihnen.');
    redirectBack();
}

/**
 * Zurueck zur Herkunftsseite (aus POST-Feld) oder zur Startseite.
 */
function redirectBack(): void
{
    $source = $_POST['page_source'] ?? '';
    $source = preg_replace('/[^a-z0-9_\-]/i', '', (string)$source);
    $target = $source && $source !== 'startseite' ? url($source) . '#kontakt' : url() . '#kontakt';
    header('Location: ' . $target, true, 302);
    exit;
}
