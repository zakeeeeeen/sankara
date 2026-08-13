@extends('layouts.marketing')

@section('title', $title . ' — Portofolio')

@section('content')
    @include('partials.marketing-header', ['active' => 'portfolios'])

    <div class="mx-auto max-w-7xl px-4 pb-16 pt-24 sm:px-6 lg:px-8 lg:pb-24">
        <div class="reveal">
            <a href="/#portofolio" class="inline-flex items-center gap-2 rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-2 text-sm font-semibold text-slate-800 shadow-sm backdrop-blur transition hover:bg-white">
                <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5">
                    <path d="M19 12H7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                    <path d="M11 6l-6 6 6 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Kembali ke landing
            </a>

            <h1 class="mt-6 text-3xl font-semibold tracking-tight text-slate-900 sm:text-4xl">{{ $title }}</h1>
            <p class="mt-3 max-w-3xl text-base leading-relaxed text-slate-600">
                Detail portofolio untuk project ini. Kamu bisa isi deskripsi, scope, dan teknologi yang dipakai sesuai kebutuhan.
            </p>
        </div>

        <div class="brand-gradient-br mt-10 reveal rounded-[2rem] p-px shadow-[0_30px_80px_-55px_rgb(var(--brand-to-rgb)/0.55)]">
            <div class="overflow-hidden rounded-[2rem] border border-white/60 bg-white/60 backdrop-blur-xl">
                <img class="w-full" src="{{ $image }}" alt="Screenshot {{ $title }}" />
            </div>
        </div>

        <div class="mt-12 grid gap-4 lg:grid-cols-3">
            <div class="reveal rounded-3xl border border-slate-200/70 bg-white/65 p-7 shadow-sm backdrop-blur transition hover:bg-white">
                <div class="text-sm font-semibold text-slate-900">Tujuan</div>
                <div class="mt-2 text-sm leading-relaxed text-slate-600">Jelaskan objektif utama project dan metrik keberhasilannya.</div>
            </div>
            <div class="reveal rounded-3xl border border-slate-200/70 bg-white/65 p-7 shadow-sm backdrop-blur transition hover:bg-white">
                <div class="text-sm font-semibold text-slate-900">Deliverables</div>
                <div class="mt-2 text-sm leading-relaxed text-slate-600">UI/UX, implementasi, responsif, optimasi, dan dokumentasi.</div>
            </div>
            <div class="reveal rounded-3xl border border-slate-200/70 bg-white/65 p-7 shadow-sm backdrop-blur transition hover:bg-white">
                <div class="text-sm font-semibold text-slate-900">Teknologi</div>
                <div class="mt-2 text-sm leading-relaxed text-slate-600">Laravel, Tailwind, dan integrasi kebutuhan bisnis.</div>
            </div>
        </div>
    </div>
@endsection
