<?php

namespace Database\Factories;

use App\Models\TransitLine;
use App\Models\TransitService;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TransitService>
 */
class TransitServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'transit_line_id' => TransitLine::factory(),
            'departure_time' => $this->faker->dateTimeBetween('-1 week', '+1 week'),
        ];
    }
}
