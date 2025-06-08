<?php 

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Services\AccountService;

class AccountController extends Controller
{
    public function __construct(
        private AccountService $accountService
    ) {}
}