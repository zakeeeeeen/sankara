<div class="space-y-8">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="inline-flex items-center gap-2 rounded-full border border-amber-400/30 bg-amber-400/10 px-3 py-1 text-xs font-semibold text-amber-700 mb-2">
                <i class="fa-solid fa-tags text-xs"></i>
                Pricing Management
            </div>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Kelola Paket & Harga</h1>
            <p class="mt-1 text-sm text-slate-500">Atur tier harga, fitur paket, badge populer, dan deskripsi scope layanan</p>
        </div>

        <a
            href="{{ route('admin.pricing.create') }}"
            wire:navigate
            class="brand-gradient inline-flex items-center gap-2 rounded-2xl px-6 py-3.5 text-sm font-bold text-white shadow-md transition-all hover:-translate-y-0.5 hover:shadow-lg"
        >
            <i class="fa-solid fa-plus text-xs"></i>
            <span>Tambah Paket Baru</span>
        </a>
    </div>

    @if (session('status'))
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-800">
            {{ session('status') }}
        </div>
    @endif

    <div class="rounded-[2.5rem] border border-slate-200/80 bg-white/90 p-6 sm:p-8 shadow-xs backdrop-blur space-y-6">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-slate-100 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                        <th class="pb-4 pl-2">Nama Paket</th>
                        <th class="pb-4">Harga</th>
                        <th class="pb-4">Tag</th>
                        <th class="pb-4">Fitur</th>
                        <th class="pb-4">Populer</th>
                        <th class="pb-4 text-right pr-2">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($plans as $plan)
                        <tr class="group hover:bg-slate-50/50 transition">
                            <td class="py-4 pl-2 font-bold text-slate-900">
                                <div>{{ $plan->name }}</div>
                                <div class="text-xs font-normal text-slate-400 truncate max-w-xs">{{ $plan->description }}</div>
                            </td>
                            <td class="py-4 font-bold text-slate-800">{{ $plan->price_text ?: '-' }}</td>
                            <td class="py-4 text-xs font-semibold text-slate-600">{{ $plan->tag ?: '-' }}</td>
                            <td class="py-4 text-xs font-semibold text-slate-600">{{ $plan->features->count() }} Fitur</td>
                            <td class="py-4">
                                <button
                                    type="button"
                                    wire:click="togglePopular({{ $plan->id }})"
                                    class="rounded-full px-3 py-1 text-[11px] font-bold transition {{ $plan->is_popular ? 'bg-amber-50 text-amber-700 border border-amber-200' : 'bg-slate-100 text-slate-500 border border-slate-200' }}"
                                >
                                    {{ $plan->is_popular ? 'Populer' : 'Biasa' }}
                                </button>
                            </td>
                            <td class="py-4 text-right pr-2">
                                <div class="flex items-center justify-end gap-2">
                                    <a
                                        href="{{ route('admin.pricing.edit', $plan) }}"
                                        wire:navigate
                                        class="rounded-xl border border-slate-200 bg-white px-3 py-1.5 text-xs font-bold text-slate-700 hover:bg-slate-50 transition"
                                    >
                                        Edit
                                    </a>
                                    <button
                                        type="button"
                                        wire:confirm="Yakin ingin menghapus paket harga ini?"
                                        wire:click="delete({{ $plan->id }})"
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
                                Belum ada data paket harga. Klik tombol tambah di atas untuk membuat paket baru.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
