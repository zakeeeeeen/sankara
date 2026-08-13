@extends('layouts.admin')

@section('title', 'Dashboard Admin - Sankara Tech')

@section('content')
    <div class="reveal">
        <h1 class="text-3xl font-semibold tracking-tight text-slate-900">Dashboard</h1>
        <p class="mt-2 max-w-2xl text-base leading-relaxed text-slate-600">
            Kelola konten landing page, halaman Tentang Kami, Layanan, Portofolio, kategori, dan pricing dari sini.
        </p>
    </div>

    <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <a href="{{ route('admin.home.edit') }}" class="reveal rounded-[2rem] border border-slate-200/70 bg-white/70 p-6 shadow-sm backdrop-blur transition hover:-translate-y-1 hover:bg-white">
            <div class="text-sm font-semibold text-emerald-700">Landing</div>
            <div class="mt-2 text-lg font-semibold text-slate-900">Home Settings</div>
            <div class="mt-2 text-sm text-slate-600">Hero, stats, about, keunggulan, CTA, kontak.</div>
        </a>
        <a href="{{ route('admin.pages.about.edit') }}" class="reveal rounded-[2rem] border border-slate-200/70 bg-white/70 p-6 shadow-sm backdrop-blur transition hover:-translate-y-1 hover:bg-white">
            <div class="text-sm font-semibold text-emerald-700">Halaman</div>
            <div class="mt-2 text-lg font-semibold text-slate-900">Tentang Kami</div>
            <div class="mt-2 text-sm text-slate-600">Judul, subjudul, dan isi halaman.</div>
        </a>
        <a href="{{ route('admin.services.index') }}" class="reveal rounded-[2rem] border border-slate-200/70 bg-white/70 p-6 shadow-sm backdrop-blur transition hover:-translate-y-1 hover:bg-white">
            <div class="text-sm font-semibold text-emerald-700">Layanan</div>
            <div class="mt-2 text-lg font-semibold text-slate-900">CRUD Layanan</div>
            <div class="mt-2 text-sm text-slate-600">Kartu layanan + detail + gambar.</div>
        </a>
        <a href="{{ route('admin.portfolios.index') }}" class="reveal rounded-[2rem] border border-slate-200/70 bg-white/70 p-6 shadow-sm backdrop-blur transition hover:-translate-y-1 hover:bg-white">
            <div class="text-sm font-semibold text-emerald-700">Portofolio</div>
            <div class="mt-2 text-lg font-semibold text-slate-900">CRUD Portofolio</div>
            <div class="mt-2 text-sm text-slate-600">Project + kategori + section detail.</div>
        </a>
        <a href="{{ route('admin.pricing.index') }}" class="reveal rounded-[2rem] border border-slate-200/70 bg-white/70 p-6 shadow-sm backdrop-blur transition hover:-translate-y-1 hover:bg-white">
            <div class="text-sm font-semibold text-emerald-700">Pricing</div>
            <div class="mt-2 text-lg font-semibold text-slate-900">Paket Harga</div>
            <div class="mt-2 text-sm text-slate-600">Paket + fitur + highlight populer.</div>
        </a>
        <a href="{{ route('admin.portfolio-categories.index') }}" class="reveal rounded-[2rem] border border-slate-200/70 bg-white/70 p-6 shadow-sm backdrop-blur transition hover:-translate-y-1 hover:bg-white">
            <div class="text-sm font-semibold text-emerald-700">Portofolio</div>
            <div class="mt-2 text-lg font-semibold text-slate-900">Kategori</div>
            <div class="mt-2 text-sm text-slate-600">Filter kategori untuk halaman portofolio.</div>
        </a>
    </div>
@endsection

