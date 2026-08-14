@php
    $iconMap = [
        'home' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
        'services' => 'M7 6h10M7 12h10M7 18h10',
        'portfolios' => 'M4.5 7.5h15M7.5 4.5v15M12 4.5v15M16.5 4.5v15',
        'contact' => 'M4 7l8 6 8-6M5 7h14v10H5V7Z',
        'info' => 'M12 9v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
        'grid' => 'M4 4h6v6H4V4zm10 0h6v6h-6V4zM4 14h6v6H4v-6zm10 0h6v6h-6v-6z',
    ];

    $customBottomNav = \App\Models\SiteSetting::getValue('bottom_nav');

    if (!empty($customBottomNav) && is_array($customBottomNav)) {
        $items = [];
        foreach ($customBottomNav as $row) {
            $url = $row['url'] ?? '#';
            
            // Check active state
            $currentPath = request()->path();
            $targetPath = ltrim(parse_url($url, PHP_URL_PATH) ?? '', '/');
            $isActive = ($currentPath === $targetPath) || ($targetPath !== '' && request()->is($targetPath . '*'));
            if ($url === '/' && request()->is('/')) {
                $isActive = true;
            }

            $iconType = $row['icon'] ?? 'home';
            $iconPath = (!empty($row['custom_icon'])) ? $row['custom_icon'] : ($iconMap[$iconType] ?? $iconMap['home']);

            $items[] = [
                'label' => $row['label'] ?? '',
                'href' => $url,
                'active' => $isActive,
                'icon' => $iconPath,
            ];
        }
    } else {
        $items = [
            [
                'label' => 'Home',
                'href' => route('home'),
                'active' => request()->routeIs('home'),
                'icon' => $iconMap['home'],
            ],
            [
                'label' => 'Layanan',
                'href' => route('services.index'),
                'active' => request()->routeIs('services.*'),
                'icon' => $iconMap['services'],
            ],
            [
                'label' => 'Portofolio',
                'href' => route('portfolios.index'),
                'active' => request()->routeIs('portfolios.*'),
                'icon' => $iconMap['portfolios'],
            ],
            [
                'label' => 'Kontak',
                'href' => route('contact.show'),
                'active' => request()->routeIs('contact.*'),
                'icon' => $iconMap['contact'],
            ],
        ];
    }

    $colCount = count($items) > 0 ? min(count($items), 6) : 4;
@endphp

@if (count($items) > 0)
    <nav class="fixed inset-x-0 bottom-0 z-50 border-t border-slate-200/60 bg-white/85 backdrop-blur-xl lg:hidden">
        <div class="mx-auto max-w-7xl px-4 pb-[env(safe-area-inset-bottom)] sm:px-6">
            <div class="grid grid-cols-{{ $colCount }} gap-1 py-2" style="grid-template-columns: repeat({{ count($items) }}, minmax(0, 1fr));">
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
                        <span class="{{ $item['active'] ? 'text-brand font-bold' : 'text-slate-600 font-semibold' }} text-[11px] truncate max-w-full">
                            {{ $item['label'] }}
                        </span>
                    </a>
                @endforeach
            </div>
        </div>
    </nav>
@endif
