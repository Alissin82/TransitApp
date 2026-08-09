<?php

namespace App\Services;

use App\Models\TransitService;

class TransitPricingService
{
    public function calculatePrice(TransitService $transitService): array
    {
        $basePrice = $transitService->transitLine->base_price;

        /*
         * Distance factor
         */
        $distanceKm = $transitService->transitLine->estimated_distance_km;

        $distancePercentage = match (true) {
            $distanceKm > 700 => 10,
            $distanceKm > 300 => 5,
            default => 0,
        };

        /*
         * Duration factor
         */
        $durationMin = $transitService->transitLine->estimated_duration_min;

        $durationPercentage = $durationMin > 0
            ? round($durationMin / 120, 1)
            : 0;

        /*
         * Departure time / last-minute factor
         */
        $createdAt = $transitService->created_at;
        $departureTime = $transitService->departure_time;

        $totalDuration = $createdAt->diffInSeconds($departureTime);
        $elapsedDuration = $createdAt->diffInSeconds(now());

        $elapsedPercentage = $totalDuration > 0
            ? ($elapsedDuration / $totalDuration) * 100
            : 0;

        $timePercentage = match (true) {
            $elapsedPercentage >= 90 => 20,
            $elapsedPercentage >= 75 => 10,
            $elapsedPercentage >= 50 => 5,
            default => 0,
        };

        /*
         * Occupancy / demand factor
         */
        $occupancyPercentage = match (true) {
            $transitService->occupancy_percentage > 90 => 10,
            $transitService->occupancy_percentage > 80 => 5,
            default => 0,
        };

        /*
         * VIP factor
         */
        $vipPercentage = $transitService->is_vip ? 20 : 0;

        $distanceAdjustment = $this->percentageOf(
            $basePrice,
            $distancePercentage
        );

        $durationAdjustment = $this->percentageOf(
            $basePrice,
            $durationPercentage
        );

        $timeAdjustment = $this->percentageOf(
            $basePrice,
            $timePercentage
        );

        $occupancyAdjustment = $this->percentageOf(
            $basePrice,
            $occupancyPercentage
        );

        $vipAdjustment = $this->percentageOf(
            $basePrice,
            $vipPercentage
        );

        $finalPrice = $basePrice
            + $distanceAdjustment
            + $durationAdjustment
            + $timeAdjustment
            + $occupancyAdjustment
            + $vipAdjustment;

        return [
            'base_price' => $basePrice,

            'distance_percentage' => $distancePercentage,
            'duration_percentage' => $durationPercentage,
            'time_percentage' => $timePercentage,
            'occupancy_percentage' => $occupancyPercentage,
            'vip_percentage' => $vipPercentage,

            'distance_adjustment' => $distanceAdjustment,
            'duration_adjustment' => $durationAdjustment,
            'time_adjustment' => $timeAdjustment,
            'occupancy_adjustment' => $occupancyAdjustment,
            'vip_adjustment' => $vipAdjustment,

            'final_price' => $finalPrice,
        ];
    }

    public function updatePrice(TransitService $service): TransitService
    {
        $result = $this->calculatePrice($service);

        $oldPrice = $service->computed_price;
        $newPrice = $result['final_price'];

        if ($oldPrice === $newPrice) {
            return $service;
        }

        $changeAmount = $oldPrice !== null
            ? $newPrice - $oldPrice
            : 0;

        $service->update([
            'computed_price' => $newPrice,
            'price_computed_at' => now(),
        ]);

        $service->priceHistories()->create([
            'base_price' => $result['base_price'],

            'distance_adjustment' => $result['distance_adjustment'],
            'duration_adjustment' => $result['duration_adjustment'],
            'time_adjustment' => $result['time_adjustment'],
            'occupancy_adjustment' => $result['occupancy_adjustment'],
            'vip_adjustment' => $result['vip_adjustment'],

            'price' => $newPrice,

            'previous_price' => $oldPrice,
            'change_amount' => $changeAmount,
        ]);

        return $service->refresh();
    }

    private function percentageOf(int $price, float|int $percentage): int
    {
        return (int) round($price * $percentage / 100);
    }
}
