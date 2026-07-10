<div class="py-4">
    <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
        <h2 class="text-2xl font-bold flex items-center gap-2">
            <i class="fa-solid fa-route text-primary"></i>
            {{ $transitLine ? __('TransitLine.Edit Record') : __('TransitLine.New Record') }}
        </h2>
        <a href="{{ route('transit-lines.index') }}" class="btn btn-outline btn-sm gap-2" wire:navigate>
            <i class="fa-solid fa-arrow-right"></i>
            {{ __('Back') }}
        </a>
    </div>

    <div class="card bg-base-100 shadow-sm">
        <div class="card-body">
            <!-- Region Filters -->
            <div class="collapse collapse-arrow bg-base-200 mb-4">
                <input type="checkbox" />
                <div class="collapse-title text-lg font-medium flex items-center gap-2">
                    <i class="fa-solid fa-filter text-primary"></i>
                    {{ __('TransitLine.Filters.Terminals Region') }}
                </div>
                <div class="collapse-content">
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
                                <option value="">{{ __('Region.Select Province') }}</option>
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
                                <option value="">{{ __('Region.Select County') }}</option>
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
                                <option value="">{{ __('Region.Select District') }}</option>
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
                                <option value="">{{ __('Region.Select Settlement') }}</option>
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
                                <option value="">{{ __('Region.Select Village') }}</option>
                                @foreach($villages as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="flex gap-2">
                        <button class="btn btn-primary btn-sm gap-2" wire:click.prevent="applyFilters">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            {{ __('Apply Filters') }}
                        </button>
                        <button class="btn btn-outline btn-sm gap-2" wire:click.prevent="clearFilters">
                            <i class="fa-solid fa-xmark"></i>
                            {{ __('Clear Filters') }}
                        </button>
                    </div>
                </div>
            </div>

            <form wire:submit.prevent="save" id="transit-line-form">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div class="form-control">
                        <label class="label" for="origin_terminal_id">
                            <span class="label-text font-medium">{{ __('TransitLine.Attributes.Origin Terminal') }}</span>
                        </label>
                        <select
                            id="origin_terminal_id"
                            name="origin_terminal_id"
                            wire:model.live="origin_terminal_id"
                            form="transit-line-form"
                            class="select select-bordered w-full"
                        >
                            <option value=""></option>
                            @foreach($originTerminals as $value => $label)
                                <option value="{{ $value }}" {{ (string) $value === (string) $origin_terminal_id ? 'selected' : '' }}>{{ $label }}</option>
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
                            wire:model.live="destination_terminal_id"
                            form="transit-line-form"
                            {{ !$originTerminals ? 'disabled' : '' }}
                            class="select select-bordered w-full"
                        >
                            <option value=""></option>
                            @foreach($destinationTerminals as $value => $label)
                                <option value="{{ $value }}" {{ (string) $value === (string) $destination_terminal_id ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div class="form-control">
                        <label class="label" for="price">
                            <span class="label-text font-medium">{{ __('TransitLine.Attributes.Price') }}</span>
                        </label>
                        <input
                            type="number"
                            id="price"
                            name="price"
                            placeholder="50000"
                            wire:model="price"
                            form="transit-line-form"
                            class="input input-bordered w-full @error('price') input-error @enderror"
                        />
                        @error('price')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="btn btn-primary gap-2">
                        <i class="fa-solid fa-floppy-disk"></i>
                        {{ $transitLine ? __('Save Changes') : __('Save') }}
                    </button>
                    <a href="{{ route('transit-lines.index') }}" class="btn btn-outline gap-2" wire:navigate>
                        <i class="fa-solid fa-xmark"></i>
                        {{ __('Cancel') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
