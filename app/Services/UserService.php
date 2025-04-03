<?php

namespace App\Services;

use App\Repositories\Interfaces\UserRepositoryInterface;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function updateUser($id, array $data)
    {
        $user = $this->userRepository->findById($id);

        if (!$user) {
            return null;
        }

        $this->userRepository->updateUser($user, $data);

        return $user;
    }
}
