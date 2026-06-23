<div class="container py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <a href="{{ request()->url() }}">
                <md-icon class="me-2">directions_bus</md-icon>
                {{ $terminal ? __('Terminal.Edit Record') : __('Terminal.New Record') }}
            </a>
        </h2>
        <md-outlined-button href="{{ route('terminals.index') }}" wire:navigate>
            <md-icon slot="icon">arrow_back</md-icon>
            {{ __('Back') }}
        </md-outlined-button>
    </div>

    <!-- Form -->
    <div class="card">
        <div class="card-body">
            <form wire:submit.prevent="save" id="terminal-form">
                <!-- Name - Full width -->
                <div class="row mb-4">
                    <div class="col-12">
                        <x-mdc.text-field.outlined
                                name="name"
                                :label="__('Terminal.Attributes.Name')"
                                wire:model="name"
                                form="terminal-form"
                        />
                    </div>
                </div>

                <!-- Province & County -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <x-mdc.select.outlined
                                name="province_id"
                                label="{{ __('Region.Province') }}"
                                wire:model.live="province_id"
                                form="terminal-form"
                                :headline="__('Region.Select Province')"
                                :options="$provinces"
                        />
                    </div>
                    <div class="col-md-6">
                        <md-outlined-select
                            name="county_id"
                            label="{{ __('Region.County') }}"
                            wire:model.live="county_id"
                            form="terminal-form"
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

                <!-- District & Settlement -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <md-outlined-select
                            name="district_id"
                            label="{{ __('Region.District') }}"
                            wire:model.live="district_id"
                            form="terminal-form"
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
                            form="terminal-form"
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

                <!-- Village - Full width -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <md-outlined-select
                            name="village_id"
                            label="{{ __('Region.Village') }} ({{ __('Optional') }})"
                            wire:model="village_id"
                            form="terminal-form"
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

                <!-- Submit Buttons -->
                <div class="d-flex gap-2">
                    <md-filled-button type="submit">
                        <md-icon slot="icon">save</md-icon>
                        {{ $terminal ? __('Save Changes') : __('Save') }}
                    </md-filled-button>
                </div>
            </form>
        </div>
    </div>
</div>
