<?php

use App\Enums\TransitServiceVehicleType;
use App\Models\TransitService;
use App\Services\TransitLineService;
use App\Services\TransitPricingService;
use App\Services\TransitServiceService;
use App\Traits\withToastNotification;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

new class extends Component
{
    use withToastNotification;

    public ?TransitService $transitService = null;

    public ?string $departure_time = null;
    public ?int $transit_line_id = null;
    public ?string $vehicle_type = null;
    public ?int $capacity = null;
    public ?int $occupancy_percentage = 0;
    public bool $is_vip = false;
    public ?int $computed_price = null;
    public ?int $previous_price = null;
    public ?int $priceChange = null;
    public array $priceBreakdown = [];
    public ?string $priceChangeDirection = null;

    public array $transitLines = [];

    public function mount(
        TransitServiceService $transitServiceService,
        TransitLineService $transitLineService,
        TransitPricingService $pricingService,
        ?TransitService $transitService = null,
    ): void {
        $this->transitLines = $transitLineService->paginate(
            perPage: 1000,
            sortable: ['id'],
        )->mapWithKeys(fn ($line) => [
            $line->id => $line->originTerminal->name . ' => ' . $line->destinationTerminal->name,
        ])->toArray();

        if ($transitService) {
            $this->transitService = $transitServiceService->find($transitService->id);

            $this->departure_time = $this->transitService->departure_time?->format('Y-m-d\TH:i');
            $this->transit_line_id = $this->transitService->transit_line_id;
            $this->vehicle_type = $this->transitService->vehicle_type?->value;
            $this->capacity = $this->transitService->capacity;
            $this->occupancy_percentage = $this->transitService->occupancy_percentage;
            $this->is_vip = $this->transitService->is_vip;

            $result = $pricingService->calculatePrice($this->transitService);

            $this->computed_price = $result['final_price'];

            $this->priceBreakdown = $result;

            $latestHistory = $this->transitService->priceHistories()
                ->latest('created_at')
                ->first();

            if ($latestHistory) {
                $this->priceChange = $latestHistory->change_amount;

                $this->priceChangeDirection = $latestHistory->change_amount > 0
                    ? 'up'
                    : ($latestHistory->change_amount < 0 ? 'down' : null);
            }
        } else {
            $this->vehicle_type = TransitServiceVehicleType::AIRPLANE->value;
        }
    }

    public function refreshPrice(TransitPricingService $pricingService): void
    {
        if (! $this->transitService) {
            return;
        }

        /*
         * Calculate current price based on the current Livewire state.
         */
        $this->transitService->transit_line_id = $this->transit_line_id;
        $this->transitService->departure_time = $this->departure_time;
        $this->transitService->occupancy_percentage = $this->occupancy_percentage;
        $this->transitService->is_vip = $this->is_vip;

        /*
         * If the transit line changed, reload the relation.
         */
        $this->transitService->load('transitLine');

        $result = $pricingService->calculatePrice($this->transitService);

        $this->priceBreakdown = $result;

        /*
         * Persist only when the actual price changed.
         */
        $service = $pricingService->updatePrice($this->transitService);

        $this->computed_price = $service->computed_price;

        $latestHistory = $service->priceHistories()
            ->latest('created_at')
            ->first();

        if ($latestHistory) {
            $this->priceChange = $latestHistory->change_amount;

            $this->priceChangeDirection = $latestHistory->change_amount > 0
                ? 'up'
                : ($latestHistory->change_amount < 0 ? 'down' : null);
        }

        $this->transitService = $service;
    }

    public function save(TransitServiceService $transitServiceService): void
    {
        try {
            $validated = $this->validate([
                'departure_time' => 'required|date',
                'transit_line_id' => 'required|exists:transit_lines,id',
                'vehicle_type' => 'required|in:' . implode(',', array_column(TransitServiceVehicleType::cases(), 'value')),
                'capacity' => 'required|integer|min:1',
                'occupancy_percentage' => 'required|integer|min:0|max:100',
                'is_vip' => 'boolean',
            ]);

            if ($this->transitService) {
                $transitServiceService->update($this->transitService, $validated);

                $this->toastSuccess(model_trans('transit-service', 'updated'));
            } else {
                $transitService = $transitServiceService->create($validated);

                $this->toastSuccess(model_trans('transit-service', 'created'));

                $this->redirect(
                    route('transit-services.edit', $transitService),
                    true
                );
            }
        } catch (ValidationException $e) {
            $this->toastValidationError();

            throw $e;
        }
    }

    public function render()
    {
        return $this->view()->title(
            $this->transitService
                ? model_trans('transit-service', 'edit')
                : model_trans('transit-service', 'new')
        );
    }
};
