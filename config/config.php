<?php
declare(strict_types=1);

// Base configuration (safe to commit/share). Override locally in config.local.php.
return [
    'app' => [
        // If empty, the app will attempt to detect it from the request.
        // Example: https://example.com
        'base_url' => '',
        'env' => 'dev', // dev|prod
        'session_name' => 'bhagyarekha_session',
    ],
    'db' => [
        'host' => '127.0.0.1',
        'port' => 3306,
        'name' => 'bhagyarekha',
        'user' => 'root',
        'pass' => '',
        'charset' => 'utf8mb4',
    ],
    'security' => [
        // Set to true only for one-time setup pages, then set back to false.
        'install_enabled' => false,
    ],
];

