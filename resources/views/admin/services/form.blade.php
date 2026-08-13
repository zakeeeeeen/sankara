@extends('layouts.admin')

@section('title', ($service->exists ? 'Edit' : 'Tambah') . ' Layanan - Admin Sankara Tech')

@section('content')
    <div class="reveal flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="text-3xl font-semibold tracking-tight text-slate-900">{{ $service->exists ? 'Edit Layanan' : 'Tambah Layanan' }}</h1>
            <p class="mt-2 text-base leading-relaxed text-slate-600">Konten layanan akan tampil di landing dan halaman /layanan.</p>
        </div>

        <a href="{{ route('admin.services.index') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-200/70 bg-white/70 px-5 py-2.5 text-sm font-semibold text-slate-800 shadow-sm backdrop-blur transition hover:-translate-y-0.5 hover:bg-white">
            Kembali
        </a>
    </div>

    <form class="mt-10 space-y-10" method="POST" action="{{ $service->exists ? route('admin.services.update', $service) : route('admin.services.store') }}" enctype="multipart/form-data">
        @csrf
        @if ($service->exists)
            @method('PUT')
        @endif

        <div class="rounded-[2rem] border border-slate-200/70 bg-white/70 p-6 shadow-sm backdrop-blur sm:p-8">
            <div class="grid gap-5 lg:grid-cols-2">
                <div>
                    <label class="text-sm font-semibold text-slate-800">Title</label>
                    <input name="service[title]" value="{{ old('service.title', $service->title) }}" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300" required />
                    @error('service.title') <div class="mt-2 text-sm font-semibold text-rose-600">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-800">Slug (optional)</label>
                    <input name="service[slug]" value="{{ old('service.slug', $service->slug) }}" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300" />
                    @error('service.slug') <div class="mt-2 text-sm font-semibold text-rose-600">{{ $message }}</div> @enderror
                </div>
                <div class="lg:col-span-2">
                    <label class="text-sm font-semibold text-slate-800">Excerpt</label>
                    <textarea name="service[excerpt]" rows="3" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300">{{ old('service.excerpt', $service->excerpt) }}</textarea>
                </div>
                <div class="lg:col-span-2">
                    <label class="text-sm font-semibold text-slate-800">Description</label>
                    <textarea name="service[description]" rows="5" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300">{{ old('service.description', $service->description) }}</textarea>
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-800">CTA Label</label>
                    <input name="service[cta_label]" value="{{ old('service.cta_label', $service->cta_label) }}" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300" />
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-800">Image URL (optional)</label>
                    <input name="service[image_url]" value="{{ old('service.image_url', $service->image_url) }}" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300" />
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-800">Upload Image (optional)</label>
                    <input type="file" name="service[image]" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur" />
                    @if ($service->image_src)
                        <div class="mt-3 text-xs font-semibold text-slate-600">Current: {{ $service->image_src }}</div>
                    @endif
                </div>
                <div class="grid gap-3 sm:grid-cols-2">
                    <div>
                        <label class="text-sm font-semibold text-slate-800">Sort Order</label>
                        <input type="number" name="service[sort_order]" value="{{ old('service.sort_order', $service->sort_order ?? 0) }}" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300" />
                    </div>
                    <div class="flex items-end gap-3">
                        <input type="hidden" name="service[is_active]" value="0" />
                        <label class="flex items-center gap-3 rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-semibold text-slate-800 shadow-sm backdrop-blur">
                            <input type="checkbox" name="service[is_active]" value="1" class="h-4 w-4 rounded border-slate-300 text-emerald-600" {{ old('service.is_active', $service->is_active) ? 'checked' : '' }} />
                            Active
                        </label>
                    </div>
                </div>
            </div>
        </div>

        @php
            $selectedCategoryIds = collect(old(
                'portfolio_category_ids',
                $service->exists ? $service->portfolioCategories->pluck('id')->all() : []
            ))->map(fn ($v) => (int) $v)->all();
        @endphp

        <div class="rounded-[2rem] border border-slate-200/70 bg-white/70 p-6 shadow-sm backdrop-blur sm:p-8">
            <div class="text-lg font-semibold text-slate-900">Kategori Portofolio Terkait</div>
            <p class="mt-2 text-sm leading-relaxed text-slate-600">Portofolio terkait akan muncul di halaman detail layanan berdasarkan kategori ini.</p>

            <div class="mt-6 flex flex-wrap gap-2">
                @foreach (($categories ?? []) as $cat)
                    <label class="inline-flex cursor-pointer items-center gap-2 rounded-full border border-slate-200/70 bg-white/70 px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm backdrop-blur transition hover:bg-white">
                        <input
                            type="checkbox"
                            name="portfolio_category_ids[]"
                            value="{{ $cat->id }}"
                            class="h-4 w-4 rounded border-slate-300 text-emerald-600"
                            {{ in_array($cat->id, $selectedCategoryIds, true) ? 'checked' : '' }}
                        />
                        {{ $cat->name }}
                    </label>
                @endforeach
            </div>

            @error('portfolio_category_ids') <div class="mt-3 text-sm font-semibold text-rose-600">{{ $message }}</div> @enderror
            @error('portfolio_category_ids.*') <div class="mt-3 text-sm font-semibold text-rose-600">{{ $message }}</div> @enderror
        </div>

        @php
            $featuresValue = old('features', $service->exists ? $service->features->map(fn ($f) => ['text' => $f->text])->all() : []);
        @endphp

        <div class="rounded-[2rem] border border-slate-200/70 bg-white/70 p-6 shadow-sm backdrop-blur sm:p-8">
            <div class="flex items-center justify-between gap-4">
                <div class="text-lg font-semibold text-slate-900">Features</div>
                <button type="button" data-add-feature class="rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-2 text-sm font-semibold text-slate-800 shadow-sm backdrop-blur transition hover:bg-white">
                    Tambah
                </button>
            </div>
            <div class="mt-6 space-y-3" data-features>
                @foreach ($featuresValue as $i => $row)
                    <div class="grid gap-3 sm:grid-cols-[1fr_auto]">
                        <input name="features[{{ $i }}][text]" value="{{ $row['text'] ?? '' }}" placeholder="Feature" class="w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300" />
                        <button type="button" data-remove class="h-11 rounded-2xl border border-slate-200/70 bg-white/70 px-4 text-sm font-semibold text-slate-800 shadow-sm backdrop-blur transition hover:bg-white">
                            Hapus
                        </button>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="flex items-center justify-end gap-3">
            <button type="submit" class="brand-gradient rounded-2xl px-6 py-3 text-sm font-semibold text-white shadow-[0_18px_50px_-26px_rgba(14,165,233,0.6)] transition hover:-translate-y-0.5">
                Simpan
            </button>
        </div>
    </form>

    <script>
        const container = document.querySelector('[data-features]');
        const addBtn = document.querySelector('[data-add-feature]');

        const bindRemove = (node) => {
            const remove = node.querySelector('[data-remove]');
            if (remove) remove.addEventListener('click', () => node.remove());
        };

        container?.querySelectorAll(':scope > *')?.forEach(bindRemove);

        addBtn?.addEventListener('click', () => {
            const i = container.children.length;
            const wrap = document.createElement('div');
            wrap.className = 'grid gap-3 sm:grid-cols-[1fr_auto]';
            wrap.innerHTML = `
                <input name="features[${i}][text]" placeholder="Feature" class="w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300" />
                <button type="button" data-remove class="h-11 rounded-2xl border border-slate-200/70 bg-white/70 px-4 text-sm font-semibold text-slate-800 shadow-sm backdrop-blur transition hover:bg-white">Hapus</button>
            `;
            container.appendChild(wrap);
            bindRemove(wrap);
        });
    </script>
@endsection

