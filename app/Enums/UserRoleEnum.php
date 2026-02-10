<?php

namespace App\Enums;

use App\Traits\EnumHelperTrait;

enum UserRoleEnum: string
{
    use EnumHelperTrait;

    case USER = 'user';
    case ADMIN = 'admin';
    case TERMINAL = 'terminal';
    case COMPANY = 'company';
}
