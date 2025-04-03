<?php

namespace App\Repositories;

use App\Repositories\Interfaces\PasswordRepositoryInterface;
use Illuminate\Support\Facades\Password;

class PasswordRepository implements PasswordRepositoryInterface
{
    public function sendResetLink(string $email)
    {
        return Password::sendResetLink(['email' => $email]);
    }

    public function resetPassword(array $credentials, callable $callback)
    {
        return Password::reset($credentials, $callback);
    }
}
