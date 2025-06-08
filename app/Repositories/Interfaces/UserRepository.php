<?php

namespace App\Repositories\Interfaces;

use App\DTOs\UserDTO;
use App\Models\User;

interface UserRepository
{
    public function getById(string $id): User;

    public function create(UserDTO $user): User;

    public function update(User $user, UserDTO $userDTO): User;

    public function getByIdWithAccounts(string $id): User;

    public function delete(User $user): bool;
}