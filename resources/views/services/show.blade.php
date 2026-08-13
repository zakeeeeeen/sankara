@extends('layouts.marketing')

@section('title', $service->title . ' - Sankara Tech')

@section('content')
    @include('partials.marketing-header', ['active' => 'services'])

    <main class="pt-24">
        <section class="relative overflow-hidden">
            <div class="mx-auto max-w-7xl px-4 pb-12 pt-12 sm:px-6 lg:px-8 lg:pb-16 lg:pt-16">
                <div class="grid gap-10 lg:grid-cols-2 lg:items-center">
                    <div class="reveal">
                        <p class="text-sm font-semibold text-brand">Layanan</p>
                        <h1 class="mt-3 text-4xl font-semibold tracking-tight text-slate-900 sm:text-5xl">{{ $service->title }}</h1>
                        @if ($service->excerpt)
                            <p class="mt-5 max-w-xl text-base leading-relaxed text-slate-600 sm:text-lg">{{ $service->excerpt }}</p>
                        @endif
                        @if ($service->description)
                            <p class="mt-4 max-w-xl text-base leading-relaxed text-slate-600">{{ $service->description }}</p>
                        @endif

                        @if ($service->features->count())
                            <div class="mt-8 grid gap-3 sm:grid-cols-2">
                                @foreach ($service->features as $feature)
                                    <div class="flex items-start gap-3 rounded-2xl border border-slate-200/70 bg-white/65 px-4 py-4 shadow-sm backdrop-blur">
                                        <span class="brand-gradient-br-soft ring-1 ring-brand-soft text-brand mt-0.5 grid h-9 w-9 place-items-center rounded-2xl">
                                            <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5">
                                                <path d="M7 12l3 3 7-7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M20 12a8 8 0 1 1-8-8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                            </svg>
                                        </span>
                                        <div class="text-sm font-medium leading-relaxed text-slate-700">{{ $feature->text }}</div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="reveal">
                        <div class="brand-gradient-br-soft rounded-[2rem] p-px shadow-[0_30px_80px_-55px_rgb(var(--brand-from-rgb)/0.55)]">
                            <div class="overflow-hidden rounded-[2rem] border border-white/60 bg-white/55 backdrop-blur-xl">
                                @if ($service->image_src)
                                    <img class="h-full w-full object-cover" src="{{ $service->image_src }}" alt="{{ $service->title }}" />
                                @else
                                    <div class="h-[340px] w-full"></div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @if (($relatedPortfolios ?? collect())->count())
            <section class="pb-16 sm:pb-20">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div>
                        <div>
                            <p class="text-sm font-semibold text-brand">Portofolio</p>
                            <h2 class="mt-3 text-3xl font-semibold tracking-tight text-slate-900 sm:text-4xl">Portofolio terkait</h2>
                            <p class="mt-3 max-w-2xl text-base leading-relaxed text-slate-600">
                                Project yang relevan dengan layanan ini berdasarkan kategori yang dipilih.
                            </p>
                        </div>
                    </div>

                    <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($relatedPortfolios as $portfolio)
                            <a
                                href="{{ route('portfolios.show', $portfolio->slug) }}"
                                class="group overflow-hidden rounded-3xl border border-slate-200/70 bg-white/70 shadow-sm backdrop-blur transition hover:-translate-y-1 hover:bg-white"
                            >
                                <div class="relative overflow-hidden">
                                    @if ($portfolio->preview_image_src)
                                        <div data-hover-shot class="no-scrollbar aspect-[4/3] overflow-y-auto overscroll-contain">
                                            <img class="w-full" src="{{ $portfolio->preview_image_src }}" alt="Preview {{ $portfolio->title }}" />
                                        </div>
                                    @else
                                        <div class="brand-gradient-br-soft aspect-[4/3] w-full"></div>
                                    @endif
                                    <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-white via-white/40 to-transparent opacity-0 transition duration-300 group-hover:opacity-100"></div>
                                </div>

                                <div class="p-6">
                                    <div class="text-base font-semibold text-slate-900">{{ $portfolio->title }}</div>
                                    @if ($portfolio->excerpt)
                                        <div class="mt-2 text-sm leading-relaxed text-slate-600">{{ $portfolio->excerpt }}</div>
                                    @endif

                                    <div class="mt-4 flex flex-wrap gap-2">
                                        @foreach ($portfolio->categories->take(3) as $cat)
                                            <span class="rounded-full border border-slate-200/70 bg-white/70 px-3 py-1 text-xs font-semibold text-slate-700 shadow-sm backdrop-blur">
                                                {{ $cat->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <div class="mt-10 flex justify-center">
                        <a href="{{ route('portfolios.index', ['service' => $service->slug]) }}" class="brand-gradient inline-flex items-center justify-center rounded-2xl px-6 py-3 text-sm font-semibold text-white shadow-[0_18px_50px_-26px_rgba(16,185,129,0.6)] transition hover:-translate-y-0.5">
                            Lihat Selengkapnya
                        </a>
                    </div>
                </div>
            </section>
        @endif
    </main>
@endsection

