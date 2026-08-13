@extends('layouts.marketing')

@section('title', 'Portofolio - Sankara Tech')

@section('content')
    @include('partials.marketing-header', ['active' => 'portfolios'])

    <main class="pt-28 pb-20 bg-white">
        <section class="relative overflow-hidden">
            <div class="mx-auto max-w-7xl px-4 pb-8 pt-4 sm:px-6 lg:px-8">
                <div class="reveal text-center flex flex-col items-center">
                    <div class="agency-divider mx-auto"></div>
                    <h1 class="mt-4 text-4xl font-bold tracking-tight text-[rgb(var(--agency-navy-1))] sm:text-5xl">Project yang Pernah Kami Kerjakan</h1>
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

