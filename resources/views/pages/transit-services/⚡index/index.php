<?php

use App\Models\TransitService;
use App\Services\TransitPricingService;
use App\Services\TransitServiceService;
use App\Traits\withDatatable;
use App\Traits\withModal;
use App\Traits\withTableDelete;
use App\Traits\withToastNotification;
use Livewire\Attributes\Url;
use Livewire\Component;

new class extends Component
{
    use withToastNotification,
        withDatatable,
        withTableDelete,
        withModal;

    protected string $model = TransitService::class;

    protected string $service = TransitServiceService::class;

    protected array $sortable = [
        'transitLine.originTerminal.name',
        'transitLine.destinationTerminal.name',
        'departure_time',
        'vehicle_type',
        'capacity',
        'occupancy_percentage',
        'computed_price',
        'created_at',
    ];

    protected array $searchable = [
        'transitLine.originTerminal.name',
        'transitLine.destinationTerminal.name',
        'vehicle_type',
    ];

    #[Url(history: true, keep: false)]
    public ?int $transit_line_id = null;

    protected function filters(): array
    {
        return [
            'transit_line_id' => $this->transit_line_id,
        ];
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
        $this->reset(['transit_line_id']);

        $this->resetPage();
        $this->resetSelection();
    }

    public array $priceChanges = [];

    public function refreshPrices(TransitPricingService $pricingService): void
    {
        foreach ($this->query() as $service) {
            $pricingService->updatePrice($service);

            $latestHistory = $service->priceHistories()
                ->latest('created_at')
                ->first();

            if (
                $latestHistory &&
                $latestHistory->change_amount !== 0
            ) {
                $this->priceChanges[$service->id] = [
                    'amount' => $latestHistory->change_amount,
                    'direction' => $latestHistory->change_amount > 0
                        ? 'up'
                        : 'down',
                ];
            }
        }
    }

    public function render()
    {
        return $this->view()->with([
            'items' => $this->query(),
        ])->title(__('transit-service.plural'));
    }
};
