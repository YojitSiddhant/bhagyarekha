<?php
declare(strict_types=1);

require_once __DIR__ . '/_init.php';

if (admin_is_logged_in()) {
    redirect(admin_base() . '/dashboard.php');
}

$error = '';

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    csrf_verify();

    if (!admin_login_attempts_ok()) {
        $error = 'Too many attempts. Please wait 1 minute.';
    } else {
        admin_login_record_attempt();
        $username = trim((string) ($_POST['username'] ?? ''));
        $password = (string) ($_POST['password'] ?? '');
        if ($username === '' || $password === '') {
            $error = 'Enter username and password.';
        } elseif (admin_login($username, $password)) {
            redirect(admin_base() . '/dashboard.php');
        } else {
            $error = 'Invalid credentials.';
        }
    }
}

admin_layout_start('Admin Login', 'login');
?>

<div class="card">
    <h2 style="margin:0 0 10px;">Login</h2>
    <div class="muted">Use the admin user created during DB import.</div>
    <?php if ($error !== ''): ?>
        <div class="alert err"><?= e($error) ?></div>
    <?php endif; ?>

    <form method="post" action="<?= e(admin_base()) ?>/login.php" style="margin-top: 12px;">
        <?= csrf_field() ?>
        <label for="username">Username</label>
        <input id="username" name="username" type="text" autocomplete="username" required>

        <label for="password">Password</label>
        <input id="password" name="password" type="password" autocomplete="current-password" required>

        <div style="margin-top: 14px;">
            <button class="btn primary" type="submit">Login</button>
            <a class="btn" href="<?= e(base_url()) ?>/">View site</a>
        </div>
    </form>
</div>

<?php admin_layout_end(); ?>

