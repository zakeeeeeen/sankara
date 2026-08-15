<div>
    <!-- WELCOME BANNER -->
    <div class="relative overflow-hidden rounded-[2.5rem] border border-slate-200/80 bg-gradient-to-br from-slate-900 via-slate-800 to-sky-950 p-6 sm:p-10 text-white shadow-xl">
        <div class="pointer-events-none absolute -right-10 -top-10 h-64 w-64 rounded-full bg-sky-500/15 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-10 right-20 h-64 w-64 rounded-full bg-cyan-500/10 blur-3xl"></div>

        <div class="relative flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex items-center gap-5">
                <div class="grid h-16 w-16 place-items-center rounded-2xl border border-white/15 bg-white/10 p-2 backdrop-blur shadow-inner">
                    <img src="{{ $siteLogo }}" alt="Logo" class="max-h-full max-w-full object-contain">
                </div>
                <div>
                    <div class="inline-flex items-center gap-2 rounded-full border border-sky-400/30 bg-sky-400/10 px-3 py-1 text-xs font-semibold text-sky-300 backdrop-blur mb-2">
                        <span class="h-1.5 w-1.5 rounded-full bg-sky-400 animate-pulse"></span>
                        Admin Workspace
                    </div>
                    <h1 class="text-2xl font-bold tracking-tight sm:text-3xl">Selamat Datang, {{ auth()->user()->name }} 👋</h1>
                    <p class="mt-1 text-sm text-slate-300">
                        Kelola seluruh konten, layanan, portofolio, dan interaksi pengunjung situs <span class="font-semibold text-sky-400">{{ $siteName }}</span>.
                    </p>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('admin.settings.edit') }}" wire:navigate class="inline-flex items-center gap-2 rounded-2xl border border-white/20 bg-white/10 px-5 py-2.5 text-xs font-semibold text-white shadow-xs backdrop-blur transition hover:bg-white/20">
                    <i class="fa-solid fa-gear text-xs"></i>
                    <span>Pengaturan Situs</span>
                </a>
                <a href="{{ route('home') }}" target="_blank" class="brand-gradient inline-flex items-center gap-2 rounded-2xl px-5 py-2.5 text-xs font-semibold text-white shadow-[0_18px_50px_-26px_rgba(14,165,233,0.6)] transition hover:-translate-y-0.5">
                    <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                    <span>Lihat Live Website</span>
                </a>
            </div>
        </div>
    </div>

    <!-- METRICS GRID -->
    <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-5">
        <!-- Card 1: Layanan -->
        <a href="{{ route('admin.services.index') }}" wire:navigate class="group relative overflow-hidden rounded-[2rem] border border-slate-200/80 bg-white/95 p-6 shadow-xs backdrop-blur transition-all duration-300 hover:-translate-y-1 hover:border-sky-300 hover:shadow-md">
            <div class="flex items-center justify-between gap-3">
                <span class="grid h-12 w-12 place-items-center rounded-2xl bg-sky-50 text-sky-600 transition-colors duration-200 group-hover:bg-sky-600 group-hover:text-white shadow-xs">
                    <i class="fa-solid fa-cubes text-lg"></i>
                </span>
                <span class="rounded-xl bg-slate-100 px-2.5 py-1 text-[11px] font-bold text-slate-500">SERVICES</span>
            </div>
            <div class="mt-5">
                <div class="text-3xl font-extrabold tracking-tight text-slate-900">{{ $servicesCount }}</div>
                <div class="mt-1 text-xs font-semibold text-slate-500">Total Layanan Aktif</div>
            </div>
        </a>

        <!-- Card 2: Portofolio -->
        <a href="{{ route('admin.portfolios.index') }}" wire:navigate class="group relative overflow-hidden rounded-[2rem] border border-slate-200/80 bg-white/95 p-6 shadow-xs backdrop-blur transition-all duration-300 hover:-translate-y-1 hover:border-emerald-300 hover:shadow-md">
            <div class="flex items-center justify-between gap-3">
                <span class="grid h-12 w-12 place-items-center rounded-2xl bg-emerald-50 text-emerald-600 transition-colors duration-200 group-hover:bg-emerald-600 group-hover:text-white shadow-xs">
                    <i class="fa-solid fa-briefcase text-lg"></i>
                </span>
                <span class="rounded-xl bg-slate-100 px-2.5 py-1 text-[11px] font-bold text-slate-500">PROJECTS</span>
            </div>
            <div class="mt-5">
                <div class="text-3xl font-extrabold tracking-tight text-slate-900">{{ $portfoliosCount }}</div>
                <div class="mt-1 text-xs font-semibold text-slate-500">Project Portofolio</div>
            </div>
        </a>

        <!-- Card 3: Kategori -->
        <a href="{{ route('admin.portfolio-categories.index') }}" wire:navigate class="group relative overflow-hidden rounded-[2rem] border border-slate-200/80 bg-white/95 p-6 shadow-xs backdrop-blur transition-all duration-300 hover:-translate-y-1 hover:border-indigo-300 hover:shadow-md">
            <div class="flex items-center justify-between gap-3">
                <span class="grid h-12 w-12 place-items-center rounded-2xl bg-indigo-50 text-indigo-600 transition-colors duration-200 group-hover:bg-indigo-600 group-hover:text-white shadow-xs">
                    <i class="fa-solid fa-layer-group text-lg"></i>
                </span>
                <span class="rounded-xl bg-slate-100 px-2.5 py-1 text-[11px] font-bold text-slate-500">CATEGORY</span>
            </div>
            <div class="mt-5">
                <div class="text-3xl font-extrabold tracking-tight text-slate-900">{{ $categoriesCount }}</div>
                <div class="mt-1 text-xs font-semibold text-slate-500">Kategori Portofolio</div>
            </div>
        </a>

        <!-- Card 4: Pricing -->
        <a href="{{ route('admin.pricing.index') }}" wire:navigate class="group relative overflow-hidden rounded-[2rem] border border-slate-200/80 bg-white/95 p-6 shadow-xs backdrop-blur transition-all duration-300 hover:-translate-y-1 hover:border-amber-300 hover:shadow-md">
            <div class="flex items-center justify-between gap-3">
                <span class="grid h-12 w-12 place-items-center rounded-2xl bg-amber-50 text-amber-600 transition-colors duration-200 group-hover:bg-amber-600 group-hover:text-white shadow-xs">
                    <i class="fa-solid fa-tags text-lg"></i>
                </span>
                <span class="rounded-xl bg-slate-100 px-2.5 py-1 text-[11px] font-bold text-slate-500">PRICING</span>
            </div>
            <div class="mt-5">
                <div class="text-3xl font-extrabold tracking-tight text-slate-900">{{ $pricingCount }}</div>
                <div class="mt-1 text-xs font-semibold text-slate-500">Paket Penawaran</div>
            </div>
        </a>

        <!-- Card 5: Pesan Kontak -->
        <a href="{{ route('admin.contact-messages.index') }}" wire:navigate class="group relative overflow-hidden rounded-[2rem] border border-slate-200/80 bg-white/95 p-6 shadow-xs backdrop-blur transition-all duration-300 hover:-translate-y-1 hover:border-rose-300 hover:shadow-md">
            <div class="flex items-center justify-between gap-3">
                <span class="grid h-12 w-12 place-items-center rounded-2xl bg-rose-50 text-rose-600 transition-colors duration-200 group-hover:bg-rose-600 group-hover:text-white shadow-xs">
                    <i class="fa-solid fa-envelope text-lg"></i>
                </span>
                <span class="rounded-xl bg-rose-100 px-2.5 py-1 text-[11px] font-bold text-rose-700">INBOX</span>
            </div>
            <div class="mt-5">
                <div class="text-3xl font-extrabold tracking-tight text-slate-900">{{ $messagesCount }}</div>
                <div class="mt-1 text-xs font-semibold text-slate-500">Pesan Masuk</div>
            </div>
        </a>
    </div>

    <!-- MAIN TWO COLUMN SECTION -->
    <div class="mt-10 grid gap-8 lg:grid-cols-3">
        <!-- LEFT 2 COLS: MENU SHORTCUTS -->
        <div class="lg:col-span-2 space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-bold tracking-tight text-slate-900">Manajemen Konten Website</h2>
                    <p class="text-xs text-slate-500">Pusat kelola seluruh halaman dan komponen utama situs</p>
                </div>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <!-- Modul 1: Pengaturan Situs -->
                <a href="{{ route('admin.settings.edit') }}" wire:navigate class="group flex items-start gap-4 rounded-[1.75rem] border border-slate-200/80 bg-white/90 p-5 shadow-xs backdrop-blur transition-all duration-200 hover:border-sky-300 hover:bg-white hover:shadow-md">
                    <div class="grid h-12 w-12 shrink-0 place-items-center rounded-2xl bg-sky-50 text-sky-600 transition-transform group-hover:scale-105">
                        <i class="fa-solid fa-gear text-lg"></i>
                    </div>
                    <div>
                        <div class="text-sm font-bold text-slate-900 group-hover:text-sky-600 transition-colors">Pengaturan Situs</div>
                        <div class="mt-1 text-xs leading-relaxed text-slate-500">Logo, favicon, brand name, tagline, bottom nav, header & footer.</div>
                    </div>
                </a>

                <!-- Modul 2: Home Settings -->
                <a href="{{ route('admin.home.edit') }}" wire:navigate class="group flex items-start gap-4 rounded-[1.75rem] border border-slate-200/80 bg-white/90 p-5 shadow-xs backdrop-blur transition-all duration-200 hover:border-emerald-300 hover:bg-white hover:shadow-md">
                    <div class="grid h-12 w-12 shrink-0 place-items-center rounded-2xl bg-emerald-50 text-emerald-600 transition-transform group-hover:scale-105">
                        <i class="fa-solid fa-house-chimney text-lg"></i>
                    </div>
                    <div>
                        <div class="text-sm font-bold text-slate-900 group-hover:text-emerald-600 transition-colors">Home Settings</div>
                        <div class="mt-1 text-xs leading-relaxed text-slate-500">Hero section, stats counter, tentang kami, keunggulan & CTA.</div>
                    </div>
                </a>

                <!-- Modul 3: Layanan -->
                <a href="{{ route('admin.services.index') }}" wire:navigate class="group flex items-start gap-4 rounded-[1.75rem] border border-slate-200/80 bg-white/90 p-5 shadow-xs backdrop-blur transition-all duration-200 hover:border-indigo-300 hover:bg-white hover:shadow-md">
                    <div class="grid h-12 w-12 shrink-0 place-items-center rounded-2xl bg-indigo-50 text-indigo-600 transition-transform group-hover:scale-105">
                        <i class="fa-solid fa-cubes text-lg"></i>
                    </div>
                    <div>
                        <div class="text-sm font-bold text-slate-900 group-hover:text-indigo-600 transition-colors">Kelola Layanan (CRUD)</div>
                        <div class="mt-1 text-xs leading-relaxed text-slate-500">Tambah, edit, hapus layanan bisnis, deskripsi & fitur layanan.</div>
                    </div>
                </a>

                <!-- Modul 4: Portofolio -->
                <a href="{{ route('admin.portfolios.index') }}" wire:navigate class="group flex items-start gap-4 rounded-[1.75rem] border border-slate-200/80 bg-white/90 p-5 shadow-xs backdrop-blur transition-all duration-200 hover:border-purple-300 hover:bg-white hover:shadow-md">
                    <div class="grid h-12 w-12 shrink-0 place-items-center rounded-2xl bg-purple-50 text-purple-600 transition-transform group-hover:scale-105">
                        <i class="fa-solid fa-briefcase text-lg"></i>
                    </div>
                    <div>
                        <div class="text-sm font-bold text-slate-900 group-hover:text-purple-600 transition-colors">Kelola Portofolio (CRUD)</div>
                        <div class="mt-1 text-xs leading-relaxed text-slate-500">Manajemen project hasil karya, gambar, client & detail section.</div>
                    </div>
                </a>

                <!-- Modul 5: Pricing Plan -->
                <a href="{{ route('admin.pricing.index') }}" wire:navigate class="group flex items-start gap-4 rounded-[1.75rem] border border-slate-200/80 bg-white/90 p-5 shadow-xs backdrop-blur transition-all duration-200 hover:border-amber-300 hover:bg-white hover:shadow-md">
                    <div class="grid h-12 w-12 shrink-0 place-items-center rounded-2xl bg-amber-50 text-amber-600 transition-transform group-hover:scale-105">
                        <i class="fa-solid fa-tags text-lg"></i>
                    </div>
                    <div>
                        <div class="text-sm font-bold text-slate-900 group-hover:text-amber-600 transition-colors">Kelola Pricing (CRUD)</div>
                        <div class="mt-1 text-xs leading-relaxed text-slate-500">Paket penawaran harga, tag populer, dan fitur yang didapat.</div>
                    </div>
                </a>

                <!-- Modul 6: Halaman Tentang Kami -->
                <a href="{{ route('admin.pages.about.edit') }}" wire:navigate class="group flex items-start gap-4 rounded-[1.75rem] border border-slate-200/80 bg-white/90 p-5 shadow-xs backdrop-blur transition-all duration-200 hover:border-blue-300 hover:bg-white hover:shadow-md">
                    <div class="grid h-12 w-12 shrink-0 place-items-center rounded-2xl bg-blue-50 text-blue-600 transition-transform group-hover:scale-105">
                        <i class="fa-solid fa-address-card text-lg"></i>
                    </div>
                    <div>
                        <div class="text-sm font-bold text-slate-900 group-hover:text-blue-600 transition-colors">Halaman Tentang Kami</div>
                        <div class="mt-1 text-xs leading-relaxed text-slate-500">Judul hero, konten utama, dan gambar profil perusahaan.</div>
                    </div>
                </a>
            </div>
        </div>

        <!-- RIGHT 1 COL: RECENT MESSAGES -->
        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-bold tracking-tight text-slate-900">Pesan Masuk Terbaru</h2>
                    <p class="text-xs text-slate-500">Pesan dari pengunjung via form kontak</p>
                </div>
                <a href="{{ route('admin.contact-messages.index') }}" wire:navigate class="text-xs font-bold text-sky-600 hover:underline inline-flex items-center gap-1">
                    <span>Lihat Semua</span>
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>

            <div class="rounded-[2rem] border border-slate-200/80 bg-white/95 p-5 shadow-xs backdrop-blur">
                @if($recentMessages->isEmpty())
                    <div class="py-12 text-center text-xs font-medium text-slate-400">
                        <i class="fa-solid fa-inbox text-2xl mb-2 text-slate-300 block"></i>
                        Belum ada pesan kontak yang masuk.
                    </div>
                @else
                    <div class="divide-y divide-slate-100">
                        @foreach ($recentMessages as $msg)
                            <a href="{{ route('admin.contact-messages.show', $msg) }}" wire:navigate class="group block py-3.5 first:pt-1 last:pb-1 transition hover:bg-slate-50/80 rounded-xl px-3">
                                <div class="flex items-center justify-between gap-2">
                                    <span class="truncate text-xs font-bold text-slate-900 group-hover:text-sky-600 transition-colors">{{ $msg->name }}</span>
                                    <span class="shrink-0 text-[10px] font-semibold text-slate-400">{{ $msg->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="truncate text-xs text-slate-600 mt-1 font-medium">{{ $msg->email }}</div>
                                <div class="truncate text-[11px] text-slate-400 mt-1">{{ \Illuminate\Support\Str::limit($msg->message, 55) }}</div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
