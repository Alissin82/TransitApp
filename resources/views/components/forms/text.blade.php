@props([
    'name',
    'label',
    'hint' => null,
    'width' => 'full',
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

    <input
            id="{{ $name }}"
            autocomplete="off"
            {{
                $attributes->merge([
                    'class' => '
                        dark:bg-dark-900
                        shadow-theme-xs
                        h-11
                        w-full
                        rounded-lg
                        border
                        bg-transparent
                        px-4
                        py-2.5
                        text-sm
                        text-gray-800
                        placeholder:text-gray-400
                        focus:ring-3
                        focus:outline-hidden
                        dark:text-white/90
                        dark:placeholder:text-white/30
                        ' . ($errors->has($name)
                            ? 'border-red-500 focus:border-red-500 focus:ring-red-500/20'
                            : 'border-gray-300 dark:border-gray-700 focus:border-brand-300 dark:focus:border-brand-800 focus:ring-brand-500/10'),
                ])
            }}
    />

    @error($name)
    <p class="mt-1 text-sm text-red-500">
        {{ $message }}
    </p>
    @enderror

</div>
