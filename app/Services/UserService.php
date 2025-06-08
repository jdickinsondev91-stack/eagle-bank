<?php

namespace App\Services;

use App\DTOs\AddressDTO;
use App\DTOs\UserDTO;
use App\Models\User;
use App\Repositories\Interfaces\UserRepository;

class UserService
{
    public function __construct(
        private UserRepository $userRepository,
        private AddressService $addressService
    ) {}

    public function getById(string $id): User
    {
        return $this->userRepository->getById($id);
    }

    public function createUser(UserDTO $user, AddressDTO $address): User 
    {
        $user = $this->userRepository->create($user);

        $address = $this->addressService->createAddress($address, $user->id);

        //Safe to assume that the address created at this point is the current address
        $user->currentAddress = $address;

        return $user;
    }
}