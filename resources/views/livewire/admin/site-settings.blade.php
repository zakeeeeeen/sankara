<div class="space-y-8">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="inline-flex items-center gap-2 rounded-full border border-sky-400/30 bg-sky-400/10 px-3 py-1 text-xs font-semibold text-sky-700 mb-2">
                <i class="fa-solid fa-gear text-xs"></i>
                Global Configuration
            </div>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Pengaturan Situs, SEO & Sitemap</h1>
            <p class="mt-1 text-sm text-slate-500">Kelola identitas website, logo, favicon, SEO Meta Tags, Google Analytics (GA4), generator sitemap XML, navigasi, serta kontak.</p>
        </div>

        <button
            type="button"
            wire:click="save"
            wire:loading.attr="disabled"
            class="brand-gradient inline-flex items-center gap-2 rounded-2xl px-7 py-3.5 text-sm font-bold text-white shadow-md transition-all hover:-translate-y-0.5 hover:shadow-lg disabled:opacity-70"
        >
            <i wire:loading.remove class="fa-solid fa-floppy-disk text-xs"></i>
            <span wire:loading.remove>Simpan Semua Pengaturan</span>
            <span wire:loading>Menyimpan...</span>
        </button>
    </div>

    @if (session('status'))
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-800">
            {{ session('status') }}
        </div>
    @endif

    @if (session('error'))
        <div class="rounded-2xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm font-semibold text-rose-800">
            {{ session('error') }}
        </div>
    @endif

    <!-- SECTION: SITEMAP GENERATOR (MANUAL BUTTON) -->
    <div class="rounded-[2.5rem] border border-sky-200/80 bg-gradient-to-br from-sky-50/60 via-white to-cyan-50/40 p-6 sm:p-8 shadow-xs backdrop-blur">
        <div class="flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="inline-flex items-center gap-2 rounded-full border border-sky-200 bg-sky-100/60 px-3 py-1 text-xs font-semibold text-sky-800">
                    <i class="fa-solid fa-sitemap text-xs"></i>
                    Spatie Laravel Sitemap Engine
                </div>
                <h2 class="mt-3 text-xl font-bold text-slate-900">XML Sitemap Generator</h2>
                <p class="mt-1 text-sm text-slate-600">
                    Sitemap otomatis diperbarui setiap hari melalui cronjob (shared hosting). Anda juga dapat memperbaruinya secara manual kapan saja.
                </p>
                <div class="mt-3 flex flex-wrap items-center gap-4 text-xs font-medium text-slate-500">
                    <div>
                        <span class="font-semibold text-slate-700">Status File:</span>
                        <a href="{{ url('/sitemap.xml') }}" target="_blank" class="text-sky-600 hover:underline inline-flex items-center gap-1 font-semibold">
                            <span>/sitemap.xml</span>
                            <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                        </a>
                    </div>
                    <div>
                        <span class="font-semibold text-slate-700">Terakhir Di-generate:</span>
                        <span class="font-bold text-slate-800">{{ $sitemapLastGeneratedAt ? \Carbon\Carbon::parse($sitemapLastGeneratedAt)->translatedFormat('d F Y, H:i') . ' WIB' : 'Belum pernah' }}</span>
                    </div>
                </div>
            </div>

            <button
                type="button"
                wire:click="generateSitemap"
                wire:loading.attr="disabled"
                class="brand-gradient inline-flex items-center gap-2 rounded-2xl px-6 py-3 text-sm font-bold text-white shadow-md transition-all hover:-translate-y-0.5 hover:shadow-lg disabled:opacity-70 shrink-0"
            >
                <i wire:loading.remove class="fa-solid fa-rotate text-xs"></i>
                <span wire:loading.remove>Generate Sitemap Sekarang</span>
                <span wire:loading>Memperbarui Sitemap...</span>
            </button>
        </div>
    </div>

    <form wire:submit="save" class="space-y-8">
        <!-- 1. IDENTITAS & BRANDING -->
        <div class="rounded-[2.5rem] border border-slate-200/80 bg-white/90 p-6 sm:p-8 shadow-xs backdrop-blur space-y-6">
            <h2 class="text-xl font-bold text-slate-900">1. Branding & Logo Website</h2>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label class="block text-xs font-bold text-slate-700">Nama Brand / Website <span class="text-rose-500">*</span></label>
                    <input
                        type="text"
                        wire:model="site_name"
                        class="mt-1.5 w-full rounded-2xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm font-medium text-slate-900 outline-none focus:border-sky-500 focus:bg-white"
                        required
                    />
                    @error('site_name') <div class="mt-1 text-xs text-rose-600">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700">Tagline Brand</label>
                    <input
                        type="text"
                        wire:model="site_tagline"
                        class="mt-1.5 w-full rounded-2xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm font-medium text-slate-900 outline-none focus:border-sky-500 focus:bg-white"
                        placeholder="Digital Agency"
                    />
                </div>

                <!-- Logo Upload -->
                <div class="rounded-2xl border border-slate-100 bg-slate-50/50 p-5">
                    <label class="block text-xs font-bold text-slate-700">Logo Utama</label>
                    <div class="mt-3 flex items-center gap-4">
                        @if ($logo)
                            <div class="h-16 w-16 rounded-2xl border border-sky-300 bg-white p-2 grid place-items-center">
                                <img src="{{ $logo->temporaryUrl() }}" alt="Preview" class="max-h-full max-w-full object-contain">
                            </div>
                        @elseif ($existingLogo)
                            <div class="h-16 w-16 rounded-2xl border border-slate-200 bg-white p-2 grid place-items-center">
                                <img src="{{ $existingLogo }}" alt="Current Logo" class="max-h-full max-w-full object-contain">
                            </div>
                        @endif
                        <div class="flex-1">
                            <input
                                type="file"
                                wire:model="logo"
                                accept="image/*"
                                class="w-full text-xs text-slate-600 file:mr-3 file:rounded-xl file:border-0 file:bg-slate-900 file:px-4 file:py-2 file:text-xs file:font-semibold file:text-white hover:file:bg-slate-800"
                            />
                        </div>
                    </div>
                </div>

                <!-- Favicon Upload -->
                <div class="rounded-2xl border border-slate-100 bg-slate-50/50 p-5">
                    <label class="block text-xs font-bold text-slate-700">Favicon Browser</label>
                    <div class="mt-3 flex items-center gap-4">
                        @if ($favicon)
                            <div class="h-16 w-16 rounded-2xl border border-sky-300 bg-white p-2 grid place-items-center">
                                <img src="{{ $favicon->temporaryUrl() }}" alt="Preview" class="max-h-full max-w-full object-contain">
                            </div>
                        @elseif ($existingFavicon)
                            <div class="h-16 w-16 rounded-2xl border border-slate-200 bg-white p-2 grid place-items-center">
                                <img src="{{ $existingFavicon }}" alt="Current Favicon" class="max-h-full max-w-full object-contain">
                            </div>
                        @endif
                        <div class="flex-1">
                            <input
                                type="file"
                                wire:model="favicon"
                                accept="image/*"
                                class="w-full text-xs text-slate-600 file:mr-3 file:rounded-xl file:border-0 file:bg-slate-900 file:px-4 file:py-2 file:text-xs file:font-semibold file:text-white hover:file:bg-slate-800"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. OPTIMASI SEO & ANALYTICS -->
        <div class="rounded-[2.5rem] border border-slate-200/80 bg-white/90 p-6 sm:p-8 shadow-xs backdrop-blur space-y-6">
            <h2 class="text-xl font-bold text-slate-900">2. Optimasi SEO Global & Google Analytics (GA4)</h2>

            <div class="grid gap-6 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700">Default Meta Title</label>
                    <input
                        type="text"
                        wire:model="seo_title"
                        class="mt-1.5 w-full rounded-2xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm font-medium text-slate-900 outline-none focus:border-sky-500 focus:bg-white"
                        placeholder="Sankara Tech - Digital Agency"
                    />
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700">Default Meta Description</label>
                    <textarea
                        wire:model="seo_description"
                        rows="3"
                        class="mt-1.5 w-full rounded-2xl border border-slate-200 bg-slate-50/50 p-4 text-sm font-medium text-slate-900 outline-none focus:border-sky-500 focus:bg-white"
                    ></textarea>
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700">Meta Keywords</label>
                    <input
                        type="text"
                        wire:model="seo_keywords"
                        class="mt-1.5 w-full rounded-2xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm font-medium text-slate-900 outline-none focus:border-sky-500 focus:bg-white"
                    />
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700">Google Analytics 4 (Measurement ID)</label>
                    <input
                        type="text"
                        wire:model="ga4_id"
                        class="mt-1.5 w-full rounded-2xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm font-mono text-slate-900 outline-none focus:border-sky-500 focus:bg-white"
                        placeholder="G-XXXXXXXXXX"
                    />
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700">Google Search Console Verification Code</label>
                    <input
                        type="text"
                        wire:model="gsc_verification"
                        class="mt-1.5 w-full rounded-2xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm font-mono text-slate-900 outline-none focus:border-sky-500 focus:bg-white"
                    />
                </div>

                <!-- OG Image Upload -->
                <div class="sm:col-span-2 rounded-2xl border border-slate-100 bg-slate-50/50 p-5">
                    <label class="block text-xs font-bold text-slate-700">Default OpenGraph Share Image</label>
                    <div class="mt-3 flex items-center gap-4">
                        @if ($og_image_file)
                            <div class="h-16 w-28 rounded-2xl border border-sky-300 bg-white p-2 grid place-items-center">
                                <img src="{{ $og_image_file->temporaryUrl() }}" alt="Preview" class="max-h-full max-w-full object-contain">
                            </div>
                        @elseif ($existingOgImage)
                            <div class="h-16 w-28 rounded-2xl border border-slate-200 bg-white p-2 grid place-items-center">
                                <img src="{{ $existingOgImage }}" alt="Current OG Image" class="max-h-full max-w-full object-contain">
                            </div>
                        @endif
                        <div class="flex-1">
                            <input
                                type="file"
                                wire:model="og_image_file"
                                accept="image/*"
                                class="w-full text-xs text-slate-600 file:mr-3 file:rounded-xl file:border-0 file:bg-slate-900 file:px-4 file:py-2 file:text-xs file:font-semibold file:text-white hover:file:bg-slate-800"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. HEADER NAVIGATION -->
        <div class="rounded-[2.5rem] border border-slate-200/80 bg-white/90 p-6 sm:p-8 shadow-xs backdrop-blur space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-slate-900">3. Header Navigation (Menu Utama)</h2>
                    <p class="text-xs text-slate-500">Atur tautan menu pada header atas website</p>
                </div>
                <button
                    type="button"
                    wire:click="addHeaderNavItem"
                    class="rounded-xl border border-slate-200 bg-slate-900 px-3.5 py-2 text-xs font-bold text-white transition hover:bg-slate-800"
                >
                    + Tambah Menu
                </button>
            </div>

            <div class="space-y-3">
                @foreach ($header_nav as $idx => $item)
                    <div class="flex items-center gap-3">
                        <div class="w-1/3">
                            <input
                                type="text"
                                wire:model="header_nav.{{ $idx }}.label"
                                placeholder="Label Menu"
                                class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-3 py-2.5 text-xs font-bold text-slate-900 outline-none focus:border-sky-500 focus:bg-white"
                            />
                        </div>
                        <div class="flex-1">
                            <input
                                type="text"
                                wire:model="header_nav.{{ $idx }}.url"
                                placeholder="URL Target (/layanan)"
                                class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-3 py-2.5 text-xs font-medium text-slate-900 outline-none focus:border-sky-500 focus:bg-white"
                            />
                        </div>
                        <button
                            type="button"
                            wire:click="removeHeaderNavItem({{ $idx }})"
                            class="grid h-8 w-8 shrink-0 place-items-center rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 transition"
                        >
                            <i class="fa-solid fa-trash text-xs"></i>
                        </button>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- 4. BOTTOM NAVIGATION (MOBILE) -->
        <div class="rounded-[2.5rem] border border-slate-200/80 bg-white/90 p-6 sm:p-8 shadow-xs backdrop-blur space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-slate-900">4. Bottom Navigation (Mobile Bar)</h2>
                    <p class="text-xs text-slate-500">Atur menu navigasi bawah pada perangkat mobile / HP</p>
                </div>
                <button
                    type="button"
                    wire:click="addBottomNavItem"
                    class="rounded-xl border border-slate-200 bg-slate-900 px-3.5 py-2 text-xs font-bold text-white transition hover:bg-slate-800"
                >
                    + Tambah Item
                </button>
            </div>

            <div class="space-y-3">
                @foreach ($bottom_nav as $idx => $item)
                    <div class="flex items-center gap-3">
                        <div class="w-1/4">
                            <input
                                type="text"
                                wire:model="bottom_nav.{{ $idx }}.label"
                                placeholder="Label"
                                class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-3 py-2.5 text-xs font-bold text-slate-900 outline-none focus:border-sky-500 focus:bg-white"
                            />
                        </div>
                        <div class="w-1/3">
                            <input
                                type="text"
                                wire:model="bottom_nav.{{ $idx }}.url"
                                placeholder="URL Target"
                                class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-3 py-2.5 text-xs font-medium text-slate-900 outline-none focus:border-sky-500 focus:bg-white"
                            />
                        </div>
                        <div class="flex-1">
                            <select
                                wire:model="bottom_nav.{{ $idx }}.icon"
                                class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-3 py-2.5 text-xs font-medium text-slate-900 outline-none focus:border-sky-500 focus:bg-white"
                            >
                                <option value="home">Home</option>
                                <option value="services">Layanan</option>
                                <option value="portfolios">Portofolio</option>
                                <option value="contact">Kontak</option>
                                <option value="info">Info / About</option>
                                <option value="grid">Grid / Dashboard</option>
                            </select>
                        </div>
                        <button
                            type="button"
                            wire:click="removeBottomNavItem({{ $idx }})"
                            class="grid h-8 w-8 shrink-0 place-items-center rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 transition"
                        >
                            <i class="fa-solid fa-trash text-xs"></i>
                        </button>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- 5. FOOTER & COPYRIGHT -->
        <div class="rounded-[2.5rem] border border-slate-200/80 bg-white/90 p-6 sm:p-8 shadow-xs backdrop-blur space-y-6">
            <h2 class="text-xl font-bold text-slate-900">5. Informasi Footer Website</h2>

            <div class="grid gap-6 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700">Deskripsi Footer</label>
                    <textarea
                        wire:model="footer_description"
                        rows="3"
                        class="mt-1.5 w-full rounded-2xl border border-slate-200 bg-slate-50/50 p-4 text-sm font-medium text-slate-900 outline-none focus:border-sky-500 focus:bg-white"
                    ></textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700">Teks Hak Cipta (Copyright)</label>
                    <input
                        type="text"
                        wire:model="footer_copyright"
                        class="mt-1.5 w-full rounded-2xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm font-medium text-slate-900 outline-none focus:border-sky-500 focus:bg-white"
                    />
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700">Subtitle Footer</label>
                    <input
                        type="text"
                        wire:model="footer_subtext"
                        class="mt-1.5 w-full rounded-2xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm font-medium text-slate-900 outline-none focus:border-sky-500 focus:bg-white"
                    />
                </div>
            </div>
        </div>

        <!-- 6. KONTAK & MEDIA SOSIAL -->
        <div class="rounded-[2.5rem] border border-slate-200/80 bg-white/90 p-6 sm:p-8 shadow-xs backdrop-blur space-y-6">
            <h2 class="text-xl font-bold text-slate-900">6. Informasi Kontak & Sosial Media</h2>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label class="block text-xs font-bold text-slate-700">Email Utama</label>
                    <input
                        type="email"
                        wire:model="contact.email"
                        class="mt-1.5 w-full rounded-2xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm font-medium text-slate-900 outline-none focus:border-sky-500 focus:bg-white"
                    />
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700">Nomor WhatsApp</label>
                    <input
                        type="text"
                        wire:model="contact.whatsapp"
                        class="mt-1.5 w-full rounded-2xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm font-medium text-slate-900 outline-none focus:border-sky-500 focus:bg-white"
                    />
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700">Alamat Kantor</label>
                    <input
                        type="text"
                        wire:model="contact.address"
                        class="mt-1.5 w-full rounded-2xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm font-medium text-slate-900 outline-none focus:border-sky-500 focus:bg-white"
                    />
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700">Jam Operasional</label>
                    <input
                        type="text"
                        wire:model="contact.hours"
                        class="mt-1.5 w-full rounded-2xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm font-medium text-slate-900 outline-none focus:border-sky-500 focus:bg-white"
                    />
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700">Google Maps Embed URL</label>
                    <input
                        type="text"
                        wire:model="contact.map_embed_url"
                        class="mt-1.5 w-full rounded-2xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm font-medium text-slate-900 outline-none focus:border-sky-500 focus:bg-white"
                    />
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700">Instagram</label>
                    <input
                        type="text"
                        wire:model="socials.instagram"
                        class="mt-1.5 w-full rounded-2xl border border-slate-200 bg-slate-50/50 px-4 py-2.5 text-xs font-medium text-slate-900 outline-none focus:border-sky-500 focus:bg-white"
                    />
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700">TikTok</label>
                    <input
                        type="text"
                        wire:model="socials.tiktok"
                        class="mt-1.5 w-full rounded-2xl border border-slate-200 bg-slate-50/50 px-4 py-2.5 text-xs font-medium text-slate-900 outline-none focus:border-sky-500 focus:bg-white"
                    />
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700">X / Twitter</label>
                    <input
                        type="text"
                        wire:model="socials.twitter"
                        class="mt-1.5 w-full rounded-2xl border border-slate-200 bg-slate-50/50 px-4 py-2.5 text-xs font-medium text-slate-900 outline-none focus:border-sky-500 focus:bg-white"
                    />
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700">LinkedIn</label>
                    <input
                        type="text"
                        wire:model="socials.linkedin"
                        class="mt-1.5 w-full rounded-2xl border border-slate-200 bg-slate-50/50 px-4 py-2.5 text-xs font-medium text-slate-900 outline-none focus:border-sky-500 focus:bg-white"
                    />
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700">Discord</label>
                    <input
                        type="text"
                        wire:model="socials.discord"
                        class="mt-1.5 w-full rounded-2xl border border-slate-200 bg-slate-50/50 px-4 py-2.5 text-xs font-medium text-slate-900 outline-none focus:border-sky-500 focus:bg-white"
                    />
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700">WhatsApp</label>
                    <input
                        type="text"
                        wire:model="socials.whatsapp"
                        class="mt-1.5 w-full rounded-2xl border border-slate-200 bg-slate-50/50 px-4 py-2.5 text-xs font-medium text-slate-900 outline-none focus:border-sky-500 focus:bg-white"
                    />
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700">Dribbble</label>
                    <input
                        type="text"
                        wire:model="socials.dribbble"
                        class="mt-1.5 w-full rounded-2xl border border-slate-200 bg-slate-50/50 px-4 py-2.5 text-xs font-medium text-slate-900 outline-none focus:border-sky-500 focus:bg-white"
                    />
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700">GitHub</label>
                    <input
                        type="text"
                        wire:model="socials.github"
                        class="mt-1.5 w-full rounded-2xl border border-slate-200 bg-slate-50/50 px-4 py-2.5 text-xs font-medium text-slate-900 outline-none focus:border-sky-500 focus:bg-white"
                    />
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700">YouTube</label>
                    <input
                        type="text"
                        wire:model="socials.youtube"
                        class="mt-1.5 w-full rounded-2xl border border-slate-200 bg-slate-50/50 px-4 py-2.5 text-xs font-medium text-slate-900 outline-none focus:border-sky-500 focus:bg-white"
                    />
                </div>
            </div>
        </div>

        <div class="flex justify-end pt-2">
            <button
                type="submit"
                wire:loading.attr="disabled"
                class="brand-gradient rounded-2xl px-8 py-3.5 text-sm font-bold text-white shadow-md transition hover:-translate-y-0.5"
            >
                Simpan Semua Pengaturan
            </button>
        </div>
    </form>
</div>
