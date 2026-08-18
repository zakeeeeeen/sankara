<div>
    @include('partials.marketing-header', ['active' => 'about'])

    <main class="pt-28 pb-20 bg-white">
        <section class="relative overflow-hidden">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid gap-12 lg:grid-cols-2 lg:items-start">
                    <div>
                        <div class="reveal">
                            <h1 class="text-4xl font-bold tracking-tight text-slate-900 sm:text-5xl">
                                {{ $page->hero_title ?: $page->title }}
                            </h1>

                            @if ($page->hero_subtitle)
                                <p class="mt-4 max-w-3xl text-base leading-relaxed text-slate-600 sm:text-lg">
                                    {{ $page->hero_subtitle }}
                                </p>
                            @endif
                        </div>

                        @if ($page->body)
                            <div class="mt-8 prose prose-slate prose-headings:font-bold prose-a:text-sky-600 prose-blockquote:border-sky-500 max-w-none reveal">
                                {!! $page->body !!}
                            </div>
                        @endif

                        <div class="mt-8">
                            <a href="{{ route('contact.show') }}" wire:navigate class="agency-btn-primary inline-flex items-center justify-center gap-2 px-8 py-3.5 text-sm font-semibold">
                                <span>Konsultasi dengan Kami</span>
                                <i class="fa-solid fa-arrow-right text-xs"></i>
                            </a>
                        </div>
                    </div>

                    <div class="reveal">
                        <div class="agency-card overflow-hidden p-2">
                            @if ($page->image_src)
                                <img class="h-full w-full rounded-2xl object-cover" src="{{ $page->image_src }}" alt="{{ $page->title }}" />
                            @else
                                <div class="h-[340px] w-full rounded-2xl bg-[linear-gradient(135deg,rgb(var(--agency-navy-1)),rgb(var(--agency-navy-2)))] flex items-center justify-center p-8 text-center text-white">
                                    <div class="text-xl font-bold">Sankara Tech Digital Agency</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>
