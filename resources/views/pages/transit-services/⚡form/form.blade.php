@use(App\Enums\TransitServiceVehicleType)

<x-layouts.app-content>
    <x-common.page-breadcrumb
            :pageTitle="$transitService
                ? model_trans('transit-service', 'edit')
                : model_trans('transit-service', 'create')"
    />

    <div class="flex flex-col gap-5">

        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/3">

            {{-- Card Header --}}
            <div class="px-6 py-5">
                <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                    {{ __('transit-service.singular') }}
                </h3>
            </div>

            {{-- Card Body --}}
            <div class="p-4 border-t border-gray-100 dark:border-gray-800 sm:p-6">
                <form wire:submit.prevent="save">

                    <div class="-mx-2.5 grid grid-cols-2 gap-x-3 gap-y-5">

                        <x-forms.select
                                name="transit_line_id"
                                label="{{ __('transit-service.fields.transit_line') }}"
                                placeholder="{{ __('Select(verb)') }}"
                                :options="$transitLines"
                                :selected="(bool) $transit_line_id"
                                wire:model="transit_line_id"
                        />

                        <x-forms.text
                                name="departure_time"
                                label="{{ __('transit-service.fields.departure_time') }}"
                                wire:model="departure_time"
                                type="datetime-local"
                        />

                        <x-forms.select
                                name="vehicle_type"
                                label="{{ __('transit-service.fields.vehicle_type') }}"
                                placeholder="{{ __('Select(verb)') }}"
                                :options="TransitServiceVehicleType::options()"
                                :selected="(bool) $vehicle_type"
                                wire:model="vehicle_type"
                        />

                        <x-forms.text
                                name="capacity"
                                label="{{ __('transit-service.fields.capacity') }}"
                                wire:model="capacity"
                                type="number"
                                min="1"
                        />

                        <x-forms.text
                                name="occupancy_percentage"
                                label="{{ __('transit-service.fields.occupancy_percentage') }}"
                                wire:model="occupancy_percentage"
                                type="number"
                                min="0"
                                max="100"
                        />

                        <div class="flex items-center gap-3 px-2.5">
                            <input
                                    id="is_vip"
                                    type="checkbox"
                                    wire:model="is_vip"
                                    class="rounded border-gray-300"
                            >

                            <label
                                    for="is_vip"
                                    class="text-sm text-gray-700 dark:text-gray-300"
                            >
                                {{ __('transit-service.fields.is_vip') }}
                            </label>
                        </div>

                        @if($transitService)
                            <div class="col-span-full px-2.5" wire:poll.5s="refreshPrice">
                                <div class="rounded-2xl border border-gray-200 bg-gray-50 p-5 dark:border-gray-800 dark:bg-gray-900">

                                    <div class="flex flex-col gap-5">

                                        {{-- Current Price --}}
                                        <div class="flex items-center justify-between gap-4">
                                            <div>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ __('Current dynamic price') }}
                                                </p>

                                                <p class="mt-1 text-2xl font-bold text-gray-800 dark:text-white">
                                                    {{ number_format($computed_price ?? 0) }}
                                                    <span class="text-sm font-normal text-gray-500">
                                                        {{ __('Tooman') }}
                                                    </span>
                                                </p>
                                            </div>

                                            @if($priceChange !== null && $priceChange != 0)
                                                <div class="text-left">
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                                        {{ __('Last price change') }}
                                                    </p>

                                                    <p
                                                            class="mt-1 text-sm font-bold {{ $priceChangeDirection === 'up'
                                                            ? 'text-red-500'
                                                            : 'text-green-500' }}"
                                                    >
                                                        {{ $priceChangeDirection === 'up' ? '▲' : '▼' }}
                                                        {{ number_format(abs($priceChange)) }}
                                                        {{ __('Tooman') }}
                                                    </p>
                                                </div>
                                            @endif
                                        </div>

                                        {{-- Price Breakdown --}}
                                        <div class="border-t border-gray-200 pt-4 dark:border-gray-800">

                                            <div class="grid grid-cols-2 gap-3 md:grid-cols-3">

                                                <div>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                                        {{ __('Base price') }}
                                                    </p>

                                                    <p class="mt-1 font-medium text-gray-800 dark:text-white">
                                                        {{ number_format($priceBreakdown['base_price'] ?? 0) }}
                                                    </p>
                                                </div>

                                                <div>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                                        {{ __('Distance') }}
                                                    </p>

                                                    <p class="mt-1 font-medium {{ ($priceBreakdown['distance_adjustment'] ?? 0) > 0 ? 'text-red-500' : 'text-gray-800 dark:text-white' }}">
                                                        +{{ number_format($priceBreakdown['distance_adjustment'] ?? 0) }}
                                                        <span class="text-xs">
                                                            ({{ $priceBreakdown['distance_percentage'] ?? 0 }}%)
                                                        </span>
                                                    </p>
                                                </div>

                                                <div>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                                        {{ __('Duration') }}
                                                    </p>

                                                    <p class="mt-1 font-medium {{ ($priceBreakdown['duration_adjustment'] ?? 0) > 0 ? 'text-red-500' : 'text-gray-800 dark:text-white' }}">
                                                        +{{ number_format($priceBreakdown['duration_adjustment'] ?? 0) }}
                                                        <span class="text-xs">
                                                            ({{ $priceBreakdown['duration_percentage'] ?? 0 }}%)
                                                        </span>
                                                    </p>
                                                </div>

                                                <div>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                                        {{ __('Time / last minute') }}
                                                    </p>

                                                    <p class="mt-1 font-medium {{ ($priceBreakdown['time_adjustment'] ?? 0) > 0 ? 'text-red-500' : 'text-gray-800 dark:text-white' }}">
                                                        +{{ number_format($priceBreakdown['time_adjustment'] ?? 0) }}
                                                        <span class="text-xs">
                                                            ({{ $priceBreakdown['time_percentage'] ?? 0 }}%)
                                                        </span>
                                                    </p>
                                                </div>

                                                <div>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                                        {{ __('Occupancy / demand') }}
                                                    </p>

                                                    <p class="mt-1 font-medium {{ ($priceBreakdown['occupancy_adjustment'] ?? 0) > 0 ? 'text-red-500' : 'text-gray-800 dark:text-white' }}">
                                                        +{{ number_format($priceBreakdown['occupancy_adjustment'] ?? 0) }}
                                                        <span class="text-xs">
                                                            ({{ $priceBreakdown['occupancy_percentage'] ?? 0 }}%)
                                                        </span>
                                                    </p>
                                                </div>

                                                <div>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                                        {{ __('VIP') }}
                                                    </p>

                                                    <p class="mt-1 font-medium {{ ($priceBreakdown['vip_adjustment'] ?? 0) > 0 ? 'text-red-500' : 'text-gray-800 dark:text-white' }}">
                                                        +{{ number_format($priceBreakdown['vip_adjustment'] ?? 0) }}
                                                        <span class="text-xs">
                                                            ({{ $priceBreakdown['vip_percentage'] ?? 0 }}%)
                                                        </span>
                                                    </p>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- Actions --}}
                        <div class="col-span-full px-2.5">
                            <div class="mt-1 flex items-center gap-3 border-t border-gray-100 pt-6 dark:border-gray-800">

                                <x-ui.button type="submit">
                                    {{ $transitService ? __('Save changes') : __('Save') }}
                                </x-ui.button>

                                <x-tables.button
                                        href="{{ route('transit-services.index') }}"
                                        wire:navigate
                                >
                                    {{ __('Cancel') }}
                                </x-tables.button>

                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>

    </div>
</x-layouts.app-content>
