@props([
    'collapseId' => 'collapseElementId',
    'defaultCollapsed' => true
])

@php
    if (is_string($defaultCollapsed)) {
        $defaultCollapsed = match (strtolower($defaultCollapsed)) {
            'false' => false,
            default => true,
        };
    }
@endphp

<div {{ $attributes }} x-data="{ open: @js(!$defaultCollapsed) }">
    <div
            wire:ignore.self
            @class([
                'position-relative',
                'collapsed' => $defaultCollapsed,
            ])
            data-mdb-collapse-init
            data-mdb-ripple-init
            role="button"
            aria-expanded="{{ $defaultCollapsed ? 'false' : 'true' }}"
            data-mdb-target="#{{ $collapseId }}"
            aria-controls="{{ $collapseId }}"
            @click="open = !open"
    >
        <div {{ $trigger->attributes->merge(['class' => 'flex-fill tw:pe-10']) }}>
            {{ $trigger }}
        </div>
        <div class="position-absolute top-0 end-0 bottom-0 h-100 tw:w-8 d-flex justify-content-center align-items-center">
            <i class="fas fa-chevron-down" x-show="!open"></i>
            <i class="fas fa-chevron-up" x-show="open"></i>
        </div>
    </div>
    @php
        $classShow = !$defaultCollapsed ? 'show' : '';
    @endphp
    <div
            wire:ignore.self
            {{ $content->attributes->merge([
                'class' => "collapse $classShow",
            ]) }}
            id="{{ $collapseId }}"
    > {{ $content }} </div>
</div>
