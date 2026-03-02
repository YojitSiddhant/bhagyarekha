<?php
declare(strict_types=1);

require_once __DIR__ . '/_init.php';

if (admin_is_logged_in()) {
    redirect(admin_base() . '/dashboard.php');
}
redirect(admin_base() . '/login.php');

