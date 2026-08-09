<?php

namespace App\Services;

use App\Class\Service;
use App\Exceptions\CannotDeleteException;
use App\Models\Terminal;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class TerminalService extends Service
{
    protected string $model = Terminal::class;

    protected array $with = [
        'province'
    ];

    /**
     * @throws CannotDeleteException if the terminal still has transit lines attached.
     */
    public function delete(Model $model): bool
    {
        /** @var Terminal $model */
        $this->guardAgainstDependentTransitLines($model);

        return parent::delete($model);
    }

    /**
     * Get terminals for select dropdown (filtered by region)
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

        $filters = [
            'province_id'   => $provinceId,
            'county_id'     => $countyId,
            'district_id'   => $districtId,
            'settlement_id' => $settlementId,
            'village_id'    => $villageId,
        ];

        foreach ($filters as $column => $value) {
            $query->when($value, fn (Builder $query) => $query->where($column, $value));
        }

        return $query->orderBy('name')
            ->get()
            ->mapWithKeys(fn (Terminal $terminal) => [
                $terminal->id => $this->formatTerminalName($terminal),
            ])
            ->toArray();
    }

    /**
     * Format terminal name with region hierarchy
     */
    public function formatTerminalName(Terminal $terminal): string
    {
        $parts = array_filter([
            $terminal->name,
            $terminal->province?->name,
            $terminal->county?->name,
            $terminal->district?->name,
            $terminal->settlement?->name,
        ]);

        return implode(' - ', $parts);
    }

    /**
     * @throws CannotDeleteException
     */
    protected function guardAgainstDependentTransitLines(Terminal $terminal): void
    {
        $count = $this->transitLinesCount($terminal);

        if ($count > 0) {
            throw new CannotDeleteException(
                model_trans('terminal', 'messages.has_transit_lines', ['count' => $count])
            );
        }
    }

    protected function transitLinesCount(Terminal $terminal): int
    {
        // Use eager-loaded counts if available (bulk path), otherwise query them.
        if (isset($terminal->origin_transit_lines_count, $terminal->destination_transit_lines_count)) {
            return $terminal->origin_transit_lines_count + $terminal->destination_transit_lines_count;
        }

        return $terminal->originTransitLines()->count() + $terminal->destinationTransitLines()->count();
    }
}
