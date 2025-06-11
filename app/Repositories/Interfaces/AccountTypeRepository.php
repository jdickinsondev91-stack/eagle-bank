<?php 

namespace App\Repositories\Interfaces;

use App\Models\AccountType;

interface AccountTypeRepository
{
    public function getBySlug(string $slug): AccountType;
}