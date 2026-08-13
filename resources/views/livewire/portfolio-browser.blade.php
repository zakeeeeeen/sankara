<div>
    <div class="space-y-4">
        <div class="w-full">
            <div class="relative">
                <input
                    wire:model.live="search"
                    type="text"
                    placeholder="Cari project..."
                    class="w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 pr-12 text-sm font-medium text-slate-800 shadow-sm backdrop-blur outline-none transition focus:border-[rgb(var(--brand-from-rgb)/0.55)]"
                />
                <div class="pointer-events-none absolute inset-y-0 right-4 grid place-items-center text-slate-400">
                    <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5">
                        <path d="M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z" stroke="currentColor" stroke-width="1.8"/>
                        <path d="M16.5 16.5 21 21" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="no-scrollbar -mx-4 flex gap-2 overflow-x-auto px-4 pb-1 sm:mx-0 sm:px-0">
            <button
                type="button"
                wire:click="$set('category','all')"
                class="shrink-0 rounded-full px-4 py-2 text-sm font-semibold shadow-sm backdrop-blur transition {{ $category === 'all' ? 'brand-gradient text-white shadow-[0_18px_40px_-26px_rgba(16,185,129,0.45)]' : 'border border-slate-200/70 bg-white/70 text-slate-700 hover:bg-white' }}"
            >
                Semua
            </button>
            @foreach ($categories as $cat)
                <button
                    type="button"
                    wire:click="$set('category','{{ $cat->slug }}')"
                    class="shrink-0 rounded-full px-4 py-2 text-sm font-semibold shadow-sm backdrop-blur transition {{ $category === $cat->slug ? 'brand-gradient text-white shadow-[0_18px_40px_-26px_rgba(16,185,129,0.45)]' : 'border border-slate-200/70 bg-white/70 text-slate-700 hover:bg-white' }}"
                >
                    {{ $cat->name }}
                </button>
            @endforeach
        </div>
    </div>

    <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @forelse ($portfolios as $portfolio)
            <a
                href="{{ route('portfolios.show', $portfolio->slug) }}"
                class="group relative overflow-hidden rounded-3xl border border-slate-200/70 bg-white/70 shadow-sm backdrop-blur transition hover:-translate-y-1 hover:bg-white"
            >
                <div class="relative overflow-hidden">
                    @if ($portfolio->preview_image_src)
                        <div data-hover-shot class="no-scrollbar aspect-[4/3] overflow-y-auto overscroll-contain">
                            <img class="w-full" src="{{ $portfolio->preview_image_src }}" alt="Preview {{ $portfolio->title }}" />
                        </div>
                    @else
                        <div class="brand-gradient-br-soft aspect-[4/3] w-full"></div>
                    @endif
                    <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-white via-white/40 to-transparent opacity-0 transition duration-300 group-hover:opacity-100"></div>
                </div>

                <div class="p-6">
                    <div class="text-base font-semibold text-slate-900">{{ $portfolio->title }}</div>
                    @if ($portfolio->excerpt)
                        <div class="mt-2 text-sm leading-relaxed text-slate-600">{{ $portfolio->excerpt }}</div>
                    @endif

                    <div class="mt-4 flex flex-wrap gap-2">
                        @foreach ($portfolio->categories->take(3) as $cat)
                            <span class="rounded-full border border-slate-200/70 bg-white/70 px-3 py-1 text-xs font-semibold text-slate-700 shadow-sm backdrop-blur">
                                {{ $cat->name }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </a>
        @empty
            <div class="rounded-3xl border border-slate-200/70 bg-white/70 p-10 text-center shadow-sm backdrop-blur sm:col-span-2 lg:col-span-3">
                <div class="text-base font-semibold text-slate-900">Belum ada project untuk filter ini.</div>
                <div class="mt-2 text-sm leading-relaxed text-slate-600">Coba ganti kategori atau gunakan pencarian untuk menemukan project yang relevan.</div>
                <button type="button" wire:click="$set('category','all')" class="mt-6 inline-flex items-center justify-center rounded-2xl border border-slate-200/70 bg-white/80 px-5 py-2.5 text-sm font-semibold text-slate-800 shadow-sm backdrop-blur transition hover:-translate-y-0.5 hover:bg-white">
                    Reset Filter
                </button>
            </div>
        @endforelse
    </div>

    <div class="mt-10">
        {{ $portfolios->links() }}
    </div>
</div>

