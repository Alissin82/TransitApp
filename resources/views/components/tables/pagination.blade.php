@php use Illuminate\Pagination\LengthAwarePaginator; @endphp
@props([
    'items',
])

@php
    /** @var LengthAwarePaginator $paginator */
    $paginator = $items;
    $hasPages = $paginator->hasPages();
@endphp

<div class="border-t border-gray-100 py-4 pl-4.5 pr-4 dark:border-white/5">
    <div class="flex flex-col items-center justify-between gap-4 sm:flex-row">
        <p class="pt-3 text-sm font-medium text-center text-gray-500 border-t border-gray-100 dark:border-gray-800 dark:text-gray-400 sm:border-t-0 sm:pt-0 sm:text-left">
            {{ __('placeholders.showing_results', [
                'from'  => $items->firstItem() ?? 0,
                'to'    => $items->lastItem() ?? 0,
                'total' => $items->total(),
            ]) }}
        </p>

        @if ($hasPages)
            @php
                $current = $paginator->currentPage();
                $last = $paginator->lastPage();
                $onFirstPage = $paginator->onFirstPage();
                $hasMorePages = $paginator->hasMorePages();

                if ($last <= 7) {
                    $elements = range(1, $last);
                } elseif ($current <= 4) {
                    $elements = [1, 2, 3, 4, 5, '...', $last];
                } elseif ($current >= $last - 3) {
                    $elements = [1, '...', $last - 4, $last - 3, $last - 2, $last - 1, $last];
                } else {
                    $elements = [1, '...', $current - 1, $current, $current + 1, '...', $last];
                }

                $arrow    = 'flex h-10 items-center justify-center rounded-lg border border-gray-300 bg-white px-3.5 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03]';
                $page     = 'flex h-10 w-10 items-center justify-center rounded-lg text-sm font-medium transition-colors';
                $active   = 'bg-brand-500 text-white';
                $inactive = 'text-gray-700 hover:bg-blue-500/[0.08] hover:text-brand-500 dark:text-gray-400 dark:hover:text-brand-500';
            @endphp

            <div class="flex items-center justify-center gap-1">
                <button
                        type="button"
                        wire:click="previousPage"
                        wire:loading.attr="disabled"
                        @disabled($onFirstPage)
                        class="{{ $arrow }} me-1.5"
                >
                    {{ __('Previous') }}
                </button>

                @foreach ($elements as $element)
                    @if ($element === '...')
                        <span class="{{ $page }} text-gray-400">...</span>
                    @else
                        <button
                                type="button"
                                wire:key="page-{{ $element }}"
                                wire:click="gotoPage({{ $element }})"
                                wire:loading.attr="disabled"
                                class="{{ $page }} {{ $current === $element ? $active : $inactive }}"
                        >
                            {{ $element }}
                        </button>
                    @endif
                @endforeach

                <button
                        type="button"
                        wire:click="nextPage"
                        wire:loading.attr="disabled"
                        @disabled(! $hasMorePages)
                        class="{{ $arrow }} ms-1.5"
                >
                    {{ __('Next') }}
                </button>
            </div>

        @endif
    </div>
</div>

