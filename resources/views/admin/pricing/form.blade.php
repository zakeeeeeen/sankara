@extends('layouts.admin')

@section('title', ($plan->exists ? 'Edit' : 'Tambah') . ' Pricing - Admin Sankara Tech')

@section('content')
    <div class="reveal flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="text-3xl font-semibold tracking-tight text-slate-900">{{ $plan->exists ? 'Edit Paket' : 'Tambah Paket' }}</h1>
            <p class="mt-2 text-base leading-relaxed text-slate-600">Paket harga akan tampil di section Harga pada landing page.</p>
        </div>

        <a href="{{ route('admin.pricing.index') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-200/70 bg-white/70 px-5 py-2.5 text-sm font-semibold text-slate-800 shadow-sm backdrop-blur transition hover:-translate-y-0.5 hover:bg-white">
            Kembali
        </a>
    </div>

    <form class="mt-10 space-y-10" method="POST" action="{{ $plan->exists ? route('admin.pricing.update', $plan) : route('admin.pricing.store') }}">
        @csrf
        @if ($plan->exists)
            @method('PUT')
        @endif

        <div class="rounded-[2rem] border border-slate-200/70 bg-white/70 p-6 shadow-sm backdrop-blur sm:p-8">
            <div class="grid gap-5 lg:grid-cols-2">
                <div>
                    <label class="text-sm font-semibold text-slate-800">Name</label>
                    <input name="plan[name]" value="{{ old('plan.name', $plan->name) }}" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300" required />
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-800">Tag</label>
                    <input name="plan[tag]" value="{{ old('plan.tag', $plan->tag) }}" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300" />
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-800">Price Text</label>
                    <input name="plan[price_text]" value="{{ old('plan.price_text', $plan->price_text) }}" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300" />
                </div>
                <div class="grid gap-3 sm:grid-cols-2">
                    <div>
                        <label class="text-sm font-semibold text-slate-800">Sort Order</label>
                        <input type="number" name="plan[sort_order]" value="{{ old('plan.sort_order', $plan->sort_order ?? 0) }}" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300" />
                    </div>
                    <div class="flex items-end gap-3">
                        <input type="hidden" name="plan[is_popular]" value="0" />
                        <label class="flex items-center gap-3 rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-semibold text-slate-800 shadow-sm backdrop-blur">
                            <input type="checkbox" name="plan[is_popular]" value="1" class="h-4 w-4 rounded border-slate-300 text-emerald-600" {{ old('plan.is_popular', $plan->is_popular) ? 'checked' : '' }} />
                            Popular
                        </label>
                    </div>
                </div>
                <div class="lg:col-span-2">
                    <label class="text-sm font-semibold text-slate-800">Description</label>
                    <textarea name="plan[description]" rows="4" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300">{{ old('plan.description', $plan->description) }}</textarea>
                </div>
            </div>
        </div>

        @php
            $featuresValue = old('features', $plan->exists ? $plan->features->map(fn ($f) => ['text' => $f->text])->all() : []);
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

