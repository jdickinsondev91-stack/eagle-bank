<?php 

namespace App\DTOs;

class UserDTO 
{
    public ?string $id; 

    public string $name;

    public string $phoneNumber;

    public string $email;

    public static function create(array $data): self
    {
        $dto = new self();

        $dto->id = $data['id'] ?? null;
        $dto->name = $data['name'];
        $dto->phoneNumber = $data['phoneNumber'];
        $dto->email = $data['email'];

        return $dto;
    }
}