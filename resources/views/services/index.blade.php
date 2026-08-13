@extends('layouts.marketing')

@section('title', 'Layanan - Sankara Tech')

@section('content')
    @include('partials.marketing-header', ['active' => 'services'])

    <main class="pt-24">
        <section class="relative overflow-hidden">
            <div class="mx-auto max-w-7xl px-4 pb-10 pt-12 sm:px-6 lg:px-8 lg:pb-14 lg:pt-16">
                <div class="reveal">
                    <p class="text-sm font-semibold text-brand">Layanan</p>
                    <h1 class="mt-3 text-4xl font-semibold tracking-tight text-slate-900 sm:text-5xl">Solusi digital end-to-end untuk bisnis modern</h1>
                    <p class="mt-5 max-w-3xl text-base leading-relaxed text-slate-600 sm:text-lg">
                        Setiap layanan kami dirancang dengan pendekatan modern, performa cepat, dan UX yang rapi. Klik detail untuk melihat cakupan dan deliverables.
                    </p>
                </div>
            </div>
        </section>

        <section class="pb-16 sm:pb-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid gap-6 md:grid-cols-2">
                    @foreach ($services as $service)
                        <div class="reveal overflow-hidden rounded-[2rem] border border-slate-200/70 bg-white/70 shadow-sm backdrop-blur transition hover:-translate-y-1 hover:bg-white">
                            <div class="grid gap-0 sm:grid-cols-[220px_1fr]">
                                <div class="relative">
                                    <div class="brand-gradient-br-soft absolute inset-0"></div>
                                    @if ($service->image_src)
                                        <img class="relative h-full w-full object-cover" src="{{ $service->image_src }}" alt="{{ $service->title }}" />
                                    @else
                                        <div class="relative h-full min-h-[180px]"></div>
                                    @endif
                                </div>

                                <div class="p-6 sm:p-8">
                                    <h3 class="text-xl font-semibold text-slate-900">{{ $service->title }}</h3>
                                    <p class="mt-3 text-sm leading-relaxed text-slate-600">
                                        {{ $service->description ?: $service->excerpt }}
                                    </p>
                                    <div class="mt-6">
                                        <a
                                            href="{{ route('services.show', $service->slug) }}"
                                            class="brand-gradient inline-flex items-center gap-2 rounded-2xl px-5 py-2.5 text-sm font-semibold text-white shadow-[0_16px_45px_-24px_rgb(var(--brand-to-rgb)/0.55)] transition hover:-translate-y-0.5"
                                        >
                                            {{ $service->cta_label ?: 'Lihat Selengkapnya' }}
                                            <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5">
                                                <path d="M5 12h12" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                                <path d="M13 6l6 6-6 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </a>
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

