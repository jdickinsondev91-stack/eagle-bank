<?php 

namespace App\Repositories;

use App\DTOs\TransactionDTO;
use App\Models\Transaction;
use App\Repositories\Interfaces\TransactionRepository;

class EloquentTransactionRepository implements TransactionRepository
{
    public function create(TransactionDTO $transaction): Transaction
    {
        return Transaction::create([
            'account_id' => $transaction->accountId,
            'transaction_type_id' => $transaction->transactionTypeId,
            'reference' => $transaction->reference,
            'amount' => $transaction->amount,
        ]);
    }
}