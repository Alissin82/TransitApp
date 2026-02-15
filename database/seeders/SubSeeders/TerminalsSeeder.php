<?php

namespace Database\Seeders\SubSeeders;

use App\Models\Terminal;
use App\Models\TransitLine;
use App\Models\TransitService;
use Illuminate\Database\Seeder;

class TerminalsSeeder extends Seeder
{
    public function run(): void
    {
        Terminal::factory(20)
            ->has(
                TransitLine::factory(20)
                    ->has(TransitService::factory(rand(1, 3))),
                'departureTransitLines'
            )
            ->has(
                TransitLine::factory(20)
                    ->has(TransitService::factory(rand(1, 3))),
                'arrivalTransitLines'
            )
            ->create();
    }
}
