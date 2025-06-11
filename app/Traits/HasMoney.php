<?php 

namespace App\Traits;

trait HasMoney 
{
    public function convertToInt(float $amount, int $decimalPlaces): int 
    {
        //+2 to the decimal places to increase accuracy
        $amountString = number_format($amount, $decimalPlaces + 2, '.', '');
        
        //same as 10 * $decimalPlaces
        $multiplier = bcpow('10', (string) $decimalPlaces);

        $value = bcmul($amountString, $multiplier, 0);

        return (int) $value;
    }

    public function convertToFloat(int $amount, int $decimalPlaces): float 
    {
        $multiplier = bcpow('10', (string) $decimalPlaces);

        return (float) bcdiv((string) $amount, $multiplier, $decimalPlaces);
    }

    /** For dealing with cryptocurrencies, it might be handy to remove any rounding */
    public function convertToString(int $amount, int $decimalPlaces): string 
    {
        $multiplier = bcpow('10', (string) $decimalPlaces);

        return bcdiv((string) $amount, $multiplier, $decimalPlaces);
    }
}