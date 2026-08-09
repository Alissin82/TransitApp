<?php

namespace Database\Factories;

use App\Models\Terminal;
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
            'base_price' => fake()->numberBetween(500_000, 5_000_000),

            'origin_terminal_id' => Terminal::factory(),
            'destination_terminal_id' => Terminal::factory(),

            'estimated_distance_km' => fake()->numberBetween(200, 1500),
            'estimated_duration_min' => fake()->numberBetween(60, 240),
        ];
    }
}
