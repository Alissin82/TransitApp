<?php

namespace App\Class;

use App\Exceptions\CannotDeleteException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class Service
{
    protected string $model;

    protected array $with = [];

    protected array $searchable = [];

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
                $parts = explode('.', $column);
                $field = array_pop($parts);

                $applyRelationSearch = function (
                    Builder $query,
                    array $relations,
                    string $field
                ) use (&$applyRelationSearch, $search): void {
                    if (empty($relations)) {
                        $query->where($field, 'like', "%$search%");
                        return;
                    }

                    $relation = array_shift($relations);

                    $query->whereHas($relation, function (Builder $query) use (
                        $relations,
                        $field,
                        &$applyRelationSearch
                    ) {
                        $applyRelationSearch($query, $relations, $field);
                    });
                };

                if (empty($parts)) {
                    $query->orWhere($field, 'like', "%$search%");
                } else {
                    $query->orWhere(function (Builder $query) use (
                        $parts,
                        $field,
                        &$applyRelationSearch
                    ) {
                        $applyRelationSearch($query, $parts, $field);
                    });
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
