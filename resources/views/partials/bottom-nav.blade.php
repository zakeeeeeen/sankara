@php
    $items = [
        [
            'key' => 'home',
            'label' => 'Home',
            'href' => route('home'),
            'active' => request()->routeIs('home'),
            'icon' => 'M6 7h12M6 11h12M6 15h12M6 19h12',
        ],
        [
            'key' => 'services',
            'label' => 'Layanan',
            'href' => route('services.index'),
            'active' => request()->routeIs('services.*'),
            'icon' => 'M7 6h10M7 12h10M7 18h10',
        ],
        [
            'key' => 'portfolios',
            'label' => 'Portofolio',
            'href' => route('portfolios.index'),
            'active' => request()->routeIs('portfolios.*'),
            'icon' => 'M4.5 7.5h15M7.5 4.5v15M12 4.5v15M16.5 4.5v15',
        ],
        [
            'key' => 'contact',
            'label' => 'Kontak',
            'href' => route('contact.show'),
            'active' => request()->routeIs('contact.*'),
            'icon' => 'M4 7l8 6 8-6M5 7h14v10H5V7Z',
        ],
    ];
@endphp

<nav class="fixed inset-x-0 bottom-0 z-50 border-t border-slate-200/60 bg-white/85 backdrop-blur-xl lg:hidden">
    <div class="mx-auto max-w-7xl px-4 pb-[env(safe-area-inset-bottom)] sm:px-6">
        <div class="grid grid-cols-4 gap-1 py-2">
            @foreach ($items as $item)
                <a
                    href="{{ $item['href'] }}"
                    class="group flex flex-col items-center justify-center gap-1 rounded-2xl px-2 py-2 transition active:scale-[0.98]"
                >
                    <span class="{{ $item['active'] ? 'brand-gradient text-white shadow-brand-cta' : 'border border-slate-200/70 bg-white/70 text-slate-700 shadow-sm' }} grid h-9 w-9 place-items-center rounded-2xl backdrop-blur transition group-hover:-translate-y-0.5">
                        <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5">
                            <path d="{{ $item['icon'] }}" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                    <span class="{{ $item['active'] ? 'text-brand' : 'text-slate-600' }} text-[11px] font-semibold">
                        {{ $item['label'] }}
                    </span>
                </a>
            @endforeach
        </div>
    </div>
</nav>

