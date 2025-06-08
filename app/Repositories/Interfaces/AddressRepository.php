<?php 

namespace App\Repositories\Interfaces;

use App\DTOs\AddressDTO;
use App\Models\Address;

interface AddressRepository 
{
    public function create(AddressDTO $address, string $userId): Address;
}