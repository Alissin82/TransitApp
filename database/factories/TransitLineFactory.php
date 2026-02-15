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
            'price' => $this->faker->numberBetween(1000, 10000),
            'origin_terminal_id' => Terminal::factory(),
            'destination_terminal_id' => Terminal::factory(),
        ];
    }
}
