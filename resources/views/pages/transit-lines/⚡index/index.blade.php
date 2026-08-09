<x-layouts.app-content>
    <x-common.page-breadcrumb :pageTitle="__('transit-line.plural')" />

    <x-tables.filters-panel class="grid! grid-cols-2!">
        <x-forms.select
                name="province_id"
                label="{{ __('Province') }}"
                placeholder="{{ __('All Provinces') }}"
                :options="$provinces"
                :selected="(bool) $province_id"
                wire:model.live="province_id"
        />
        <x-forms.select
                name="county_id"
                label="{{ __('County') }}"
                placeholder="{{ __('All Counties') }}"
                :options="$counties"
                :selected="(bool) $county_id"
                wire:model.live="county_id"
                :disabled="!$province_id"
        />

        <x-forms.select
                name="district_id"
                label="{{ __('District') }}"
                placeholder="{{ __('All Districts') }}"
                :options="$districts"
                :selected="(bool) $district_id"
                wire:model.live="district_id"
                :disabled="!$county_id"
        />
        <x-forms.select
                name="settlement_id"
                label="{{ __('Settlement') }}"
                placeholder="{{ __('All Settlements') }}"
                :options="$settlements"
                :selected="(bool) $settlement_id"
                wire:model.live="settlement_id"
                :disabled="!$district_id"
        />

        <x-forms.select
                name="village_id"
                label="{{ __('Village') }}"
                hint="{{ __('Optional') }}"
                placeholder="{{ __('All Villages') }}"
                :options="$villages"
                wire:model.live="village_id"
                :disabled="!$settlement_id"
        />

        <br>

        <x-forms.text
                name="min_price"
                label="{{ __('Minimum price(Tooman)') }}"
                wire:model.live.debounce="min_price"
                type="number"
        />

        <x-forms.text
                name="max_price"
                label="{{ __('Maximum price(Tooman)') }}"
                wire:model.live.debounce="max_price"
                type="number"
        />

        <x-slot:footer>
            <x-ui.button
                    variant="outline"
                    wire:click="resetFilters"
            >
                <x-slot name="startIcon">
                    <i class="fa-solid fa-xmark"></i>
                </x-slot>
                {{ __('Reset filters') }}
            </x-ui.button>
        </x-slot:footer>
    </x-tables.filters-panel>

    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-white/5 dark:bg-white/3">
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

                <x-tables.create-button href="{{ route('transit-lines.create') }}" wire:navigate>
                    {{ model_trans('transit-line', 'new') }}
                </x-tables.create-button>
            </div>
        </div>

        <div class="max-w-full overflow-x-auto custom-scrollbar">
            <table class="w-full min-w-full">
                <thead class="border-gray-100 border-y bg-gray-50 dark:border-white/5 dark:bg-gray-900">
                <tr>
                    <x-tables.sortable-header field="originTerminal.name" :sortBy="$sortField" :sortDirection="$sortDirection">
                        <x-slot:before>
                            <x-tables.checkbox wire:model.live="selectAll" />
                        </x-slot:before>
                        {{ __('transit-line.fields.origin_terminal') }}
                    </x-tables.sortable-header>

                    <x-tables.sortable-header field="destinationTerminal.name" :sortBy="$sortField" :sortDirection="$sortDirection">
                        {{ __('transit-line.fields.destination_terminal') }}
                    </x-tables.sortable-header>

                    <x-tables.sortable-header field="base_price" :sortBy="$sortField" :sortDirection="$sortDirection">
                        {{ __('transit-line.fields.base_price') }}
                    </x-tables.sortable-header>

                    <x-tables.sortable-header field="estimated_distance_km" :sortBy="$sortField" :sortDirection="$sortDirection">
                        {{ __('transit-line.fields.estimated_distance_km') }}
                    </x-tables.sortable-header>

                    <x-tables.sortable-header field="estimated_duration_min" :sortBy="$sortField" :sortDirection="$sortDirection">
                        {{ __('transit-line.fields.estimated_duration_min') }}
                    </x-tables.sortable-header>

                    <x-tables.sortable-header field="created_at" :sortBy="$sortField" :sortDirection="$sortDirection">
                        {{ __('Created at') }}
                    </x-tables.sortable-header>

                    <th scope="col" class="px-4 py-3 text-left border border-gray-100 dark:border-gray-800">
                        <p class="font-medium text-gray-700 text-theme-xs dark:text-gray-400">{{ __('Actions') }}</p>
                    </th>
                </tr>
                </thead>

                <tbody>
                @forelse ($items as $item)
                    <tr class="border-t border-gray-100 dark:border-white/5 {{ in_array($item->id, (array) $selectedRows) ? 'bg-gray-50 dark:bg-gray-900' : '' }}">
                        <x-tables.selectable-cell value="{{ $item->id }}">
                            <span class="block font-medium text-gray-800 text-theme-sm dark:text-white/90">
                                {{ $item->originTerminal->name }}
                            </span>
                        </x-tables.selectable-cell>

                        <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
                            <p class="text-gray-700 text-theme-sm dark:text-gray-400">{{ $item->destinationTerminal->name }}</p>
                        </td>

                        <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
                            <p class="text-gray-700 text-theme-sm dark:text-gray-400">{{ $item->base_price }}</p>
                        </td>

                        <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
                            <p class="text-gray-700 text-theme-sm dark:text-gray-400">{{ $item->estimated_distance_km }}</p>
                        </td>

                        <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
                            <p class="text-gray-700 text-theme-sm dark:text-gray-400">{{ $item->estimated_duration_min }}</p>
                        </td>

                        <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
                            <p class="text-gray-700 text-theme-sm dark:text-gray-400">
                                <x-ui.jalali :datetime="$item->created_at" format="Y/m/d"/> <br>
                                <x-ui.jalali :datetime="$item->created_at" format="H:i:s"/>
                            </p>
                        </td>

                        <td class="px-4 py-[17.5px] border border-gray-100 dark:border-gray-800">
                            <x-tables.action-buttons>
                                <x-tables.edit-action href="{{ route('transit-lines.edit', $item->id) }}" />
                                <x-tables.delete-action wire:click="openDeleteModal({{ $item->id }})"/>
                            </x-tables.action-buttons>
                        </td>
                    </tr>
                @empty
                    <x-tables.empty-state colspan="5" />
                @endforelse
                </tbody>
            </table>
        </div>

        <x-tables.pagination :items="$items"/>
    </div>
</x-layouts.app-content>
