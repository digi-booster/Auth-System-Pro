<?php

declare(strict_types=1);

$host = '127.0.0.1';
$db = 'auth_system_pro';
$user = 'root';
$pass = 'root';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO(dsn: $dsn, username: $user, password: $pass, options: $options);
} catch (\PDOException $e) {
    error_log(message: "Database connection error" . $e->getMessage());
    exit('A system error occurred. Please try again later');
}
