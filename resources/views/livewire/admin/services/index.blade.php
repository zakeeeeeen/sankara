<div class="space-y-8">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="inline-flex items-center gap-2 rounded-full border border-sky-400/30 bg-sky-400/10 px-3 py-1 text-xs font-semibold text-sky-700 mb-2">
                <i class="fa-solid fa-cubes text-xs"></i>
                Services CRUD
            </div>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Kelola Layanan Bisnis</h1>
            <p class="mt-1 text-sm text-slate-500">Daftar semua layanan, fitur, dan relasi kategori portofolio</p>
        </div>

        <a
            href="{{ route('admin.services.create') }}"
            wire:navigate
            class="brand-gradient inline-flex items-center gap-2 rounded-2xl px-6 py-3.5 text-sm font-bold text-white shadow-md transition-all hover:-translate-y-0.5 hover:shadow-lg"
        >
            <i class="fa-solid fa-plus text-xs"></i>
            <span>Tambah Layanan Baru</span>
        </a>
    </div>

    @if (session('status'))
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-800">
            {{ session('status') }}
        </div>
    @endif

    <div class="rounded-[2.5rem] border border-slate-200/80 bg-white/90 p-6 sm:p-8 shadow-xs backdrop-blur space-y-6">
        <div class="flex items-center justify-between gap-4">
            <div class="relative w-full max-w-sm">
                <input
                    type="text"
                    wire:model.live="search"
                    placeholder="Cari layanan..."
                    class="w-full rounded-2xl border border-slate-200 bg-slate-50/50 px-4 py-2.5 pr-10 text-sm font-medium text-slate-900 outline-none focus:border-sky-500 focus:bg-white"
                />
                <i class="fa-solid fa-magnifying-glass absolute right-4 top-3 text-xs text-slate-400"></i>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-slate-100 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                        <th class="pb-4 pl-2">Layanan</th>
                        <th class="pb-4">Slug</th>
                        <th class="pb-4">Fitur</th>
                        <th class="pb-4">Urutan</th>
                        <th class="pb-4">Status</th>
                        <th class="pb-4 text-right pr-2">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($services as $service)
                        <tr class="group hover:bg-slate-50/50 transition">
                            <td class="py-4 pl-2 font-bold text-slate-900">
                                <div class="flex items-center gap-3">
                                    <div class="grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-sky-50 text-sky-600 font-bold text-sm">
                                        <i class="fa-solid fa-cube text-xs"></i>
                                    </div>
                                    <div>
                                        <div>{{ $service->title }}</div>
                                        <div class="text-xs font-normal text-slate-400 truncate max-w-xs">{{ $service->excerpt }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 font-mono text-xs text-slate-500">{{ $service->slug }}</td>
                            <td class="py-4 text-xs font-semibold text-slate-600">{{ $service->features_count }} Fitur</td>
                            <td class="py-4 font-semibold text-slate-600">{{ $service->sort_order }}</td>
                            <td class="py-4">
                                <button
                                    type="button"
                                    wire:click="toggleActive({{ $service->id }})"
                                    class="rounded-full px-3 py-1 text-[11px] font-bold transition {{ $service->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-500 border border-slate-200' }}"
                                >
                                    {{ $service->is_active ? 'Aktif' : 'Non-aktif' }}
                                </button>
                            </td>
                            <td class="py-4 text-right pr-2">
                                <div class="flex items-center justify-end gap-2">
                                    <a
                                        href="{{ route('admin.services.edit', $service) }}"
                                        wire:navigate
                                        class="rounded-xl border border-slate-200 bg-white px-3 py-1.5 text-xs font-bold text-slate-700 hover:bg-slate-50 transition"
                                    >
                                        Edit
                                    </a>
                                    <button
                                        type="button"
                                        wire:confirm="Yakin ingin menghapus layanan ini?"
                                        wire:click="delete({{ $service->id }})"
                                        class="rounded-xl border border-rose-200 bg-rose-50 px-3 py-1.5 text-xs font-bold text-rose-600 hover:bg-rose-100 transition"
                                    >
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-sm font-medium text-slate-400">
                                Belum ada data layanan. Klik tombol tambah di atas untuk membuat layanan baru.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
