@extends('layouts.marketing')

@section('title', 'Kontak - Sankara Tech')

@section('content')
    @php
        $contact = is_array($contact ?? null) ? $contact : [];
        $publicEmail = $contact['email'] ?? ($contact['inbox_email'] ?? '');
        $publicWhatsapp = $contact['whatsapp'] ?? '';
        $publicAddress = $contact['address'] ?? '';
        $publicHours = $contact['hours'] ?? '';
        $mapEmbedUrl = $contact['map_embed_url'] ?? '';
        $waLink = session('wa_link');
    @endphp

    @include('partials.marketing-header', ['active' => 'contact'])

    <main class="pt-24">
        <section class="relative overflow-hidden">
            <div class="mx-auto max-w-7xl px-4 pb-12 pt-12 sm:px-6 lg:px-8 lg:pb-16 lg:pt-16">
                <div class="grid gap-10 lg:grid-cols-[1fr_1.2fr] lg:items-start">
                    <div class="reveal">
                        <p class="text-sm font-semibold text-slate-700">Kontak</p>
                        <h1 class="mt-3 text-4xl font-semibold tracking-tight text-slate-900 sm:text-5xl">Kontak Informasi</h1>
                        <p class="mt-5 max-w-xl text-base leading-relaxed text-slate-600 sm:text-lg">
                            Kami siap membantu mewujudkan ide digital Anda. Hubungi tim kami untuk diskusi, konsultasi, atau mendapatkan solusi terbaik untuk proyek Anda.
                        </p>
                    <div class="mt-7 flex flex-col gap-3 sm:flex-row sm:items-center">
                        <a href="#form" class="brand-gradient shadow-brand-cta inline-flex items-center justify-center rounded-2xl px-6 py-3 text-sm font-semibold text-white transition hover:-translate-y-0.5">
                            Kirim Pesan
                        </a>
                        <a href="{{ route('home') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-200/70 bg-white/70 px-6 py-3 text-sm font-semibold text-slate-800 shadow-sm backdrop-blur transition hover:-translate-y-0.5 hover:bg-white">
                            Kembali
                        </a>
                    </div>

                        <div class="mt-10 grid gap-4 rounded-3xl border border-slate-200/70 bg-white/70 p-6 shadow-sm backdrop-blur">
                            <div class="flex items-start gap-4">
                                <div class="grid h-11 w-11 place-items-center rounded-2xl bg-slate-900 text-white">
                                    <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5">
                                        <path d="M12 21s7-5.5 7-11a7 7 0 1 0-14 0c0 5.5 7 11 7 11Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M12 10.5a2.2 2.2 0 1 0 0-4.4 2.2 2.2 0 0 0 0 4.4Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <div class="text-sm font-semibold text-slate-900">Address</div>
                                    <div class="mt-1 text-sm leading-relaxed text-slate-600">{{ $publicAddress ?: '-' }}</div>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div class="grid h-11 w-11 place-items-center rounded-2xl bg-slate-900 text-white">
                                    <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5">
                                        <path d="M4 6.5l8 6 8-6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M5 7h14v10H5V7Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <div class="text-sm font-semibold text-slate-900">Email</div>
                                    <div class="mt-1 text-sm leading-relaxed text-slate-600 break-all">{{ $publicEmail ?: '-' }}</div>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div class="grid h-11 w-11 place-items-center rounded-2xl bg-slate-900 text-white">
                                    <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5">
                                        <path d="M6 3h4l2 5-2.5 1.5a16 16 0 0 0 7 7L18 15l5 2v4c0 1.1-.9 2-2 2C10.4 23 1 13.6 1 3c0-1.1.9-2 2-2h3Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <div class="text-sm font-semibold text-slate-900">Phone Number</div>
                                    <div class="mt-1 text-sm leading-relaxed text-slate-600">{{ $publicWhatsapp ?: '-' }}</div>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div class="grid h-11 w-11 place-items-center rounded-2xl bg-slate-900 text-white">
                                    <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5">
                                        <path d="M12 8v4l2.5 2.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <div class="text-sm font-semibold text-slate-900">Operating Hours</div>
                                    <div class="mt-1 text-sm leading-relaxed text-slate-600">{{ $publicHours ?: '-' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="form" class="reveal scroll-mt-28">
                        @if (session('status'))
                            <div class="brand-gradient-soft mb-6 rounded-3xl border border-slate-200/70 px-5 py-4 text-sm font-semibold text-slate-900">
                                <div>{{ session('status') }}</div>
                                @if ($waLink)
                                    <div class="mt-3">
                                        <a href="{{ $waLink }}" target="_blank" rel="noreferrer" class="brand-gradient shadow-brand-cta inline-flex items-center justify-center rounded-2xl px-5 py-2.5 text-sm font-semibold text-white transition hover:-translate-y-0.5">
                                            Lanjut via WhatsApp
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @endif

                        <div class="rounded-3xl border border-slate-200/70 bg-white/70 p-6 shadow-sm backdrop-blur sm:p-8">
                            <form method="POST" action="{{ route('contact.store') }}" class="grid gap-4">
                                @csrf

                                <div>
                                    <label class="text-sm font-semibold text-slate-800">Nama Lengkap</label>
                                    <input name="name" value="{{ old('name') }}" placeholder="Masukkan Nama Lengkap" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/80 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm outline-none focus:border-[rgb(var(--brand-from-rgb)/0.55)]" required />
                                    @error('name') <div class="mt-2 text-sm font-semibold text-rose-600">{{ $message }}</div> @enderror
                                </div>

                                <div>
                                    <label class="text-sm font-semibold text-slate-800">Email</label>
                                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Masukkan Email" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/80 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm outline-none focus:border-[rgb(var(--brand-from-rgb)/0.55)]" required />
                                    @error('email') <div class="mt-2 text-sm font-semibold text-rose-600">{{ $message }}</div> @enderror
                                </div>

                                <div>
                                    <label class="text-sm font-semibold text-slate-800">No. Telp</label>
                                    <input name="phone" value="{{ old('phone') }}" placeholder="Masukkan No. Telp" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/80 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm outline-none focus:border-[rgb(var(--brand-from-rgb)/0.55)]" />
                                    @error('phone') <div class="mt-2 text-sm font-semibold text-rose-600">{{ $message }}</div> @enderror
                                </div>

                                <div>
                                    <label class="text-sm font-semibold text-slate-800">Pesan</label>
                                    <textarea name="message" rows="5" placeholder="Tulis Pesan Anda" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/80 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm outline-none focus:border-[rgb(var(--brand-from-rgb)/0.55)]" required>{{ old('message') }}</textarea>
                                    @error('message') <div class="mt-2 text-sm font-semibold text-rose-600">{{ $message }}</div> @enderror
                                </div>

                                <div class="pt-2">
                                    <button type="submit" class="brand-gradient shadow-brand-cta inline-flex items-center justify-center rounded-2xl px-6 py-3 text-sm font-semibold text-white transition hover:-translate-y-0.5">
                                        Kirim Pesan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="mt-12 overflow-hidden rounded-3xl border border-slate-200/70 bg-white/70 shadow-sm backdrop-blur reveal">
                    @if (filled($mapEmbedUrl))
                        <iframe
                            src="{{ $mapEmbedUrl }}"
                            width="100%"
                            height="420"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                        ></iframe>
                    @else
                        <div class="grid h-[420px] place-items-center text-sm font-semibold text-slate-600">Map belum diatur.</div>
                    @endif
                </div>
            </div>
        </section>
    </main>
@endsection
