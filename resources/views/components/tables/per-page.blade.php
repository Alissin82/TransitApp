@props([
    'label' => __('Show'),
    'suffix' => __('Row'),
    'options' => [10, 25, 50, 100],
    'id' => 'perPage',
])

<div class="flex items-center gap-3">

    <label for="{{ $id }}" class="text-gray-500 dark:text-gray-400">
        {{ $label }}
    </label>

    <div class="relative z-20 bg-transparent">

        <select
                id="{{ $id }}"
                {{
                    $attributes->merge([
                        'class' => '
                            dark:bg-dark-900
                            h-9
                            w-full
                            appearance-none
                            rounded-lg
                            border
                            border-gray-300
                            bg-transparent
                            py-2
                            pl-3
                            pr-8
                            text-sm
                            text-gray-800
                            shadow-theme-xs
                            placeholder:text-gray-400
                            focus:border-brand-300
                            focus:outline-hidden
                            focus:ring-3
                            focus:ring-brand-500/10
                            dark:border-gray-700
                            dark:bg-gray-900
                            dark:text-white/90
                            dark:placeholder:text-white/30
                            dark:focus:border-brand-800
                        '
                    ])
                }}
        >

            @foreach($options as $option)
                <option value="{{ $option }}" class="text-gray-500 dark:bg-gray-900 dark:text-gray-400">
                    {{ $option }}
                </option>
            @endforeach

        </select>

        <span class="absolute z-30 text-gray-500 -translate-y-1/2 right-2 top-1/2 dark:text-gray-400">
            <svg class="stroke-current" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path d="M4 6L8 10L12 6" stroke="" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </span>

    </div>

    <span class="text-gray-500 dark:text-gray-400">
        {{ $suffix }}
    </span>

</div>
