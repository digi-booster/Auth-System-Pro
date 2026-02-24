<?php
namespace App\Middlewares;

final readonly class RBACMiddleware
{
    public static function checkRole(string $requiredRole): void
    {

        ini_set(option: 'session.use_strict_mode', value: 1);

        $cookieParams = [
            'lifetime' => 0,
            'path' => '/',
            'domain' => '',
            'secure' => false,
            'httponly' => true,
            'samesite' => 'Strict'
        ];
        session_set_cookie_params(lifetime_or_options: $cookieParams);

        if (session_start() === PHP_SESSION_NONE) {

            session_start();
        }
        if (!isset($_SESSION['initiated'])) {
            session_regenerate_id(delete_old_session: true);
            $_SESSION['initiated'] = time();
        } elseif (time() - $_SESSION['initiated'] > 1800) {
            session_regenerate_id(delete_old_session: true);
            $_SESSION['initiated'] = time();
        }


        $userRole = $_SESSION['user_role'] ?? 'guest';

        $hasAccess = match ($requiredRole) {
            'admin' => $userRole === 'admin',
            'user' => \in_array(needle: $userRole, haystack: ['user', 'admin'], strict: true),
            default => false,
        };

        if (!$hasAccess) {
            self::abortForbidden();
        }
    }


    private static function abortForbidden(): void
    {
        header(header: "HTTP/1.1 403 Forbidden");

        ?>
        <html lang="en">

        <head>
            <link rel="stylesheet" href="../assets/css/output.css">
            <Title>Access Denied</Title>
        </head>

        <body class="bg-gray-50 dark:bg-gray-950 flex items-center-safe justify-center-safe min-h-svh p-6"></body>
        <div class="max-w-md p-10 bg-white dark:bg-gray-900 rounded-3xl shadow-2xl text-center">
            <div class="text-5xl mb-4">🔐</div>
            <h1 class="text-2xl font-bold mb-2">Access Denied</h1>
            <p class="text-gray-500 text-sm mb-6">Your current role doesn't have permission to view this resource.</p>
            <a href="dashboard.php"
                class="inline-block bg-purple-600 text-white px-8 py-3 rounded-xl font-bold hover:scale-95 transition-all will-change-transform">
                Return
            </a>
        </div>
        <?php
        exit;
    }
}