@php
    $active = $active ?? '';
    $homeHref = $homeHref ?? route('home');
    $headerId = $headerId ?? null;
    $scrollNavbar = (bool) ($scrollNavbar ?? false);
    $variant = $variant ?? 'light';
    $isLanding = $variant === 'landing';

    $siteName = \App\Models\SiteSetting::getValue('site_name', 'Sankara Tech');
    $siteTagline = \App\Models\SiteSetting::getValue('site_tagline', 'Digital Agency');
    $siteLogo = \App\Models\SiteSetting::getValue('site_logo', asset('logo.webp'));

    $customHeaderNav = \App\Models\SiteSetting::getValue('header_nav');
    if (!empty($customHeaderNav) && is_array($customHeaderNav)) {
        $navItems = array_map(function ($item) {
            return [
                'key' => $item['key'] ?? \Illuminate\Support\Str::slug($item['label'] ?? ''),
                'label' => $item['label'] ?? '',
                'url' => $item['url'] ?? '#',
            ];
        }, $customHeaderNav);
    } else {
        $navItems = [
            ['key' => 'home', 'label' => 'Home', 'url' => $homeHref],
            ['key' => 'about', 'label' => 'Tentang Kami', 'url' => route('about')],
            ['key' => 'services', 'label' => 'Layanan', 'url' => route('services.index')],
            ['key' => 'portfolios', 'label' => 'Portofolio', 'url' => route('portfolios.index')],
            ['key' => 'contact', 'label' => 'Kontak', 'url' => route('contact.show')],
        ];
    }
@endphp

<header @if($headerId) id="{{ $headerId }}" @endif class="relative" x-data="{ open: false }">
    <div class="fixed inset-x-0 top-0 z-50">
        <div
            id="navbar"
            class="border-b transition-all duration-300 {{ $isLanding ? 'border-transparent' : 'border-slate-200/60 bg-white/90 backdrop-blur-xl shadow-sm' }}"
        >
            <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between gap-4 lg:grid lg:grid-cols-[1fr_auto_1fr] lg:gap-6">
                    <a href="{{ $homeHref }}" class="flex items-center gap-3 lg:justify-self-start" aria-label="{{ $siteName }} Home">
                        <img src="{{ $siteLogo }}" alt="{{ $siteName }} Logo" width="36" height="36" fetchpriority="high" class="h-9 w-9 object-contain">
                        <span class="leading-tight">
                            <span data-brand-name class="block text-sm font-semibold tracking-tight {{ $isLanding ? 'text-white' : 'text-slate-900' }}">{{ $siteName }}</span>
                            <span data-brand-tagline class="block text-xs font-medium {{ $isLanding ? 'text-white/65' : 'text-slate-500' }}">{{ $siteTagline }}</span>
                        </span>
                    </a>

                    <nav class="hidden items-center gap-7 text-sm font-medium lg:flex lg:justify-self-center" aria-label="Navigasi Utama">
                        @foreach ($navItems as $item)
                            @php
                                $isActive = $active === $item['key'];
                            @endphp
                            <a
                                wire:navigate
                                class="navlink relative py-1 text-sm font-medium transition-colors duration-200
                                {{ $isActive
                                    ? ($isLanding ? 'navlink--active text-sky-400 font-semibold after:absolute after:-bottom-1 after:inset-x-0 after:h-0.5 after:rounded-full after:bg-sky-400' : 'navlink--active text-sky-600 font-semibold after:absolute after:-bottom-1 after:inset-x-0 after:h-0.5 after:rounded-full after:bg-sky-600')
                                    : ($isLanding ? 'text-white/80 hover:text-white' : 'text-slate-900 hover:text-sky-600')
                                }}"
                                href="{{ $item['url'] }}"
                            >
                                {{ $item['label'] }}
                            </a>
                        @endforeach
                    </nav>

                    <button
                        type="button"
                        @click="open = !open"
                        data-mobile-toggle="true"
                        class="flex h-10 w-10 shrink-0 aspect-square items-center justify-center rounded-full border {{ $isLanding ? 'border-white/20 bg-white/10 text-white shadow-none backdrop-blur hover:bg-white/20' : 'border-slate-200/70 bg-white text-slate-700 shadow-sm backdrop-blur hover:bg-slate-50 hover:text-sky-600' }} transition lg:justify-self-end lg:hidden"
                        aria-label="Buka menu navigasi"
                    >
                        <i :class="open ? 'fa-solid fa-xmark' : 'fa-solid fa-bars'" class="text-base" aria-hidden="true"></i>
                    </button>
                </div>
            </div>

            <div
                data-mobile-menu
                x-show="open"
                x-cloak
                @click.away="open = false"
                x-transition:enter="transition ease-out duration-250 transform"
                x-transition:enter-start="opacity-0 -translate-y-3 scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                x-transition:leave="transition ease-in duration-150 transform"
                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                x-transition:leave-end="opacity-0 -translate-y-2 scale-95"
                class="absolute inset-x-0 top-full mt-2 mx-4 rounded-2xl border {{ $isLanding ? 'border-white/15 bg-[rgb(var(--agency-navy-1))] text-white shadow-2xl' : 'border-slate-200/80 bg-white/95 text-slate-900 shadow-2xl' }} backdrop-blur-2xl lg:hidden overflow-hidden"
            >
                <div class="px-4 py-4 sm:px-6">
                    <nav class="grid gap-1 text-sm font-medium" aria-label="Navigasi Mobile">
                        @foreach ($navItems as $item)
                            @php
                                $isActive = $active === $item['key'];
                            @endphp
                            <a
                                @click="open = false"
                                wire:navigate
                                class="block rounded-xl px-4 py-3 font-medium transition-all duration-200 {{
                                    $isActive
                                        ? ($isLanding
                                            ? 'bg-sky-500/20 text-sky-400 font-semibold border-l-4 border-sky-400 pl-3.5'
                                            : 'bg-sky-50 text-sky-600 font-semibold border-l-4 border-sky-600 pl-3.5')
                                        : ($isLanding
                                            ? 'text-white/85 hover:bg-white/10 hover:text-white'
                                            : 'text-slate-700 hover:bg-slate-50 hover:text-sky-600')
                                }}"
                                href="{{ $item['url'] }}"
                            >
                                {{ $item['label'] }}
                            </a>
                        @endforeach
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>
