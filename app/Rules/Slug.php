<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Slug implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $pattern = '/^[a-z0-9]+(?:[_-][a-z0-9]+)*$/';

        if (!preg_match($pattern, $value)) {
            $fail("The {$attribute} must be a valid slug.");
        }
    }
}
