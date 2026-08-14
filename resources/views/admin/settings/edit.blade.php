@extends('layouts.admin')

@section('title', 'Pengaturan Situs - Admin Sankara Tech')

@section('content')
    <div class="reveal flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="text-3xl font-semibold tracking-tight text-slate-900">Pengaturan Situs & Navigasi</h1>
            <p class="mt-2 max-w-2xl text-base leading-relaxed text-slate-600">
                Kelola identitas website, logo, favicon, bottom navigation (mobile), menu header, footer, kontak, serta media sosial.
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

    @if ($errors->any())
        <div class="mt-8 rounded-2xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm font-semibold text-rose-800">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form class="mt-10 space-y-10" method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- SECTION 1: IDENTITAS & BRANDING -->
        <div class="rounded-[2rem] border border-slate-200/70 bg-white/70 p-6 shadow-sm backdrop-blur sm:p-8">
            <div class="text-lg font-semibold text-slate-900">1. Branding & Logo Website</div>
            <p class="mt-2 text-sm leading-relaxed text-slate-600">Atur nama brand, tagline, logo utama, favicon, dan tema warna situs.</p>

            <div class="mt-8 grid gap-6 sm:grid-cols-2">
                <div>
                    <label class="block text-sm font-semibold text-slate-900" for="site_name">Nama Brand / Website</label>
                    <input
                        id="site_name"
                        type="text"
                        name="site_name"
                        value="{{ old('site_name', $siteName) }}"
                        class="mt-2 w-full rounded-2xl border border-slate-200/80 bg-white/80 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm outline-none transition focus:border-sky-500 focus:bg-white"
                        required
                    />
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-900" for="site_tagline">Tagline Brand</label>
                    <input
                        id="site_tagline"
                        type="text"
                        name="site_tagline"
                        value="{{ old('site_tagline', $siteTagline) }}"
                        class="mt-2 w-full rounded-2xl border border-slate-200/80 bg-white/80 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm outline-none transition focus:border-sky-500 focus:bg-white"
                        placeholder="Contoh: Digital Agency"
                    />
                </div>
            </div>

            <!-- Upload Logo & Favicon -->
            <div class="mt-8 grid gap-6 sm:grid-cols-2">
                <!-- Logo -->
                <div class="rounded-2xl border border-slate-200/70 bg-white/50 p-5">
                    <label class="block text-sm font-semibold text-slate-900">Logo Utama Website</label>
                    <p class="mt-1 text-xs text-slate-500">Format JPG, PNG, WEBP, atau SVG (Maks. 4MB).</p>
                    
                    <div class="mt-4 flex items-center gap-4">
                        <div class="grid h-16 w-16 place-items-center rounded-2xl border border-slate-200/80 bg-slate-900/5 p-2">
                            <img id="logo-preview" src="{{ $siteLogo }}" alt="Preview Logo" class="max-h-full max-w-full object-contain">
                        </div>
                        <div class="flex-1">
                            <input
                                type="file"
                                name="logo"
                                accept="image/*"
                                class="w-full text-xs text-slate-600 file:mr-3 file:rounded-xl file:border-0 file:bg-slate-900 file:px-3 file:py-2 file:text-xs file:font-semibold file:text-white hover:file:bg-slate-800"
                                onchange="previewImage(this, 'logo-preview')"
                            />
                            <span class="mt-1 block text-[11px] text-slate-400 truncate">Current: {{ $siteLogo }}</span>
                        </div>
                    </div>
                </div>

                <!-- Favicon -->
                <div class="rounded-2xl border border-slate-200/70 bg-white/50 p-5">
                    <label class="block text-sm font-semibold text-slate-900">Favicon Browser</label>
                    <p class="mt-1 text-xs text-slate-500">Ikon tab browser (Maks. 2MB).</p>
                    
                    <div class="mt-4 flex items-center gap-4">
                        <div class="grid h-16 w-16 place-items-center rounded-2xl border border-slate-200/80 bg-slate-900/5 p-2">
                            <img id="favicon-preview" src="{{ $siteFavicon }}" alt="Preview Favicon" class="max-h-full max-w-full object-contain">
                        </div>
                        <div class="flex-1">
                            <input
                                type="file"
                                name="favicon"
                                accept="image/*"
                                class="w-full text-xs text-slate-600 file:mr-3 file:rounded-xl file:border-0 file:bg-slate-900 file:px-3 file:py-2 file:text-xs file:font-semibold file:text-white hover:file:bg-slate-800"
                                onchange="previewImage(this, 'favicon-preview')"
                            />
                            <span class="mt-1 block text-[11px] text-slate-400 truncate">Current: {{ $siteFavicon }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 2: BOTTOM NAVIGATION (MOBILE) -->
        <div class="rounded-[2rem] border border-slate-200/70 bg-white/70 p-6 shadow-sm backdrop-blur sm:p-8">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <div class="text-lg font-semibold text-slate-900">2. Bottom Navigation (Tampilan Mobile)</div>
                    <p class="mt-2 text-sm leading-relaxed text-slate-600">
                        Atur item menu yang tampil pada bar navigasi bawah di HP/layar kecil.
                    </p>
                </div>
                <button
                    type="button"
                    onclick="addBottomNavItem()"
                    class="rounded-2xl border border-slate-200/80 bg-slate-900 px-4 py-2.5 text-xs font-semibold text-white shadow-sm transition hover:bg-slate-800"
                >
                    + Tambah Item
                </button>
            </div>

            <div id="bottom-nav-container" class="mt-8 space-y-4">
                @php
                    $bottomNavItems = old('bottom_nav', $bottomNav);
                @endphp

                @foreach ($bottomNavItems as $index => $item)
                    <div class="bottom-nav-item rounded-2xl border border-slate-200/70 bg-white/60 p-5 backdrop-blur">
                        <div class="grid gap-4 sm:grid-cols-12 items-start">
                            <div class="sm:col-span-3">
                                <label class="block text-xs font-semibold text-slate-700">Label Menu</label>
                                <input
                                    type="text"
                                    name="bottom_nav[{{ $index }}][label]"
                                    value="{{ $item['label'] ?? '' }}"
                                    class="mt-1.5 w-full rounded-xl border border-slate-200/80 bg-white px-3 py-2 text-xs font-medium text-slate-900 shadow-sm outline-none focus:border-sky-500"
                                    placeholder="Home"
                                    required
                                />
                            </div>

                            <div class="sm:col-span-4">
                                <label class="block text-xs font-semibold text-slate-700">URL / Link Target</label>
                                <input
                                    type="text"
                                    name="bottom_nav[{{ $index }}][url]"
                                    value="{{ $item['url'] ?? '' }}"
                                    class="mt-1.5 w-full rounded-xl border border-slate-200/80 bg-white px-3 py-2 text-xs font-medium text-slate-900 shadow-sm outline-none focus:border-sky-500"
                                    placeholder="/"
                                    required
                                />
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-xs font-semibold text-slate-700">Ikon Preset</label>
                                <select
                                    name="bottom_nav[{{ $index }}][icon]"
                                    class="mt-1.5 w-full rounded-xl border border-slate-200/80 bg-white px-3 py-2 text-xs font-medium text-slate-900 shadow-sm outline-none focus:border-sky-500"
                                >
                                    <option value="home" {{ ($item['icon'] ?? '') === 'home' ? 'selected' : '' }}>Home</option>
                                    <option value="services" {{ ($item['icon'] ?? '') === 'services' ? 'selected' : '' }}>Layanan</option>
                                    <option value="portfolios" {{ ($item['icon'] ?? '') === 'portfolios' ? 'selected' : '' }}>Portofolio</option>
                                    <option value="contact" {{ ($item['icon'] ?? '') === 'contact' ? 'selected' : '' }}>Kontak</option>
                                    <option value="info" {{ ($item['icon'] ?? '') === 'info' ? 'selected' : '' }}>Info / About</option>
                                    <option value="grid" {{ ($item['icon'] ?? '') === 'grid' ? 'selected' : '' }}>Grid / Dashboard</option>
                                    <option value="custom" {{ ($item['icon'] ?? '') === 'custom' ? 'selected' : '' }}>Custom SVG</option>
                                </select>
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-xs font-semibold text-slate-700">Custom SVG Path (Opsional)</label>
                                <input
                                    type="text"
                                    name="bottom_nav[{{ $index }}][custom_icon]"
                                    value="{{ $item['custom_icon'] ?? '' }}"
                                    class="mt-1.5 w-full rounded-xl border border-slate-200/80 bg-white px-3 py-2 text-xs font-mono text-slate-800 shadow-sm outline-none focus:border-sky-500"
                                    placeholder="M6 7h12..."
                                />
                            </div>

                            <div class="sm:col-span-1 flex justify-end pt-5">
                                <button
                                    type="button"
                                    onclick="removeBottomNavItem(this)"
                                    class="rounded-xl border border-rose-200 bg-rose-50 px-3 py-2 text-xs font-semibold text-rose-600 transition hover:bg-rose-100"
                                    title="Hapus"
                                >
                                    ✕
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- SECTION 3: HEADER NAVIGATION -->
        <div class="rounded-[2rem] border border-slate-200/70 bg-white/70 p-6 shadow-sm backdrop-blur sm:p-8">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <div class="text-lg font-semibold text-slate-900">3. Header Navigation (Menu Utama Navigasi)</div>
                    <p class="mt-2 text-sm leading-relaxed text-slate-600">
                        Atur item menu navigasi yang tampil pada bagian atas website.
                    </p>
                </div>
                <button
                    type="button"
                    onclick="addHeaderNavItem()"
                    class="rounded-2xl border border-slate-200/80 bg-slate-900 px-4 py-2.5 text-xs font-semibold text-white shadow-sm transition hover:bg-slate-800"
                >
                    + Tambah Item
                </button>
            </div>

            <div id="header-nav-container" class="mt-8 space-y-4">
                @php
                    $headerNavItems = old('header_nav', $headerNav);
                @endphp

                @foreach ($headerNavItems as $index => $item)
                    <div class="header-nav-item rounded-2xl border border-slate-200/70 bg-white/60 p-4 backdrop-blur">
                        <div class="grid gap-4 sm:grid-cols-12 items-center">
                            <div class="sm:col-span-5">
                                <label class="block text-xs font-semibold text-slate-700">Label Menu</label>
                                <input
                                    type="text"
                                    name="header_nav[{{ $index }}][label]"
                                    value="{{ $item['label'] ?? '' }}"
                                    class="mt-1 w-full rounded-xl border border-slate-200/80 bg-white px-3 py-2 text-xs font-medium text-slate-900 shadow-sm outline-none focus:border-sky-500"
                                    placeholder="Layanan"
                                    required
                                />
                            </div>

                            <div class="sm:col-span-6">
                                <label class="block text-xs font-semibold text-slate-700">URL / Link Target</label>
                                <input
                                    type="text"
                                    name="header_nav[{{ $index }}][url]"
                                    value="{{ $item['url'] ?? '' }}"
                                    class="mt-1 w-full rounded-xl border border-slate-200/80 bg-white px-3 py-2 text-xs font-medium text-slate-900 shadow-sm outline-none focus:border-sky-500"
                                    placeholder="/layanan"
                                    required
                                />
                            </div>

                            <div class="sm:col-span-1 flex justify-end pt-4 sm:pt-0">
                                <button
                                    type="button"
                                    onclick="removeHeaderNavItem(this)"
                                    class="rounded-xl border border-rose-200 bg-rose-50 px-3 py-2 text-xs font-semibold text-rose-600 transition hover:bg-rose-100"
                                    title="Hapus"
                                >
                                    ✕
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- SECTION 4: FOOTER & COPYRIGHT -->
        <div class="rounded-[2rem] border border-slate-200/70 bg-white/70 p-6 shadow-sm backdrop-blur sm:p-8">
            <div class="text-lg font-semibold text-slate-900">4. Informasi Footer Website</div>
            <p class="mt-2 text-sm leading-relaxed text-slate-600">Atur deskripsi singkat, teks hak cipta, dan subtitle di bagian paling bawah website.</p>

            <div class="mt-8 space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-900" for="footer_description">Deskripsi Footer</label>
                    <textarea
                        id="footer_description"
                        name="footer_description"
                        rows="3"
                        class="mt-2 w-full rounded-2xl border border-slate-200/80 bg-white/80 p-4 text-sm font-medium text-slate-900 shadow-sm outline-none transition focus:border-sky-500 focus:bg-white"
                    >{{ old('footer_description', $footerDescription) }}</textarea>
                </div>

                <div class="grid gap-6 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-semibold text-slate-900" for="footer_copyright">Teks Hak Cipta (Copyright)</label>
                        <input
                            id="footer_copyright"
                            type="text"
                            name="footer_copyright"
                            value="{{ old('footer_copyright', $footerCopyright) }}"
                            class="mt-2 w-full rounded-2xl border border-slate-200/80 bg-white/80 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm outline-none transition focus:border-sky-500 focus:bg-white"
                        />
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-900" for="footer_subtext">Subtitle Footer</label>
                        <input
                            id="footer_subtext"
                            type="text"
                            name="footer_subtext"
                            value="{{ old('footer_subtext', $footerSubtext) }}"
                            class="mt-2 w-full rounded-2xl border border-slate-200/80 bg-white/80 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm outline-none transition focus:border-sky-500 focus:bg-white"
                        />
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 5: KONTAK & SOSIAL MEDIA -->
        <div class="rounded-[2rem] border border-slate-200/70 bg-white/70 p-6 shadow-sm backdrop-blur sm:p-8">
            <div class="text-lg font-semibold text-slate-900">5. Informasi Kontak & Media Sosial</div>
            <p class="mt-2 text-sm leading-relaxed text-slate-600">Kontak utama yang akan muncul pada footer dan halaman kontak.</p>

            <div class="mt-8 grid gap-6 sm:grid-cols-2">
                <div>
                    <label class="block text-sm font-semibold text-slate-900">Email Utama</label>
                    <input
                        type="text"
                        name="contact[email]"
                        value="{{ old('contact.email', $contact['email'] ?? '') }}"
                        class="mt-2 w-full rounded-2xl border border-slate-200/80 bg-white/80 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm outline-none transition focus:border-sky-500 focus:bg-white"
                    />
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-900">Nomor WhatsApp</label>
                    <input
                        type="text"
                        name="contact[whatsapp]"
                        value="{{ old('contact.whatsapp', $contact['whatsapp'] ?? '') }}"
                        class="mt-2 w-full rounded-2xl border border-slate-200/80 bg-white/80 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm outline-none transition focus:border-sky-500 focus:bg-white"
                    />
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-900">Alamat</label>
                    <input
                        type="text"
                        name="contact[address]"
                        value="{{ old('contact.address', $contact['address'] ?? '') }}"
                        class="mt-2 w-full rounded-2xl border border-slate-200/80 bg-white/80 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm outline-none transition focus:border-sky-500 focus:bg-white"
                    />
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-900">Jam Kerja</label>
                    <input
                        type="text"
                        name="contact[hours]"
                        value="{{ old('contact.hours', $contact['hours'] ?? '') }}"
                        class="mt-2 w-full rounded-2xl border border-slate-200/80 bg-white/80 px-4 py-3 text-sm font-medium text-slate-900 shadow-sm outline-none transition focus:border-sky-500 focus:bg-white"
                    />
                </div>
            </div>

            <div class="mt-8">
                <div class="text-sm font-semibold text-slate-900">Link Sosial Media</div>
                <div class="mt-4 grid gap-6 sm:grid-cols-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700">Instagram</label>
                        <input
                            type="text"
                            name="socials[instagram]"
                            value="{{ old('socials.instagram', $socials['instagram'] ?? '') }}"
                            class="mt-1.5 w-full rounded-2xl border border-slate-200/80 bg-white/80 px-4 py-2.5 text-xs font-medium text-slate-900 shadow-sm outline-none focus:border-sky-500"
                        />
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700">LinkedIn</label>
                        <input
                            type="text"
                            name="socials[linkedin]"
                            value="{{ old('socials.linkedin', $socials['linkedin'] ?? '') }}"
                            class="mt-1.5 w-full rounded-2xl border border-slate-200/80 bg-white/80 px-4 py-2.5 text-xs font-medium text-slate-900 shadow-sm outline-none focus:border-sky-500"
                        />
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700">Dribbble</label>
                        <input
                            type="text"
                            name="socials[dribbble]"
                            value="{{ old('socials.dribbble', $socials['dribbble'] ?? '') }}"
                            class="mt-1.5 w-full rounded-2xl border border-slate-200/80 bg-white/80 px-4 py-2.5 text-xs font-medium text-slate-900 shadow-sm outline-none focus:border-sky-500"
                        />
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700">Twitter / X</label>
                        <input
                            type="text"
                            name="socials[twitter]"
                            value="{{ old('socials.twitter', $socials['twitter'] ?? '') }}"
                            class="mt-1.5 w-full rounded-2xl border border-slate-200/80 bg-white/80 px-4 py-2.5 text-xs font-medium text-slate-900 shadow-sm outline-none focus:border-sky-500"
                        />
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700">GitHub</label>
                        <input
                            type="text"
                            name="socials[github]"
                            value="{{ old('socials.github', $socials['github'] ?? '') }}"
                            class="mt-1.5 w-full rounded-2xl border border-slate-200/80 bg-white/80 px-4 py-2.5 text-xs font-medium text-slate-900 shadow-sm outline-none focus:border-sky-500"
                        />
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700">YouTube</label>
                        <input
                            type="text"
                            name="socials[youtube]"
                            value="{{ old('socials.youtube', $socials['youtube'] ?? '') }}"
                            class="mt-1.5 w-full rounded-2xl border border-slate-200/80 bg-white/80 px-4 py-2.5 text-xs font-medium text-slate-900 shadow-sm outline-none focus:border-sky-500"
                        />
                    </div>
                </div>
            </div>
        </div>

        <!-- SUBMIT BUTTON -->
        <div class="flex items-center justify-end gap-4">
            <button
                type="submit"
                class="brand-gradient rounded-2xl px-8 py-3 text-sm font-semibold text-white shadow-[0_18px_50px_-26px_rgba(14,165,233,0.6)] transition hover:-translate-y-0.5"
            >
                Simpan Perubahan
            </button>
        </div>
    </form>

    <script>
        function previewImage(input, previewId) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById(previewId).src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        let bottomNavCounter = {{ count($bottomNavItems) }};
        function addBottomNavItem() {
            const container = document.getElementById('bottom-nav-container');
            const idx = bottomNavCounter++;
            const html = `
                <div class="bottom-nav-item rounded-2xl border border-slate-200/70 bg-white/60 p-5 backdrop-blur">
                    <div class="grid gap-4 sm:grid-cols-12 items-start">
                        <div class="sm:col-span-3">
                            <label class="block text-xs font-semibold text-slate-700">Label Menu</label>
                            <input
                                type="text"
                                name="bottom_nav[\${idx}][label]"
                                class="mt-1.5 w-full rounded-xl border border-slate-200/80 bg-white px-3 py-2 text-xs font-medium text-slate-900 shadow-sm outline-none focus:border-sky-500"
                                placeholder="Menu Baru"
                                required
                            />
                        </div>

                        <div class="sm:col-span-4">
                            <label class="block text-xs font-semibold text-slate-700">URL / Link Target</label>
                            <input
                                type="text"
                                name="bottom_nav[\${idx}][url]"
                                class="mt-1.5 w-full rounded-xl border border-slate-200/80 bg-white px-3 py-2 text-xs font-medium text-slate-900 shadow-sm outline-none focus:border-sky-500"
                                placeholder="/path"
                                required
                            />
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-xs font-semibold text-slate-700">Ikon Preset</label>
                            <select
                                name="bottom_nav[\${idx}][icon]"
                                class="mt-1.5 w-full rounded-xl border border-slate-200/80 bg-white px-3 py-2 text-xs font-medium text-slate-900 shadow-sm outline-none focus:border-sky-500"
                            >
                                <option value="home">Home</option>
                                <option value="services">Layanan</option>
                                <option value="portfolios">Portofolio</option>
                                <option value="contact">Kontak</option>
                                <option value="info">Info / About</option>
                                <option value="grid">Grid / Dashboard</option>
                                <option value="custom">Custom SVG</option>
                            </select>
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-xs font-semibold text-slate-700">Custom SVG Path</label>
                            <input
                                type="text"
                                name="bottom_nav[\${idx}][custom_icon]"
                                class="mt-1.5 w-full rounded-xl border border-slate-200/80 bg-white px-3 py-2 text-xs font-mono text-slate-800 shadow-sm outline-none focus:border-sky-500"
                                placeholder="Path SVG..."
                            />
                        </div>

                        <div class="sm:col-span-1 flex justify-end pt-5">
                            <button
                                type="button"
                                onclick="removeBottomNavItem(this)"
                                class="rounded-xl border border-rose-200 bg-rose-50 px-3 py-2 text-xs font-semibold text-rose-600 transition hover:bg-rose-100"
                                title="Hapus"
                            >
                                ✕
                            </button>
                        </div>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
        }

        function removeBottomNavItem(btn) {
            const item = btn.closest('.bottom-nav-item');
            if (item) item.remove();
        }

        let headerNavCounter = {{ count($headerNavItems) }};
        function addHeaderNavItem() {
            const container = document.getElementById('header-nav-container');
            const idx = headerNavCounter++;
            const html = `
                <div class="header-nav-item rounded-2xl border border-slate-200/70 bg-white/60 p-4 backdrop-blur">
                    <div class="grid gap-4 sm:grid-cols-12 items-center">
                        <div class="sm:col-span-5">
                            <label class="block text-xs font-semibold text-slate-700">Label Menu</label>
                            <input
                                type="text"
                                name="header_nav[\${idx}][label]"
                                class="mt-1 w-full rounded-xl border border-slate-200/80 bg-white px-3 py-2 text-xs font-medium text-slate-900 shadow-sm outline-none focus:border-sky-500"
                                placeholder="Menu Baru"
                                required
                            />
                        </div>

                        <div class="sm:col-span-6">
                            <label class="block text-xs font-semibold text-slate-700">URL / Link Target</label>
                            <input
                                type="text"
                                name="header_nav[\${idx}][url]"
                                class="mt-1 w-full rounded-xl border border-slate-200/80 bg-white px-3 py-2 text-xs font-medium text-slate-900 shadow-sm outline-none focus:border-sky-500"
                                placeholder="/path"
                                required
                            />
                        </div>

                        <div class="sm:col-span-1 flex justify-end pt-4 sm:pt-0">
                            <button
                                type="button"
                                onclick="removeHeaderNavItem(this)"
                                class="rounded-xl border border-rose-200 bg-rose-50 px-3 py-2 text-xs font-semibold text-rose-600 transition hover:bg-rose-100"
                                title="Hapus"
                            >
                                ✕
                            </button>
                        </div>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
        }

        function removeHeaderNavItem(btn) {
            const item = btn.closest('.header-nav-item');
            if (item) item.remove();
        }
    </script>
@endsection
