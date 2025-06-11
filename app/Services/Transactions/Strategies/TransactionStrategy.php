<?php 

namespace App\Services\Transactions\Strategies;

use App\DTOs\TransactionDTO;
use App\Models\Transaction;

interface TransactionStrategy
{
    public function handle(TransactionDTO $transactionDTO): Transaction;
}