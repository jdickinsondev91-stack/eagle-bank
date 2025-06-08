<?php

namespace App\Providers;

use App\Repositories\EloquentAccountRepository;
use App\Repositories\EloquentAddressRepository;
use App\Repositories\EloquentUserRepository;
use App\Repositories\Interfaces\AccountRepository;
use App\Repositories\Interfaces\AddressRepository;
use App\Repositories\Interfaces\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(UserRepository::class, EloquentUserRepository::class);
        $this->app->bind(AddressRepository::class, EloquentAddressRepository::class);
        $this->app->bind(AccountRepository::class, EloquentAccountRepository::class);
    }
}
