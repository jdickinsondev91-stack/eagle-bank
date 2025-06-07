<?php

namespace App\Providers;

use App\Repositories\EloquentUserRepository;
use App\Repositories\Interfaces\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(UserRepository::class, EloquentUserRepository::class);
    }
}
