<?php

use App\Models\Terminal;
use App\Services\RegionsService;
use App\Services\TerminalService;
use App\Traits\ToastR;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

new class extends Component
{
    use ToastR;

    public ?Terminal $terminal = null;

    public string $name = '';
    public ?int $province_id = null;
    public ?int $county_id = null;
    public ?int $district_id = null;
    public ?int $settlement_id = null;
    public ?int $village_id = null;

    public array $provinces = [];
    public array $counties = [];
    public array $districts = [];
    public array $settlements = [];
    public array $villages = [];


    public function mount(
        TerminalService $terminalService,
        RegionsService $regionsService,
        $terminal = null
    ): void
    {
        $this->provinces = $regionsService->getProvincesForSelect();

        if ($terminal) {
            $this->terminal = $terminalService->find($terminal->id);

            $this->name = $this->terminal->name;
            $this->province_id = $this->terminal->province_id;
            $this->county_id = $this->terminal->county_id;
            $this->district_id = $this->terminal->district_id;
            $this->settlement_id = $this->terminal->settlement_id;
            $this->village_id = $this->terminal->village_id;

            $this->counties = $regionsService->getCountiesByProvince($this->province_id);
            $this->districts = $regionsService->getDistrictsByCounty($this->county_id);
            $this->settlements = $regionsService->getSettlementsByDistrict($this->district_id);
            $this->villages = $regionsService->getVillagesBySettlement($this->settlement_id);
        }
    }

    public function updatedProvinceId($value, RegionsService $service): void
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
            $this->counties = $service->getCountiesByProvince((int) $value);
        }
    }

    public function updatedCountyId($value, RegionsService $service): void
    {
        $this->district_id = null;
        $this->settlement_id = null;
        $this->village_id = null;
        $this->districts = [];
        $this->settlements = [];
        $this->villages = [];

        if ($value) {
            $this->districts = $service->getDistrictsByCounty((int) $value);
        }
    }

    public function updatedDistrictId($value, RegionsService $service): void
    {
        $this->settlement_id = null;
        $this->village_id = null;
        $this->settlements = [];
        $this->villages = [];

        if ($value) {
            $this->settlements = $service->getSettlementsByDistrict((int) $value);
        }
    }

    public function updatedSettlementId($value, RegionsService $service): void
    {
        $this->village_id = null;
        $this->villages = [];

        if ($value) {
            $this->villages = $service->getVillagesBySettlement((int) $value);
        }
    }

    public function save(TerminalService $service): void
    {
        try {
            $validated = $this->validate([
                'name' => 'required|string|max:255',
                'province_id' => 'required|exists:provinces,id',
                'county_id' => 'required|exists:counties,id',
                'district_id' => 'required|exists:districts,id',
                'settlement_id' => 'required|exists:settlements,id',
                'village_id' => 'nullable|exists:villages,id',
            ]);

            if ($this->terminal) {
                $service->update($this->terminal, $validated);
                $this->toastSuccess(__('Terminal.Record Edited Successfully.'));
            } else {
                $terminal = $service->create($validated);
                $this->toastSuccess(__('Terminal.Record Created Successfully.'));
                $this->redirect(route('terminals.edit',[
                    'id' => $terminal->id,
                ]), true);
            }
        } catch (ValidationException $e) {
            $this->toastValidationError();
            throw $e;
        }
    }

    public function render()
    {
        return $this->view()->title(
            $this->terminal ? $this->terminal->name : __('Terminal.New Record')
        );
    }
};
