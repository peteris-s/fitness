<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">
        <div class="min-h-screen bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">
            @include('layouts.navigation')

            
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main>
                @isset($slot)
                    {{ $slot }}
                @else
                    @yield('content')
                @endisset
            </main>
        </div>
        <script>
            (function () {
                const storedTheme = localStorage.getItem('theme');
                const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
                const htmlEl = document.documentElement;

                function setTheme(theme) {
                    if (theme === 'dark') htmlEl.classList.add('dark');
                    else htmlEl.classList.remove('dark');
                    localStorage.setItem('theme', theme);
                    updateToggle();
                }

                function updateToggle() {
                    const darkIcon = document.getElementById('theme-toggle-dark-icon');
                    const lightIcon = document.getElementById('theme-toggle-light-icon');
                    if (!darkIcon || !lightIcon) return;
                    if (htmlEl.classList.contains('dark')) {
                        darkIcon.classList.remove('hidden');
                        lightIcon.classList.add('hidden');
                    } else {
                        darkIcon.classList.add('hidden');
                        lightIcon.classList.remove('hidden');
                    }
                }

                if (storedTheme === 'dark' || (!storedTheme && prefersDark)) {
                    htmlEl.classList.add('dark');
                } else {
                    htmlEl.classList.remove('dark');
                }
                updateToggle();
                document.addEventListener('DOMContentLoaded', updateToggle);

                window.toggleTheme = function () {
                    if (document.documentElement.classList.contains('dark')) setTheme('light');
                    else setTheme('dark');
                }

                // Attach toggle only to the actual toggle button to avoid global click handlers
                function attachThemeToggle() {
                    const btn = document.getElementById('theme-toggle');
                    if (!btn) return;
                    btn.addEventListener('click', function (e) {
                        e.preventDefault();
                        window.toggleTheme();
                    });
                }

                if (document.readyState === 'complete' || document.readyState === 'interactive') attachThemeToggle();
                else document.addEventListener('DOMContentLoaded', attachThemeToggle);
            })();
        </script>
        <!-- debug scripts removed -->
        @stack('scripts')
    </body>
</html>
