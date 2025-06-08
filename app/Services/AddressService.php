<?php 

namespace App\Services;

use App\DTOs\AddressDTO;
use App\Models\Address;
use App\Repositories\Interfaces\AddressRepository;

class AddressService
{
    public function __construct(
        private AddressRepository $addressRepository
    ) {}

    public function createAddress(AddressDTO $address, string $userId): Address
    {
        return $this->addressRepository->create($address, $userId);
    }
}