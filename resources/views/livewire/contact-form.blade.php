<div>
    @if ($status)
        <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 p-5 text-sm font-semibold text-emerald-900" role="alert">
            <div>{{ $status }}</div>
            @if ($waLink)
                <div class="mt-3">
                    <a href="{{ $waLink }}" target="_blank" rel="noreferrer" class="inline-flex items-center justify-center rounded-full bg-emerald-600 px-5 py-2 text-xs font-bold text-white shadow-sm transition hover:bg-emerald-700" aria-label="Lanjut chat via WhatsApp">
                        Lanjut via WhatsApp
                    </a>
                </div>
            @endif
        </div>
    @endif

    @error('rate_limit')
        <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 p-4 text-sm font-semibold text-rose-800" role="alert">
            {{ $message }}
        </div>
    @enderror

    <div class="agency-card p-6 sm:p-8">
        <h3 class="text-xl font-bold text-[rgb(var(--agency-navy-1))]">Kirim Pesan</h3>
        <p class="mt-1 text-sm text-slate-600">Isi formulir di bawah ini dan tim kami akan merespons secepatnya.</p>

        <form wire:submit="submit" class="mt-6 grid gap-4">
            <input type="text" wire:model="honeypot" class="hidden" tabindex="-1" autocomplete="off" aria-hidden="true" />

            <div>
                <label for="contact-name" class="text-sm font-semibold text-slate-800">Nama Lengkap</label>
                <input
                    id="contact-name"
                    type="text"
                    wire:model="name"
                    placeholder="Masukkan Nama Lengkap"
                    class="mt-2 w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm font-medium text-slate-900 outline-none transition focus:border-sky-600 focus:bg-white focus:ring-2 focus:ring-sky-500/20"
                    required
                />
                @error('name') <div class="mt-1 text-xs font-semibold text-rose-700">{{ $message }}</div> @enderror
            </div>

            <div>
                <label for="contact-email" class="text-sm font-semibold text-slate-800">Email</label>
                <input
                    id="contact-email"
                    type="email"
                    wire:model="email"
                    placeholder="Masukkan Email"
                    class="mt-2 w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm font-medium text-slate-900 outline-none transition focus:border-sky-600 focus:bg-white focus:ring-2 focus:ring-sky-500/20"
                    required
                />
                @error('email') <div class="mt-1 text-xs font-semibold text-rose-700">{{ $message }}</div> @enderror
            </div>

            <div>
                <label for="contact-phone" class="text-sm font-semibold text-slate-800">No. Telp / WhatsApp</label>
                <input
                    id="contact-phone"
                    type="tel"
                    wire:model="phone"
                    placeholder="Masukkan No. Telp"
                    class="mt-2 w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm font-medium text-slate-900 outline-none transition focus:border-sky-600 focus:bg-white focus:ring-2 focus:ring-sky-500/20"
                />
                @error('phone') <div class="mt-1 text-xs font-semibold text-rose-700">{{ $message }}</div> @enderror
            </div>

            <div>
                <label for="contact-message" class="text-sm font-semibold text-slate-800">Pesan Anda</label>
                <textarea
                    id="contact-message"
                    wire:model="message"
                    rows="5"
                    placeholder="Tulis Pesan Anda"
                    class="mt-2 w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm font-medium text-slate-900 outline-none transition focus:border-sky-600 focus:bg-white focus:ring-2 focus:ring-sky-500/20"
                    required
                ></textarea>
                @error('message') <div class="mt-1 text-xs font-semibold text-rose-700">{{ $message }}</div> @enderror
            </div>

            <div class="pt-2">
                <button type="submit" wire:loading.attr="disabled" class="inline-flex w-full items-center justify-center gap-2 rounded-full bg-sky-600 px-8 py-3.5 text-sm font-bold text-white shadow-lg shadow-sky-600/20 transition-all duration-300 hover:-translate-y-0.5 hover:bg-sky-700 disabled:opacity-70" aria-label="Kirim Formulir Kontak">
                    <span wire:loading.remove>Kirim Pesan Sekarang</span>
                    <span wire:loading>Mengirim...</span>
                    <i wire:loading.remove class="fa-solid fa-paper-plane text-xs" aria-hidden="true"></i>
                </button>
            </div>
        </form>
    </div>
</div>
