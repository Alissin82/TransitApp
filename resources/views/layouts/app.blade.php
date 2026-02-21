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
<body class="tw:h-screen d-flex flex-column">
<header>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <!-- Toggle button -->
            <button
                    data-mdb-collapse-init
                    class="navbar-toggler"
                    type="button"
                    data-mdb-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
            >
                <i class="fas fa-bars"></i>
            </button>

            <!-- Collapsible wrapper -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Navbar brand -->
                <a class="navbar-brand mt-2 mt-lg-0 d-flex align-items-center gap-2" href="{{ route('home') }}">
                    <img src="{{ asset('logo.svg') }}" alt="TransitApp Logo" width="30" height="30">
                    {{ config('app.name') }}
                </a>
                <!-- Left links -->
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('terminals.index') }}">{{ __('Terminal.Plural') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('transit-lines.index') }}">{{ __('TransitLine.Plural') }}</a>
                    </li>
                </ul>
                <!-- Left links -->
            </div>
            <!-- Collapsible wrapper -->

            <!-- End elements -->
            <div class="d-flex align-items-center">
            </div>
            <!-- End elements -->
        </div>
    </nav>
</header>

<main class="container d-flex flex-column flex-fill tw:*:flex-1">
    {{ $slot }}
</main>

<footer>
    <div class="container-fluid text-center p-3 bg-body-tertiary">
        {{ __('All rights reserved.') }}
    </div>
</footer>

@livewireScripts
</body>
</html>
