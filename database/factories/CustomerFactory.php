<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'phoneMain' => fake()->e164PhoneNumber(),
            'bAddress1' => fake()->buildingNumber . ' ' . fake()->streetName(),
            'bAddress2' => fake()->secondaryAddress(),
            'bCity' => fake()->city(),
            'bState' => fake()->stateAbbr(),
            'bZip' => fake()->postcode(),
            'primaryContact' => fake()->firstName() . ' ' . fake()->lastName(),
            'primaryEmail' => fake()->safeEmail(),
            'primaryPhone' => fake()->e164PhoneNumber(),
            'billingContact' => fake()->firstName() . ' ' . fake()->lastName(),
            'billingEmail' => fake()->safeEmail(),
            'billingPhone' => fake()->e164PhoneNumber(),
            'archive' => fake()->randomElement(['Y', 'N']),
        ];
    }
}
