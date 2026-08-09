<?php

namespace Database\Factories;

use App\Enums\TransitServiceVehicleType;
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
            'departure_time' => fake()->dateTimeBetween(
                '+1 hour',
                '+1 week'
            ),

            'transit_line_id' => TransitLine::factory(),

            'vehicle_type' => TransitServiceVehicleType::AIRPLANE,

            'capacity' => fake()->randomElement([
                120,
                150,
                180,
                220,
                300,
            ]),

            'occupancy_percentage' => fake()->numberBetween(10, 95),

            'is_vip' => fake()->boolean(25),
        ];
    }
}
