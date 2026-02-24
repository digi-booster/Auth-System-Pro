<?php

declare(strict_types=1);

namespace App\Controllers;
use App\Models\User;


class RegisterController
{
    public function __construct(
        private User $userModel,
    ) {
    }

    public function regsiter(array $data): array
    {
        $data = array_map(callback: 'trim', array: $data);

        $username = trim(string: $data['username']) ?? '';

        $email = filter_var(value: trim(string: $data['email']), filter: FILTER_VALIDATE_EMAIL) ?? '';

        $password = trim(string: $data['password']) ?? '';

        if (empty($username) || empty($email) || empty($password)) {
            return [
                'success' => false,
                'message' => "Input(s) can't be empty",
            ];
        }

        if ($this->userModel->findByEmail(email: $email)) {
            return [
                'success' => false,
                'message' => 'Email already registered with us',
            ];
        }
        try {
            $this->userModel->create(username: $username, email: $email, password: $password);

            return [
                'success' => true,
                'message' => 'User registered successfully',
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }
}