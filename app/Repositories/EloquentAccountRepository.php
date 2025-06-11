<?php 

namespace App\Repositories;

use App\DTOs\AccountDTO;
use App\Models\Account;
use App\Repositories\Interfaces\AccountRepository;
use Illuminate\Database\Eloquent\Collection;

class EloquentAccountRepository implements AccountRepository
{
    public function create(AccountDTO $account): Account
    {
        $account = Account::create([
            'name' => $account->name,
            'sort_code' => $account->sortCode,
            'account_type_id' => $account->accountTypeId,
            'currency_id' => $account->currencyId,
            'balance' => $account->balance,
            'open' => $account->open
        ]);

        return $account->load(['currency', 'accountType']);
    }

    public function update(Account $account, AccountDTO $accountDTO): Account
    {
        $account-> update([
            'name' => $accountDTO->name,
            'sort_code' => $accountDTO->sortCode,
            'account_type_id' => $accountDTO->accountTypeId,
            'currency_id' => $accountDTO->currencyId,
            'balance' => $accountDTO->balance,
            'open' => $accountDTO->open
        ]);

        return $account->fresh(['currency', 'accountType']);
    }

    public function delete(string $accountId): bool
    {
        //Comment on this - Whilst the account is being deleted we might need to
        //Delete the associated Transactions however this wasn't part of the task so
        //Leaving this for now
        return Account::where('id', $accountId)->delete();
    }

    public function getById(string $accountId): Account
    {
        return Account::with(['currency', 'accountType'])->findOrFail($accountId);
    }

    public function getByUserId(string $userId): Collection
    {
        return Account::with(['currency', 'accountType'])->where('user_id', $userId)->get();
    }

    public function updateBalance(Account $account, int $newBalance): Account
    {
        $account->update(['balance' => $newBalance]);

        return $account->fresh(['currency', 'accountType']);
    }
}