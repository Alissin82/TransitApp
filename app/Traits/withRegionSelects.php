<?php

namespace App\Traits;

use App\Services\RegionsService;

trait withRegionSelects {
    public ?int $province_id = null;
    public ?int $county_id = null;
    public ?int $district_id = null;
    public ?int $settlement_id = null;
    public ?int $village_id = null;

    public array $provinces = [];
    public array $counties = [];
    public array $districts = [];
    public array $settlements = [];
    public array $villages = [];

    public function initRegions(): void
    {
        $this->provinces = (new RegionsService)->getProvincesForSelect();
    }

    public function updatedProvinceId($value, RegionsService $service): void
    {
        $this->county_id = null;
        $this->district_id = null;
        $this->settlement_id = null;
        $this->village_id = null;
        $this->counties = [];
        $this->districts = [];
        $this->settlements = [];
        $this->villages = [];

        if ($value) {
            $this->counties = $service->getCountiesByProvince((int) $value);
        }
    }

    public function updatedCountyId($value, RegionsService $service): void
    {
        $this->district_id = null;
        $this->settlement_id = null;
        $this->village_id = null;
        $this->districts = [];
        $this->settlements = [];
        $this->villages = [];

        if ($value) {
            $this->districts = $service->getDistrictsByCounty((int) $value);
        }
    }

    public function updatedDistrictId($value, RegionsService $service): void
    {
        $this->settlement_id = null;
        $this->village_id = null;
        $this->settlements = [];
        $this->villages = [];

        if ($value) {
            $this->settlements = $service->getSettlementsByDistrict((int) $value);
        }
    }

    public function updatedSettlementId($value, RegionsService $service): void
    {
        $this->village_id = null;
        $this->villages = [];

        if ($value) {
            $this->villages = $service->getVillagesBySettlement((int) $value);
        }
    }

    public function resetRegions(): void
    {
        $this->reset([
            'province_id',

            'county_id',
            'counties',

            'district_id',
            'districts',

            'settlement_id',
            'settlements',

            'village_id',
            'villages',
        ]);
    }
}
