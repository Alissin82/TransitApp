<?php

namespace App\Enums;

use App\Traits\EnumHelperTrait;

enum TransitServiceVehicleType: string
{
    use EnumHelperTrait;

    case AIRPLANE = 'airplane';

    public function label(): string
    {
        return match ($this) {
            self::AIRPLANE => __('Airplane'),
        };
    }
}
