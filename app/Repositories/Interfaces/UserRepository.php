<?php

namespace App\Repositories\Interfaces;

use App\Models\User;

interface UserRepository
{
    public function getById(string $id): User;
}