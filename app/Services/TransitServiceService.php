<?php

namespace App\Services;

use App\Class\Service;
use App\Models\TransitService;

class TransitServiceService extends Service
{
    protected string $model = TransitService::class;

    protected array $with = [
        'transitLine.originTerminal',
        'transitLine.destinationTerminal',
    ];
}
