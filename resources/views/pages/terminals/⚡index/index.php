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
            $this->toastError('پایانه مورد نظر یافت نشد.');
            return;
        }

        $service->delete($terminal);
        $this->toastSuccess('پایانه با موفقیت حذف شد.');
    }

    public function render(TerminalService $service)
    {
        return $this->view()->with([
            'terminals' => $service->paginate($this->perPage, $this->search)
        ])->title(__('terminals'));
    }
};
