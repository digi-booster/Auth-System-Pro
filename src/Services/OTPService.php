<?php

declare(strict_types=1);

namespace App\Services;
use PDO;
final readonly class OTPService
{
    public function __construct(
        private PDO $pdo,
    ) {
    }
    public function generate(): string
    {
        return (string) random_int(min: 100000, max: 999999);
    }

    public function createToken(int $userId, string $otp, string $action): bool
    {

        $this->pdo->prepare(query: "UPDATE password_reset_tokens 
        SET expires_at = NOW(6) WHERE user_id = ? AND type = ? AND consumed_at IS NULL")
            ->execute(params: [$userId, $action]);

        $hash = hash(algo: 'sha256', data: $otp);

        $sql = "INSERT INTO password_reset_tokens (user_id, token_hash, type, expires_at) 
        VALUES (?, UNHEX(?), ?, DATE_ADD(NOW(6), INTERVAL 10 MINUTE) )";
        return $this->pdo->prepare(query: $sql)->execute(params: [$userId, $hash, $action]);

    }

    public function verify(int $userId, string $otp, string $action): bool
    {
        $stmt = $this->pdo->prepare(query: "SELECT id, HEX(token_hash) as token_hash FROM password_reset_tokens 
        WHERE user_id = ? AND type = ? and expires_at > NOW(6) AND consumed_at IS NULL 
        ORDER BY created_at DESC LIMIT 1");

        $stmt->execute(params: [$userId, $action]);

        $token = $stmt->fetch();
        if (
            $token && 
            hash_equals(known_string: strtolower(string: $token['token_hash']),
                user_string: hash(algo: 'sha256',data: $otp)
            )
        ) {
            $this->pdo->prepare(query: "UPDATE password_reset_tokens SET consumed_at = NOW(6) 
            WHERE id = ?")->execute(params: [$token['id']]);
            return true;
        }
        return false;
    }
}