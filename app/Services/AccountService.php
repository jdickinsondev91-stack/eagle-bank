<?php 

namespace App\Services;

use App\DTOs\AccountDTO;
use App\Helpers\SortCodeHelper;
use App\Models\Account;
use App\Models\Currency;
use App\Repositories\Interfaces\AccountRepository;
use App\Repositories\Interfaces\AccountTypeRepository;
use App\Repositories\Interfaces\CurrencyRepository;
use Illuminate\Database\Eloquent\Collection;

class AccountService 
{
    public function __construct(
        private AccountRepository $accountRepository,
        private AccountTypeRepository $accountTypeRepository,
        private CurrencyRepository $currencyRepository,
    ) {}

    public function getById(string $accountId): Account
    {
        return $this->accountRepository->getById($accountId);
    }

    public function getByUser(string $userId): Collection
    {
        return $this->accountRepository->getByUserId($userId);
    }

    public function deleteAccount(string $accountId): bool 
    {
        return $this->accountRepository->delete($accountId);
    }

    public function createAccount(AccountDTO $account, string $accountTypeSlug, string $userId): Account
    {
        $accountType = $this->accountTypeRepository->getBySlug($accountTypeSlug);
        $currency = $this->currencyRepository->getByCode(Currency::DEFAULT_CURRENCY_CODE);

        $account->accountTypeId = $accountType->id;
        $account->userId = $userId;
        $account->currencyId = $currency->id;
        $account->sortCode = SortCodeHelper::generate();

        return $this->accountRepository->create($account);
    }

    public function updateAccount(AccountDTO $accountDTO, string $accountId): Account
    {
        $account = $this->accountRepository->getById($accountId);
        return $this->accountRepository->update($account, $accountDTO);
    }
}