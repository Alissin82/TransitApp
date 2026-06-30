<div class="container py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <a href="{{ request()->url() }}">
                <md-icon class="me-2">route</md-icon>
                {{ $transitLine ? __('TransitLine.Edit Record') : __('TransitLine.New Record') }}
            </a>
        </h2>
        <md-outlined-button href="{{ route('transit-lines.index') }}" wire:navigate>
            <md-icon slot="icon">arrow_back</md-icon>
            {{ __('Back') }}
        </md-outlined-button>
    </div>

    <!-- Form -->
    <div class="card">
        <div class="card-body">
            <!-- Region Filters -->
            <div class="card mb-4">
                <div x-data="{ open: false }" class="card">
                    <div
                        class="card-header d-flex justify-content-between align-items-center"
                        role="button"
                        @click="open = !open"
                    >
                        <h5 class="mb-0">
                            <md-icon class="me-2">filter_list</md-icon>
                            {{ __('TransitLine.Filters.Terminals Region') }}
                        </h5>
                        <md-icon x-show="!open">expand_more</md-icon>
                        <md-icon x-show="open">expand_less</md-icon>
                    </div>
                    <div x-show="open" x-collapse class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <md-outlined-select
                                    name="province_id"
                                    label="{{ __('Region.Province') }}"
                                    wire:model.live="province_id"
                                >
                                    <md-select-option value="" disabled selected>
                                        <div slot="headline">{{ __('Region.Select Province') }}</div>
                                    </md-select-option>
                                    @foreach($provinces as $value => $label)
                                        <md-select-option value="{{ $value }}">
                                            <div slot="headline">{{ $label }}</div>
                                        </md-select-option>
                                    @endforeach
                                </md-outlined-select>
                            </div>
                            <div class="col-md-6">
                                <md-outlined-select
                                    name="county_id"
                                    label="{{ __('Region.County') }}"
                                    wire:model.live="county_id"
                                    @disabled(!$province_id)
                                >
                                    <md-select-option value="" disabled selected>
                                        <div slot="headline">{{ __('Region.Select County') }}</div>
                                    </md-select-option>
                                    @foreach($counties as $value => $label)
                                        <md-select-option value="{{ $value }}">
                                            <div slot="headline">{{ $label }}</div>
                                        </md-select-option>
                                    @endforeach
                                </md-outlined-select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <md-outlined-select
                                    name="district_id"
                                    label="{{ __('Region.District') }}"
                                    wire:model.live="district_id"
                                    @disabled(!$county_id)
                                >
                                    <md-select-option value="" disabled selected>
                                        <div slot="headline">{{ __('Region.Select District') }}</div>
                                    </md-select-option>
                                    @foreach($districts as $value => $label)
                                        <md-select-option value="{{ $value }}">
                                            <div slot="headline">{{ $label }}</div>
                                        </md-select-option>
                                    @endforeach
                                </md-outlined-select>
                            </div>
                            <div class="col-md-6">
                                <md-outlined-select
                                    name="settlement_id"
                                    label="{{ __('Region.Settlement') }}"
                                    wire:model.live="settlement_id"
                                    @disabled(!$district_id)
                                >
                                    <md-select-option value="" disabled selected>
                                        <div slot="headline">{{ __('Region.Select Settlement') }}</div>
                                    </md-select-option>
                                    @foreach($settlements as $value => $label)
                                        <md-select-option value="{{ $value }}">
                                            <div slot="headline">{{ $label }}</div>
                                        </md-select-option>
                                    @endforeach
                                </md-outlined-select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <md-outlined-select
                                    name="village_id"
                                    label="{{ __('Region.Village') }}"
                                    wire:model.live="village_id"
                                    @disabled(!$settlement_id)
                                >
                                    <md-select-option value="" disabled selected>
                                        <div slot="headline">{{ __('Region.Select Village') }}</div>
                                    </md-select-option>
                                    @foreach($villages as $value => $label)
                                        <md-select-option value="{{ $value }}">
                                            <div slot="headline">{{ $label }}</div>
                                        </md-select-option>
                                    @endforeach
                                </md-outlined-select>
                            </div>
                        </div>
                        <!-- Filter Actions -->
                        <div class="d-flex gap-2">
                            <md-filled-button wire:click.prevent="applyFilters">
                                <md-icon slot="icon">search</md-icon>
                                {{ __('Apply Filters') }}
                            </md-filled-button>
                            <md-outlined-button wire:click.prevent="clearFilters">
                                <md-icon slot="icon">close</md-icon>
                                {{ __('Clear Filters') }}
                            </md-outlined-button>
                        </div>
                    </div>
                </div>
            </div>

            <form wire:submit.prevent="save" id="transit-line-form">
                <!-- Transit Line Fields -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <md-outlined-select
                            name="origin_terminal_id"
                            label="{{ __('TransitLine.Attributes.Origin Terminal') }}"
                            wire:model="origin_terminal_id"
                            form="transit-line-form"
                        >
                            <md-select-option value="" disabled selected>
                                <div slot="headline">{{ __('TransitLine.Select Origin Terminal') }}</div>
                            </md-select-option>
                            @foreach($originTerminals as $value => $label)
                                <md-select-option value="{{ $value }}">
                                    <div slot="headline">{{ $label }}</div>
                                </md-select-option>
                            @endforeach
                        </md-outlined-select>
                    </div>
                    <div class="col-md-6">
                        <md-outlined-select
                            name="destination_terminal_id"
                            label="{{ __('TransitLine.Attributes.Destination Terminal') }}"
                            wire:model="destination_terminal_id"
                            form="transit-line-form"
                            @disabled(!$originTerminals)
                        >
                            <md-select-option value="" disabled selected>
                                <div slot="headline">{{ __('TransitLine.Select Destination Terminal') }}</div>
                            </md-select-option>
                            @foreach($destinationTerminals as $value => $label)
                                <md-select-option value="{{ $value }}">
                                    <div slot="headline">{{ $label }}</div>
                                </md-select-option>
                            @endforeach
                        </md-outlined-select>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <md-outlined-text-field
                            name="price"
                            label="{{ __('TransitLine.Attributes.Price') }}"
                            type="number"
                            placeholder="50000"
                            wire:model="price"
                            form="transit-line-form"
                            style="width: 100%;"
                        >
                        </md-outlined-text-field>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="d-flex gap-2">
                    <md-filled-button type="submit">
                        <md-icon slot="icon">save</md-icon>
                        {{ $transitLine ? __('Save Changes') : __('Save') }}
                    </md-filled-button>
                    <md-outlined-button href="{{ route('transit-lines.index') }}" wire:navigate>
                        <md-icon slot="icon">close</md-icon>
                        {{ __('Cancel') }}
                    </md-outlined-button>
                </div>
            </form>
        </div>
    </div>
</div>
