{{-- Preloader: full-screen loading spinner shown on initial page load --}}
<div
  x-data="{ loaded: true }"
  x-show="loaded"
  x-init="
      document.addEventListener('livewire:navigated', () => {
          setTimeout(() => loaded = false, 350)
      });
      document.addEventListener('livewire:navigate', () => {
          loaded = true
      });
  "
  class="fixed start-0 top-0 z-999999 flex h-screen w-screen items-center justify-center bg-white dark:bg-black"
>
  {{-- Spinning circle indicator --}}
  <div
    class="h-16 w-16 animate-spin rounded-full border-4 border-solid border-brand-500 border-t-transparent"
  ></div>
</div>
