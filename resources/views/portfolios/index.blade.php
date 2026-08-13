@extends('layouts.marketing')

@section('title', 'Portofolio - Sankara Tech')

@section('content')
    @include('partials.marketing-header', ['active' => 'portfolios'])

    <main class="pt-24">
        <section class="relative overflow-hidden">
            <div class="mx-auto max-w-7xl px-4 pb-8 pt-12 sm:px-6 lg:px-8 lg:pb-10 lg:pt-16">
                <div class="reveal text-center">
                    <h1 class="mt-3 text-4xl font-semibold tracking-tight text-slate-900 sm:text-5xl">Project yang pernah kami kerjakan</h1>
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

