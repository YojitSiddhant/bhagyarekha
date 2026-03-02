<?php
declare(strict_types=1);

require_once __DIR__ . '/../app/bootstrap.php';

function admin_base(): string
{
    return base_url() . '/admin';
}

function admin_nav(string $active): array
{
    return [
        'dashboard' => ['label' => 'Dashboard', 'href' => admin_base() . '/dashboard.php'],
        'content' => ['label' => 'Content', 'href' => admin_base() . '/content.php'],
        'seo' => ['label' => 'SEO', 'href' => admin_base() . '/seo.php'],
        'services' => ['label' => 'Services', 'href' => admin_base() . '/services.php'],
        'testimonials' => ['label' => 'Testimonials', 'href' => admin_base() . '/testimonials.php'],
        'products' => ['label' => 'Products', 'href' => admin_base() . '/products.php'],
        'awards' => ['label' => 'Awards', 'href' => admin_base() . '/awards.php'],
        'gallery' => ['label' => 'Gallery', 'href' => admin_base() . '/gallery.php'],
        'media' => ['label' => 'Media', 'href' => admin_base() . '/media.php'],
        'messages' => ['label' => 'Messages', 'href' => admin_base() . '/messages.php'],
    ];
}

function admin_layout_start(string $title, string $active): void
{
    $user = admin_user();
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= e($title) ?></title>
        <link rel="stylesheet" href="<?= e(admin_base()) ?>/assets/admin.css">
    </head>
    <body>
    <div class="wrap">
        <div class="top">
            <div>
                <div class="brand">Bhagyarekha Admin</div>
                <div class="muted"><?= e(content_get('site.brand_name')) ?></div>
            </div>
            <div>
                <?php if ($user): ?>
                    <span class="muted">Logged in as <?= e((string) $user['username']) ?></span>
                    <a class="btn" href="<?= e(admin_base()) ?>/logout.php">Logout</a>
                <?php endif; ?>
            </div>
        </div>
        <?php if ($user): ?>
            <div class="nav">
                <?php foreach (admin_nav($active) as $key => $item): ?>
                    <a href="<?= e($item['href']) ?>" class="<?= $active === $key ? 'active' : '' ?>"><?= e($item['label']) ?></a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    <?php
}

function admin_layout_end(): void
{
    ?>
    </div>
    </body>
    </html>
    <?php
}

