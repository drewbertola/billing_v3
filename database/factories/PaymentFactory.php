<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customerId' => Customer::all()->random()->id,
            'amount' => fake()->randomFloat(2, 200, 8000),
            'date' => fake()->date(),
            'method' => fake()->randomElement(['Card', 'Cash', 'Check', 'Transfer']),
            'number' => fake()->bankAccountNumber(),
        ];
    }
}
