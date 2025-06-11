<?php 

namespace App\Services\Transactions\Strategies;

use App\DTOs\TransactionDTO;
use App\Exceptions\InsufficientFundsException;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class WithdrawStrategy extends BaseTransactionStrategy implements TransactionStrategy
{
    public function handle(TransactionDTO $transactionDTO): Transaction
    {
        $account = $this->accountService->getById($transactionDTO->accountId);
        $transactionAmount = $this->convertToInt($transactionDTO->amount, $account->currency->decimal_places);

        if ($transactionAmount > $account->balance) {
            throw new InsufficientFundsException();
        }

        return DB::transaction(function () use ($transactionDTO, $account, $transactionAmount) {
            
            $transactionType = $this->transactionTypeRepository->getBySlug($transactionDTO->transactionTypeSlug);

            $account = $this->accountService->updateBalance($account, ($account->balance - $transactionAmount));

            $transactionDTO->amount = $transactionAmount;
            $transactionDTO->transactionTypeId = $transactionType->id;

            return $this->createTransaction($transactionDTO);
        });
    }
}