@extends('layouts.admin')

@section('title', 'Pesan Kontak - Admin Sankara Tech')

@section('page_title', 'Pesan Kontak')
@section('page_subtitle', 'Lihat pesan yang masuk dari halaman kontak')

@section('content')
    <div class="reveal flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="text-3xl font-semibold tracking-tight text-slate-900">Pesan Kontak</h1>
            <p class="mt-2 text-base leading-relaxed text-slate-600">Daftar pesan dari pengunjung website.</p>
        </div>
    </div>

    @if (session('status'))
        <div class="brand-gradient-soft mt-8 rounded-2xl border border-slate-200/70 px-5 py-4 text-sm font-semibold text-slate-900">
            {{ session('status') }}
        </div>
    @endif

    <div class="mt-10 overflow-hidden rounded-[2rem] border border-slate-200/70 bg-white/70 shadow-sm backdrop-blur">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-slate-200/60 text-xs font-semibold uppercase tracking-wide text-slate-600">
                    <tr>
                        <th class="px-6 py-4">Nama</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Telp</th>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200/60">
                    @forelse ($messages as $row)
                        <tr class="text-slate-800">
                            <td class="px-6 py-4 font-semibold text-slate-900">{{ $row->name }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $row->email }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $row->phone ?: '-' }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $row->created_at }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.contact-messages.show', $row) }}" class="rounded-xl border border-slate-200/70 bg-white/70 px-4 py-2 text-sm font-semibold text-slate-800 shadow-sm backdrop-blur transition hover:bg-white">
                                        Detail
                                    </a>
                                    <form method="POST" action="{{ route('admin.contact-messages.destroy', $row) }}" onsubmit="return confirm('Hapus pesan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-xl border border-rose-200/70 bg-rose-50 px-4 py-2 text-sm font-semibold text-rose-700 transition hover:bg-rose-100">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-6 py-10 text-center text-sm font-semibold text-slate-600" colspan="5">Belum ada pesan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

