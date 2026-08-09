<?php

namespace App\Observers;

use App\Models\TransitLine;
use App\Services\TransitPricingService;

class TransitLineObserver
{
    public function updated(TransitLine $transitLine): void
    {
        if (! $transitLine->wasChanged([
            'base_price',
            'estimated_distance_km',
            'estimated_duration_min',
        ])) {
            return;
        }

        $service = app(TransitPricingService::class);

        $transitLine->transitServices()->get()->each(
            fn ($transitService) => $service->updatePrice($transitService)
        );
    }
}
