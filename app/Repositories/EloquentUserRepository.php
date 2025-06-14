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

    public function update(User $user, UserDTO $userDTO): User
    {
        $user->update([
            'name' => $userDTO->name,
            'phone_number' => $userDTO->phoneNumber,
            'email' => $userDTO->email
        ]);

        return $user->fresh(['currentAddress']);
    }

    public function getByIdWithAccounts(string $id): User
    {
        return User::with('accounts')->findOrFail($id);
    }

    public function delete(User $user): bool 
    {
        $user->addresses()->delete();
        return $user->delete();
    }

    public function getByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }
}