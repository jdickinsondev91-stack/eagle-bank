<?php

use App\Http\Controllers\V1\AccountController;
use App\Http\Controllers\V1\AuthController;
use App\Http\Controllers\V1\TransactionController;
use App\Http\Controllers\V1\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    
    // Public Auth routes
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);

    // Protected routes
    Route::middleware('auth:api')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);

        // Users CRUD
        Route::apiResource('users', UserController::class);

        //Accounts CRUD
        Route::apiResource('accounts', AccountController::class);

        //Transactions CRUD
        Route::apiResource('/accounts/{accountId}/transactions', TransactionController::class);
    });
});