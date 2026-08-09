<?php

namespace App\View\Components\ui;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Morilog\Jalali\Jalalian;

class Jalali extends Component
{
    private ?Jalalian $jalali = null;
    private string $format = '';

    /**
     * Create a new component instance.
     */
    public function __construct(?Carbon $datetime = null, string $format = 'Y/m/d H:i:s')
    {
        if ($datetime) {
            $this->jalali = Jalalian::fromCarbon($datetime);
            $this->format = $format;
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ui.jalali', [
            'jalali' => $this->jalali,
            'format' => $this->format,
        ]);
    }
}
