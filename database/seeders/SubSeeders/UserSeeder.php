<?php

namespace Database\Seeders\SubSeeders;

use App\Enums\UserRoleEnum;
use App\Models\User;
use Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory(1)->create([
            'name' => 'Admin',
            'password' => Hash::make('admin'),
            'role' => UserRoleEnum::ADMIN,
        ]);

        User::factory(10)->create([
            'role' => UserRoleEnum::USER,
        ]);

        User::factory(10)->create([
            'role' => UserRoleEnum::COMPANY,
        ]);

        User::factory(10)->create([
            'role' => UserRoleEnum::TERMINAL,
        ]);
    }
}
