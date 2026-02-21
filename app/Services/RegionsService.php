<?php

namespace App\Services;

use App\Models\IranRegion\County;
use App\Models\IranRegion\District;
use App\Models\IranRegion\Province;
use App\Models\IranRegion\Settlement;
use App\Models\IranRegion\Village;

class RegionsService
{
    /**
     * Get provinces for dropdown
     */
    public function getProvincesForSelect(): array
    {
        return Province::query()
            ->orderBy('name')
            ->pluck('name', 'id')
            ->toArray();
    }

    /**
     * Get counties by province ID for dropdown
     */
    public function getCountiesByProvince(int $provinceId): array
    {
        return County::where('province_id', $provinceId)
            ->orderBy('name')
            ->pluck('name', 'id')
            ->toArray();
    }

    /**
     * Get districts by county ID for dropdown
     */
    public function getDistrictsByCounty(int $countyId): array
    {
        return District::where('county_id', $countyId)
            ->orderBy('name')
            ->pluck('name', 'id')
            ->toArray();
    }

    /**
     * Get settlements by district ID for dropdown
     */
    public function getSettlementsByDistrict(int $districtId): array
    {
        return Settlement::where('district_id', $districtId)
            ->orderBy('name')
            ->pluck('name', 'id')
            ->toArray();
    }

    /**
     * Get villages by settlement ID for dropdown
     */
    public function getVillagesBySettlement(int $settlementId): array
    {
        return Village::where('settlement_id', $settlementId)
            ->orderBy('name')
            ->pluck('name', 'id')
            ->toArray();
    }
}
