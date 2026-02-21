<div class="container py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <a href="{{ request()->url() }}">
                <i class="fas fa-bus me-2"></i>
                {{ $terminal ? __('Terminal.Edit Record') : __('Terminal.New Record') }}
            </a>
        </h2>
        <a href="{{ route('terminals.index') }}" class="btn btn-outline-secondary" wire:navigate>
            <i class="fas fa-arrow-right me-2"></i>
            {{ __('Back') }}
        </a>
    </div>

    <!-- Form -->
    <div class="card">
        <div class="card-body">
            <form wire:submit="save">
                <!-- Name - Full width -->
                <div class="row mb-4">
                    <div class="col-12">
                        <x-mdb.input
                            name="name"
                            :label="__('Terminal.Attributes.Name')"
                            wire:model="name"
                            :active="$terminal != null"
                        />
                    </div>
                </div>

                <!-- Province & County -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <x-mdb.input
                            input-type="select"
                            name="province_id"
                            :label="__('Region.Province')"
                            :options="$provinces"
                            wire:model.live="province_id"
                        />
                    </div>
                    <div class="col-md-6">
                        <x-mdb.input
                            input-type="select"
                            name="county_id"
                            :label="__('Region.County')"
                            :options="$counties"
                            wire:model.live="county_id"
                            :disabled="!$province_id"
                        />
                    </div>
                </div>

                <!-- District & Settlement -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <x-mdb.input
                            input-type="select"
                            name="district_id"
                            :label="__('Region.District')"
                            :options="$districts"
                            wire:model.live="district_id"
                            :disabled="!$county_id"
                        />
                    </div>
                    <div class="col-md-6">
                        <x-mdb.input
                            input-type="select"
                            name="settlement_id"
                            :label="__('Region.Settlement')"
                            :options="$settlements"
                            wire:model.live="settlement_id"
                            :disabled="!$district_id"
                        />
                    </div>
                </div>

                <!-- Village - Full width -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <x-mdb.input
                            input-type="select"
                            name="village_id"
                            :label="__('Region.Village') . ' (' . __('Optional') . ')'"
                            :options="$villages"
                            wire:model="village_id"
                            :disabled="!$settlement_id"
                        />
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>
                        {{ $terminal ? __('Save Changes') : __('Save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
