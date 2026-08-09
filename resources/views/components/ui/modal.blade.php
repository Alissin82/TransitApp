@props([
    'showCloseButton' => true,
])

<div
        @click.stop
        {{
            $attributes->merge([
                'class' => '
                    relative
                    mx-auto
                    w-full
                    rounded-3xl
                    bg-white
                    shadow-2xl
                    dark:bg-gray-900
                ',
            ])
        }}
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
>

    {{-- Close Button --}}
    @if($showCloseButton)
        <button
                type="button"
                wire:click="$dispatch('closeModal')"
                class="
                    absolute
                    -top-3
                    -start-3
                    z-20
                    flex
                    h-10
                    w-10
                    items-center
                    justify-center
                    rounded-full
                    bg-error-100
                    text-error-400
                    transition-all
                    duration-200
                    hover:bg-error-200
                    hover:text-error-700
                    focus:outline-none
                    focus:ring-2
                    focus:ring-error-500/20
                    dark:bg-error-800
                    dark:text-error-500
                    dark:hover:bg-error-700
                    dark:hover:text-white
                "
        >
            <i class="fas fa-times"></i>
        </button>
    @endif

    {{ $slot }}

</div>
