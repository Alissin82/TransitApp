<?php

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

    public function delete(int $id, TerminalService $service): void
    {
        $terminal = $service->find($id);

        if (!$terminal) {
            $this->toastError(__('Terminal.Terminal Not Found!'));
            return;
        }

        $service->delete($terminal);
        $this->toastSuccess(__('Terminal.Terminal Deleted Successfully.'));
    }

    public function render(TerminalService $service)
    {
        return $this->view()->with([
            'terminals' => $service->paginate($this->perPage, $this->search)
        ])->title(__('Terminal.Plural'));
    }
};
