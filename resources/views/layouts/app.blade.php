<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? config('app.name') }}</title>

    <link rel="icon" href="{{ asset('favicon.svg') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
</head>
<body class="flex flex-col min-h-screen bg-base-100">
<header class="sticky top-0 z-50">
    <nav class="navbar bg-base-200 shadow-sm px-4">
        <div class="navbar-start">
            <div class="dropdown" dir="rtl">
                <div tabindex="0" role="button" class="btn btn-ghost btn-sm lg:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" />
                    </svg>
                </div>
                <ul tabindex="0" class="menu menu-sm dropdown-content bg-base-100 rounded-box z-50 mt-3 w-52 p-2 shadow-lg border border-base-300">
                    <li><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
                    <li><a href="{{ route('terminals.index') }}">{{ __('Terminal.Plural') }}</a></li>
                    <li><a href="{{ route('transit-lines.index') }}">{{ __('TransitLine.Plural') }}</a></li>
                </ul>
            </div>
            <a class="btn btn-ghost text-lg gap-2" href="{{ route('home') }}">
                <img src="{{ asset('logo.svg') }}" alt="Logo" class="w-8 h-8">
                {{ config('app.name') }}
            </a>
        </div>
        <div class="navbar-center hidden lg:flex">
            <ul class="menu menu-horizontal gap-1">
                <li><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
                <li><a href="{{ route('terminals.index') }}">{{ __('Terminal.Plural') }}</a></li>
                <li><a href="{{ route('transit-lines.index') }}">{{ __('TransitLine.Plural') }}</a></li>
            </ul>
        </div>
        <div class="navbar-end">
        </div>
    </nav>
</header>

<main class="container mx-auto px-4 flex-grow py-6">
    {{ $slot }}
</main>

<footer class="footer footer-center bg-base-200 text-base-content p-4 border-t border-base-300">
    <div>{{ __('All rights reserved.') }}</div>
</footer>

@livewireScripts
</body>
</html>
