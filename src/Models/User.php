<?php

declare(strict_types=1);
namespace App\Models;

use PDO;
use Exception;
use PDOException;
final readonly class User
{
    public function __construct(
        private PDO $pdo
    ) {
    }

    public function create(string $username, string $email, string $password): bool
    {
        try {
            $hash = password_hash(password: $password, algo: PASSWORD_ARGON2ID);
            $sql = "INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)";

            $stmt = $this->pdo->prepare(query: $sql);
            return $stmt->execute(params: [$username, $email, $hash]);

        } catch (PDOException $e) {
            error_log(message: "Database error during registration " . $e->getMessage());
            throw new Exception(message: "Registration failed, please try again later");

        }
    }


    public function findByEmail(string $email): ?array
    {
        $sql = "SELECT id, username, email, role, is_verified, password_hash FROM users WHERE email = ?";
        $stmt = $this->pdo->prepare(query: $sql);
        $stmt->execute(params: [$email]);

        return $stmt->fetch() ?: null;

    }

}