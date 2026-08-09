<?php

// transit_service.php
return [
    // Model name
    'singular' => 'سرویس تردد',
    'plural'   => 'سرویس‌های تردد',

    // Model-specific fields
    'fields' => [
        'origin_terminal'      => 'ترمینال مبدا',
        'destination_terminal' => 'ترمینال مقصد',
        'transit_line'         => 'خط تردد',
        'departure_time'       => 'زمان حرکت',
        'vehicle_type'         => 'نوع وسیله نقلیه',
        'capacity'             => 'ظرفیت',
        'occupancy_percentage' => 'درصد اشغال',
        'is_vip'               => 'ویژه',
        'computed_price'       => 'قیمت پویا',
        'price_computed_at'    => 'آخرین محاسبه قیمت',
    ],
];
