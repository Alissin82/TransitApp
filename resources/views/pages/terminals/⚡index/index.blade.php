<div class="container py-4">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold flex items-center gap-2">
            <i class="fa-solid fa-bus"></i>
            {{ __('Terminal.Manage Records') }}
        </h2>
        <a href="{{ route('terminals.create') }}" class="btn btn-primary btn-sm" wire:navigate>
            <i class="fa-solid fa-plus"></i>
            {{ __('Terminal.New Record') }}
        </a>
    </div>

    <!-- Search -->
    <div class="card bg-base-100 shadow-sm mb-4">
        <div class="card-body">
            <div class="form-control">
                <label class="label" for="searchInput">
                    <span class="label-text">{{ __('Search') }}</span>
                </label>
                <input
                    type="text"
                    id="searchInput"
                    name="searchInput"
                    placeholder="{{ __('Terminal.Search Placeholder') }}"
                    wire:model.live.debounce.300ms="search"
                    class="input input-bordered w-full"
                />
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="card bg-base-100 shadow-sm">
        <div class="card-body">
            <div class="mb-4">
                {{ $terminals->links() }}
            </div>

            <div class="overflow-x-auto">
                <table class="table table-zebra table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ __('Terminal.Attributes.Name') }}</th>
                        <th>{{ __('Region.Province') }}</th>
                        <th>{{ __('Region.County') }}</th>
                        <th>{{ __('Region.District') }}</th>
                        <th>{{ __('Region.Settlement') }}</th>
                        <th>{{ __('Region.Village') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @if($terminals->count() == 0)
                            <tr>
                                <td colspan="8" class="text-center text-base-content/50 py-4">
                                    {{ __('Terminal.No Records Found') }}
                                </td>
                            </tr>
                        @else
                            @foreach ($terminals as $terminal)
                                <tr>
                                    <td>{{ $terminal->id }}</td>
                                    <td>{{ $terminal->name }}</td>
                                    <td>{{ $terminal->province->name }}</td>
                                    <td>{{ $terminal->county->name }}</td>
                                    <td>{{ $terminal->district->name }}</td>
                                    <td>{{ $terminal->settlement->name }}</td>
                                    <td>{{ $terminal->village->name ?? '-' }}</td>
                                    <td>
                                        <div class="flex gap-1 justify-center">
                                            <a
                                                href="{{ route('terminals.edit', $terminal) }}"
                                                wire:navigate
                                                class="btn btn-ghost btn-sm"
                                                aria-label="{{ __('Edit') }}"
                                            >
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <button
                                                wire:click="confirmDelete({{ $terminal->id }})"
                                                class="btn btn-ghost btn-sm text-error"
                                                aria-label="{{ __('Delete') }}"
                                            >
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $terminals->links() }}
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <dialog id="deleteConfirmModal" class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg">{{ __('Terminal.Delete Confirmation Title') }}</h3>
            <p class="py-4">{{ __('Terminal.Delete Confirmation Message') }}</p>

            @if($this->affectedCount > 0)
                <div class="alert alert-warning">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span>{{ __('Terminal.Delete Cascade Warning', ['count' => $this->affectedCount]) }}</span>
                </div>
            @endif

            <div class="modal-action">
                <form method="dialog">
                    <button class="btn" wire:click="cancelDelete()">{{ __('Cancel') }}</button>
                </form>
                <form method="dialog">
                    <button class="btn btn-error" wire:click="executeDelete()">
                        <i class="fa-solid fa-trash"></i>
                        {{ __('Delete') }}
                    </button>
                </form>
            </div>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>

    @script
    <script>
        $wire.on('show-delete-confirm', () => {
            document.getElementById('deleteConfirmModal').showModal();
        });
    </script>
    @endscript
</div>
