<div class="space-y-8">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <a href="{{ route('admin.services.index') }}" wire:navigate class="inline-flex items-center gap-2 text-xs font-bold text-sky-600 hover:underline mb-2">
                <i class="fa-solid fa-arrow-left text-[10px]"></i>
                <span>Kembali ke Daftar Layanan</span>
            </a>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Tambah Layanan Baru</h1>
            <p class="mt-1 text-sm text-slate-500">Buat layanan digital baru lengkap dengan fitur dan relasi portofolio</p>
        </div>

        <button
            type="button"
            wire:click="save"
            wire:loading.attr="disabled"
            class="brand-gradient inline-flex items-center gap-2 rounded-2xl px-7 py-3.5 text-sm font-bold text-white shadow-md transition-all hover:-translate-y-0.5 hover:shadow-lg disabled:opacity-70"
        >
            <i wire:loading.remove class="fa-solid fa-check text-xs"></i>
            <span wire:loading.remove>Simpan Layanan</span>
            <span wire:loading>Menyimpan...</span>
        </button>
    </div>

    <form wire:submit="save" class="space-y-8">
        <div class="rounded-[2.5rem] border border-slate-200/80 bg-white/90 p-6 sm:p-8 shadow-xs backdrop-blur space-y-6">
            <h2 class="text-xl font-bold text-slate-900">Informasi Utama Layanan</h2>

            <div class="grid gap-6 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700">Nama / Judul Layanan <span class="text-rose-500">*</span></label>
                    <input
                        type="text"
                        wire:model="service.title"
                        class="mt-1.5 w-full rounded-2xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm font-medium text-slate-900 outline-none focus:border-sky-500 focus:bg-white"
                        placeholder="Website Development"
                        required
                    />
                    @error('service.title') <div class="mt-1 text-xs text-rose-600">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700">Slug (URL)</label>
                    <input
                        type="text"
                        wire:model="service.slug"
                        class="mt-1.5 w-full rounded-2xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm font-mono text-slate-900 outline-none focus:border-sky-500 focus:bg-white"
                        placeholder="website-development (otomatis jika kosong)"
                    />
                    @error('service.slug') <div class="mt-1 text-xs text-rose-600">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700">Urutan Tampil (Sort Order)</label>
                    <input
                        type="number"
                        wire:model="service.sort_order"
                        class="mt-1.5 w-full rounded-2xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm font-medium text-slate-900 outline-none focus:border-sky-500 focus:bg-white"
                    />
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700">Ringkasan / Excerpt (Tampil di Card)</label>
                    <textarea
                        wire:model="service.excerpt"
                        rows="2"
                        class="mt-1.5 w-full rounded-2xl border border-slate-200 bg-slate-50/50 p-4 text-sm font-medium text-slate-900 outline-none focus:border-sky-500 focus:bg-white"
                    ></textarea>
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700">Deskripsi Lengkap (Halaman Detail)</label>
                    <textarea
                        wire:model="service.description"
                        rows="5"
                        class="mt-1.5 w-full rounded-2xl border border-slate-200 bg-slate-50/50 p-4 text-sm font-medium text-slate-900 outline-none focus:border-sky-500 focus:bg-white leading-relaxed"
                    ></textarea>
                </div>

                <div class="sm:col-span-2 rounded-2xl border border-slate-100 bg-slate-50/50 p-5">
                    <label class="block text-xs font-bold text-slate-700">Gambar Banner / Ilustrasi Layanan</label>
                    <div class="mt-3 flex items-center gap-6">
                        @if ($image)
                            <div class="h-20 w-32 rounded-xl overflow-hidden border border-sky-300">
                                <img src="{{ $image->temporaryUrl() }}" alt="Preview" class="h-full w-full object-cover">
                            </div>
                        @endif
                        <div class="flex-1">
                            <input
                                type="file"
                                wire:model="image"
                                accept="image/*"
                                class="w-full text-xs text-slate-600 file:mr-3 file:rounded-xl file:border-0 file:bg-slate-900 file:px-4 file:py-2.5 file:text-xs file:font-semibold file:text-white hover:file:bg-slate-800"
                            />
                            <div wire:loading wire:target="image" class="mt-1 text-xs text-sky-600 font-semibold">Mengunggah gambar...</div>
                        </div>
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" wire:model="service.is_active" class="rounded border-slate-300 text-sky-600 focus:ring-sky-500">
                        <span class="text-xs font-bold text-slate-800">Aktifkan Layanan (Tampilkan ke Publik)</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- FITUR-FITUR LAYANAN -->
        <div class="rounded-[2.5rem] border border-slate-200/80 bg-white/90 p-6 sm:p-8 shadow-xs backdrop-blur space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-slate-900">Daftar Fitur / Poin Layanan</h2>
                    <p class="text-xs text-slate-500">Poin keunggulan atau fitur yang didapat klien</p>
                </div>
                <button
                    type="button"
                    wire:click="addFeature"
                    class="rounded-xl border border-slate-200 bg-slate-900 px-3.5 py-2 text-xs font-bold text-white transition hover:bg-slate-800"
                >
                    + Tambah Fitur
                </button>
            </div>

            <div class="space-y-3">
                @foreach ($features as $idx => $feat)
                    <div class="flex items-center gap-3">
                        <div class="grid h-8 w-8 shrink-0 place-items-center rounded-lg bg-sky-50 text-sky-600 text-xs font-bold">
                            {{ $idx + 1 }}
                        </div>
                        <input
                            type="text"
                            wire:model="features.{{ $idx }}.text"
                            placeholder="Contoh: Responsive Design & SEO Ready"
                            class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-2.5 text-xs font-medium text-slate-900 outline-none focus:border-sky-500 focus:bg-white"
                        />
                        <button
                            type="button"
                            wire:click="removeFeature({{ $idx }})"
                            class="grid h-8 w-8 shrink-0 place-items-center rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 transition"
                        >
                            <i class="fa-solid fa-trash text-xs"></i>
                        </button>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- RELASI PORTFOLIO CATEGORIES -->
        <div class="rounded-[2.5rem] border border-slate-200/80 bg-white/90 p-6 sm:p-8 shadow-xs backdrop-blur space-y-4">
            <h2 class="text-xl font-bold text-slate-900">Kategori Portofolio Terkait</h2>
            <p class="text-xs text-slate-500">Portofolio pada kategori yang dipilih akan otomatis tampil di halaman layanan ini</p>

            <div class="grid gap-3 sm:grid-cols-3 pt-2">
                @foreach ($allCategories as $cat)
                    <label class="flex items-center gap-2.5 rounded-xl border border-slate-100 bg-slate-50/50 p-3 cursor-pointer hover:bg-slate-100/60 transition">
                        <input
                            type="checkbox"
                            value="{{ $cat->id }}"
                            wire:model="portfolio_category_ids"
                            class="rounded border-slate-300 text-sky-600 focus:ring-sky-500"
                        />
                        <span class="text-xs font-bold text-slate-800">{{ $cat->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <div class="flex justify-end pt-2">
            <button
                type="submit"
                wire:loading.attr="disabled"
                class="brand-gradient rounded-2xl px-8 py-3.5 text-sm font-bold text-white shadow-md transition hover:-translate-y-0.5"
            >
                Simpan Layanan Baru
            </button>
        </div>
    </form>
</div>
