<?php
declare(strict_types=1);

require_once __DIR__ . '/_init.php';

admin_logout();
redirect(admin_base() . '/login.php');

