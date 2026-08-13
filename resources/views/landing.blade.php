@extends('layouts.marketing')

@section('title', 'Sankara Tech - Digital Agency')

@section('content')
    @php
        $contact = is_array($contact ?? null) ? $contact : [];
        $publicEmail = $contact['email'] ?? ($contact['inbox_email'] ?? null);
        $publicEmail = filled($publicEmail) ? $publicEmail : 'hello@sankaratech.com';
        $publicWhatsapp = filled($contact['whatsapp'] ?? null) ? $contact['whatsapp'] : '+62 812-0000-0000';
        $publicHours = filled($contact['hours'] ?? null) ? $contact['hours'] : 'Senin–Jumat, 09.00–18.00 WIB';
    @endphp

    @include('partials.marketing-header', [
        'active' => 'home',
        'homeHref' => '#home',
        'headerId' => 'home',
        'scrollNavbar' => true,
        'variant' => 'landing',
    ])

    <main class="pt-0">
        <section id="home" class="agency-hero relative overflow-hidden pt-28">
            <div class="agency-hero-grid pointer-events-none absolute inset-0 opacity-45"></div>
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mx-auto max-w-3xl text-center">
                    <div class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-4 py-2 text-xs font-semibold text-white/85 backdrop-blur">
                        <span class="h-1.5 w-1.5 rounded-full bg-[rgb(var(--agency-cyan))]"></span>
                        Web & Product Agency
                    </div>

                    <h1 class="mt-6 text-4xl font-semibold tracking-tight text-white sm:text-5xl lg:text-6xl">
                        {{ $hero?->heading ?? 'Inovasi Digital untuk Pertumbuhan Bisnis Anda' }}
                    </h1>

                    <p class="mx-auto mt-5 max-w-2xl text-base leading-relaxed text-white/80 sm:text-lg">
                        {{ $hero?->subheading ?? 'Kami membantu bisnis berkembang melalui solusi digital modern seperti website, aplikasi mobile, software custom, desain kreatif, game development, dan 3D modeling.' }}
                    </p>

                    <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row sm:items-center">
                        <a href="{{ route('contact.show') }}" class="agency-btn-primary inline-flex items-center justify-center gap-2 px-8 py-3 text-sm font-semibold">
                            {{ $hero?->primary_cta_label ?? 'Mulai Proyek' }}
                            <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5">
                                <path d="M5 12h12" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                <path d="M13 6l6 6-6 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>

                        <a href="{{ $hero?->secondary_cta_url ?: '#portofolio' }}" class="agency-btn-secondary inline-flex items-center justify-center gap-2 px-8 py-3 text-sm font-semibold">
                            {{ $hero?->secondary_cta_label ?? 'Lihat Portofolio' }}
                            <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5 text-white/70">
                                <path d="M8 5h8M8 12h8M8 19h8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="relative mx-auto mt-14 max-w-[70rem] pb-16 lg:pb-24">
                    <div class="agency-code-panel relative mx-auto max-w-4xl">
                        <div class="flex items-center justify-between border-b border-white/10 px-5 py-4">
                            <div class="flex items-center gap-2">
                                <span class="h-2.5 w-2.5 rounded-full bg-rose-400"></span>
                                <span class="h-2.5 w-2.5 rounded-full bg-amber-400"></span>
                                <span class="h-2.5 w-2.5 rounded-full bg-emerald-400"></span>
                                <div class="ml-3 hidden rounded-full border border-white/10 bg-white/5 px-3 py-1 text-[11px] font-medium text-white/55 sm:block">app/Http/Controllers/HomeController.php</div>
                            </div>
                            <div class="agency-pill hidden px-3 py-1 text-[11px] font-medium sm:block">Laravel • Blade • Livewire</div>
                        </div>

                        <div class="grid gap-0 lg:grid-cols-[88px_1fr]">
                            <div class="hidden border-r border-white/8 bg-black/10 px-4 py-5 text-right text-xs leading-10 text-white/28 lg:block">
                                @for ($i = 1; $i <= 9; $i++)
                                    <div>{{ $i }}</div>
                                @endfor
                            </div>
                            <div class="agency-code-lines overflow-hidden px-5 py-5 font-mono text-[13px] leading-10 sm:px-7 sm:text-[14px]">
                                <div><span class="text-cyan-300">const</span> <span class="text-sky-200">agency</span> <span class="text-white/70">=</span> <span class="text-white">{</span></div>
                                <div class="pl-4"><span class="text-sky-200">name</span><span class="text-white/70">:</span> <span class="text-emerald-300">'Sankara Tech'</span><span class="text-white/60">,</span></div>
                                <div class="pl-4"><span class="text-sky-200">focus</span><span class="text-white/70">:</span> <span class="text-emerald-300">['website', 'software', 'mobile']</span><span class="text-white/60">,</span></div>
                                <div class="pl-4"><span class="text-sky-200">approach</span><span class="text-white/70">:</span> <span class="text-emerald-300">'clean UI, fast build, scalable system'</span><span class="text-white/60">,</span></div>
                                <div class="pl-4"><span class="text-sky-200">delivery</span><span class="text-white/70">:</span> <span class="text-emerald-300">'design to launch'</span></div>
                                <div><span class="text-white">}</span></div>
                                <div class="mt-2"><span class="text-cyan-300">export default</span> <span class="text-sky-200">agency</span><span class="text-white/60">;</span></div>
                                <div class="mt-2"><span class="text-cyan-300">echo</span> <span class="text-emerald-300">"Hello, World!"</span><span class="text-white/60">;</span></div>
                            </div>
                        </div>
                    </div>

                <div class="pointer-events-none absolute -left-6 top-6 hidden h-20 w-20 rounded-3xl border border-white/15 bg-white/10 blur-sm sm:block"></div>
                <div class="pointer-events-none absolute -right-8 bottom-14 hidden h-24 w-24 rounded-full border border-white/15 bg-white/10 blur-sm sm:block"></div>
                <div class="pointer-events-none absolute left-12 bottom-10 hidden h-3 w-3 rounded-full bg-[rgb(var(--agency-cyan))] sm:block"></div>
            </div>
        </section>

        <section id="tentang" class="scroll-mt-28 relative bg-white py-16 sm:py-20 lg:py-24">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid gap-10 lg:grid-cols-[220px_1fr] lg:items-start">
                    <div>
                        <div class="agency-divider"></div>
                        <h2 class="mt-4 text-4xl font-bold leading-none tracking-tight text-slate-900 sm:text-5xl">
                            WHO<br>WE<br>ARE?
                        </h2>
                    </div>

                    <div class="max-w-4xl">
                        <p class="pt-2 text-base leading-8 text-slate-600 sm:text-xl sm:leading-relaxed">
                            {{ $about?->body ?? 'Kami merancang pengalaman digital end-to-end—mulai dari strategi, desain UI/UX, hingga pengembangan website, software, mobile apps, game, dan 3D asset. Fokus kami sederhana: hasil yang elegan, cepat, dan siap scale.' }}
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section id="why-us" class="scroll-mt-28 relative overflow-hidden bg-[linear-gradient(135deg,rgb(var(--agency-navy-1)),rgb(var(--agency-navy-2)))] pt-16 sm:pt-20 lg:pt-24">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col items-center text-center">
                    <div class="agency-divider mx-auto"></div>
                    <h2 class="mt-4 text-3xl font-bold tracking-tight text-white sm:text-4xl lg:text-5xl">Why Choose Us?</h2>
                    <p class="mt-3 max-w-2xl text-base font-medium text-white/80 sm:text-lg">
                        Keunggulan Utama & Alasan Mengapa Partner Memilih Sankara Tech
                    </p>
                </div>

                <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3 sm:mt-16 pb-12 sm:pb-16 lg:pb-20">
                    @foreach (($advantages ?? collect()) as $adv)
                        <div class="group relative flex flex-col justify-between overflow-hidden rounded-3xl border border-white/15 bg-white/10 p-8 shadow-xl backdrop-blur-md transition-all duration-300 hover:-translate-y-1.5 hover:border-emerald-400/40 hover:bg-white/15 hover:shadow-2xl">
                            <div>
                                <div class="grid h-14 w-14 place-items-center rounded-2xl border border-emerald-400/30 bg-emerald-400/10 text-emerald-400 transition-colors group-hover:bg-emerald-400 group-hover:text-slate-950">
                                    <svg viewBox="0 0 24 24" fill="none" class="h-7 w-7">
                                        <path d="M5 13l4 4L19 7" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <h3 class="mt-6 text-xl font-bold text-white transition-colors group-hover:text-emerald-400">{{ $adv->title }}</h3>
                                <p class="mt-3 text-sm leading-relaxed text-white/75">{{ $adv->description }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="agency-wave -mb-px">
                <svg viewBox="0 0 1440 120" preserveAspectRatio="none" class="block w-full h-12 sm:h-20 lg:h-28" aria-hidden="true">
                    <path fill="#f8fafc" d="M0,64 C240,120 480,120 720,86 C960,52 1200,0 1440,16 L1440,120 L0,120 Z"></path>
                </svg>
            </div>
        </section>

        <section id="layanan" class="scroll-mt-28 relative bg-slate-50 pt-8 sm:pt-12 lg:pt-16 pb-16 sm:pb-24 lg:pb-32">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                {{-- Header (Layanan Kami & Subjudul) --}}
                <div class="flex flex-col items-center text-center">
                    <div class="agency-divider mx-auto"></div>
                    <h2 class="mt-4 text-3xl font-bold tracking-tight text-[rgb(var(--agency-navy-1))] sm:text-4xl lg:text-5xl">Layanan Kami</h2>
                    <p class="mt-3 max-w-2xl text-base font-medium text-slate-600 sm:text-lg">
                        Solusi Digital End-to-End untuk Membantu Bisnis Anda Grow & Scale
                    </p>
                </div>

                @php
                    $serviceIcons = [
                        'website-development' => 'M7 7h10M7 12h10M7 17h10',
                        'software-development' => 'M12 6v12M6 12h12',
                        'mobile-app-development' => 'M7 4h10v16H7z',
                        'ui-ux-design' => 'M12 4l8 4-8 4-8-4 8-4Z',
                        'game-development' => 'M8 5v14l11-7L8 5Z',
                        '3d-modeling' => 'M12 3l9 5-9 5-9-5 9-5 9 5-9 5V8l9-5Z',
                    ];
                @endphp

                <div class="mt-12 sm:mt-16">
                    <div data-carousel data-carousel-autoplay="false" data-carousel-loop="true" data-carousel-featured-center="true" class="relative mx-auto max-w-[58rem]">
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 -left-3 z-10 flex items-center sm:-left-6 lg:-left-8">
                            <button type="button" data-carousel-prev class="pointer-events-auto grid h-10 w-10 place-items-center rounded-full border border-slate-200 bg-white/90 text-slate-700 shadow-md backdrop-blur-md transition hover:-translate-y-0.5 hover:border-sky-200 hover:text-[rgb(var(--agency-navy-1))] active:scale-95 sm:h-12 sm:w-12" aria-label="Sebelumnya">
                                <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5">
                                    <path d="M15 6l-6 6 6 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>
                        <div class="pointer-events-none absolute inset-y-0 -right-3 z-10 flex items-center sm:-right-6 lg:-right-8">
                            <button type="button" data-carousel-next class="pointer-events-auto grid h-10 w-10 place-items-center rounded-full border border-slate-200 bg-white/90 text-slate-700 shadow-md backdrop-blur-md transition hover:-translate-y-0.5 hover:border-sky-200 hover:text-[rgb(var(--agency-navy-1))] active:scale-95 sm:h-12 sm:w-12" aria-label="Selanjutnya">
                                <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5">
                                    <path d="M9 6l6 6-6 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>

                        <div data-carousel-track class="no-scrollbar flex gap-4 snap-x snap-mandatory overflow-x-auto scroll-smooth px-1 pb-10 pt-8">
                            @foreach (($services ?? collect()) as $service)
                                @php
                                    $icon = $serviceIcons[$service->slug] ?? 'M7 7h10M7 12h10M7 17h10';
                                @endphp
                                <div class="w-[88%] shrink-0 snap-center sm:w-[44%] lg:w-[32.2%]">
                                    <a href="{{ route('services.show', $service->slug) }}" data-carousel-feature-card class="agency-service-card flex h-full flex-col p-8">
                                        <div class="grid h-14 w-14 place-items-center rounded-2xl border border-sky-100 bg-[rgb(var(--agency-cyan)/0.08)] text-[rgb(var(--agency-cyan))]">
                                            <svg viewBox="0 0 24 24" fill="none" class="h-7 w-7">
                                                <path d="{{ $icon }}" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </div>
                                        <h3 class="mt-8 text-[1.8rem] font-semibold leading-tight tracking-tight text-[rgb(var(--agency-navy-1))]">{{ strtoupper($service->title) }}</h3>
                                        <p class="mt-4 max-w-xs text-sm leading-7 text-slate-500">{{ $service->excerpt }}</p>
                                        <div class="mt-auto flex items-center justify-end pt-10 text-[rgb(var(--agency-navy-2))]">
                                            <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5">
                                                <path d="M5 12h12" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                                <path d="M13 6l6 6-6 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mt-2 flex justify-center gap-2 lg:hidden" data-carousel-dots></div>
                </div>
            </div>
        </div>
    </section>

        <section id="portofolio" class="scroll-mt-28 bg-[linear-gradient(135deg,rgb(var(--agency-navy-1)),rgb(var(--agency-navy-2)))]">
            <div class="agency-wave -mb-px rotate-180">
                <svg viewBox="0 0 1440 120" preserveAspectRatio="none" aria-hidden="true">
                    <path fill="#f8fafc" d="M0,64 C240,120 480,120 720,86 C960,52 1200,0 1440,16 L1440,120 L0,120 Z"></path>
                </svg>
            </div>

            <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-24">
                {{-- Header (Portofolio & Subjudul) --}}
                <div class="flex flex-col items-center text-center">
                    <div class="agency-divider mx-auto"></div>
                    <h2 class="mt-4 text-3xl font-bold tracking-tight text-white sm:text-4xl lg:text-5xl">Portofolio</h2>
                    <p class="mt-3 max-w-2xl text-base font-medium text-white/80 sm:text-lg">
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

                {{-- Projek Cards (Auto-slide 3 di desktop, pause saat hover) --}}
                <div class="mt-12 sm:mt-16">
                    @if ($items->count() === 0)
                        <div class="rounded-3xl border border-white/15 bg-white/10 p-8 text-center text-sm text-white/75">
                            Belum ada data portofolio.
                        </div>
                    @else
                        <div data-carousel data-carousel-autoplay="false" data-carousel-loop="true" data-carousel-theme="dark" class="relative px-2 sm:px-4 lg:px-6">
                            <div class="pointer-events-none absolute inset-y-0 -left-2 z-10 flex items-center sm:-left-4">
                                <button type="button" data-carousel-prev class="pointer-events-auto grid h-11 w-11 place-items-center rounded-2xl border border-white/20 bg-slate-950/70 text-white shadow-lg backdrop-blur-md transition-all hover:scale-105 hover:bg-white/25 active:scale-95 sm:h-12 sm:w-12" aria-label="Sebelumnya">
                                    <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5">
                                        <path d="M15 6l-6 6 6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </button>
                            </div>
                            <div class="pointer-events-none absolute inset-y-0 -right-2 z-10 flex items-center sm:-right-4">
                                <button type="button" data-carousel-next class="pointer-events-auto grid h-11 w-11 place-items-center rounded-2xl border border-white/20 bg-slate-950/70 text-white shadow-lg backdrop-blur-md transition-all hover:scale-105 hover:bg-white/25 active:scale-95 sm:h-12 sm:w-12" aria-label="Selanjutnya">
                                    <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5">
                                        <path d="M9 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </button>
                            </div>

                            <div data-carousel-track class="no-scrollbar flex gap-6 snap-x snap-mandatory overflow-x-auto scroll-smooth py-4">
                                @foreach ($items as $item)
                                    <div class="w-full shrink-0 snap-start sm:w-[calc(50%-0.75rem)] lg:w-[calc(33.333%-1rem)]">
                                        <a href="{{ $item['url'] }}" class="group block h-full">
                                            <div data-hover-shot class="no-scrollbar aspect-[4/3] w-full overflow-y-auto overscroll-contain rounded-2xl bg-slate-900 shadow-xl transition-all duration-300 group-hover:-translate-y-1.5 group-hover:shadow-2xl group-hover:shadow-cyan-500/20 sm:aspect-[16/11]">
                                                <img class="block w-full object-cover object-top transition-opacity duration-300" alt="Preview {{ $item['title'] }}" src="{{ $item['src'] }}" />
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>

                            <div data-carousel-dots class="mt-8 flex justify-center gap-2"></div>
                        </div>
                    @endif
                </div>

                {{-- Tombol Lihat Selengkapnya (Bawah) --}}
                <div class="mt-12 flex justify-center">
                    <a href="{{ route('portfolios.index') }}" class="brand-gradient inline-flex items-center gap-2 rounded-full px-8 py-3.5 text-sm font-semibold text-white shadow-lg transition-all duration-300 hover:-translate-y-0.5 hover:shadow-cyan-500/30">
                        <span>Lihat Selengkapnya</span>
                        <svg viewBox="0 0 24 24" fill="none" class="h-4 w-4 transition-transform group-hover:translate-x-1">
                            <path d="M5 12h14M12 5l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                </div>
            </div>

            <div class="agency-wave -mt-px">
                <svg viewBox="0 0 1440 120" preserveAspectRatio="none" aria-hidden="true">
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
                    <p class="mt-4 text-sm font-semibold text-slate-600">Pricing</p>
                    <h2 class="mt-3 text-3xl font-semibold tracking-tight text-slate-900 sm:text-4xl">Paket fleksibel untuk setiap kebutuhan</h2>
                    <p class="mx-auto mt-4 max-w-2xl text-base leading-relaxed text-slate-600">
                        Pilih paket sesuai scope. Semua paket sudah termasuk konsultasi, timeline yang jelas, dan dokumentasi.
                    </p>
                </div>

                <div class="mt-12 grid gap-6 lg:grid-cols-3">
                    @foreach (($pricingPlans ?? collect()) as $plan)
                        @php $popular = (bool) $plan->is_popular; @endphp
                        <div class="agency-card relative p-8 {{ $popular ? 'ring-2 ring-[rgb(var(--agency-cyan)/0.55)]' : '' }}">
                            @if ($popular)
                                <div class="absolute right-6 top-6 rounded-full bg-[rgb(var(--agency-cyan))] px-3 py-1 text-xs font-semibold text-[rgb(var(--agency-navy-1))]">Paling populer</div>
                            @endif
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <div class="text-lg font-semibold text-slate-900">{{ $plan->name }}</div>
                                    <div class="mt-2 text-xs font-semibold text-slate-500">{{ $plan->tag }}</div>
                                </div>
                                <div class="h-10 w-10 rounded-2xl bg-[rgb(var(--agency-cyan)/0.12)]"></div>
                            </div>

                            @if ($plan->price_text)
                                <div class="mt-5 text-3xl font-semibold tracking-tight text-[rgb(var(--agency-navy-1))]">{{ $plan->price_text }}</div>
                            @endif
                            <p class="mt-3 text-sm leading-relaxed text-slate-600">{{ $plan->description }}</p>

                            <div class="mt-6 space-y-2 text-sm text-slate-700">
                                @foreach ($plan->features as $feat)
                                    <div class="flex items-center gap-2">
                                        <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5 text-[rgb(var(--agency-cyan))]">
                                            <path d="M7 12l3 3 7-7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <span>{{ $feat->text }}</span>
                                    </div>
                                @endforeach
                            </div>

                            <a href="{{ route('contact.show') }}" class="mt-8 inline-flex w-full items-center justify-center rounded-full bg-[rgb(var(--agency-navy-1))] px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:-translate-y-0.5 hover:bg-[rgb(var(--agency-navy-2))]">
                                Konsultasi Paket
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section id="kontak" class="scroll-mt-28 relative bg-white py-16 sm:py-24 lg:py-32">
            <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
                <div class="relative overflow-hidden rounded-[2.5rem] bg-[linear-gradient(135deg,rgb(var(--agency-navy-1)),rgb(var(--agency-navy-2)))] p-8 text-center shadow-2xl sm:p-12 lg:p-16">
                    <div class="pointer-events-none absolute -right-16 -top-16 h-64 w-64 rounded-full bg-[rgb(var(--agency-cyan)/0.2)] blur-3xl"></div>
                    <div class="pointer-events-none absolute -bottom-16 -left-16 h-64 w-64 rounded-full bg-white/10 blur-3xl"></div>

                    <div class="relative flex flex-col items-center text-center">
                        <div class="agency-divider mx-auto"></div>
                        <h2 class="mt-4 text-3xl font-bold tracking-tight text-white sm:text-4xl lg:text-5xl">
                            {{ $cta?->heading ?? 'Siap Membangun Produk Digital Anda?' }}
                        </h2>
                        <p class="mt-4 max-w-2xl text-base leading-relaxed text-white/80 sm:text-lg">
                            {{ $cta?->body ?? 'Ceritakan kebutuhan Anda. Kami bantu dari ide hingga eksekusi—dengan desain futuristik, performa cepat, dan pengalaman pengguna yang elegan.' }}
                        </p>
                        <div class="mt-8 flex flex-col gap-4 sm:flex-row sm:justify-center">
                            <a href="{{ route('contact.show') }}" class="agency-btn-primary inline-flex items-center justify-center px-8 py-3.5 text-sm font-semibold shadow-lg transition-transform hover:-translate-y-0.5">
                                {{ $cta?->primary_label ?? 'Konsultasi Sekarang' }}
                            </a>
                            <a href="{{ $cta?->secondary_url ?: '#portofolio' }}" class="agency-btn-secondary inline-flex items-center justify-center px-8 py-3.5 text-sm font-semibold shadow-md transition-transform hover:-translate-y-0.5">
                                {{ $cta?->secondary_label ?? 'Lihat Hasil Kami' }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
