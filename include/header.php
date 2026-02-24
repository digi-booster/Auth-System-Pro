<?php
if (session_status() === PHP_SESSION_NONE)
    session_start();

$isLoggedIn = isset($_SESSION['user_id']);
$isAdmin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
$current_page = basename(path: $_SERVER['PHP_SELF']);
?>

<nav
    class="hidden md:block w-svw fixed top-0 left-0 z-50 border-b border-gray-200/50 bg-white/70 backdrop-blur-xl dark:border-white/10 dark:bg-gray-900/70">
    <div class="mx-auto max-w-7xl px-8 h-20 flex items-center justify-between">

        <div class="flex items-center gap-3 group">
            <div class="h-10 w-1.5 bg-green-500 rounded-full group-hover:h-12 transition-all"></div>
            <a href="/index.php" class="text-2xl font-black tracking-tighter uppercase italic dark:text-white">Auth<span
                    class="text-green-500">Pro</span></a>
        </div>

        <div class="flex items-center gap-6">
            <?php if ($isLoggedIn): ?>
                <a href="/public/user_dash.php"
                    class="text-sm font-bold <?= $current_page == 'user_dashboard.php' ? 'text-green-600' : 'text-gray-500 hover:text-black dark:hover:text-white' ?>">My
                    Profile</a>

                <?php if ($isAdmin): ?>
                    <a href="/public/admin_dash.php"
                        class="flex items-center gap-2 text-sm font-black text-purple-600 dark:text-purple-400 px-4 py-2 bg-purple-50 dark:bg-purple-900/20 rounded-xl hover:bg-purple-100 transition-all border border-purple-100 dark:border-purple-800">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        Admin Dashboard
                    </a>
                <?php endif; ?>

                <a href="/public/logout.php"
                    class="text-xs font-black uppercase text-gray-400 hover:text-red-500 transition-colors">Sign Out</a>
            <?php else: ?>
                <a href="/public/login.php" class="text-sm font-bold text-gray-500">Sign In</a>
                <a href="/public/register.php"
                    class="bg-black text-white dark:bg-white dark:text-black px-6 py-2.5 rounded-xl font-black text-sm">Join</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<div
    class="md:hidden w-svw fixed top-0 left-0  z-40 bg-white/80 backdrop-blur-lg dark:bg-gray-900/80 border-b dark:border-white/10 p-4 flex justify-center">
    <a href="/" class="text-xl font-black tracking-tighter uppercase italic dark:text-white">Auth<span
            class="text-green-500">Pro</span></a>
</div>

<nav
    class="md:hidden fixed bottom-0 left-0 admin z-50 w-full bg-white/90 backdrop-blur-2xl border-t border-gray-100 dark:bg-gray-950/90 dark:border-white/5 pb-safe">
    <div class="flex justify-around items-center h-16 px-4">
        <?php if ($isLoggedIn): ?>
            <a href="/public/user_dash.php"
                class="flex flex-col items-center <?= $current_page == 'user_dashboard.php' ? 'text-green-500' : 'text-gray-400' ?>">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span class="text-[9px] font-black uppercase mt-1">Profile</span>
            </a>

            <?php if ($isAdmin): ?>
                <a href="/public/admin_dash.php"
                    class="relative -top-6 flex h-14 w-14 items-center justify-center rounded-2xl bg-purple-600 text-white shadow-xl shadow-purple-500/40 active:scale-90 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                    </svg>
                </a>
            <?php else: ?>
                <button id="menu-toggle"
                    class="relative -top-6 flex h-14 w-14 items-center justify-center rounded-2xl bg-green-500 text-white shadow-xl shadow-green-500/40 active:scale-90 transition-transform">
                    <svg id="toggle-icon" class="w-6 h-6 transition-transform" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>
            <?php endif; ?>

            <a href="/public/logout.php" class="flex flex-col items-center text-gray-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7" />
                </svg>
                <span class="text-[9px] font-black uppercase mt-1">Exit</span>
            </a>
        <?php else: ?>
            <a href="/public/login.php" class="text-xs font-black uppercase text-gray-400">Sign In</a>
            <a href="/public/register.php"
                class="bg-green-600 text-white px-8 py-2.5 rounded-full text-xs font-black uppercase">Get Started</a>
        <?php endif; ?>
    </div>
</nav>

<!-- 4. FULL-SCREEN MOBILE DRAWER (For extra links) -->
<div id="mobile-drawer"
    class="md:hidden fixed inset-0 z-50 translate-x-full transition-transform duration-500 pointer-events-none">
    <div class="absolute inset-0 bg-white/40 dark:bg-gray-900/60 backdrop-blur-3xl pointer-events-auto"
        onclick="toggleMenu(false)"></div>
    <div
        class="relative h-full w-4/5 ml-auto bg-white dark:bg-gray-900 shadow-2xl p-10 flex flex-col justify-between pointer-events-auto">
        <div class="space-y-10 mt-12">
            <p class="text-[10px] font-black uppercase tracking-[0.4em] text-green-500">Navigation</p>
            <nav class="flex flex-col gap-6">
                <a href="index.php" class="text-4xl font-black dark:text-white">Home</a>
                <a href="public/user_dash.php" class="text-4xl font-black dark:text-white">My Account</a>
                <?php if ($isAdmin): ?>
                    <a href="public/admin_dash.php" class="text-4xl font-black text-purple-500">Admin Control</a>
                <?php endif; ?>
            </nav>
        </div>
        <button onclick="toggleMenu(false)"
            class="w-full py-4 text-xs font-black uppercase text-gray-400 border border-gray-100 dark:border-gray-800 rounded-xl">Close</button>
    </div>
</div>

<script>
    function toggleMenu(open) {
        const drawer = document.getElementById('mobile-drawer');
        const icon = document.getElementById('toggle-icon');
        if (!drawer) return;

        if (open) {
            drawer.classList.remove('translate-x-full');
            if (icon) icon.style.transform = 'rotate(90deg)';
            document.body.style.overflow = 'hidden';
        } else {
            drawer.classList.add('translate-x-full');
            if (icon) icon.style.transform = 'rotate(0deg)';
            document.body.style.overflow = 'auto';
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const btn = document.getElementById('menu-toggle');
        if (btn) btn.onclick = () => toggleMenu(true);
    });
</script>

<style>
    @media (min-width: 768px) {
        body {
            padding-bottom: 0;
        }
    }

    @supports (padding-bottom: env(safe-area-inset-bottom)) {
        .pb-safe {
            padding-bottom: env(safe-area-inset-bottom);
        }
    }
</style>