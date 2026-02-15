<?php

namespace Database\Seeders;


use Database\Seeders\SubSeeders\IranRegionsSeeder;
use Database\Seeders\SubSeeders\TerminalsSeeder;
use Database\Seeders\SubSeeders\UserSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(IranRegionsSeeder::class);
        $this->call(TerminalsSeeder::class);
    }
}
