document.addEventListener('livewire:init', () => {
    // Livewire toast event handler
    // noinspection JSUnresolvedReference
    Livewire.on('toast', (toast) => {
        const titles = {
            success: 'موفق',
            error: 'خطا',
            warning: 'هشدار',
            info: 'پیام سیستم'
        };

        const title = titles[toast.type] || titles.info;
        
        switch (toast.type) {
            case 'success':
                window.toastr.success(toast.message, title)
                break;
            case 'danger':
                window.toastr.error(toast.message, title)
                break;
            case 'warning':
                window.toastr.warning(toast.message, title)
                break;
            case 'info':
                window.toastr.info(toast.message, title)
                break;
        }
    });
});

document.addEventListener('livewire:navigated', function () {
    document.querySelectorAll('[data-mdb-input-init] input:not([type="hidden"])').forEach(input => {
        const wrapper = input.closest('[data-mdb-input-init]');
        if (!wrapper) return;

        const label = wrapper.querySelector('label');
        const notchMiddle = wrapper.querySelector('.form-notch-middle');

        if (label && notchMiddle) {
            notchMiddle.style.width = `${label.offsetWidth}px`;
        }
    });
});
