<?php

use App\Livewire\Terminals\Modals\Delete;
use App\Models\Terminal;
use App\Services\TerminalService;
use App\Traits\withModal;
use App\Traits\withTableDelete;
use App\Traits\withToastNotification;
use App\Traits\withDatatable;
use Livewire\Attributes\On;
use Livewire\Component;

new class extends Component
{
    use withToastNotification, withDatatable, withTableDelete, withModal;

    protected string $model = Terminal::class;

    protected string $service = TerminalService::class;

    protected array $sortable = ['name', 'created_at'];
    protected array $searchable = [
        'name',
        'province.name',
        'county.name',
        'district.name',
        'settlement.name',
        'created_at',
    ];

    public function openDeleteModal(int $id): void
    {
        $this->pendingDeleteId = $id;
        $this->openModal(Delete::class, ['id' => $id]);
    }

    #[On('terminal-delete-confirmed')]
    public function onTerminalDeleteConfirmed(int $id): void
    {
        $this->pendingDeleteId = $id;
        $this->executeDelete();
    }

    public function render()
    {
        return $this->view()->with([
            'items' => $this->query()
        ])->title(__('terminal.plural'));
    }
};
