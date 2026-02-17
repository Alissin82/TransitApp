<?php

use Livewire\Attributes\Title;
use Livewire\Component;

new class extends Component {
    #[Title('خانه')]
};
?>

<div class="d-flex flex-column justify-content-center align-items-center p-3">
    <h1 class="font-weight-bold">سلام دنیا</h1>
    <span wire:poll.keep-alive.1s class="text-muted">{{ now()->format("H:i:s") }}</span>
</div>
