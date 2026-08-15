<div class="space-y-8">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="inline-flex items-center gap-2 rounded-full border border-emerald-400/30 bg-emerald-400/10 px-3 py-1 text-xs font-semibold text-emerald-700 mb-2">
                <i class="fa-solid fa-briefcase text-xs"></i>
                Portfolio Showcase
            </div>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Kelola Portofolio Proyek</h1>
            <p class="mt-1 text-sm text-slate-500">Daftar karya, studi kasus, mockup gambar, dan teknologi yang digunakan</p>
        </div>

        <div class="flex items-center gap-3">
            <a
                href="{{ route('admin.portfolio-categories.index') }}"
                wire:navigate
                class="rounded-2xl border border-slate-200 bg-white px-5 py-3.5 text-xs font-bold text-slate-700 shadow-xs transition hover:bg-slate-50"
            >
                Kelola Kategori
            </a>
            <a
                href="{{ route('admin.portfolios.create') }}"
                wire:navigate
                class="brand-gradient inline-flex items-center gap-2 rounded-2xl px-6 py-3.5 text-sm font-bold text-white shadow-md transition-all hover:-translate-y-0.5 hover:shadow-lg"
            >
                <i class="fa-solid fa-plus text-xs"></i>
                <span>Tambah Portofolio</span>
            </a>
        </div>
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
                    placeholder="Cari portofolio..."
                    class="w-full rounded-2xl border border-slate-200 bg-slate-50/50 px-4 py-2.5 pr-10 text-sm font-medium text-slate-900 outline-none focus:border-sky-500 focus:bg-white"
                />
                <i class="fa-solid fa-magnifying-glass absolute right-4 top-3 text-xs text-slate-400"></i>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-slate-100 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                        <th class="pb-4 pl-2">Project</th>
                        <th class="pb-4">Kategori</th>
                        <th class="pb-4">Slug</th>
                        <th class="pb-4">Status</th>
                        <th class="pb-4 text-right pr-2">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($portfolios as $portfolio)
                        <tr class="group hover:bg-slate-50/50 transition">
                            <td class="py-4 pl-2 font-bold text-slate-900">
                                <div class="flex items-center gap-3.5">
                                    <div class="h-12 w-16 shrink-0 rounded-xl overflow-hidden bg-slate-100 border border-slate-200">
                                        @if ($portfolio->preview_image_src || $portfolio->cover_image_src)
                                            <img src="{{ $portfolio->preview_image_src ?: $portfolio->cover_image_src }}" alt="{{ $portfolio->title }}" class="h-full w-full object-cover">
                                        @else
                                            <div class="h-full w-full grid place-items-center text-slate-400 text-xs">
                                                <i class="fa-solid fa-image"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-900">{{ $portfolio->title }}</div>
                                        <div class="text-xs font-normal text-slate-400 truncate max-w-xs">{{ $portfolio->excerpt }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4">
                                <div class="flex flex-wrap gap-1.5 max-w-xs">
                                    @foreach ($portfolio->categories as $cat)
                                        <span class="rounded-lg bg-sky-50 border border-sky-100 px-2 py-0.5 text-[10px] font-bold text-sky-700">
                                            {{ $cat->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="py-4 font-mono text-xs text-slate-500">{{ $portfolio->slug }}</td>
                            <td class="py-4">
                                <button
                                    type="button"
                                    wire:click="toggleActive({{ $portfolio->id }})"
                                    class="rounded-full px-3 py-1 text-[11px] font-bold transition {{ $portfolio->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-500 border border-slate-200' }}"
                                >
                                    {{ $portfolio->is_active ? 'Aktif' : 'Non-aktif' }}
                                </button>
                            </td>
                            <td class="py-4 text-right pr-2">
                                <div class="flex items-center justify-end gap-2">
                                    <a
                                        href="{{ route('admin.portfolios.edit', $portfolio) }}"
                                        wire:navigate
                                        class="rounded-xl border border-slate-200 bg-white px-3 py-1.5 text-xs font-bold text-slate-700 hover:bg-slate-50 transition"
                                    >
                                        Edit
                                    </a>
                                    <button
                                        type="button"
                                        wire:confirm="Yakin ingin menghapus portofolio ini?"
                                        wire:click="delete({{ $portfolio->id }})"
                                        class="rounded-xl border border-rose-200 bg-rose-50 px-3 py-1.5 text-xs font-bold text-rose-600 hover:bg-rose-100 transition"
                                    >
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-sm font-medium text-slate-400">
                                Belum ada data portofolio.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pt-4">
            {{ $portfolios->links() }}
        </div>
    </div>
</div>
