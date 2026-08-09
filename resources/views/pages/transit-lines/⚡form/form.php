<?php

use App\Models\TransitLine;
use App\Services\TerminalService;
use App\Services\TransitLineService;
use App\Traits\withRegionSelects;
use App\Traits\withToastNotification;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

new class extends Component
{
    use withToastNotification, withRegionSelects;

    public ?TransitLine $transitLine = null;

    public ?int $base_price = null;
    public ?int $origin_terminal_id = null;
    public ?int $destination_terminal_id = null;
    public ?int $estimated_distance_km = null;
    public ?int $estimated_duration_min = null;

    public array $originTerminals = [];
    public array $destinationTerminals = [];

    public function mount(
        TransitLineService $transitLineService,
        TerminalService $terminalService,
        ?TransitLine $transitLine = null,
    ): void {
        $this->initRegions();

        if ($transitLine) {
            $this->transitLine = $transitLineService->find($transitLine->id);

            $this->base_price = $this->transitLine->base_price;
            $this->origin_terminal_id = $this->transitLine->origin_terminal_id;
            $this->destination_terminal_id = $this->transitLine->destination_terminal_id;
            $this->estimated_distance_km = $this->transitLine->estimated_distance_km;
            $this->estimated_duration_min = $this->transitLine->estimated_duration_min;

            // Scope each dropdown to the region of its own currently-picked terminal,
            // so the selected value is always present in its own list.
            $origin = $this->transitLine->originTerminal;
            $this->originTerminals = $terminalService->getTerminalsForSelect(
                $origin->province_id,
                $origin->county_id,
                $origin->district_id,
                $origin->settlement_id,
                $origin->village_id,
            );

            $destination = $this->transitLine->destinationTerminal;
            $this->destinationTerminals = $terminalService->getTerminalsForSelect(
                $destination->province_id,
                $destination->county_id,
                $destination->district_id,
                $destination->settlement_id,
                $destination->village_id,
            );
        } else {
            $this->originTerminals = $terminalService->getTerminalsForSelect();
            $this->destinationTerminals = $terminalService->getTerminalsForSelect();
        }
    }

    /**
     * Region selects are wire:model.live (see withRegionSelects). Once the trait's own
     * updated{Field}ID() hook has cascaded/reset the lower selects, this generic hook
     * fires and re-filters the terminal dropdowns to match.
     */
    public function updated(string $name): void
    {
        if (in_array($name, ['province_id', 'county_id', 'district_id', 'settlement_id', 'village_id'], true)) {
            $this->applyRegionFilters(app(TerminalService::class));
        }
    }

    public function resetFilters(): void
    {
        $this->resetRegions();

        $this->applyRegionFilters(app(TerminalService::class));
    }

    protected function applyRegionFilters(TerminalService $service): void
    {
        if ($this->origin_terminal_id && $this->destination_terminal_id) {
            $this->toastInfo('برای مشاهده نتایج فیلتر، باید ترمینال مبدا یا مقصد از انتخاب خارج شود.');

            return;
        }

        if (! $this->origin_terminal_id) {
            $this->originTerminals = $service->getTerminalsForSelect(
                $this->province_id,
                $this->county_id,
                $this->district_id,
                $this->settlement_id,
                $this->village_id,
            );
        }

        if (! $this->destination_terminal_id) {
            $this->destinationTerminals = $service->getTerminalsForSelect(
                $this->province_id,
                $this->county_id,
                $this->district_id,
                $this->settlement_id,
                $this->village_id,
            );
        }
    }

    public function save(TransitLineService $transitLineService): void
    {
        try {
            $validated = $this->validate([
                'base_price' => 'required|integer|min:1',
                'origin_terminal_id' => 'required|exists:terminals,id',
                'destination_terminal_id' => 'required|exists:terminals,id|different:origin_terminal_id',
                'estimated_distance_km' => 'required|integer|min:1',
                'estimated_duration_min' => 'required|integer|min:1',
            ]);

            if ($this->transitLine) {
                $transitLineService->update($this->transitLine, $validated);
                $this->toastSuccess(model_trans('transit-line', 'updated'));
            } else {
                $transitLine = $transitLineService->create($validated);
                $this->toastSuccess(model_trans('transit-line', 'created'));
                $this->redirect(route('transit-lines.edit', $transitLine), true);
            }
        } catch (ValidationException $e) {
            $this->toastValidationError();
            throw $e;
        }
    }

    public function render()
    {
        return $this->view()->title(
            $this->transitLine
                ?
                $this->transitLine->originTerminal->name . ' → ' . $this->transitLine->destinationTerminal->name
                :
                model_trans('transit-line', 'new')
        );
    }
};
