<?php

namespace App\Services;

use App\DTOs\AddressDTO;
use App\DTOs\UserDTO;
use App\Exceptions\HasAccountsException;
use App\Models\User;
use App\Repositories\Interfaces\UserRepository;
use Illuminate\Support\Facades\DB;

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

    public function createUser(UserDTO $userDTO, AddressDTO $addressDTO): User 
    {
        return DB::transaction(function () use ($userDTO, $addressDTO) {
            $user = $this->userRepository->create($userDTO);

            $address = $this->addressService->createAddress($addressDTO, $user->id);

            //Safe to assume that the address created at this point is the current address
            $user->currentAddress = $address;

            return $user;
        });
    }

    public function updateUser(UserDTO $userDTO, AddressDTO $addressDTO): User 
    {
        return DB::transaction(function () use ($userDTO, $addressDTO) {
            $user = $this->userRepository->getById($userDTO->id);

            $address = $this->addressService->updateAddress($user->currentAddress, $addressDTO);

            $user = $this->userRepository->update($user, $userDTO);

            return $user;
        });
    }

    public function deleteUser(string $userId): bool 
    {
        $user = $this->userRepository->getByIdWithAccounts($userId);

        if ($user->accounts->isNotEmpty()) {
            throw new HasAccountsException();
        }

        return DB::transaction(function () use ($user) {
            return $this->userRepository->delete($user);
        });
    }
}