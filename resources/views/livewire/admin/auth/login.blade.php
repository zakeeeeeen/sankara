<div class="mx-auto max-w-md py-12">
    <div class="rounded-[2.5rem] border border-slate-200/80 bg-white/90 p-8 sm:p-10 shadow-xl backdrop-blur-xl">
        <div class="text-center">
            <div class="mx-auto mb-4 grid h-14 w-14 place-items-center rounded-2xl bg-sky-50 text-sky-600 shadow-inner">
                <i class="fa-solid fa-lock text-xl"></i>
            </div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Login Administrator</h1>
            <p class="mt-1 text-xs text-slate-500">
                Masuk untuk mengelola seluruh konten dan pengaturan website
            </p>
        </div>

        <form wire:submit="login" class="mt-8 space-y-4">
            <div>
                <label class="text-xs font-bold text-slate-700" for="email">Email</label>
                <input
                    id="email"
                    wire:model="email"
                    type="email"
                    placeholder="admin@sankaratech.test"
                    class="mt-1.5 w-full rounded-2xl border border-slate-200 bg-slate-50/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-inner outline-none transition focus:border-sky-500 focus:bg-white focus:ring-2 focus:ring-sky-500/20"
                    required
                    autofocus
                />
                @error('email')
                    <div class="mt-1.5 text-xs font-semibold text-rose-600">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="text-xs font-bold text-slate-700" for="password">Password</label>
                <input
                    id="password"
                    wire:model="password"
                    type="password"
                    placeholder="••••••••"
                    class="mt-1.5 w-full rounded-2xl border border-slate-200 bg-slate-50/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-inner outline-none transition focus:border-sky-500 focus:bg-white focus:ring-2 focus:ring-sky-500/20"
                    required
                />
                @error('password')
                    <div class="mt-1.5 text-xs font-semibold text-rose-600">{{ $message }}</div>
                @enderror
            </div>

            <div class="flex items-center justify-between text-xs font-medium pt-1">
                <label class="flex items-center gap-2 text-slate-600 cursor-pointer">
                    <input type="checkbox" wire:model="remember" class="rounded border-slate-300 text-sky-600 focus:ring-sky-500">
                    <span>Ingat saya di perangkat ini</span>
                </label>
            </div>

            <button
                type="submit"
                wire:loading.attr="disabled"
                class="brand-gradient w-full rounded-2xl py-3.5 text-sm font-bold text-white shadow-md transition-all hover:-translate-y-0.5 hover:shadow-lg disabled:opacity-70 mt-2"
            >
                <span wire:loading.remove>Masuk ke Dashboard</span>
                <span wire:loading>Memproses...</span>
            </button>

        </form>
    </div>
</div>
