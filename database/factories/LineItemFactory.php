<?php

namespace Database\Factories;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LineItem>
 */
class LineItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'invoiceId' => Invoice::all()->random()->id,
            'price' => fake()->randomFloat(2, 10, 80),
            'units' => fake()->randomElement(['hour', 'each', 'unit']),
            'quantity' => fake()->randomNumber(2, 1, 80),
            'description' => fake()->randomElement([
                'Programming', 'Administration', 'Installation', 'Hardware',
                'Screws, nuts, and bolts', 'Configuration',
            ]),
        ];
    }
}
