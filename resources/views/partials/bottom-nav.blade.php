@php
    $iconMap = [
        'home' => 'fa-solid fa-house-chimney',
        'services' => 'fa-solid fa-cubes',
        'portfolios' => 'fa-solid fa-briefcase',
        'contact' => 'fa-solid fa-envelope',
        'info' => 'fa-solid fa-circle-info',
        'grid' => 'fa-solid fa-table-cells-large',
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
            $iconClass = (!empty($row['custom_icon']) && str_starts_with($row['custom_icon'], 'fa')) 
                ? $row['custom_icon'] 
                : ($iconMap[$iconType] ?? $iconMap['home']);

            $items[] = [
                'label' => $row['label'] ?? '',
                'href' => $url,
                'active' => $isActive,
                'icon' => $iconClass,
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
                        wire:navigate
                        class="group flex flex-col items-center justify-center gap-1 rounded-2xl px-2 py-2 transition active:scale-[0.98]"
                    >
                        <span class="{{ $item['active'] ? 'brand-gradient text-white shadow-brand-cta' : 'border border-slate-200/70 bg-white/70 text-slate-700 shadow-sm' }} grid h-9 w-9 place-items-center rounded-2xl backdrop-blur transition group-hover:-translate-y-0.5">
                            <i class="{{ $item['icon'] }} text-sm"></i>
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
