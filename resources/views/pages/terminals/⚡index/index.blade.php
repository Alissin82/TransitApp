<x-layouts.app-content>
    <x-common.page-breadcrumb :pageTitle="__('terminal.plural')" />

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

                <x-tables.create-button href="{{ route('terminals.create') }}" wire:navigate>
                    {{ model_trans('terminal', 'new') }}
                </x-tables.create-button>

            </div>
        </div>

        <div class="max-w-full overflow-x-auto custom-scrollbar">
            <table class="w-full min-w-full">
                <thead class="border-gray-100 border-y bg-gray-50 dark:border-white/5 dark:bg-gray-900">
                <tr>
                    <x-tables.sortable-header field="name" :sortBy="$sortField" :sortDirection="$sortDirection">
                        {{ __('terminal.fields.name') }}
                    </x-tables.sortable-header>

                    <th scope="col" class="px-4 py-3 text-left border border-gray-100 dark:border-gray-800">
                        <p class="font-medium text-gray-700 text-theme-xs dark:text-gray-400">{{ __('Address') }}</p>
                    </th>

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
                        <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
                            <span class="block font-medium text-gray-800 text-theme-sm dark:text-white/90">
                                {{ $item->name }}
                            </span>
                        </td>

                        <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
                            <p class="text-gray-700 text-theme-sm dark:text-gray-400">{{ $item->address }}</p>
                        </td>

                        <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
                            <p class="text-gray-700 text-theme-sm dark:text-gray-400">
                                <x-ui.jalali :datetime="$item->created_at" />
                            </p>
                        </td>

                        <td class="px-4 py-[17.5px] border border-gray-100 dark:border-gray-800">
                            <x-tables.action-buttons>
                                <x-tables.edit-action href="{{ route('terminals.edit', $item->id) }}" />
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
