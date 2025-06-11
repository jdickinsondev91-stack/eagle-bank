<?php 

namespace App\Services\Transactions\Strategies;

use App\DTOs\TransactionDTO;
use App\Models\Transaction;
use App\Repositories\Interfaces\CurrencyRepository;
use App\Repositories\Interfaces\TransactionRepository;
use App\Repositories\Interfaces\TransactionTypeRepository;
use App\Services\Accounts\AccountService;
use App\Traits\HasMoney;

abstract class BaseTransactionStrategy
{
    use HasMoney;

    public function __construct(
        protected TransactionTypeRepository $transactionTypeRepository,
        protected TransactionRepository $transactionRepository,
        protected CurrencyRepository $currencyRepository,
        protected AccountService $accountService
    ) {}

    protected function createTransaction(TransactionDTO $transactionDTO): Transaction
    {
        return $this->transactionRepository->create($transactionDTO);
    }
}