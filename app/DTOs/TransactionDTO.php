<?php 

namespace App\DTOs;

class TransactionDTO 
{
    public ?string $accountId;

    public ?string $transactionTypeSlug;

    public ?string $transactionTypeId;

    public string $currencyCode;

    public float $amount = 0;

    public string $reference;

    public static function createFromRequestArray(array $data): self 
    {
        $dto = new self();
        $dto->accountId = $data['account_id'] ?? null;
        $dto->transactionTypeSlug = $data['type'] ?? null;
        $dto->transactionTypeId = $data['transaction_type_Id'] ?? null;
        $dto->currencyCode = $data['currency'];
        $dto->amount = $data['amount'];
        $dto->reference = $data['reference'];

        return $dto;
    }
}