<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auth System Pro | Portfolio</title>
    <link rel="stylesheet" href="\assets\css\output.css">

</head>

<body
    class="bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200 font-sans transition-colors duration-300 relative">
    <?php require_once __DIR__ . '/include/header.php'; ?>


    <section class="bg-blue-600 dark:bg-blue-800 text-white py-20 text-center transition-colors duration-300">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">Auth System Pro</h1>
        <p class="text-xl md:text-2xl mb-6">Enterprise-Level Authentication System</p>
        <img src="assets/images/cheatsheet.png" alt="Auth System Pro Cheat Sheet" width="89" height="45"
            class="mx-auto rounded shadow-lg max-w-4xl dark:opacity-90 transition-opacity w-[90%] inline-block">
    </section>

    <section class="max-w-2xl mx-auto my-10 space-y-6 w-[90%]">
        <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-700">
            <h2 class="text-xl font-black mb-4 dark:text-white uppercase tracking-tight">About the Project</h2>
            <p class="text-gray-600 dark:text-gray-400 leading-relaxed text-sm md:text-base">
                Auth System Pro is a modern, secure, full-stack authentication system with OTP 2FA, RBAC, adaptive
                authentication, secure sessions, and polished dashboards for users and admins. Designed to showcase
                professional full-stack development and enterprise-level security practices.
            </p>

            <div class="mt-6 p-4 bg-gray-50 dark:bg-gray-900/50 rounded-2xl border-l-4 border-green-500">
                <p class="text-[10px] font-black uppercase text-gray-400 tracking-widest mb-1">Note</p>
                <p class="text-xs italic text-gray-500 dark:text-gray-400">
                    This project is not AI-generated. AI was utilized as a specialized tool for learning, image
                    creation, code review,
                    and concept clarification. I maintain full ownership and can explain every single line of logic
                    within this architecture.
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div
                class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm">
                <span class="text-[10px] font-black uppercase tracking-widest text-green-500 block mb-1">Admin
                    Email</span>
                <span class="font-mono text-sm font-bold dark:text-gray-200">admin@email.com</span>
            </div>
            <div
                class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm">
                <span class="text-[10px] font-black uppercase tracking-widest text-green-500 block mb-1">Password</span>
                <span class="font-mono text-sm font-bold dark:text-gray-200">123456789</span>
            </div>
        </div>
    </section>


    <section class="py-16 px-6 md:px-20 bg-white dark:bg-gray-800 transition-colors duration-300">
        <h2 class="text-3xl font-bold mb-12 text-center">Key Features</h2>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8  max-w-7xl mx-auto">
            <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded shadow hover:shadow-lg transition-shadow">
                <h3 class="text-xl font-semibold mb-2">RBAC</h3>
                <p class="dark:text-gray-300">Role-Based Access Control ensures proper access for users and admins.</p>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded shadow hover:shadow-lg transition-shadow">
                <h3 class="text-xl font-semibold mb-2">2FA / OTP</h3>
                <p class="dark:text-gray-300">Two-factor authentication for added login security and adaptive
                    verification.</p>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded shadow hover:shadow-lg transition-shadow">
                <h3 class="text-xl font-semibold mb-2">User Dashboard</h3>
                <p class="dark:text-gray-300">Edit profile, change password, view secure information in a responsive UI.
                </p>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded shadow hover:shadow-lg transition-shadow">
                <h3 class="text-xl font-semibold mb-2">Admin Dashboard</h3>
                <p class="dark:text-gray-300">Manage users, reset passwords, update roles, and view login logs securely.
                </p>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded shadow hover:shadow-lg transition-shadow">
                <h3 class="text-xl font-semibold mb-2">Architecture & Security</h3>
                <p class="dark:text-gray-300">Secure sessions, hashed passwords, adaptive auth, and full system
                    architecture included.</p>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded shadow hover:shadow-lg transition-shadow">
                <h3 class="text-xl font-semibold mb-2">Core Stack</h3>
                <p class="dark:text-gray-300">
                    PHP 8.3.29 core with PSR-4 autoloading, Argon2id Hash Middleware, and strict session management.
                </p>
            </div>

        </div>
    </section>

    <section class="py-16 px-6 md:px-20 bg-gray-100 dark:bg-gray-900 transition-colors duration-300">
        <h2 class="text-3xl font-bold mb-12 text-center">Screenshots</h2>
        <div class="grid md:grid-cols-2 gap-8 max-w-8xl mx-auto cursor-pointer">
            <img src="assets/images/register.png" alt="Register Page"
                class="rounded shadow-lg hover:scale-105 transition-transform duration-300 dark:opacity-90 hover:dark:opacity-100 will-change"
                loading="lazy">
            <img src="assets/images/login.png" alt="Login Page"
                class="rounded shadow-lg hover:scale-105 transition-transform duration-300 dark:opacity-90 hover:dark:opacity-100"
                loading="lazy">
            <img src="assets/images/otp.png" alt="OTP Verification"
                class="rounded shadow-lg hover:scale-105 transition-transform duration-300 dark:opacity-90 hover:dark:opacity-100"
                loading="lazy">
            <img src="assets/images/user.png" alt="User Dashboard"
                class="rounded shadow-lg hover:scale-105 transition-transform duration-300 dark:opacity-90 hover:dark:opacity-100"
                loading="lazy">
            <img src="assets/images/user-edit.png" alt="User Edit"
                class="rounded shadow-lg hover:scale-105 transition-transform duration-300 dark:opacity-90 hover:dark:opacity-100"
                loading="lazy">
            <img src="assets/images/admin.png" alt="Admin Dashboard"
                class="rounded shadow-lg hover:scale-105 transition-transform duration-300 dark:opacity-90 hover:dark:opacity-100"
                loading="lazy">
        </div>
    </section>

    <section class="py-16 px-6 md:px-20 bg-white dark:bg-gray-800 transition-colors duration-300">
        <h2 class="text-3xl font-bold mb-8 text-center">Architecture Diagram</h2>
        <div class="flex justify-center">
            <img src="assets/images/ArchitectureDiagram.png" alt="Architecture Diagram"
                class="w-full rounded shadow-lg max-w-4xl hover:scale-105 transition-transform duration-300 dark:opacity-90"
                loading="lazy">
        </div>
    </section>

    <section class="py-16 px-6 md:px-20 bg-gray-100 dark:bg-gray-900 transition-colors duration-300">
        <h2 class="text-3xl font-bold mb-8 text-center">Demo Flow</h2>
        <ol class="max-w-4xl mx-auto space-y-4 list-decimal list-inside text-lg dark:text-gray-300">
            <li>Landing → Registration → Login → OTP Verification</li>
            <li>Role-based Dashboard Redirect (User or Admin)</li>
            <li>User Dashboard: Edit Profile, Change Password</li>
            <li>Admin Dashboard: User Management & Login Logs</li>
            <li>Adaptive Authentication triggers OTP for new devices/IPs</li>
        </ol>
    </section>

    <section
        class="py-16 px-6 md:px-20 bg-blue-600 dark:bg-blue-800 text-white text-center transition-colors duration-300">
        <h2 class="text-3xl font-bold mb-6">Check It Out</h2>
        <p class="mb-6">Explore the code or run the demo to see the full system in action.</p>
        <div class="flex flex-col sm:flex-row justify-center gap-4 mb-9">
            <a href="https://github.com/digi-booster/Auth-System-Pro" target="_blank"
                class="bg-white dark:bg-gray-900 text-blue-600 dark:text-blue-400 px-6 py-3 rounded font-semibold hover:bg-gray-200 dark:hover:bg-gray-800 transition hover:-translate-y-1 shadow-md">View
                Code on GitHub</a>
            <a href="public/register.php" target="_blank"
                class="bg-white dark:bg-gray-900 text-blue-600 dark:text-blue-400 px-6 py-3 rounded font-semibold hover:bg-gray-200 dark:hover:bg-gray-800 transition hover:-translate-y-1 shadow-md">Run
                Live Demo</a>
        </div>
    </section>

    <?php require_once __DIR__ . '/include/footer.php'; ?>

</body>

</html>