<div>
    @php
        $contact = is_array($contact ?? null) ? $contact : [];
        $publicEmail = $contact['email'] ?? ($contact['inbox_email'] ?? '');
        $publicWhatsapp = $contact['whatsapp'] ?? '';
        $publicAddress = $contact['address'] ?? '';
        $publicHours = $contact['hours'] ?? '';
        $mapEmbedUrl = $contact['map_embed_url'] ?? '';
    @endphp

    @include('partials.marketing-header', ['active' => 'contact'])

    <main class="pt-28 pb-20 bg-white">
        <section class="relative overflow-hidden">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid gap-12 lg:grid-cols-[1fr_1.2fr] lg:items-start">
                    <div class="reveal">
                        <div class="agency-divider"></div>
                        <h1 class="mt-4 text-4xl font-bold tracking-tight text-slate-900 sm:text-5xl">Hubungi Tim Kami</h1>
                        <p class="mt-4 max-w-xl text-base leading-relaxed text-slate-600 sm:text-lg">
                            Kami siap membantu mewujudkan ide digital Anda. Hubungi tim kami untuk diskusi, konsultasi, atau penawaran proyek terbaik.
                        </p>

                        <div class="mt-8 grid gap-4">
                            <div class="agency-card flex items-start gap-4 p-5">
                                <div class="grid h-11 w-11 flex-none place-items-center rounded-2xl border border-sky-100 bg-[rgb(var(--agency-cyan)/0.12)] text-[rgb(var(--agency-cyan))]">
                                    <i class="fa-solid fa-location-dot text-base"></i>
                                </div>
                                <div class="min-w-0">
                                    <div class="text-sm font-bold text-[rgb(var(--agency-navy-1))]">Alamat</div>
                                    <div class="mt-1 text-sm leading-relaxed text-slate-600">{{ $publicAddress ?: '-' }}</div>
                                </div>
                            </div>

                            <div class="agency-card flex items-start gap-4 p-5">
                                <div class="grid h-11 w-11 flex-none place-items-center rounded-2xl border border-sky-100 bg-[rgb(var(--agency-cyan)/0.12)] text-[rgb(var(--agency-cyan))]">
                                    <i class="fa-solid fa-envelope text-base"></i>
                                </div>
                                <div class="min-w-0">
                                    <div class="text-sm font-bold text-[rgb(var(--agency-navy-1))]">Email</div>
                                    <div class="mt-1 text-sm leading-relaxed text-slate-600 break-all">{{ $publicEmail ?: '-' }}</div>
                                </div>
                            </div>

                            <div class="agency-card flex items-start gap-4 p-5">
                                <div class="grid h-11 w-11 flex-none place-items-center rounded-2xl border border-sky-100 bg-[rgb(var(--agency-cyan)/0.12)] text-[rgb(var(--agency-cyan))]">
                                    <i class="fa-brands fa-whatsapp text-lg"></i>
                                </div>
                                <div class="min-w-0">
                                    <div class="text-sm font-bold text-[rgb(var(--agency-navy-1))]">WhatsApp / Telepon</div>
                                    <div class="mt-1 text-sm leading-relaxed text-slate-600">{{ $publicWhatsapp ?: '-' }}</div>
                                </div>
                            </div>

                            <div class="agency-card flex items-start gap-4 p-5">
                                <div class="grid h-11 w-11 flex-none place-items-center rounded-2xl border border-sky-100 bg-[rgb(var(--agency-cyan)/0.12)] text-[rgb(var(--agency-cyan))]">
                                    <i class="fa-solid fa-clock text-base"></i>
                                </div>
                                <div class="min-w-0">
                                    <div class="text-sm font-bold text-[rgb(var(--agency-navy-1))]">Jam Operasional</div>
                                    <div class="mt-1 text-sm leading-relaxed text-slate-600">{{ $publicHours ?: '-' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="form" class="reveal scroll-mt-28">
                        <livewire:contact-form />
                    </div>
                </div>

                <div class="mt-14 agency-card overflow-hidden p-0 reveal">
                    @if (filled($mapEmbedUrl))
                        <iframe
                            src="{{ $mapEmbedUrl }}"
                            width="100%"
                            height="400"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                        ></iframe>
                    @else
                        <div class="grid h-[320px] place-items-center text-sm font-semibold text-slate-500">Map belum diatur.</div>
                    @endif
                </div>
            </div>
        </section>
    </main>
</div>
