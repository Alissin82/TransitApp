<?php

namespace App\Traits;

trait EnumHelperTrait
{
    public static function inRandomOrder(): self
    {
        return fake()->randomElement(self::cases());
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
