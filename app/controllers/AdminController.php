<?php
/**
 * Admin panel controller — handles all CMS operations.
 */
class AdminController
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    // ── Authentication ──

    public function loginForm(): void
    {
        if (Auth::check()) {
            redirect(SITE_URL . ADMIN_PATH);
        }
        $error = '';
        require APP_PATH . '/views/admin/login.php';
    }

    public function loginSubmit(): void
    {
        if (!Auth::verifyCsrfToken($_POST[CSRF_TOKEN_NAME] ?? '')) {
            redirect(SITE_URL . ADMIN_PATH . '/login');
        }

        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if (Auth::login($username, $password)) {
            setFlash('success', 'Willkommen zurück!');
            redirect(SITE_URL . ADMIN_PATH);
        }

        $error = 'Ungültige Anmeldedaten.';
        require APP_PATH . '/views/admin/login.php';
    }

    public function logout(): void
    {
        Auth::logout();
        redirect(SITE_URL . ADMIN_PATH . '/login');
    }

    // ── Dashboard ──

    public function dashboard(): void
    {
        Auth::requireLogin();

        $pageCount = $this->db->query('SELECT COUNT(*) FROM pages')->fetchColumn();
        $refCount = $this->db->query('SELECT COUNT(*) FROM references_projects')->fetchColumn();
        $msgCount = $this->db->query('SELECT COUNT(*) FROM contact_messages WHERE is_read = 0')->fetchColumn();
        $totalMsgs = $this->db->query('SELECT COUNT(*) FROM contact_messages')->fetchColumn();

        $recentMessages = $this->db->query(
            'SELECT * FROM contact_messages ORDER BY created_at DESC LIMIT 5'
        )->fetchAll();

        require APP_PATH . '/views/admin/dashboard.php';
    }

    // ── Pages Management ──

    public function pagesList(): void
    {
        Auth::requireLogin();
        $pages = $this->db->query('SELECT * FROM pages ORDER BY sort_order')->fetchAll();
        require APP_PATH . '/views/admin/pages_list.php';
    }

    public function pageEdit(string $id): void
    {
        Auth::requireLogin();
        $page = $this->db->prepare('SELECT * FROM pages WHERE id = ?');
        $page->execute([$id]);
        $page = $page->fetch();

        if (!$page) {
            setFlash('error', 'Seite nicht gefunden.');
            redirect(SITE_URL . ADMIN_PATH . '/pages');
        }

        $contentBlocks = $this->db->prepare(
            'SELECT * FROM content_blocks WHERE page_id = ? ORDER BY sort_order'
        );
        $contentBlocks->execute([$id]);
        $contentBlocks = $contentBlocks->fetchAll();

        require APP_PATH . '/views/admin/page_edit.php';
    }

    public function pageUpdate(string $id): void
    {
        Auth::requireLogin();
        if (!Auth::verifyCsrfToken($_POST[CSRF_TOKEN_NAME] ?? '')) {
            redirect(SITE_URL . ADMIN_PATH . '/pages');
        }

        $stmt = $this->db->prepare(
            'UPDATE pages SET title = ?, meta_description = ?, meta_keywords = ?, is_active = ?, is_in_nav = ? WHERE id = ?'
        );
        $stmt->execute([
            trim($_POST['title'] ?? ''),
            trim($_POST['meta_description'] ?? ''),
            trim($_POST['meta_keywords'] ?? ''),
            isset($_POST['is_active']) ? 1 : 0,
            isset($_POST['is_in_nav']) ? 1 : 0,
            $id,
        ]);

        setFlash('success', 'Seite aktualisiert.');
        redirect(SITE_URL . ADMIN_PATH . '/pages/' . $id);
    }

    public function pageCreate(): void
    {
        Auth::requireLogin();
        $page = null;
        $contentBlocks = [];
        require APP_PATH . '/views/admin/page_edit.php';
    }

    public function pageStore(): void
    {
        Auth::requireLogin();
        if (!Auth::verifyCsrfToken($_POST[CSRF_TOKEN_NAME] ?? '')) {
            redirect(SITE_URL . ADMIN_PATH . '/pages');
        }

        $title = trim($_POST['title'] ?? '');
        $slug = slugify($title);

        $stmt = $this->db->prepare(
            'INSERT INTO pages (slug, title, meta_description, meta_keywords, is_active, is_in_nav, sort_order) VALUES (?, ?, ?, ?, ?, ?, ?)'
        );
        $maxOrder = $this->db->query('SELECT COALESCE(MAX(sort_order), 0) FROM pages')->fetchColumn();
        $stmt->execute([
            $slug,
            $title,
            trim($_POST['meta_description'] ?? ''),
            trim($_POST['meta_keywords'] ?? ''),
            isset($_POST['is_active']) ? 1 : 0,
            isset($_POST['is_in_nav']) ? 1 : 0,
            $maxOrder + 1,
        ]);

        $newId = $this->db->lastInsertId();
        setFlash('success', 'Seite erstellt.');
        redirect(SITE_URL . ADMIN_PATH . '/pages/' . $newId);
    }

    public function pageDelete(string $id): void
    {
        Auth::requireLogin();
        if (!Auth::verifyCsrfToken($_POST[CSRF_TOKEN_NAME] ?? '')) {
            redirect(SITE_URL . ADMIN_PATH . '/pages');
        }

        // Prevent deleting default pages
        $page = $this->db->prepare('SELECT slug FROM pages WHERE id = ?');
        $page->execute([$id]);
        $page = $page->fetch();

        $protected = ['startseite', 'kompetenzen', 'referenzen', 'unternehmen', 'kontakt'];
        if ($page && in_array($page['slug'], $protected)) {
            setFlash('error', 'Standard-Seiten können nicht gelöscht werden.');
            redirect(SITE_URL . ADMIN_PATH . '/pages');
        }

        $stmt = $this->db->prepare('DELETE FROM pages WHERE id = ?');
        $stmt->execute([$id]);

        setFlash('success', 'Seite gelöscht.');
        redirect(SITE_URL . ADMIN_PATH . '/pages');
    }

    // ── Content Blocks ──

    public function contentEdit(string $id): void
    {
        Auth::requireLogin();
        $block = $this->db->prepare('SELECT cb.*, p.title as page_title FROM content_blocks cb JOIN pages p ON p.id = cb.page_id WHERE cb.id = ?');
        $block->execute([$id]);
        $block = $block->fetch();

        if (!$block) {
            setFlash('error', 'Inhalt nicht gefunden.');
            redirect(SITE_URL . ADMIN_PATH . '/pages');
        }

        require APP_PATH . '/views/admin/content_edit.php';
    }

    public function contentUpdate(string $id): void
    {
        Auth::requireLogin();
        if (!Auth::verifyCsrfToken($_POST[CSRF_TOKEN_NAME] ?? '')) {
            redirect(SITE_URL . ADMIN_PATH . '/pages');
        }

        // Handle image upload
        $imagePath = $_POST['existing_image'] ?? '';
        if (!empty($_FILES['image']['name'])) {
            $uploaded = $this->handleUpload($_FILES['image']);
            if ($uploaded) {
                $imagePath = $uploaded;
            }
        }

        $stmt = $this->db->prepare(
            'UPDATE content_blocks SET title = ?, subtitle = ?, content = ?, image_path = ?, link_url = ?, link_text = ?, is_active = ? WHERE id = ?'
        );
        $stmt->execute([
            trim($_POST['title'] ?? ''),
            trim($_POST['subtitle'] ?? ''),
            $_POST['content'] ?? '',
            $imagePath,
            trim($_POST['link_url'] ?? ''),
            trim($_POST['link_text'] ?? ''),
            isset($_POST['is_active']) ? 1 : 0,
            $id,
        ]);

        // Get page_id for redirect
        $block = $this->db->prepare('SELECT page_id FROM content_blocks WHERE id = ?');
        $block->execute([$id]);
        $block = $block->fetch();

        setFlash('success', 'Inhalt aktualisiert.');
        redirect(SITE_URL . ADMIN_PATH . '/pages/' . ($block['page_id'] ?? ''));
    }

    public function contentCreate(string $pageId): void
    {
        Auth::requireLogin();
        $block = null;

        $pageData = $this->db->prepare('SELECT * FROM pages WHERE id = ?');
        $pageData->execute([$pageId]);
        $pageData = $pageData->fetch();

        if (!$pageData) {
            setFlash('error', 'Seite nicht gefunden.');
            redirect(SITE_URL . ADMIN_PATH . '/pages');
        }

        $block = ['page_id' => $pageId, 'page_title' => $pageData['title']];
        require APP_PATH . '/views/admin/content_edit.php';
    }

    public function contentStore(string $pageId): void
    {
        Auth::requireLogin();
        if (!Auth::verifyCsrfToken($_POST[CSRF_TOKEN_NAME] ?? '')) {
            redirect(SITE_URL . ADMIN_PATH . '/pages/' . $pageId);
        }

        $imagePath = '';
        if (!empty($_FILES['image']['name'])) {
            $uploaded = $this->handleUpload($_FILES['image']);
            if ($uploaded) {
                $imagePath = $uploaded;
            }
        }

        $sectionKey = trim($_POST['section_key'] ?? '');
        if (empty($sectionKey)) {
            $sectionKey = 'custom_' . time();
        }

        $maxOrder = $this->db->prepare('SELECT COALESCE(MAX(sort_order), 0) FROM content_blocks WHERE page_id = ?');
        $maxOrder->execute([$pageId]);
        $maxOrder = $maxOrder->fetchColumn();

        $stmt = $this->db->prepare(
            'INSERT INTO content_blocks (page_id, section_key, title, subtitle, content, image_path, link_url, link_text, sort_order, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([
            $pageId,
            $sectionKey,
            trim($_POST['title'] ?? ''),
            trim($_POST['subtitle'] ?? ''),
            $_POST['content'] ?? '',
            $imagePath,
            trim($_POST['link_url'] ?? ''),
            trim($_POST['link_text'] ?? ''),
            $maxOrder + 1,
            isset($_POST['is_active']) ? 1 : 0,
        ]);

        setFlash('success', 'Inhalt erstellt.');
        redirect(SITE_URL . ADMIN_PATH . '/pages/' . $pageId);
    }

    public function contentDelete(string $id): void
    {
        Auth::requireLogin();
        if (!Auth::verifyCsrfToken($_POST[CSRF_TOKEN_NAME] ?? '')) {
            redirect(SITE_URL . ADMIN_PATH . '/pages');
        }

        $block = $this->db->prepare('SELECT page_id FROM content_blocks WHERE id = ?');
        $block->execute([$id]);
        $block = $block->fetch();

        $stmt = $this->db->prepare('DELETE FROM content_blocks WHERE id = ?');
        $stmt->execute([$id]);

        setFlash('success', 'Inhalt gelöscht.');
        redirect(SITE_URL . ADMIN_PATH . '/pages/' . ($block['page_id'] ?? ''));
    }

    // ── References Management ──

    public function referencesList(): void
    {
        Auth::requireLogin();
        $references = $this->db->query('SELECT * FROM references_projects ORDER BY sort_order')->fetchAll();
        require APP_PATH . '/views/admin/references_list.php';
    }

    public function referenceEdit(string $id): void
    {
        Auth::requireLogin();
        $ref = $this->db->prepare('SELECT * FROM references_projects WHERE id = ?');
        $ref->execute([$id]);
        $ref = $ref->fetch();

        if (!$ref) {
            setFlash('error', 'Referenz nicht gefunden.');
            redirect(SITE_URL . ADMIN_PATH . '/references');
        }

        require APP_PATH . '/views/admin/reference_edit.php';
    }

    public function referenceUpdate(string $id): void
    {
        Auth::requireLogin();
        if (!Auth::verifyCsrfToken($_POST[CSRF_TOKEN_NAME] ?? '')) {
            redirect(SITE_URL . ADMIN_PATH . '/references');
        }

        $imagePath = $_POST['existing_image'] ?? '';
        if (!empty($_FILES['image']['name'])) {
            $uploaded = $this->handleUpload($_FILES['image']);
            if ($uploaded) {
                $imagePath = $uploaded;
            }
        }

        $title = trim($_POST['title'] ?? '');
        $stmt = $this->db->prepare(
            'UPDATE references_projects SET title = ?, slug = ?, description = ?, client = ?, location = ?, year = ?, category = ?, image_path = ?, is_featured = ?, is_active = ? WHERE id = ?'
        );
        $stmt->execute([
            $title,
            slugify($title),
            $_POST['description'] ?? '',
            trim($_POST['client'] ?? ''),
            trim($_POST['location'] ?? ''),
            $_POST['year'] ?: null,
            trim($_POST['category'] ?? ''),
            $imagePath,
            isset($_POST['is_featured']) ? 1 : 0,
            isset($_POST['is_active']) ? 1 : 0,
            $id,
        ]);

        setFlash('success', 'Referenz aktualisiert.');
        redirect(SITE_URL . ADMIN_PATH . '/references/' . $id);
    }

    public function referenceCreate(): void
    {
        Auth::requireLogin();
        $ref = null;
        require APP_PATH . '/views/admin/reference_edit.php';
    }

    public function referenceStore(): void
    {
        Auth::requireLogin();
        if (!Auth::verifyCsrfToken($_POST[CSRF_TOKEN_NAME] ?? '')) {
            redirect(SITE_URL . ADMIN_PATH . '/references');
        }

        $imagePath = '';
        if (!empty($_FILES['image']['name'])) {
            $uploaded = $this->handleUpload($_FILES['image']);
            if ($uploaded) {
                $imagePath = $uploaded;
            }
        }

        $title = trim($_POST['title'] ?? '');
        $maxOrder = $this->db->query('SELECT COALESCE(MAX(sort_order), 0) FROM references_projects')->fetchColumn();

        $stmt = $this->db->prepare(
            'INSERT INTO references_projects (title, slug, description, client, location, year, category, image_path, is_featured, is_active, sort_order) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([
            $title,
            slugify($title),
            $_POST['description'] ?? '',
            trim($_POST['client'] ?? ''),
            trim($_POST['location'] ?? ''),
            $_POST['year'] ?: null,
            trim($_POST['category'] ?? ''),
            $imagePath,
            isset($_POST['is_featured']) ? 1 : 0,
            isset($_POST['is_active']) ? 1 : 0,
            $maxOrder + 1,
        ]);

        $newId = $this->db->lastInsertId();
        setFlash('success', 'Referenz erstellt.');
        redirect(SITE_URL . ADMIN_PATH . '/references/' . $newId);
    }

    public function referenceDelete(string $id): void
    {
        Auth::requireLogin();
        if (!Auth::verifyCsrfToken($_POST[CSRF_TOKEN_NAME] ?? '')) {
            redirect(SITE_URL . ADMIN_PATH . '/references');
        }

        $stmt = $this->db->prepare('DELETE FROM references_projects WHERE id = ?');
        $stmt->execute([$id]);

        setFlash('success', 'Referenz gelöscht.');
        redirect(SITE_URL . ADMIN_PATH . '/references');
    }

    // ── Messages ──

    public function messagesList(): void
    {
        Auth::requireLogin();
        $messages = $this->db->query('SELECT * FROM contact_messages ORDER BY created_at DESC')->fetchAll();
        require APP_PATH . '/views/admin/messages_list.php';
    }

    public function messageView(string $id): void
    {
        Auth::requireLogin();

        // Mark as read
        $stmt = $this->db->prepare('UPDATE contact_messages SET is_read = 1 WHERE id = ?');
        $stmt->execute([$id]);

        $msg = $this->db->prepare('SELECT * FROM contact_messages WHERE id = ?');
        $msg->execute([$id]);
        $msg = $msg->fetch();

        if (!$msg) {
            setFlash('error', 'Nachricht nicht gefunden.');
            redirect(SITE_URL . ADMIN_PATH . '/messages');
        }

        require APP_PATH . '/views/admin/message_view.php';
    }

    public function messageDelete(string $id): void
    {
        Auth::requireLogin();
        if (!Auth::verifyCsrfToken($_POST[CSRF_TOKEN_NAME] ?? '')) {
            redirect(SITE_URL . ADMIN_PATH . '/messages');
        }

        $stmt = $this->db->prepare('DELETE FROM contact_messages WHERE id = ?');
        $stmt->execute([$id]);

        setFlash('success', 'Nachricht gelöscht.');
        redirect(SITE_URL . ADMIN_PATH . '/messages');
    }

    // ── Settings ──

    public function settings(): void
    {
        Auth::requireLogin();
        $settings = [];
        $rows = $this->db->query('SELECT * FROM settings ORDER BY setting_group, setting_key')->fetchAll();
        foreach ($rows as $row) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
        require APP_PATH . '/views/admin/settings.php';
    }

    public function settingsUpdate(): void
    {
        Auth::requireLogin();
        if (!Auth::verifyCsrfToken($_POST[CSRF_TOKEN_NAME] ?? '')) {
            redirect(SITE_URL . ADMIN_PATH . '/settings');
        }

        $fields = ['site_name', 'site_tagline', 'site_email', 'site_phone', 'site_address', 'footer_text', 'contact_email', 'google_maps_embed', 'maintenance_mode', 'maintenance_title', 'maintenance_message'];

        // Checkbox: if not sent, set to '0'
        if (!isset($_POST['maintenance_mode'])) {
            $_POST['maintenance_mode'] = '0';
        }
        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                $stmt = $this->db->prepare(
                    'INSERT INTO settings (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)'
                );
                $stmt->execute([$field, trim($_POST[$field])]);
            }
        }

        setFlash('success', 'Einstellungen gespeichert.');
        redirect(SITE_URL . ADMIN_PATH . '/settings');
    }

    // ── Password Change ──

    public function passwordForm(): void
    {
        Auth::requireLogin();
        require APP_PATH . '/views/admin/password.php';
    }

    public function passwordUpdate(): void
    {
        Auth::requireLogin();
        if (!Auth::verifyCsrfToken($_POST[CSRF_TOKEN_NAME] ?? '')) {
            redirect(SITE_URL . ADMIN_PATH . '/password');
        }

        $current = $_POST['current_password'] ?? '';
        $new = $_POST['new_password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';

        // Verify current
        $user = $this->db->prepare('SELECT password_hash FROM users WHERE id = ?');
        $user->execute([Auth::user('user_id')]);
        $user = $user->fetch();

        if (!password_verify($current, $user['password_hash'])) {
            setFlash('error', 'Aktuelles Passwort ist falsch.');
            redirect(SITE_URL . ADMIN_PATH . '/password');
        }

        if (strlen($new) < 8) {
            setFlash('error', 'Das neue Passwort muss mindestens 8 Zeichen lang sein.');
            redirect(SITE_URL . ADMIN_PATH . '/password');
        }

        if ($new !== $confirm) {
            setFlash('error', 'Die Passwörter stimmen nicht überein.');
            redirect(SITE_URL . ADMIN_PATH . '/password');
        }

        $hash = password_hash($new, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare('UPDATE users SET password_hash = ? WHERE id = ?');
        $stmt->execute([$hash, Auth::user('user_id')]);

        setFlash('success', 'Passwort geändert.');
        redirect(SITE_URL . ADMIN_PATH);
    }

    // ── File Upload Helper ──

    private function handleUpload(array $file): ?string
    {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        if ($file['size'] > MAX_UPLOAD_SIZE) {
            setFlash('error', 'Datei ist zu gross (max. 5 MB).');
            return null;
        }

        $mime = mime_content_type($file['tmp_name']);
        if (!in_array($mime, ALLOWED_IMAGE_TYPES)) {
            setFlash('error', 'Ungültiger Dateityp. Erlaubt: JPG, PNG, WebP, SVG.');
            return null;
        }

        $ext = match ($mime) {
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp',
            'image/svg+xml' => 'svg',
            default => 'jpg',
        };

        $filename = uniqid('img_', true) . '.' . $ext;
        $destination = UPLOAD_PATH . '/' . $filename;

        if (!is_dir(UPLOAD_PATH)) {
            mkdir(UPLOAD_PATH, 0755, true);
        }

        if (move_uploaded_file($file['tmp_name'], $destination)) {
            return UPLOAD_URL . '/' . $filename;
        }

        return null;
    }
}
