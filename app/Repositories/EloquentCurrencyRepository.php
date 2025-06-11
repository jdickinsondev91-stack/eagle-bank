<?php 

namespace App\Repositories;

use App\Models\Currency;
use App\Repositories\Interfaces\CurrencyRepository;

class EloquentCurrencyRepository implements CurrencyRepository
{
    public function getByCode(string $code): Currency
    {
        return Currency::where('code', $code)->firstOrFail();
    }
}