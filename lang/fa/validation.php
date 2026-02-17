<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        // Terminal attributes
        'province_id' => 'استان',
        'county_id' => 'شهرستان',
        'district_id' => 'بخش',
        'settlement_id' => 'دهستان/شهر',
        'village_id' => 'روستا',

        // TransitLine attributes
        'price' => 'قیمت',
        'origin_terminal_id' => 'پایانه مبدأ',
        'destination_terminal_id' => 'پایانه مقصد',

        // TransitService attributes
        'departure_time' => 'زمان حرکت',
        'transit_line_id' => 'خط اتوبوس',

        // User attributes
        'password' => 'رمز عبور',
        'role' => 'نقش',
        'email' => 'ایمیل',

        // General attributes
        'name' => 'نام',
        'title' => 'عنوان',
        'description' => 'توضیحات',
        'status' => 'وضعیت',
        'type' => 'نوع',
        'code' => 'کد',
        'date' => 'تاریخ',
        'time' => 'زمان',
        'amount' => 'مبلغ',
        'count' => 'تعداد',
        'file' => 'فایل',
        'image' => 'تصویر',
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ':attribute باید پذیرفته شود.',
    'accepted_if' => ':attribute باید زمانی که :other برابر :value است پذیرفته شود.',
    'active_url' => ':attribute یک URL معتبر نیست.',
    'after' => ':attribute باید تاریخی بعد از :date باشد.',
    'after_or_equal' => ':attribute باید تاریخی بعد یا مساوی با :date باشد.',
    'alpha' => ':attribute فقط باید شامل حروف باشد.',
    'alpha_dash' => ':attribute فقط باید شامل حروف، اعداد، خط تیره و زیرخط باشد.',
    'alpha_num' => ':attribute فقط باید شامل حروف و اعداد باشد.',
    'array' => ':attribute باید یک آرایه باشد.',
    'ascii' => ':attribute فقط باید شامل کاراکترها و نمادهای تک‌بایتی باشد.',
    'before' => ':attribute باید تاریخی قبل از :date باشد.',
    'before_or_equal' => ':attribute باید تاریخی قبل یا مساوی با :date باشد.',
    'between' => [
        'array' => ':attribute باید بین :min و :max آیتم باشد.',
        'file' => ':attribute باید بین :min و :max کیلوبایت باشد.',
        'numeric' => ':attribute باید بین :min و :max باشد.',
        'string' => ':attribute باید بین :min و :max کاراکتر باشد.',
    ],
    'boolean' => ':attribute باید true یا false باشد.',
    'can' => ':attribute شامل مقدار غیرمجاز است.',
    'confirmed' => 'تأییدیه :attribute با مطابقت ندارد.',
    'contains' => ':attribute شامل مقدار مورد نیاز نیست.',
    'current_password' => 'رمز عبور اشتباه است.',
    'date' => ':attribute یک تاریخ معتبر نیست.',
    'date_equals' => ':attribute باید تاریخی مساوی با :date باشد.',
    'date_format' => ':attribute با فرمت :format مطابقت ندارد.',
    'decimal' => ':attribute باید :decimal رقم اعشار داشته باشد.',
    'declined' => ':attribute باید رد شود.',
    'declined_if' => ':attribute باید زمانی که :other برابر :value است رد شود.',
    'different' => ':attribute و :other باید متفاوت باشند.',
    'digits' => ':attribute باید :digits رقم باشد.',
    'digits_between' => ':attribute باید بین :min و :max رقم باشد.',
    'dimensions' => ':attribute ابعاد تصویر نامعتبر است.',
    'distinct' => ':attribute دارای مقدار تکراری است.',
    'doesnt_end_with' => ':attribute نباید با یکی از موارد زیر پایان یابد: :values.',
    'doesnt_start_with' => ':attribute نباید با یکی از موارد زیر شروع شود: :values.',
    'email' => ':attribute باید یک آدرس ایمیل معتبر باشد.',
    'ends_with' => ':attribute باید با یکی از موارد زیر پایان یابد: :values.',
    'enum' => ':attribute انتخاب شده معتبر نیست.',
    'exists' => ':attribute انتخاب شده معتبر نیست.',
    'extensions' => ':attribute باید یکی از پسوندهای زیر را داشته باشد: :values.',
    'file' => ':attribute باید یک فایل باشد.',
    'filled' => ':attribute باید دارای مقدار باشد.',
    'gt' => [
        'array' => ':attribute باید بیشتر از :value آیتم داشته باشد.',
        'file' => ':attribute باید بزرگتر از :value کیلوبایت باشد.',
        'numeric' => ':attribute باید بزرگتر از :value باشد.',
        'string' => ':attribute باید بزرگتر از :value کاراکتر باشد.',
    ],
    'gte' => [
        'array' => ':attribute باید حداقل شامل :value آیتم باشد.',
        'file' => ':attribute باید بزرگتر یا مساوی :value کیلوبایت باشد.',
        'numeric' => ':attribute باید بزرگتر یا مساوی :value باشد.',
        'string' => ':attribute باید بزرگتر یا مساوی :value کاراکتر باشد.',
    ],
    'hex_color' => ':attribute باید یک رنگ شش‌زمینه‌ای معتبر باشد.',
    'image' => ':attribute باید یک تصویر باشد.',
    'in' => ':attribute انتخاب شده معتبر نیست.',
    'in_array' => ':attribute در :other وجود ندارد.',
    'integer' => ':attribute باید یک عدد صحیح باشد.',
    'ip' => ':attribute باید یک آدرس IP معتبر باشد.',
    'ipv4' => ':attribute باید یک آدرس IPv4 معتبر باشد.',
    'ipv6' => ':attribute باید یک آدرس IPv6 معتبر باشد.',
    'json' => ':attribute باید یک رشته JSON معتبر باشد.',
    'list' => ':attribute باید یک لیست باشد.',
    'lowercase' => ':attribute باید با حروف کوچک باشد.',
    'lt' => [
        'array' => ':attribute باید کمتر از :value آیتم داشته باشد.',
        'file' => ':attribute باید کمتر از :value کیلوبایت باشد.',
        'numeric' => ':attribute باید کمتر از :value باشد.',
        'string' => ':attribute باید کمتر از :value کاراکتر باشد.',
    ],
    'lte' => [
        'array' => ':attribute نباید بیشتر از :value آیتم داشته باشد.',
        'file' => ':attribute باید کمتر یا مساوی :value کیلوبایت باشد.',
        'numeric' => ':attribute باید کمتر یا مساوی :value باشد.',
        'string' => ':attribute باید کمتر یا مساوی :value کاراکتر باشد.',
    ],
    'mac_address' => ':attribute باید یک آدرس MAC معتبر باشد.',
    'max' => [
        'array' => ':attribute نباید بیشتر از :max آیتم داشته باشد.',
        'file' => ':attribute نباید بزرگتر از :max کیلوبایت باشد.',
        'numeric' => ':attribute نباید بزرگتر از :max باشد.',
        'string' => ':attribute نباید بزرگتر از :max کاراکتر باشد.',
    ],
    'max_digits' => ':attribute نباید بیشتر از :max رقم داشته باشد.',
    'mimes' => ':attribute باید یک فایل از نوع: :values باشد.',
    'mimetypes' => ':attribute باید یک فایل از نوع: :values باشد.',
    'min' => [
        'array' => ':attribute باید حداقل شامل :min آیتم باشد.',
        'file' => ':attribute باید حداقل :min کیلوبایت باشد.',
        'numeric' => ':attribute باید حداقل :min باشد.',
        'string' => ':attribute باید حداقل :min کاراکتر باشد.',
    ],
    'min_digits' => ':attribute باید حداقل :min رقم داشته باشد.',
    'missing' => ':attribute باید وجود نداشته باشد.',
    'missing_if' => ':attribute زمانی که :other برابر :value است باید وجود نداشته باشد.',
    'missing_unless' => ':attribute باید وجود نداشته باشد مگر اینکه :other برابر :value باشد.',
    'missing_with' => ':attribute زمانی که :values وجود دارد باید وجود نداشته باشد.',
    'missing_with_all' => ':attribute زمانی که :values وجود دارند باید وجود نداشته باشد.',
    'multiple_of' => ':attribute باید مضربی از :value باشد.',
    'not_in' => ':attribute انتخاب شده معتبر نیست.',
    'not_regex' => 'فرمت :attribute معتبر نیست.',
    'numeric' => ':attribute باید یک عدد باشد.',
    'password' => [
        'letters' => ':attribute باید حداقل شامل یک حرف باشد.',
        'mixed' => ':attribute باید حداقل شامل یک حرف بزرگ و یک حرف کوچک باشد.',
        'numbers' => ':attribute باید حداقل شامل یک عدد باشد.',
        'symbols' => ':attribute باید حداقل شامل یک نماد باشد.',
        'uncompromised' => ':attribute داده شده در نشت داده ظاهر شده است. لطفاً :attribute متفاوتی انتخاب کنید.',
    ],
    'present' => ':attribute باید موجود باشد.',
    'present_if' => ':attribute باید زمانی که :other برابر :value است موجود باشد.',
    'present_unless' => ':attribute باید موجود باشد مگر اینکه :other برابر :value باشد.',
    'present_with' => ':attribute باید زمانی که :values موجود است موجود باشد.',
    'present_with_all' => ':attribute باید زمانی که :values موجود هستند موجود باشد.',
    'prohibited' => ':attribute ممنوع است.',
    'prohibited_if' => ':attribute زمانی که :other برابر :value است ممنوع است.',
    'prohibited_if_accepted' => ':attribute زمانی که :other پذیرفته شده است ممنوع است.',
    'prohibited_if_declined' => ':attribute زمانی که :other رد شده است ممنوع است.',
    'prohibited_unless' => ':attribute ممنوع است مگر اینکه :other در :values باشد.',
    'prohibits' => ':attribute از حضور :other منع می‌کند.',
    'regex' => 'فرمت :attribute معتبر نیست.',
    'required' => 'فیلد :attribute الزامی است.',
    'required_array_keys' => ':attribute باید شامل مقادیر: :values باشد.',
    'required_if' => 'فیلد :attribute زمانی که :other برابر :value است الزامی است.',
    'required_if_accepted' => 'فیلد :attribute زمانی که :other پذیرفته شده است الزامی است.',
    'required_if_declined' => 'فیلد :attribute زمانی که :other رد شده است الزامی است.',
    'required_unless' => 'فیلد :attribute الزامی است مگر اینکه :other در :values باشد.',
    'required_with' => 'فیلد :attribute زمانی که :values موجود است الزامی است.',
    'required_with_all' => 'فیلد :attribute زمانی که :values موجود هستند الزامی است.',
    'required_without' => 'فیلد :attribute زمانی که :values موجود نیست الزامی است.',
    'required_without_all' => 'فیلد :attribute زمانی که هیچ‌کدام از :values موجود نیستند الزامی است.',
    'same' => ':attribute باید با :other مطابقت داشته باشد.',
    'size' => [
        'array' => ':attribute باید شامل :size آیتم باشد.',
        'file' => ':attribute باید :size کیلوبایت باشد.',
        'numeric' => ':attribute باید :size باشد.',
        'string' => ':attribute باید :size کاراکتر باشد.',
    ],
    'starts_with' => ':attribute باید با یکی از موارد زیر شروع شود: :values.',
    'string' => ':attribute باید یک رشته باشد.',
    'timezone' => ':attribute باید یک منطقه زمانی معتبر باشد.',
    'unique' => ':attribute قبلاً انتخاب شده است.',
    'uploaded' => ':attribute بارگذاری نشد.',
    'uppercase' => ':attribute باید با حروف بزرگ باشد.',
    'url' => ':attribute باید یک URL معتبر باشد.',
    'ulid' => ':attribute باید یک ULID معتبر باشد.',
    'uuid' => ':attribute باید یک UUID معتبر باشد.',
];
