<?php

use App\Models\TransitLine;
use App\Services\RegionsService;
use App\Services\TerminalService;
use App\Services\TransitLineService;
use App\Traits\ToastR;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

new class extends Component
{
    use ToastR;

    public ?TransitLine $transitLine = null;

    // Form fields
    public ?int $price = null;
    public ?int $origin_terminal_id = null;
    public ?int $destination_terminal_id = null;

    // Region filters for terminal dropdowns
    public ?int $province_id = null;
    public ?int $county_id = null;
    public ?int $district_id = null;
    public ?int $settlement_id = null;
    public ?int $village_id = null;

    // Dropdown options
    public array $provinces = [];
    public array $counties = [];
    public array $districts = [];
    public array $settlements = [];
    public array $villages = [];
    public array $originTerminals = [];
    public array $destinationTerminals = [];

    public function mount(
        TransitLineService $transitLineService,
        TerminalService $terminalService,
        RegionsService $regionsService,
        $transitLine = null
    ): void
    {
        $this->provinces = $regionsService->getProvincesForSelect();

        if ($transitLine) {
            $this->transitLine = $transitLineService->find($transitLine->id);

            $this->price = $this->transitLine->price;
            $this->origin_terminal_id = $this->transitLine->origin_terminal_id;
            $this->destination_terminal_id = $this->transitLine->destination_terminal_id;

            $this->clearFilters();

            $originalTerminal = $this->transitLine->originTerminal;
            $this->originTerminals = $terminalService->getTerminalsForSelect(
                $originalTerminal->province_id,
                $originalTerminal->county_id,
                $originalTerminal->district_id,
                $originalTerminal->settlement_id,
                $originalTerminal->village_id
            );

            $destinationTerminal = $this->transitLine->destinationTerminal;
            $this->destinationTerminals = $terminalService->getTerminalsForSelect(
                $destinationTerminal->province_id,
                $destinationTerminal->county_id,
                $destinationTerminal->district_id,
                $destinationTerminal->settlement_id,
                $destinationTerminal->village_id
            );
        } else {
            // Load all terminals for new transit line
            $this->originTerminals = $terminalService->getTerminalsForSelect();
            $this->destinationTerminals = $terminalService->getTerminalsForSelect();
        }
    }

    public function updatedProvinceId(
        $value,
        RegionsService $regionsService,
        TerminalService $terminalService,
    ): void
    {
        $this->county_id = null;
        $this->district_id = null;
        $this->settlement_id = null;
        $this->village_id = null;
        $this->counties = [];
        $this->districts = [];
        $this->settlements = [];
        $this->villages = [];

        if ($value) {
            $this->counties = $regionsService->getCountiesByProvince($value);
            $this->applyFilters($terminalService);
        }
    }

    public function updatedCountyId(
        $value,
        RegionsService $regionsService,
        TerminalService $terminalService,
    ): void
    {
        $this->district_id = null;
        $this->settlement_id = null;
        $this->village_id = null;
        $this->districts = [];
        $this->settlements = [];
        $this->villages = [];

        if ($value) {
            $this->districts = $regionsService->getDistrictsByCounty($value);
            $this->applyFilters($terminalService);
        }
    }

    public function updatedDistrictId(
        $value,
        RegionsService $regionsService,
        TerminalService $terminalService,
    ): void
    {
        $this->settlement_id = null;
        $this->village_id = null;
        $this->settlements = [];
        $this->villages = [];

        if ($value) {
            $this->settlements = $regionsService->getSettlementsByDistrict($value);
            $this->applyFilters($terminalService);
        }
    }

    public function updatedSettlementId(
        $value,
        RegionsService $regionsService,
        TerminalService $terminalService,
    ): void
    {
        $this->village_id = null;
        $this->villages = [];

        if ($value) {
            $this->villages = $regionsService->getVillagesBySettlement($value);
            $this->applyFilters($terminalService);
        }
    }

    public function updatedVillageId(TerminalService $terminalService): void
    {
        $this->applyFilters($terminalService);
    }

    public function applyFilters(TerminalService $terminalService): void
    {
        if (!empty($this->origin_terminal_id) && !empty($this->destination_terminal_id)) {
            $this->toastInfo("برای مشاهده نتایج فیلتر، باید ترمینال مبدا یا مقصد از انتخاب خارج شود.");
            return;
        }

        if (empty($this->origin_terminal_id)) {
            $this->originTerminals = $terminalService->getTerminalsForSelect(
                provinceId: $this->province_id,
                countyId: $this->county_id,
                districtId: $this->district_id,
                settlementId: $this->settlement_id,
                villageId: $this->village_id,
            );
        }
        if (empty($this->destination_terminal_id)) {
            $this->destinationTerminals = $terminalService->getTerminalsForSelect(
                provinceId: $this->province_id,
                countyId: $this->county_id,
                districtId: $this->district_id,
                settlementId: $this->settlement_id,
                villageId: $this->village_id,
            );
        }

    }

    public function clearFilters(): void
    {
        $this->province_id = null;
        $this->county_id = null;
        $this->district_id = null;
        $this->settlement_id = null;
        $this->village_id = null;

        $this->counties = [];
        $this->districts = [];
        $this->settlements = [];
        $this->villages = [];
    }

    public function save(TransitLineService $service): void
    {
        try {
            $validated = $this->validate([
                'price' => 'required|numeric|min:0',
                'origin_terminal_id' => 'required|exists:terminals,id',
                'destination_terminal_id' => 'required|exists:terminals,id|different:origin_terminal_id',
            ]);

            if ($this->transitLine) {
                $service->update($this->transitLine, $validated);
                $this->toastSuccess(__('TransitLine.Record Updated Successfully.'));
            } else {
                $transitLine = $service->create($validated);
                $this->toastSuccess(__('TransitLine.Record Created Successfully.'));
                $this->redirect(route('transit-lines.edit', [
                    'transitLine' => $transitLine->id,
                ]), true);
            }
        } catch (ValidationException $e) {
            $this->toastValidationError();
            throw $e;
        }
    }

    private function formatTransitLineTitle(): string
    {
        return $this->transitLine->originTerminal->name . ' → ' . $this->transitLine->destinationTerminal->name;
    }

    public function render()
    {
        return $this->view()->title(
            $this->transitLine ? $this->formatTransitLineTitle() : __('TransitLine.New Record')
        );
    }
};
