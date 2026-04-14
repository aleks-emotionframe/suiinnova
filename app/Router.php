<?php
/**
 * Simple router for the application.
 */
class Router
{
    private array $routes = [];

    public function get(string $path, callable $handler): void
    {
        $this->routes['GET'][$path] = $handler;
    }

    public function post(string $path, callable $handler): void
    {
        $this->routes['POST'][$path] = $handler;
    }

    public function dispatch(string $uri, string $method): void
    {
        // Remove query string
        $uri = strtok($uri, '?');
        // Remove trailing slash (except for root)
        if ($uri !== '/') {
            $uri = rtrim($uri, '/');
        }

        $method = strtoupper($method);

        // Check for exact match
        if (isset($this->routes[$method][$uri])) {
            call_user_func($this->routes[$method][$uri]);
            return;
        }

        // Check for parameterized routes
        foreach ($this->routes[$method] ?? [] as $route => $handler) {
            $pattern = preg_replace('/\{([a-zA-Z_]+)\}/', '(?P<$1>[^/]+)', $route);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $uri, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                call_user_func_array($handler, $params);
                return;
            }
        }

        // 404
        http_response_code(404);
        require APP_PATH . '/views/pages/404.php';
    }
}
