<?php
/** @noinspection PhpUnused */

namespace App\Class;

use LivewireUI\Modal\Contracts\ModalComponent as ModalComponentInterface;

abstract class ModalComponent extends \LivewireUI\Modal\ModalComponent implements ModalComponentInterface
{

    public static function closeModalOnClickAway(): bool
    {
        return true;
    }

    public static function closeModalOnEscape(): bool
    {
        return true;
    }

    public static function closeModalOnEscapeIsForceful(): bool
    {
        return true;
    }

    public static function dispatchCloseEvent(): bool
    {
        return true;
    }

    public static function destroyOnClose(): bool
    {
        return true;
    }

    /**
     * Supported: 'sm', 'md', 'lg', 'xl', '2xl', '3xl', '4xl', '5xl', '6xl', '7xl'
     */
    public static function modalMaxWidth(): string
    {
        return 'xl';
    }
}
