<?php

use App\Livewire\TransitLines\Modals\Delete;
use App\Models\TransitLine;
use App\Services\TransitLineService;
use App\Traits\withDatatable;
use App\Traits\withModal;
use App\Traits\withRegionSelects;
use App\Traits\withTableDelete;
use App\Traits\withToastNotification;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;

new class extends Component
{
    use withToastNotification,
        withRegionSelects,
        withDatatable,
        withTableDelete,
        withModal;

    protected string $model = TransitLine::class;

    protected string $service = TransitLineService::class;

    protected array $sortable = ['price', 'originTerminal.name', 'destinationTerminal.name', 'created_at'];
    protected array $searchable = ['price', 'originTerminal.name', 'destinationTerminal.name', 'created_at'];

    #[Url(history: true, keep: false)]
    public ?int $province_id = null;

    #[Url(history: true, keep: false)]
    public ?int $county_id = null;

    #[Url(history: true, keep: false)]
    public ?int $district_id = null;

    #[Url(history: true, keep: false)]
    public ?int $settlement_id = null;

    #[Url(history: true, keep: false)]
    public ?int $village_id = null;

    public ?int $min_price = null;
    public ?int $max_price = null;

    protected function filters(): array
    {
        return [
            'min_price'     => $this->min_price,
            'max_price'     => $this->max_price,
            'province_id'   => $this->province_id,
            'county_id'     => $this->county_id,
            'district_id'   => $this->district_id,
            'settlement_id' => $this->settlement_id,
            'village_id'    => $this->village_id,
        ];
    }

    public function mount(): void
    {
        $this->initRegions();
    }

    public function openDeleteModal(int $id): void
    {
        $this->pendingDeleteId = $id;
        $this->openModal(Delete::class, ['id' => $id]);
    }

    #[On('transitline-delete-confirmed')]
    public function onTransitLineDeleteConfirmed(int $id): void
    {
        $this->pendingDeleteId = $id;
        $this->executeDelete();
    }

    public function updated($name): void
    {
        if (in_array($name, array_keys($this->filters()), true)) {
            $this->resetPage();
            $this->resetSelection();
        }
    }

    public function resetFilters(): void
    {
        $this->reset(['min_price', 'max_price']);
        $this->resetRegions();
        $this->resetPage();
        $this->resetSelection();
    }

    public function render()
    {
        return $this->view()->with([
            'items' => $this->query()
        ])->title(__('transit-line.plural'));
    }
};
