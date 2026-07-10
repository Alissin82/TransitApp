@props([
    'value' => null,
    'ltr' => false,
    'columnDisplay' => true,
])

<td>
    <div
            @class([
                'flex',

                'flex-col' => $columnDisplay,
                'items-end' => $columnDisplay && $ltr,

                'flex-row' => !$columnDisplay,
                'justify-end' => !$columnDisplay && $ltr,
            ])
            {{ $attributes->merge() }}
    >
        {{ $value ?? $slot }}
    </div>
</td>
