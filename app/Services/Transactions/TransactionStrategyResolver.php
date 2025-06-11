<?php 

namespace App\Services\Transactions;

use App\Services\Transactions\Strategies\DepositStrategy;
use App\Services\Transactions\Strategies\TransactionStrategy;
use App\Services\Transactions\Strategies\WithdrawStrategy;
use InvalidArgumentException;

class TransactionStrategyResolver
{
    public function __construct(
        private DepositStrategy $depositStrategy,
        private WithdrawStrategy $withdrawStrategy
    ) {}
    public function resolve(string $type): TransactionStrategy
    {
        return match ($type) {
            'deposit' =>  $this->depositStrategy,
            'withdraw' => $this->withdrawStrategy,
            default => throw new InvalidArgumentException("Unsupported transaction type: {$type}")
        };
    }

}