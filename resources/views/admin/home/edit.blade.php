@extends('layouts.admin')

@section('title', 'Home Settings - Admin Sankara Tech')

@section('content')
    <div class="reveal flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="text-3xl font-semibold tracking-tight text-slate-900">Home Settings</h1>
            <p class="mt-2 max-w-2xl text-base leading-relaxed text-slate-600">
                Atur konten landing page (Hero, Stats, Tentang, Keunggulan, CTA, Kontak & Social).
            </p>
        </div>

        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-200/70 bg-white/70 px-5 py-2.5 text-sm font-semibold text-slate-800 shadow-sm backdrop-blur transition hover:-translate-y-0.5 hover:bg-white">
            Kembali
        </a>
    </div>

    @if (session('status'))
        <div class="brand-gradient-soft mt-8 rounded-2xl border border-slate-200/70 px-5 py-4 text-sm font-semibold text-slate-800">
            {{ session('status') }}
        </div>
    @endif

    <form class="mt-10 space-y-10" method="POST" action="{{ route('admin.home.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')



        <div class="rounded-[2rem] border border-slate-200/70 bg-white/70 p-6 shadow-sm backdrop-blur sm:p-8">
            <div class="text-lg font-semibold text-slate-900">Hero</div>
            <div class="mt-6 grid gap-5 lg:grid-cols-2">
                <div>
                    <label class="text-sm font-semibold text-slate-800">Heading</label>
                    <input name="hero[heading]" value="{{ old('hero.heading', $hero->heading ?? '') }}" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300" required />
                    @error('hero.heading') <div class="mt-2 text-sm font-semibold text-rose-600">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-800">Subheading</label>
                    <textarea name="hero[subheading]" rows="3" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300">{{ old('hero.subheading', $hero->subheading ?? '') }}</textarea>
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-800">Primary CTA Label</label>
                    <input name="hero[primary_cta_label]" value="{{ old('hero.primary_cta_label', $hero->primary_cta_label ?? '') }}" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300" />
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-800">Primary CTA URL</label>
                    <input name="hero[primary_cta_url]" value="{{ old('hero.primary_cta_url', $hero->primary_cta_url ?? '') }}" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300" />
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-800">Secondary CTA Label</label>
                    <input name="hero[secondary_cta_label]" value="{{ old('hero.secondary_cta_label', $hero->secondary_cta_label ?? '') }}" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300" />
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-800">Secondary CTA URL</label>
                    <input name="hero[secondary_cta_url]" value="{{ old('hero.secondary_cta_url', $hero->secondary_cta_url ?? '') }}" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300" />
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-800">Hero Image URL (optional)</label>
                    <input name="hero[image_url]" value="{{ old('hero.image_url', $hero->image_url ?? '') }}" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300" />
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-800">Hero Image Upload (optional)</label>
                    <input type="file" name="hero[image]" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur" />
                    @if ($hero?->image_src)
                        <div class="mt-3 text-xs font-semibold text-slate-600">Current: {{ $hero->image_src }}</div>
                    @endif
                </div>
            </div>
        </div>

        @php
            $statsValue = old('stats', ($stats ?? collect())->map(fn ($s) => ['value' => $s->value, 'label' => $s->label])->all());
            $advantagesValue = old('advantages', ($advantages ?? collect())->map(fn ($a) => ['title' => $a->title, 'description' => $a->description])->all());
        @endphp

        <div class="rounded-[2rem] border border-slate-200/70 bg-white/70 p-6 shadow-sm backdrop-blur sm:p-8">
            <div class="flex items-center justify-between gap-4">
                <div class="text-lg font-semibold text-slate-900">Stats</div>
                <button type="button" data-add-stat class="rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-2 text-sm font-semibold text-slate-800 shadow-sm backdrop-blur transition hover:bg-white">
                    Tambah
                </button>
            </div>
            <div class="mt-6 space-y-3" data-stats>
                @foreach ($statsValue as $i => $row)
                    <div class="grid gap-3 sm:grid-cols-[1fr_1fr_auto]">
                        <input name="stats[{{ $i }}][value]" value="{{ $row['value'] ?? '' }}" placeholder="50+" class="w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300" />
                        <input name="stats[{{ $i }}][label]" value="{{ $row['label'] ?? '' }}" placeholder="Project" class="w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300" />
                        <button type="button" data-remove class="h-11 rounded-2xl border border-slate-200/70 bg-white/70 px-4 text-sm font-semibold text-slate-800 shadow-sm backdrop-blur transition hover:bg-white">
                            Hapus
                        </button>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="rounded-[2rem] border border-slate-200/70 bg-white/70 p-6 shadow-sm backdrop-blur sm:p-8">
            <div class="text-lg font-semibold text-slate-900">Tentang (Section Landing)</div>
            <div class="mt-6 grid gap-5 lg:grid-cols-2">
                <div>
                    <label class="text-sm font-semibold text-slate-800">Eyebrow</label>
                    <input name="about[eyebrow]" value="{{ old('about.eyebrow', $about->eyebrow ?? '') }}" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300" />
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-800">Heading</label>
                    <input name="about[heading]" value="{{ old('about.heading', $about->heading ?? '') }}" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300" required />
                    @error('about.heading') <div class="mt-2 text-sm font-semibold text-rose-600">{{ $message }}</div> @enderror
                </div>
                <div class="lg:col-span-2">
                    <label class="text-sm font-semibold text-slate-800">Body</label>
                    <textarea name="about[body]" rows="4" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300">{{ old('about.body', $about->body ?? '') }}</textarea>
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-800">Image URL (optional)</label>
                    <input name="about[image_url]" value="{{ old('about.image_url', $about->image_url ?? '') }}" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300" />
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-800">Image Upload (optional)</label>
                    <input type="file" name="about[image]" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur" />
                    @if ($about?->image_src)
                        <div class="mt-3 text-xs font-semibold text-slate-600">Current: {{ $about->image_src }}</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="rounded-[2rem] border border-slate-200/70 bg-white/70 p-6 shadow-sm backdrop-blur sm:p-8">
            <div class="flex items-center justify-between gap-4">
                <div class="text-lg font-semibold text-slate-900">Keunggulan</div>
                <button type="button" data-add-adv class="rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-2 text-sm font-semibold text-slate-800 shadow-sm backdrop-blur transition hover:bg-white">
                    Tambah
                </button>
            </div>
            <div class="mt-6 space-y-3" data-advantages>
                @foreach ($advantagesValue as $i => $row)
                    <div class="grid gap-3 sm:grid-cols-[1fr_1fr_auto]">
                        <input name="advantages[{{ $i }}][title]" value="{{ $row['title'] ?? '' }}" placeholder="Judul" class="w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300" />
                        <input name="advantages[{{ $i }}][description]" value="{{ $row['description'] ?? '' }}" placeholder="Deskripsi" class="w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300" />
                        <button type="button" data-remove class="h-11 rounded-2xl border border-slate-200/70 bg-white/70 px-4 text-sm font-semibold text-slate-800 shadow-sm backdrop-blur transition hover:bg-white">
                            Hapus
                        </button>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="rounded-[2rem] border border-slate-200/70 bg-white/70 p-6 shadow-sm backdrop-blur sm:p-8">
            <div class="text-lg font-semibold text-slate-900">CTA (Kontak)</div>
            <div class="mt-6 grid gap-5 lg:grid-cols-2">
                <div>
                    <label class="text-sm font-semibold text-slate-800">Heading</label>
                    <input name="cta[heading]" value="{{ old('cta.heading', $cta->heading ?? '') }}" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300" required />
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-800">Body</label>
                    <textarea name="cta[body]" rows="3" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300">{{ old('cta.body', $cta->body ?? '') }}</textarea>
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-800">Primary Label</label>
                    <input name="cta[primary_label]" value="{{ old('cta.primary_label', $cta->primary_label ?? '') }}" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300" />
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-800">Primary URL</label>
                    <input name="cta[primary_url]" value="{{ old('cta.primary_url', $cta->primary_url ?? '') }}" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300" />
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-800">Secondary Label</label>
                    <input name="cta[secondary_label]" value="{{ old('cta.secondary_label', $cta->secondary_label ?? '') }}" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300" />
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-800">Secondary URL</label>
                    <input name="cta[secondary_url]" value="{{ old('cta.secondary_url', $cta->secondary_url ?? '') }}" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300" />
                </div>
            </div>
        </div>

        <div class="rounded-[2rem] border border-slate-200/70 bg-white/70 p-6 shadow-sm backdrop-blur sm:p-8">
            <div class="text-lg font-semibold text-slate-900">Kontak & Social</div>
            <div class="mt-6 grid gap-5 lg:grid-cols-2">
                <div>
                    <label class="text-sm font-semibold text-slate-800">Email</label>
                    <input name="contact[email]" value="{{ old('contact.email', $contact['email'] ?? '') }}" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300" />
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-800">WhatsApp</label>
                    <input name="contact[whatsapp]" value="{{ old('contact.whatsapp', $contact['whatsapp'] ?? '') }}" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300" />
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-800">Alamat</label>
                    <input name="contact[address]" value="{{ old('contact.address', $contact['address'] ?? '') }}" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300" />
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-800">Jam Operasional</label>
                    <input name="contact[hours]" value="{{ old('contact.hours', $contact['hours'] ?? '') }}" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300" />
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-800">Inbox Email (Pesan Masuk)</label>
                    <input name="contact[inbox_email]" value="{{ old('contact.inbox_email', $contact['inbox_email'] ?? '') }}" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300" />
                    @error('contact.inbox_email') <div class="mt-2 text-sm font-semibold text-rose-600">{{ $message }}</div> @enderror
                </div>
                <div class="lg:col-span-2">
                    <label class="text-sm font-semibold text-slate-800">Google Maps Embed URL</label>
                    <input name="contact[map_embed_url]" value="{{ old('contact.map_embed_url', $contact['map_embed_url'] ?? '') }}" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300" />
                    @error('contact.map_embed_url') <div class="mt-2 text-sm font-semibold text-rose-600">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-800">Instagram URL</label>
                    <input name="socials[instagram]" value="{{ old('socials.instagram', $socials['instagram'] ?? '') }}" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300" />
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-800">LinkedIn URL</label>
                    <input name="socials[linkedin]" value="{{ old('socials.linkedin', $socials['linkedin'] ?? '') }}" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300" />
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-800">Dribbble URL</label>
                    <input name="socials[dribbble]" value="{{ old('socials.dribbble', $socials['dribbble'] ?? '') }}" class="mt-2 w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300" />
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3">
            <button type="submit" class="brand-gradient rounded-2xl px-6 py-3 text-sm font-semibold text-white shadow-[0_18px_50px_-26px_rgba(14,165,233,0.6)] transition hover:-translate-y-0.5">
                Simpan Perubahan
            </button>
        </div>
    </form>

    <script>
        const attachList = (root, addBtn, factory) => {
            const container = document.querySelector(root);
            const btn = document.querySelector(addBtn);
            if (!container || !btn) return;

            const bindRemove = (node) => {
                const remove = node.querySelector('[data-remove]');
                if (remove) remove.addEventListener('click', () => node.remove());
            };

            container.querySelectorAll(':scope > *').forEach(bindRemove);

            btn.addEventListener('click', () => {
                const index = container.children.length;
                const node = factory(index);
                container.appendChild(node);
                bindRemove(node);
            });
        };

        attachList('[data-stats]', '[data-add-stat]', (i) => {
            const wrap = document.createElement('div');
            wrap.className = 'grid gap-3 sm:grid-cols-[1fr_1fr_auto]';
            wrap.innerHTML = `
                <input name="stats[${i}][value]" placeholder="50+" class="w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300" />
                <input name="stats[${i}][label]" placeholder="Project" class="w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300" />
                <button type="button" data-remove class="h-11 rounded-2xl border border-slate-200/70 bg-white/70 px-4 text-sm font-semibold text-slate-800 shadow-sm backdrop-blur transition hover:bg-white">Hapus</button>
            `;
            return wrap;
        });

        attachList('[data-advantages]', '[data-add-adv]', (i) => {
            const wrap = document.createElement('div');
            wrap.className = 'grid gap-3 sm:grid-cols-[1fr_1fr_auto]';
            wrap.innerHTML = `
                <input name="advantages[${i}][title]" placeholder="Judul" class="w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300" />
                <input name="advantages[${i}][description]" placeholder="Deskripsi" class="w-full rounded-2xl border border-slate-200/70 bg-white/70 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm backdrop-blur outline-none focus:border-emerald-300" />
                <button type="button" data-remove class="h-11 rounded-2xl border border-slate-200/70 bg-white/70 px-4 text-sm font-semibold text-slate-800 shadow-sm backdrop-blur transition hover:bg-white">Hapus</button>
            `;
            return wrap;
        });
    </script>
@endsection

