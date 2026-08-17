<div
    x-data="{
        show: false,
        type: 'success',
        title: 'Berhasil!',
        message: '',
        timer: null,
        notify(msg, t = 'success') {
            if (!msg) return;
            this.message = msg;
            this.type = t;
            this.title = t === 'error' ? 'Gagal' : 'Berhasil disimpan!';
            this.show = true;
            clearTimeout(this.timer);
            this.timer = setTimeout(() => { this.show = false; }, 4500);
        }
    }"
    x-init="
        @if (session('status') || session('success'))
            $nextTick(() => notify(@js(session('status') ?: session('success')), 'success'));
        @elseif (session('error'))
            $nextTick(() => notify(@js(session('error')), 'error'));
        @endif

        window.addEventListener('notify', (e) => {
            const detail = e.detail || {};
            const msg = typeof detail === 'string' ? detail : (detail.message || detail[0]?.message || 'Perubahan berhasil disimpan');
            const type = detail.type || detail[0]?.type || 'success';
            notify(msg, type);
        });

        if (typeof Livewire !== 'undefined') {
            Livewire.on('notify', (data) => {
                const msg = typeof data === 'string' ? data : (data.message || data[0]?.message || 'Perubahan berhasil disimpan');
                const type = data.type || data[0]?.type || 'success';
                notify(msg, type);
            });
        }
    "
    x-show="show"
    x-transition:enter="transition ease-out duration-300 transform"
    x-transition:enter-start="opacity-0 translate-y-[-20px] scale-95"
    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
    x-transition:leave="transition ease-in duration-200 transform"
    x-transition:leave-start="opacity-100 translate-y-0 scale-100"
    x-transition:leave-end="opacity-0 translate-y-[-20px] scale-95"
    x-cloak
    class="fixed top-5 right-5 z-[9999] max-w-md w-full px-4 sm:px-0 pointer-events-auto"
    style="display: none;"
>
    <div
        :class="type === 'error'
            ? 'border-rose-200 bg-white/95 text-slate-900 shadow-[0_20px_50px_-10px_rgba(244,63,94,0.3)]'
            : 'border-emerald-200 bg-white/95 text-slate-900 shadow-[0_20px_50px_-10px_rgba(16,185,129,0.3)]'"
        class="flex items-start gap-3.5 rounded-2xl border p-4 shadow-2xl backdrop-blur-xl transition-all duration-300"
    >
        <div
            :class="type === 'error' ? 'bg-rose-100 text-rose-600' : 'bg-emerald-100 text-emerald-600'"
            class="grid h-10 w-10 shrink-0 place-items-center rounded-xl font-bold text-base shadow-inner"
        >
            <template x-if="type === 'error'">
                <i class="fa-solid fa-circle-exclamation"></i>
            </template>
            <template x-if="type !== 'error'">
                <i class="fa-solid fa-circle-check"></i>
            </template>
        </div>

        <div class="flex-1 min-w-0 pr-1 pt-0.5">
            <div
                :class="type === 'error' ? 'text-rose-600' : 'text-emerald-600'"
                class="text-xs font-bold uppercase tracking-wider"
                x-text="title"
            ></div>
            <div class="mt-0.5 text-xs sm:text-sm font-semibold leading-snug text-slate-800 break-words" x-text="message"></div>
        </div>

        <button
            type="button"
            @click="show = false"
            class="shrink-0 text-slate-400 hover:text-slate-700 p-1 rounded-lg hover:bg-slate-100 transition-colors"
            aria-label="Tutup notifikasi"
        >
            <i class="fa-solid fa-xmark text-sm"></i>
        </button>
    </div>
</div>
