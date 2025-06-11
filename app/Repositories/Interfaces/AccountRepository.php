<?php 

namespace App\Repositories\Interfaces;

use App\DTOs\AccountDTO;
use App\Models\Account;
use Illuminate\Database\Eloquent\Collection;

interface AccountRepository
{
    public function getById(string $accountId): Account;

    public function create(AccountDTO $account): Account;

    public function update(Account $account, AccountDTO $accountDTO): Account;

    public function getByUserId(string $userId): Collection;

    public function delete(string $accountId): bool;

    public function updateBalance(Account $account, int $newBalance): Account;
}