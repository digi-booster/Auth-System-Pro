<?php
require_once __DIR__ . '/../vendor/autoload.php';
use App\Middlewares\RBACMiddleware;

// Only admin can access this page
RBACMiddleware::checkRole(requiredRole: 'admin');

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(string: random_bytes(length: 32));
}

require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!isset($_SESSION['csrf_token']) || !hash_equals(known_string: $_SESSION['csrf_token'], user_string: $_POST['csrf_token'])) {
        die('CSRF security failure');
    }

    if (isset($_POST['update_role'])) {
        $stmt = $pdo->prepare(query: "UPDATE users SET role = ? WHERE id = ?");
        $stmt->execute(params: [$_POST['role'], $_POST['user_id']]);
        header("Location: admin_dash.php?msg=RoleUpdated");
        exit;
    }

    if (isset($_POST['reset_password'])) {
        $tempPwd = 'Temp1234';
        $hash = password_hash(password: $tempPwd, algo: PASSWORD_ARGON2ID);
        $stmt = $pdo->prepare(query: 'UPDATE users SET password_hash = ? WHERE id = ?');
        $stmt->execute(params: [$hash, $_POST['user_id']]);
        header(header: "Location: admin_dash.php?msg=PassReset");
        exit;
    }
}

$users = $pdo->query(query: "SELECT id, username, email, role, created_at FROM users")->fetchAll();
$logs = $pdo->query(query: "SELECT user_id, ip_address, device_info, status, created_at FROM login_logs ORDER BY id DESC LIMIT 10")->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admi Panel</title>
    <link rel="stylesheet" href="../assets/css/output.css">
    <meta name="color-scheme" content="light dark">
    <style>
        .admin {
            bottom: -2rem;
        }
    </style>

</head>

<body class="bg-gray-50 dark:bg-gray-950 min-h-svh p-6 pb-0 space-y-8 relative">
    <?php require_once __DIR__ . '/../include/header.php'; ?>


    <nav
        class="max-w-6xl mx-auto flex justify-between items-center-safe bg-white dark:bg-gray-900 p-6 rounded-3xl shadow-xl mt-25">
        <h1 class="text-2xl font-black t">
            ADMIN
            <span class="text-purple-600">DASH</span>
        </h1>

    </nav>
    <main class="max-w-6xl mx-auto space-y-8">

        <section class="bg-white dark:bg-gray-900 p-8 rounded-3xl shadow-2xl overflow-hidden">
            <h2 class="text-lg font-black mb-6 border-b pb-4 border-gray-100 dark:border-gray-800">Identity Management
            </h2>

            <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
                <h2 class="text-xl font-black mb-6 dark:text-white">User Management</h2>
                <table class="w-full text-sm text-left border-collapse">
                    <thead
                        class="bg-gray-50 dark:bg-gray-700 uppercase text-[10px] tracking-widest font-bold text-gray-500">
                        <tr>
                            <th class="p-4 border-b dark:border-gray-600">User</th>
                            <th class="p-4 border-b dark:border-gray-600 text-center">Role Authority</th>
                            <th class="p-4 border-b dark:border-gray-600 text-right">Security Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        <?php foreach ($users as $u): ?>
                            <tr class="hover:bg-gray-600 dark:hover:bg-gray-750 transition-colors">
                                <td class="p-4">
                                    <div class="font-bold dark:text-gray-200">
                                        <?= htmlspecialchars(string: $u['username']) ?>
                                    </div>
                                    <div class="text-xs text-gray-400"><?= htmlspecialchars(string: $u['email']) ?> (ID:
                                        #<?= $u['id'] ?>)</div>
                                </td>
                                <td class="p-4 text-center">
                                    <form method="POST" class="flex items-center justify-center gap-2">
                                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                                        <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
                                        <select name="role"
                                            class="bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-xs rounded p-1.5 focus:ring-2 focus:ring-blue-500">
                                            <option value="user" <?= $u['role'] === 'user' ? 'selected' : '' ?>>User</option>
                                            <option value="admin" <?= $u['role'] === 'admin' ? 'selected' : '' ?>>Admin
                                            </option>
                                        </select>
                                        <button type="submit" name="update_role"
                                            class="bg-blue-600 hover:bg-blue-700 text-white text-[10px] font-semibold uppercase px-3 py-1.5 rounded transition">
                                            Update
                                        </button>
                                    </form>
                                </td>
                                <td class="p-4 text-right">
                                    <form method="POST" onsubmit="return confirm('Reset password to Temp1234?');">
                                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                                        <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
                                        <button type="submit" name="reset_password"
                                            class="bg-purple-600 hover:bg-purple-700 text-white text-[10px] font-semibold uppercase px-4 py-2 rounded transition">
                                            Reset Password
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </section>

        <section class="bg-white dark:bg-gray-900 p-8 rounded-3xl shadow-2xl mb-45">
            <h2 class="text-xl font-black mb-6 dark:text-white uppercase tracking-tight">Latest 10 System Login Audit
                Logs
            </h2>
            <div class="overflow-x-auto">
                <table class="w-full text-xs text-left">
                    <thead class="bg-gray-100 dark:bg-gray-700 font-bold text-gray-500 uppercase">
                        <tr>
                            <th class="p-3">User ID</th>
                            <th class="p-3">Network IP</th>
                            <th class="p-3">Device Detail</th>
                            <th class="p-3">Result</th>
                            <th class="p-3 text-right">Timestamp</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        <?php foreach ($logs as $log): ?>
                            <tr class="dark:text-gray-300">
                                <td class="p-3 font-mono">#<?= $log['user_id'] ?></td>
                                <td class="p-3 font-mono">
                                    <?= htmlspecialchars(string: inet_ntop(ip: $log['ip_address'])) ?>
                                </td>
                                <td class="p-3 opacity-70">
                                    <?= htmlspecialchars(string: substr(string: $log['device_info'], offset: 0, length: 40)) ?>...
                                </td>
                                <td class="p-3">
                                    <span
                                        class="px-2 py-0.5 rounded-full text-[10px] font-bold <?= $log['status'] === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
                                        <?= strtoupper(string: $log['status']) ?>
                                    </span>
                                </td>
                                <td class="p-3 text-right opacity-50 italic">
                                    <?= (new DateTime(datetime: $log['created_at']))->format(format: 'd-M H:i:s') ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </section>

    </main>

    <footer
        class="py-8 text-center text-gray-500 dark:text-gray-400 dark:bg-gray-900 transition-colors duration-300 w-full left-0 absolute">
        &copy; 2026 Himu | Auth System Pro Portfolio
    </footer>
</body>

</html>