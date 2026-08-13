@extends('layouts.marketing')

@section('title', 'Layanan - Sankara Tech')

@section('content')
    @include('partials.marketing-header', ['active' => 'services'])

    <main class="pt-28 pb-20 bg-slate-50">
        <section class="relative overflow-hidden">
            <div class="mx-auto max-w-7xl px-4 pb-10 pt-4 sm:px-6 lg:px-8 lg:pb-14">
                <div class="reveal">
                    <div class="agency-divider"></div>
                    <h1 class="mt-4 text-4xl font-bold tracking-tight text-[rgb(var(--agency-navy-1))] sm:text-5xl">Solusi Digital End-to-End untuk Bisnis Modern</h1>
                    <p class="mt-4 max-w-3xl text-base leading-relaxed text-slate-600 sm:text-lg">
                        Setiap layanan kami dirancang dengan pendekatan modern, performa cepat, dan UX yang rapi untuk mendukung pertumbuhan bisnis Anda.
                    </p>
                </div>
            </div>
        </section>

        <section class="pb-16 sm:pb-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid gap-8 md:grid-cols-2">
                    @foreach ($services as $service)
                        <div class="reveal">
                            <div class="agency-service-card flex h-full flex-col p-8">
                                <div class="grid gap-6 sm:grid-cols-[180px_1fr] sm:items-center">
                                    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-sky-50 to-cyan-50 border border-sky-100 p-2">
                                        @if ($service->image_src)
                                            <img class="h-36 w-full rounded-xl object-cover" src="{{ $service->image_src }}" alt="{{ $service->title }}" />
                                        @else
                                            <div class="flex h-36 w-full items-center justify-center rounded-xl bg-[linear-gradient(135deg,rgb(var(--agency-navy-1)),rgb(var(--agency-navy-2)))] p-4 text-center text-xs font-bold text-white">
                                                {{ $service->title }}
                                            </div>
                                        @endif
                                    </div>

                                    <div>
                                        <h3 class="text-xl font-bold text-[rgb(var(--agency-navy-1))]">{{ $service->title }}</h3>
                                        <p class="mt-2 text-sm leading-relaxed text-slate-500 line-clamp-3">
                                            {{ $service->description ?: $service->excerpt }}
                                        </p>
                                        <div class="mt-5">
                                            <a
                                                href="{{ route('services.show', $service->slug) }}"
                                                class="agency-btn-primary inline-flex items-center gap-2 px-5 py-2.5 text-xs font-semibold"
                                            >
                                                {{ $service->cta_label ?: 'Lihat Selengkapnya' }}
                                                <svg viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                                                    <path d="M5 12h12" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                                    <path d="M13 6l6 6-6 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </main>
@endsection

