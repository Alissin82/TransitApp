<x-layouts.app-content>
    <x-common.page-breadcrumb :pageTitle="__('transit-service.plural')" />

    <div
            class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-white/5 dark:bg-white/3"
            wire:poll.5s="refreshPrices"
    >
        <div class="flex flex-col gap-4 px-4 py-4 border border-b-0 border-gray-100 dark:border-white/5 rounded-t-xl sm:flex-row sm:items-center sm:justify-between">
            <x-tables.per-page wire:model.live="perPage" />

            <div class="flex flex-col w-full gap-3 sm:w-auto sm:flex-row sm:items-center">
                <x-tables.search
                        wire:model.live.debounce.300ms="search"
                        placeholder="{{ __('Search') }}"
                />

                @if($this->hasSelection())
                    <x-tables.button
                            variant="danger"
                            wire:click="deleteSelected"
                            wire:confirm="{{ __('Are you sure you want to delete the selected records?') }}"
                    >
                        {{ __('Delete') }} ({{ count($selectedRows) }})
                    </x-tables.button>
                @endif

                <x-tables.create-button href="{{ route('transit-services.create') }}" wire:navigate>
                    {{ model_trans('transit-service', 'new') }}
                </x-tables.create-button>
            </div>
        </div>

        <div class="max-w-full overflow-x-auto custom-scrollbar">
            <table class="w-full min-w-full">
                <thead class="border-gray-100 border-y bg-gray-50 dark:border-white/5 dark:bg-gray-900">
                <tr>
                    <x-tables.sortable-header
                            field="transitLine.originTerminal.name"
                            :sortBy="$sortField"
                            :sortDirection="$sortDirection"
                    >
                        <x-slot:before>
                            <x-tables.checkbox wire:model.live="selectAll" />
                        </x-slot:before>
                        {{ __('transit-service.fields.origin_terminal') }}
                    </x-tables.sortable-header>

                    <x-tables.sortable-header
                            field="transitLine.destinationTerminal.name"
                            :sortBy="$sortField"
                            :sortDirection="$sortDirection"
                    >
                        {{ __('transit-service.fields.destination_terminal') }}
                    </x-tables.sortable-header>

                    <x-tables.sortable-header
                            field="departure_time"
                            :sortBy="$sortField"
                            :sortDirection="$sortDirection"
                    >
                        {{ __('transit-service.fields.departure_time') }}
                    </x-tables.sortable-header>

                    <x-tables.sortable-header
                            field="vehicle_type"
                            :sortBy="$sortField"
                            :sortDirection="$sortDirection"
                    >
                        {{ __('transit-service.fields.vehicle_type') }}
                    </x-tables.sortable-header>

                    <x-tables.sortable-header
                            field="capacity"
                            :sortBy="$sortField"
                            :sortDirection="$sortDirection"
                    >
                        {{ __('transit-service.fields.capacity') }}
                    </x-tables.sortable-header>

                    <x-tables.sortable-header
                            field="occupancy_percentage"
                            :sortBy="$sortField"
                            :sortDirection="$sortDirection"
                    >
                        {{ __('transit-service.fields.occupancy_percentage') }}
                    </x-tables.sortable-header>

                    <x-tables.sortable-header
                            field="computed_price"
                            :sortBy="$sortField"
                            :sortDirection="$sortDirection"
                    >
                        {{ __('transit-service.fields.computed_price') }}
                    </x-tables.sortable-header>

                    <th scope="col" class="px-4 py-3 text-start border border-gray-100 dark:border-gray-800">
                        <p class="font-medium text-gray-700 text-theme-xs dark:text-gray-400">
                            {{ __('Actions') }}
                        </p>
                    </th>
                </tr>
                </thead>

                <tbody>
                @forelse ($items as $item)
                    <tr class="border-t border-gray-100 dark:border-white/5 {{ in_array($item->id, (array) $selectedRows) ? 'bg-gray-50 dark:bg-gray-900' : '' }}">

                        <x-tables.selectable-cell value="{{ $item->id }}">
                            <span class="block font-medium text-gray-800 text-theme-sm dark:text-white/90">
                                {{ $item->transitLine->originTerminal->name }}
                            </span>
                        </x-tables.selectable-cell>

                        <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
                            <p class="text-gray-700 text-theme-sm dark:text-gray-400">
                                {{ $item->transitLine->destinationTerminal->name }}
                            </p>
                        </td>

                        <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
                            <p class="text-gray-700 text-theme-sm dark:text-gray-400">
                                <x-ui.jalali :datetime="$item->departure_time" format="Y/m/d" />
                                <br>
                                <x-ui.jalali :datetime="$item->departure_time" format="H:i" />
                            </p>
                        </td>

                        <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
                            <p class="text-gray-700 text-theme-sm dark:text-gray-400">
                                {{ $item->vehicle_type->label() }}
                            </p>
                        </td>

                        <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
                            <p class="text-gray-700 text-theme-sm dark:text-gray-400">
                                {{ $item->capacity }}
                            </p>
                        </td>

                        <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
                            <p class="text-gray-700 text-theme-sm dark:text-gray-400">
                                {{ $item->occupancy_percentage }}%
                            </p>
                        </td>

                        <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
                            <div class="flex flex-col gap-1">
                                <p class="font-medium text-gray-700 text-theme-sm dark:text-gray-400">
                                    {{ number_format($item->computed_price ?? 0) }}
                                    {{ __('Tooman') }}
                                </p>

                                @if(isset($priceChanges[$item->id]))
                                    <span
                                            class="text-xs font-medium {{ $priceChanges[$item->id]['direction'] === 'up' ? 'text-red-500' : 'text-green-500' }}"
                                    >
                                        {{ $priceChanges[$item->id]['direction'] === 'up' ? '▲' : '▼' }}
                                        {{ number_format(abs($priceChanges[$item->id]['amount'])) }}
                                    </span>
                                @endif
                            </div>
                        </td>

                        <td class="px-4 py-[17.5px] border border-gray-100 dark:border-gray-800">
                            <x-tables.action-buttons>
                                <x-tables.edit-action
                                        href="{{ route('transit-services.edit', $item->id) }}"
                                />

                                <x-tables.delete-action
                                        wire:click="openDeleteModal({{ $item->id }})"
                                />
                            </x-tables.action-buttons>
                        </td>
                    </tr>
                @empty
                    <x-tables.empty-state colspan="8" />
                @endforelse
                </tbody>
            </table>
        </div>

        <x-tables.pagination :items="$items"/>
    </div>
</x-layouts.app-content>
