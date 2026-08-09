<?php

// terminal.php
return [
    'singular' => 'پایانه',
    'plural'   => 'پایانه‌ها',

    'fields' => [
        'name'                => 'نام پایانه',
        'code'                => 'کد پایانه',
        'region'              => 'منطقه',
        'transit_lines_count' => 'تعداد خطوط',
    ],

    'filters' => [
        'select_region' => 'انتخاب منطقه',
        'all_regions'   => 'همه مناطق',
    ],

    'messages' => [
        'has_transit_lines' => 'این ترمینال به :count خط تردد متصل است و قابل حذف نیست. ابتدا خطوط تردد مربوطه را حذف یا اصلاح کنید.',
    ],
];
