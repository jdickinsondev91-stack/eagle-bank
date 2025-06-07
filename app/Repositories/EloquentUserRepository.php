<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepository;

class EloquentUserRepository implements UserRepository
{
    public function getById(string $id): User
    {
        return User::with('currentAddress')->findOrFail($id);
    }
}