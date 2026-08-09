@props([
    'status',
])

@php

    $config = [

        'active' => [
            'color' => 'success',
            'label' => __('Active'),
        ],

        'inactive' => [
            'color' => 'light',
            'label' => __('Inactive'),
        ],

        'scheduled' => [
            'color' => 'primary',
            'label' => __('Scheduled'),
        ],

        'boarding' => [
            'color' => 'warning',
            'label' => __('Boarding'),
        ],

        'departed' => [
            'color' => 'info',
            'label' => __('Departed'),
        ],

        'arrived' => [
            'color' => 'success',
            'label' => __('Arrived'),
        ],

        'cancelled' => [
            'color' => 'error',
            'label' => __('Cancelled'),
        ],

        'pending' => [
            'color' => 'warning',
            'label' => __('Pending'),
        ],

        'confirmed' => [
            'color' => 'success',
            'label' => __('Confirmed'),
        ],

        'expired' => [
            'color' => 'light',
            'label' => __('Expired'),
        ],

        'failed' => [
            'color' => 'error',
            'label' => __('Failed'),
        ],

        'refunded' => [
            'color' => 'info',
            'label' => __('Refunded'),
        ],

        'issued' => [
            'color' => 'success',
            'label' => __('Issued'),
        ],

        'used' => [
            'color' => 'primary',
            'label' => __('Used'),
        ],

    ];

    $item = $config[$status] ?? [
        'color' => 'light',
        'label' => ucfirst($status),
    ];

@endphp

<x-ui.badge
        color="{{ $item['color'] }}"
>
    {{ $item['label'] }}
</x-ui.badge>
