<?php 

namespace App\Repositories\Interfaces;

use App\Models\TransactionType;

interface TransactionTypeRepository 
{
    public function getBySlug(string $slug): TransactionType;
}