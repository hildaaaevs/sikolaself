<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <title>{{ $title ?? 'SiKolaself' }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
        @livewireScripts
    </head>

    <body class="bg-slate-200 dark:bg-slate-700">
        @livewire('partials.navbar')
        <main>
            {{ $slot }}
        </main>
        @livewire('partials.footer')
        @livewireScripts
    </body>
</html>
