<div class="container py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <a href="{{ route('terminals.index') }}" wire:navigate>
                <md-icon class="me-2">directions_bus</md-icon>
                {{ __('Terminal.Manage Records') }}
            </a>
        </h2>
        <md-filled-button href="{{ route('terminals.create') }}" wire:navigate>
            <md-icon slot="icon">add</md-icon>
            {{ __('Terminal.New Record') }}
        </md-filled-button>
    </div>

    <!-- Search -->
    <div class="card mb-4">
        <div class="card-body">
            <md-outlined-text-field
                name="searchInput"
                label="{{ __('Search') }}"
                placeholder="{{ __('Terminal.Search Placeholder') }}"
                wire:model.live.debounce.300ms="search"
                style="width: 100%;"
            >
            </md-outlined-text-field>
        </div>
    </div>

    <!-- Table -->
    <div class="card">
        <div class="card-body">
            <!-- Pagination -->
            <div class="mb-4">
                {{ $terminals->links() }}
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-hover table-group-divider align-middle">
                    <thead class="table-light">
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
                                <td colspan="8" class="text-center text-muted py-4">
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
                                        <div class="d-flex gap-2">
                                            <md-filled-tonal-button
                                                href="{{ route('terminals.edit', $terminal) }}"
                                                wire:navigate
                                            >
                                                <md-icon slot="icon">edit</md-icon>
                                            </md-filled-tonal-button>
                                            <md-filled-button
                                                wire:click="confirmDelete({{ $terminal->id }})"
                                            >
                                                <md-icon slot="icon">delete</md-icon>
                                            </md-filled-button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $terminals->links() }}
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <dialog id="deleteConfirmModal" wire:ignore.self>
        <form method="dialog">
            <div class="modal-content">
                <h3>{{ __('Terminal.Delete Confirmation Title') }}</h3>
                <p>{{ __('Terminal.Delete Confirmation Message') }}</p>
                @if($this->affectedCount > 0)
                    <div class="alert alert-warning">
                        <md-icon class="me-2">warning</md-icon>
                        {{ __('Terminal.Delete Cascade Warning', ['count' => $this->affectedCount]) }}
                    </div>
                @endif
                <div class="d-flex gap-2 justify-content-end mt-4">
                    <md-filled-tonal-button wire:click="cancelDelete()" onclick="document.getElementById('deleteConfirmModal').close()">
                        {{ __('Cancel') }}
                    </md-filled-tonal-button>
                    <md-filled-button wire:click="executeDelete()" onclick="document.getElementById('deleteConfirmModal').close()" class="bg-danger">
                        <md-icon slot="icon">delete</md-icon>
                        {{ __('Delete') }}
                    </md-filled-button>
                </div>
            </div>
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
