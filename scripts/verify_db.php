<?php
declare(strict_types=1);

require __DIR__ . '/../app/bootstrap.php';

echo "DB connected OK\n";

$tables = db()->query('SHOW TABLES')->fetchAll(PDO::FETCH_NUM);
echo "Tables:\n";
foreach ($tables as $t) {
    echo "- " . $t[0] . "\n";
}

