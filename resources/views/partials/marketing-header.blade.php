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

<header @if($headerId) id="{{ $headerId }}" @endif class="relative">
    <div class="fixed inset-x-0 top-0 z-50">
        <div
            @if($scrollNavbar)
                id="navbar"
                class="border-b border-transparent transition-all duration-300"
            @else
                class="border-b border-slate-200/60 bg-white/75 backdrop-blur-xl"
            @endif
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

                    <div class="flex items-center justify-end gap-3 lg:justify-self-end">
                        <a
                            wire:navigate
                            href="{{ route('contact.show') }}"
                            class="hidden lg:inline-flex items-center gap-2 rounded-2xl brand-gradient px-5 py-2.5 text-xs font-bold text-white shadow-sm transition-all hover:-translate-y-0.5 hover:shadow-md"
                        >
                            <span>Hubungi Kami</span>
                            <i class="fa-solid fa-arrow-right text-[10px]" aria-hidden="true"></i>
                        </a>

                        <button
                            type="button"
                            data-mobile-toggle="true"
                            class="flex h-10 w-10 shrink-0 aspect-square items-center justify-center rounded-full border {{ $isLanding ? 'border-white/20 bg-white/10 text-white shadow-none backdrop-blur' : 'border-slate-200/70 bg-white text-slate-700 shadow-sm backdrop-blur' }} transition hover:bg-white lg:hidden"
                            aria-label="Buka menu navigasi"
                        >
                            <i class="fa-solid fa-bars text-sm" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div data-mobile-menu class="hidden border-t {{ $isLanding ? 'border-white/15 bg-[rgb(var(--agency-navy-1)/0.95)]' : 'border-slate-200/60 bg-white/85' }} backdrop-blur lg:hidden">
                <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
                    <nav class="grid gap-2 text-sm font-medium {{ $isLanding ? 'text-white/80' : 'text-slate-700' }}" aria-label="Navigasi Mobile">
                        @foreach ($navItems as $item)
                            @php
                                $isActive = $active === $item['key'];
                            @endphp
                            <a wire:navigate class="flex items-center justify-between rounded-xl px-3 py-2 transition-colors {{ $isActive ? 'bg-sky-500/10 text-sky-400 font-semibold border-l-4 border-sky-400 pl-3' : ($isLanding ? 'hover:bg-white/10' : 'hover:bg-slate-50') }}" href="{{ $item['url'] }}">
                                <span>{{ $item['label'] }}</span>
                            </a>
                        @endforeach
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>
