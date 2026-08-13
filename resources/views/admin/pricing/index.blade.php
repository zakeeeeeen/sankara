@extends('layouts.admin')

@section('title', 'Pricing - Admin Sankara Tech')

@section('content')
    <div class="reveal flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="text-3xl font-semibold tracking-tight text-slate-900">Pricing</h1>
            <p class="mt-2 text-base leading-relaxed text-slate-600">Kelola paket harga dan fitur.</p>
        </div>

        <a href="{{ route('admin.pricing.create') }}" class="brand-gradient inline-flex items-center justify-center rounded-2xl px-6 py-3 text-sm font-semibold text-white shadow-[0_18px_50px_-26px_rgba(14,165,233,0.6)] transition hover:-translate-y-0.5">
            Tambah Paket
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
                        <th class="px-6 py-4">Name</th>
                        <th class="px-6 py-4">Tag</th>
                        <th class="px-6 py-4">Price</th>
                        <th class="px-6 py-4">Popular</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200/60">
                    @foreach ($plans as $plan)
                        <tr class="text-slate-800">
                            <td class="px-6 py-4 font-semibold text-slate-900">{{ $plan->name }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $plan->tag }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $plan->price_text }}</td>
                            <td class="px-6 py-4">
                                <span class="rounded-full border px-3 py-1 text-xs font-semibold {{ $plan->is_popular ? 'border-emerald-200/70 bg-emerald-50 text-emerald-700' : 'border-slate-200/70 bg-white text-slate-600' }}">
                                    {{ $plan->is_popular ? 'Yes' : 'No' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.pricing.edit', $plan) }}" class="rounded-xl border border-slate-200/70 bg-white/70 px-4 py-2 text-sm font-semibold text-slate-800 shadow-sm backdrop-blur transition hover:bg-white">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.pricing.destroy', $plan) }}" onsubmit="return confirm('Hapus paket ini?')">
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

