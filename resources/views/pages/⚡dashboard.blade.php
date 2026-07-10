<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<div class="container py-4">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold flex items-center gap-2">
            <i class="fa-solid fa-gauge"></i>
            {{ __('Dashboard') }}
        </h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="card bg-base-100 shadow-sm h-full">
            <div class="card-body items-center text-center">
                <i class="fa-solid fa-bus text-5xl text-primary mb-3"></i>
                <h5 class="card-title">{{ __('Terminal.Plural') }}</h5>
                <div class="card-actions mt-3">
                    <a href="{{ route('terminals.index') }}" wire:navigate class="btn btn-primary btn-sm">
                        {{ __('Terminal.Manage Records') }}
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="card bg-base-100 shadow-sm h-full">
            <div class="card-body items-center text-center">
                <i class="fa-solid fa-route text-5xl text-primary mb-3"></i>
                <h5 class="card-title">{{ __('TransitLine.Plural') }}</h5>
                <div class="card-actions mt-3">
                    <a href="{{ route('transit-lines.index') }}" wire:navigate class="btn btn-primary btn-sm">
                        {{ __('TransitLine.Manage Records') }}
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
