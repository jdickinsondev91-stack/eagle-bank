<?php 

namespace App\Repositories\Interfaces;

use App\Models\Currency;

interface CurrencyRepository 
{
    public function getByCode(string $code): Currency;
}