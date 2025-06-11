<?php 

namespace App\Repositories;

use App\Models\TransactionType;
use App\Repositories\Interfaces\TransactionTypeRepository;

class EloquentTransactionTypeRepository implements TransactionTypeRepository
{
    public function getBySlug(string $slug): TransactionType
    {
        return TransactionType::where('slug', $slug)->firstOrFail();
    }
}