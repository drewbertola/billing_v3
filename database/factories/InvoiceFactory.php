<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
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
            'amount' => 0,
            'date' => fake()->date(),
            'emailed' => fake()->randomElement(['Y']),
            'note' => fake()->paragraph(4),
        ];
    }
}
