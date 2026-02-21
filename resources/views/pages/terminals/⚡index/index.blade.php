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
            <x-mdb.input
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

            <x-mdb.table :records-count="$terminals->count()">
                <x-slot:header>
                    <th>#</th>
                    <th>{{ __('Terminal.Attributes.Name') }}</th>
                    <th>{{ __('Region.Province') }}</th>
                    <th>{{ __('Region.County') }}</th>
                    <th>{{ __('Region.District') }}</th>
                    <th>{{ __('Region.Settlement') }}</th>
                    <th>{{ __('Region.Village') }}</th>
                    <th>{{ __('Actions') }}</th>
                </x-slot:header>
                <x-slot:notFound colspan="8">
                    {{ __('Terminal.No Records Found') }}
                </x-slot:notFound>
                <x-slot:body>
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
                    @endforeach
                </x-slot:body>
            </x-mdb.table>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $terminals->links() }}
            </div>
        </div>
    </div>
</div>
