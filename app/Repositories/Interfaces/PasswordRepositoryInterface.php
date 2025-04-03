<?php

namespace App\Repositories\Interfaces;

interface PasswordRepositoryInterface
{
    public function sendResetLink(string $email);
    public function resetPassword(array $credentials, callable $callback);
}
