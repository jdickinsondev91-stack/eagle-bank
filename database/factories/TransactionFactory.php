<?php

namespace Database\Factories;

use Account;
use Illuminate\Database\Eloquent\Factories\Factory;
use TransactionType;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'account_id' => fn () => Account::factory()->create()->id,
            'transaction_type_id' => fn () => TransactionType::factory()->create()->id,
            'amount' => fake()->randomNumber(),
            'reference' => fake()->sentence()
        ];
    }
}
