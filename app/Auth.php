<?php
/**
 * Simple authentication handler.
 */
class Auth
{
    public static function login(string $username, string $password): bool
    {
        $db = Database::getInstance();
        $stmt = $db->prepare('SELECT * FROM users WHERE username = ? AND is_active = 1 LIMIT 1');
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['display_name'] = $user['display_name'];
            $_SESSION['logged_in'] = true;

            // Update last login
            $update = $db->prepare('UPDATE users SET last_login = NOW() WHERE id = ?');
            $update->execute([$user['id']]);

            return true;
        }

        return false;
    }

    public static function logout(): void
    {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }
        session_destroy();
    }

    public static function check(): bool
    {
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }

    public static function requireLogin(): void
    {
        if (!self::check()) {
            header('Location: ' . SITE_URL . ADMIN_PATH . '/login');
            exit;
        }
    }

    public static function user(?string $key = null)
    {
        if ($key) {
            return $_SESSION[$key] ?? null;
        }
        return [
            'id' => $_SESSION['user_id'] ?? null,
            'username' => $_SESSION['username'] ?? null,
            'display_name' => $_SESSION['display_name'] ?? null,
        ];
    }

    public static function generateCsrfToken(): string
    {
        if (empty($_SESSION[CSRF_TOKEN_NAME])) {
            $_SESSION[CSRF_TOKEN_NAME] = bin2hex(random_bytes(32));
        }
        return $_SESSION[CSRF_TOKEN_NAME];
    }

    public static function verifyCsrfToken(string $token): bool
    {
        return isset($_SESSION[CSRF_TOKEN_NAME]) && hash_equals($_SESSION[CSRF_TOKEN_NAME], $token);
    }
}
