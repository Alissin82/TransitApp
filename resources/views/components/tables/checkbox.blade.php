@props([
    'disabled' => false,
])

<label class="flex items-center text-sm font-medium text-gray-700 cursor-pointer select-none dark:text-gray-400">

    <span class="relative flex h-4 w-4 items-center justify-center rounded-sm border-[1.25px] border-gray-300 bg-transparent has-checked:border-brand-500 has-checked:bg-brand-500 dark:border-gray-700">

        <input
                type="checkbox"

                @disabled($disabled)

                {{
                    $attributes->merge([
                        'class' => 'peer absolute inset-0 z-10 cursor-pointer opacity-0',
                    ])
                }}
        />

        <svg
                class="pointer-events-none text-white opacity-0 peer-checked:opacity-100"
                width="10"
                height="10"
                viewBox="0 0 10 10"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
                aria-hidden="true"
        >
            <path
                    d="M8.33317 2.5L3.74984 7.08333L1.6665 5"
                    stroke="currentColor"
                    stroke-width="1.6666"
                    stroke-linecap="round"
                    stroke-linejoin="round"
            />
        </svg>

    </span>

</label>
