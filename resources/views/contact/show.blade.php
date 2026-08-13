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

    <main class="pt-28 pb-20 bg-white">
        <section class="relative overflow-hidden">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid gap-12 lg:grid-cols-[1fr_1.2fr] lg:items-start">
                    <div class="reveal">
                        <div class="agency-divider"></div>
                        <h1 class="mt-4 text-4xl font-bold tracking-tight text-slate-900 sm:text-5xl">Hubungi Tim Kami</h1>
                        <p class="mt-4 max-w-xl text-base leading-relaxed text-slate-600 sm:text-lg">
                            Kami siap membantu mewujudkan ide digital Anda. Hubungi tim kami untuk diskusi, konsultasi, atau penawaran proyek terbaik.
                        </p>

                        <div class="mt-8 grid gap-4">
                            <div class="agency-card flex items-start gap-4 p-5">
                                <div class="grid h-11 w-11 flex-none place-items-center rounded-2xl border border-sky-100 bg-[rgb(var(--agency-cyan)/0.12)] text-[rgb(var(--agency-cyan))]">
                                    <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5">
                                        <path d="M12 21s7-5.5 7-11a7 7 0 1 0-14 0c0 5.5 7 11 7 11Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M12 10.5a2.2 2.2 0 1 0 0-4.4 2.2 2.2 0 0 0 0 4.4Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <div class="text-sm font-bold text-[rgb(var(--agency-navy-1))]">Alamat</div>
                                    <div class="mt-1 text-sm leading-relaxed text-slate-600">{{ $publicAddress ?: '-' }}</div>
                                </div>
                            </div>

                            <div class="agency-card flex items-start gap-4 p-5">
                                <div class="grid h-11 w-11 flex-none place-items-center rounded-2xl border border-sky-100 bg-[rgb(var(--agency-cyan)/0.12)] text-[rgb(var(--agency-cyan))]">
                                    <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5">
                                        <path d="M4 6.5l8 6 8-6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M5 7h14v10H5V7Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <div class="text-sm font-bold text-[rgb(var(--agency-navy-1))]">Email</div>
                                    <div class="mt-1 text-sm leading-relaxed text-slate-600 break-all">{{ $publicEmail ?: '-' }}</div>
                                </div>
                            </div>

                            <div class="agency-card flex items-start gap-4 p-5">
                                <div class="grid h-11 w-11 flex-none place-items-center rounded-2xl border border-sky-100 bg-[rgb(var(--agency-cyan)/0.12)] text-[rgb(var(--agency-cyan))]">
                                    <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5">
                                        <path d="M6 3h4l2 5-2.5 1.5a16 16 0 0 0 7 7L18 15l5 2v4c0 1.1-.9 2-2 2C10.4 23 1 13.6 1 3c0-1.1.9-2 2-2h3Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <div class="text-sm font-bold text-[rgb(var(--agency-navy-1))]">WhatsApp / Telepon</div>
                                    <div class="mt-1 text-sm leading-relaxed text-slate-600">{{ $publicWhatsapp ?: '-' }}</div>
                                </div>
                            </div>

                            <div class="agency-card flex items-start gap-4 p-5">
                                <div class="grid h-11 w-11 flex-none place-items-center rounded-2xl border border-sky-100 bg-[rgb(var(--agency-cyan)/0.12)] text-[rgb(var(--agency-cyan))]">
                                    <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5">
                                        <path d="M12 8v4l2.5 2.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <div class="text-sm font-bold text-[rgb(var(--agency-navy-1))]">Jam Operasional</div>
                                    <div class="mt-1 text-sm leading-relaxed text-slate-600">{{ $publicHours ?: '-' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="form" class="reveal scroll-mt-28">
                        @if (session('status'))
                            <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 p-5 text-sm font-semibold text-emerald-900">
                                <div>{{ session('status') }}</div>
                                @if ($waLink)
                                    <div class="mt-3">
                                        <a href="{{ $waLink }}" target="_blank" rel="noreferrer" class="agency-btn-primary inline-flex items-center justify-center px-5 py-2 text-xs font-semibold">
                                            Lanjut via WhatsApp
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @endif

                        <div class="agency-card p-6 sm:p-8">
                            <h3 class="text-xl font-bold text-[rgb(var(--agency-navy-1))]">Kirim Pesan</h3>
                            <p class="mt-1 text-sm text-slate-500">Isi formulir di bawah ini dan tim kami akan merespons secepatnya.</p>

                            <form method="POST" action="{{ route('contact.store') }}" class="mt-6 grid gap-4">
                                @csrf

                                <div>
                                    <label class="text-sm font-semibold text-slate-800">Nama Lengkap</label>
                                    <input name="name" value="{{ old('name') }}" placeholder="Masukkan Nama Lengkap" class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-medium text-slate-900 outline-none transition focus:border-[rgb(var(--agency-cyan))] focus:bg-white focus:ring-2 focus:ring-[rgb(var(--agency-cyan)/0.2)]" required />
                                    @error('name') <div class="mt-2 text-sm font-semibold text-rose-600">{{ $message }}</div> @enderror
                                </div>

                                <div>
                                    <label class="text-sm font-semibold text-slate-800">Email</label>
                                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Masukkan Email" class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-medium text-slate-900 outline-none transition focus:border-[rgb(var(--agency-cyan))] focus:bg-white focus:ring-2 focus:ring-[rgb(var(--agency-cyan)/0.2)]" required />
                                    @error('email') <div class="mt-2 text-sm font-semibold text-rose-600">{{ $message }}</div> @enderror
                                </div>

                                <div>
                                    <label class="text-sm font-semibold text-slate-800">No. Telp / WhatsApp</label>
                                    <input name="phone" value="{{ old('phone') }}" placeholder="Masukkan No. Telp" class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-medium text-slate-900 outline-none transition focus:border-[rgb(var(--agency-cyan))] focus:bg-white focus:ring-2 focus:ring-[rgb(var(--agency-cyan)/0.2)]" />
                                    @error('phone') <div class="mt-2 text-sm font-semibold text-rose-600">{{ $message }}</div> @enderror
                                </div>

                                <div>
                                    <label class="text-sm font-semibold text-slate-800">Pesan Anda</label>
                                    <textarea name="message" rows="5" placeholder="Tulis Pesan Anda" class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-medium text-slate-900 outline-none transition focus:border-[rgb(var(--agency-cyan))] focus:bg-white focus:ring-2 focus:ring-[rgb(var(--agency-cyan)/0.2)]" required>{{ old('message') }}</textarea>
                                    @error('message') <div class="mt-2 text-sm font-semibold text-rose-600">{{ $message }}</div> @enderror
                                </div>

                                <div class="pt-2">
                                    <button type="submit" class="agency-btn-primary inline-flex w-full items-center justify-center gap-2 px-8 py-3.5 text-sm font-semibold">
                                        Kirim Pesan Sekarang
                                        <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5">
                                            <path d="M5 12h12" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                            <path d="M13 6l6 6-6 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="mt-14 agency-card overflow-hidden p-0 reveal">
                    @if (filled($mapEmbedUrl))
                        <iframe
                            src="{{ $mapEmbedUrl }}"
                            width="100%"
                            height="400"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                        ></iframe>
                    @else
                        <div class="grid h-[320px] place-items-center text-sm font-semibold text-slate-500">Map belum diatur.</div>
                    @endif
                </div>
            </div>
        </section>
    </main>
@endsection
