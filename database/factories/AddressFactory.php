<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fn () => User::factory()->create()->id,
            'line_1' => fake()->streetAddress(),
            'line_2' => fake()->word(),
            'line_3' => fake()->word(),
            'postcode' => fake()->postcode(),
            'town' => fake()->city(),
            'county' => fake()->state(),
            'is_current' => fake()->boolean()
        ];
    }
}
