<?php

namespace Database\Seeders\SubSeeders;

use App\Models\TransitLine;
use App\Models\TransitService;
use Illuminate\Database\Seeder;

class TransitsSeeder extends Seeder
{
    public function run(): void
    {
        TransitLine::factory(50)
            ->has(TransitService::factory(count: rand(1, 3)))
            ->create();
    }
}
