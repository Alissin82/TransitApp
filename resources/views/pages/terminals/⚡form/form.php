<?php

use App\Models\Terminal;
use App\Services\RegionsService;
use App\Services\TerminalService;
use App\Traits\withRegionSelects;
use App\Traits\withToastNotification;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

new class extends Component
{
    use withToastNotification, withRegionSelects;

    public ?Terminal $terminal = null;

    public string $name = '';

    public function mount(
        TerminalService $terminalService,
        RegionsService $regionsService,
        ?Terminal $terminal = null
    ): void {
        $this->initRegions();

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
                $this->toastSuccess(model_trans('terminal', 'updated'));
            } else {
                $terminal = $service->create($validated);
                $this->toastSuccess(model_trans('terminal', 'created'));
                $this->redirect(route('terminals.edit', $terminal), true);
            }
        } catch (ValidationException $e) {
            $this->toastValidationError();
            throw $e;
        }
    }

    public function render()
    {
        return $this->view()->title(
            $this->terminal ? $this->terminal->name : model_trans('terminal', 'new')
        );
    }
};
