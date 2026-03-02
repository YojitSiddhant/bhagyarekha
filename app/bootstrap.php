<?php
declare(strict_types=1);

// Central bootstrap for both frontend and admin.

require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/security.php';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/csrf.php';
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/content.php';
require_once __DIR__ . '/seo.php';
require_once __DIR__ . '/view.php';
require_once __DIR__ . '/models.php';
require_once __DIR__ . '/uploads.php';

$config = require __DIR__ . '/../config/config.php';
$localPath = __DIR__ . '/../config/config.local.php';
if (is_file($localPath)) {
    $local = require $localPath;
    $config = array_replace_recursive($config, is_array($local) ? $local : []);
}

app_set('config', $config);

date_default_timezone_set('Asia/Kolkata');

if (($config['app']['env'] ?? 'dev') === 'prod') {
    error_reporting(E_ALL);
    ini_set('display_errors', '0');
} else {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
}

secure_headers();
secure_session_start($config['app']['session_name'] ?? 'bhagyarekha_session');

// Lazy PDO connection (created when first used).
app_set('db', null);

