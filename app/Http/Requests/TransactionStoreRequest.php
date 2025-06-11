<?php 

namespace App\Http\Requests;

use App\Rules\Slug;
use Illuminate\Foundation\Http\FormRequest;

class TransactionStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'amount' => 'required|numeric',
            'currency' => 'required|string',
            'reference' => 'required|string',
            'type' => ['required', new Slug()]
        ];
    }
}