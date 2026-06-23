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

<div class="d-flex flex-column justify-content-center align-items-center">
    <h1 class="md-typescale-display-medium">{{ __('Hello World') }}</h1>
    <span wire:poll.keep-alive.1s class="text-muted">{{ now()->format("H:i:s") }}</span>
</div>
