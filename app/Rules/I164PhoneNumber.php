<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class I164PhoneNumber implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match('/^\+[1-9]\d{1,14}$/', $value)) {
            $fail("The {$attribute} must be a valid phone number in E.164 format.");
        }
    }
}
