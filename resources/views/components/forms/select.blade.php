@props([
    'name',
    'label',
    'options' => [],
    'placeholder' => null,
    'hint' => null,
    'width' => 'full',
    'selected' => false,
])

<div class="w-full px-2.5 {{ $width === 'half' ? 'xl:w-1/2' : '' }}">

    <label for="{{ $name }}" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
        {{ $label }}

        @if($hint)
            <span class="text-xs text-gray-400">
                ({{ $hint }})
            </span>
        @endif
    </label>

    <div x-data="{ isOptionSelected: @js((bool) $selected) }" class="relative z-20 bg-transparent">

        <select
                id="{{ $name }}"
                :class="isOptionSelected && 'text-gray-800 dark:text-white/90'"
                @change="isOptionSelected = true"

                {{
                    $attributes->merge([
                        'class' => '
                            dark:bg-dark-900
                            shadow-theme-xs
                            h-11
                            w-full
                            appearance-none
                            rounded-lg
                            border
                            bg-transparent
                            bg-none
                            px-4
                            py-2.5
                            pr-11
                            text-sm
                            text-gray-800
                            placeholder:text-gray-400
                            focus:ring-3
                            focus:outline-hidden
                            disabled:border-gray-100
                            disabled:bg-gray-50
                            disabled:text-gray-400
                            disabled:cursor-not-allowed
                            dark:bg-gray-900
                            dark:text-white/90
                            dark:placeholder:text-white/30
                            dark:disabled:border-gray-800
                            dark:disabled:bg-white/[0.03]
                            ' . ($errors->has($name)
                                ? 'border-red-500 focus:border-red-500 focus:ring-red-500/20'
                                : 'border-gray-300 dark:border-gray-700 focus:border-brand-300 dark:focus:border-brand-800 focus:ring-brand-500/10'),
                    ])
                }}
        >
            @if($placeholder)
                <option value="" class="text-gray-500 dark:bg-gray-900 dark:text-gray-400">
                    {{ $placeholder }}
                </option>
            @endif

            @foreach($options as $value => $optionLabel)
                <option value="{{ $value }}" class="text-gray-500 dark:bg-gray-900 dark:text-gray-400">
                    {{ $optionLabel }}
                </option>
            @endforeach
        </select>

        <span class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
            <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </span>

    </div>

    @if($errors->has($name) && !$attributes->get('disabled'))
        <p class="mt-1 text-sm text-red-500">
            {{ $errors->first($name) }}
        </p>
    @endif
</div>
