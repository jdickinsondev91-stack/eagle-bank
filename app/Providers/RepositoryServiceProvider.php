<?php

namespace App\Providers;

use App\Repositories\EloquentAccountRepository;
use App\Repositories\EloquentAccountTypeRepository;
use App\Repositories\EloquentAddressRepository;
use App\Repositories\EloquentCurrencyRepository;
use App\Repositories\EloquentTransactionRepository;
use App\Repositories\EloquentTransactionTypeRepository;
use App\Repositories\EloquentUserRepository;
use App\Repositories\Interfaces\AccountRepository;
use App\Repositories\Interfaces\AccountTypeRepository;
use App\Repositories\Interfaces\AddressRepository;
use App\Repositories\Interfaces\CurrencyRepository;
use App\Repositories\Interfaces\TransactionRepository;
use App\Repositories\Interfaces\TransactionTypeRepository;
use App\Repositories\Interfaces\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(UserRepository::class, EloquentUserRepository::class);
        $this->app->bind(AddressRepository::class, EloquentAddressRepository::class);
        $this->app->bind(AccountRepository::class, EloquentAccountRepository::class);
        $this->app->bind(AccountTypeRepository::class, EloquentAccountTypeRepository::class);
        $this->app->bind(TransactionTypeRepository::class, EloquentTransactionTypeRepository::class);
        $this->app->bind(TransactionRepository::class, EloquentTransactionRepository::class);
        $this->app->bind(CurrencyRepository::class, EloquentCurrencyRepository::class);
    }
}
