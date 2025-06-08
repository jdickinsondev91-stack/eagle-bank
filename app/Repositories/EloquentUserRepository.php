<?php

namespace App\Repositories;

use App\DTOs\UserDTO;
use App\Models\User;
use App\Repositories\Interfaces\UserRepository;

class EloquentUserRepository implements UserRepository
{
    public function getById(string $id): User
    {
        return User::with('currentAddress')->findOrFail($id);
    }

    public function create(UserDTO $user): User
    {
        return User::create([
            'name' => $user->name,
            'phone_number' => $user->phoneNumber,
            'email' => $user->email
        ]);
    }
}