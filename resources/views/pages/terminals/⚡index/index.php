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

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function delete(Terminal $terminal, TerminalService $service): void
    {
        $service->delete($terminal);
        $this->toastSuccess(__('Terminal.Record Deleted Successfully.'));
    }

    public function render(TerminalService $service)
    {
        return $this->view()->with([
            'terminals' => $service->paginate($this->perPage, $this->search)
        ])->title(__('Terminal.Plural'));
    }
};
