<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="{{ \App\Models\SiteSetting::getValue('theme', 'emerald') }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('code') - @yield('title') | {{ \App\Models\SiteSetting::getValue('site_name', 'Sankara Tech') }}</title>

        <!-- Favicons -->
        @php
            $fav = \App\Models\SiteSetting::getValue('site_favicon', asset('favicon.svg'));
            $siteName = \App\Models\SiteSetting::getValue('site_name', 'Sankara Tech');
            $siteTagline = \App\Models\SiteSetting::getValue('site_tagline', 'Digital Agency');
            $siteLogo = \App\Models\SiteSetting::getValue('site_logo', asset('logo.webp'));
        @endphp
        <link rel="icon" type="image/png" href="{{ $fav }}">
        <link rel="apple-touch-icon" href="{{ $fav }}">

        <!-- Preconnect & Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
        <link rel="dns-prefetch" href="https://fonts.bunny.net">
        @fonts

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-950 text-slate-100 antialiased selection:bg-sky-500 selection:text-white flex flex-col justify-between landing-agency relative overflow-x-hidden">
        <!-- Background Ambient Glow & Mesh -->
        <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden" aria-hidden="true">
            <div class="brand-blob-1 absolute -top-40 left-1/2 h-[36rem] w-[36rem] -translate-x-1/2 rounded-full opacity-40 blur-3xl"></div>
            <div class="brand-blob-2 absolute -bottom-56 -left-40 h-[36rem] w-[36rem] rounded-full opacity-30 blur-3xl"></div>
            <div class="brand-blob-1 absolute -right-44 top-64 h-[32rem] w-[32rem] rounded-full opacity-35 blur-3xl"></div>
            <div class="agency-hero-grid absolute inset-0 opacity-25"></div>
        </div>

        <!-- Header / Logo -->
        <header class="relative z-10 w-full py-6 px-4 sm:px-6 lg:px-8 border-b border-white/10 bg-slate-950/40 backdrop-blur-md">
            <div class="mx-auto max-w-7xl flex items-center justify-between">
                <a href="{{ route('home') }}" class="flex items-center gap-3 group transition" aria-label="{{ $siteName }} Home">
                    <img src="{{ $siteLogo }}" alt="{{ $siteName }} Logo" width="36" height="36" class="h-9 w-9 object-contain transition duration-300 group-hover:scale-105">
                    <span class="leading-tight">
                        <span class="block text-sm font-semibold tracking-tight text-white group-hover:text-sky-300 transition">{{ $siteName }}</span>
                        <span class="block text-xs font-medium text-white/60">{{ $siteTagline }}</span>
                    </span>
                </a>

                <a href="{{ route('home') }}" class="agency-btn-secondary inline-flex items-center gap-2 px-4 py-2 text-xs sm:text-sm font-medium">
                    <i class="fa-solid fa-arrow-left text-xs" aria-hidden="true"></i>
                    <span>Beranda</span>
                </a>
            </div>
        </header>

        <!-- Main Content -->
        <main class="relative z-10 flex-1 flex items-center justify-center px-4 py-16 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-2xl w-full text-center">
                <!-- Badge Code -->
                <div class="inline-flex items-center gap-2 rounded-full border border-sky-400/25 bg-sky-500/10 px-4 py-1.5 text-xs font-semibold text-sky-300 backdrop-blur mb-6">
                    <span class="h-2 w-2 rounded-full bg-sky-400 animate-pulse"></span>
                    <span>Status Error @yield('code')</span>
                </div>

                <!-- Big Gradient Error Code -->
                <div class="relative flex items-center justify-center select-none my-2">
                    <span class="text-8xl sm:text-9xl lg:text-[11rem] font-black tracking-tighter bg-gradient-to-br from-sky-300 via-sky-400 to-indigo-600 bg-clip-text text-transparent opacity-90 drop-shadow-2xl font-sans">
                        @yield('code')
                    </span>
                </div>

                <!-- Error Title & Description -->
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold tracking-tight text-white mt-4">
                    @yield('message')
                </h1>

                <p class="mx-auto mt-4 max-w-lg text-sm sm:text-base leading-relaxed text-slate-300">
                    @yield('description', 'Halaman yang Anda cari mungkin telah dipindahkan, dihapus, atau sedang tidak dapat diakses saat ini.')
                </p>

                <!-- Actions Button -->
                <div class="mt-8 flex flex-wrap items-center justify-center gap-3 sm:gap-4">
                    <a href="{{ route('home') }}" class="agency-btn-primary inline-flex items-center justify-center gap-2 px-7 py-3 text-sm font-semibold shadow-lg shadow-sky-500/25">
                        <i class="fa-solid fa-house text-xs" aria-hidden="true"></i>
                        <span>Kembali ke Beranda</span>
                    </a>

                    <a href="{{ route('contact.show') }}" class="agency-btn-secondary inline-flex items-center justify-center gap-2 px-7 py-3 text-sm font-semibold">
                        <i class="fa-solid fa-headset text-xs text-sky-400" aria-hidden="true"></i>
                        <span>Hubungi Dukungan</span>
                    </a>
                </div>

                <!-- Helpful Links -->
                <div class="mt-12 pt-8 border-t border-white/10 flex flex-wrap items-center justify-center gap-6 text-xs sm:text-sm text-slate-400">
                    <a href="{{ route('services.index') }}" class="hover:text-sky-300 transition-colors flex items-center gap-1.5">
                        <i class="fa-solid fa-cube text-xs text-slate-500"></i>
                        <span>Layanan Kami</span>
                    </a>
                    <span class="text-slate-700">&bull;</span>
                    <a href="{{ route('portfolios.index') }}" class="hover:text-sky-300 transition-colors flex items-center gap-1.5">
                        <i class="fa-solid fa-briefcase text-xs text-slate-500"></i>
                        <span>Portofolio</span>
                    </a>
                    <span class="text-slate-700">&bull;</span>
                    <a href="{{ route('about') }}" class="hover:text-sky-300 transition-colors flex items-center gap-1.5">
                        <i class="fa-solid fa-circle-info text-xs text-slate-500"></i>
                        <span>Tentang Kami</span>
                    </a>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="relative z-10 w-full py-6 px-4 border-t border-white/10 text-center text-xs text-slate-400">
            <div class="mx-auto max-w-7xl">
                <p>&copy; {{ date('Y') }} {{ $siteName }}. Seluruh hak cipta dilindungi undang-undang.</p>
            </div>
        </footer>
    </body>
</html>

