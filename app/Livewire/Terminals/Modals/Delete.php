<?php

namespace App\Livewire\Terminals\Modals;

use App\Class\ModalComponent;
use Illuminate\View\View;

class Delete extends ModalComponent
{
    public int $id;

    public function mount(int $id): void
    {
        $this->id = $id;
    }

    public function confirm(): void
    {
        $this->dispatch('terminal-delete-confirmed', id: $this->id);
        $this->closeModal();
    }

    public function render(): View
    {
        return view('livewire.terminals.modals.delete');
    }
}
