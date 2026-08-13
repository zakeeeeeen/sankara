@extends('layouts.admin')

@section('title', 'Detail Pesan - Admin Sankara Tech')

@section('page_title', 'Detail Pesan')
@section('page_subtitle', 'Periksa pesan masuk dari pengunjung')

@section('content')
    <div class="reveal flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-semibold tracking-tight text-slate-900">{{ $message->name }}</h1>
            <p class="mt-2 text-base leading-relaxed text-slate-600">{{ $message->created_at }}</p>
        </div>

        <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
            <a href="{{ route('admin.contact-messages.index') }}" class="rounded-2xl border border-slate-200/70 bg-white/70 px-5 py-2.5 text-sm font-semibold text-slate-800 shadow-sm backdrop-blur transition hover:-translate-y-0.5 hover:bg-white">
                Kembali
            </a>
            <form method="POST" action="{{ route('admin.contact-messages.destroy', $message) }}" onsubmit="return confirm('Hapus pesan ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="rounded-2xl border border-rose-200/70 bg-rose-50 px-5 py-2.5 text-sm font-semibold text-rose-700 transition hover:-translate-y-0.5 hover:bg-rose-100">
                    Hapus
                </button>
            </form>
        </div>
    </div>

    <div class="mt-10 grid gap-6 lg:grid-cols-2">
        <div class="reveal rounded-[2rem] border border-slate-200/70 bg-white/70 p-6 shadow-sm backdrop-blur">
            <div class="text-sm font-semibold text-slate-900">Kontak</div>
            <dl class="mt-5 grid gap-4 text-sm text-slate-700">
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Email</dt>
                    <dd class="mt-1 break-all font-semibold text-slate-900">{{ $message->email }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">No. Telp</dt>
                    <dd class="mt-1 font-semibold text-slate-900">{{ $message->phone ?: '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">IP</dt>
                    <dd class="mt-1 font-semibold text-slate-900">{{ $message->ip_address ?: '-' }}</dd>
                </div>
            </dl>
        </div>

        <div class="reveal rounded-[2rem] border border-slate-200/70 bg-white/70 p-6 shadow-sm backdrop-blur">
            <div class="text-sm font-semibold text-slate-900">Pesan</div>
            <div class="mt-5 whitespace-pre-line text-sm leading-relaxed text-slate-700">{{ $message->message }}</div>
        </div>
    </div>

    @if ($message->user_agent)
        <div class="reveal mt-6 rounded-[2rem] border border-slate-200/70 bg-white/70 p-6 shadow-sm backdrop-blur">
            <div class="text-sm font-semibold text-slate-900">User Agent</div>
            <div class="mt-4 break-words text-sm text-slate-600">{{ $message->user_agent }}</div>
        </div>
    @endif
@endsection

