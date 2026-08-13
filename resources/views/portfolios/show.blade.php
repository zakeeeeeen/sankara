@extends('layouts.marketing')

@section('title', $portfolio->title . ' - Sankara Tech')

@section('content')
    @include('partials.marketing-header', ['active' => 'portfolios'])

    <main class="pt-24">
        <section class="relative overflow-hidden">
            <div class="mx-auto max-w-7xl px-4 pb-12 pt-12 sm:px-6 lg:px-8 lg:pb-16 lg:pt-16">
                <div class="grid gap-10 lg:grid-cols-2 lg:items-start">
                    <div class="reveal">
                        <p class="text-sm font-semibold text-brand">Portofolio</p>
                        <h1 class="mt-3 text-4xl font-semibold tracking-tight text-slate-900 sm:text-5xl">{{ $portfolio->title }}</h1>
                        <div class="mt-6 flex flex-wrap gap-2">
                            @foreach ($portfolio->categories as $cat)
                                <span class="border-brand-soft text-brand rounded-full border bg-white/70 px-3 py-1 text-xs font-semibold shadow-sm backdrop-blur">
                                    {{ $cat->name }}
                                </span>
                            @endforeach
                        </div>

                        <div class="mt-10 space-y-10">
                            @if ($portfolio->excerpt)
                                <div>
                                    <h2 class="text-2xl font-semibold tracking-tight text-slate-900">Tentang Proyek</h2>
                                    <p class="mt-3 whitespace-pre-line text-base leading-relaxed text-slate-600">{{ $portfolio->excerpt }}</p>
                                </div>
                            @endif

                            @if ($portfolio->sections->count())
                                <div>
                                    <h2 class="text-2xl font-semibold tracking-tight text-slate-900">Fitur Utama</h2>
                                    <ul class="mt-4 space-y-3 text-base leading-relaxed text-slate-700">
                                        @foreach ($portfolio->sections as $section)
                                            @php
                                                $rawBody = $section->body ?? '';
                                                $bodyLines = array_values(array_filter(preg_split("/\r\n|\r|\n/", (string) $rawBody), fn ($line) => trim((string) $line) !== ''));
                                            @endphp

                                            @continue(!filled($section->heading) && count($bodyLines) === 0)

                                            @if (filled($section->heading))
                                                <li class="flex gap-3">
                                                    <span class="brand-dot mt-2 h-1.5 w-1.5 flex-none rounded-full"></span>
                                                    <div>
                                                        <div class="font-semibold text-slate-900">{{ $section->heading }}</div>
                                                        @if (count($bodyLines) === 1)
                                                            <div class="mt-1 whitespace-pre-line text-sm leading-relaxed text-slate-600">{{ $bodyLines[0] }}</div>
                                                        @elseif (count($bodyLines) > 1)
                                                            <ul class="mt-2 space-y-2 text-sm leading-relaxed text-slate-600">
                                                                @foreach ($bodyLines as $line)
                                                                    <li class="flex gap-3">
                                                                        <span class="mt-2 h-1.5 w-1.5 flex-none rounded-full bg-slate-300"></span>
                                                                        <div class="whitespace-pre-line">{{ $line }}</div>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </div>
                                                </li>
                                            @else
                                                @foreach ($bodyLines as $line)
                                                    <li class="flex gap-3">
                                                        <span class="brand-dot mt-2 h-1.5 w-1.5 flex-none rounded-full"></span>
                                                        <div class="whitespace-pre-line">{{ $line }}</div>
                                                    </li>
                                                @endforeach
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                        </div>
                    </div>

                    <div class="reveal lg:pt-7">
                        <div class="brand-gradient-br-soft rounded-[2rem] p-px shadow-[0_30px_80px_-55px_rgb(var(--brand-from-rgb)/0.55)]">
                            <div class="overflow-hidden rounded-[2rem] border border-white/60 bg-white/55 backdrop-blur-xl">
                                @php
                                    $mainShot = $portfolio->cover_image_src ?: $portfolio->preview_image_src;
                                @endphp

                                @if ($mainShot)
                                    <div data-hover-shot class="no-scrollbar h-[360px] overflow-y-auto overscroll-contain sm:h-[420px] lg:h-[480px]">
                                        <img class="w-full" src="{{ $mainShot }}" alt="{{ $portfolio->title }}" />
                                    </div>
                                @else
                                    <div class="h-[340px] w-full"></div>
                                @endif
                            </div>
                        </div>

                        @if (is_array($portfolio->technologies) && count($portfolio->technologies))
                            <div class="mt-8">
                                <h2 class="text-2xl font-semibold tracking-tight text-slate-900">Teknologi yang Digunakan</h2>
                                <div class="mt-4 flex flex-wrap gap-2">
                                    @foreach ($portfolio->technologies as $tech)
                                        @continue(!filled($tech))
                                        <span class="rounded-full border border-slate-200/70 bg-white/70 px-3 py-1 text-sm font-semibold text-slate-700 shadow-sm backdrop-blur">
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

