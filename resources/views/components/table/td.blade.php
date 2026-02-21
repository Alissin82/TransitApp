@props([
    'value' => null,
    'ltr' => false,
    'columnDisplay' => true,
])

<td>
    <div
            @class([
                'd-flex',

                'flex-column' => $columnDisplay,
                'align-items-end' => $columnDisplay && $ltr,

                'flex-row' => !$columnDisplay,
                'justify-content-end' => !$columnDisplay && $ltr,
            ])
            {{ $attributes->merge() }}
    >
        {{ $value ?? $slot }}
    </div>
</td>
