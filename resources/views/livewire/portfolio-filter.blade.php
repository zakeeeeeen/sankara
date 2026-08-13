<div class="space-y-6">
    <div class="flex flex-wrap items-center gap-2">
        @foreach ($categories as $cat)
            @php $active = $category === $cat; @endphp
            <button
                type="button"
                wire:click="setCategory('{{ $cat }}')"
                class="rounded-2xl px-4 py-2 text-sm font-semibold transition hover:-translate-y-0.5 {{ $active ? 'brand-gradient text-white shadow-[0_14px_40px_-24px_rgb(var(--brand-to-rgb)/0.6)]' : 'border border-slate-200/70 bg-white/70 text-slate-700 shadow-sm backdrop-blur hover:bg-white' }}"
            >
                {{ $cat }}
            </button>
        @endforeach
    </div>

    <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($this->filteredProjects as $project)
            <div class="brand-gradient-br group rounded-3xl p-px transition hover:-translate-y-1">
                <div class="flex h-full flex-col overflow-hidden rounded-3xl border border-white/60 bg-white/60 shadow-sm backdrop-blur-xl transition group-hover:bg-white">
                    <div class="relative aspect-[16/10] overflow-hidden">
                        <img
                            class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.04]"
                            alt="Preview project {{ $project['title'] }}"
                            src="{{ $imgBase . '?prompt=' . rawurlencode($project['prompt']) . '&image_size=' . $project['size'] }}"
                        />
                        <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-slate-950/45 via-slate-950/0 to-transparent opacity-0 transition group-hover:opacity-100"></div>
                        <div class="absolute left-4 top-4">
                            <div class="rounded-full border border-white/30 bg-white/15 px-3 py-1 text-xs font-semibold text-white backdrop-blur">
                                {{ $project['category'] }}
                            </div>
                        </div>
                        <div class="absolute bottom-4 left-4 right-4 opacity-0 transition group-hover:opacity-100">
                            <div class="flex items-center justify-between gap-3">
                                <div class="text-sm font-semibold text-white">{{ $project['title'] }}</div>
                                <div class="grid h-9 w-9 place-items-center rounded-2xl bg-white/15 text-white backdrop-blur">
                                    <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5">
                                        <path d="M5 12h12" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                        <path d="M13 6l6 6-6 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-1 flex-col p-6">
                        <div class="text-lg font-semibold text-slate-900">{{ $project['title'] }}</div>
                        <div class="mt-2 text-sm leading-relaxed text-slate-600">{{ $project['desc'] }}</div>

                        <div class="mt-5 flex flex-wrap gap-2">
                            @foreach ($project['stack'] as $tag)
                                <span class="rounded-full border border-slate-200/70 bg-white/70 px-3 py-1 text-xs font-semibold text-slate-700 shadow-sm backdrop-blur">
                                    {{ $tag }}
                                </span>
                            @endforeach
                        </div>

                        <div class="text-brand mt-6 inline-flex items-center gap-2 text-sm font-semibold">
                            Lihat detail
                            <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5">
                                <path d="M5 12h12" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                <path d="M13 6l6 6-6 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
