<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user_id']) && isset($_SESSION['user_role'])) {

    if ($_SESSION['user_role'] === 'admin') {
        header(header: "Location: admin_dash.php");
        exit();
    } else {
        header(header: "Location: user_dash.php");
        exit();
    }
}


use App\Models\User;
use App\Controllers\LoginController;
use App\Services\OTPService;


$userId = $_SESSION['temp_auth_id'] ?? null;
$action = $_GET['action'] ?? 'otp';

if (!$userId) {
    header(header: 'Location: login.php');
    echo $userId;
    exit;
}

$userModel = new User(pdo: $pdo);
$otp = new OTPService(pdo: $pdo);
$controller = new LoginController(userModel: $userModel, pdo: $pdo, otp: $otp, );

$msg = '';
$demo = $_SESSION['demo_otp'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if ($otp->verify(userId: (int) $userId, otp: (string) $_POST['otp'], action: $action)) {
        unset($_SESSION['demo_otp']);

        if ($action === 'otp') {
            $controller->audit(userId: (int) $userId, status: 'success');
            $_SESSION['user_id'] = $userId;
            $_SESSION['user_role'] = $_SESSION['temp_auth_role'];
            header(header: 'Location: dashboard.php');
            unset($_SESSION['temp_auth_id']);

        } else {
            // reset final redirection
        }
        exit;
    }
    $msg = 'Invaild or expired code, try again';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $action ?> Verification 2026</title>
    <link rel="stylesheet" href="..\assets\css\output.css">
    <meta name="color-scheme" content="light dark">

</head>

<body class="flex justify-center-safe items-center-safe min-h-svh p-6">
    <?php require_once __DIR__ . '/../include/header.php'; ?>

    <?php if ($demo): ?>
        <div
            class="fixed top-6 right-6 p-4 bg-purple-600 tex-white rounded-2xl animate-pulse shadow-2xl z-50 mt-10 sm:mt-15">
            Demo Code: <?= $demo ?>
        </div>
    <?php endif; ?>

    <main class="auth-card">
        <h1 class="text-3xl font-bold mb-2 text-center"><?= ucfirst(string: $action) ?> Verification</h1>

        <?php if ($msg): ?>
            <div class="p-4 mb-4 rounded-xl bg-red-100 text-red-800 font-bold text-sm">
                <?= $msg ?>
            </div>
        <?php endif; ?>

        <form action="" method="post" class="mt-10 space-y-6">

            <input type="text" name="otp" id="otp" inputmode="numeric" autocomplete="one-time-code" pattern="\d{6}"
                maxlength="6" placeholder="000000" required class="input-field text-center text-4xl">
            <button type="submit" class="btn bg-purple-600">Verify Now!</button>
        </form>
    </main>
    <?php require_once __DIR__ . '/../include/footer.php'; ?>

</body>

</html>