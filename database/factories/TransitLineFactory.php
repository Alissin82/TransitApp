<?php

namespace Database\Factories;

use App\Models\TransitLine;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TransitLine>
 */
class TransitLineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'origin_city' => $this->faker->city(),
            'destination_city' => $this->faker->city(),
            'origin_terminal' => $this->faker->streetName(),
            'destination_terminal' => $this->faker->streetName(),
            'price' => $this->faker->numberBetween(1000, 10000),
        ];
    }
}
