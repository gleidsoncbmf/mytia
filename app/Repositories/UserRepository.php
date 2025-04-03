<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function findById($id)
    {
        return User::find($id);
    }

    public function updateUser($user, array $data)
    {
        return $user->update($data);
    }
}
