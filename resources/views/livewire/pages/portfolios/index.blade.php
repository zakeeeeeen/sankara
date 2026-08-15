<div>
    @include('partials.marketing-header', ['active' => 'portfolios'])

    <main class="pt-28 pb-20 bg-slate-50">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="reveal">
                <div class="agency-divider"></div>
                <h1 class="mt-4 text-4xl font-bold tracking-tight text-[rgb(var(--agency-navy-1))] sm:text-5xl">Portofolio Project</h1>
                <p class="mt-4 max-w-3xl text-base leading-relaxed text-slate-600 sm:text-lg">
                    Eksplorasi karya dan solusi digital yang telah kami bangun bersama para partner dan klien.
                </p>
            </div>

            <div class="mt-10">
                <livewire:portfolio-browser />
            </div>
        </div>
    </main>
</div>
