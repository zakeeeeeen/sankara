<div>
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">Detail Pesan Kontak</h1>
            <p class="mt-1 text-sm text-slate-500">Informasi lengkap pesan dari pengunjung website.</p>
        </div>

        <div class="flex items-center gap-3">
            <a
                href="{{ route('admin.contact-messages.index') }}"
                wire:navigate
                class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-5 py-2.5 text-xs font-semibold text-slate-700 shadow-2xs transition hover:bg-slate-50"
            >
                <i class="fa-solid fa-arrow-left text-xs"></i>
                <span>Kembali</span>
            </a>

            <button
                type="button"
                wire:click="delete"
                wire:confirm="Hapus pesan kontak ini?"
                class="inline-flex items-center gap-2 rounded-2xl border border-rose-200 bg-rose-50 px-5 py-2.5 text-xs font-semibold text-rose-700 shadow-2xs transition hover:bg-rose-100"
            >
                <i class="fa-solid fa-trash-can text-xs"></i>
                <span>Hapus Pesan</span>
            </button>
        </div>
    </div>

    <div class="mt-8 grid gap-6 lg:grid-cols-3">
        <!-- Sender Information Card -->
        <div class="rounded-[2rem] border border-slate-200/80 bg-white/95 p-6 shadow-xs backdrop-blur space-y-6">
            <div>
                <div class="text-xs font-bold uppercase tracking-wider text-slate-400">Informasi Pengirim</div>
                <div class="mt-4 flex items-center gap-3.5">
                    <div class="grid h-12 w-12 place-items-center rounded-2xl bg-sky-50 text-sky-600 font-bold text-base shadow-xs">
                        {{ substr($message->name, 0, 1) }}
                    </div>
                    <div>
                        <div class="text-base font-bold text-slate-900">{{ $message->name }}</div>
                        <div class="text-xs text-slate-400">Pengunjung Web</div>
                    </div>
                </div>
            </div>

            <div class="space-y-3.5 pt-4 border-t border-slate-100 text-xs">
                <div>
                    <span class="text-slate-400 font-medium block">Alamat Email</span>
                    <a href="mailto:{{ $message->email }}" class="font-semibold text-sky-600 hover:underline mt-0.5 inline-block">{{ $message->email }}</a>
                </div>

                <div>
                    <span class="text-slate-400 font-medium block">Nomor Telepon / WhatsApp</span>
                    <div class="font-semibold text-slate-800 mt-0.5">{{ $message->phone ?: '-' }}</div>
                </div>

                <div>
                    <span class="text-slate-400 font-medium block">Waktu Diterima</span>
                    <div class="font-semibold text-slate-800 mt-0.5">{{ $message->created_at->format('d F Y, H:i:s') }}</div>
                </div>

                <div>
                    <span class="text-slate-400 font-medium block">IP Address & User Agent</span>
                    <div class="font-mono text-[11px] text-slate-600 mt-0.5">{{ $message->ip_address ?: '-' }}</div>
                    <div class="text-[11px] text-slate-400 mt-1 truncate">{{ $message->user_agent ?: '-' }}</div>
                </div>
            </div>
        </div>

        <!-- Message Body Card -->
        <div class="lg:col-span-2 rounded-[2rem] border border-slate-200/80 bg-white/95 p-6 sm:p-8 shadow-xs backdrop-blur">
            <div class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-4">Isi Pesan</div>
            <div class="rounded-2xl border border-slate-100 bg-slate-50/60 p-6 text-sm leading-relaxed text-slate-800 whitespace-pre-line font-medium min-h-[16rem]">
                {{ $message->message }}
            </div>

            <div class="mt-6 flex flex-wrap items-center gap-3">
                <a
                    href="mailto:{{ $message->email }}?subject=Balasan Pesan - {{ config('app.name') }}"
                    class="brand-gradient inline-flex items-center gap-2 rounded-2xl px-6 py-3 text-xs font-semibold text-white shadow-sm transition hover:-translate-y-0.5"
                >
                    <i class="fa-solid fa-reply text-xs"></i>
                    <span>Balas via Email</span>
                </a>

                @if (filled($message->phone))
                    @php
                        $digits = preg_replace('/\D+/', '', $message->phone) ?: '';
                        if (str_starts_with($digits, '0')) {
                            $digits = '62' . substr($digits, 1);
                        }
                    @endphp
                    <a
                        href="https://wa.me/{{ $digits }}?text=Halo%20{{ urlencode($message->name) }}%2C%20terima%20kasih%20telah%20menghubungi%20kami."
                        target="_blank"
                        rel="noreferrer"
                        class="inline-flex items-center gap-2 rounded-2xl border border-emerald-300 bg-emerald-50 px-6 py-3 text-xs font-semibold text-emerald-800 shadow-2xs transition hover:bg-emerald-100"
                    >
                        <i class="fa-brands fa-whatsapp text-sm text-emerald-600"></i>
                        <span>Hubungi via WhatsApp</span>
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
