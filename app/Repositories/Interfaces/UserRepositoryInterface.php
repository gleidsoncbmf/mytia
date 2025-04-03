<?php

namespace App\Repositories\Interfaces;

interface UserRepositoryInterface
{
    public function findById($id);
    public function updateUser($user, array $data);
}
