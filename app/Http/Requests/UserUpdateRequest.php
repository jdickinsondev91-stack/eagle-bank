<?php

namespace App\Http\Requests;

use App\Rules\I164PhoneNumber;
use App\Rules\UKPostcode;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'address' => 'required|array',
            'address.line1' => 'required|string|max:255',
            'address.town' => 'required|string|max:255',
            'address.county' => 'required|string|max:255',
            'address.postcode' => ['required', new UKPostcode()],
            'phoneNumber' => ['required', new I164PhoneNumber()], 
            'email' => 'required|email|max:255',
        ];
    }
}
