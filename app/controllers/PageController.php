<?php
/**
 * Handles public-facing page rendering.
 */
class PageController
{
    public function home(): void
    {
        $page = getPage('startseite');
        enforcePageActive($page);
        $blocks = getContentBlocks($page['id'] ?? 1);
        $blockMap = [];
        foreach ($blocks as $b) {
            $blockMap[$b['section_key']] = $b;
        }

        $pageTitle = 'SUI Innova GmbH – Vorfabrikation & Montage';
        $metaDescription = $page['meta_description'] ?? '';
        $navPages = getNavPages();
        $currentSlug = 'startseite';

        require APP_PATH . '/views/layout/header.php';
        require APP_PATH . '/views/pages/home.php';
        require APP_PATH . '/views/layout/footer.php';
    }

    public function kompetenzen(): void
    {
        $page = getPage('kompetenzen');
        enforcePageActive($page);
        $blocks = getContentBlocks($page['id'] ?? 2);
        $blockMap = [];
        foreach ($blocks as $b) {
            $blockMap[$b['section_key']] = $b;
        }

        $pageTitle = 'Kompetenzen – SUI Innova GmbH';
        $metaDescription = $page['meta_description'] ?? '';
        $navPages = getNavPages();
        $currentSlug = 'kompetenzen';

        require APP_PATH . '/views/layout/header.php';
        require APP_PATH . '/views/pages/kompetenzen.php';
        require APP_PATH . '/views/layout/footer.php';
    }

    public function referenzen(): void
    {
        $page = getPage('referenzen');
        enforcePageActive($page);
        $db = Database::getInstance();
        $stmt = $db->query('SELECT * FROM references_projects WHERE is_active = 1 ORDER BY sort_order');
        $projects = $stmt->fetchAll();

        $categories = array_unique(array_filter(array_column($projects, 'category')));

        $pageTitle = 'Referenzen – SUI Innova GmbH';
        $metaDescription = $page['meta_description'] ?? '';
        $navPages = getNavPages();
        $currentSlug = 'referenzen';

        require APP_PATH . '/views/layout/header.php';
        require APP_PATH . '/views/pages/referenzen.php';
        require APP_PATH . '/views/layout/footer.php';
    }

    public function unternehmen(): void
    {
        $page = getPage('unternehmen');
        enforcePageActive($page);
        $blocks = getContentBlocks($page['id'] ?? 4);
        $blockMap = [];
        foreach ($blocks as $b) {
            $blockMap[$b['section_key']] = $b;
        }

        $pageTitle = 'Unternehmen – SUI Innova GmbH';
        $metaDescription = $page['meta_description'] ?? '';
        $navPages = getNavPages();
        $currentSlug = 'unternehmen';

        require APP_PATH . '/views/layout/header.php';
        require APP_PATH . '/views/pages/unternehmen.php';
        require APP_PATH . '/views/layout/footer.php';
    }

    public function kontakt(): void
    {
        $page = getPage('kontakt');
        enforcePageActive($page);
        $blocks = getContentBlocks($page['id'] ?? 5);
        $blockMap = [];
        foreach ($blocks as $b) {
            $blockMap[$b['section_key']] = $b;
        }

        $pageTitle = 'Kontakt – SUI Innova GmbH';
        $metaDescription = $page['meta_description'] ?? '';
        $navPages = getNavPages();
        $currentSlug = 'kontakt';
        $formSent = false;
        $formError = '';

        require APP_PATH . '/views/layout/header.php';
        require APP_PATH . '/views/pages/kontakt.php';
        require APP_PATH . '/views/layout/footer.php';
    }

    public function kontaktSubmit(): void
    {
        // CSRF check
        if (!Auth::verifyCsrfToken($_POST[CSRF_TOKEN_NAME] ?? '')) {
            redirect(pageUrl('kontakt'));
        }

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $company = trim($_POST['company'] ?? '');
        $subject = trim($_POST['subject'] ?? '');
        $message = trim($_POST['message'] ?? '');

        // Honeypot
        if (!empty($_POST['website'])) {
            redirect(pageUrl('kontakt'));
        }

        // Validation
        if (empty($name) || empty($email) || empty($message)) {
            setFlash('error', 'Bitte füllen Sie alle Pflichtfelder aus.');
            redirect(pageUrl('kontakt'));
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            setFlash('error', 'Bitte geben Sie eine gültige E-Mail-Adresse ein.');
            redirect(pageUrl('kontakt'));
        }

        try {
            $db = Database::getInstance();
            $stmt = $db->prepare(
                'INSERT INTO contact_messages (name, email, phone, company, subject, message) VALUES (?, ?, ?, ?, ?, ?)'
            );
            $stmt->execute([$name, $email, $phone, $company, $subject, $message]);

            // Send email notification
            $to = setting('contact_email', 'info@suiinnova.ch');
            $mailSubject = 'Neue Kontaktanfrage: ' . $subject;
            $mailBody = "Name: {$name}\nE-Mail: {$email}\nTelefon: {$phone}\nFirma: {$company}\n\n{$message}";
            $headers = "From: noreply@suiinnova.ch\r\nReply-To: {$email}\r\n";
            @mail($to, $mailSubject, $mailBody, $headers);

            setFlash('success', 'Vielen Dank für Ihre Nachricht. Wir melden uns in Kürze bei Ihnen.');
        } catch (Exception $e) {
            setFlash('error', 'Es ist ein Fehler aufgetreten. Bitte versuchen Sie es erneut.');
        }

        redirect(pageUrl('kontakt'));
    }
}
