<?php
declare(strict_types=1);

/**
 * Create (and reuse) a PDO connection to the local MySQL database.
 */
function db(): PDO
{
    static $pdo;

    // Reuse the same PDO instance
    if ($pdo instanceof PDO) {
        return $pdo;
    }

    // Hard-coded credentials for local XAMPP
    $host    = '127.0.0.1';
    $port    = 3306;
    $name    = 'bhagyarekha';
    $user    = 'root';
    $pass    = '';          // empty password for XAMPP root
    $charset = 'utf8mb4';

    $dsn = "mysql:host={$host};port={$port};dbname={$name};charset={$charset}";

    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    $pdo = new PDO($dsn, $user, $pass, $options);
    return $pdo;
}

/**
 * Helper: check if a table exists in the current DB.
 */
function db_table_exists(string $tableName): bool
{
    // Use information_schema to safely check table existence
    $stmt = db()->prepare(
        'SELECT 1
         FROM information_schema.tables
         WHERE table_schema = DATABASE()
           AND table_name = ?
         LIMIT 1'
    );
    $stmt->execute([$tableName]);

    return (bool) $stmt->fetchColumn();
}