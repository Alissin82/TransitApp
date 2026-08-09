<?php

namespace App\Services;

use App\Class\Service;
use App\Models\TransitLine;
use Illuminate\Database\Eloquent\Builder;

class TransitLineService extends Service
{
    protected string $model = TransitLine::class;

    protected array $with = [
        'originTerminal',
        'destinationTerminal',
    ];

    protected function applyFilters(Builder $query, array $filters): void
    {
        if (isset($filters['min_price'])) {
            $query->where('price', '>=', $filters['min_price']);
        }
        if (isset($filters['max_price'])) {
            $query->where('price', '<=', $filters['max_price']);
        }

        $regionField = collect([
            'village_id',
            'settlement_id',
            'district_id',
            'county_id',
            'province_id'
        ])->first(fn ($f) => isset($filters[$f]));

        if ($regionField) {
            $regionValue = $filters[$regionField];

            $query->where(function (Builder $q) use ($regionField, $regionValue) {
                $q->whereHas('originTerminal', fn (Builder $q) => $q->where($regionField, $regionValue))
                    ->orWhereHas('destinationTerminal', fn (Builder $q) => $q->where($regionField, $regionValue));
            });
        }
    }
}
