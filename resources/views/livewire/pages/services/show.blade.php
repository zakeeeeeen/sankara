@php
    $seoStructured = app(\App\Services\SeoService::class)->renderStructuredData([
        'service' => [
            'title' => $service->title,
            'excerpt' => $service->excerpt,
            'description' => $service->description,
            'url' => route('services.show', $service->slug),
        ],
        'breadcrumb' => [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Layanan', 'url' => route('services.index')],
            ['name' => $service->title, 'url' => route('services.show', $service->slug)],
        ],
    ]);
@endphp

@section('title', $service->title . ' - ' . \App\Models\SiteSetting::getValue('site_name', 'Sankara Tech'))
@section('meta_description', $service->excerpt ?: $service->description)
@section('structured_data', $seoStructured)

<div>
    @include('partials.marketing-header', ['active' => 'services'])

    <main class="pt-28 pb-20 bg-white">
        <section class="relative overflow-hidden">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid gap-12 lg:grid-cols-2 lg:items-center">
                    <div class="reveal">
                        <div class="agency-divider"></div>
                        <h1 class="mt-4 text-4xl font-bold tracking-tight text-slate-900 sm:text-5xl">{{ $service->title }}</h1>
                        @if ($service->excerpt)
                            <p class="mt-4 max-w-xl text-base leading-relaxed text-slate-600 sm:text-lg">{{ $service->excerpt }}</p>
                        @endif
                        @if ($service->description)
                            <div class="mt-4 prose prose-slate prose-headings:font-bold prose-a:text-sky-600 prose-blockquote:border-sky-500 max-w-none">
                                {!! $service->description !!}
                            </div>
                        @endif

                        @if ($service->features->count())
                            <div class="mt-8 grid gap-3 sm:grid-cols-2">
                                @foreach ($service->features as $feature)
                                    <div class="flex items-start gap-3 rounded-2xl border border-slate-100 bg-slate-50/80 p-4 shadow-sm">
                                        <div class="mt-0.5 grid h-7 w-7 flex-none place-items-center rounded-xl border border-sky-100 bg-[rgb(var(--agency-cyan)/0.12)] text-[rgb(var(--agency-cyan))]">
                                            <i class="fa-solid fa-check text-xs"></i>
                                        </div>
                                        <div class="text-sm font-semibold text-slate-800">{{ $feature->text }}</div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <div class="mt-8">
                            <a href="{{ route('contact.show') }}" wire:navigate class="agency-btn-primary inline-flex items-center justify-center gap-2 px-8 py-3.5 text-sm font-semibold">
                                <span>Konsultasi Layanan Ini</span>
                                <i class="fa-solid fa-arrow-right text-xs"></i>
                            </a>
                        </div>
                    </div>

                    <div class="reveal">
                        <div class="agency-card overflow-hidden p-2">
                            @if ($service->image_src)
                                <img class="h-full w-full rounded-2xl object-cover" src="{{ $service->image_src }}" alt="{{ $service->title }}" />
                            @else
                                <div class="h-[340px] w-full rounded-2xl bg-[linear-gradient(135deg,rgb(var(--agency-navy-1)),rgb(var(--agency-navy-2)))] flex items-center justify-center p-8 text-center text-white">
                                    <div class="text-xl font-bold">{{ $service->title }}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @if (($relatedPortfolios ?? collect())->count())
            <section class="mt-16 bg-slate-50 py-16">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div>
                        <div class="agency-divider"></div>
                        <h2 class="mt-4 text-3xl font-bold tracking-tight text-[rgb(var(--agency-navy-1))] sm:text-4xl">Project yang Pernah Kami Kerjakan</h2>
                        <p class="mt-2 max-w-2xl text-base leading-relaxed text-slate-600">
                            Berikut beberapa hasil karya terbaik menggunakan kapabilitas layanan ini.
                        </p>
                    </div>

                    <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($relatedPortfolios as $portfolio)
                            <a
                                href="{{ route('portfolios.show', $portfolio->slug) }}"
                                wire:navigate
                                class="agency-card group overflow-hidden p-0"
                            >
                                <div class="relative overflow-hidden bg-slate-900">
                                    @if ($portfolio->preview_image_src)
                                        <div data-hover-shot class="no-scrollbar aspect-video overflow-y-auto overscroll-contain">
                                            <img class="w-full object-cover object-top" src="{{ $portfolio->preview_image_src }}" alt="Preview {{ $portfolio->title }}" />
                                        </div>
                                    @else
                                        <div class="aspect-video w-full bg-[linear-gradient(135deg,rgb(var(--agency-navy-1)),rgb(var(--agency-navy-2)))]"></div>
                                    @endif
                                </div>

                                <div class="p-6">
                                    <div class="text-base font-bold text-[rgb(var(--agency-navy-1))] group-hover:text-[rgb(var(--agency-cyan))] transition-colors">{{ $portfolio->title }}</div>

                                    <div class="mt-4 flex flex-wrap gap-2">
                                        @foreach ($portfolio->categories->take(3) as $cat)
                                            <span class="rounded-full border border-sky-100 bg-[rgb(var(--agency-cyan)/0.08)] px-3 py-1 text-xs font-semibold text-[rgb(var(--agency-navy-1))]">
                                                {{ $cat->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <div class="mt-10 flex justify-center">
                        <a href="{{ route('portfolios.index', ['service' => $service->slug]) }}" wire:navigate class="agency-btn-primary inline-flex items-center justify-center gap-2 px-8 py-3 text-sm font-semibold">
                            Lihat Selengkapnya
                        </a>
                    </div>
                </div>
            </section>
        @endif
    </main>
</div>
