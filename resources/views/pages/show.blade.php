@extends('layouts.marketing')

@section('title', $page->title . ' - Sankara Tech')

@section('content')
    @include('partials.marketing-header', ['active' => 'about'])

    <main class="pt-24">
        <section class="relative overflow-hidden">
            <div class="mx-auto max-w-7xl px-4 pb-14 pt-12 sm:px-6 lg:px-8 lg:pb-20 lg:pt-16">
                <div class="grid gap-10 lg:grid-cols-2 lg:items-start">
                    <div>
                        <div class="reveal">
                            <div class="inline-flex items-center gap-2 rounded-full border border-brand-soft bg-white/70 px-4 py-2 text-xs font-semibold text-slate-700 shadow-sm backdrop-blur">
                                <span class="brand-dot h-1.5 w-1.5 rounded-full"></span>
                                {{ $page->title }}
                            </div>

                            <h1 class="mt-6 text-4xl font-semibold tracking-tight text-slate-900 sm:text-5xl">
                                {{ $page->hero_title ?: $page->title }}
                            </h1>

                            @if ($page->hero_subtitle)
                                <p class="mt-5 max-w-3xl text-base leading-relaxed text-slate-600 sm:text-lg">
                                    {{ $page->hero_subtitle }}
                                </p>
                            @endif
                        </div>

                        @if ($page->body)
                            <div class="mt-10 text-base leading-relaxed text-slate-600 reveal whitespace-pre-line">
                                {{ $page->body }}
                            </div>
                        @endif
                    </div>

                    <div class="reveal">
                        <div class="brand-gradient-br-soft rounded-[2rem] p-px shadow-[0_30px_80px_-55px_rgb(var(--brand-from-rgb)/0.55)]">
                            <div class="overflow-hidden rounded-[2rem] border border-white/60 bg-white/55 backdrop-blur-xl">
                                @if ($page->image_src)
                                    <img class="h-full w-full object-cover" src="{{ $page->image_src }}" alt="{{ $page->title }}" />
                                @else
                                    <div class="h-[340px] w-full"></div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

