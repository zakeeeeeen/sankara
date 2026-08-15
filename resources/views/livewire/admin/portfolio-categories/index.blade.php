<div>
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">Kategori Portofolio</h1>
            <p class="mt-1 text-sm text-slate-500">Kelola dan susun kategori untuk klasifikasi proyek portofolio.</p>
        </div>

        <div class="flex items-center gap-3">
            <button
                type="button"
                wire:click="openCreateModal"
                class="brand-gradient inline-flex items-center justify-center gap-2 rounded-2xl px-5 py-2.5 text-xs font-semibold text-white shadow-[0_18px_50px_-26px_rgba(14,165,233,0.6)] transition hover:-translate-y-0.5"
            >
                <i class="fa-solid fa-plus text-xs"></i>
                <span>Tambah Kategori</span>
            </button>
        </div>
    </div>

    @if (session('status'))
        <div class="mt-6 rounded-2xl border border-emerald-200/80 bg-emerald-50/80 px-5 py-3.5 text-xs font-semibold text-emerald-800 flex items-center gap-2">
            <i class="fa-solid fa-circle-check text-emerald-600 text-sm"></i>
            <span>{{ session('status') }}</span>
        </div>
    @endif

    <div class="mt-8 overflow-hidden rounded-[2rem] border border-slate-200/80 bg-white/95 shadow-xs backdrop-blur">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-slate-200/60 bg-slate-50/70 text-xs font-semibold uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-6 py-4">Nama Kategori</th>
                        <th class="px-6 py-4">Slug</th>
                        <th class="px-6 py-4 text-center">Urutan Tampil</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($categories as $cat)
                        <tr wire:key="cat-{{ $cat->id }}" class="text-slate-800 transition hover:bg-slate-50/60">
                            <td class="px-6 py-4 font-semibold text-slate-900">
                                <div class="flex items-center gap-3.5">
                                    <span class="grid h-10 w-10 shrink-0 place-items-center rounded-2xl bg-sky-50 text-sky-600 shadow-2xs">
                                        <i class="fa-solid fa-folder text-sm"></i>
                                    </span>
                                    <div>
                                        <div class="text-sm font-bold text-slate-900">{{ $cat->name }}</div>
                                        <div class="text-xs text-slate-400 font-normal">Portofolio Group</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-mono text-xs font-medium text-slate-500 bg-slate-100 px-2.5 py-1 rounded-lg">
                                    {{ $cat->slug }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex rounded-xl bg-sky-50 text-sky-700 px-3 py-1 text-xs font-bold">
                                    #{{ $cat->sort_order }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end items-center gap-2">
                                    <button
                                        type="button"
                                        wire:click="openEditModal({{ $cat->id }})"
                                        class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 shadow-2xs transition hover:border-sky-300 hover:text-sky-600 hover:bg-slate-50"
                                    >
                                        <i class="fa-solid fa-pen text-[10px]"></i>
                                        <span>Edit</span>
                                    </button>

                                    <button
                                        type="button"
                                        wire:click="delete({{ $cat->id }})"
                                        wire:confirm="Yakin ingin menghapus kategori ini?"
                                        class="inline-flex items-center gap-1.5 rounded-xl border border-rose-200 bg-rose-50 px-3 py-1.5 text-xs font-semibold text-rose-700 shadow-2xs transition hover:bg-rose-100"
                                    >
                                        <i class="fa-solid fa-trash-can text-[10px]"></i>
                                        <span>Hapus</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-14 text-center text-sm font-medium text-slate-400">
                                <i class="fa-solid fa-folder-open text-3xl mb-2 text-slate-300 block"></i>
                                Belum ada kategori portofolio.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- CREATE MODAL -->
    @if ($createModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="fixed inset-0 bg-slate-950/40 backdrop-blur-xs" wire:click="closeCreateModal"></div>

            <div class="relative w-full max-w-md rounded-3xl border border-slate-200 bg-white p-6 shadow-2xl transition sm:p-8">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <div>
                        <div class="text-base font-bold text-slate-900">Tambah Kategori Baru</div>
                        <div class="text-xs text-slate-400">Kategori untuk filter portofolio</div>
                    </div>
                    <button type="button" wire:click="closeCreateModal" class="flex h-8 w-8 items-center justify-center rounded-full border border-slate-200 text-slate-500 hover:bg-slate-100 transition">
                        <i class="fa-solid fa-xmark text-sm"></i>
                    </button>
                </div>

                <form class="mt-5 space-y-4" wire:submit="store">
                    <div>
                        <label class="text-xs font-bold uppercase tracking-wider text-slate-700">Nama Kategori</label>
                        <input type="text" wire:model="name" placeholder="Contoh: Web Application" class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50/60 px-4 py-3 text-sm font-medium text-slate-900 outline-none transition focus:border-sky-500 focus:bg-white focus:ring-2 focus:ring-sky-500/20" />
                        @error('name') <div class="mt-1 text-xs font-semibold text-rose-600">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <label class="text-xs font-bold uppercase tracking-wider text-slate-700">Slug (Opsional)</label>
                        <input type="text" wire:model="slug" placeholder="web-application" class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50/60 px-4 py-3 text-sm font-medium text-slate-900 outline-none transition focus:border-sky-500 focus:bg-white focus:ring-2 focus:ring-sky-500/20" />
                        @error('slug') <div class="mt-1 text-xs font-semibold text-rose-600">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <label class="text-xs font-bold uppercase tracking-wider text-slate-700">Urutan (Sort Order)</label>
                        <input type="number" wire:model="sort_order" class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50/60 px-4 py-3 text-sm font-medium text-slate-900 outline-none transition focus:border-sky-500 focus:bg-white focus:ring-2 focus:ring-sky-500/20" />
                        @error('sort_order') <div class="mt-1 text-xs font-semibold text-rose-600">{{ $message }}</div> @enderror
                    </div>

                    <div class="mt-6 flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                        <button type="button" wire:click="closeCreateModal" class="rounded-2xl border border-slate-200 px-5 py-2.5 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition">
                            Batal
                        </button>
                        <button type="submit" wire:loading.attr="disabled" class="brand-gradient rounded-2xl px-6 py-2.5 text-xs font-semibold text-white shadow-xs transition hover:-translate-y-0.5 disabled:opacity-70">
                            <span wire:loading.remove>Simpan Kategori</span>
                            <span wire:loading>Menyimpan...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- EDIT MODAL -->
    @if ($editModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="fixed inset-0 bg-slate-950/40 backdrop-blur-xs" wire:click="closeEditModal"></div>

            <div class="relative w-full max-w-md rounded-3xl border border-slate-200 bg-white p-6 shadow-2xl transition sm:p-8">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <div>
                        <div class="text-base font-bold text-slate-900">Edit Kategori</div>
                        <div class="text-xs text-slate-400">Ubah konfigurasi kategori</div>
                    </div>
                    <button type="button" wire:click="closeEditModal" class="flex h-8 w-8 items-center justify-center rounded-full border border-slate-200 text-slate-500 hover:bg-slate-100 transition">
                        <i class="fa-solid fa-xmark text-sm"></i>
                    </button>
                </div>

                <form class="mt-5 space-y-4" wire:submit="update">
                    <div>
                        <label class="text-xs font-bold uppercase tracking-wider text-slate-700">Nama Kategori</label>
                        <input type="text" wire:model="editName" class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50/60 px-4 py-3 text-sm font-medium text-slate-900 outline-none transition focus:border-sky-500 focus:bg-white focus:ring-2 focus:ring-sky-500/20" />
                        @error('editName') <div class="mt-1 text-xs font-semibold text-rose-600">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <label class="text-xs font-bold uppercase tracking-wider text-slate-700">Slug</label>
                        <input type="text" wire:model="editSlug" class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50/60 px-4 py-3 text-sm font-medium text-slate-900 outline-none transition focus:border-sky-500 focus:bg-white focus:ring-2 focus:ring-sky-500/20" />
                        @error('editSlug') <div class="mt-1 text-xs font-semibold text-rose-600">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <label class="text-xs font-bold uppercase tracking-wider text-slate-700">Urutan (Sort Order)</label>
                        <input type="number" wire:model="editSortOrder" class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50/60 px-4 py-3 text-sm font-medium text-slate-900 outline-none transition focus:border-sky-500 focus:bg-white focus:ring-2 focus:ring-sky-500/20" />
                        @error('editSortOrder') <div class="mt-1 text-xs font-semibold text-rose-600">{{ $message }}</div> @enderror
                    </div>

                    <div class="mt-6 flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                        <button type="button" wire:click="closeEditModal" class="rounded-2xl border border-slate-200 px-5 py-2.5 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition">
                            Batal
                        </button>
                        <button type="submit" wire:loading.attr="disabled" class="brand-gradient rounded-2xl px-6 py-2.5 text-xs font-semibold text-white shadow-xs transition hover:-translate-y-0.5 disabled:opacity-70">
                            <span wire:loading.remove>Update Kategori</span>
                            <span wire:loading>Menyimpan...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
