<?php 

namespace App\Repositories;

use App\DTOs\AddressDTO;
use App\Models\Address;
use App\Repositories\Interfaces\AddressRepository;

class EloquentAddressRepository implements AddressRepository 
{
    public function create(AddressDTO $address, string $userId): Address
    {
        return Address::create([
            'line_1' => $address->line1,
            'line_2' => $address->line2,
            'line_3' => $address->line3,
            'town' => $address->town,
            'county' => $address->county,
            'postcode' => $address->postcode,
            'user_id' => $userId
        ]);
    }

    public function update(Address $address, AddressDTO $addressDTO): Address 
    {
        $address->update([
            'line_1' => $addressDTO->line1,
            'line_2' => $addressDTO->line2,
            'line_3' => $addressDTO->line3,
            'town' => $addressDTO->town,
            'county' => $addressDTO->county,
            'postcode' => $addressDTO->postcode,
            'is_current' => $addressDTO->isCurrent
        ]);

        return $address->fresh();
    }
}