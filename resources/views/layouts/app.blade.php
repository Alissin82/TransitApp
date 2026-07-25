<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        {{ $title ?? 'داشبورد' }}
        |
        سامانه ترابری
    </title>

    {{-- Vite assets: CSS and JS bundles --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Alpine.js: loaded via Vite, not CDN --}}

    {{-- Alpine.js store: theme management --}}
    <script>
        document.addEventListener('alpine:init', () => {
            {{-- Theme store: persists light/dark preference in localStorage --}}
            Alpine.store('theme', {
                init() {
                    const savedTheme = localStorage.getItem('theme');
                    const systemTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' :
                        'light';
                    this.theme = savedTheme || systemTheme;
                    this.updateTheme();
                },
                theme: 'light',
                toggle() {
                    this.theme = this.theme === 'light' ? 'dark' : 'light';
                    localStorage.setItem('theme', this.theme);
                    this.updateTheme();
                },
                updateTheme() {
                    const html = document.documentElement;
                    const body = document.body;
                    if (this.theme === 'dark') {
                        html.classList.add('dark');
                        body.classList.add('dark', 'bg-gray-900');
                    } else {
                        html.classList.remove('dark');
                        body.classList.remove('dark', 'bg-gray-900');
                    }
                }
            });

            {{-- Sidebar store: controls expansion, mobile open, and hover states --}}
            Alpine.store('sidebar', {
                isExpanded: window.innerWidth >= 1280,
                isMobileOpen: false,
                isHovered: false,

                toggleExpanded() {
                    this.isExpanded = !this.isExpanded;
                    // Close mobile menu when toggling desktop sidebar
                    this.isMobileOpen = false;
                },

                toggleMobileOpen() {
                    this.isMobileOpen = !this.isMobileOpen;
                },

                setMobileOpen(val) {
                    this.isMobileOpen = val;
                },

                setHovered(val) {
                    // Only allow hover-to-expand on desktop when sidebar is collapsed
                    if (window.innerWidth >= 1280 && !this.isExpanded) {
                        this.isHovered = val;
                    }
                }
            });
        });
    </script>

    {{-- Inline script: apply dark mode immediately to prevent flash of wrong theme --}}
    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme');
            const systemTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            const theme = savedTheme || systemTheme;
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
                document.body.classList.add('dark', 'bg-gray-900');
            } else {
                document.documentElement.classList.remove('dark');
                document.body.classList.remove('dark', 'bg-gray-900');
            }
        })();
    </script>

</head>

{{-- Body: initializes sidebar state and responsive resize handler --}}
<body
    x-data="{ 'loaded': true}"
    x-init="$store.sidebar.isExpanded = window.innerWidth >= 1280;
    const checkMobile = () => {
        if (window.innerWidth < 1280) {
            $store.sidebar.setMobileOpen(false);
            $store.sidebar.isExpanded = false;
        } else {
            $store.sidebar.isMobileOpen = false;
            $store.sidebar.isExpanded = true;
        }
    };
    window.addEventListener('resize', checkMobile);">

    {{-- Preloader: loading spinner shown on initial page load --}}
    <x-common.preloader/>

    {{-- Main layout: sidebar + content area --}}
    <div class="min-h-screen xl:flex">
        {{-- Mobile backdrop overlay --}}
        @include('layouts.backdrop')
        {{-- Sidebar navigation --}}
        @include('layouts.sidebar')

        {{-- Content area: shifts right/left based on sidebar state --}}
        <div class="flex-1 transition-all duration-300 ease-in-out"
            :class="{
                'xl:ms-72.5': $store.sidebar.isExpanded || $store.sidebar.isHovered,
                'xl:ms-22.5': !$store.sidebar.isExpanded && !$store.sidebar.isHovered,
                'ms-0': $store.sidebar.isMobileOpen
            }">
            {{-- App header --}}
            @include('layouts.app-header')

            {{-- Main page content --}}
            {{-- Supports both slot (component usage) and yield (legacy) --}}
            @if(isset($slot))
                {{ $slot }}
            @else
                @yield('content')
            @endif
        </div>

    </div>

</body>

@stack('scripts')

</html>
