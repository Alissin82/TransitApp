<div class="container py-4">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold flex items-center gap-2">
            <i class="fa-solid fa-bus"></i>
            {{ $terminal ? __('Terminal.Edit Record') : __('Terminal.New Record') }}
        </h2>
        <a href="{{ route('terminals.index') }}" class="btn btn-outline btn-sm" wire:navigate>
            <i class="fa-solid fa-arrow-right"></i>
            {{ __('Back') }}
        </a>
    </div>

    <div class="card bg-base-100 shadow-sm">
        <div class="card-body">
            <form wire:submit.prevent="save" id="terminal-form">
                <!-- Name -->
                <div class="grid grid-cols-1 mb-4">
                    <div class="form-control">
                        <label class="label" for="name">
                            <span class="label-text">{{ __('Terminal.Attributes.Name') }}</span>
                        </label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            wire:model="name"
                            autocomplete="off"
                            class="input input-bordered w-full @error('name') input-error @enderror"
                        />
                        @error('name')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>
                </div>

                <!-- Region Selects -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div class="form-control">
                        <label class="label" for="province_id">
                            <span class="label-text">{{ __('Region.Province') }}</span>
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
                            <span class="label-text">{{ __('Region.County') }}</span>
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
                            <span class="label-text">{{ __('Region.District') }}</span>
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
                            <span class="label-text">{{ __('Region.Settlement') }}</span>
                        </label>
                        <select
                            id="settlement_id"
                            name="settlement_id"
                            wire:model.live="settlement_id"
                            {{ !$districtId ? 'disabled' : '' }}
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
                            <span class="label-text">{{ __('Region.Village') }} ({{ __('Optional') }})</span>
                        </label>
                        <select
                            id="village_id"
                            name="village_id"
                            wire:model="village_id"
                            {{ !$settlementId ? 'disabled' : '' }}
                            class="select select-bordered w-full"
                        >
                            <option value="">{{ __('Region.Select Village') }}</option>
                            @foreach($villages as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Submit -->
                <div class="flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-floppy-disk"></i>
                        {{ $terminal ? __('Save Changes') : __('Save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
