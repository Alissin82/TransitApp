<x-ui.modal class="max-w-lg">
    <div class="p-6 sm:p-7">
        {{-- Header --}}
        <div>
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                {{ __('Delete Confirmation') }}
            </h3>

            <p class="text-sm leading-6 text-gray-500 dark:text-gray-400">
                {{ __('Are you sure you want to delete this record? This action is irreversible') }}
            </p>
        </div>

        {{-- Actions --}}
        <div class="mt-8 flex items-center gap-3">
            <x-ui.button
                    variant="danger"
                    wire:click="confirm"
            >
                {{ __('Delete') }}
            </x-ui.button>

            <x-ui.button
                    variant="outline"
                    wire:click="$dispatch('closeModal')"
            >
                {{ __('Cancel') }}
            </x-ui.button>
        </div>
    </div>
</x-ui.modal>
