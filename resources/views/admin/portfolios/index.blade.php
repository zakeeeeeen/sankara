@extends('layouts.admin')

@section('title', 'Portofolio - Admin Sankara Tech')

@section('content')
    <div class="reveal flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="text-3xl font-semibold tracking-tight text-slate-900">Portofolio</h1>
            <p class="mt-2 text-base leading-relaxed text-slate-600">Kelola project, kategori, dan section detail.</p>
        </div>

        <a href="{{ route('admin.portfolios.create') }}" class="brand-gradient inline-flex items-center justify-center rounded-2xl px-6 py-3 text-sm font-semibold text-white shadow-[0_18px_50px_-26px_rgba(14,165,233,0.6)] transition hover:-translate-y-0.5">
            Tambah Portofolio
        </a>
    </div>

    @if (session('status'))
        <div class="mt-8 rounded-2xl border border-emerald-200/70 bg-gradient-to-r from-emerald-50 to-cyan-50 px-5 py-4 text-sm font-semibold text-emerald-700">
            {{ session('status') }}
        </div>
    @endif

    <div class="mt-10 overflow-hidden rounded-[2rem] border border-slate-200/70 bg-white/70 shadow-sm backdrop-blur">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-slate-200/60 text-xs font-semibold uppercase tracking-wide text-slate-600">
                    <tr>
                        <th class="px-6 py-4">Title</th>
                        <th class="px-6 py-4">Slug</th>
                        <th class="px-6 py-4">Published</th>
                        <th class="px-6 py-4">Active</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200/60">
                    @foreach ($portfolios as $p)
                        <tr class="text-slate-800">
                            <td class="px-6 py-4 font-semibold text-slate-900">{{ $p->title }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $p->slug }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $p->published_at?->format('Y-m-d') }}</td>
                            <td class="px-6 py-4">
                                <span class="rounded-full border px-3 py-1 text-xs font-semibold {{ $p->is_active ? 'border-emerald-200/70 bg-emerald-50 text-emerald-700' : 'border-slate-200/70 bg-white text-slate-600' }}">
                                    {{ $p->is_active ? 'Yes' : 'No' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.portfolios.edit', $p) }}" class="rounded-xl border border-slate-200/70 bg-white/70 px-4 py-2 text-sm font-semibold text-slate-800 shadow-sm backdrop-blur transition hover:bg-white">
                                        Edit
                                    </a>
                                    <a href="{{ route('portfolios.show', $p->slug) }}" target="_blank" rel="noreferrer" class="rounded-xl border border-slate-200/70 bg-white/70 px-4 py-2 text-sm font-semibold text-slate-800 shadow-sm backdrop-blur transition hover:bg-white">
                                        Lihat
                                    </a>
                                    <form method="POST" action="{{ route('admin.portfolios.destroy', $p) }}" onsubmit="return confirm('Hapus portofolio ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-xl border border-rose-200/70 bg-rose-50 px-4 py-2 text-sm font-semibold text-rose-700 transition hover:bg-rose-100">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

