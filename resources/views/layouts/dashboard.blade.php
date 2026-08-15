<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="{{ \App\Models\SiteSetting::getValue('theme', 'emerald') }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Critical Inline Anti-FOUC Styles -->
        <style>
            html {
                background-color: #f1f5f9;
                color: #1e293b;
            }
            [x-cloak], .cloak { display: none !important; }
        </style>
        <link rel="icon" type="image/png" href="{{ asset('favicon.svg') }}">
        <link rel="shortcut icon" href="{{ asset('favicon.svg') }}">
        @fonts
        @livewireStyles
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-100/90 text-slate-800 antialiased font-sans">
        @php
            $navItemClass = fn (bool $active) => implode(' ', [
                'group flex items-center gap-3.5 rounded-2xl px-4 py-3 text-sm font-semibold transition-all duration-200',
                $active
                    ? 'brand-gradient text-white shadow-[0_10px_25px_-6px_rgba(14,165,233,0.5)] translate-x-1'
                    : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900',
            ]);

            $navIconClass = fn (bool $active) => implode(' ', [
                'w-5 text-center text-sm transition-transform duration-200 group-hover:scale-110',
                $active ? 'text-white' : 'text-slate-400 group-hover:text-sky-600',
            ]);
        @endphp

        <!-- Decorative background blobs -->
        <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">
            <div class="brand-blob-1 absolute -top-40 left-1/2 h-[34rem] w-[34rem] -translate-x-1/2 rounded-full blur-3xl opacity-40"></div>
            <div class="brand-blob-2 absolute -bottom-56 -left-40 h-[36rem] w-[36rem] rounded-full blur-3xl opacity-40"></div>
        </div>

        <div class="min-h-screen md:flex">
            <!-- Mobile Backdrop -->
            <div class="fixed inset-0 z-40 hidden bg-slate-950/30 backdrop-blur-sm md:hidden" data-admin-backdrop></div>

            <!-- Fixed / Sticky Sidebar -->
            <aside
                class="fixed inset-y-0 left-0 z-50 flex h-screen w-72 -translate-x-full flex-col border-r border-slate-200/80 bg-white/95 backdrop-blur-xl transition-transform duration-300 md:sticky md:top-0 md:translate-x-0 shadow-sm"
                data-admin-sidebar
            >
                <!-- Brand Header -->
                <div class="flex h-20 shrink-0 items-center justify-between gap-3 px-6 border-b border-slate-100">
                    <a href="{{ route('admin.dashboard') }}" wire:navigate class="flex items-center gap-3.5 group">
                        <span class="brand-gradient-br grid h-11 w-11 place-items-center rounded-2xl overflow-hidden shadow-[0_12px_30px_-10px_rgba(14,165,233,0.5)] transition-transform group-hover:scale-105">
                            <img src="{{ \App\Models\SiteSetting::getValue('site_logo', asset('logo.webp')) }}" alt="Logo" class="h-full w-full object-contain p-1">
                        </span>
                        <div class="leading-tight">
                            <span class="block text-sm font-bold tracking-tight text-slate-900 group-hover:text-sky-600 transition-colors">{{ \App\Models\SiteSetting::getValue('site_name', 'Sankara Tech') }}</span>
                            <span class="block text-[11px] font-semibold text-slate-400">Admin Management</span>
                        </div>
                    </a>

                    <button type="button" class="flex h-9 w-9 shrink-0 aspect-square items-center justify-center rounded-full border border-slate-200 bg-white text-slate-700 shadow-sm transition hover:bg-slate-100 md:hidden" data-admin-sidebar-close aria-label="Tutup sidebar">
                        <i class="fa-solid fa-xmark text-sm"></i>
                    </button>
                </div>

                <!-- Navigation List -->
                <nav class="flex-1 space-y-1.5 overflow-y-auto px-4 py-5 scrollbar-thin scrollbar-thumb-slate-200">
                    <div class="px-3 pb-2 text-[10px] font-bold uppercase tracking-wider text-slate-400">Menu Utama</div>

                    <a href="{{ route('admin.dashboard') }}" wire:navigate class="{{ $navItemClass(request()->routeIs('admin.dashboard')) }}">
                        <i class="fa-solid fa-gauge-high {{ $navIconClass(request()->routeIs('admin.dashboard')) }}"></i>
                        <span>Dashboard</span>
                    </a>

                    <a href="{{ route('admin.settings.edit') }}" wire:navigate class="{{ $navItemClass(request()->routeIs('admin.settings.*')) }}">
                        <i class="fa-solid fa-gear {{ $navIconClass(request()->routeIs('admin.settings.*')) }}"></i>
                        <span>Pengaturan Situs</span>
                    </a>

                    <a href="{{ route('admin.home.edit') }}" wire:navigate class="{{ $navItemClass(request()->routeIs('admin.home.*')) }}">
                        <i class="fa-solid fa-house-chimney {{ $navIconClass(request()->routeIs('admin.home.*')) }}"></i>
                        <span>Home Settings</span>
                    </a>

                    <a href="{{ route('admin.pages.about.edit') }}" wire:navigate class="{{ $navItemClass(request()->routeIs('admin.pages.about.*')) }}">
                        <i class="fa-solid fa-address-card {{ $navIconClass(request()->routeIs('admin.pages.about.*')) }}"></i>
                        <span>Tentang Kami</span>
                    </a>

                    <div class="pt-4 px-3 pb-2 text-[10px] font-bold uppercase tracking-wider text-slate-400">Konten & Bisnis</div>

                    <a href="{{ route('admin.services.index') }}" wire:navigate class="{{ $navItemClass(request()->routeIs('admin.services.*')) }}">
                        <i class="fa-solid fa-cubes {{ $navIconClass(request()->routeIs('admin.services.*')) }}"></i>
                        <span>Layanan</span>
                    </a>

                    <a href="{{ route('admin.portfolios.index') }}" wire:navigate class="{{ $navItemClass(request()->routeIs('admin.portfolios.*')) }}">
                        <i class="fa-solid fa-briefcase {{ $navIconClass(request()->routeIs('admin.portfolios.*')) }}"></i>
                        <span>Portofolio</span>
                    </a>

                    <a href="{{ route('admin.portfolio-categories.index') }}" wire:navigate class="{{ $navItemClass(request()->routeIs('admin.portfolio-categories.*')) }}">
                        <i class="fa-solid fa-layer-group {{ $navIconClass(request()->routeIs('admin.portfolio-categories.*')) }}"></i>
                        <span>Kategori Portofolio</span>
                    </a>

                    <a href="{{ route('admin.pricing.index') }}" wire:navigate class="{{ $navItemClass(request()->routeIs('admin.pricing.*')) }}">
                        <i class="fa-solid fa-tags {{ $navIconClass(request()->routeIs('admin.pricing.*')) }}"></i>
                        <span>Pricing</span>
                    </a>

                    <a href="{{ route('admin.contact-messages.index') }}" wire:navigate class="{{ $navItemClass(request()->routeIs('admin.contact-messages.*')) }}">
                        <i class="fa-solid fa-envelope {{ $navIconClass(request()->routeIs('admin.contact-messages.*')) }}"></i>
                        <span>Pesan Kontak</span>
                    </a>
                </nav>

                <!-- Sidebar Footer Profile & Actions -->
                <div class="shrink-0 border-t border-slate-200/80 bg-slate-50/70 p-4">
                    <div class="flex items-center justify-between gap-3 rounded-2xl border border-slate-200/60 bg-white p-3 shadow-xs">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="grid h-9 w-9 shrink-0 place-items-center rounded-xl bg-sky-100 text-sky-700 font-bold text-xs uppercase">
                                {{ substr(auth()->user()?->name ?? 'A', 0, 1) }}
                            </div>
                            <div class="min-w-0">
                                <div class="truncate text-xs font-bold text-slate-900">{{ auth()->user()?->name ?? 'Administrator' }}</div>
                                <div class="truncate text-[11px] font-medium text-slate-400">{{ auth()->user()?->email ?? '' }}</div>
                            </div>
                        </div>

                        <div class="flex items-center gap-1.5 shrink-0">
                            <a href="{{ route('home') }}" target="_blank" title="Buka Website" class="grid h-8 w-8 place-items-center rounded-xl border border-slate-200 bg-white text-slate-600 transition hover:border-sky-300 hover:text-sky-600 shadow-2xs">
                                <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.logout') }}">
                                @csrf
                                <button type="submit" title="Logout" class="grid h-8 w-8 place-items-center rounded-xl border border-rose-200 bg-rose-50 text-rose-600 transition hover:bg-rose-100 shadow-2xs">
                                    <i class="fa-solid fa-right-from-bracket text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Main Content Area -->
            <div class="flex min-h-screen min-w-0 flex-1 flex-col">
                <!-- Sticky Topbar -->
                <header class="sticky top-0 z-30 flex h-20 items-center justify-between border-b border-slate-200/80 bg-white/90 px-4 backdrop-blur-xl sm:px-8">
                    <div class="flex items-center gap-4">
                        <button type="button" class="flex h-10 w-10 shrink-0 aspect-square items-center justify-center rounded-full border border-slate-200 bg-white text-slate-800 shadow-sm backdrop-blur transition hover:bg-slate-100 md:hidden" data-admin-sidebar-open aria-label="Buka navigasi">
                            <i class="fa-solid fa-bars text-sm"></i>
                        </button>
                        <div>
                            <div class="text-base font-bold tracking-tight text-slate-900 sm:text-lg">
                                @yield('page_title', $pageTitle ?? 'Admin Panel')
                            </div>
                            <div class="text-xs font-medium text-slate-500">
                                @yield('page_subtitle', $pageSubtitle ?? 'Kelola konten dan konfigurasi website')
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <a href="{{ route('home') }}" target="_blank" class="hidden rounded-2xl border border-slate-200 bg-white px-4 py-2 text-xs font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 sm:inline-flex items-center gap-2">
                            <i class="fa-solid fa-globe text-sky-500"></i>
                            <span>Kunjungi Website</span>
                        </a>

                        <form method="POST" action="{{ route('admin.logout') }}" class="hidden sm:block">
                            @csrf
                            <button type="submit" class="brand-gradient inline-flex items-center gap-2 rounded-2xl px-4 py-2 text-xs font-semibold text-white shadow-sm transition hover:-translate-y-0.5">
                                <i class="fa-solid fa-right-from-bracket text-xs"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </header>

                <!-- Page Body -->
                <main class="flex-1 p-4 sm:p-8">
                    @isset($slot)
                        {{ $slot }}
                    @else
                        @yield('content')
                    @endisset
                </main>
            </div>
        </div>

        @livewireScripts
    </body>
</html>
