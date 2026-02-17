<?php

namespace App\Services;

use App\Models\IranRegion\County;
use App\Models\IranRegion\District;
use App\Models\IranRegion\Province;
use App\Models\IranRegion\Settlement;
use App\Models\IranRegion\Village;
use App\Models\Terminal;
use Illuminate\Pagination\LengthAwarePaginator;

class TerminalService
{
    /**
     * Get all terminals with pagination
     */
    public function paginate(int $perPage = 15, string $search = ''): LengthAwarePaginator
    {
        $query = Terminal::with([
            'province',
            'county',
            'district',
            'settlement',
            'village'
        ]);

        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%$search%")
                    ->orWhereHas('province', function ($query) use ($search) {
                        $query->where('name', 'like', "%$search%");
                    })
                    ->orWhereHas('county', function ($query) use ($search) {
                        $query->where('name', 'like', "%$search%");
                    })
                    ->orWhereHas('district', function ($query) use ($search) {
                        $query->where('name', 'like', "%$search%");
                    })
                    ->orWhereHas('settlement', function ($query) use ($search) {
                        $query->where('name', 'like', "%$search%");
                    })
                    ->orWhereHas('village', function ($query) use ($search) {
                        $query->where('name', 'like', "%$search%");
                    });
            });
        }

        return $query->latest()->paginate($perPage);
    }

    /**
     * Get terminal by ID
     */
    public function find(int $id): ?Terminal
    {
        return Terminal::with([
            'province',
            'county',
            'district',
            'settlement',
            'village'
        ])->find($id);
    }

    /**
     * Create a new terminal
     */
    public function create(array $data): Terminal
    {
        return Terminal::create($data);
    }

    /**
     * Update an existing terminal
     */
    public function update(Terminal $terminal, array $data): bool
    {
        return $terminal->update($data);
    }

    /**
     * Delete a terminal
     */
    public function delete(Terminal $terminal): bool
    {
        return $terminal->delete();
    }

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
