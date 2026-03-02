<?php
declare(strict_types=1);

/**
 * Tiny app container + helpers (no framework).
 */

function app_set(string $key, mixed $value): void
{
    $store = &app_store();
    $store[$key] = $value;
}

function app_get(string $key, mixed $default = null): mixed
{
    $store = &app_store();
    return array_key_exists($key, $store) ? $store[$key] : $default;
}

function &app_store(): array
{
    static $store = [];
    return $store;
}

function config(string $path, mixed $default = null): mixed
{
    $cfg = app_get('config', []);
    $parts = explode('.', $path);
    foreach ($parts as $p) {
        if (!is_array($cfg) || !array_key_exists($p, $cfg)) {
            return $default;
        }
        $cfg = $cfg[$p];
    }
    return $cfg;
}

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function base_url(): string
{
    $base = trim((string) config('app.base_url', ''));
    if ($base !== '') {
        return rtrim($base, '/');
    }

    $isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (($_SERVER['SERVER_PORT'] ?? '') === '443');
    $scheme = $isHttps ? 'https' : 'http';
    $host = (string) ($_SERVER['HTTP_HOST'] ?? 'localhost');
    $scriptName = (string) ($_SERVER['SCRIPT_NAME'] ?? '/index.php');
    $dir = rtrim(str_replace('\\', '/', dirname($scriptName)), '/');

    // If running inside /admin/*, compute base url at project root.
    if (str_ends_with($dir, '/admin')) {
        $dir = substr($dir, 0, -strlen('/admin'));
    }
    if ($dir === '/' || $dir === '.') {
        $dir = '';
    }

    return rtrim($scheme . '://' . $host . ($dir === '' ? '' : $dir), '/');
}

function redirect(string $url): never
{
    header('Location: ' . $url, true, 302);
    exit;
}

function request_path(): string
{
    $uri = (string) ($_SERVER['REQUEST_URI'] ?? '/');
    $path = parse_url($uri, PHP_URL_PATH);
    $path = is_string($path) ? $path : '/';

    // If the project is served from a subfolder (e.g. /bhagyarekha/),
    // remove that prefix so routing works for "/" as "home".
    $scriptName = (string) ($_SERVER['SCRIPT_NAME'] ?? '/index.php');
    $basePath = rtrim(str_replace('\\', '/', dirname($scriptName)), '/');
    if (str_ends_with($basePath, '/admin')) {
        $basePath = substr($basePath, 0, -strlen('/admin'));
    }
    if ($basePath === '/' || $basePath === '.') {
        $basePath = '';
    }
    if ($basePath !== '' && str_starts_with($path, $basePath)) {
        $path = substr($path, strlen($basePath));
        if ($path === '') {
            $path = '/';
        }
    }

    return $path;
}

function url_to(string $pathOrUrl): string
{
    $v = trim($pathOrUrl);
    if ($v === '') {
        return '';
    }
    if (preg_match('~^https?://~i', $v)) {
        return $v;
    }
    if (str_starts_with($v, '/')) {
        return base_url() . $v;
    }
    return base_url() . '/' . $v;
}

function flash_set(string $key, string $message): void
{
    if (!isset($_SESSION['_flash']) || !is_array($_SESSION['_flash'])) {
        $_SESSION['_flash'] = [];
    }
    $_SESSION['_flash'][$key] = $message;
}

function flash_get(string $key): string
{
    $val = '';
    if (isset($_SESSION['_flash']) && is_array($_SESSION['_flash']) && array_key_exists($key, $_SESSION['_flash'])) {
        $val = (string) $_SESSION['_flash'][$key];
        unset($_SESSION['_flash'][$key]);
    }
    return $val;
}

