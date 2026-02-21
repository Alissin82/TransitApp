<div class="container py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <a href="{{ route('transit-lines.index') }}" wire:navigate>
                <i class="fas fa-route me-2"></i>
                {{ __('TransitLine.Manage Records') }}
            </a>
        </h2>
        <a href="{{ route('transit-lines.create') }}" class="btn btn-primary" wire:navigate>
            <i class="fas fa-plus me-2"></i>
            {{ __('TransitLine.New Record') }}
        </a>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <x-mdb.collapse collapse-id="filterCollapse">
            <x-slot:trigger class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-filter me-2"></i>
                    {{ __('Filters') }}
                </h5>
            </x-slot:trigger>
            <x-slot:content class="card-body">
                <!-- Search -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <x-mdb.input
                                name="search"
                                :label="__('TransitLine.Search Label')"
                                wire:model.live.debounce.300ms="search"
                                :placeholder="__('TransitLine.Search Placeholder')"
                        />
                    </div>
                </div>

                <!-- Region Filters -->
                <div class="row">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <x-mdb.input
                                    input-type="select"
                                    name="province_id"
                                    :label="__('Region.Province')"
                                    :options="$provinces"
                                    wire:model.live="province_id"
                                    :placeholder="__('Region.All Provinces')"
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
                                    :placeholder="__('Region.All Counties')"
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
                                    :placeholder="__('Region.All Districts')"
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
                                    :placeholder="__('Region.All Settlements')"
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
                                    :placeholder="__('Region.All Villages')"
                            />
                        </div>
                    </div>
                </div>

                <!-- Terminal Filters -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <x-mdb.input
                                input-type="select"
                                name="origin_terminal_id"
                                :label="__('TransitLine.Attributes.Origin Terminal')"
                                :options="$originTerminals"
                                wire:model="origin_terminal_id"
                                :placeholder="__('TransitLine.Filters.All Origin Terminals')"
                        />
                    </div>
                    <div class="col-md-6">
                        <x-mdb.input
                                input-type="select"
                                name="destination_terminal_id"
                                :label="__('TransitLine.Attributes.Destination Terminal')"
                                :options="$destinationTerminals"
                                wire:model="destination_terminal_id"
                                :placeholder="__('TransitLine.Filters.All Destination Terminals')"
                        />
                    </div>
                </div>

                <!-- Price Filters -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <x-mdb.input
                                name="min_price"
                                :label="__('Min Price')"
                                type="number"
                                wire:model="min_price"
                                :placeholder="__('Min Price')"
                                :active="!empty($min_price)"
                        />
                    </div>
                    <div class="col-md-6">
                        <x-mdb.input
                                name="max_price"
                                :label="__('Max Price')"
                                type="number"
                                wire:model="max_price"
                                :placeholder="__('Max Price')"
                                :active="!empty($max_price)"
                        />
                    </div>
                </div>

                <!-- Filter Actions -->
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary" wire:click.prevent="clearFilters">
                        <i class="fas fa-times me-2"></i>
                        {{ __('Clear Filters') }}
                    </button>
                </div>
            </x-slot:content>
        </x-mdb.collapse>
    </div>

    <!-- Table -->
    <div class="card">
        <div class="card-body">
            <!-- Pagination -->
            <div class="mb-4">
                {{ $transitLines->links() }}
            </div>

            <x-mdb.table :records-count="$transitLines->count()">
                <x-slot:header>
                    <th>#</th>
                    <th>{{ __('TransitLine.Attributes.Origin Terminal') }}</th>
                    <th>{{ __('TransitLine.Attributes.Destination Terminal') }}</th>
                    <th>{{ __('TransitLine.Attributes.Price') }}</th>
                    <th>{{ __('Actions') }}</th>
                </x-slot:header>
                <x-slot:notFound colspan="5">
                    {{ __('TransitLine.No Records Found') }}
                </x-slot:notFound>
                <x-slot:body>
                    @foreach ($transitLines as $transitLine)
                        <tr>
                            <x-table.td :value="$transitLine->id"/>
                            <x-table.td>
                                <strong>{{ $transitLine->originTerminal->name }}</strong>
                                <small class="text-muted">
                                    {{ $transitLine->originTerminal->province->name }}
                                    - {{ $transitLine->originTerminal->county->name }}
                                </small>
                            </x-table.td>
                            <x-table.td>
                                <strong>{{ $transitLine->destinationTerminal->name }}</strong>
                                <small class="text-muted">
                                    {{ $transitLine->destinationTerminal->province->name }}
                                    - {{ $transitLine->destinationTerminal->county->name }}
                                </small>
                            </x-table.td>
                            <x-table.td :value="number_format($transitLine->price)"/>
                            <x-table.td :ltr="true" :column-display="false">
                                <x-mdb.btn-group>
                                    <a
                                            href="{{ route('transit-lines.edit', $transitLine) }}"
                                            class="btn btn-warning"
                                            wire:navigate
                                    >
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button
                                            wire:click="delete({{ $transitLine->id }})"
                                            wire:confirm="{{ __('TransitLine.Record Delete Confirmation') }}"
                                            class="btn btn-danger"
                                    >
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </x-mdb.btn-group>
                            </x-table.td>
                        </tr>
                    @endforeach
                </x-slot:body>
            </x-mdb.table>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $transitLines->links() }}
            </div>
        </div>
    </div>
</div>
