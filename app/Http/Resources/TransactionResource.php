<?php 

namespace App\Http\Resources;

use App\Traits\HasMoney;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    use HasMoney;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'amount' => $this->convertToFloat($this->amount, $this->currency->decimal_places),
            'currency' => $this->currency->code,
            'type' => $this->transactionType->slug,
            'reference' => $this->reference,
            'userId' => $this->account->user->id,
            'createdTimestamp' => $this->created_at->format('Y-m-d\TH:i:s\Z'),
            'updatedTimestamp' => $this->updated_at->format('Y-m-d\TH:i:s\Z')
        ];
    }
}