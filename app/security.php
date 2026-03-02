<?php
declare(strict_types=1);

function secure_headers(): void
{
    // Basic hardening headers (tuned for simple PHP site; adjust if needed).
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: SAMEORIGIN');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('Permissions-Policy: geolocation=(), microphone=(), camera=()');

    // HSTS should only be enabled when HTTPS is guaranteed for the domain.
    // if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
    //     header('Strict-Transport-Security: max-age=31536000; includeSubDomains; preload');
    // }
}

function secure_session_start(string $sessionName): void
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return;
    }

    $isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (($_SERVER['SERVER_PORT'] ?? '') === '443');

    // Ensure session save path is writable (important on Windows/XAMPP).
    $savePath = (string) ini_get('session.save_path');
    $savePath = trim(explode(';', $savePath)[0] ?? $savePath); // handle "N;path" formats
    if ($savePath === '' || !is_dir($savePath) || !is_writable($savePath)) {
        $fallback = __DIR__ . '/../storage/sessions';
        if (!is_dir($fallback)) {
            @mkdir($fallback, 0755, true);
        }
        if (is_dir($fallback) && is_writable($fallback)) {
            ini_set('session.save_path', $fallback);
        }
    }

    // Safer defaults.
    ini_set('session.use_strict_mode', '1');
    ini_set('session.use_only_cookies', '1');
    ini_set('session.cookie_httponly', '1');
    ini_set('session.cookie_samesite', 'Lax');
    if ($isHttps) {
        ini_set('session.cookie_secure', '1');
    }

    session_name($sessionName);
    session_start();
}

