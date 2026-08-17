<div>
    @include('partials.marketing-header', ['active' => 'services'])

    <main class="pt-28 pb-20 bg-slate-50">
        <section class="relative overflow-hidden">
            <div class="mx-auto max-w-7xl px-4 pb-10 pt-4 sm:px-6 lg:px-8 lg:pb-14">
                <div class="reveal">
                    <h1 class="text-4xl font-bold tracking-tight text-[rgb(var(--agency-navy-1))] sm:text-5xl">Solusi Digital End-to-End untuk Bisnis Modern</h1>
                    <p class="mt-4 max-w-3xl text-base leading-relaxed text-slate-600 sm:text-lg">
                        Setiap layanan kami dirancang dengan pendekatan modern, performa cepat, dan UX yang rapi untuk mendukung pertumbuhan bisnis Anda.
                    </p>
                </div>
            </div>
        </section>

        <section class="pb-16 sm:pb-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($services as $service)
                        @php
                            $faIcons = [
                                'website-development' => 'fa-solid fa-globe',
                                'software-development' => 'fa-solid fa-code',
                                'mobile-app-development' => 'fa-solid fa-mobile-screen-button',
                                'ui-ux-design' => 'fa-solid fa-pen-ruler',
                                'uiux-design' => 'fa-solid fa-pen-ruler',
                                'game-development' => 'fa-solid fa-gamepad',
                                '3d-modeling' => 'fa-solid fa-cube',
                            ];
                            $iconClass = $faIcons[$service->slug] ?? 'fa-solid fa-cubes';
                        @endphp
                        <div class="reveal h-full">
                            <a href="{{ route('services.show', $service->slug) }}" wire:navigate class="agency-service-card group flex h-full flex-col p-6 sm:p-8" aria-label="Detail Layanan {{ $service->title }}">
                                <div class="grid h-14 w-14 sm:h-16 sm:w-16 place-items-center rounded-2xl border border-sky-100 bg-sky-50 text-sky-600 shadow-sm transition-transform duration-300 group-hover:scale-105">
                                    <i class="{{ $iconClass }} text-xl sm:text-2xl" aria-hidden="true"></i>
                                </div>
                                <h3 class="mt-6 sm:mt-8 text-xl sm:text-2xl font-bold leading-snug tracking-tight text-[rgb(var(--agency-navy-1))] group-hover:text-sky-600 transition-colors">{{ strtoupper($service->title) }}</h3>
                                <p class="mt-3 sm:mt-4 text-xs sm:text-base leading-relaxed text-slate-500 line-clamp-3">{{ $service->description ?: $service->excerpt }}</p>
                                <div class="mt-auto flex items-center justify-end pt-8 sm:pt-10 text-sky-600">
                                    <i class="fa-solid fa-arrow-right text-base sm:text-lg transition-transform group-hover:translate-x-1" aria-hidden="true"></i>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </main>
</div>
