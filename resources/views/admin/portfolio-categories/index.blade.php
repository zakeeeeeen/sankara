@extends('layouts.admin')

@section('title', 'Kategori Portofolio - Admin Sankara Tech')

@section('content')
    <div class="reveal flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="text-3xl font-semibold tracking-tight text-slate-900">Kategori Portofolio</h1>
            <p class="mt-2 text-base leading-relaxed text-slate-600">Kategori dipakai untuk filter di halaman portofolio.</p>
        </div>

        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-200/70 bg-white/70 px-5 py-2.5 text-sm font-semibold text-slate-800 shadow-sm backdrop-blur transition hover:-translate-y-0.5 hover:bg-white">
            Kembali
        </a>
    </div>

    @if (session('status'))
        <div class="mt-8 rounded-2xl border border-emerald-200/70 bg-gradient-to-r from-emerald-50 to-cyan-50 px-5 py-4 text-sm font-semibold text-emerald-700">
            {{ session('status') }}
        </div>
    @endif

    <div class="mt-10 grid gap-6 lg:grid-cols-3">
        <div class="rounded-[2rem] border border-slate-200/70 bg-white/70 p-6 shadow-sm backdrop-blur sm:p-8">
            <div class="text-lg font-semibold text-slate-900">Tambah Kategori</div>
            <form class="mt-6 space-y-4" method="POST" action="{{ route('admin.portfolio-categories.store') }}">
                @csrf
                <div>
                    <label class="text-sm font-semibold text-slate-800">Name</label>
                    <input name="name" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300" required />
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-800">Slug (optional)</label>
                    <input name="slug" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300" />
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-800">Sort Order</label>
                    <input type="number" name="sort_order" value="0" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300" />
                </div>
                <button type="submit" class="brand-gradient w-full rounded-2xl px-6 py-3 text-sm font-semibold text-white shadow-[0_18px_50px_-26px_rgba(14,165,233,0.6)] transition hover:-translate-y-0.5">
                    Simpan
                </button>
            </form>
        </div>

        <div class="rounded-[2rem] border border-slate-200/70 bg-white/70 p-6 shadow-sm backdrop-blur sm:p-8 lg:col-span-2">
            <div class="text-lg font-semibold text-slate-900">Daftar Kategori</div>
            <div class="mt-6 space-y-3">
                @foreach ($categories as $cat)
                    <div class="rounded-2xl border border-slate-200/70 bg-white/60 p-4 shadow-sm backdrop-blur">
                        <div class="grid gap-3 sm:grid-cols-[1fr_1fr_120px_auto_auto]">
                            <form method="POST" action="{{ route('admin.portfolio-categories.update', $cat) }}" class="contents">
                                @csrf
                                @method('PUT')
                                <input name="name" value="{{ $cat->name }}" class="w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300" />
                                <input name="slug" value="{{ $cat->slug }}" class="w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300" />
                                <input type="number" name="sort_order" value="{{ $cat->sort_order }}" class="w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300" />
                                <button type="submit" class="h-11 rounded-2xl border border-slate-200/70 bg-white/70 px-4 text-sm font-semibold text-slate-800 shadow-sm backdrop-blur transition hover:bg-white">
                                    Update
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.portfolio-categories.destroy', $cat) }}" onsubmit="return confirm('Hapus kategori ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="h-11 w-full rounded-2xl border border-rose-200/70 bg-rose-50 px-4 text-sm font-semibold text-rose-700 transition hover:bg-rose-100">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

