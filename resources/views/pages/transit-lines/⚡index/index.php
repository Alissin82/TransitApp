<?php

use App\Models\TransitLine;
use App\Services\RegionsService;
use App\Services\TerminalService;
use App\Services\TransitLineService;
use App\Traits\ToastR;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use ToastR, WithPagination;

    public int $perPage = 15;
    public ?string $search = '';

    // Region filters
    public ?int $province_id = null;
    public ?int $county_id = null;
    public ?int $district_id = null;
    public ?int $settlement_id = null;
    public ?int $village_id = null;

    // Terminal filters
    public ?int $origin_terminal_id = null;
    public ?int $destination_terminal_id = null;

    // Price filters
    public ?int $min_price = null;
    public ?int $max_price = null;

    // Dropdown options
    public array $provinces = [];
    public array $counties = [];
    public array $districts = [];
    public array $settlements = [];
    public array $villages = [];
    public array $originTerminals = [];
    public array $destinationTerminals = [];

    public function mount(RegionsService $service): void
    {
        $this->provinces = $service->getProvincesForSelect();
        $this->min_price = TransitLine::min('price');
        $this->max_price = TransitLine::max('price');
    }

    public function updatedProvinceId($value, RegionsService $regionsService, TerminalService $terminalService): void
    {
        $this->county_id = null;
        $this->district_id = null;
        $this->settlement_id = null;
        $this->village_id = null;
        $this->counties = [];
        $this->districts = [];
        $this->settlements = [];
        $this->villages = [];

        $this->clearTerminals();

        if ($value) {
            $this->counties = $regionsService->getCountiesByProvince($value);
        }

        $this->loadTerminals($terminalService);
    }

    public function updatedCountyId($value, RegionsService $regionsService, TerminalService $terminalService): void
    {
        $this->district_id = null;
        $this->settlement_id = null;
        $this->village_id = null;
        $this->districts = [];
        $this->settlements = [];
        $this->villages = [];

        $this->clearTerminals();

        if ($value) {
            $this->districts = $regionsService->getDistrictsByCounty($value);
        }

        $this->loadTerminals($terminalService);
    }

    public function updatedDistrictId($value, RegionsService $regionsService, TerminalService $terminalService): void
    {
        $this->settlement_id = null;
        $this->village_id = null;
        $this->settlements = [];
        $this->villages = [];

        $this->clearTerminals();

        if ($value) {
            $this->settlements = $regionsService->getSettlementsByDistrict($value);
        }

        $this->loadTerminals($terminalService);
    }

    public function updatedSettlementId($value, RegionsService $regionsService, TerminalService $terminalService): void
    {
        $this->village_id = null;
        $this->villages = [];

        $this->clearTerminals();

        if ($value) {
            $this->villages = $regionsService->getVillagesBySettlement($value);
        }

        $this->loadTerminals($terminalService);
    }

    public function updatedVillageId(TerminalService $service): void
    {
        $this->clearTerminals();

        $this->loadTerminals($service);
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedMinPrice(): void
    {
        $this->resetPage();
    }

    public function updatedMaxPrice(): void
    {
        $this->resetPage();
    }

    public function clearFilters(): void
    {
        $this->search = '';
        $this->min_price = TransitLine::min('price');
        $this->max_price = TransitLine::max('price');
        $this->province_id = null;
        $this->county_id = null;
        $this->district_id = null;
        $this->settlement_id = null;
        $this->village_id = null;
        $this->origin_terminal_id = null;
        $this->destination_terminal_id = null;
        $this->counties = [];
        $this->districts = [];
        $this->settlements = [];
        $this->villages = [];
        $this->originTerminals = [];
        $this->destinationTerminals = [];

        $this->resetPage();
    }

    public function clearTerminals(): void
    {
        if (empty($this->origin_terminal_id)) {
            $this->originTerminals = [];
        }
        if (empty($this->destination_terminal_id)) {
            $this->destinationTerminals = [];
        }
    }

    private function loadTerminals(TerminalService $service): void
    {
        if (empty($this->origin_terminal_id)) {
            $this->originTerminals = $service->getTerminalsForSelect(
                $this->province_id,
                $this->county_id,
                $this->district_id,
                $this->settlement_id,
                $this->village_id
            );
        }
        if (empty($this->destination_terminal_id)) {
            $this->destinationTerminals = $service->getTerminalsForSelect(
                $this->province_id,
                $this->county_id,
                $this->district_id,
                $this->settlement_id,
                $this->village_id
            );
        }
    }

    public function delete(TransitLine $transitLine, TransitLineService $service): void
    {
        $service->delete($transitLine);
        $this->toastSuccess(__('TransitLine.Record Deleted Successfully.'));
    }

    public function render(TransitLineService $service)
    {
        $transitLines = $service->paginate(
            perPage: $this->perPage,
            search: $this->search ?: null,
            provinceId: $this->province_id,
            countyId: $this->county_id,
            districtId: $this->district_id,
            settlementId: $this->settlement_id,
            villageId: $this->village_id,
            minPrice: $this->min_price ?: null,
            maxPrice: $this->max_price ?: null,
            originTerminalId: $this->origin_terminal_id,
            destinationTerminalId: $this->destination_terminal_id
        );

        return $this->view()->with([
            'transitLines' => $transitLines
        ])->title(__('TransitLine.Plural'));
    }
};
