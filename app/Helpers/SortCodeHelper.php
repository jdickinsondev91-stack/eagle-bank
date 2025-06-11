<?php 

namespace App\Helpers;

/**
 * This is just for the purpose of the test.
 * I'm aware that there is a BACS directory available that would be 
 * able to provide this data
 */
class SortCodeHelper 
{
    public static function generate(): string 
    {
        $parts = [
            str_pad(random_int(0, 99), 2, '0', STR_PAD_LEFT),
            str_pad(random_int(0, 99), 2, '0', STR_PAD_LEFT),
            str_pad(random_int(0, 99), 2, '0', STR_PAD_LEFT),
        ];

        return implode('-', $parts);
    }
}