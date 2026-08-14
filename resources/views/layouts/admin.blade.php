<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="{{ \App\Models\SiteSetting::getValue('theme', 'emerald') }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Admin - Sankara Tech')</title>
        <link rel="icon" type="image/png" href="{{ asset('logosankara.png') }}">
        <link rel="shortcut icon" href="{{ asset('logosankara.png') }}">
        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-white text-slate-900 antialiased">
        @php
            $showSidebar = auth()->check() && auth()->user()?->is_admin;

            $navItemClass = fn (bool $active) => implode(' ', [
                'group flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold transition',
                $active
                    ? 'bg-slate-900 text-white shadow-sm'
                    : 'text-slate-700 hover:bg-white/70 hover:text-slate-900',
            ]);

            $navIconClass = fn (bool $active) => implode(' ', [
                'h-5 w-5',
                $active ? 'text-white' : 'text-slate-400 group-hover:text-slate-600',
            ]);
        @endphp

        <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">
            <div class="brand-blob-1 absolute -top-40 left-1/2 h-[32rem] w-[32rem] -translate-x-1/2 rounded-full blur-3xl"></div>
            <div class="brand-blob-2 absolute -bottom-56 -left-40 h-[36rem] w-[36rem] rounded-full blur-3xl"></div>
        </div>

        @if ($showSidebar)
            <div class="min-h-screen md:flex">
                <div class="fixed inset-0 z-40 hidden bg-slate-950/25 backdrop-blur-sm md:hidden" data-admin-backdrop></div>

                <aside
                    class="fixed inset-y-0 left-0 z-50 flex w-72 -translate-x-full flex-col border-r border-slate-200/70 bg-white/80 backdrop-blur-xl transition md:static md:translate-x-0"
                    data-admin-sidebar
                >
                    <div class="flex items-center justify-between gap-3 px-4 py-4">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                            <span class="brand-gradient-br grid h-10 w-10 place-items-center rounded-2xl overflow-hidden shadow-[0_18px_40px_-22px_rgba(16,185,129,0.6)]">
                                <img src="{{ \App\Models\SiteSetting::getValue('site_logo', asset('logosankara.png')) }}" alt="Logo" class="h-full w-full object-contain p-0.5">
                            </span>
                            <span class="leading-tight">
                                <span class="block text-sm font-semibold tracking-tight text-slate-900">{{ \App\Models\SiteSetting::getValue('site_name', 'Sankara Tech') }}</span>
                                <span class="block text-xs font-medium text-slate-500">Admin Panel</span>
                            </span>
                        </a>

                        <button type="button" class="grid h-10 w-10 place-items-center rounded-2xl border border-slate-200/70 bg-white/70 text-slate-700 shadow-sm backdrop-blur transition hover:bg-white md:hidden" data-admin-sidebar-close>
                            <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5">
                                <path d="M6 6l12 12M18 6L6 18" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                            </svg>
                        </button>
                    </div>

                    <nav class="flex-1 space-y-1 px-3 pb-6 pt-2">
                        <a href="{{ route('admin.dashboard') }}" class="{{ $navItemClass(request()->routeIs('admin.dashboard')) }}">
                            <svg viewBox="0 0 24 24" fill="none" class="{{ $navIconClass(request()->routeIs('admin.dashboard')) }}">
                                <path d="M10.4 4.8l-6 5v8.8a1.6 1.6 0 001.6 1.6h4.8v-6.4h2.4v6.4h4.8a1.6 1.6 0 001.6-1.6V9.8l-6-5a2.4 2.4 0 00-3.2 0Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                            </svg>
                            Dashboard
                        </a>

                        <a href="{{ route('admin.settings.edit') }}" class="{{ $navItemClass(request()->routeIs('admin.settings.*')) }}">
                            <svg viewBox="0 0 24 24" fill="none" class="{{ $navIconClass(request()->routeIs('admin.settings.*')) }}">
                                <path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Pengaturan Situs
                        </a>

                        <a href="{{ route('admin.home.edit') }}" class="{{ $navItemClass(request()->routeIs('admin.home.*')) }}">
                            <svg viewBox="0 0 24 24" fill="none" class="{{ $navIconClass(request()->routeIs('admin.home.*')) }}">
                                <path d="M4.5 7.2L12 3l7.5 4.2v9.6L12 21l-7.5-4.2V7.2Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                                <path d="M12 21V12" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                            </svg>
                            Home Settings
                        </a>

                        <a href="{{ route('admin.pages.about.edit') }}" class="{{ $navItemClass(request()->routeIs('admin.pages.about.*')) }}">
                            <svg viewBox="0 0 24 24" fill="none" class="{{ $navIconClass(request()->routeIs('admin.pages.about.*')) }}">
                                <path d="M7 4h10a2 2 0 012 2v14l-7-3-7 3V6a2 2 0 012-2Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                            </svg>
                            Tentang Kami
                        </a>

                        <a href="{{ route('admin.services.index') }}" class="{{ $navItemClass(request()->routeIs('admin.services.*')) }}">
                            <svg viewBox="0 0 24 24" fill="none" class="{{ $navIconClass(request()->routeIs('admin.services.*')) }}">
                                <path d="M7 7h10M7 12h10M7 17h10" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                            </svg>
                            Layanan
                        </a>

                        <a href="{{ route('admin.portfolios.index') }}" class="{{ $navItemClass(request()->routeIs('admin.portfolios.*')) }}">
                            <svg viewBox="0 0 24 24" fill="none" class="{{ $navIconClass(request()->routeIs('admin.portfolios.*')) }}">
                                <path d="M4.5 6.8A2.3 2.3 0 016.8 4.5h10.4a2.3 2.3 0 012.3 2.3v10.4a2.3 2.3 0 01-2.3 2.3H6.8a2.3 2.3 0 01-2.3-2.3V6.8Z" stroke="currentColor" stroke-width="1.6"/>
                                <path d="M8 10h8M8 14h5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                            </svg>
                            Portofolio
                        </a>

                        <a href="{{ route('admin.portfolio-categories.index') }}" class="{{ $navItemClass(request()->routeIs('admin.portfolio-categories.*')) }}">
                            <svg viewBox="0 0 24 24" fill="none" class="{{ $navIconClass(request()->routeIs('admin.portfolio-categories.*')) }}">
                                <path d="M4.5 7.2L12 3l7.5 4.2v9.6L12 21l-7.5-4.2V7.2Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                                <path d="M9 10.5h6M9 14h6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                            </svg>
                            Kategori Portofolio
                        </a>

                        <a href="{{ route('admin.pricing.index') }}" class="{{ $navItemClass(request()->routeIs('admin.pricing.*')) }}">
                            <svg viewBox="0 0 24 24" fill="none" class="{{ $navIconClass(request()->routeIs('admin.pricing.*')) }}">
                                <path d="M7 8h10M7 12h10M7 16h10" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                <path d="M5 5.5A2.5 2.5 0 017.5 3h9A2.5 2.5 0 0119 5.5v13A2.5 2.5 0 0116.5 21h-9A2.5 2.5 0 015 18.5v-13Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                            </svg>
                            Pricing
                        </a>

                        <a href="{{ route('admin.contact-messages.index') }}" class="{{ $navItemClass(request()->routeIs('admin.contact-messages.*')) }}">
                            <svg viewBox="0 0 24 24" fill="none" class="{{ $navIconClass(request()->routeIs('admin.contact-messages.*')) }}">
                                <path d="M6.5 19.5a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h11a2 2 0 0 1 2 2v6.5" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                                <path d="M8 9h8M8 12h6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                <path d="M12.5 19.5l2-2 2 2 3.5-3.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Pesan Kontak
                        </a>
                    </nav>

                    <div class="border-t border-slate-200/70 px-4 py-4">
                        <div class="flex items-center justify-between gap-3">
                            <div class="min-w-0">
                                <div class="truncate text-sm font-semibold text-slate-900">{{ auth()->user()->name }}</div>
                                <div class="truncate text-xs font-medium text-slate-500">{{ auth()->user()->email }}</div>
                            </div>
                            <a href="{{ route('home') }}" class="rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-2 text-xs font-semibold text-slate-800 shadow-sm backdrop-blur transition hover:bg-white">
                                Website
                            </a>
                        </div>
                    </div>
                </aside>

                <div class="flex min-h-screen min-w-0 flex-1 flex-col">
                    <header class="sticky top-0 z-30 border-b border-slate-200/60 bg-white/75 backdrop-blur-xl">
                        <div class="flex items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
                            <div class="flex items-center gap-3">
                                <button type="button" class="grid h-10 w-10 place-items-center rounded-2xl border border-slate-200/70 bg-white/70 text-slate-800 shadow-sm backdrop-blur transition hover:bg-white md:hidden" data-admin-sidebar-open>
                                    <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5">
                                        <path d="M6 7h12M6 12h12M6 17h12" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                    </svg>
                                </button>
                                <div class="leading-tight">
                                    <div class="text-sm font-semibold tracking-tight text-slate-900">@yield('page_title', 'Admin')</div>
                                    <div class="text-xs font-medium text-slate-500">@yield('page_subtitle', 'Kelola konten website')</div>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <a href="{{ route('home') }}" class="hidden rounded-2xl border border-slate-200/70 bg-white/70 px-5 py-2.5 text-sm font-semibold text-slate-800 shadow-sm backdrop-blur transition hover:-translate-y-0.5 hover:bg-white sm:inline-flex">
                                    Lihat Website
                                </a>
                                <form method="POST" action="{{ route('admin.logout') }}">
                                    @csrf
                                    <button type="submit" class="brand-gradient rounded-2xl px-5 py-2.5 text-sm font-semibold text-white shadow-[0_18px_50px_-26px_rgba(14,165,233,0.6)] transition hover:-translate-y-0.5">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </header>

                    <main class="flex-1 px-4 py-8 sm:px-6 lg:px-8">
                        @yield('content')
                    </main>
                </div>
            </div>
        @else
            <main class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
                @yield('content')
            </main>
        @endif
    </body>
</html>
