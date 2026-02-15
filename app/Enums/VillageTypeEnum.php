<?php

namespace App\Enums;

use App\Traits\EnumHelperTrait;

enum VillageTypeEnum: string
{
    use EnumHelperTrait;

    case VILLAGE = 'village';
    case BLOCKED_VILLAGE = 'blocked-village';
}
