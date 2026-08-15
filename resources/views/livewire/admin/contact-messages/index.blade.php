<div>
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">Pesan Kontak</h1>
            <p class="mt-1 text-sm text-slate-500">Daftar pertanyaan dan penawaran dari form kontak website.</p>
        </div>

        <div class="w-full sm:w-72">
            <div class="relative">
                <input
                    type="text"
                    wire:model.live.debounce.300ms="search"
                    placeholder="Cari nama, email, isi pesan..."
                    class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-2.5 pl-10 text-xs font-medium text-slate-900 outline-none transition focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 shadow-2xs"
                />
                <span class="pointer-events-none absolute inset-y-0 left-3.5 flex items-center text-slate-400">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </span>
            </div>
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
                        <th class="px-6 py-4">Pengirim</th>
                        <th class="px-6 py-4">Kontak</th>
                        <th class="px-6 py-4">Cuplikan Pesan</th>
                        <th class="px-6 py-4">Waktu</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($messages as $msg)
                        <tr wire:key="msg-{{ $msg->id }}" class="text-slate-800 transition hover:bg-slate-50/60">
                            <td class="px-6 py-4 font-semibold text-slate-900">
                                <div class="flex items-center gap-3">
                                    <div class="grid h-9 w-9 shrink-0 place-items-center rounded-xl bg-sky-50 text-sky-600 font-bold text-xs">
                                        {{ substr($msg->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-slate-900">{{ $msg->name }}</div>
                                        <div class="text-xs text-slate-400 font-normal">IP: {{ $msg->ip_address ?: '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-xs font-medium text-slate-900">{{ $msg->email }}</div>
                                <div class="text-xs text-slate-400 mt-0.5">{{ $msg->phone ?: '-' }}</div>
                            </td>
                            <td class="px-6 py-4 max-w-xs">
                                <div class="text-xs text-slate-600 truncate font-normal">
                                    {{ $msg->message }}
                                </div>
                            </td>
                            <td class="px-6 py-4 text-xs font-medium text-slate-500 whitespace-nowrap">
                                {{ $msg->created_at->format('d M Y, H:i') }}
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <div class="flex justify-end items-center gap-2">
                                    <a
                                        href="{{ route('admin.contact-messages.show', $msg) }}"
                                        wire:navigate
                                        class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 shadow-2xs transition hover:border-sky-300 hover:text-sky-600 hover:bg-slate-50"
                                    >
                                        <i class="fa-solid fa-eye text-[10px]"></i>
                                        <span>Detail</span>
                                    </a>

                                    <button
                                        type="button"
                                        wire:click="delete({{ $msg->id }})"
                                        wire:confirm="Hapus pesan kontak ini?"
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
                            <td colspan="5" class="px-6 py-14 text-center text-sm font-medium text-slate-400">
                                <i class="fa-solid fa-envelope-open-text text-3xl mb-2 text-slate-300 block"></i>
                                Belum ada pesan kontak yang cocok.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($messages->hasPages())
            <div class="border-t border-slate-200/80 bg-slate-50/50 p-4">
                {{ $messages->links() }}
            </div>
        @endif
    </div>
</div>
