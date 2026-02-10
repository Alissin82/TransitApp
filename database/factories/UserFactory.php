<?php

namespace Database\Factories;

use App\Enums\UserRoleEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        $role = UserRoleEnum::inRandomOrder();
        return [
            'name' => match ($role) {
                UserRoleEnum::ADMIN,
                UserRoleEnum::USER => $this->faker->name(),

                UserRoleEnum::COMPANY => $this->faker->company(),

                UserRoleEnum::TERMINAL => $this->faker->streetName(),
            },
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'role' => $role->value,
        ];
    }

}
