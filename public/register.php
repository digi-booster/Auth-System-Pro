<?php

declare(strict_types=1);

session_start();

if (isset($_SESSION['user_id']) && isset($_SESSION['user_role'])) {

    if ($_SESSION['user_role'] === 'admin') {
        header(header: "Location: admin_dash.php");
        exit();
    } else {
        header(header: "Location: user_dash.php");
        exit();
    }
}

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/db.php';

use App\Models\User;
use App\Controllers\RegisterController;

$userModel = new User(pdo: $pdo);
$controller = new RegisterController(userModel: $userModel);

$msg = '';
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $res = $controller->regsiter(data: $_POST);
    $msg = $res['message'];
    $success = $res['success'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>2026 Auth</title>
    <link rel="stylesheet" href="\..\assets\css\output.css">
    <script type="module" src="..\assets\js\showPwd.js"></script>

    <meta name="color-scheme" content="light dark">
</head>

<body class="flex flex-col  justify-center-safe items-center-safe min-h-svh p-6 relative">
    <?php require_once __DIR__ . '/../include/header.php'; ?>

    <main class="auth-card">
        <h1 class="text-3xl font-black mb-6">Register</h1>
        <?php if ($msg): ?>
            <div
                class="p-4 mb-4 rounded-xl text-sm <?= $success ? 'bg-green-100 text-green-800' : 'bg-red-100 text-green-800' ?>">
                <?= htmlspecialchars(string: $msg) ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-4">
            <input type="text" name="username" placeholder="Username" class="input-field" autocomplete="username"
                required>
            <input type="email" name="email" placeholder="Email" class="input-field" autocomplete="email" required>

            <input type="password" name="password" placeholder="Password" class="input-field" id="pwd"
                autocomplete="new-password" required>

            <label id="showPwd" class="inline-block cursor-pointer"><input type="checkbox" name=""> Show
                Password</label>

            <button type="submit" class="btn btn-primary">Register</button>
        </form>
        <footer class="mt-10 text-center border-t border-gray-100 dark:border-gray-800 pt-6">
            <p class="text-gray-500">
                Already have an account?
                <a href="login.php" class="text-brand font-bold hover:underline ml-1">
                    Login
                </a>
            </p>
    </main>
    </footer>

    <?php require_once __DIR__ . '/../include/footer.php'; ?>

</body>

</html>