@extends('layouts.admin')

@section('title', 'Dashboard Admin - ' . $siteName)
@section('page_title', 'Dashboard Utama')
@section('page_subtitle', 'Ringkasan performa dan manajemen konten website')

@section('content')
    <!-- WELCOME BANNER -->
    <div class="relative overflow-hidden rounded-[2rem] border border-slate-200/70 bg-gradient-to-br from-slate-900 via-slate-800 to-sky-950 p-8 text-white shadow-xl">
        <div class="pointer-events-none absolute -right-10 -top-10 h-64 w-64 rounded-full bg-sky-500/10 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-10 right-20 h-64 w-64 rounded-full bg-emerald-500/10 blur-3xl"></div>

        <div class="relative flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-5">
                <div class="grid h-16 w-16 place-items-center rounded-2xl border border-white/10 bg-white/10 p-2 backdrop-blur">
                    <img src="{{ $siteLogo }}" alt="Logo" class="max-h-full max-w-full object-contain">
                </div>
                <div>
                    <h1 class="text-2xl font-bold tracking-tight sm:text-3xl">Halo, {{ auth()->user()->name }} 👋</h1>
                    <p class="mt-1 text-sm text-slate-300">
                        Selamat datang di Admin Panel <span class="font-semibold text-sky-400">{{ $siteName }}</span>. Kelola seluruh aspek situs Anda dari sini.
                    </p>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('admin.settings.edit') }}" class="rounded-2xl border border-white/20 bg-white/10 px-5 py-2.5 text-sm font-semibold text-white shadow-sm backdrop-blur transition hover:bg-white/20">
                    ⚙️ Pengaturan Situs
                </a>
                <a href="{{ route('home') }}" target="_blank" class="brand-gradient rounded-2xl px-5 py-2.5 text-sm font-semibold text-white shadow-[0_18px_50px_-26px_rgba(14,165,233,0.6)] transition hover:-translate-y-0.5">
                    🌐 Lihat Website
                </a>
            </div>
        </div>
    </div>

    <!-- METRICS GRID -->
    <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-5">
        <!-- Card 1: Layanan -->
        <a href="{{ route('admin.services.index') }}" class="group rounded-[1.8rem] border border-slate-200/70 bg-white/70 p-5 shadow-sm backdrop-blur transition hover:-translate-y-1 hover:border-sky-300 hover:bg-white">
            <div class="flex items-center justify-between gap-3">
                <span class="grid h-11 w-11 place-items-center rounded-2xl bg-sky-50 text-sky-600 transition group-hover:bg-sky-600 group-hover:text-white">
                    <svg viewBox="0 0 24 24" fill="none" class="h-6 w-6">
                        <path d="M7 7h10M7 12h10M7 17h10" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </span>
                <span class="rounded-xl bg-slate-100 px-2.5 py-1 text-[11px] font-semibold text-slate-600">CRUD</span>
            </div>
            <div class="mt-4">
                <div class="text-2xl font-bold text-slate-900">{{ $servicesCount }}</div>
                <div class="text-xs font-semibold text-slate-500">Total Layanan</div>
            </div>
        </a>

        <!-- Card 2: Portofolio -->
        <a href="{{ route('admin.portfolios.index') }}" class="group rounded-[1.8rem] border border-slate-200/70 bg-white/70 p-5 shadow-sm backdrop-blur transition hover:-translate-y-1 hover:border-emerald-300 hover:bg-white">
            <div class="flex items-center justify-between gap-3">
                <span class="grid h-11 w-11 place-items-center rounded-2xl bg-emerald-50 text-emerald-600 transition group-hover:bg-emerald-600 group-hover:text-white">
                    <svg viewBox="0 0 24 24" fill="none" class="h-6 w-6">
                        <path d="M4.5 6.8A2.3 2.3 0 016.8 4.5h10.4a2.3 2.3 0 012.3 2.3v10.4a2.3 2.3 0 01-2.3 2.3H6.8a2.3 2.3 0 01-2.3-2.3V6.8Z" stroke="currentColor" stroke-width="1.8"/>
                        <path d="M8 10h8M8 14h5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </span>
                <span class="rounded-xl bg-slate-100 px-2.5 py-1 text-[11px] font-semibold text-slate-600">CRUD</span>
            </div>
            <div class="mt-4">
                <div class="text-2xl font-bold text-slate-900">{{ $portfoliosCount }}</div>
                <div class="text-xs font-semibold text-slate-500">Project Portofolio</div>
            </div>
        </a>

        <!-- Card 3: Kategori -->
        <a href="{{ route('admin.portfolio-categories.index') }}" class="group rounded-[1.8rem] border border-slate-200/70 bg-white/70 p-5 shadow-sm backdrop-blur transition hover:-translate-y-1 hover:border-indigo-300 hover:bg-white">
            <div class="flex items-center justify-between gap-3">
                <span class="grid h-11 w-11 place-items-center rounded-2xl bg-indigo-50 text-indigo-600 transition group-hover:bg-indigo-600 group-hover:text-white">
                    <svg viewBox="0 0 24 24" fill="none" class="h-6 w-6">
                        <path d="M4.5 7.2L12 3l7.5 4.2v9.6L12 21l-7.5-4.2V7.2Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                    </svg>
                </span>
                <span class="rounded-xl bg-slate-100 px-2.5 py-1 text-[11px] font-semibold text-slate-600">Filtet</span>
            </div>
            <div class="mt-4">
                <div class="text-2xl font-bold text-slate-900">{{ $categoriesCount }}</div>
                <div class="text-xs font-semibold text-slate-500">Kategori Portofolio</div>
            </div>
        </a>

        <!-- Card 4: Pricing -->
        <a href="{{ route('admin.pricing.index') }}" class="group rounded-[1.8rem] border border-slate-200/70 bg-white/70 p-5 shadow-sm backdrop-blur transition hover:-translate-y-1 hover:border-amber-300 hover:bg-white">
            <div class="flex items-center justify-between gap-3">
                <span class="grid h-11 w-11 place-items-center rounded-2xl bg-amber-50 text-amber-600 transition group-hover:bg-amber-600 group-hover:text-white">
                    <svg viewBox="0 0 24 24" fill="none" class="h-6 w-6">
                        <path d="M7 8h10M7 12h10M7 16h10" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </span>
                <span class="rounded-xl bg-slate-100 px-2.5 py-1 text-[11px] font-semibold text-slate-600">Paket</span>
            </div>
            <div class="mt-4">
                <div class="text-2xl font-bold text-slate-900">{{ $pricingCount }}</div>
                <div class="text-xs font-semibold text-slate-500">Paket Harga</div>
            </div>
        </a>

        <!-- Card 5: Pesan Kontak -->
        <a href="{{ route('admin.contact-messages.index') }}" class="group rounded-[1.8rem] border border-slate-200/70 bg-white/70 p-5 shadow-sm backdrop-blur transition hover:-translate-y-1 hover:border-rose-300 hover:bg-white">
            <div class="flex items-center justify-between gap-3">
                <span class="grid h-11 w-11 place-items-center rounded-2xl bg-rose-50 text-rose-600 transition group-hover:bg-rose-600 group-hover:text-white">
                    <svg viewBox="0 0 24 24" fill="none" class="h-6 w-6">
                        <path d="M6.5 19.5a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h11a2 2 0 0 1 2 2v6.5" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                        <path d="M8 9h8M8 12h6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </span>
                <span class="rounded-xl bg-rose-100 px-2.5 py-1 text-[11px] font-semibold text-rose-700">Inbox</span>
            </div>
            <div class="mt-4">
                <div class="text-2xl font-bold text-slate-900">{{ $messagesCount }}</div>
                <div class="text-xs font-semibold text-slate-500">Pesan Masuk</div>
            </div>
        </a>
    </div>

    <!-- MAIN TWO COLUMN SECTION -->
    <div class="mt-10 grid gap-8 lg:grid-cols-3">
        <!-- LEFT 2 COLS: MENU SHORTCUTS -->
        <div class="lg:col-span-2 space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-slate-900">Manajemen Konten Website</h2>
                    <p class="text-xs text-slate-500">Akses cepat ke modul CRUD dan halaman admin</p>
                </div>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <!-- Modul 1: Pengaturan Situs -->
                <a href="{{ route('admin.settings.edit') }}" class="flex items-start gap-4 rounded-2xl border border-slate-200/70 bg-white/70 p-5 shadow-sm backdrop-blur transition hover:border-sky-300 hover:bg-white">
                    <div class="grid h-12 w-12 shrink-0 place-items-center rounded-2xl bg-sky-50 text-sky-600">
                        <svg viewBox="0 0 24 24" fill="none" class="h-6 w-6">
                            <path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" stroke="currentColor" stroke-width="1.8"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-sm font-bold text-slate-900">Pengaturan Situs</div>
                        <div class="mt-1 text-xs leading-relaxed text-slate-600">Logo, favicon, brand name, tagline, bottom nav, header & footer.</div>
                    </div>
                </a>

                <!-- Modul 2: Home Settings -->
                <a href="{{ route('admin.home.edit') }}" class="flex items-start gap-4 rounded-2xl border border-slate-200/70 bg-white/70 p-5 shadow-sm backdrop-blur transition hover:border-emerald-300 hover:bg-white">
                    <div class="grid h-12 w-12 shrink-0 place-items-center rounded-2xl bg-emerald-50 text-emerald-600">
                        <svg viewBox="0 0 24 24" fill="none" class="h-6 w-6">
                            <path d="M4.5 7.2L12 3l7.5 4.2v9.6L12 21l-7.5-4.2V7.2Z" stroke="currentColor" stroke-width="1.8"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-sm font-bold text-slate-900">Home Settings</div>
                        <div class="mt-1 text-xs leading-relaxed text-slate-600">Hero section, stats counter, tentang kami, keunggulan & CTA.</div>
                    </div>
                </a>

                <!-- Modul 3: Layanan -->
                <a href="{{ route('admin.services.index') }}" class="flex items-start gap-4 rounded-2xl border border-slate-200/70 bg-white/70 p-5 shadow-sm backdrop-blur transition hover:border-indigo-300 hover:bg-white">
                    <div class="grid h-12 w-12 shrink-0 place-items-center rounded-2xl bg-indigo-50 text-indigo-600">
                        <svg viewBox="0 0 24 24" fill="none" class="h-6 w-6">
                            <path d="M7 7h10M7 12h10M7 17h10" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-sm font-bold text-slate-900">Kelola Layanan (CRUD)</div>
                        <div class="mt-1 text-xs leading-relaxed text-slate-600">Tambah, edit, hapus layanan bisnis, deskripsi & fitur.</div>
                    </div>
                </a>

                <!-- Modul 4: Portofolio -->
                <a href="{{ route('admin.portfolios.index') }}" class="flex items-start gap-4 rounded-2xl border border-slate-200/70 bg-white/70 p-5 shadow-sm backdrop-blur transition hover:border-purple-300 hover:bg-white">
                    <div class="grid h-12 w-12 shrink-0 place-items-center rounded-2xl bg-purple-50 text-purple-600">
                        <svg viewBox="0 0 24 24" fill="none" class="h-6 w-6">
                            <path d="M4.5 6.8A2.3 2.3 0 016.8 4.5h10.4a2.3 2.3 0 012.3 2.3v10.4a2.3 2.3 0 01-2.3 2.3H6.8a2.3 2.3 0 01-2.3-2.3V6.8Z" stroke="currentColor" stroke-width="1.8"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-sm font-bold text-slate-900">Kelola Portofolio (CRUD)</div>
                        <div class="mt-1 text-xs leading-relaxed text-slate-600">Manajemen project hasil karya, gambar, client & detail section.</div>
                    </div>
                </a>

                <!-- Modul 5: Pricing Plan -->
                <a href="{{ route('admin.pricing.index') }}" class="flex items-start gap-4 rounded-2xl border border-slate-200/70 bg-white/70 p-5 shadow-sm backdrop-blur transition hover:border-amber-300 hover:bg-white">
                    <div class="grid h-12 w-12 shrink-0 place-items-center rounded-2xl bg-amber-50 text-amber-600">
                        <svg viewBox="0 0 24 24" fill="none" class="h-6 w-6">
                            <path d="M7 8h10M7 12h10M7 16h10" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-sm font-bold text-slate-900">Kelola Pricing (CRUD)</div>
                        <div class="mt-1 text-xs leading-relaxed text-slate-600">Paket penawaran harga, tag populer, dan fitur yang didapat.</div>
                    </div>
                </a>

                <!-- Modul 6: Halaman Tentang Kami -->
                <a href="{{ route('admin.pages.about.edit') }}" class="flex items-start gap-4 rounded-2xl border border-slate-200/70 bg-white/70 p-5 shadow-sm backdrop-blur transition hover:border-blue-300 hover:bg-white">
                    <div class="grid h-12 w-12 shrink-0 place-items-center rounded-2xl bg-blue-50 text-blue-600">
                        <svg viewBox="0 0 24 24" fill="none" class="h-6 w-6">
                            <path d="M7 4h10a2 2 0 012 2v14l-7-3-7 3V6a2 2 0 012-2Z" stroke="currentColor" stroke-width="1.8"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-sm font-bold text-slate-900">Halaman Tentang Kami</div>
                        <div class="mt-1 text-xs leading-relaxed text-slate-600">Judul hero, konten utama, dan gambar profil perusahaan.</div>
                    </div>
                </a>
            </div>
        </div>

        <!-- RIGHT 1 COL: RECENT MESSAGES -->
        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-slate-900">Pesan Masuk Terbaru</h2>
                    <p class="text-xs text-slate-500">Pesan dari pengunjung via form kontak</p>
                </div>
                <a href="{{ route('admin.contact-messages.index') }}" class="text-xs font-semibold text-sky-600 hover:underline">
                    Lihat Semua →
                </a>
            </div>

            <div class="rounded-2xl border border-slate-200/70 bg-white/70 p-4 shadow-sm backdrop-blur">
                @if($recentMessages->isEmpty())
                    <div class="py-10 text-center text-xs font-medium text-slate-400">
                        Belum ada pesan kontak yang masuk.
                    </div>
                @else
                    <div class="divide-y divide-slate-100">
                        @foreach ($recentMessages as $msg)
                            <a href="{{ route('admin.contact-messages.show', $msg) }}" class="group block py-3 first:pt-0 last:pb-0 transition hover:bg-slate-50/80 rounded-xl px-2">
                                <div class="flex items-center justify-between gap-2">
                                    <span class="truncate text-xs font-bold text-slate-900 group-hover:text-sky-600">{{ $msg->name }}</span>
                                    <span class="shrink-0 text-[10px] text-slate-400">{{ $msg->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="truncate text-xs text-slate-600 mt-0.5">{{ $msg->subject ?: $msg->email }}</div>
                                <div class="truncate text-[11px] text-slate-400 mt-1">{{ Str::limit($msg->message, 50) }}</div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
