<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="{{ \App\Models\SiteSetting::getValue('theme', 'emerald') }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', config('app.name', 'Sankara Tech'))</title>
        <link rel="icon" type="image/png" href="{{ asset('logosankara.png') }}">
        <link rel="shortcut icon" href="{{ asset('logosankara.png') }}">
        @fonts
        @livewireStyles
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-white text-slate-900 antialiased landing-agency">
        <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">
            <div class="brand-blob-1 absolute -top-40 left-1/2 h-[32rem] w-[32rem] -translate-x-1/2 rounded-full blur-3xl"></div>
            <div class="brand-blob-2 absolute -bottom-56 -left-40 h-[36rem] w-[36rem] rounded-full blur-3xl"></div>
            <div class="brand-blob-1 absolute -right-44 top-64 h-[30rem] w-[30rem] rounded-full blur-3xl"></div>
        </div>

        @yield('content')

        @include('partials.marketing-footer')

        @livewireScripts
    </body>
</html>
