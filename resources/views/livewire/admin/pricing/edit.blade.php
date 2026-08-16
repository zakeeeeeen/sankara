<div class="space-y-8">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <a href="{{ route('admin.pricing.index') }}" wire:navigate class="inline-flex items-center gap-2 text-xs font-bold text-sky-600 hover:underline mb-2">
                <i class="fa-solid fa-arrow-left text-[10px]"></i>
                <span>Kembali ke Daftar Paket Harga</span>
            </a>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Edit Paket: {{ $planData['name'] }}</h1>
            <p class="mt-1 text-sm text-slate-500">Perbarui harga, deskripsi, tag, dan daftar benefit paket</p>
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
        <div class="rounded-[2.5rem] border border-slate-200/80 bg-white/90 p-6 sm:p-8 shadow-xs backdrop-blur space-y-6">
            <h2 class="text-xl font-bold text-slate-900">Informasi Paket</h2>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label class="block text-xs font-bold text-slate-700">Nama Paket</label>
                    <input
                        type="text"
                        wire:model="planData.name"
                        class="mt-1.5 w-full rounded-2xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm font-medium text-slate-900 outline-none focus:border-sky-500 focus:bg-white"
                        required
                    />
                    @error('planData.name') <div class="mt-1 text-xs text-rose-600">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700">Tag / Keterangan Tag</label>
                    <input
                        type="text"
                        wire:model="planData.tag"
                        class="mt-1.5 w-full rounded-2xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm font-medium text-slate-900 outline-none focus:border-sky-500 focus:bg-white"
                    />
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700">Teks Harga</label>
                    <input
                        type="text"
                        wire:model="planData.price_text"
                        class="mt-1.5 w-full rounded-2xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm font-bold text-slate-900 outline-none focus:border-sky-500 focus:bg-white"
                    />
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700">Urutan Tampil (Sort Order)</label>
                    <input
                        type="number"
                        wire:model="planData.sort_order"
                        class="mt-1.5 w-full rounded-2xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm font-medium text-slate-900 outline-none focus:border-sky-500 focus:bg-white"
                    />
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700">Deskripsi Singkat Paket</label>
                    <textarea
                        wire:model="planData.description"
                        rows="3"
                        class="mt-1.5 w-full rounded-2xl border border-slate-200 bg-slate-50/50 p-4 text-sm font-medium text-slate-900 outline-none focus:border-sky-500 focus:bg-white"
                    ></textarea>
                </div>

                <div class="sm:col-span-2">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" wire:model="planData.is_popular" class="rounded border-slate-300 text-sky-600 focus:ring-sky-500">
                        <span class="text-xs font-bold text-slate-800">Tandai sebagai Paket Terpopuler (Featured Card)</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- FITUR-FITUR PAKET -->
        <div class="rounded-[2.5rem] border border-slate-200/80 bg-white/90 p-6 sm:p-8 shadow-xs backdrop-blur space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-slate-900">Fitur & Benefit Paket</h2>
                    <p class="text-xs text-slate-500">Daftar checklist benefit yang didapat customer</p>
                </div>
                <button
                    type="button"
                    wire:click="addFeature"
                    class="rounded-xl border border-slate-200 bg-slate-900 px-3.5 py-2 text-xs font-bold text-white transition hover:bg-slate-800"
                >
                    + Tambah Benefit
                </button>
            </div>

            <div class="space-y-3">
                @foreach ($features as $idx => $feat)
                    <div class="flex items-center gap-3">
                        <div class="grid h-8 w-8 shrink-0 place-items-center rounded-lg bg-emerald-50 text-emerald-600 text-xs font-bold">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <input
                            type="text"
                            wire:model="features.{{ $idx }}.text"
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

        <div class="flex justify-end pt-2">
            <button
                type="submit"
                wire:loading.attr="disabled"
                class="brand-gradient rounded-2xl px-8 py-3.5 text-sm font-bold text-white shadow-md transition hover:-translate-y-0.5"
            >
                Simpan Perubahan Paket
            </button>
        </div>
    </form>
</div>
