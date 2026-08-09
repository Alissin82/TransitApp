@props([
    'containerName' => 'filtersCollapseContainer',
    'title' => __('Filters'),
    'defaultOpen' => false,
])

<x-ui.collapse
        :title="$title"
        :default-open="$defaultOpen"
        :container-name="$containerName"
>
    <div {{ $attributes->merge([
        'class' => "-mx-2.5 grid grid-cols-1 gap-3 p-3"
    ]) }}>
        {{ $slot }}
    </div>

    @if(isset($footer))
        <x-slot:footer>
            <div {{ $footer->attributes->merge([
                'class' => 'flex col-span-full border-t border-gray-100 py-4 pl-4.5 pr-4 dark:border-white/5'
            ]) }}>
                {{ $footer }}
            </div>
        </x-slot:footer>
    @endif
</x-ui.collapse>
