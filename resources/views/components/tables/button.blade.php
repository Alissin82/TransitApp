@props([
    'variant' => 'default',
])

@php
    $base = '
        flex
        w-full
        items-center
        justify-center
        gap-2
        rounded-lg
        border
        px-4
        py-2.75
        text-sm
        font-medium
        shadow-theme-xs
        sm:w-auto
    ';

    $variants = [
        'default' => '
            border-gray-300
            bg-white
            text-gray-700
            hover:bg-gray-50
            hover:text-gray-800
            dark:border-gray-700
            dark:bg-gray-800
            dark:text-gray-400
            dark:hover:bg-white/3
            dark:hover:text-gray-200
        ',
        'danger' => '
            border-error-300
            bg-white
            text-error-600
            hover:bg-error-50
            hover:text-error-700
            dark:border-error-800
            dark:bg-gray-800
            dark:text-error-400
            dark:hover:bg-error-500/10
            dark:hover:text-error-300
        ',
    ];

    $variantClass = $variants[$variant] ?? $variants['default'];
@endphp

<button
        type="button"
        {{
            $attributes->merge([
                'class' => $base . ' ' . $variantClass,
            ])
        }}
>
    {{ $slot }}
</button>
