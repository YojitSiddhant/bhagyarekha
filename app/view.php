<?php
declare(strict_types=1);

function render(string $viewPath, array $data = [], string $layoutPath = 'layouts/main.php'): void
{
    $viewFile = __DIR__ . '/../views/' . ltrim($viewPath, '/');
    $layoutFile = __DIR__ . '/../views/' . ltrim($layoutPath, '/');

    if (!is_file($viewFile)) {
        http_response_code(500);
        echo 'View not found: ' . e($viewPath);
        return;
    }
    if (!is_file($layoutFile)) {
        http_response_code(500);
        echo 'Layout not found: ' . e($layoutPath);
        return;
    }

    extract($data, EXTR_SKIP);

    ob_start();
    require $viewFile;
    $content = (string) ob_get_clean();

    require $layoutFile;
}

