<?php

use App\Models\Terminal;
use App\Services\TerminalService;
use App\Traits\ToastR;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use ToastR, WithPagination;

    public int $perPage = 15;
    public string $search = '';
    public ?int $pendingDeleteId = null;

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function confirmDelete(int $terminalId): void
    {
        $this->pendingDeleteId = $terminalId;
        $this->dispatch('show-delete-confirm');
    }

    public function executeDelete(TerminalService $service): void
    {
        if ($this->pendingDeleteId === null) {
            return;
        }

        $terminal = Terminal::find($this->pendingDeleteId);
        if ($terminal) {
            $service->delete($terminal);
            $this->toastSuccess(__('Terminal.Record Deleted Successfully.'));
        }

        $this->pendingDeleteId = null;
    }

    public function cancelDelete(): void
    {
        $this->pendingDeleteId = null;
    }

    public function getAffectedCountProperty(): int
    {
        if ($this->pendingDeleteId === null) {
            return 0;
        }

        $terminal = Terminal::find($this->pendingDeleteId);
        if (!$terminal) {
            return 0;
        }

        return $terminal->departureTransitLines()->count()
            + $terminal->arrivalTransitLines()->count();
    }

    public function render(TerminalService $service)
    {
        return $this->view()->with([
            'terminals' => $service->paginate($this->perPage, $this->search)
        ])->title(__('Terminal.Plural'));
    }
};
