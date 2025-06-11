<?php 

namespace App\Services\Transactions;

use App\DTOs\TransactionDTO;
use App\Models\Transaction;

class TransactionService 
{
    public function __construct(
        private TransactionStrategyResolver $transactionStrategyResolver
    ) {}

    public function createTransaction(TransactionDTO $transactionDTO, string $accountId): Transaction
    {
        $transactionDTO->accountId = $accountId;
        
        $strategy = $this->transactionStrategyResolver->resolve($transactionDTO->transactionTypeSlug);

        return $strategy->handle($transactionDTO);
    }
}