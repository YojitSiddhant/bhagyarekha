<?php
declare(strict_types=1);

function admin_user(): ?array
{
    $id = $_SESSION['admin_user_id'] ?? null;
    if (!is_int($id) && !is_string($id)) {
        return null;
    }
    $id = (int) $id;
    if ($id <= 0) {
        return null;
    }

    if (!db_table_exists('admin_users')) {
        return null;
    }

    $stmt = db()->prepare('SELECT id, username, role, is_active FROM admin_users WHERE id = ? LIMIT 1');
    $stmt->execute([$id]);
    $row = $stmt->fetch();
    if (!$row || (int) $row['is_active'] !== 1) {
        return null;
    }
    return $row;
}

function admin_is_logged_in(): bool
{
    return admin_user() !== null;
}

function admin_require_login(): void
{
    if (!admin_is_logged_in()) {
        redirect(base_url() . '/admin/login.php');
    }
}

function admin_logout(): void
{
    unset($_SESSION['admin_user_id']);
}

function admin_login_attempts_ok(): bool
{
    $windowSeconds = 60;
    $maxAttempts = 10;

    $now = time();
    $bucket = $_SESSION['_admin_login_bucket'] ?? null;
    if (!is_array($bucket) || ($bucket['reset_at'] ?? 0) < $now) {
        $_SESSION['_admin_login_bucket'] = ['reset_at' => $now + $windowSeconds, 'count' => 0];
        return true;
    }

    return (int) ($bucket['count'] ?? 0) < $maxAttempts;
}

function admin_login_record_attempt(): void
{
    $bucket = $_SESSION['_admin_login_bucket'] ?? ['reset_at' => time() + 60, 'count' => 0];
    if (!is_array($bucket)) {
        $bucket = ['reset_at' => time() + 60, 'count' => 0];
    }
    $bucket['count'] = (int) ($bucket['count'] ?? 0) + 1;
    $_SESSION['_admin_login_bucket'] = $bucket;
}

function admin_login(string $username, string $password): bool
{
    if (!db_table_exists('admin_users')) {
        return false;
    }

    $stmt = db()->prepare('SELECT id, username, password_hash, is_active FROM admin_users WHERE username = ? LIMIT 1');
    $stmt->execute([$username]);
    $row = $stmt->fetch();
    if (!$row || (int) $row['is_active'] !== 1) {
        return false;
    }
    if (!password_verify($password, (string) $row['password_hash'])) {
        return false;
    }

    $_SESSION['admin_user_id'] = (int) $row['id'];
    session_regenerate_id(true);

    $upd = db()->prepare('UPDATE admin_users SET last_login_at = NOW() WHERE id = ?');
    $upd->execute([(int) $row['id']]);

    return true;
}

