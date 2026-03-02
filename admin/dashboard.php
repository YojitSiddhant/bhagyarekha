<?php
declare(strict_types=1);

require_once __DIR__ . '/_init.php';
admin_require_login();

$dbOk = db_table_exists('content') && db_table_exists('admin_users');

admin_layout_start('Dashboard', 'dashboard');
?>

<div class="card">
    <h2 style="margin:0 0 10px;">Dashboard</h2>
    <?php if ($dbOk): ?>
        <div class="alert ok">Database looks installed. You can edit Content / SEO / Services now.</div>
    <?php else: ?>
        <div class="alert err">Database tables not found. Import `database/bhagyarekha.sql` into MySQL.</div>
    <?php endif; ?>

    <div class="grid">
        <div class="card">
            <h3 style="margin:0 0 10px;">Quick actions</h3>
            <div class="row-actions">
                <a class="btn primary" href="<?= e(admin_base()) ?>/content.php">Edit content</a>
                <a class="btn" href="<?= e(admin_base()) ?>/seo.php">Manage SEO</a>
                <a class="btn" href="<?= e(admin_base()) ?>/services.php">Manage services</a>
            </div>
        </div>
        <div class="card">
            <h3 style="margin:0 0 10px;">Frontend</h3>
            <div class="muted">Open the site to verify layout & responsiveness.</div>
            <div style="margin-top: 12px;">
                <a class="btn good" href="<?= e(base_url()) ?>/" target="_blank" rel="noopener">Open website</a>
            </div>
        </div>
    </div>
</div>

<?php admin_layout_end(); ?>

