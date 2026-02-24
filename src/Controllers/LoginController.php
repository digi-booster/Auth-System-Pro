<?php

declare(strict_types=1);

namespace App\Controllers;
use App\Models\User;
use App\Services\OTPService;
use PDO;
readonly class LoginController
{
    public function __construct(
        private User $userModel,
        private PDO $pdo,
        private OTPService $otp,
    ) {
    }

    public function login(string $email, string $password): array
    {
        $user = $this->userModel->findByEmail(email: $email);

        if (!$user || !password_verify(password: $password, hash: $user['password_hash'])) {

            if ($user) {
                $this->audit(userId: (int) $user['id'], status: 'fail');
            }
            return [
                'success' => false,
                'message' => 'Invalid email or password',
            ];
        }

        $currIp = inet_pton(ip: $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1');
        $currDev = substr(string: $_SERVER['HTTP_USER_AGENT'], offset: 0, length: 512);

        $last = $this->pdo->prepare(query: "SELECT ip_address, device_info FROM login_logs 
        WHERE user_id = ? AND status = 'success' ORDER BY created_at DESC LIMIT 1");
        $last->execute(params: [$user['id']]);
        $history = $last->fetch();

        $isSus = (!$history || $history['ip_address'] !== $currIp || $history['device_info'] !== $currDev);

        if ($isSus) {

            $code = $this->otp->generate();
            $this->otp->createToken(userId: $user['id'], otp: $code, action: 'otp');

            if (session_status() === PHP_SESSION_NONE) {
                session_start();
                $_SESSION['demo_otp'] = $code;
                $_SESSION['temp_auth_id'] = $user['id'];
                $_SESSION['temp_auth_role'] = $user['role'];
                return ['success' => true, 'step_up' => true];
            }
        }

        unset($user['password_hash']);
        unset($_SESSION['temp_auth_id']);
        $this->finalizeLogin(userId: $user['id'], role: $user['role']);
        return [
            'success' => true,
            'step_up' => false,
        ];

    }

    public function finalizeLogin(int $userId, string $role): void
    {
        if (session_start() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION['user_id'] = $userId;
        $_SESSION['user_role'] = $role;

        $this->audit(userId: $userId, status: 'success');
    }

    public function audit(int $userId, string $status): void
    {
        $binaryIP = inet_pton(ip: $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1');
        $device = substr(string: $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown', offset: 0, length: 512);

        $this->pdo->prepare(query: "INSERT INTO login_logs (user_id, ip_address, device_info, status) VALUES (?, ?, ?, ?)")
            ->execute(params: [$userId, $binaryIP, $device, $status]);
    }
}