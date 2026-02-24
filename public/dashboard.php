<?php

declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header(header: 'Location: login.php');
    exit;
}

$target = match ($_SESSION['user_role'] ?? 'guest') {
    'admin' => 'admin_dash.php',
    'user' => 'user_dash.php',
    default => 'login.php'
};

header(header: "Location: $target");
exit;
