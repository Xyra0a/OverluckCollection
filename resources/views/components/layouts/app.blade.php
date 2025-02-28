<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? 'Dummy' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/iconWeb.jpg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles()
</head>
<body class="bg-slate-200 dark:bg-slate-700">
    @livewire('partials.navbar')
    <main>
        {{ $slot }}
    </main>
    @livewire('partials.footer')
    @livewireScripts()
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <x-livewire-alert::scripts />
</body>
</html>
