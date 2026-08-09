@props([
    'href',
])

<x-tables.button :href="$href" {{ $attributes }}>

    <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
        <path fill-rule="evenodd" clip-rule="evenodd" d="M10 3.125C10.4142 3.125 10.75 3.46079 10.75 3.875V9.25H16.125C16.5392 9.25 16.875 9.58579 16.875 10C16.875 10.4142 16.5392 10.75 16.125 10.75H10.75V16.125C10.75 16.5392 10.4142 16.875 10 16.875C9.58579 16.875 9.25 16.5392 9.25 16.125V10.75H3.875C3.46079 10.75 3.125 10.4142 3.125 10C3.125 9.58579 3.46079 9.25 3.875 9.25H9.25V3.875C9.25 3.46079 9.58579 3.125 10 3.125Z" fill="" />
    </svg>

    {{ $slot }}

</x-tables.button>
