<div>
    @isset($jsPath)
        <script>{!! file_get_contents($jsPath) !!}</script>
    @endisset
    @isset($cssPath)
        <style>{!! file_get_contents($cssPath) !!}</style>
    @endisset

    <div
            x-data="LivewireUIModal()"
            x-on:close.stop="setShowPropertyTo(false)"
            x-on:keydown.escape.window="show && closeModalOnEscape()"
            x-show="show"
            x-effect="$store.modalLoading.visible = show && !showActiveComponent"
            class="fixed inset-0 z-99999 overflow-y-auto size-full align-center"
            style="display: none;"
    >
        <div class="flex items-center justify-center min-h-dvh px-4 pt-4 pb-10 text-center align-center sm:p-0">
            <div
                    x-show="show"
                    x-on:click="closeModalOnClickAway()"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="fixed inset-0 transition-all transform"
            >
                {{-- Same backdrop as x-ui.base-modal --}}
                <div class="absolute inset-0 bg-black/70 backdrop-blur-sm"></div>
            </div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div
                    x-show="show && showActiveComponent"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-bind:class="modalWidth"
                    class="relative inline-block w-full align-bottom text-start transform transition-all sm:my-8 sm:align-middle sm:w-full"
                    id="modal-container"
                    x-trap.noscroll.inert="show && showActiveComponent"
                    aria-modal="true"
            >
                {{-- No bg/rounded/shadow here on purpose — each child component's
                     view uses <x-ui.wire-modal> for that, so the card look is
                     defined in exactly one place (modal-panel.blade.php). --}}
                @forelse($components as $id => $component)
                    <div x-show.immediate="activeComponent == '{{ $id }}'" x-ref="{{ $id }}" wire:key="{{ $id }}">
                        @livewire($component['name'], $component['arguments'], key($id))
                    </div>
                @empty
                @endforelse
            </div>
        </div>
    </div>

    {{-- Global "opening modal" overlay — shown from the moment openModal() fires
         until the target Livewire component has actually mounted and rendered. --}}
    <div
            x-data
            x-show="$store.modalLoading.visible"
            x-cloak
            x-transition.opacity
            class="fixed inset-0 z-999999 flex items-center justify-center bg-black/40"
            style="display: none;"
    >
        <svg class="h-10 w-10 animate-spin text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z" />
        </svg>
    </div>
</div>
