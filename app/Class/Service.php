<?php

namespace App\Class;

use App\Exceptions\CannotDeleteException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Base for all "resource services" (TerminalService, TransitLineService, ...).
 *
 * A child only needs to set $model (and usually $with / $sortable) to get
 * find/create/update/delete/deleteMany/paginate for free. Override any
 * method when a resource needs something the default can't express —
 * e.g. TerminalService overrides delete() to guard against dependent
 * transit lines, and applySearch()/applySort() to search/sort by relations.
 */
abstract class Service
{
    /** Eloquent model class this service operates on, e.g. Terminal::class. */
    protected string $model;

    /** Relations to eager-load on find()/paginate(). */
    protected array $with = [];

    /** Columns searched with LIKE when a search term is given (plain columns only — see applySearch() for relations). */
    protected array $searchable = [];

    /** Whitelisted sortable fields. */
    protected array $sortable = [];

    protected string $defaultSortField = 'id';

    protected string $defaultSortDirection = 'desc';

    public function paginate(
        int $perPage = 10,

        string $search = '',
        array $searchable = [],

        ?string $sortField = null,
        ?string $sortDirection = null,
        array $sortable = [],

        array $filters = [],
    ): LengthAwarePaginator {
        $query = $this->model::with($this->with);

        $this->searchable = $searchable;

        $this->applySearch(
            query: $query,
            search: trim($search),
        );

        $this->sortable = $sortable;

        $this->applySort(
            query: $query,
            sortField: $sortField ?: $this->defaultSortField,
            sortDirection: $sortDirection ?: $this->defaultSortDirection,
        );

        $this->applyFilters(
            query: $query,
            filters: array_filter(
                array: $filters,
                callback: fn ($v) => $v !== null && $v !== '',
            )
        );

        return $query->paginate($perPage)->withQueryString();
    }

    protected function applySearch(Builder $query, string $search): void
    {
        if ($search === '' || empty($this->searchable)) {
            return;
        }

        $query->where(function (Builder $query) use ($search) {
            foreach ($this->searchable as $column) {
                $explodedColumn = explode('.', $column);
                if (count($explodedColumn) > 1) {
                    [$relationName, $columnName] = $explodedColumn;

                    $query->orWhereHas($relationName, function ($q) use ($search, $columnName) {
                        $q->where($columnName, 'like', "%$search%");
                    });
                } else {
                    $query->orWhere($column, 'like', "%$search%");
                }
            }
        });
    }

    protected function applySort(Builder $query, string $sortField, string $sortDirection): void
    {
        $direction = strtolower($sortDirection) === 'asc' ? 'asc' : 'desc';

        if (! in_array($sortField, $this->sortable, true)) {
            $sortField = $this->defaultSortField;
        }

        $explodedColumn = explode('.', $sortField);
        if (count($explodedColumn) > 1) {
            [$relationName, $column] = $explodedColumn;

            $relation = $query->getModel()->{$relationName}();

            $query->orderBy(
                $relation->getRelated()->newQuery()
                    ->select($column)
                    ->whereColumn(
                        $relation->getQualifiedOwnerKeyName(),
                        $relation->getQualifiedForeignKeyName()
                    ),
                $direction
            );
        } else {
            $query->orderBy($sortField, $direction);
        }
    }

    protected function applyFilters(Builder $query, array $filters): void
    {
        // it will be overridden when needed in every inheritor
    }

    public function find(int $id): ?Model
    {
        return $this->model::with($this->with)->find($id);
    }

    public function create(array $data): Model
    {
        return $this->model::create($data);
    }

    public function update(Model $model, array $data): bool
    {
        return $model->update($data);
    }

    /**
     * @throws CannotDeleteException if a child service blocks this deletion.
     */
    public function delete(Model $model): bool
    {
        return $model->delete();
    }

    /**
     * Deletes each row via delete(), silently skipping any that throw
     * CannotDeleteException. Returns the count actually deleted.
     *
     * Override this if a resource needs different bulk semantics
     * (e.g. all-or-nothing instead of skip-and-continue).
     */
    public function deleteMany(array $ids): int
    {
        $ids = array_filter(array_map('intval', $ids));

        if (empty($ids)) {
            return 0;
        }

        $deleted = 0;

        foreach ($this->model::whereIn('id', $ids)->get() as $model) {
            try {
                $this->delete($model);
                $deleted++;
            } catch (CannotDeleteException) {
                // Skipped on purpose — bulk delete doesn't fail the whole batch.
            }
        }

        return $deleted;
    }

    public function modelClass(): string
    {
        return $this->model;
    }
}
