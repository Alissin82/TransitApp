@props([
    'title' => null,
    'icon' => null,
])

<div
        class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

    <div class="flex items-center gap-3">

        @if($icon)
            <div class="text-brand-500 text-xl">
                {!! $icon !!}
            </div>
        @endif

        <div>

            @if($title)
                <h1
                        class="text-2xl font-semibold text-gray-800 dark:text-white">

                    {{ $title }}

                </h1>
            @endif

        </div>

    </div>

    <div
            class="flex flex-col gap-3 sm:flex-row sm:items-center">

        {{ $actions ?? '' }}

    </div>

</div>
