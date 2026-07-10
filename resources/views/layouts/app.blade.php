<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? config('app.name') }}</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.svg') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
</head>
<body class="flex flex-col min-h-screen">
<header>
    <nav class="navbar bg-base-200 shadow-sm">
        <div class="navbar-start">
            <div class="dropdown">
                <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" />
                    </svg>
                </div>
                <ul tabindex="0" class="menu menu-sm dropdown-content bg-base-100 rounded-box z-10 mt-3 w-52 p-2 shadow">
                    <li><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
                    <li><a href="{{ route('terminals.index') }}">{{ __('Terminal.Plural') }}</a></li>
                    <li><a href="{{ route('transit-lines.index') }}">{{ __('TransitLine.Plural') }}</a></li>
                </ul>
            </div>
            <a class="btn btn-ghost text-xl" href="{{ route('home') }}">
                <img src="{{ asset('logo.svg') }}" alt="Logo" width="30" height="30">
                {{ config('app.name') }}
            </a>
        </div>
        <div class="navbar-center hidden lg:flex">
            <ul class="menu menu-horizontal px-1">
                <li><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
                <li><a href="{{ route('terminals.index') }}">{{ __('Terminal.Plural') }}</a></li>
                <li><a href="{{ route('transit-lines.index') }}">{{ __('TransitLine.Plural') }}</a></li>
            </ul>
        </div>
        <div class="navbar-end">
        </div>
    </nav>
</header>

<main class="container flex-grow">
    {{ $slot }}
</main>

<footer class="footer footer-center bg-base-200 text-base-content p-4">
    <div>{{ __('All rights reserved.') }}</div>
</footer>

@livewireScripts
</body>
</html>
