<?php

namespace App\View\Components\ui;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Modal extends Component
{
    public function render(): View|Closure|string
    {
        return view('components.ui.modal');
    }
}
