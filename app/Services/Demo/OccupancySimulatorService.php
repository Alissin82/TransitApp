<?php

namespace App\Services\Demo;

use App\Models\TransitService;
use App\Services\TransitPricingService;
use Random\RandomException;

class OccupancySimulatorService
{
    public function __construct(
        protected TransitPricingService $transitServiceService,
    ) {
    }

    public function simulate(): void
    {
        TransitService::query()
            ->with('transitLine')
            ->get()
            ->each(/**
             * @throws RandomException
             */ function (TransitService $service) {
                $change = random_int(-10, 10);

                $newOccupancy = max(
                    0,
                    min(
                        100,
                        $service->occupancy_percentage + $change
                    )
                );

                $service->update([
                    'occupancy_percentage' => $newOccupancy,
                ]);

                $this->transitServiceService->updatePrice($service);
            });
    }
}
