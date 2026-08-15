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
    <div class="pointer-events-none absolute inset-0" aria-hidden="true">
        <div class="absolute -bottom-28 -left-24 h-96 w-96 rounded-full bg-[rgb(var(--agency-cyan)/0.14)] blur-3xl"></div>
        <div class="absolute -bottom-24 -right-24 h-96 w-96 rounded-full bg-white/10 blur-3xl"></div>
        <div class="absolute inset-x-0 top-0 h-20 bg-gradient-to-b from-white/5 to-transparent"></div>
    </div>

    <div class="relative mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
        <div class="grid gap-10 lg:grid-cols-4">
            <div class="lg:col-span-2">
                <div class="flex items-center gap-3">
                    <img src="{{ $siteLogo }}" alt="{{ $siteName }} Logo" width="36" height="36" loading="lazy" class="h-9 w-9 object-contain">
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
                <nav class="mt-4 grid gap-2 text-sm font-medium text-white/75" aria-label="Navigasi Footer">
                    <a class="hover:text-white transition-colors" href="{{ $href('tentang') }}">Tentang Kami</a>
                    <a class="hover:text-white transition-colors" href="{{ $href('layanan') }}">Layanan</a>
                    <a class="hover:text-white transition-colors" href="{{ $href('portofolio') }}">Portofolio</a>
                    <a class="hover:text-white transition-colors" href="{{ $href('harga') }}">Harga</a>
                    <a class="hover:text-white transition-colors" href="{{ route('contact.show') }}">Kontak</a>
                </nav>
            </div>

            <div>
                <div class="text-sm font-semibold text-white">Kontak</div>
                <div class="mt-4 grid gap-3 text-sm font-medium text-white/75">
                    <div class="flex items-start gap-3">
                        <i class="fa-solid fa-envelope mt-0.5 text-[rgb(var(--agency-cyan))]" aria-hidden="true"></i>
                        <span>{{ $email }}</span>
                    </div>
                    <div class="flex items-start gap-3">
                        <i class="fa-brands fa-whatsapp mt-0.5 text-[rgb(var(--agency-cyan))]" aria-hidden="true"></i>
                        <span>{{ $whatsapp }}</span>
                    </div>
                    <div class="flex items-start gap-3">
                        <i class="fa-solid fa-location-dot mt-0.5 text-[rgb(var(--agency-cyan))]" aria-hidden="true"></i>
                        <span>{{ $address }}</span>
                    </div>
                </div>

                <div class="mt-6 flex flex-wrap items-center gap-3">
                    @if (filled($socials['instagram'] ?? null))
                        <a class="grid h-10 w-10 place-items-center rounded-2xl border border-white/15 bg-white/10 text-white shadow-none backdrop-blur transition hover:-translate-y-0.5 hover:bg-white/15" href="{{ $socials['instagram'] }}" aria-label="Instagram Sankara Tech" target="_blank" rel="noreferrer">
                            <i class="fa-brands fa-instagram text-base" aria-hidden="true"></i>
                        </a>
                    @endif
                    @if (filled($socials['linkedin'] ?? null))
                        <a class="grid h-10 w-10 place-items-center rounded-2xl border border-white/15 bg-white/10 text-white shadow-none backdrop-blur transition hover:-translate-y-0.5 hover:bg-white/15" href="{{ $socials['linkedin'] }}" aria-label="LinkedIn Sankara Tech" target="_blank" rel="noreferrer">
                            <i class="fa-brands fa-linkedin-in text-base" aria-hidden="true"></i>
                        </a>
                    @endif
                    @if (filled($socials['dribbble'] ?? null))
                        <a class="grid h-10 w-10 place-items-center rounded-2xl border border-white/15 bg-white/10 text-white shadow-none backdrop-blur transition hover:-translate-y-0.5 hover:bg-white/15" href="{{ $socials['dribbble'] }}" aria-label="Dribbble Sankara Tech" target="_blank" rel="noreferrer">
                            <i class="fa-brands fa-dribbble text-base" aria-hidden="true"></i>
                        </a>
                    @endif
                    @if (filled($socials['twitter'] ?? null))
                        <a class="grid h-10 w-10 place-items-center rounded-2xl border border-white/15 bg-white/10 text-white shadow-none backdrop-blur transition hover:-translate-y-0.5 hover:bg-white/15" href="{{ $socials['twitter'] }}" aria-label="Twitter Sankara Tech" target="_blank" rel="noreferrer">
                            <i class="fa-brands fa-x-twitter text-base" aria-hidden="true"></i>
                        </a>
                    @endif
                    @if (filled($socials['github'] ?? null))
                        <a class="grid h-10 w-10 place-items-center rounded-2xl border border-white/15 bg-white/10 text-white shadow-none backdrop-blur transition hover:-translate-y-0.5 hover:bg-white/15" href="{{ $socials['github'] }}" aria-label="GitHub Sankara Tech" target="_blank" rel="noreferrer">
                            <i class="fa-brands fa-github text-base" aria-hidden="true"></i>
                        </a>
                    @endif
                    @if (filled($socials['youtube'] ?? null))
                        <a class="grid h-10 w-10 place-items-center rounded-2xl border border-white/15 bg-white/10 text-white shadow-none backdrop-blur transition hover:-translate-y-0.5 hover:bg-white/15" href="{{ $socials['youtube'] }}" aria-label="YouTube Sankara Tech" target="_blank" rel="noreferrer">
                            <i class="fa-brands fa-youtube text-base" aria-hidden="true"></i>
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
