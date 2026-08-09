document.addEventListener('livewire:init', () => {
    // Livewire toast event handler
    // noinspection JSUnresolvedReference
    Livewire.on('toast', (toast) => {
        console.log('toast', toast);

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
            case 'error':
                window.toastr.error(toast.message, title)
                break;
            case 'warning':
                window.toastr.warning(toast.message, title)
                break;
            default:
                window.toastr.info(toast.message, title)
                break;
        }
    });
});

document.addEventListener('alpine:init', () => {
    Alpine.store('modalLoading', {
        visible: false,
    });
});
