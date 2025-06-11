<?php

namespace App\Repositories;

use App\Models\AccountType;
use App\Repositories\Interfaces\AccountTypeRepository;

class EloquentAccountTypeRepository implements AccountTypeRepository
{
    public function getBySlug(string $slug): AccountType
    {
        return AccountType::where('slug', $slug)->firstOrFail();
    }
}