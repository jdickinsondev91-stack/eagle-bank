<?php 

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AccountResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'accountNumber' => $this->id,
            'sortCode' => $this->sort_code,
            'name' => $this->name,
            'accountType' => $this->accountType->slug,
            'balance' => $this->balance,
            'currency' => $this->currency->code,
            'createdTimestamp' => $this->created_at->format('Y-m-d\TH:i:s\Z'),
            'updatedTimestamp' => $this->updated_at->format('Y-m-d\TH:i:s\Z')
        ];
    }
}