<?php
require_once __DIR__ . '/../vendor/autoload.php';
use App\Middlewares\RBACMiddleware;


RBACMiddleware::checkRole(requiredRole: 'user');

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(string: random_bytes(length: 32));
}

$msg = '';
$err = '';
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!isset($_SESSION['csrf_token']) || !hash_equals(known_string: $_SESSION['csrf_token'], user_string: $_POST['csrf_token'])) {
        die('CSRF validation failed');
    }

    if (isset($_POST['update_profile'])) {
        $newUsername = trim(string: $_POST['username']);
        $check = $pdo->prepare(query: "SELECT id FROM users WHERE username = ? AND id != ?");
        $check->execute(params: [$newUsername, $_SESSION['user_id']]);

        if ($check->fetch()) {
            $err = 'Username already exist';
        } else {
            $stmt = $pdo->prepare(query: "UPDATE users SET username = ? WHERE id = ?");
            $stmt->execute(params: [$newUsername, $_SESSION['user_id']]);
            $msg = 'Profile updated successfully';
        }
    }

    if (isset($_POST['change_password'])) {
        $currPwd = $_POST['current_password'];
        $nePwd = $_POST['new_password'];

        $stmt = $pdo->prepare(query: "SELECT password_hash FROM users WHERE id = ?");
        $stmt->execute(params: [$_SESSION['user_id']]);
        $userPwd = $stmt->fetch();

        if ($userPwd && password_verify(password: $currPwd, hash: $userPwd['password_hash'])) {

            $newHash = password_hash(password: $nePwd, algo: PASSWORD_ARGON2ID);
            $pdo->prepare("UPDATE users SET password_hash = ? WHERE id = ?")
                ->execute(params: [$newHash, $_SESSION['user_id']]);
        }
    }

}

$stmt = $pdo->prepare(query: "SELECT id, username, email, created_at FROM users WHERE id = ?");
$stmt->execute(params: [$_SESSION['user_id']]);
$user = $stmt->fetch();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/../assets/css/output.css">
    <meta name="color-scheme" content="light dark">
    <title>Profile</title>
    <script type="module" src="\..\assets\js\editForm.js"></script>
</head>

<body
    class="flex items-center-safe justify-center-safe min-h-svh p-6 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
    <?php require_once __DIR__ . '/../include/header.php'; ?>

    <main class="auth-card max-w-lg p-12 relative overflow-hidden bg-white dark:bg-gray-800 shadow-xl rounded-2xl">
        <div class="absolute top-0 left-0 w-full h-2 bg-green-500"></div>


        <?php if ($msg): ?>
            <div class="mb-6 p-3 bg-green-100 text-green-700 rounded text-xs font-bold border border-green-200"><?= $msg ?>
            </div>
        <?php endif; ?>
        <?php if ($err): ?>
            <div class="mb-6 p-3 bg-red-100 text-red-700 rounded text-xs font-bold border border-red-200"><?= $err ?></div>
        <?php endif; ?>

        <header class="flex justify-between items-start mb-10">
            <div>
                <h1 class="text-xl font-black tracking-wide sm:text-4xl">My Profile</h1>
                <p class="text-gray-500 text-sm mt-1">Manage your secure identity</p>
            </div>
            <a href="logout.php"
                class="text-xs font-bold uppercase text-gray-400 hover:text-red-500 transition-colors">Sign Out</a>
        </header>

        <!-- VIEW MODE -->
        <div id="view-mode" class="space-y-8">
            <div class="grid grid-cols-2 gap-4">
                <div class="flex flex-col">
                    <span class="text-[10px] uppercase tracking-widest text-gray-400 font-bold mb-1">Username</span>
                    <span class="font-bold"><?= htmlspecialchars(string: $user['username']); ?></span>
                </div>
                <div class="flex flex-col text-right">
                    <span class="text-[10px] uppercase tracking-widest text-gray-400 font-bold mb-1">Account ID</span>
                    <span class="font-mono text-xs opacity-50">#<?= $user['id']; ?></span>
                </div>
            </div>

            <div class="flex flex-col">
                <span class="text-[10px] uppercase tracking-widest text-gray-400 font-bold mb-1">Email Address</span>
                <span class="font-bold"><?= htmlspecialchars(string: $user['email']); ?></span>
            </div>

            <footer class="pt-6 border-t border-gray-100 dark:border-gray-700 flex justify-between items-center-safe">
                <span class="text-[11px] font-bold opacity-40 uppercase tracking-widest">
                    Since: <?= (new DateTime(datetime: $user['created_at']))->format(format: 'd M Y') ?>
                </span>
                <button type="button" id="edit-btn" class="text-sm font-black text-green-600 hover:underline">
                    Edit Profile
                </button>
            </footer>
        </div>


        <div id="edit-mode" class="hidden space-y-6">

            <form method="POST" class="space-y-4">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <div>
                    <label class="text-[10px] font-bold uppercase text-gray-400 tracking-widest" for="username">Update
                        Username</label>
                    <input type="text" id="username" name="username"
                        value="<?= htmlspecialchars(string: $user['username']) ?>" autocomplete="username" required
                        class="w-full mt-1 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded p-3 font-bold text-sm outline-none focus:ring-2 focus:ring-green-500">
                </div>
                <button type="submit" name="update_profile"
                    class="w-full bg-green-600 text-white text-xs font-black p-3 rounded uppercase tracking-widest hover:bg-green-700 transition">Save
                    Username</button>
            </form>

            <hr class="opacity-10">


            <form method="POST" class="space-y-4">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <label class="text-[10px] font-bold uppercase text-gray-400 tracking-widest" for="curr_pwd">Security
                    Update</label>
                <input type="password" name="current_password" placeholder="Current Password" id="curr_pwd"
                    autocomplete="current-password" required
                    class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded p-3 text-sm outline-none focus:ring-2 focus:ring-gray-400">
                <input type="password" name="new_password" placeholder="New Password" autocomplete="new-password"
                    required
                    class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded p-3 text-sm outline-none focus:ring-2 focus:ring-gray-400">
                <button type="submit" name="change_password"
                    class="w-full bg-gray-900 dark:bg-white dark:text-gray-900 text-white text-xs font-black p-3 rounded uppercase tracking-widest hover:opacity-90 transition">Change
                    Password</button>
            </form>

            <button type="button" id="cancel-btn"
                class="w-full text-center text-[10px] font-bold uppercase text-gray-400 tracking-widest hover:text-gray-600 py-2">Cancel</button>
        </div>
    </main>
    <?php require_once __DIR__ . '/../include/footer.php'; ?>
</body>

</html>