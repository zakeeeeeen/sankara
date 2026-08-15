@extends('layouts.marketing')

@section('title', 'Portofolio Project & Karya - Sankara Tech')
@section('meta_description', 'Jelajahi portofolio project terbaik Sankara Tech dalam pembuatan website, mobile app, software bisnis, game, UI/UX, dan desain 3D.')

@section('structured_data')
    {{ app(\App\Services\SeoService::class)->renderStructuredData([
        'breadcrumb' => [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Portofolio', 'url' => route('portfolios.index')],
        ],
    ]) }}
@endsection

@section('content')
    @include('partials.marketing-header', ['active' => 'portfolios'])

    <main class="pt-28 pb-20 bg-white">
        <section class="relative overflow-hidden">
            <div class="mx-auto max-w-7xl px-4 pb-8 pt-4 sm:px-6 lg:px-8">
                <div class="reveal text-center flex flex-col items-center">
                    <div class="agency-divider mx-auto"></div>
                    <h1 class="mt-4 text-4xl font-bold tracking-tight text-[rgb(var(--agency-navy-1))] sm:text-5xl">Project yang Pernah Kami Kerjakan</h1>
                    <p class="mt-3 max-w-2xl text-base font-medium text-slate-600 sm:text-lg">
                        Eksplorasi portfolio dan studi kasus hasil karya terbaik bersama mitra kami.
                    </p>
                </div>
            </div>
        </section>

        <section class="pb-16 sm:pb-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <livewire:portfolio-browser />
            </div>
        </section>
    </main>
@endsection
