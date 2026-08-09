<?php

namespace App\Traits;

use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Url;
use Livewire\WithPagination;

/**
 * @property string $service
 * @property array $sortable
 * @property array $searchable
*/


trait withDatatable
{
    use WithPagination;

    #[Url(history: true, keep: false)]
    public string $search = '';

    #[Url(history: true, keep: false)]
    public int $perPage = 10;

    #[Url(history: true, keep: false)]
    public string $sortField = '';

    #[Url(history: true, keep: false)]
    public string $sortDirection = 'desc';

    /** @var array<int, string> */
    public array $selectedRows = [];

    public bool $selectAll = false;

    protected array $perPageOptions = [10, 25, 50, 100];

    protected string $defaultSortField = 'id';

    protected string $defaultSortDirection = 'desc';


    public function mountWithDatatable(): void
    {
        if (! in_array($this->sortField, $this->sortable, true)) {
            $this->sortField = $this->defaultSortField;
            $this->sortDirection = $this->defaultSortDirection;
        }

        if (! in_array($this->sortDirection, ['asc', 'desc'], true)) {
            $this->sortDirection = $this->defaultSortDirection;
        }

        if (! in_array($this->perPage, $this->perPageOptions, true)) {
            $this->perPage = $this->perPageOptions[0];
        }
    }


    protected function filters(): array
    {
        return [];
    }

    protected function query(): LengthAwarePaginator
    {
        return app($this->service)->paginate(
            perPage: $this->perPage,
            search: $this->search,
            searchable: $this->searchable,
            sortField: $this->sortField,
            sortDirection: $this->sortDirection,
            sortable: $this->sortable,
            filters: $this->filters(),
        );
    }

    protected function selectableRowIds(): array
    {
        return $this->query()
            ->pluck('id')
            ->map(fn ($id) => (string) $id)
            ->all();
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
        $this->resetSelection();
    }

    public function clearSearch(): void
    {
        $this->search = '';
        $this->resetPage();
        $this->resetSelection();
    }

    public function updatedPerPage(mixed $value): void
    {
        $this->perPage = in_array((int) $value, $this->perPageOptions, true)
            ? (int) $value
            : $this->perPageOptions[0];

        $this->resetPage();
        $this->resetSelection();
    }

    public function sortBy(string $field): void
    {
        if (! in_array($field, $this->sortable, true)) {
            return;
        }

        if ($this->sortField === $field) {
            // disabling sort on field if user clicks on desc ordered column
            if ($this->sortDirection === 'desc') {
                $this->sortDirection = $this->defaultSortDirection;
                $this->sortField = $this->defaultSortField;
                return;
            } elseif ($this->sortDirection === 'asc') {
                // sort is asc so it will be set to desc
                $this->sortDirection = 'desc';
            }  else {
                // guard / safe query
                $this->sortDirection = $this->defaultSortDirection;
            }
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }

        $this->resetPage();
    }

    public function updatedSelectAll(mixed $value): void
    {
        $this->selectedRows = $value ? $this->selectableRowIds() : [];
    }

    public function updatedSelectedRows(): void
    {
        $this->selectAll = false;
    }

    public function resetSelection(): void
    {
        $this->selectedRows = [];
        $this->selectAll = false;
    }

    public function hasSelection(): bool
    {
        return $this->selectedRows !== [];
    }

    protected function selectedIds(): array
    {
        return array_values(array_map('intval', $this->selectedRows));
    }
}
