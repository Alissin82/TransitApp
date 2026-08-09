@props([
    'field',
    'sortBy' => null,
    'sortDirection' => 'asc',
])

@php
    $isActive = $sortBy === $field;
@endphp

<th scope="col" class="px-4 py-3 text-left border border-gray-100 dark:border-gray-800">
    <div class="flex items-center gap-3">

        {{ $before ?? '' }}

        <button
                type="button"
                wire:click="sortBy('{{ $field }}')"
                class="flex items-center justify-between w-full cursor-pointer"
        >
            <p class="font-medium text-gray-700 text-theme-xs dark:text-gray-400">
                {{ $slot }}
            </p>

            <span class="flex flex-col gap-0.5">

                <svg
                        class="{{ $isActive && $sortDirection === 'asc' ? 'fill-brand-500' : 'fill-gray-300 dark:fill-gray-700' }}"
                        width="8" height="5" viewBox="0 0 8 5" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"
                >
                    <path d="M4.40962 0.585167C4.21057 0.329024 3.82361 0.329024 3.62456 0.585167L0.628696 4.43247C0.377354 4.75536 0.607665 5.22293 1.01669 5.22293H7.01749C7.42652 5.22293 7.65683 4.75536 7.40549 4.43247L4.40962 0.585167Z" fill="" />
                </svg>

                <svg
                        class="{{ $isActive && $sortDirection === 'desc' ? 'fill-brand-500' : 'fill-gray-300 dark:fill-gray-700' }}"
                        width="8" height="5" viewBox="0 0 8 5" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"
                >
                    <path d="M4.40962 4.63933C4.21057 4.89547 3.82361 4.89547 3.62456 4.63933L0.628696 0.792025C0.377354 0.469135 0.607665 0.00156581 1.01669 0.00156581H7.01749C7.42652 0.00156581 7.65683 0.469135 7.40549 0.792025L4.40962 4.63933Z" fill="" />
                </svg>

            </span>
        </button>

    </div>
</th>
