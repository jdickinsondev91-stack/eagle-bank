<?php

namespace Database\Factories;

use AccountType;
use App\Models\User;
use Currency;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Account>
 */
class AccountFactory extends Factory
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
            'account_type_id' => fn () => AccountType::factory()->create()->id,
            'currency_id' => fn () => Currency::factory()->create()->id,
            'sort_code' => fake()->numerify('##-##-##'),
            'name' => fake()->word() . ' Bank Account',
            'balance' => fake()->randomNumber(),
            'open' => fake()->boolean()
        ];
    }
}
