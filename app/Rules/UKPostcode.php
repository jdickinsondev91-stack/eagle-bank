<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UKPostcode implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $pattern = '/^
            (GIR\s?0AA|
            (?:[A-PR-UWYZ][0-9]{1,2}|
            [A-PR-UWYZ][A-HK-Y][0-9]{1,2}|
            [A-PR-UWYZ][0-9][A-HJKPSTUW]|
            [A-PR-UWYZ][A-HK-Y][0-9][ABEHMNPRVWXY])
            \s?[0-9][ABD-HJLNP-UW-Z]{2})$/ix';

        if (!preg_match($pattern, trim ($value))) {
            $fail("The {$attribute} must be a valid UK postcode.");
        }
    }
}
