<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Interfaces\UserRepository;

class UserService
{
    public function __construct(
        private UserRepository $userRepository
    ) {}

    public function getById(string $id): User
    {
        return $this->userRepository->getById($id);
    }
}