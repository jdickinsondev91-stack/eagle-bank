<?php 

namespace App\Repositories\Interfaces;

use App\DTOs\TransactionDTO;
use App\Models\Transaction;

interface TransactionRepository
{
    public function create(TransactionDTO $transaction): Transaction;
}