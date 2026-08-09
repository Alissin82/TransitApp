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

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $case) => [
                $case->value => $case->label(),
            ])
            ->toArray();
    }
}
