<?php

use App\Providers\AuthServiceProvider;
use App\Providers\RepositoryServiceProvider;
use App\Providers\RouteServiceProvider;

return [
    App\Providers\AppServiceProvider::class,
    RepositoryServiceProvider::class,
    RouteServiceProvider::class,
    AuthServiceProvider::class,
];
