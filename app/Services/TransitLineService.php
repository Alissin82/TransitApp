<?php

namespace App\Services;

use App\Models\TransitLine;
use Illuminate\Pagination\LengthAwarePaginator;

class TransitLineService
{
    /**
     * Get all transit lines with pagination and filters
     */
    public function paginate(
        int $perPage = 15,
        ?string $search = null,
        ?int $provinceId = null,
        ?int $countyId = null,
        ?int $districtId = null,
        ?int $settlementId = null,
        ?int $villageId = null,
        ?int $minPrice = null,
        ?int $maxPrice = null,
        ?int $originTerminalId = null,
        ?int $destinationTerminalId = null
    ): LengthAwarePaginator {
        $query = TransitLine::with([
            'originTerminal.province',
            'originTerminal.county',
            'originTerminal.district',
            'originTerminal.settlement',
            'originTerminal.village',
            'destinationTerminal.province',
            'destinationTerminal.county',
            'destinationTerminal.district',
            'destinationTerminal.settlement',
            'destinationTerminal.village',
        ]);

        // Search by origin or destination terminal name
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('originTerminal', function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%");
                })
                ->orWhereHas('destinationTerminal', function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%");
                });
            });
        }

        // Filter by origin terminal region
        if ($originTerminalId) {
            $query->where('origin_terminal_id', $originTerminalId);
        }

        // Filter by destination terminal region
        if ($destinationTerminalId) {
            $query->where('destination_terminal_id', $destinationTerminalId);
        }

        // Filter terminals by region hierarchy
        if ($provinceId) {
            $query->where(function ($q) use ($originTerminalId, $destinationTerminalId, $provinceId) {
                if (empty($originTerminalId)) {
                    $q->whereHas('originTerminal', fn ($q) => $q->where('province_id', $provinceId));
                }
                if (empty($destinationTerminalId)) {
                    $q->orWhereHas('destinationTerminal', fn ($q) => $q->where('province_id', $provinceId));
                }
            });
        }

        if ($countyId) {
            $query->where(function ($q) use ($originTerminalId, $destinationTerminalId, $countyId) {
                if (empty($originTerminalId)) {
                    $q->whereHas('originTerminal', fn ($q) => $q->where('county_id', $countyId));
                }
                if (empty($destinationTerminalId)) {
                    $q->orWhereHas('destinationTerminal', fn ($q) => $q->where('county_id', $countyId));
                }
            });
        }

        if ($districtId) {
            $query->where(function ($q) use ($originTerminalId, $destinationTerminalId, $districtId) {
                if (empty($originTerminalId)) {
                    $q->whereHas('originTerminal', fn ($q) => $q->where('district_id', $districtId));
                }
                if (empty($destinationTerminalId)) {
                    $q->orWhereHas('destinationTerminal', fn ($q) => $q->where('district_id', $districtId));
                }
            });
        }

        if ($settlementId) {
            $query->where(function ($q) use ($originTerminalId, $destinationTerminalId, $settlementId) {
                if (empty($originTerminalId)) {
                    $q->whereHas('originTerminal', fn ($q) => $q->where('settlement_id', $settlementId));
                }
                if (empty($destinationTerminalId)) {
                    $q->orWhereHas('destinationTerminal', fn ($q) => $q->where('settlement_id', $settlementId));
                }
            });
        }

        if ($villageId) {
            $query->where(function ($q) use ($originTerminalId, $destinationTerminalId, $villageId) {
                if (empty($originTerminalId)) {
                    $q->whereHas('originTerminal', fn ($q) => $q->where('village_id', $villageId));
                }
                if (empty($destinationTerminalId)) {
                    $q->orWhereHas('destinationTerminal', fn ($q) => $q->where('village_id', $villageId));
                }
            });
        }

        // Price filters
        if ($minPrice !== null) {
            $query->where('price', '>=', $minPrice);
        }

        if ($maxPrice !== null) {
            $query->where('price', '<=', $maxPrice);
        }

        return $query->latest()->paginate($perPage);
    }

    /**
     * Get transit line by ID
     */
    public function find(int $id): ?TransitLine
    {
        return TransitLine::with([
            'originTerminal',
            'destinationTerminal',
        ])->find($id);
    }

    /**
     * Create a new transit line
     */
    public function create(array $data): TransitLine
    {
        return TransitLine::create($data);
    }

    /**
     * Update an existing transit line
     */
    public function update(TransitLine $transitLine, array $data): bool
    {
        return $transitLine->update($data);
    }

    /**
     * Delete a transit line
     */
    public function delete(TransitLine $transitLine): bool
    {
        return $transitLine->delete();
    }
}
