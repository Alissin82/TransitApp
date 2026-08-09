<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait withModal
{
    public function openModal(string $modalComponentClassString, array $params = []): void
    {
        $view = Str::of($modalComponentClassString)
            ->after('App\\Livewire\\')
            ->replace('\\', '.')
            ->kebab()
            ->replace('.-', '.')
            ->lower();

        $this->dispatch(
            'openModal',
            $view->value(),
            $params
        );
    }
}
