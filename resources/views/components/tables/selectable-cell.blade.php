@props([
    'value',
])

<td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
    <div class="flex items-center gap-3">

        <x-tables.checkbox
                value="{{ $value }}"
                wire:model.live="selectedRows"
        />

        <div>
            {{ $slot }}
        </div>

    </div>
</td>
