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
        $terminals = Terminal::factory(20)->create();

        TransitLine::factory(40)
            ->state(function () use ($terminals) {
                $origin = $terminals->random();

                do {
                    $destination = $terminals->random();
                } while ($destination->is($origin));

                return [
                    'origin_terminal_id' => $origin->id,
                    'destination_terminal_id' => $destination->id,
                ];
            })
            ->has(
                TransitService::factory()
                    ->count(2)
            )
            ->create();
    }
}
