<?php

// transit_line.php
return [
    // Model name
    'singular' => 'خط تردد',
    'plural'   => 'خطوط تردد',

    // Model-specific fields
    'fields' => [
        'origin_terminal'      => 'پایانه مبدأ',
        'destination_terminal' => 'پایانه مقصد',
        'price'                => 'قیمت',
        'price(Tooman)'        => 'قیمت (تومان)',
    ],

    // Model-specific filters
    'filters' => [
        'select_origin'      => 'انتخاب پایانه مبدأ',
        'select_destination' => 'انتخاب پایانه مقصد',
        'min_price'          => 'حداقل قیمت',
        'max_price'          => 'حداکثر قیمت',
    ],
];
