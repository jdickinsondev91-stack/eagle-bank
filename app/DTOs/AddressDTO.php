<?php 

namespace App\DTOs;

class AddressDTO
{
    public string $line1;

    public ?string $line2;

    public ?string $line3;

    public string $county;

    public string $town;

    public string $postcode;

    public bool $isCurrent;

    public static function create(array $data): self 
    {
        $dto = new self();

        $dto->line1 = $data['line1'];
        $dto->line2 = $data['line2'] ?? null;
        $dto->line3 = $data['line3'] ?? null;
        $dto->county = $data['county'];
        $dto->town = $data['town'];
        $dto->postcode = $data['postcode'];
        $dto->isCurrent = $data['is_current'] ?? true;

        return $dto;
    }
}