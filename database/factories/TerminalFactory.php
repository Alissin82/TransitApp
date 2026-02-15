<?php

namespace Database\Factories;

use App\Enums\SettlementTypeEnum;
use App\Models\IranRegion\Settlement;
use App\Models\Terminal;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Terminal>
 */
class TerminalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $settlement = Settlement::inRandomOrder()->first();

        if ($settlement->type == SettlementTypeEnum::RURAL_DISTRICT) {
            $village = $settlement->villages()->inRandomOrder()->first();
        } else {
            $village = null;
        }

        $district = $settlement->district;
        $county = $district->county;
        $province = $county->province;

        return [
            'name' => $this->faker->streetName(),
            'province_id' => $province->id,
            'county_id' => $county->id,
            'district_id' => $district->id,
            'settlement_id' => $settlement->id,
            'village_id' => $village?->id,
        ];
    }
}
