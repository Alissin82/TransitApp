<?php

namespace App\Services;

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
     * Get terminals for select dropdown (grouped by region)
     */
    public function getTerminalsForSelect(
        ?int $provinceId = null,
        ?int $countyId = null,
        ?int $districtId = null,
        ?int $settlementId = null,
        ?int $villageId = null
    ): array {
        $query = Terminal::with([
            'province',
            'county',
            'district',
            'settlement',
        ]);

        if ($provinceId) {
            $query->where('province_id', $provinceId);
        }

        if ($countyId) {
            $query->where('county_id', $countyId);
        }

        if ($districtId) {
            $query->where('district_id', $districtId);
        }

        if ($settlementId) {
            $query->where('settlement_id', $settlementId);
        }

        if ($villageId) {
            $query->where('village_id', $villageId);
        }

        return $query->orderBy('name')
            ->get()
            ->mapWithKeys(fn ($terminal) => [
                $terminal->id => $this->formatTerminalName($terminal)
            ])
            ->toArray();
    }

    /**
     * Format terminal name with region hierarchy
     */
    private function formatTerminalName(Terminal $terminal): string
    {
        $parts = [$terminal->name];

        if ($terminal->province) {
            $parts[] = $terminal->province->name;
        }

        if ($terminal->county) {
            $parts[] = $terminal->county->name;
        }

        if ($terminal->district) {
            $parts[] = $terminal->district->name;
        }

        if ($terminal->settlement) {
            $parts[] = $terminal->settlement->name;
        }

        return implode(' - ', $parts);
    }
}
