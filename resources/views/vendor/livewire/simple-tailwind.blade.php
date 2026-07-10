@php
if (! isset($scrollTo)) {
    $scrollTo = 'body';
}

$scrollIntoViewJsSnippet = ($scrollTo !== false)
    ? <<<JS
       (\$el.closest('{$scrollTo}') || document.querySelector('{$scrollTo}')).scrollIntoView()
    JS
    : '';
@endphp

<div dir="rtl" data-theme="corporate">
    @if ($paginator->hasPages())
        <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between gap-3">
            <div>
                @if ($paginator->onFirstPage())
                    <span class="btn btn-sm btn-outline btn-disabled">{{ __('pagination.previous') }}</span>
                @else
                    <button
                        type="button"
                        wire:click="previousPage('{{ $paginator->getPageName() }}')"
                        x-on:click="{{ $scrollIntoViewJsSnippet }}"
                        wire:loading.attr="disabled"
                        dusk="previousPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}"
                        class="btn btn-sm btn-outline"
                    >
                        {{ __('pagination.previous') }}
                    </button>
                @endif
            </div>

            <div>
                @if ($paginator->hasMorePages())
                    <button
                        type="button"
                        wire:click="nextPage('{{ $paginator->getPageName() }}')"
                        x-on:click="{{ $scrollIntoViewJsSnippet }}"
                        wire:loading.attr="disabled"
                        dusk="nextPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}"
                        class="btn btn-sm btn-outline"
                    >
                        {{ __('pagination.next') }}
                    </button>
                @else
                    <span class="btn btn-sm btn-outline btn-disabled">{{ __('pagination.next') }}</span>
                @endif
            </div>
        </nav>
    @endif
</div>
