<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->first_name . ' ' . $this->last_name,
            'address' => [
                'line1' => $this->currentAddress->line_1,
                'line2' => $this->currentAddress->line_2,
                'line3' => $this->currentAddress->line_3,
                'town' => $this->currentAddress->town,
                'county' => $this->currentAddress->county,
                'postcode' => $this->currentAddress->postcode
            ],
            'phoneNumber' => $this->phone_number,
            'email' => $this->email,
            'createdTimestamp' => $this->created_at->format('Y-m-d\TH:i:s.u'),
            'updatedTimestamp' => $this->updated_at->format('Y-m-d\TH:i:s.u')
        ];
    }
}
