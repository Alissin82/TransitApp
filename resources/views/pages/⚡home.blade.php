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

<x-layouts.app-content>
    <x-common.page-breadcrumb pageTitle="خالی"/>
    <div class="min-h-screen rounded-2xl border border-gray-200 bg-white px-5 py-7 dark:border-gray-800 dark:bg-white/3 xl:px-10 xl:py-12">
        <div class="mx-auto w-full max-w-157.5 text-center">
            <h3 class="mb-4 font-semibold text-gray-800 text-theme-xl dark:text-white/90 sm:text-2xl">
                خالی
            </h3>

            <p class="text-sm text-gray-500 dark:text-gray-400 sm:text-base">
                این صفحه در این لحظه محتوا قابل نمایش ندارد لطفا از فهرست استفاده کنید و به صفحه مد نظر خود پیمایش کنید.
            </p>

            <p class="flex items-center gap-1 justify-center text-sm text-gray-500 dark:text-gray-400 sm:text-base">
                <i class="fa-regular fa-clock"></i>
                <span wire:poll.keep-alive.1s>{{ now()->format("H:i:s") }}</span>
            </p>
        </div>
    </div>
</x-layouts.app-content>
