<div class="container py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <a href="{{ request()->url() }}">
                <i class="fas fa-route me-2"></i>
                {{ $transitLine ? __('TransitLine.Edit Record') : __('TransitLine.New Record') }}
            </a>
        </h2>
        <a href="{{ route('transit-lines.index') }}" class="btn btn-outline-secondary" wire:navigate>
            <i class="fas fa-arrow-right me-2"></i>
            {{ __('Back') }}
        </a>
    </div>

    <!-- Form -->
    <div class="card">
        <div class="card-body">
            <!-- Region Filters -->
            <div class="card mb-4">
                <x-mdb.collapse collapse-id="terminalRegionsFilter">
                    <x-slot:trigger class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-filter me-2"></i>
                            {{ __('TransitLine.Filters.Terminals Region') }}
                        </h5>
                    </x-slot:trigger>
                    <x-slot:content class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <x-mdb.input
                                        input-type="select"
                                        name="province_id"
                                        :label="__('Region.Province')"
                                        :options="$provinces"
                                        wire:model.live="province_id"
                                        :placeholder="__('Region.Select Province')"
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
                                        :placeholder="__('Region.Select County')"
                                />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <x-mdb.input
                                        input-type="select"
                                        name="district_id"
                                        :label="__('Region.District')"
                                        :options="$districts"
                                        wire:model.live="district_id"
                                        :disabled="!$county_id"
                                        :placeholder="__('Region.Select District')"
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
                                        :placeholder="__('Region.Select Settlement')"
                                />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <x-mdb.input
                                        input-type="select"
                                        name="village_id"
                                        :label="__('Region.Village')"
                                        :options="$villages"
                                        wire:model.live="village_id"
                                        :disabled="!$settlement_id"
                                        :placeholder="__('Region.Select Village')"
                                />
                            </div>
                        </div>
                        <!-- Filter Actions -->
                        <div class="d-flex gap-2">
                            <button class="btn btn-primary" wire:click.prevent="applyFilters">
                                <i class="fas fa-search me-2"></i>
                                {{ __('Apply Filters') }}
                            </button>
                            <button class="btn btn-outline-secondary" wire:click.prevent="clearFilters">
                                <i class="fas fa-times me-2"></i>
                                {{ __('Clear Filters') }}
                            </button>
                        </div>
                    </x-slot:content>
                </x-mdb.collapse>
            </div>

            <form wire:submit.prevent="save">
                <!-- Transit Line Fields -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <x-mdb.input
                            input-type="select"
                            name="origin_terminal_id"
                            :label="__('TransitLine.Attributes.Origin Terminal')"
                            :options="$originTerminals"
                            wire:model="origin_terminal_id"
                            :active="$transitLine != null"
                        />
                    </div>
                    <div class="col-md-6">
                        <x-mdb.input
                            input-type="select"
                            name="destination_terminal_id"
                            :label="__('TransitLine.Attributes.Destination Terminal')"
                            :options="$destinationTerminals"
                            wire:model="destination_terminal_id"
                            :disabled="!$originTerminals"
                            :active="$transitLine != null"
                        />
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <x-mdb.input
                            name="price"
                            :label="__('TransitLine.Attributes.Price')"
                            type="number"
                            wire:model="price"
                            placeholder="50000"
                            :active="$transitLine != null"
                        />
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>
                        {{ $transitLine ? __('Save Changes') : __('Save') }}
                    </button>
                    <a href="{{ route('transit-lines.index') }}" class="btn btn-outline-secondary" wire:navigate>
                        <i class="fas fa-times me-2"></i>
                        {{ __('Cancel') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
