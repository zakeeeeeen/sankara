@extends('layouts.admin')

@section('title', 'Login Admin - Sankara Tech')

@section('content')
    <div class="mx-auto max-w-md">
        <div class="reveal rounded-[2rem] border border-slate-200/70 bg-white/70 p-8 shadow-sm backdrop-blur">
            <h1 class="text-2xl font-semibold tracking-tight text-slate-900">Login Admin</h1>
            <p class="mt-2 text-sm leading-relaxed text-slate-600">
                Gunakan akun admin untuk mengatur semua konten website.
            </p>

            <form class="mt-8 space-y-4" method="POST" action="{{ route('admin.login.store') }}">
                @csrf

                <div>
                    <label class="text-sm font-semibold text-slate-800" for="email">Email</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none transition focus:border-emerald-300"
                        required
                        autofocus
                    />
                    @error('email')
                        <div class="mt-2 text-sm font-semibold text-rose-600">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label class="text-sm font-semibold text-slate-800" for="password">Password</label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none transition focus:border-emerald-300"
                        required
                    />
                    @error('password')
                        <div class="mt-2 text-sm font-semibold text-rose-600">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="brand-gradient w-full rounded-2xl px-6 py-3 text-sm font-semibold text-white shadow-[0_18px_50px_-26px_rgba(14,165,233,0.6)] transition hover:-translate-y-0.5">
                    Masuk
                </button>

                <div class="mt-4 rounded-2xl border border-emerald-200/70 bg-gradient-to-r from-emerald-50 to-cyan-50 px-4 py-3 text-xs font-semibold text-emerald-700">
                    Default admin: admin@sankaratech.test / password
                </div>
            </form>
        </div>
    </div>
@endsection

