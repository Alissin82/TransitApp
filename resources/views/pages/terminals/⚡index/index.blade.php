<div class="container py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <a href="{{ route('terminals.index') }}" wire:navigate>
                <i class="fas fa-bus me-2"></i>
                {{ __('Terminal.Manage Records') }}
            </a>
        </h2>
        <a href="{{ route('terminals.create') }}" class="btn btn-primary" wire:navigate>
            <i class="fas fa-plus me-2"></i>
            {{ __('Terminal.New Record') }}
        </a>
    </div>

    <!-- Search -->
    <div class="card mb-4">
        <div class="card-body">
            <x-forms.input
                    name="searchInput"
                    :label="__('Search')"
                    wire:model.live.debounce.300ms="search"
                    :placeholder="__('Terminal.Search Placeholder')"
            />
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
                <table class="table table-hover align-middle">
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
                        @forelse ($terminals as $terminal)
                            <tr>
                                <td>{{ $terminal->id }}</td>
                                <td>{{ $terminal->name }}</td>
                                <td>{{ $terminal->province->name }}</td>
                                <td>{{ $terminal->county->name }}</td>
                                <td>{{ $terminal->district->name }}</td>
                                <td>{{ $terminal->settlement->name }}</td>
                                <td>{{ $terminal->village->name ?? '-' }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a
                                            href="{{ route('terminals.edit', $terminal) }}"
                                            class="btn btn-warning"
                                            wire:navigate
                                        >
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button
                                            wire:click="delete({{ $terminal->id }})"
                                            wire:confirm="{{ __('Terminal.Record Delete Confirmation') }}"
                                            class="btn btn-danger"
                                        >
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                    {{ __('Terminal.No Records Found') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $terminals->links() }}
            </div>
        </div>
    </div>
</div>
