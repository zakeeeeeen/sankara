@php
    $active = $active ?? '';
    $homeHref = $homeHref ?? route('home');
    $headerId = $headerId ?? null;
    $scrollNavbar = (bool) ($scrollNavbar ?? false);
    $variant = $variant ?? 'light';
    $isLanding = $variant === 'landing';

    $navItems = [
        ['key' => 'home', 'label' => 'Home', 'url' => $homeHref],
        ['key' => 'about', 'label' => 'Tentang Kami', 'url' => route('about')],
        ['key' => 'services', 'label' => 'Layanan', 'url' => route('services.index')],
        ['key' => 'portfolios', 'label' => 'Portofolio', 'url' => route('portfolios.index')],
        ['key' => 'contact', 'label' => 'Kontak', 'url' => route('contact.show')],
    ];
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
                    <a href="{{ $homeHref }}" class="flex items-center gap-3 lg:justify-self-start">
                        <img src="{{ asset('logosankara.png') }}" alt="Sankara Tech Logo" class="h-9 w-9 object-contain">
                        <span class="leading-tight">
                            <span data-brand-name class="block text-sm font-semibold tracking-tight {{ $isLanding ? 'text-white' : 'text-slate-900' }}">Sankara Tech</span>
                            <span data-brand-tagline class="block text-xs font-medium {{ $isLanding ? 'text-white/65' : 'text-slate-500' }}">Digital Agency</span>
                        </span>
                    </a>

                    <nav class="hidden items-center gap-7 text-sm font-medium lg:flex lg:justify-self-center">
                        @foreach ($navItems as $item)
                            @php
                                $isActive = $active === $item['key'];
                            @endphp
                            <a
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
                        data-mobile-toggle="true"
                        class="inline-flex h-11 w-11 items-center justify-center rounded-2xl border {{ $isLanding ? 'border-white/20 bg-white/10 text-white shadow-none backdrop-blur' : 'border-slate-200/70 bg-white/70 text-slate-700 shadow-sm backdrop-blur' }} transition hover:bg-white lg:justify-self-end lg:hidden"
                        aria-label="Buka menu"
                    >
                        <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5">
                            <path d="M5 7h14M5 12h14M5 17h14" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                        </svg>
                    </button>
                </div>
            </div>

            <div data-mobile-menu class="hidden border-t {{ $isLanding ? 'border-white/15 bg-[rgb(var(--agency-navy-1)/0.95)]' : 'border-slate-200/60 bg-white/85' }} backdrop-blur lg:hidden">
                <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
                    <div class="grid gap-2 text-sm font-medium {{ $isLanding ? 'text-white/80' : 'text-slate-700' }}">
                        @foreach ($navItems as $item)
                            @php
                                $isActive = $active === $item['key'];
                            @endphp
                            <a class="flex items-center justify-between rounded-xl px-3 py-2 transition-colors {{ $isActive ? 'bg-sky-500/10 text-sky-400 font-semibold border-l-4 border-sky-400 pl-3' : ($isLanding ? 'hover:bg-white/10' : 'hover:bg-slate-50') }}" href="{{ $item['url'] }}">
                                <span>{{ $item['label'] }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
