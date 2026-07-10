<div class="py-4">
    <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
        <h2 class="text-2xl font-bold flex items-center gap-2">
            <i class="fa-solid fa-route text-primary"></i>
            {{ __('TransitLine.Manage Records') }}
        </h2>
        <a href="{{ route('transit-lines.create') }}" class="btn btn-primary btn-sm gap-2" wire:navigate>
            <i class="fa-solid fa-plus"></i>
            {{ __('TransitLine.New Record') }}
        </a>
    </div>

    <!-- Filters -->
    <div class="card bg-base-100 shadow-sm mb-4">
        <div class="collapse collapse-arrow">
            <input type="checkbox" />
            <div class="collapse-title text-lg font-medium flex items-center gap-2">
                <i class="fa-solid fa-filter text-primary"></i>
                {{ __('Filters') }}
            </div>
            <div class="collapse-content">
                <!-- Search -->
                <div class="form-control mb-4">
                    <input
                        type="text"
                        placeholder="{{ __('TransitLine.Search Placeholder') }}"
                        wire:model.live.debounce.300ms="search"
                        class="input input-bordered w-full"
                    />
                </div>

                <!-- Region Filters -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div class="form-control">
                        <label class="label" for="province_id">
                            <span class="label-text font-medium">{{ __('Region.Province') }}</span>
                        </label>
                        <select
                            id="province_id"
                            name="province_id"
                            wire:model.live="province_id"
                            class="select select-bordered w-full"
                        >
                            <option value="">{{ __('Region.All Provinces') }}</option>
                            @foreach($provinces as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-control">
                        <label class="label" for="county_id">
                            <span class="label-text font-medium">{{ __('Region.County') }}</span>
                        </label>
                        <select
                            id="county_id"
                            name="county_id"
                            wire:model.live="county_id"
                            {{ !$province_id ? 'disabled' : '' }}
                            class="select select-bordered w-full"
                        >
                            <option value="">{{ __('Region.All Counties') }}</option>
                            @foreach($counties as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div class="form-control">
                        <label class="label" for="district_id">
                            <span class="label-text font-medium">{{ __('Region.District') }}</span>
                        </label>
                        <select
                            id="district_id"
                            name="district_id"
                            wire:model.live="district_id"
                            {{ !$county_id ? 'disabled' : '' }}
                            class="select select-bordered w-full"
                        >
                            <option value="">{{ __('Region.All Districts') }}</option>
                            @foreach($districts as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-control">
                        <label class="label" for="settlement_id">
                            <span class="label-text font-medium">{{ __('Region.Settlement') }}</span>
                        </label>
                        <select
                            id="settlement_id"
                            name="settlement_id"
                            wire:model.live="settlement_id"
                            {{ !$district_id ? 'disabled' : '' }}
                            class="select select-bordered w-full"
                        >
                            <option value="">{{ __('Region.All Settlements') }}</option>
                            @foreach($settlements as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div class="form-control">
                        <label class="label" for="village_id">
                            <span class="label-text font-medium">{{ __('Region.Village') }}</span>
                        </label>
                        <select
                            id="village_id"
                            name="village_id"
                            wire:model.live="village_id"
                            {{ !$settlement_id ? 'disabled' : '' }}
                            class="select select-bordered w-full"
                        >
                            <option value="">{{ __('Region.All Villages') }}</option>
                            @foreach($villages as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Terminal Filters -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div class="form-control">
                        <label class="label" for="origin_terminal_id">
                            <span class="label-text font-medium">{{ __('TransitLine.Attributes.Origin Terminal') }}</span>
                        </label>
                        <select
                            id="origin_terminal_id"
                            name="origin_terminal_id"
                            wire:model="origin_terminal_id"
                            class="select select-bordered w-full"
                        >
                            <option value="">{{ __('TransitLine.Filters.All Origin Terminals') }}</option>
                            @foreach($originTerminals as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-control">
                        <label class="label" for="destination_terminal_id">
                            <span class="label-text font-medium">{{ __('TransitLine.Attributes.Destination Terminal') }}</span>
                        </label>
                        <select
                            id="destination_terminal_id"
                            name="destination_terminal_id"
                            wire:model="destination_terminal_id"
                            class="select select-bordered w-full"
                        >
                            <option value="">{{ __('TransitLine.Filters.All Destination Terminals') }}</option>
                            @foreach($destinationTerminals as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Price Filters -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div class="form-control">
                        <label class="label" for="min_price">
                            <span class="label-text font-medium">{{ __('Min Price') }}</span>
                        </label>
                        <input
                            type="number"
                            id="min_price"
                            name="min_price"
                            wire:model="min_price"
                            class="input input-bordered w-full"
                        />
                    </div>
                    <div class="form-control">
                        <label class="label" for="max_price">
                            <span class="label-text font-medium">{{ __('Max Price') }}</span>
                        </label>
                        <input
                            type="number"
                            id="max_price"
                            name="max_price"
                            wire:model="max_price"
                            class="input input-bordered w-full"
                        />
                    </div>
                </div>

                <!-- Filter Actions -->
                <div class="flex gap-2">
                    <button class="btn btn-outline btn-sm gap-2" wire:click.prevent="clearFilters">
                        <i class="fa-solid fa-xmark"></i>
                        {{ __('Clear Filters') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="card bg-base-100 shadow-sm">
        <div class="card-body p-0">
            <div class="p-4">
                {{ $transitLines->links() }}
            </div>

            <div class="overflow-x-auto">
                <table class="table table-zebra">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ __('TransitLine.Attributes.Origin Terminal') }}</th>
                        <th>{{ __('TransitLine.Attributes.Destination Terminal') }}</th>
                        <th>{{ __('TransitLine.Attributes.Price') }}</th>
                        <th class="text-center">{{ __('Actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @if($transitLines->count() == 0)
                            <tr>
                                <td colspan="5" class="text-center text-base-content/50 py-8">
                                    <i class="fa-solid fa-inbox text-4xl mb-2 block text-base-content/30"></i>
                                    {{ __('TransitLine.No Records Found') }}
                                </td>
                            </tr>
                        @else
                            @foreach ($transitLines as $transitLine)
                                <tr class="hover">
                                    <td class="font-mono text-sm">{{ $transitLine->id }}</td>
                                    <td>
                                        <div class="flex flex-col">
                                            <span class="font-medium">{{ $transitLine->originTerminal->name }}</span>
                                            <span class="text-xs text-base-content/60">
                                                {{ $transitLine->originTerminal->province->name }}
                                                - {{ $transitLine->originTerminal->county->name }}
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="flex flex-col">
                                            <span class="font-medium">{{ $transitLine->destinationTerminal->name }}</span>
                                            <span class="text-xs text-base-content/60">
                                                {{ $transitLine->destinationTerminal->province->name }}
                                                - {{ $transitLine->destinationTerminal->county->name }}
                                            </span>
                                        </div>
                                    </td>
                                    <td dir="ltr" class="text-end font-mono">{{ number_format($transitLine->price) }}</td>
                                    <td>
                                        <div class="flex gap-1 justify-center">
                                            <a
                                                href="{{ route('transit-lines.edit', $transitLine) }}"
                                                wire:navigate
                                                class="btn btn-ghost btn-xs text-info"
                                                title="{{ __('Edit') }}"
                                            >
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <button
                                                wire:click="confirmDelete({{ $transitLine->id }})"
                                                class="btn btn-ghost btn-xs text-error"
                                                title="{{ __('Delete') }}"
                                            >
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

            <div class="p-4">
                {{ $transitLines->links() }}
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <dialog id="deleteConfirmModal" class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg">{{ __('TransitLine.Delete Confirmation Title') }}</h3>
            <p class="py-4">{{ __('TransitLine.Delete Confirmation Message') }}</p>

            <div class="modal-action">
                <form method="dialog">
                    <button class="btn" wire:click="cancelDelete()">{{ __('Cancel') }}</button>
                </form>
                <form method="dialog">
                    <button class="btn btn-error gap-2" wire:click="executeDelete()">
                        <i class="fa-solid fa-trash"></i>
                        {{ __('Delete') }}
                    </button>
                </form>
            </div>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>

    @script
    <script>
        $wire.on('show-delete-confirm', () => {
            document.getElementById('deleteConfirmModal').showModal();
        });
    </script>
    @endscript
</div>
