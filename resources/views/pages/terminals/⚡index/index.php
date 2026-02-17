<?php

use App\Services\TerminalService;
use App\Traits\ToastR;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

new #[Title('پایانه‌ها')]
class extends Component
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

    public function render(TerminalService $service): Illuminate\View\View
    {
        return view('pages.terminals.⚡index.index', [
            'terminals' => $service->paginate($this->perPage, $this->search)
        ]);
    }
};
