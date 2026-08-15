<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="{{ \App\Models\SiteSetting::getValue('theme', 'emerald') }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Critical Inline Anti-FOUC Styles -->
        <style>
            html {
                background-color: #ffffff;
                color: #0f172a;
            }
            [x-cloak], .cloak { display: none !important; }
        </style>
        
        <!-- Dynamic SEO Meta Tags, OpenGraph, Twitter Cards & GA4 -->
        @php
            $seoCustom = [
                'title' => View::yieldContent('title'),
                'description' => View::yieldContent('meta_description'),
                'image' => View::yieldContent('meta_image'),
                'canonical' => View::yieldContent('canonical_url'),
                'keywords' => View::yieldContent('meta_keywords'),
            ];
            $seoCustom = array_filter($seoCustom, fn($v) => filled($v));
        @endphp
        {{ app(\App\Services\SeoService::class)->renderTags($seoCustom) }}

        <!-- Structured Data (Schema.org JSON-LD) -->
        @yield('structured_data', app(\App\Services\SeoService::class)->renderStructuredData())

        <!-- Favicons -->
        @php
            $fav = \App\Models\SiteSetting::getValue('site_favicon', asset('favicon.svg'));
        @endphp
        <link rel="icon" type="image/png" href="{{ $fav }}">
        <link rel="apple-touch-icon" href="{{ $fav }}">

        <!-- Preconnect & Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
        <link rel="dns-prefetch" href="https://fonts.bunny.net">
        @fonts
        @livewireStyles
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-white text-slate-900 antialiased landing-agency">
        <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden" aria-hidden="true">
            <div class="brand-blob-1 absolute -top-40 left-1/2 h-[32rem] w-[32rem] -translate-x-1/2 rounded-full blur-3xl"></div>
            <div class="brand-blob-2 absolute -bottom-56 -left-40 h-[36rem] w-[36rem] rounded-full blur-3xl"></div>
            <div class="brand-blob-1 absolute -right-44 top-64 h-[30rem] w-[30rem] rounded-full blur-3xl"></div>
        </div>

        @isset($slot)
            {{ $slot }}
        @else
            @yield('content')
        @endisset

        @include('partials.marketing-footer')

        @livewireScripts
    </body>
</html>
