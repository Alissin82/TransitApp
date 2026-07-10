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
        <nav role="navigation" aria-label="Pagination Navigation" class="flex flex-col gap-3">
            <div class="flex items-center justify-between gap-3 text-sm text-base-content/70">
                <span>
                    {!! __('Showing') !!}
                    <span class="font-semibold text-base-content">{{ $paginator->firstItem() }}</span>
                    {!! __('to') !!}
                    <span class="font-semibold text-base-content">{{ $paginator->lastItem() }}</span>
                    {!! __('of') !!}
                    <span class="font-semibold text-base-content">{{ $paginator->total() }}</span>
                    {!! __('results') !!}
                </span>
            </div>

            <div class="flex flex-wrap items-center justify-center gap-2">
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

                <div class="join">
                    @foreach ($elements as $element)
                        @if (is_string($element))
                            <span class="join-item btn btn-sm btn-disabled">{{ $element }}</span>
                        @endif

                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span class="join-item btn btn-sm btn-primary btn-active" aria-current="page">
                                        {{ $page }}
                                    </span>
                                @else
                                    <button
                                        type="button"
                                        wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')"
                                        x-on:click="{{ $scrollIntoViewJsSnippet }}"
                                        class="join-item btn btn-sm btn-outline"
                                        aria-label="{{ __('Go to page :page', ['page' => $page]) }}"
                                    >
                                        {{ $page }}
                                    </button>
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                </div>

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
