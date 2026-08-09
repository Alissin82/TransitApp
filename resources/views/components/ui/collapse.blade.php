@props([
    'containerName' => 'collapseContainer',
    'title' => __('Set name'),
    'defaultOpen' => false,
])

@php
    $containerOpen = "{$containerName}Open";
@endphp

<div
        x-data="{ {{ $containerOpen }}: @js($defaultOpen) }"
        class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-white/5 dark:bg-white/3"
>

    <button
            type="button"
            @click="{{ $containerOpen }} = !{{ $containerOpen }}"
            class="flex w-full items-center justify-between gap-2 px-4 py-4"
    >
        <span class="text-sm font-medium text-gray-700 dark:text-gray-400">
            {{ $title }}
        </span>

        <svg
                class="stroke-current text-gray-500 transition-transform duration-200 dark:text-gray-400"
                :class="{{ $containerOpen }} && 'rotate-180'"
                width="20"
                height="20"
                viewBox="0 0 20 20"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
        >
            <path
                    d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396"
                    stroke-width="1.5"
                    stroke-linecap="round"
                    stroke-linejoin="round"
            />
        </svg>
    </button>


    <div
            x-show="{{ $containerOpen }}"
            x-collapse
            class="border-t border-gray-100 dark:border-white/5"
    >
        <div class="p-4">
            {{ $slot }}
        </div>

        @if(isset($footer))
            {{ $footer }}
        @endif
    </div>
</div>
