<?php

use Livewire\Attributes\Title;
use Livewire\Component;

new class extends Component {
    public function render()
    {
        return $this->view()->title(__('Home'));
    }
};
?>

<div class="flex flex-col justify-center items-center min-h-[50vh] gap-4">
    <h1 class="text-4xl font-bold">{{ __('Hello World') }}</h1>
    <div class="flex items-center gap-2 text-base-content/60">
        <i class="fa-regular fa-clock"></i>
        <span wire:poll.keep-alive.1s>{{ now()->format("H:i:s") }}</span>
    </div>
</div>
