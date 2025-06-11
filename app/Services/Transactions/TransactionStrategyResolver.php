<?php 

namespace App\Services\Transactions;

use App\Services\Transactions\Strategies\DepositStrategy;
use App\Services\Transactions\Strategies\TransactionStrategy;
use InvalidArgumentException;

class TransactionStrategyResolver
{
    public function __construct(
        private DepositStrategy $depositStrategy
    ) {}
    public function resolve(string $type): TransactionStrategy
    {
        return match ($type) {
            'deposit' =>  $this->depositStrategy,
            default => throw new InvalidArgumentException("Unsupported transaction type: {$type}")
        };
    }

}