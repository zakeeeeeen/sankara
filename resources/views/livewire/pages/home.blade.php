<div>
    @include('partials.marketing-header', [
        'variant' => 'landing',
        'active' => 'home',
        'scrollNavbar' => true,
    ])

    <main>
        <section id="hero" class="agency-hero relative overflow-hidden min-h-screen min-h-[100dvh] flex flex-col justify-center items-center pt-24 pb-16 sm:pt-32 sm:pb-20">
            <div class="pointer-events-none absolute inset-0">
                <div class="agency-hero-grid absolute inset-0 opacity-75"></div>
                <div class="brand-blob-1 absolute -top-40 left-1/2 h-[38rem] w-[38rem] -translate-x-1/2 rounded-full blur-3xl opacity-30"></div>
                <div class="brand-blob-2 absolute -bottom-56 -left-40 h-[42rem] w-[42rem] rounded-full blur-3xl opacity-20"></div>
            </div>

            <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 w-full my-auto">
                <div class="text-center flex flex-col items-center">
                    <!-- Badge: Melayang Pelan & Lebih Jelas -->
                    <div class="mb-5 inline-flex items-center gap-2.5 rounded-full border border-white/20 bg-white/10 px-5 py-2 text-xs sm:text-sm font-semibold text-white backdrop-blur-md shadow-lg animate-float-slow">
                        <span class="inline-block h-2.5 w-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span>{{ $hero?->badge_text ?? 'Digital Agency • Web, Mobile & Software' }}</span>
                    </div>

                    <!-- H1: Maksimal 2 Baris Presisi + Emas Mengkilap di "Inovasi Digital" -->
                    @php
                        $headingText = $hero?->heading ?? 'Inovasi Digital untuk Pertumbuhan Bisnis Anda';
                        if (str_contains($headingText, 'Inovasi Digital')) {
                            $line1 = 'Inovasi Digital';
                            $line2 = trim(str_replace('Inovasi Digital', '', $headingText));
                        } else {
                            $words = explode(' ', $headingText);
                            $mid = ceil(count($words) / 2);
                            $line1 = implode(' ', array_slice($words, 0, $mid));
                            $line2 = implode(' ', array_slice($words, $mid));
                        }
                    @endphp
                    <h1 class="mt-1 text-[2.15rem] xs:text-[2.4rem] sm:text-5xl lg:text-7xl font-black tracking-tight text-white leading-[1.15] sm:leading-[1.1] animate-float max-w-5xl mx-auto">
                        <span class="block text-gold-shiny drop-shadow-md">{{ $line1 }}</span>
                        <span class="block text-white mt-0.5 sm:mt-1">{{ $line2 }}</span>
                    </h1>

                    <!-- P: Deskripsi Lebih Besar & Jelas di Mobile (16px / text-base) -->
                    <p class="mx-auto mt-5 sm:mt-6 max-w-lg sm:max-w-3xl text-base sm:text-xl leading-relaxed text-slate-200 font-normal px-1 sm:px-0 animate-float-delayed">
                        {{ $hero?->subheading ?? 'Kami membantu brand dan bisnis membangun website, aplikasi mobile, dan perangkat lunak kustom dengan standar desain dunia dan teknologi modern.' }}
                    </p>

                    <!-- Buttons CTA: Lebih Besar & Mantap (Full-Width di Mobile) -->
                    <div class="mt-8 sm:mt-10 flex flex-col gap-3.5 sm:flex-row sm:justify-center w-full max-w-sm sm:max-w-none mx-auto">
                        <a href="{{ route('contact.show') }}" wire:navigate class="agency-btn-primary w-full sm:w-auto inline-flex items-center justify-center gap-2.5 px-8 py-4 text-base sm:text-lg font-extrabold shadow-2xl transition-all duration-300 hover:scale-[1.03]" aria-label="Konsultasi Gratis">
                            <span>{{ $hero?->cta_primary_label ?? 'Konsultasi Gratis' }}</span>
                            <i class="fa-solid fa-arrow-right text-sm"></i>
                        </a>

                        <a href="#portofolio" class="agency-btn-secondary w-full sm:w-auto inline-flex items-center justify-center gap-2.5 px-8 py-4 text-base sm:text-lg font-extrabold shadow-xl transition-all duration-300 hover:scale-[1.03]" aria-label="Lihat Portofolio">
                            <span>{{ $hero?->cta_secondary_label ?? 'Lihat Portofolio' }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section id="tentang" class="scroll-mt-28 relative bg-white py-16 sm:py-20 lg:py-24">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid gap-10 lg:grid-cols-[220px_1fr] lg:items-start">
                    <div>
                        <div class="agency-divider"></div>
                        <h2 class="mt-4 text-4xl font-bold leading-none tracking-tight text-slate-900 sm:text-5xl">
                            SIAPA<br>KAMI?
                        </h2>
                    </div>

                    <div class="max-w-4xl">
                        <p class="pt-2 text-base leading-8 text-slate-700 sm:text-xl sm:leading-relaxed font-normal">
                            {{ $about?->body ?? 'Kami merancang pengalaman digital end-to-end—mulai dari strategi, desain UI/UX, hingga pengembangan website, software, mobile apps, game, dan 3D asset. Fokus kami sederhana: hasil yang elegan, cepat, dan siap scale.' }}
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section id="why-us" class="scroll-mt-28 relative overflow-hidden bg-[linear-gradient(135deg,rgb(var(--agency-navy-1)),rgb(var(--agency-navy-2)))] py-16 sm:py-24 lg:py-28">
            <div class="pointer-events-none absolute inset-0">
                <div class="absolute -top-24 -right-24 h-96 w-96 rounded-full bg-sky-500/10 blur-3xl"></div>
                <div class="absolute -bottom-24 -left-24 h-96 w-96 rounded-full bg-sky-400/10 blur-3xl"></div>
            </div>

            <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col items-center text-center">
                    <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl lg:text-5xl">
                        Dari Ide hingga <br class="sm:hidden" /><span class="text-sky-400">Siap Scale</span>
                    </h2>
                    <p class="mt-4 max-w-2xl text-base font-normal text-white/80 sm:text-lg">
                        Solusi digital agency terlengkap dengan berbagai keunggulan untuk kesuksesan bisnismu
                    </p>
                </div>

                <div class="mt-14 grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-2 lg:grid-cols-3 sm:gap-10 lg:gap-12">
                    @foreach (($advantages ?? collect()) as $adv)
                        @php
                            $titleLower = mb_strtolower($adv->title);
                            $iconClass = 'fa-solid fa-circle-check';

                            if (str_contains($titleLower, 'desain') || str_contains($titleLower, 'ui')) {
                                $iconClass = 'fa-solid fa-wand-magic-sparkles';
                            } elseif (str_contains($titleLower, 'cepat') || str_contains($titleLower, 'pengerjaan')) {
                                $iconClass = 'fa-solid fa-bolt-lightning';
                            } elseif (str_contains($titleLower, 'tim') || str_contains($titleLower, 'profesional')) {
                                $iconClass = 'fa-solid fa-user-group';
                            } elseif (str_contains($titleLower, 'support') || str_contains($titleLower, 'maintenance')) {
                                $iconClass = 'fa-solid fa-headset';
                            } elseif (str_contains($titleLower, 'teknologi') || str_contains($titleLower, 'terbaru')) {
                                $iconClass = 'fa-solid fa-layer-group';
                            } elseif (str_contains($titleLower, 'harga') || str_contains($titleLower, 'kompetitif')) {
                                $iconClass = 'fa-solid fa-award';
                            }
                        @endphp

                        <div class="group flex flex-col items-center text-center">
                            <div class="grid h-12 w-12 sm:h-16 sm:w-16 place-items-center rounded-2xl bg-gradient-to-br from-sky-400 via-sky-500 to-sky-600 text-white shadow-lg shadow-sky-500/30 transition-transform duration-300 group-hover:scale-110">
                                <i class="{{ $iconClass }} text-xl sm:text-2xl" aria-hidden="true"></i>
                            </div>

                            <h3 class="mt-4 sm:mt-6 text-sm sm:text-lg font-bold text-white leading-snug transition-colors group-hover:text-sky-300">
                                {{ $adv->title }}
                            </h3>

                            <p class="mt-2 sm:mt-3 text-xs sm:text-sm leading-relaxed text-white/75 max-w-xs">
                                {{ $adv->description }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section id="layanan" class="scroll-mt-28 relative bg-slate-50 pt-8 sm:pt-12 lg:pt-16 pb-16 sm:pb-24 lg:pb-32">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col items-center text-center">
                    <div class="agency-divider mx-auto"></div>
                    <h2 class="mt-4 text-3xl font-bold tracking-tight text-[rgb(var(--agency-navy-1))] sm:text-4xl lg:text-5xl">Layanan Kami</h2>
                    <p class="mt-3 max-w-2xl text-base font-semibold text-slate-700 sm:text-lg">
                        Solusi Digital End-to-End untuk Membantu Bisnis Anda Grow & Scale
                    </p>
                </div>

                @php
                    $serviceList = ($services ?? collect())->values();
                @endphp

                <!-- Layanan Mobile: 1 Card Per View (Native Touch Swipe, Zero Peek, Desain Persis Desktop) -->
                <div class="block sm:hidden mt-4 w-full max-w-full overflow-x-auto snap-x snap-mandatory no-scrollbar flex gap-0 scroll-smooth touch-pan-x py-6 px-1">
                    @foreach ($serviceList as $service)
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
                        <div class="w-full min-w-full shrink-0 snap-center snap-always px-2 py-2">
                            <a href="{{ route('services.show', $service->slug) }}" wire:navigate class="agency-service-card flex h-full flex-col p-7" aria-label="Detail Layanan {{ $service->title }}">
                                <div class="grid h-14 w-14 place-items-center rounded-2xl border border-sky-100 bg-sky-50 text-sky-600 shadow-sm">
                                    <i class="{{ $iconClass }} text-xl" aria-hidden="true"></i>
                                </div>
                                <h3 class="mt-6 text-xl font-bold leading-snug tracking-tight text-[rgb(var(--agency-navy-1))]">{{ strtoupper($service->title) }}</h3>
                                <p class="mt-3 text-xs leading-relaxed text-slate-500">{{ $service->excerpt }}</p>
                                <div class="mt-auto flex items-center justify-end pt-8 text-sky-600">
                                    <i class="fa-solid fa-arrow-right text-base transition-transform group-hover:translate-x-1" aria-hidden="true"></i>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <!-- Layanan Tampilan Desktop Carousel Track (>= sm) -->
                <div class="hidden sm:block mt-12 sm:mt-16">
                    <div data-carousel data-carousel-autoplay="false" data-carousel-loop="true" data-carousel-featured-center="true" class="relative mx-auto max-w-[74rem]">
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 -left-3 z-10 flex items-center sm:-left-6 lg:-left-8">
                                <button type="button" data-carousel-prev class="pointer-events-auto grid h-10 w-10 place-items-center rounded-full border border-slate-200 bg-white/90 text-slate-700 shadow-md backdrop-blur-md transition hover:-translate-y-0.5 hover:border-sky-200 hover:text-[rgb(var(--agency-navy-1))] active:scale-95 sm:h-12 sm:w-12" aria-label="Layanan Sebelumnya">
                                    <i class="fa-solid fa-chevron-left text-sm" aria-hidden="true"></i>
                                </button>
                            </div>
                            <div class="pointer-events-none absolute inset-y-0 -right-3 z-10 flex items-center sm:-right-6 lg:-right-8">
                                <button type="button" data-carousel-next class="pointer-events-auto grid h-10 w-10 place-items-center rounded-full border border-slate-200 bg-white/90 text-slate-700 shadow-md backdrop-blur-md transition hover:-translate-y-0.5 hover:border-sky-200 hover:text-[rgb(var(--agency-navy-1))] active:scale-95 sm:h-12 sm:w-12" aria-label="Layanan Selanjutnya">
                                    <i class="fa-solid fa-chevron-right text-sm" aria-hidden="true"></i>
                                </button>
                            </div>

                            <div data-carousel-track class="no-scrollbar flex w-full gap-6 snap-x snap-mandatory overflow-x-auto scroll-smooth pb-10 pt-10 px-1">
                                @foreach ($serviceList as $service)
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
                                    <div class="w-full shrink-0 snap-center sm:w-[46%] lg:w-[31.5%] py-2">
                                        <a href="{{ route('services.show', $service->slug) }}" wire:navigate data-carousel-feature-card class="agency-service-card flex h-full flex-col p-6 sm:p-9 lg:p-10" aria-label="Detail Layanan {{ $service->title }}">
                                            <div class="grid h-14 w-14 sm:h-16 sm:w-16 place-items-center rounded-2xl border border-sky-100 bg-sky-50 text-sky-600 shadow-sm">
                                                <i class="{{ $iconClass }} text-xl sm:text-2xl" aria-hidden="true"></i>
                                            </div>
                                            <h3 class="mt-6 sm:mt-8 text-xl sm:text-2xl font-bold leading-snug tracking-tight text-[rgb(var(--agency-navy-1))]">{{ strtoupper($service->title) }}</h3>
                                            <p class="mt-3 sm:mt-4 text-xs sm:text-base leading-relaxed sm:leading-relaxed text-slate-500">{{ $service->excerpt }}</p>
                                            <div class="mt-auto flex items-center justify-end pt-8 sm:pt-10 text-sky-600">
                                                <i class="fa-solid fa-arrow-right text-base sm:text-lg transition-transform group-hover:translate-x-1" aria-hidden="true"></i>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="portofolio" class="scroll-mt-28 bg-[linear-gradient(135deg,rgb(var(--agency-navy-1)),rgb(var(--agency-navy-2)))]">
            <div class="agency-wave -mb-px rotate-180" aria-hidden="true">
                <svg viewBox="0 0 1440 120" preserveAspectRatio="none" class="block w-full h-12 sm:h-20 lg:h-28" aria-hidden="true">
                    <path fill="#f8fafc" d="M0,64 C240,120 480,120 720,86 C960,52 1200,0 1440,16 L1440,120 L0,120 Z"></path>
                </svg>
            </div>

            <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-24">
                <div class="flex flex-col items-center text-center">
                    <div class="agency-divider mx-auto"></div>
                    <h2 class="mt-4 text-3xl font-bold tracking-tight text-white sm:text-4xl lg:text-5xl">Portofolio</h2>
                    <p class="mt-3 max-w-2xl text-base font-semibold text-slate-200 sm:text-lg">
                        Menampilkan Project Terbaik dari Setiap Kolaborasi
                    </p>
                </div>

                @php
                    $items = ($portfolios ?? collect())
                        ->map(fn ($p) => [
                            'id' => $p->slug,
                            'title' => $p->title,
                            'src' => $p->preview_image_src ?: $p->cover_image_src,
                            'url' => route('portfolios.show', $p->slug),
                        ])
                        ->filter(fn ($p) => filled($p['src']))
                        ->values();
                @endphp

                <div
                    x-data="{
                        active: 0,
                        total: {{ $items->count() }},
                        timer: null,
                        startAutoPlay() {
                            if (this.total <= 1) return;
                            this.timer = setInterval(() => {
                                if (window.innerWidth < 640) {
                                    this.active = (this.active + 1) % this.total;
                                }
                            }, 4500);
                        }
                    }"
                    x-init="startAutoPlay()"
                    class="mt-8 sm:mt-16"
                >
                    @if ($items->count() === 0)
                        <div class="rounded-3xl border border-white/15 bg-white/10 p-8 text-center text-sm text-slate-200 font-medium">
                            Belum ada data portofolio.
                        </div>
                    @else
                        <!-- Portofolio Mobile: Auto-Changing Fade Carousel (< sm) -->
                        <div class="block sm:hidden relative w-full aspect-video overflow-hidden rounded-3xl bg-slate-900 shadow-2xl border border-white/10 select-none">
                            @foreach ($items as $idx => $item)
                                <div
                                    x-show="active === {{ $idx }}"
                                    x-transition:enter="transition opacity duration-700 ease-in-out"
                                    x-transition:enter-start="opacity-0"
                                    x-transition:enter-end="opacity-100"
                                    x-transition:leave="transition opacity duration-500 ease-in-out"
                                    x-transition:leave-start="opacity-100"
                                    x-transition:leave-end="opacity-0"
                                    class="absolute inset-0 h-full w-full"
                                >
                                    <a href="{{ $item['url'] }}" wire:navigate class="group block h-full w-full" aria-label="Lihat Project {{ $item['title'] }}">
                                        <div data-hover-shot class="no-scrollbar h-full w-full overflow-y-auto overscroll-contain rounded-3xl bg-slate-900">
                                            <img class="block h-full w-full object-cover object-top transition-opacity duration-300" loading="lazy" width="600" height="337" alt="Preview Project {{ $item['title'] }}" src="{{ $item['src'] }}" />
                                        </div>
                                        <div class="pointer-events-none absolute inset-x-0 bottom-0 bg-gradient-to-t from-slate-950/90 via-slate-950/40 to-transparent p-5 text-white">
                                            <div class="text-[11px] font-medium text-sky-400">Featured Project</div>
                                            <div class="mt-0.5 text-base font-bold tracking-tight text-white">{{ $item['title'] }}</div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>

                        <!-- Tampilan Desktop Carousel Track (>= sm) -->
                        <div data-carousel data-carousel-autoplay="false" data-carousel-loop="true" data-carousel-theme="dark" class="hidden sm:block relative px-2 sm:px-4 lg:px-6">
                            <div class="pointer-events-none absolute inset-y-0 -left-2 z-10 hidden sm:flex items-center sm:-left-4">
                                <button type="button" data-carousel-prev class="pointer-events-auto grid h-11 w-11 place-items-center rounded-2xl border border-white/20 bg-slate-950/70 text-white shadow-lg backdrop-blur-md transition-all hover:scale-105 hover:bg-white/25 active:scale-95 sm:h-12 sm:w-12" aria-label="Portofolio Sebelumnya">
                                    <i class="fa-solid fa-chevron-left text-sm" aria-hidden="true"></i>
                                </button>
                            </div>
                            <div class="pointer-events-none absolute inset-y-0 -right-2 z-10 flex items-center sm:-right-4">
                                <button type="button" data-carousel-next class="pointer-events-auto grid h-10 w-10 sm:h-12 sm:w-12 place-items-center rounded-2xl border border-white/20 bg-slate-950/80 text-white shadow-lg backdrop-blur-md transition-all hover:scale-105 hover:bg-white/25 active:scale-95" aria-label="Portofolio Selanjutnya">
                                    <i class="fa-solid fa-chevron-right text-sm" aria-hidden="true"></i>
                                </button>
                            </div>

                            <!-- Carousel Track -->
                            <div data-carousel-track class="no-scrollbar flex w-full gap-6 overflow-x-auto scroll-smooth py-4 select-none">
                                @foreach ($items as $item)
                                    <div class="w-[85%] shrink-0 sm:w-[calc(50%-0.75rem)] lg:w-[calc(33.333%-1rem)]">
                                        <a href="{{ $item['url'] }}" wire:navigate class="group block h-full" aria-label="Lihat Project {{ $item['title'] }}">
                                            <div data-hover-shot class="no-scrollbar aspect-video w-full overflow-y-auto overscroll-contain rounded-2xl bg-slate-900 shadow-xl transition-all duration-300 group-hover:-translate-y-1.5 group-hover:shadow-2xl group-hover:shadow-cyan-500/20">
                                                <img class="block w-full object-cover object-top transition-opacity duration-300" loading="lazy" width="600" height="337" alt="Preview Project {{ $item['title'] }}" src="{{ $item['src'] }}" />
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <div class="mt-12 flex justify-center">
                    <a href="{{ route('portfolios.index') }}" wire:navigate class="agency-btn-primary group inline-flex items-center gap-2 px-8 py-3.5 text-sm font-semibold shadow-lg transition-all duration-300 hover:-translate-y-0.5" aria-label="Buka Semua Halaman Portofolio">
                        <span>Lihat Selengkapnya</span>
                        <i class="fa-solid fa-arrow-right text-xs transition-transform group-hover:translate-x-1" aria-hidden="true"></i>
                    </a>
                </div>
            </div>

            <div class="agency-wave -mt-px" aria-hidden="true">
                <svg viewBox="0 0 1440 120" preserveAspectRatio="none" class="block w-full h-12 sm:h-20 lg:h-28" aria-hidden="true">
                    <path fill="#ffffff" d="M0,64 C240,120 480,120 720,86 C960,52 1200,0 1440,16 L1440,120 L0,120 Z"></path>
                </svg>
            </div>
        </section>

        <section id="harga" class="scroll-mt-28 bg-white">
            <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-24">
                <div class="text-center">
                    <div class="mx-auto flex justify-center">
                        <div class="agency-divider"></div>
                    </div>
                    <p class="mt-4 text-sm font-bold text-slate-800">Pricing</p>
                    <h2 class="mt-3 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">Paket fleksibel untuk setiap kebutuhan</h2>
                    <p class="mx-auto mt-4 max-w-2xl text-base leading-relaxed text-slate-700 font-normal">
                        Pilih paket sesuai scope. Semua paket sudah termasuk konsultasi, timeline yang jelas, dan dokumentasi.
                    </p>
                </div>

                @php
                    $pricingList = ($pricingPlans ?? collect())->values();
                @endphp

                <!-- Pricing Mobile: 1 Card Per View (Native Touch Swipe, Zero Peek) -->
                <div class="block lg:hidden mt-4 w-full max-w-full overflow-x-auto snap-x snap-mandatory no-scrollbar flex gap-0 scroll-smooth touch-pan-x py-6 px-1">
                    @foreach ($pricingList as $plan)
                        @php $popular = (bool) $plan->is_popular; @endphp
                        <div class="w-full min-w-full shrink-0 snap-center snap-always px-2 py-2">
                            <div class="agency-card relative flex flex-col justify-between p-7 {{ $popular ? 'ring-2 ring-[rgb(var(--agency-cyan)/0.55)]' : '' }}">
                                <div>
                                    @if ($popular)
                                        <div class="inline-block mb-3 rounded-full bg-[rgb(var(--agency-cyan))] px-3 py-1 text-xs font-semibold text-[rgb(var(--agency-navy-1))]">Paling populer</div>
                                    @endif
                                    <div class="flex items-start justify-between gap-4">
                                        <div>
                                            <h3 class="text-lg font-bold text-slate-900">{{ $plan->name }}</h3>
                                            <div class="mt-1 text-xs font-semibold text-slate-500">{{ $plan->tag }}</div>
                                        </div>
                                    </div>

                                    @if ($plan->price_text)
                                        <div class="mt-4 text-2xl font-bold tracking-tight text-[rgb(var(--agency-navy-1))]">{{ $plan->price_text }}</div>
                                    @endif
                                    <p class="mt-2 text-xs leading-relaxed text-slate-600">{{ $plan->description }}</p>

                                    <div class="mt-6 space-y-2.5 text-xs text-slate-700">
                                        @foreach ($plan->features as $feat)
                                            <div class="flex items-center gap-2.5">
                                                <i class="fa-solid fa-check text-xs text-[rgb(var(--agency-cyan))]" aria-hidden="true"></i>
                                                <span>{{ $feat->text }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <a href="{{ route('contact.show') }}" wire:navigate class="mt-8 inline-flex w-full items-center justify-center rounded-full bg-[rgb(var(--agency-navy-1))] px-6 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-[rgb(var(--agency-navy-2))]" aria-label="Konsultasi Paket {{ $plan->name }}">
                                    Konsultasi Paket
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pricing Tampilan Desktop Grid (>= lg) -->
                <div class="hidden lg:grid lg:grid-cols-3 lg:gap-8 mt-10 py-6 px-1 items-stretch">
                    @foreach ($pricingList as $plan)
                        @php $popular = (bool) $plan->is_popular; @endphp
                        <div class="py-2 flex flex-col">
                            <div class="agency-card relative flex h-full flex-col justify-between p-8 {{ $popular ? 'ring-2 ring-[rgb(var(--agency-cyan)/0.55)]' : '' }}">
                            <div>
                                @if ($popular)
                                    <div class="inline-block mb-3 lg:absolute lg:right-6 lg:top-6 rounded-full bg-[rgb(var(--agency-cyan))] px-3 py-1 text-xs font-semibold text-[rgb(var(--agency-navy-1))]">Paling populer</div>
                                @endif
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <h3 class="text-lg font-bold text-slate-900">{{ $plan->name }}</h3>
                                        <div class="mt-1 text-xs font-semibold text-slate-500">{{ $plan->tag }}</div>
                                    </div>
                                </div>

                                @if ($plan->price_text)
                                    <div class="mt-4 text-2xl font-bold tracking-tight text-[rgb(var(--agency-navy-1))] sm:text-3xl">{{ $plan->price_text }}</div>
                                @endif
                                <p class="mt-2 text-xs leading-relaxed text-slate-600 sm:text-sm">{{ $plan->description }}</p>

                                <div class="mt-6 space-y-2.5 text-xs text-slate-700 sm:text-sm">
                                    @foreach ($plan->features as $feat)
                                        <div class="flex items-center gap-2.5">
                                            <i class="fa-solid fa-check text-xs text-[rgb(var(--agency-cyan))]" aria-hidden="true"></i>
                                            <span>{{ $feat->text }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <a href="{{ route('contact.show') }}" wire:navigate class="mt-8 inline-flex w-full items-center justify-center rounded-full bg-[rgb(var(--agency-navy-1))] px-6 py-3 text-sm font-bold text-white shadow-sm transition hover:-translate-y-0.5 hover:bg-[rgb(var(--agency-navy-2))]" aria-label="Konsultasi Paket {{ $plan->name }}">
                                Konsultasi Paket
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section id="kontak" class="scroll-mt-28 relative bg-white py-16 sm:py-24 lg:py-32">
            <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
                <div class="relative overflow-hidden rounded-[2.5rem] bg-[linear-gradient(135deg,rgb(var(--agency-navy-1)),rgb(var(--agency-navy-2)))] p-8 text-center shadow-2xl sm:p-12 lg:p-16">
                    <div class="pointer-events-none absolute -right-16 -top-16 h-64 w-64 rounded-full bg-[rgb(var(--agency-cyan)/0.2)] blur-3xl" aria-hidden="true"></div>
                    <div class="pointer-events-none absolute -bottom-16 -left-16 h-64 w-64 rounded-full bg-white/10 blur-3xl" aria-hidden="true"></div>

                    <div class="relative flex flex-col items-center text-center">
                        <div class="agency-divider mx-auto"></div>
                        <h2 class="mt-4 text-3xl font-bold tracking-tight text-white sm:text-4xl lg:text-5xl">
                            {{ $cta?->heading ?? 'Siap Membangun Produk Digital Anda?' }}
                        </h2>
                        <p class="mt-4 max-w-2xl text-base leading-relaxed text-slate-100 sm:text-lg font-medium">
                            {{ $cta?->body ?? 'Ceritakan kebutuhan Anda. Kami bantu dari ide hingga eksekusi—dengan desain futuristik, performa cepat, dan pengalaman pengguna yang elegan.' }}
                        </p>
                        <div class="mt-8 flex flex-col gap-4 sm:flex-row sm:justify-center">
                            <a href="{{ route('contact.show') }}" wire:navigate class="agency-btn-primary inline-flex items-center justify-center px-8 py-3.5 text-sm font-bold shadow-lg transition-transform hover:-translate-y-0.5" aria-label="Konsultasi Sekarang">
                                {{ $cta?->primary_label ?? 'Konsultasi Sekarang' }}
                            </a>
                            <a href="{{ $cta?->secondary_url ?: '#portofolio' }}" class="agency-btn-secondary inline-flex items-center justify-center px-8 py-3.5 text-sm font-bold shadow-md transition-transform hover:-translate-y-0.5" aria-label="Lihat Hasil Karya Kami">
                                {{ $cta?->secondary_label ?? 'Lihat Hasil Kami' }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>
