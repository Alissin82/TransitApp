<div class="container py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <a href="{{ route('transit-lines.index') }}" wire:navigate>
                <md-icon class="me-2">route</md-icon>
                {{ __('TransitLine.Manage Records') }}
            </a>
        </h2>
        <md-filled-button href="{{ route('transit-lines.create') }}" wire:navigate>
            <md-icon slot="icon">add</md-icon>
            {{ __('TransitLine.New Record') }}
        </md-filled-button>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div x-data="{ open: false }" class="card">
            <div
                class="card-header d-flex justify-content-between align-items-center"
                role="button"
                @click="open = !open"
                aria-expanded="x-show='open' ? 'true' : 'false'"
            >
                <h5 class="mb-0">
                    <md-icon class="me-2">filter_list</md-icon>
                    {{ __('Filters') }}
                </h5>
                <md-icon x-show="!open">expand_more</md-icon>
                <md-icon x-show="open">expand_less</md-icon>
            </div>
            <div x-show="open" x-collapse class="card-body">
                <!-- Search -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <md-outlined-text-field
                            name="search"
                            label="{{ __('TransitLine.Search Label') }}"
                            placeholder="{{ __('TransitLine.Search Placeholder') }}"
                            wire:model.live.debounce.300ms="search"
                            style="width: 100%;"
                        >
                        </md-outlined-text-field>
                    </div>
                </div>

                <!-- Region Filters -->
                <div class="row">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <md-outlined-select
                                name="province_id"
                                label="{{ __('Region.Province') }}"
                                wire:model.live="province_id"
                            >
                                <md-select-option value="" disabled selected>
                                    <div slot="headline">{{ __('Region.All Provinces') }}</div>
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
                                    <div slot="headline">{{ __('Region.All Counties') }}</div>
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
                                    <div slot="headline">{{ __('Region.All Districts') }}</div>
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
                                    <div slot="headline">{{ __('Region.All Settlements') }}</div>
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
                                    <div slot="headline">{{ __('Region.All Villages') }}</div>
                                </md-select-option>
                                @foreach($villages as $value => $label)
                                    <md-select-option value="{{ $value }}">
                                        <div slot="headline">{{ $label }}</div>
                                    </md-select-option>
                                @endforeach
                            </md-outlined-select>
                        </div>
                    </div>
                </div>

                <!-- Terminal Filters -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <md-outlined-select
                            name="origin_terminal_id"
                            label="{{ __('TransitLine.Attributes.Origin Terminal') }}"
                            wire:model="origin_terminal_id"
                        >
                            <md-select-option value="" disabled selected>
                                <div slot="headline">{{ __('TransitLine.Filters.All Origin Terminals') }}</div>
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
                        >
                            <md-select-option value="" disabled selected>
                                <div slot="headline">{{ __('TransitLine.Filters.All Destination Terminals') }}</div>
                            </md-select-option>
                            @foreach($destinationTerminals as $value => $label)
                                <md-select-option value="{{ $value }}">
                                    <div slot="headline">{{ $label }}</div>
                                </md-select-option>
                            @endforeach
                        </md-outlined-select>
                    </div>
                </div>

                <!-- Price Filters -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <md-outlined-text-field
                            name="min_price"
                            label="{{ __('Min Price') }}"
                            type="number"
                            placeholder="{{ __('Min Price') }}"
                            wire:model="min_price"
                            style="width: 100%;"
                        >
                        </md-outlined-text-field>
                    </div>
                    <div class="col-md-6">
                        <md-outlined-text-field
                            name="max_price"
                            label="{{ __('Max Price') }}"
                            type="number"
                            placeholder="{{ __('Max Price') }}"
                            wire:model="max_price"
                            style="width: 100%;"
                        >
                        </md-outlined-text-field>
                    </div>
                </div>

                <!-- Filter Actions -->
                <div class="d-flex gap-2">
                    <md-outlined-button wire:click.prevent="clearFilters">
                        <md-icon slot="icon">close</md-icon>
                        {{ __('Clear Filters') }}
                    </md-outlined-button>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="card">
        <div class="card-body">
            <!-- Pagination -->
            <div class="mb-4">
                {{ $transitLines->links() }}
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-hover table-group-divider align-middle">
                    <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>{{ __('TransitLine.Attributes.Origin Terminal') }}</th>
                        <th>{{ __('TransitLine.Attributes.Destination Terminal') }}</th>
                        <th>{{ __('TransitLine.Attributes.Price') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @if($transitLines->count() == 0)
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    {{ __('TransitLine.No Records Found') }}
                                </td>
                            </tr>
                        @else
                            @foreach ($transitLines as $transitLine)
                                <tr>
                                    <td>{{ $transitLine->id }}</td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <strong>{{ $transitLine->originTerminal->name }}</strong>
                                            <small class="text-muted">
                                                {{ $transitLine->originTerminal->province->name }}
                                                - {{ $transitLine->originTerminal->county->name }}
                                            </small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <strong>{{ $transitLine->destinationTerminal->name }}</strong>
                                            <small class="text-muted">
                                                {{ $transitLine->destinationTerminal->province->name }}
                                                - {{ $transitLine->destinationTerminal->county->name }}
                                            </small>
                                        </div>
                                    </td>
                                    <td dir="ltr" style="text-align: right;">{{ number_format($transitLine->price) }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <md-filled-tonal-button
                                                href="{{ route('transit-lines.edit', $transitLine) }}"
                                                wire:navigate
                                            >
                                                <md-icon slot="icon">edit</md-icon>
                                            </md-filled-tonal-button>
                                            <md-filled-button
                                                wire:click="delete({{ $transitLine->id }})"
                                                wire:confirm="{{ __('TransitLine.Record Delete Confirmation') }}"
                                            >
                                                <md-icon slot="icon">delete</md-icon>
                                            </md-filled-button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $transitLines->links() }}
            </div>
        </div>
    </div>
</div>
