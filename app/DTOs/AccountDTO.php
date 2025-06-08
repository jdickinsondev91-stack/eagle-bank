<?php 

namespace App\DTOs;

class AccountDTO 
{
    public ?string $id;

    public string $userId;

    public ?string $accountTypeId;

    public ?string $currencyId; 

    public string $sortCode;

    public string $name;

    public int $balance;

    public bool $open;

    public static function create(array $data): self
    {
        $dto = new self();

        $dto->id = $data['id'] ?? null;
        $dto->userId = $data['userId'];
        $dto->accountTypeId = $data['account_type_id'] ?? null;
        $dto->currencyId = $data['currency_id'] ?? null;
        $dto->sortCode = $data['sort_code'];
        $dto->name = $data['name'];
        $dto->balance = $data['balance'];
        $dto->open = $data['open'] ?? true;

        return $dto;
    }
}