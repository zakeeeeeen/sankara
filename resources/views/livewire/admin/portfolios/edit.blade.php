<div class="space-y-8">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <a href="{{ route('admin.portfolios.index') }}" wire:navigate class="inline-flex items-center gap-2 text-xs font-bold text-sky-600 hover:underline mb-2">
                <i class="fa-solid fa-arrow-left text-[10px]"></i>
                <span>Kembali ke Daftar Portofolio</span>
            </a>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Edit Portofolio: {{ $portfolioData['title'] }}</h1>
            <p class="mt-1 text-sm text-slate-500">Perbarui rincian proyek, mockup preview, kategori, dan sections</p>
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

    <form wire:submit="save" class="space-y-8">
        <!-- DETAIL UTAMA -->
        <div class="rounded-[2.5rem] border border-slate-200/80 bg-white/90 p-6 sm:p-8 shadow-xs backdrop-blur space-y-6">
            <h2 class="text-xl font-bold text-slate-900">1. Informasi Proyek</h2>

            <div class="grid gap-6 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700">Nama / Judul Project <span class="text-rose-500">*</span></label>
                    <input
                        type="text"
                        wire:model="portfolioData.title"
                        class="mt-1.5 w-full rounded-2xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm font-medium text-slate-900 outline-none focus:border-sky-500 focus:bg-white"
                        required
                    />
                    @error('portfolioData.title') <div class="mt-1 text-xs text-rose-600">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700">Slug (URL)</label>
                    <input
                        type="text"
                        wire:model="portfolioData.slug"
                        class="mt-1.5 w-full rounded-2xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm font-mono text-slate-900 outline-none focus:border-sky-500 focus:bg-white"
                    />
                    @error('portfolioData.slug') <div class="mt-1 text-xs text-rose-600">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700">Nama Klien / Partner</label>
                    <input
                        type="text"
                        wire:model="portfolioData.client_name"
                        class="mt-1.5 w-full rounded-2xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm font-medium text-slate-900 outline-none focus:border-sky-500 focus:bg-white"
                    />
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700">Link Live Project (URL)</label>
                    <input
                        type="text"
                        wire:model="portfolioData.project_url"
                        class="mt-1.5 w-full rounded-2xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm font-medium text-slate-900 outline-none focus:border-sky-500 focus:bg-white"
                    />
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700">Tanggal Rilis / Publish</label>
                    <input
                        type="date"
                        wire:model="portfolioData.published_at"
                        class="mt-1.5 w-full rounded-2xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm font-medium text-slate-900 outline-none focus:border-sky-500 focus:bg-white"
                    />
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700">Teknologi yang Digunakan (Pisahkan dengan koma)</label>
                    <input
                        type="text"
                        wire:model="technologiesText"
                        class="mt-1.5 w-full rounded-2xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm font-medium text-slate-900 outline-none focus:border-sky-500 focus:bg-white"
                    />
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700">Ringkasan / Excerpt Singkat</label>
                    <textarea
                        wire:model="portfolioData.excerpt"
                        rows="2"
                        class="mt-1.5 w-full rounded-2xl border border-slate-200 bg-slate-50/50 p-4 text-sm font-medium text-slate-900 outline-none focus:border-sky-500 focus:bg-white"
                    ></textarea>
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700">Deskripsi Lengkap / Overview</label>
                    <textarea
                        wire:model="portfolioData.description"
                        rows="5"
                        class="mt-1.5 w-full rounded-2xl border border-slate-200 bg-slate-50/50 p-4 text-sm font-medium text-slate-900 outline-none focus:border-sky-500 focus:bg-white leading-relaxed"
                    ></textarea>
                </div>
            </div>
        </div>

        <!-- GAMBAR & PREVIEW -->
        <div class="rounded-[2.5rem] border border-slate-200/80 bg-white/90 p-6 sm:p-8 shadow-xs backdrop-blur space-y-6">
            <h2 class="text-xl font-bold text-slate-900">2. Gambar & Mockup Portofolio</h2>

            <div class="grid gap-6 sm:grid-cols-2">
                <div class="rounded-2xl border border-slate-100 bg-slate-50/50 p-5">
                    <label class="block text-xs font-bold text-slate-700">Cover Image Utama</label>
                    <div class="mt-3 flex items-center gap-4">
                        @if ($cover_image)
                            <div class="h-20 w-32 rounded-xl overflow-hidden border border-sky-300">
                                <img src="{{ $cover_image->temporaryUrl() }}" alt="Preview" class="h-full w-full object-cover">
                            </div>
                        @elseif ($existingCoverImage)
                            <div class="h-20 w-32 rounded-xl overflow-hidden border border-slate-200">
                                <img src="{{ $existingCoverImage }}" alt="Current" class="h-full w-full object-cover">
                            </div>
                        @endif
                        <div class="flex-1">
                            <input
                                type="file"
                                wire:model="cover_image"
                                accept="image/*"
                                class="w-full text-xs text-slate-600 file:mr-3 file:rounded-xl file:border-0 file:bg-slate-900 file:px-4 file:py-2.5 file:text-xs file:font-semibold file:text-white hover:file:bg-slate-800"
                            />
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-100 bg-slate-50/50 p-5">
                    <label class="block text-xs font-bold text-slate-700">Preview Screenshot Card</label>
                    <div class="mt-3 flex items-center gap-4">
                        @if ($preview_image)
                            <div class="h-20 w-32 rounded-xl overflow-hidden border border-sky-300">
                                <img src="{{ $preview_image->temporaryUrl() }}" alt="Preview" class="h-full w-full object-cover">
                            </div>
                        @elseif ($existingPreviewImage)
                            <div class="h-20 w-32 rounded-xl overflow-hidden border border-slate-200">
                                <img src="{{ $existingPreviewImage }}" alt="Current" class="h-full w-full object-cover">
                            </div>
                        @endif
                        <div class="flex-1">
                            <input
                                type="file"
                                wire:model="preview_image"
                                accept="image/*"
                                class="w-full text-xs text-slate-600 file:mr-3 file:rounded-xl file:border-0 file:bg-slate-900 file:px-4 file:py-2.5 file:text-xs file:font-semibold file:text-white hover:file:bg-slate-800"
                            />
                        </div>
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" wire:model="portfolioData.is_active" class="rounded border-slate-300 text-sky-600 focus:ring-sky-500">
                        <span class="text-xs font-bold text-slate-800">Aktifkan Portofolio (Tampilkan ke Publik)</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- KATEGORI PORTOFOLIO -->
        <div class="rounded-[2.5rem] border border-slate-200/80 bg-white/90 p-6 sm:p-8 shadow-xs backdrop-blur space-y-4">
            <h2 class="text-xl font-bold text-slate-900">3. Kategori Portofolio</h2>
            <p class="text-xs text-slate-500">Pilih satu atau beberapa kategori untuk filter showcase</p>

            <div class="grid gap-3 sm:grid-cols-3 pt-2">
                @foreach ($allCategories as $cat)
                    <label class="flex items-center gap-2.5 rounded-xl border border-slate-100 bg-slate-50/50 p-3 cursor-pointer hover:bg-slate-100/60 transition">
                        <input
                            type="checkbox"
                            value="{{ $cat->id }}"
                            wire:model="categories"
                            class="rounded border-slate-300 text-sky-600 focus:ring-sky-500"
                        />
                        <span class="text-xs font-bold text-slate-800">{{ $cat->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- SECTIONS TAMBAHAN -->
        <div class="rounded-[2.5rem] border border-slate-200/80 bg-white/90 p-6 sm:p-8 shadow-xs backdrop-blur space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-slate-900">4. Section Detail & Fitur Project</h2>
                    <p class="text-xs text-slate-500">Blok konten fitur atau penjelasan detail pada halaman portofolio</p>
                </div>
                <button
                    type="button"
                    wire:click="addSection"
                    class="rounded-xl border border-slate-200 bg-slate-900 px-3.5 py-2 text-xs font-bold text-white transition hover:bg-slate-800"
                >
                    + Tambah Section
                </button>
            </div>

            <div class="space-y-4">
                @foreach ($sections as $idx => $sec)
                    <div class="rounded-2xl border border-slate-100 bg-slate-50/60 p-5 space-y-3">
                        <div class="flex items-center justify-between gap-4">
                            <div class="flex-1">
                                <label class="block text-[11px] font-bold text-slate-600">Judul Section / Fitur</label>
                                <input
                                    type="text"
                                    wire:model="sections.{{ $idx }}.heading"
                                    class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs font-bold text-slate-900 outline-none focus:border-sky-500"
                                />
                            </div>
                            <div>
                                <button
                                    type="button"
                                    wire:click="removeSection({{ $idx }})"
                                    class="grid h-9 w-9 place-items-center rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-100 transition"
                                >
                                    <i class="fa-solid fa-trash text-xs"></i>
                                </button>
                            </div>
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-slate-600">Isi Penjelasan Section</label>
                            <textarea
                                wire:model="sections.{{ $idx }}.body"
                                rows="3"
                                class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs font-medium text-slate-900 outline-none focus:border-sky-500"
                            ></textarea>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="flex justify-end pt-2">
            <button
                type="submit"
                wire:loading.attr="disabled"
                class="brand-gradient rounded-2xl px-8 py-3.5 text-sm font-bold text-white shadow-md transition hover:-translate-y-0.5"
            >
                Simpan Perubahan Portofolio
            </button>
        </div>
    </form>
</div>
