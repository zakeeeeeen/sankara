@extends('layouts.admin')

@section('title', ($portfolio->exists ? 'Edit' : 'Tambah') . ' Portofolio - Admin Sankara Tech')

@section('content')
    <div class="reveal flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="text-3xl font-semibold tracking-tight text-slate-900">{{ $portfolio->exists ? 'Edit Portofolio' : 'Tambah Portofolio' }}</h1>
            <p class="mt-2 text-base leading-relaxed text-slate-600">Konten portofolio tampil di landing (preview) dan halaman detail.</p>
        </div>

        <a href="{{ route('admin.portfolios.index') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-200/70 bg-white/70 px-5 py-2.5 text-sm font-semibold text-slate-800 shadow-sm backdrop-blur transition hover:-translate-y-0.5 hover:bg-white">
            Kembali
        </a>
    </div>

    <form class="mt-10 space-y-10" method="POST" action="{{ $portfolio->exists ? route('admin.portfolios.update', $portfolio) : route('admin.portfolios.store') }}" enctype="multipart/form-data">
        @csrf
        @if ($portfolio->exists)
            @method('PUT')
        @endif

        <div class="rounded-[2rem] border border-slate-200/70 bg-white/70 p-6 shadow-sm backdrop-blur sm:p-8">
            <div class="grid gap-5 lg:grid-cols-2">
                <div>
                    <label class="text-sm font-semibold text-slate-800">Title</label>
                    <input name="portfolio[title]" value="{{ old('portfolio.title', $portfolio->title) }}" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300" required />
                    @error('portfolio.title') <div class="mt-2 text-sm font-semibold text-rose-600">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-800">Slug (optional)</label>
                    <input name="portfolio[slug]" value="{{ old('portfolio.slug', $portfolio->slug) }}" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300" />
                    @error('portfolio.slug') <div class="mt-2 text-sm font-semibold text-rose-600">{{ $message }}</div> @enderror
                </div>
                <div class="lg:col-span-2">
                    <label class="text-sm font-semibold text-slate-800">Excerpt</label>
                    <textarea name="portfolio[excerpt]" rows="3" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300">{{ old('portfolio.excerpt', $portfolio->excerpt) }}</textarea>
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-800">Client Name (optional)</label>
                    <input name="portfolio[client_name]" value="{{ old('portfolio.client_name', $portfolio->client_name) }}" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300" />
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-800">Project URL (optional)</label>
                    <input name="portfolio[project_url]" value="{{ old('portfolio.project_url', $portfolio->project_url) }}" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300" />
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-800">Published At</label>
                    <input type="date" name="portfolio[published_at]" value="{{ old('portfolio.published_at', $portfolio->published_at?->format('Y-m-d')) }}" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300" />
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-800">Kategori</label>
                    @php
                        $selectedValue = old('categories', $selected ?? []);
                    @endphp
                    <select multiple name="categories[]" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300">
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" {{ in_array($cat->id, $selectedValue) ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    <div class="mt-2 text-xs font-semibold text-slate-500">Gunakan Ctrl/Cmd untuk multi pilih.</div>
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-800">Cover Image URL (optional)</label>
                    <input name="portfolio[cover_image_url]" value="{{ old('portfolio.cover_image_url', $portfolio->cover_image_url) }}" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300" />
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-800">Preview Image URL (optional)</label>
                    <input name="portfolio[preview_image_url]" value="{{ old('portfolio.preview_image_url', $portfolio->preview_image_url) }}" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300" />
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-800">Upload Cover Image (optional)</label>
                    <input type="file" name="portfolio[cover_image]" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur" />
                    @if ($portfolio->cover_image_src)
                        <div class="mt-3 text-xs font-semibold text-slate-600">Current: {{ $portfolio->cover_image_src }}</div>
                    @endif
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-800">Upload Preview Image (optional)</label>
                    <input type="file" name="portfolio[preview_image]" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur" />
                    @if ($portfolio->preview_image_src)
                        <div class="mt-3 text-xs font-semibold text-slate-600">Current: {{ $portfolio->preview_image_src }}</div>
                    @endif
                </div>
                <div class="grid gap-3 sm:grid-cols-2 lg:col-span-2">
                    <div>
                        <label class="text-sm font-semibold text-slate-800">Sort Order</label>
                        <input type="number" name="portfolio[sort_order]" value="{{ old('portfolio.sort_order', $portfolio->sort_order ?? 0) }}" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300" />
                    </div>
                    <div class="flex items-end gap-3">
                        <input type="hidden" name="portfolio[is_active]" value="0" />
                        <label class="flex items-center gap-3 rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-semibold text-slate-800 shadow-sm backdrop-blur">
                            <input type="checkbox" name="portfolio[is_active]" value="1" class="h-4 w-4 rounded border-slate-300 text-emerald-600" {{ old('portfolio.is_active', $portfolio->is_active) ? 'checked' : '' }} />
                            Active
                        </label>
                    </div>
                </div>
            </div>
        </div>

        @php
            $techValue = old('portfolio.technologies', $portfolio->technologies ?? []);
        @endphp

        <div class="rounded-[2rem] border border-slate-200/70 bg-white/70 p-6 shadow-sm backdrop-blur sm:p-8">
            <div class="flex items-center justify-between gap-4">
                <div class="text-lg font-semibold text-slate-900">Teknologi yang Digunakan</div>
                <button type="button" data-add-tech class="rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-2 text-sm font-semibold text-slate-800 shadow-sm backdrop-blur transition hover:bg-white">
                    Tambah
                </button>
            </div>

            <div class="mt-6 space-y-3" data-techs>
                @foreach (($techValue ?? []) as $i => $t)
                    <div class="grid gap-3 sm:grid-cols-[1fr_auto]">
                        <input name="portfolio[technologies][{{ $i }}]" value="{{ $t }}" placeholder="Contoh: Laravel" class="w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300" />
                        <button type="button" data-remove class="h-11 rounded-2xl border border-slate-200/70 bg-white/70 px-4 text-sm font-semibold text-slate-800 shadow-sm backdrop-blur transition hover:bg-white">
                            Hapus
                        </button>
                    </div>
                @endforeach
            </div>

            @error('portfolio.technologies') <div class="mt-3 text-sm font-semibold text-rose-600">{{ $message }}</div> @enderror
            @error('portfolio.technologies.*') <div class="mt-3 text-sm font-semibold text-rose-600">{{ $message }}</div> @enderror
        </div>

        @php
            $sectionsValue = old('sections', $sections ?? []);
        @endphp

        <div class="rounded-[2rem] border border-slate-200/70 bg-white/70 p-6 shadow-sm backdrop-blur sm:p-8">
            <div class="flex items-center justify-between gap-4">
                <div class="text-lg font-semibold text-slate-900">Fitur Utama</div>
                <button type="button" data-add-section class="rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-2 text-sm font-semibold text-slate-800 shadow-sm backdrop-blur transition hover:bg-white">
                    Tambah
                </button>
            </div>

            <div class="mt-6 space-y-4" data-sections>
                @foreach ($sectionsValue as $i => $row)
                    <div class="rounded-2xl border border-slate-200/70 bg-white/60 p-5 shadow-sm backdrop-blur">
                        <div class="flex items-center justify-between gap-3">
                            <div class="text-sm font-semibold text-slate-900">Section #{{ $i + 1 }}</div>
                            <button type="button" data-remove class="rounded-xl border border-slate-200/70 bg-white/70 px-4 py-2 text-sm font-semibold text-slate-800 shadow-sm backdrop-blur transition hover:bg-white">
                                Hapus
                            </button>
                        </div>

                        <div class="mt-4 grid gap-4 lg:grid-cols-2">
                            <div>
                                <label class="text-sm font-semibold text-slate-800">Heading</label>
                                <input name="sections[{{ $i }}][heading]" value="{{ $row['heading'] ?? '' }}" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300" />
                            </div>
                            <div>
                                <label class="text-sm font-semibold text-slate-800">Image URL (optional)</label>
                                <input name="sections[{{ $i }}][image_url]" value="{{ $row['image_url'] ?? '' }}" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300" />
                            </div>
                            <div class="lg:col-span-2">
                                <label class="text-sm font-semibold text-slate-800">Body</label>
                                <textarea name="sections[{{ $i }}][body]" rows="4" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300">{{ $row['body'] ?? '' }}</textarea>
                            </div>
                            <div class="lg:col-span-2">
                                <label class="text-sm font-semibold text-slate-800">Upload Image (optional)</label>
                                <input type="file" name="sections[{{ $i }}][image]" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur" />
                                @if (!empty($row['image_src']))
                                    <div class="mt-3 text-xs font-semibold text-slate-600">Current: {{ $row['image_src'] }}</div>
                                @endif
                            </div>
                        </div>
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
        const techList = document.querySelector('[data-techs]');
        const addTech = document.querySelector('[data-add-tech]');

        const list = document.querySelector('[data-sections]');
        const add = document.querySelector('[data-add-section]');

        const bindRemove = (node) => {
            const btn = node.querySelector('[data-remove]');
            if (btn) btn.addEventListener('click', () => node.remove());
        };

        techList?.querySelectorAll(':scope > *')?.forEach(bindRemove);
        list?.querySelectorAll(':scope > *')?.forEach(bindRemove);

        addTech?.addEventListener('click', () => {
            const i = techList.children.length;
            const wrap = document.createElement('div');
            wrap.className = 'grid gap-3 sm:grid-cols-[1fr_auto]';
            wrap.innerHTML = `
                <input name="portfolio[technologies][${i}]" placeholder="Contoh: Laravel" class="w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300" />
                <button type="button" data-remove class="h-11 rounded-2xl border border-slate-200/70 bg-white/70 px-4 text-sm font-semibold text-slate-800 shadow-sm backdrop-blur transition hover:bg-white">Hapus</button>
            `;
            techList.appendChild(wrap);
            bindRemove(wrap);
        });

        add?.addEventListener('click', () => {
            const i = list.children.length;
            const wrap = document.createElement('div');
            wrap.className = 'rounded-2xl border border-slate-200/70 bg-white/60 p-5 shadow-sm backdrop-blur';
            wrap.innerHTML = `
                <div class="flex items-center justify-between gap-3">
                    <div class="text-sm font-semibold text-slate-900">Section #${i + 1}</div>
                    <button type="button" data-remove class="rounded-xl border border-slate-200/70 bg-white/70 px-4 py-2 text-sm font-semibold text-slate-800 shadow-sm backdrop-blur transition hover:bg-white">Hapus</button>
                </div>
                <div class="mt-4 grid gap-4 lg:grid-cols-2">
                    <div>
                        <label class="text-sm font-semibold text-slate-800">Heading</label>
                        <input name="sections[${i}][heading]" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300" />
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-slate-800">Image URL (optional)</label>
                        <input name="sections[${i}][image_url]" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300" />
                    </div>
                    <div class="lg:col-span-2">
                        <label class="text-sm font-semibold text-slate-800">Body</label>
                        <textarea name="sections[${i}][body]" rows="4" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300"></textarea>
                    </div>
                    <div class="lg:col-span-2">
                        <label class="text-sm font-semibold text-slate-800">Upload Image (optional)</label>
                        <input type="file" name="sections[${i}][image]" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur" />
                    </div>
                </div>
            `;
            list.appendChild(wrap);
            bindRemove(wrap);
        });
    </script>
@endsection

