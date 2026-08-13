@extends('layouts.admin')

@section('title', 'Tentang Kami - Admin Sankara Tech')

@section('content')
    <div class="reveal flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="text-3xl font-semibold tracking-tight text-slate-900">Halaman Tentang Kami</h1>
            <p class="mt-2 text-base leading-relaxed text-slate-600">Konten ini tampil di halaman /tentang-kami.</p>
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

    <form class="mt-10 space-y-10" method="POST" action="{{ route('admin.pages.about.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="rounded-[2rem] border border-slate-200/70 bg-white/70 p-6 shadow-sm backdrop-blur sm:p-8">
            <div class="grid gap-5 lg:grid-cols-2">
                <div>
                    <label class="text-sm font-semibold text-slate-800">Title</label>
                    <input name="title" value="{{ old('title', $page->title) }}" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300" required />
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-800">Hero Title</label>
                    <input name="hero_title" value="{{ old('hero_title', $page->hero_title) }}" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300" />
                </div>
                <div class="lg:col-span-2">
                    <label class="text-sm font-semibold text-slate-800">Hero Subtitle</label>
                    <textarea name="hero_subtitle" rows="3" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300">{{ old('hero_subtitle', $page->hero_subtitle) }}</textarea>
                </div>
                <div class="lg:col-span-2">
                    <label class="text-sm font-semibold text-slate-800">Body</label>
                    <textarea name="body" rows="8" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300">{{ old('body', $page->body) }}</textarea>
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-800">Image URL (optional)</label>
                    <input name="image_url" value="{{ old('image_url', $page->image_url) }}" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300" />
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-800">Upload Image (optional)</label>
                    <input type="file" name="image" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur" />
                    @if ($page->image_src)
                        <div class="mt-3 text-xs font-semibold text-slate-600">Current: {{ $page->image_src }}</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3">
            <button type="submit" class="brand-gradient rounded-2xl px-6 py-3 text-sm font-semibold text-white shadow-[0_18px_50px_-26px_rgba(14,165,233,0.6)] transition hover:-translate-y-0.5">
                Simpan
            </button>
        </div>
    </form>
@endsection

