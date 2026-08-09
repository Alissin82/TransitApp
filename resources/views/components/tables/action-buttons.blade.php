<div
        {{
            $attributes->merge([
                'class' => '
                    flex
                    items-center
                    w-full
                    gap-2
                '
            ])
        }}
>
    {{ $slot }}
</div>
