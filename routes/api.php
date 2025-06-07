<?php

use App\Http\Controllers\V1\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::apiResource('users', UserController::class);
});