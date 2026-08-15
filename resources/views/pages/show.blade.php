@extends('layouts.marketing')

@section('title', $page->title . ' - Sankara Tech')
@section('meta_description', $page->hero_subtitle ?: \Illuminate\Support\Str::limit(strip_tags($page->body), 155))
@if ($page->image_src)
    @section('meta_image', $page->image_src)
@endif

@section('structured_data')
    {{ app(\App\Services\SeoService::class)->renderStructuredData([
        'breadcrumb' => [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => $page->title, 'url' => route('about')],
        ],
    ]) }}
@endsection

@section('content')
    @include('partials.marketing-header', ['active' => 'about'])

    <main class="pt-28 pb-20 bg-white">
        <section class="relative overflow-hidden">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid gap-12 lg:grid-cols-2 lg:items-start">
                    <div>
                        <div class="reveal">
                            <div class="agency-divider"></div>

                            <h1 class="mt-4 text-4xl font-bold tracking-tight text-slate-900 sm:text-5xl">
                                {{ $page->hero_title ?: $page->title }}
                            </h1>

                            @if ($page->hero_subtitle)
                                <p class="mt-4 max-w-3xl text-base leading-relaxed text-slate-600 sm:text-lg">
                                    {{ $page->hero_subtitle }}
                                </p>
                            @endif
                        </div>

                        @if ($page->body)
                            <div class="mt-8 text-base leading-relaxed text-slate-600 reveal whitespace-pre-line">
                                {{ $page->body }}
                            </div>
                        @endif

                        <div class="mt-8">
                            <a href="{{ route('contact.show') }}" class="agency-btn-primary inline-flex items-center justify-center gap-2 px-8 py-3.5 text-sm font-semibold">
                                <span>Konsultasi dengan Kami</span>
                                <i class="fa-solid fa-arrow-right text-xs" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>

                    <div class="reveal">
                        <div class="agency-card overflow-hidden p-2">
                            @if ($page->image_src)
                                <img class="h-full w-full rounded-2xl object-cover" width="600" height="400" fetchpriority="high" src="{{ $page->image_src }}" alt="{{ $page->title }}" />
                            @else
                                <div class="h-[340px] w-full rounded-2xl bg-[linear-gradient(135deg,rgb(var(--agency-navy-1)),rgb(var(--agency-navy-2)))] flex items-center justify-center p-8 text-center text-white">
                                    <div class="text-xl font-bold">Sankara Tech Digital Agency</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
