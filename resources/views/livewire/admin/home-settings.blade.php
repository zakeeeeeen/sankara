<div class="space-y-8">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="inline-flex items-center gap-2 rounded-full border border-sky-400/30 bg-sky-400/10 px-3 py-1 text-xs font-semibold text-sky-700 mb-2">
                <i class="fa-solid fa-house text-xs"></i>
                Homepage Management
            </div>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Kelola Konten Beranda</h1>
            <p class="mt-1 text-sm text-slate-500">Edit hero section, counter statistik, tentang kami, keunggulan, dan CTA landing page</p>
        </div>

        <button
            type="button"
            wire:click="save"
            wire:loading.attr="disabled"
            class="brand-gradient inline-flex items-center gap-2 rounded-2xl px-7 py-3.5 text-sm font-bold text-white shadow-md transition-all hover:-translate-y-0.5 hover:shadow-lg disabled:opacity-70"
        >
            <i wire:loading.remove class="fa-solid fa-floppy-disk text-xs"></i>
            <span wire:loading.remove>Simpan Perubahan</span>
            <span wire:loading>Menyimpan...</span>
        </button>
    </div>

    @if (session('status'))
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-800">
            {{ session('status') }}
        </div>
    @endif

    <form wire:submit="save" class="space-y-8">
        <!-- HERO SECTION -->
        <div class="rounded-[2.5rem] border border-slate-200/80 bg-white/90 p-6 sm:p-8 shadow-xs backdrop-blur">
            <h2 class="text-xl font-bold text-slate-900 flex items-center gap-3">
                <span class="grid h-8 w-8 place-items-center rounded-xl bg-sky-100 text-sky-600 text-xs">1</span>
                <span>Hero Section</span>
            </h2>

            <div class="mt-6 grid gap-6 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700">Heading Utama</label>
                    <input
                        type="text"
                        wire:model="hero.heading"
                        class="mt-1.5 w-full rounded-2xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm font-medium text-slate-900 outline-none focus:border-sky-500 focus:bg-white"
                        placeholder="Inovasi Digital untuk Pertumbuhan Bisnis Anda"
                    />
                    @error('hero.heading') <div class="mt-1 text-xs text-rose-600">{{ $message }}</div> @enderror
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700">Subheading / Deskripsi Singkat</label>
                    <textarea
                        wire:model="hero.subheading"
                        rows="3"
                        class="mt-1.5 w-full rounded-2xl border border-slate-200 bg-slate-50/50 p-4 text-sm font-medium text-slate-900 outline-none focus:border-sky-500 focus:bg-white"
                    ></textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700">Tombol Utama (Label)</label>
                    <input
                        type="text"
                        wire:model="hero.primary_cta_label"
                        class="mt-1.5 w-full rounded-2xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm font-medium text-slate-900 outline-none focus:border-sky-500 focus:bg-white"
                        placeholder="Mulai Proyek"
                    />
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700">Tombol Utama (URL Target)</label>
                    <input
                        type="text"
                        wire:model="hero.primary_cta_url"
                        class="mt-1.5 w-full rounded-2xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm font-medium text-slate-900 outline-none focus:border-sky-500 focus:bg-white"
                        placeholder="/kontak"
                    />
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700">Tombol Kedua (Label)</label>
                    <input
                        type="text"
                        wire:model="hero.secondary_cta_label"
                        class="mt-1.5 w-full rounded-2xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm font-medium text-slate-900 outline-none focus:border-sky-500 focus:bg-white"
                        placeholder="Lihat Portofolio"
                    />
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700">Tombol Kedua (URL Target)</label>
                    <input
                        type="text"
                        wire:model="hero.secondary_cta_url"
                        class="mt-1.5 w-full rounded-2xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm font-medium text-slate-900 outline-none focus:border-sky-500 focus:bg-white"
                        placeholder="#portofolio"
                    />
                </div>
            </div>
        </div>

        <!-- STATS COUNTER -->
        <div class="rounded-[2.5rem] border border-slate-200/80 bg-white/90 p-6 sm:p-8 shadow-xs backdrop-blur">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold text-slate-900 flex items-center gap-3">
                    <span class="grid h-8 w-8 place-items-center rounded-xl bg-sky-100 text-sky-600 text-xs">2</span>
                    <span>Counter Statistik</span>
                </h2>
                <button
                    type="button"
                    wire:click="addStat"
                    class="rounded-xl border border-slate-200 bg-slate-900 px-3.5 py-2 text-xs font-bold text-white transition hover:bg-slate-800"
                >
                    + Tambah Stat
                </button>
            </div>

            <div class="mt-6 space-y-4">
                @foreach ($stats as $idx => $stat)
                    <div class="flex items-center gap-4 rounded-2xl border border-slate-100 bg-slate-50/60 p-4">
                        <div class="w-1/3">
                            <label class="block text-[11px] font-bold text-slate-600">Nilai / Angka</label>
                            <input
                                type="text"
                                wire:model="stats.{{ $idx }}.value"
                                class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs font-bold text-slate-900 outline-none focus:border-sky-500"
                                placeholder="50+"
                            />
                        </div>
                        <div class="flex-1">
                            <label class="block text-[11px] font-bold text-slate-600">Label Keterangan</label>
                            <input
                                type="text"
                                wire:model="stats.{{ $idx }}.label"
                                class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs font-medium text-slate-900 outline-none focus:border-sky-500"
                                placeholder="Proyek Selesai"
                            />
                        </div>
                        <div class="pt-5">
                            <button
                                type="button"
                                wire:click="removeStat({{ $idx }})"
                                class="grid h-9 w-9 place-items-center rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-100 transition"
                            >
                                <i class="fa-solid fa-trash text-xs"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- ABOUT SECTION -->
        <div class="rounded-[2.5rem] border border-slate-200/80 bg-white/90 p-6 sm:p-8 shadow-xs backdrop-blur">
            <h2 class="text-xl font-bold text-slate-900 flex items-center gap-3">
                <span class="grid h-8 w-8 place-items-center rounded-xl bg-sky-100 text-sky-600 text-xs">3</span>
                <span>Section "Siapa Kami"</span>
            </h2>

            <div class="mt-6">
                <label class="block text-xs font-bold text-slate-700">Deskripsi Singkat</label>
                <textarea
                    wire:model="about.body"
                    rows="4"
                    class="mt-1.5 w-full rounded-2xl border border-slate-200 bg-slate-50/50 p-4 text-sm font-medium text-slate-900 outline-none focus:border-sky-500 focus:bg-white"
                ></textarea>
            </div>
        </div>

        <!-- ADVANTAGES (WHY CHOOSE US) -->
        <div class="rounded-[2.5rem] border border-slate-200/80 bg-white/90 p-6 sm:p-8 shadow-xs backdrop-blur">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold text-slate-900 flex items-center gap-3">
                    <span class="grid h-8 w-8 place-items-center rounded-xl bg-sky-100 text-sky-600 text-xs">4</span>
                    <span>Keunggulan (Why Choose Us)</span>
                </h2>
                <button
                    type="button"
                    wire:click="addAdvantage"
                    class="rounded-xl border border-slate-200 bg-slate-900 px-3.5 py-2 text-xs font-bold text-white transition hover:bg-slate-800"
                >
                    + Tambah Keunggulan
                </button>
            </div>

            <div class="mt-6 space-y-4">
                @foreach ($advantages as $idx => $adv)
                    <div class="rounded-2xl border border-slate-100 bg-slate-50/60 p-4 space-y-3">
                        <div class="flex items-center justify-between gap-4">
                            <div class="flex-1">
                                <label class="block text-[11px] font-bold text-slate-600">Judul Keunggulan</label>
                                <input
                                    type="text"
                                    wire:model="advantages.{{ $idx }}.title"
                                    class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs font-bold text-slate-900 outline-none focus:border-sky-500"
                                    placeholder="Teknologi Modern"
                                />
                            </div>
                            <div>
                                <button
                                    type="button"
                                    wire:click="removeAdvantage({{ $idx }})"
                                    class="grid h-9 w-9 place-items-center rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-100 transition"
                                >
                                    <i class="fa-solid fa-trash text-xs"></i>
                                </button>
                            </div>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-600">Deskripsi</label>
                            <textarea
                                wire:model="advantages.{{ $idx }}.description"
                                rows="2"
                                class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs font-medium text-slate-900 outline-none focus:border-sky-500"
                            ></textarea>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- CTA SECTION -->
        <div class="rounded-[2.5rem] border border-slate-200/80 bg-white/90 p-6 sm:p-8 shadow-xs backdrop-blur">
            <h2 class="text-xl font-bold text-slate-900 flex items-center gap-3">
                <span class="grid h-8 w-8 place-items-center rounded-xl bg-sky-100 text-sky-600 text-xs">5</span>
                <span>Call to Action (CTA) Banner</span>
            </h2>

            <div class="mt-6 grid gap-6 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700">Judul CTA</label>
                    <input
                        type="text"
                        wire:model="cta.heading"
                        class="mt-1.5 w-full rounded-2xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm font-medium text-slate-900 outline-none focus:border-sky-500 focus:bg-white"
                    />
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700">Deskripsi CTA</label>
                    <textarea
                        wire:model="cta.body"
                        rows="3"
                        class="mt-1.5 w-full rounded-2xl border border-slate-200 bg-slate-50/50 p-4 text-sm font-medium text-slate-900 outline-none focus:border-sky-500 focus:bg-white"
                    ></textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700">Tombol Utama (Label)</label>
                    <input
                        type="text"
                        wire:model="cta.primary_label"
                        class="mt-1.5 w-full rounded-2xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm font-medium text-slate-900 outline-none focus:border-sky-500 focus:bg-white"
                    />
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700">Tombol Utama (URL Target)</label>
                    <input
                        type="text"
                        wire:model="cta.primary_url"
                        class="mt-1.5 w-full rounded-2xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm font-medium text-slate-900 outline-none focus:border-sky-500 focus:bg-white"
                    />
                </div>
            </div>
        </div>

        <div class="flex justify-end pt-4">
            <button
                type="submit"
                wire:loading.attr="disabled"
                class="brand-gradient rounded-2xl px-8 py-3.5 text-sm font-bold text-white shadow-md transition hover:-translate-y-0.5"
            >
                Simpan Semua Perubahan Beranda
            </button>
        </div>
    </form>
</div>
