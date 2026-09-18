<?php
/**
 * Authentifizierung & CSRF-Schutz
 */

/**
 * Admin einloggen
 */
function login(string $username, string $password): bool
{
    global $db;

    $user = $db->fetch(
        "SELECT id, username, password, role FROM users WHERE username = :username",
        ['username' => $username]
    );

    if (!$user || !password_verify($password, $user['password'])) {
        return false;
    }

    // Session regenerieren (Session Fixation verhindern)
    session_regenerate_id(true);

    $_SESSION['admin_id'] = $user['id'];
    $_SESSION['admin_username'] = $user['username'];
    $_SESSION['admin_role'] = $user['role'];
    $_SESSION['admin_login_time'] = time();
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

    return true;
}

/**
 * Admin ausloggen
 */
function logout(): void
{
    $_SESSION = [];

    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(), '', time() - 42000,
            $params['path'], $params['domain'],
            $params['secure'], $params['httponly']
        );
    }

    session_destroy();
}

/**
 * Ist Admin eingeloggt?
 */
function isLoggedIn(): bool
{
    if (empty($_SESSION['admin_id'])) {
        return false;
    }

    // Session-Timeout pruefen
    if (time() - ($_SESSION['admin_login_time'] ?? 0) > SESSION_LIFETIME) {
        logout();
        return false;
    }

    return true;
}

/**
 * Login erzwingen (Redirect falls nicht eingeloggt)
 */
function requireAuth(): void
{
    if (!isLoggedIn()) {
        header('Location: ' . url('admin/login'));
        exit;
    }
}

/**
 * CSRF-Token generieren falls noch nicht vorhanden
 */
function ensureCsrfToken(): void
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
}

/**
 * CSRF-Token holen
 */
function csrfToken(): string
{
    ensureCsrfToken();
    return $_SESSION['csrf_token'];
}

/**
 * Hidden CSRF-Input-Feld ausgeben
 */
function csrfField(): string
{
    return '<input type="hidden" name="csrf_token" value="' . e(csrfToken()) . '">';
}

/**
 * CSRF-Token validieren
 */
function validateCsrf(): bool
{
    $token = $_POST['csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
    return hash_equals(csrfToken(), $token);
}

/**
 * CSRF erzwingen (bricht ab bei ungueltigem Token)
 */
function requireCsrf(): void
{
    if (!validateCsrf()) {
        http_response_code(403);
        echo json_encode(['error' => 'Ungültiges CSRF-Token']);
        exit;
    }
}

/**
 * Aktuellen Admin-Usernamen holen
 */
function adminUsername(): string
{
    return $_SESSION['admin_username'] ?? '';
}

/**
 * Aktuelle Admin-ID holen
 */
function adminId(): int
{
    return (int) ($_SESSION['admin_id'] ?? 0);
}
