<?php

namespace App\Enums;

use App\Traits\EnumHelperTrait;

enum SettlementTypeEnum: string
{
    use EnumHelperTrait;

    case CITY = 'city';
    case URBAN_AREA = 'urban-area';
    case RURAL_DISTRICT = 'rural-district';
}
