<?php /** @noinspection PhpUndefinedMethodInspection */

namespace App\Traits;

trait ToastR
{
    /**
     * Show success toast using toastr
     */
    protected function toastSuccess(string $message): void
    {
        $this->dispatch('toast',
            type: 'success',
            message: $message
        );
    }

    /**
     * Show error toast using toastr
     */
    protected function toastError(string $message): void
    {
        $this->dispatch('toast',
            type: 'error',
            message: $message
        );
    }

    /**
     * Show warning toast using toastr
     */
    protected function toastWarning(string $message): void
    {
        $this->dispatch('toast',
            type: 'warning',
            message: $message
        );
    }

    /**
     * Show info toast using toastr
     */
    protected function toastInfo(string $message): void
    {
        $this->dispatch('toast',
            type: 'info',
            message: $message
        );
    }

    /**
     * Show toast for validation errors
     */
    protected function toastValidationError(): void
    {
        $this->toastError('لطفاً خطاهای فرم را برطرف کنید.');
    }
}
