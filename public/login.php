<?php

declare(strict_types=1);

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
use App\Controllers\LoginController;
use App\Services\OTPService;

$userModel = new User(pdo: $pdo);
$otp = new OTPService(pdo: $pdo);
$loginController = new LoginController(userModel: $userModel, pdo: $pdo, otp: $otp);

$msg = '';
$isSuccess = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = (string) $_POST['email'] ?? '';
    $password = (string) $_POST['password'] ?? '';

    $result = $loginController->login(email: $email, password: $password);
    $msg = $result['message'];
    $isSuccess = $result['success'] ?? false;

    if ($isSuccess) {
        header(header: 'location: ' . ($result['step_up'] ? 'verify_otp.php' : 'dashboard.php'));
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Login 2026</title>
    <link rel="stylesheet" href="../assets/css/output.css">
    <meta name="color-scheme" content="light dark">

    <script type="module" src="..\assets\js\showPwd.js"></script>
</head>

<body class="flex items-center-safe justify-center-safe min-h-svh p-6 relative">
    <?php require_once __DIR__ . '/../include/header.php'; ?>

    <main class="auth-card">
        <h1 class="text-4xl font-black tracking-tighter dark:text-white mb-6">Login</h1>

        <?php if ($msg): ?>
            <div class="p-4 mb-4 rounded-2xl text-sm font-bold shadow-sm transition-all" role="alert">
                <div class="flex items-center-safe gap-2">
                    <span
                        class="size-2 rounded-full animate-pulse <?= $isSuccess ? 'bg-green-500' : 'bg-red-500' ?>"></span>
                    <?= htmlspecialchars(string: $msg) ?>
                </div>
            </div>
        <?php endif; ?>

        <form action="" method="post" class="space-y-6">
            <div class="space-y-2">
                <label for="email" class="label">Email Address</label>
                <input type="email" name="email" id="email" class="input-field" autocomplete="email"
                    placeholder="Example@email.com" required>
            </div>
            <div class="space-y-2">
                <label for="pwd" class="label">Password</label>
                <input type="password" name="password" id="pwd" class="input-field" autocomplete="current-password"
                    placeholder="••••••••••••••••••••••••" required>
            </div>
            <div class="flex justify-between flex-col sm:flex-row">
                <label id="showPwd" class="cursor-pointer"><input type="checkbox" name=""> Show Password</label>
                <!-- <a href="#" target="_blank" rel="noopener noreferrer">Forget
                    Password?</a> -->
            </div>
            <button type="submit" class="btn btn-submit">Verify & Sign In</button>
        </form>
        <footer class="mt-10 text-center border-t border-gray-100 dark:border-gray-800 pt-6">
            <p class="text-gray-500">
                New to system?
                <a href="register.php" class="text-brand font-bold hover:underline ml-1">
                    Create Account
                </a>
            </p>
        </footer>
    </main>
    <?php require_once __DIR__ . '/../include/footer.php'; ?>
</body>

</html>