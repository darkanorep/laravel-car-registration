<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PlateNumber>
 */
class PlateNumberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'owner_id' => $this->faker->numberBetween(1, 100),
            'plate_number' => strtoupper($this->faker->regexify('[A-Z0-9]{6}')),
        ];
    }
    
}
