<?php

namespace App\Services;

use App\Class\Service;
use App\Exceptions\CannotDeleteException;
use App\Models\TransitLine;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

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

    /**
     * @throws CannotDeleteException if the terminal still has transit services attached.
     */
    public function delete(Model $model): bool
    {
        /** @var TransitLine $model */
        $this->guardAgainstDependentTransitServices($model);

        return parent::delete($model);
    }

    /**
     * @throws CannotDeleteException
     */
    protected function guardAgainstDependentTransitServices(TransitLine $transitLine): void
    {
        $count = $this->transitServicesCount($transitLine);

        if ($count > 0) {
            throw new CannotDeleteException(
                model_trans('transit-line', 'messages.has_transit_services', ['count' => $count])
            );
        }
    }

    protected function transitServicesCount(TransitLine $transitLine): int
    {
        // Use eager-loaded counts if available (bulk path), otherwise query them.
        if (isset($transitLine->transit_services_count)) {
            return $transitLine->transit_services_count;
        }

        return $transitLine->transitServices()->count();
    }
}
