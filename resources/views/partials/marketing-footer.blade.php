@php
    $home = route('home');
    $isHome = request()->routeIs('home');

    $siteName = \App\Models\SiteSetting::getValue('site_name', 'Sankara Tech');
    $siteTagline = \App\Models\SiteSetting::getValue('site_tagline', 'Digital Agency');
    $siteLogo = \App\Models\SiteSetting::getValue('site_logo', asset('logosankara.png'));

    $footerDescription = \App\Models\SiteSetting::getValue('footer_description', 'Kami membangun produk digital modern: website, software, aplikasi mobile, UI/UX, game development, dan 3D modeling—dengan kualitas premium yang meyakinkan.');
    $footerCopyright = \App\Models\SiteSetting::getValue('footer_copyright', '© ' . date('Y') . ' ' . $siteName . '. All rights reserved.');
    $footerSubtext = \App\Models\SiteSetting::getValue('footer_subtext', 'Built with Laravel • Blade • Livewire • Tailwind');

    $contact = \App\Models\SiteSetting::getValue('contact', []);
    $socials = \App\Models\SiteSetting::getValue('socials', []);

    $emailRaw = $contact['email'] ?? ($contact['inbox_email'] ?? null);
    $email = filled($emailRaw) ? $emailRaw : 'hello@sankaratech.com';

    $whatsappRaw = $contact['whatsapp'] ?? null;
    $whatsapp = filled($whatsappRaw) ? $whatsappRaw : '+62 812-0000-0000';

    $addressRaw = $contact['address'] ?? null;
    $address = filled($addressRaw) ? $addressRaw : 'Jakarta, Indonesia';

    $href = fn (string $anchor) => $isHome ? ('#' . $anchor) : ($home . '#' . $anchor);
@endphp

<footer class="relative overflow-hidden bg-[linear-gradient(135deg,rgb(var(--agency-navy-1)),rgb(var(--agency-navy-2)))] text-white">
    <div class="pointer-events-none absolute inset-0">
        <div class="absolute -bottom-28 -left-24 h-96 w-96 rounded-full bg-[rgb(var(--agency-cyan)/0.14)] blur-3xl"></div>
        <div class="absolute -bottom-24 -right-24 h-96 w-96 rounded-full bg-white/10 blur-3xl"></div>
        <div class="absolute inset-x-0 top-0 h-20 bg-gradient-to-b from-white/5 to-transparent"></div>
    </div>

    <div class="relative mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
        <div class="grid gap-10 lg:grid-cols-4">
            <div class="lg:col-span-2">
                <div class="flex items-center gap-3">
                    <img src="{{ $siteLogo }}" alt="{{ $siteName }} Logo" class="h-9 w-9 object-contain">
                    <div>
                        <div class="text-sm font-semibold text-white">{{ $siteName }}</div>
                        <div class="text-xs font-medium text-white/65">{{ $siteTagline }}</div>
                    </div>
                </div>

                <p class="mt-4 max-w-xl text-sm leading-relaxed text-white/75">
                    {{ $footerDescription }}
                </p>
            </div>

            <div>
                <div class="text-sm font-semibold text-white">Navigasi</div>
                <div class="mt-4 grid gap-2 text-sm font-medium text-white/75">
                    <a class="hover:text-white transition-colors" href="{{ $href('tentang') }}">Tentang Kami</a>
                    <a class="hover:text-white transition-colors" href="{{ $href('layanan') }}">Layanan</a>
                    <a class="hover:text-white transition-colors" href="{{ $href('portofolio') }}">Portofolio</a>
                    <a class="hover:text-white transition-colors" href="{{ $href('harga') }}">Harga</a>
                    <a class="hover:text-white transition-colors" href="{{ route('contact.show') }}">Kontak</a>
                </div>
            </div>

            <div>
                <div class="text-sm font-semibold text-white">Kontak</div>
                <div class="mt-4 grid gap-3 text-sm font-medium text-white/75">
                    <div class="flex items-start gap-3">
                        <svg viewBox="0 0 24 24" fill="none" class="mt-0.5 h-5 w-5 text-[rgb(var(--agency-cyan))]">
                            <path d="M4 6.5l8 6 8-6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M5 7h14v10H5V7Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                        </svg>
                        <span>{{ $email }}</span>
                    </div>
                    <div class="flex items-start gap-3">
                        <svg viewBox="0 0 24 24" fill="none" class="mt-0.5 h-5 w-5 text-[rgb(var(--agency-cyan))]">
                            <path d="M6 3h4l2 5-2.5 1.5a16 16 0 0 0 7 7L18 15l5 2v4c0 1.1-.9 2-2 2C10.4 23 1 13.6 1 3c0-1.1.9-2 2-2h3Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span>{{ $whatsapp }}</span>
                    </div>
                    <div class="flex items-start gap-3">
                        <svg viewBox="0 0 24 24" fill="none" class="mt-0.5 h-5 w-5 text-[rgb(var(--agency-cyan))]">
                            <path d="M12 21s7-5.5 7-11a7 7 0 1 0-14 0c0 5.5 7 11 7 11Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M12 10.5a2.2 2.2 0 1 0 0-4.4 2.2 2.2 0 0 0 0 4.4Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span>{{ $address }}</span>
                    </div>
                </div>

                <div class="mt-6 flex flex-wrap items-center gap-3">
                    @if (filled($socials['instagram'] ?? null))
                        <a class="grid h-10 w-10 place-items-center rounded-2xl border border-white/15 bg-white/10 text-white shadow-none backdrop-blur transition hover:-translate-y-0.5 hover:bg-white/15" href="{{ $socials['instagram'] }}" aria-label="Instagram" target="_blank" rel="noreferrer">
                            <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5">
                                <path d="M7 3h10a4 4 0 0 1 4 4v10a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4V7a4 4 0 0 1 4-4Z" stroke="currentColor" stroke-width="1.8"/>
                                <path d="M12 16a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z" stroke="currentColor" stroke-width="1.8"/>
                                <path d="M17.5 6.5h.01" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/>
                            </svg>
                        </a>
                    @endif
                    @if (filled($socials['linkedin'] ?? null))
                        <a class="grid h-10 w-10 place-items-center rounded-2xl border border-white/15 bg-white/10 text-white shadow-none backdrop-blur transition hover:-translate-y-0.5 hover:bg-white/15" href="{{ $socials['linkedin'] }}" aria-label="LinkedIn" target="_blank" rel="noreferrer">
                            <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5">
                                <path d="M6 9v12" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                <path d="M6 6.5h.01" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/>
                                <path d="M10 21V9" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                <path d="M10 13.5c0-2.5 1.5-4.5 4-4.5s4 2 4 4.5V21" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    @endif
                    @if (filled($socials['dribbble'] ?? null))
                        <a class="grid h-10 w-10 place-items-center rounded-2xl border border-white/15 bg-white/10 text-white shadow-none backdrop-blur transition hover:-translate-y-0.5 hover:bg-white/15" href="{{ $socials['dribbble'] }}" aria-label="Dribbble" target="_blank" rel="noreferrer">
                            <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5">
                                <path d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Z" stroke="currentColor" stroke-width="1.8"/>
                                <path d="M4.5 7.5c4.5 2 7.5 6.5 8.8 13" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                <path d="M19.5 6.5c-4 2.5-9.5 3.5-15.5 2.8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                <path d="M21 13c-4.2-1-8.8.5-12 4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                            </svg>
                        </a>
                    @endif
                    @if (filled($socials['twitter'] ?? null))
                        <a class="grid h-10 w-10 place-items-center rounded-2xl border border-white/15 bg-white/10 text-white shadow-none backdrop-blur transition hover:-translate-y-0.5 hover:bg-white/15" href="{{ $socials['twitter'] }}" aria-label="Twitter / X" target="_blank" rel="noreferrer">
                            <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5">
                                <path d="M4 4l11.733 16h4.267l-11.733-16zM4 20l6.768-6.768M13.232 10.768L20 4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    @endif
                    @if (filled($socials['github'] ?? null))
                        <a class="grid h-10 w-10 place-items-center rounded-2xl border border-white/15 bg-white/10 text-white shadow-none backdrop-blur transition hover:-translate-y-0.5 hover:bg-white/15" href="{{ $socials['github'] }}" aria-label="GitHub" target="_blank" rel="noreferrer">
                            <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5">
                                <path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    @endif
                    @if (filled($socials['youtube'] ?? null))
                        <a class="grid h-10 w-10 place-items-center rounded-2xl border border-white/15 bg-white/10 text-white shadow-none backdrop-blur transition hover:-translate-y-0.5 hover:bg-white/15" href="{{ $socials['youtube'] }}" aria-label="YouTube" target="_blank" rel="noreferrer">
                            <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5">
                                <path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                <polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02" fill="currentColor"/>
                            </svg>
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <div class="mt-10 flex flex-col gap-2 border-t border-white/15 pt-6 text-sm text-white/65 sm:flex-row sm:items-center sm:justify-between">
            <div>{{ $footerCopyright }}</div>
            <div class="text-white/65">{{ $footerSubtext }}</div>
        </div>
    </div>
</footer>
