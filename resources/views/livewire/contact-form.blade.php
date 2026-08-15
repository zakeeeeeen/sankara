<div>
    @if ($status)
        <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 p-5 text-sm font-semibold text-emerald-900">
            <div>{{ $status }}</div>
            @if ($waLink)
                <div class="mt-3">
                    <a href="{{ $waLink }}" target="_blank" rel="noreferrer" class="agency-btn-primary inline-flex items-center justify-center px-5 py-2 text-xs font-semibold">
                        Lanjut via WhatsApp
                    </a>
                </div>
            @endif
        </div>
    @endif

    @error('rate_limit')
        <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 p-4 text-sm font-semibold text-rose-700">
            {{ $message }}
        </div>
    @enderror

    <div class="agency-card p-6 sm:p-8">
        <h3 class="text-xl font-bold text-[rgb(var(--agency-navy-1))]">Kirim Pesan</h3>
        <p class="mt-1 text-sm text-slate-500">Isi formulir di bawah ini dan tim kami akan merespons secepatnya.</p>

        <form wire:submit="submit" class="mt-6 grid gap-4">
            <input type="text" wire:model="honeypot" class="hidden" tabindex="-1" autocomplete="off" />

            <div>
                <label class="text-sm font-semibold text-slate-800">Nama Lengkap</label>
                <input
                    type="text"
                    wire:model="name"
                    placeholder="Masukkan Nama Lengkap"
                    class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-medium text-slate-900 outline-none transition focus:border-[rgb(var(--agency-cyan))] focus:bg-white focus:ring-2 focus:ring-[rgb(var(--agency-cyan)/0.2)]"
                />
                @error('name') <div class="mt-1 text-xs font-semibold text-rose-600">{{ $message }}</div> @enderror
            </div>

            <div>
                <label class="text-sm font-semibold text-slate-800">Email</label>
                <input
                    type="email"
                    wire:model="email"
                    placeholder="Masukkan Email"
                    class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-medium text-slate-900 outline-none transition focus:border-[rgb(var(--agency-cyan))] focus:bg-white focus:ring-2 focus:ring-[rgb(var(--agency-cyan)/0.2)]"
                />
                @error('email') <div class="mt-1 text-xs font-semibold text-rose-600">{{ $message }}</div> @enderror
            </div>

            <div>
                <label class="text-sm font-semibold text-slate-800">No. Telp / WhatsApp</label>
                <input
                    type="text"
                    wire:model="phone"
                    placeholder="Masukkan No. Telp"
                    class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-medium text-slate-900 outline-none transition focus:border-[rgb(var(--agency-cyan))] focus:bg-white focus:ring-2 focus:ring-[rgb(var(--agency-cyan)/0.2)]"
                />
                @error('phone') <div class="mt-1 text-xs font-semibold text-rose-600">{{ $message }}</div> @enderror
            </div>

            <div>
                <label class="text-sm font-semibold text-slate-800">Pesan Anda</label>
                <textarea
                    wire:model="message"
                    rows="5"
                    placeholder="Tulis Pesan Anda"
                    class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-medium text-slate-900 outline-none transition focus:border-[rgb(var(--agency-cyan))] focus:bg-white focus:ring-2 focus:ring-[rgb(var(--agency-cyan)/0.2)]"
                ></textarea>
                @error('message') <div class="mt-1 text-xs font-semibold text-rose-600">{{ $message }}</div> @enderror
            </div>

            <div class="pt-2">
                <button type="submit" wire:loading.attr="disabled" class="agency-btn-primary inline-flex w-full items-center justify-center gap-2 px-8 py-3.5 text-sm font-semibold disabled:opacity-70">
                    <span wire:loading.remove>Kirim Pesan Sekarang</span>
                    <span wire:loading>Mengirim...</span>
                    <i wire:loading.remove class="fa-solid fa-paper-plane text-xs"></i>
                </button>
            </div>
        </form>
    </div>
</div>
