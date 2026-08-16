<div class="space-y-8">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="inline-flex items-center gap-2 rounded-full border border-sky-400/30 bg-sky-400/10 px-3 py-1 text-xs font-semibold text-sky-700 mb-2">
                <i class="fa-solid fa-address-card text-xs"></i>
                Page Management
            </div>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Edit Halaman: Tentang Kami</h1>
            <p class="mt-1 text-sm text-slate-500">Kelola judul hero, pengantar, deskripsi lengkap, dan foto profil perusahaan</p>
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
        <div class="rounded-[2.5rem] border border-slate-200/80 bg-white/90 p-6 sm:p-8 shadow-xs backdrop-blur">
            <div class="grid gap-6 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700">Nama Halaman (Browser Title) <span class="text-rose-500">*</span></label>
                    <input
                        type="text"
                        wire:model="title"
                        class="mt-1.5 w-full rounded-2xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm font-medium text-slate-900 outline-none focus:border-sky-500 focus:bg-white"
                        required
                    />
                    @error('title') <div class="mt-1 text-xs text-rose-600">{{ $message }}</div> @enderror
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700">Hero Title (Judul Banner)</label>
                    <input
                        type="text"
                        wire:model="hero_title"
                        class="mt-1.5 w-full rounded-2xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm font-medium text-slate-900 outline-none focus:border-sky-500 focus:bg-white"
                        placeholder="Tentang Kami"
                    />
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700">Hero Subtitle / Pengantar Singkat</label>
                    <textarea
                        wire:model="hero_subtitle"
                        rows="2"
                        class="mt-1.5 w-full rounded-2xl border border-slate-200 bg-slate-50/50 p-4 text-sm font-medium text-slate-900 outline-none focus:border-sky-500 focus:bg-white"
                    ></textarea>
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700">Konten Utama Halaman (Body)</label>
                    <textarea
                        wire:model="body"
                        rows="8"
                        class="mt-1.5 w-full rounded-2xl border border-slate-200 bg-slate-50/50 p-4 text-sm font-medium text-slate-900 outline-none focus:border-sky-500 focus:bg-white leading-relaxed"
                    ></textarea>
                </div>

                <div class="sm:col-span-2 rounded-2xl border border-slate-100 bg-slate-50/50 p-5">
                    <label class="block text-xs font-bold text-slate-700">Foto / Gambar Perusahaan</label>
                    <div class="mt-4 flex items-center gap-6">
                        @if ($image)
                            <div class="h-24 w-36 rounded-xl overflow-hidden border border-sky-300">
                                <img src="{{ $image->temporaryUrl() }}" alt="Preview" class="h-full w-full object-cover">
                            </div>
                        @elseif ($existingImage)
                            <div class="h-24 w-36 rounded-xl overflow-hidden border border-slate-200">
                                <img src="{{ $existingImage }}" alt="Current" class="h-full w-full object-cover">
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
            </div>
        </div>
    </form>
</div>
