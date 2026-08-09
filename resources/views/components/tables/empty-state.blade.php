@props([
    'colspan' => 1,
    'title' => __('No records found'),
    'description' => __('Try adjusting your search or filters'),
])

<tr class="border-t border-gray-100 dark:border-white/5">
    <td colspan="{{ $colspan }}" class="px-4 py-10 text-center border border-gray-100 dark:border-gray-800">
        <div class="flex flex-col items-center justify-center gap-2">

            <svg class="fill-gray-300 dark:fill-gray-700" width="40" height="40" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M3.04175 9.37363C3.04175 5.87693 5.87711 3.04199 9.37508 3.04199C12.8731 3.04199 15.7084 5.87693 15.7084 9.37363C15.7084 12.8703 12.8731 15.7053 9.37508 15.7053C5.87711 15.7053 3.04175 12.8703 3.04175 9.37363ZM9.37508 1.54199C5.04902 1.54199 1.54175 5.04817 1.54175 9.37363C1.54175 13.6991 5.04902 17.2053 9.37508 17.2053C11.2674 17.2053 13.003 16.5344 14.357 15.4176L17.177 18.238C17.4699 18.5309 17.9448 18.5309 18.2377 18.238C18.5306 17.9451 18.5306 17.4703 18.2377 17.1774L15.418 14.3573C16.5365 13.0033 17.2084 11.2669 17.2084 9.37363C17.2084 5.04817 13.7011 1.54199 9.37508 1.54199Z" fill="" />
            </svg>

            <p class="font-medium text-gray-700 text-theme-sm dark:text-gray-400">
                {{ $title }}
            </p>

            <p class="text-sm text-gray-500 dark:text-gray-400">
                {{ $description }}
            </p>

        </div>
    </td>
</tr>
