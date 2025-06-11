<?php 

namespace App\Services\Transactions\Strategies;

use App\DTOs\TransactionDTO;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class DepositStrategy extends BaseTransactionStrategy implements TransactionStrategy
{
    public function handle(TransactionDTO $transactionDTO): Transaction
    {
        return DB::transaction(function () use ($transactionDTO){

            $account = $this->accountService->getById($transactionDTO->accountId);

            //No N+1 query here because currency has been eager loaded
            $transactionAmount = $this->convertToInt($transactionDTO->amount, $account->currency->decimal_places);
            
            $account = $this->accountService->updateBalance($account, ($account->balance + $transactionAmount));

            $transactionType = $this->transactionTypeRepository->getBySlug($transactionDTO->transactionTypeSlug);

            $transactionDTO->amount = $transactionAmount;
            $transactionDTO->transactionTypeId = $transactionType->id;

            return $this->createTransaction($transactionDTO);
        });
    }
}