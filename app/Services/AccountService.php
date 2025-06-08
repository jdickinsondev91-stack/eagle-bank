<?php 

namespace App\Services;

use App\Repositories\Interfaces\AccountRepository;

class AccountService 
{
    public function __construct(
        private AccountRepository $accountRepository
    ) {}
}