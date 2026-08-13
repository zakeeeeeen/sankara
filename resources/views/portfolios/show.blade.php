@extends('layouts.marketing')

@section('title', $portfolio->title . ' - Sankara Tech')

@section('content')
    @include('partials.marketing-header', ['active' => 'portfolios'])

    <main class="pt-28 pb-20 bg-white">
        <section class="relative overflow-hidden">
            <div class="mx-auto max-w-7xl px-4 pb-12 sm:px-6 lg:px-8">
                <div class="grid gap-12 lg:grid-cols-2 lg:items-start">
                    <div class="reveal">
                        <div class="agency-divider"></div>
                        <h1 class="mt-4 text-4xl font-bold tracking-tight text-slate-900 sm:text-5xl">{{ $portfolio->title }}</h1>
                        <div class="mt-4 flex flex-wrap gap-2">
                            @foreach ($portfolio->categories as $cat)
                                <span class="rounded-full border border-sky-100 bg-[rgb(var(--agency-cyan)/0.08)] px-3.5 py-1 text-xs font-semibold text-[rgb(var(--agency-navy-1))]">
                                    {{ $cat->name }}
                                </span>
                            @endforeach
                        </div>

                        <div class="mt-8 space-y-8">
                            @if ($portfolio->excerpt)
                                <div>
                                    <h2 class="text-2xl font-bold tracking-tight text-[rgb(var(--agency-navy-1))]">Tentang Proyek</h2>
                                    <p class="mt-3 whitespace-pre-line text-base leading-relaxed text-slate-600">{{ $portfolio->excerpt }}</p>
                                </div>
                            @endif

                            @if ($portfolio->sections->count())
                                <div>
                                    <h2 class="text-2xl font-bold tracking-tight text-[rgb(var(--agency-navy-1))]">Fitur Utama</h2>
                                    <ul class="mt-4 space-y-3 text-base leading-relaxed text-slate-700">
                                        @foreach ($portfolio->sections as $section)
                                            @php
                                                $rawBody = $section->body ?? '';
                                                $bodyLines = array_values(array_filter(preg_split("/\r\n|\r|\n/", (string) $rawBody), fn ($line) => trim((string) $line) !== ''));
                                            @endphp

                                            @continue(!filled($section->heading) && count($bodyLines) === 0)

                                            <li class="flex gap-4 rounded-2xl border border-slate-100 bg-slate-50/80 p-4 shadow-sm">
                                                <div class="mt-1 grid h-7 w-7 flex-none place-items-center rounded-xl border border-sky-100 bg-[rgb(var(--agency-cyan)/0.12)] text-[rgb(var(--agency-cyan))]">
                                                    <svg viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                                                        <path d="M7 12l3 3 7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                </div>
                                                <div>
                                                    @if (filled($section->heading))
                                                        <div class="font-bold text-slate-900">{{ $section->heading }}</div>
                                                    @endif
                                                    @if (count($bodyLines) === 1)
                                                        <div class="mt-1 whitespace-pre-line text-sm leading-relaxed text-slate-600">{{ $bodyLines[0] }}</div>
                                                    @elseif (count($bodyLines) > 1)
                                                        <ul class="mt-2 space-y-2 text-sm leading-relaxed text-slate-600">
                                                            @foreach ($bodyLines as $line)
                                                                <li class="flex gap-2">
                                                                    <span class="mt-2 h-1.5 w-1.5 flex-none rounded-full bg-slate-400"></span>
                                                                    <div class="whitespace-pre-line">{{ $line }}</div>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div>
                                <a href="{{ route('contact.show') }}" class="agency-btn-primary inline-flex items-center justify-center gap-2 px-8 py-3.5 text-sm font-semibold">
                                    Konsultasi Proyek Serupa
                                    <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5">
                                        <path d="M5 12h12" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                        <path d="M13 6l6 6-6 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="reveal">
                        <div class="agency-card overflow-hidden p-2">
                            @php
                                $mainShot = $portfolio->cover_image_src ?: $portfolio->preview_image_src;
                            @endphp

                            @if ($mainShot)
                                <div data-hover-shot class="no-scrollbar h-[380px] overflow-y-auto overscroll-contain rounded-2xl bg-slate-900 sm:h-[440px] lg:h-[480px]">
                                    <img class="w-full object-cover object-top" src="{{ $mainShot }}" alt="{{ $portfolio->title }}" />
                                </div>
                            @else
                                <div class="h-[340px] w-full rounded-2xl bg-[linear-gradient(135deg,rgb(var(--agency-navy-1)),rgb(var(--agency-navy-2)))] flex items-center justify-center p-8 text-center text-white">
                                    <div class="text-xl font-bold">{{ $portfolio->title }}</div>
                                </div>
                            @endif
                        </div>

                        @if (is_array($portfolio->technologies) && count($portfolio->technologies))
                            <div class="mt-8">
                                <h3 class="text-base font-bold text-slate-900">Teknologi yang Digunakan</h3>
                                <div class="mt-3 flex flex-wrap gap-2">
                                    @foreach ($portfolio->technologies as $tech)
                                        @continue(!filled($tech))
                                        <span class="rounded-full border border-slate-200 bg-slate-50 px-3.5 py-1 text-xs font-semibold text-slate-700">
                                            {{ $tech }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

