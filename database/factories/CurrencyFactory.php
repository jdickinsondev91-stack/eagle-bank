<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Currency>
 */
class CurrencyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'symbol' => fake()->randomLetter(),
            'code' => fake()->currencyCode(),
            'decimal_places' => fake()->randomDigitNotNull(),
            'is_active' => fake()->boolean()
        ];
    }
}
