<?php

namespace Database\Seeders;

use App\Models\Advantage;
use App\Models\HomeAbout;
use App\Models\HomeCta;
use App\Models\HomeHero;
use App\Models\Page;
use App\Models\Portfolio;
use App\Models\PortfolioCategory;
use App\Models\PricingFeature;
use App\Models\PricingPlan;
use App\Models\Service;
use App\Models\ServiceFeature;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CmsSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@sankaratech.test'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'is_admin' => true,
            ],
        );

        HomeHero::query()->firstOrCreate([], [
            'heading' => 'Inovasi Digital untuk Pertumbuhan Bisnis Anda',
            'subheading' => 'Kami membantu bisnis berkembang melalui solusi digital modern seperti website, aplikasi mobile, software custom, desain kreatif, game development, dan 3D modeling.',
            'primary_cta_label' => 'Mulai Proyek',
            'primary_cta_url' => '#kontak',
            'secondary_cta_label' => 'Lihat Portofolio',
            'secondary_cta_url' => '#portofolio',
        ]);

        HomeAbout::query()->firstOrCreate([], [
            'eyebrow' => 'Tentang Kami',
            'heading' => 'Startup digital yang fokus pada inovasi, kreativitas, dan teknologi modern',
            'body' => 'Kami merancang pengalaman digital end-to-end—mulai dari strategi, desain UI/UX, hingga pengembangan website, software, mobile apps, game, dan 3D asset. Fokus kami sederhana: hasil yang elegan, cepat, dan siap scale.',
        ]);

        if (Advantage::query()->count() === 0) {
            $items = [
                ['Desain Modern & Responsif', 'UI clean, premium, dan nyaman di semua device.'],
                ['Pengerjaan Cepat', 'Proses iterasi rapi dengan milestone yang jelas.'],
                ['Tim Profesional', 'Berpengalaman membangun produk digital end-to-end.'],
                ['Support & Maintenance', 'Pendampingan setelah launch agar tetap stabil.'],
                ['Teknologi Terbaru', 'Stack modern yang siap perform dan aman.'],
                ['Harga Kompetitif', 'Value tinggi dengan biaya yang transparan.'],
            ];

            foreach ($items as $i => [$title, $desc]) {
                Advantage::query()->create([
                    'title' => $title,
                    'description' => $desc,
                    'icon' => 'check',
                    'sort_order' => $i + 1,
                ]);
            }
        }

        if (Service::query()->count() === 0) {
            $services = [
                [
                    'Website Development',
                    'Website cepat, SEO-friendly, dan siap scaling.',
                    'Kami bangun website modern yang ringan, responsif, dan mudah dikelola—mulai dari company profile, landing page, sampai portal bisnis. Fokus pada performa, struktur SEO, dan tampilan premium agar siap dipakai untuk growth.',
                ],
                [
                    'Software Development',
                    'Software custom untuk otomatisasi proses bisnis.',
                    'Solusi software sesuai alur kerja bisnismu: dashboard, CRM, inventory, laporan, sampai integrasi API. Kami rancang arsitektur yang rapi dan aman supaya mudah dikembangkan saat kebutuhan bertambah.',
                ],
                [
                    'Mobile App Development',
                    'Aplikasi iOS/Android dengan UX yang elegan.',
                    'Pengembangan aplikasi mobile end-to-end: riset kebutuhan, desain UI/UX, build fitur, testing, sampai rilis. Hasilnya aplikasi yang stabil, cepat, dan nyaman digunakan untuk user harian.',
                ],
                [
                    'UI/UX Design',
                    'Desain premium yang fokus pada konversi dan usability.',
                    'Desain UI/UX yang clean dan futuristik untuk meningkatkan kepercayaan dan konversi. Termasuk wireframe, design system, prototype, dan handoff yang rapi agar proses development lebih cepat.',
                ],
                [
                    'Game Development',
                    'Game 2D/3D untuk brand experience dan hiburan.',
                    'Pembuatan game 2D/3D untuk kebutuhan edukasi, promosi brand, atau hiburan. Kami fokus pada gameplay yang jelas, visual menarik, dan optimasi performa agar tetap lancar di berbagai device.',
                ],
                [
                    '3D Modeling',
                    '3D asset & visualisasi produk yang detail dan realistis.',
                    'Pembuatan 3D modeling untuk produk, karakter, environment, maupun visualisasi arsitektur. Output siap untuk rendering, animasi, atau kebutuhan marketing dengan kualitas detail yang konsisten.',
                ],
            ];

            foreach ($services as $i => [$title, $excerpt, $description]) {
                $service = Service::query()->create([
                    'title' => $title,
                    'slug' => Str::slug($title),
                    'excerpt' => $excerpt,
                    'description' => $description,
                    'cta_label' => 'Lihat Selengkapnya',
                    'sort_order' => $i + 1,
                ]);

                ServiceFeature::query()->create([
                    'service_id' => $service->id,
                    'text' => 'Konsultasi & analisis kebutuhan',
                    'sort_order' => 1,
                ]);
                ServiceFeature::query()->create([
                    'service_id' => $service->id,
                    'text' => 'Desain UI/UX modern',
                    'sort_order' => 2,
                ]);
                ServiceFeature::query()->create([
                    'service_id' => $service->id,
                    'text' => 'Development & testing',
                    'sort_order' => 3,
                ]);
            }
        }

        $serviceDescriptions = [
            'website-development' => 'Kami bangun website modern yang ringan, responsif, dan mudah dikelola—mulai dari company profile, landing page, sampai portal bisnis. Fokus pada performa, struktur SEO, dan tampilan premium agar siap dipakai untuk growth.',
            'software-development' => 'Solusi software sesuai alur kerja bisnismu: dashboard, CRM, inventory, laporan, sampai integrasi API. Kami rancang arsitektur yang rapi dan aman supaya mudah dikembangkan saat kebutuhan bertambah.',
            'mobile-app-development' => 'Pengembangan aplikasi mobile end-to-end: riset kebutuhan, desain UI/UX, build fitur, testing, sampai rilis. Hasilnya aplikasi yang stabil, cepat, dan nyaman digunakan untuk user harian.',
            'ui-ux-design' => 'Desain UI/UX yang clean dan futuristik untuk meningkatkan kepercayaan dan konversi. Termasuk wireframe, design system, prototype, dan handoff yang rapi agar proses development lebih cepat.',
            'game-development' => 'Pembuatan game 2D/3D untuk kebutuhan edukasi, promosi brand, atau hiburan. Kami fokus pada gameplay yang jelas, visual menarik, dan optimasi performa agar tetap lancar di berbagai device.',
            '3d-modeling' => 'Pembuatan 3D modeling untuk produk, karakter, environment, maupun visualisasi arsitektur. Output siap untuk rendering, animasi, atau kebutuhan marketing dengan kualitas detail yang konsisten.',
        ];

        foreach ($serviceDescriptions as $slug => $description) {
            $service = Service::query()->where('slug', $slug)->first();
            if (! $service) {
                continue;
            }

            $current = trim((string) $service->description);
            $excerpt = trim((string) $service->excerpt);
            if ($current === '' || $current === $excerpt) {
                $service->description = $description;
                $service->save();
            }
        }

        $portfolioCategories = PortfolioCategory::query()
            ->orderBy('sort_order')
            ->get()
            ->keyBy(fn ($c) => mb_strtolower($c->name));

        $serviceMap = [
            'website development' => ['website'],
            'software development' => ['dashboard'],
            'mobile app development' => ['mobile app'],
            'ui/ux design' => ['website', 'dashboard', 'mobile app'],
            'game development' => ['game'],
            '3d modeling' => ['3d design'],
        ];

        foreach ($serviceMap as $serviceTitle => $categoryNames) {
            $service = Service::query()->where('title', $serviceTitle)->first()
                ?: Service::query()->where('title', Str::headline($serviceTitle))->first();

            if (! $service) {
                continue;
            }

            $ids = collect($categoryNames)
                ->map(fn ($name) => $portfolioCategories->get(mb_strtolower($name))?->id)
                ->filter()
                ->values()
                ->all();

            if (count($ids) > 0) {
                $service->portfolioCategories()->syncWithoutDetaching($ids);
            }
        }

        if (PricingPlan::query()->count() === 0) {
            $plans = [
                ['Basic', 'Mulai', 'Untuk landing page/website sederhana.', 'Mulai dari ...', false, ['UI modern', '1–3 halaman', 'Optimasi performa', 'Revisi terjadwal']],
                ['Professional', 'Populer', 'Cocok untuk bisnis yang butuh fitur lebih lengkap.', 'Mulai dari ...', true, ['UI/UX lengkap', 'Integrasi API', 'CMS / Dashboard', 'Support 30 hari']],
                ['Enterprise', 'Custom', 'Untuk produk skala besar & kebutuhan khusus.', 'Hubungi kami', false, ['Arsitektur scalable', 'Audit security', 'CI/CD setup', 'Support prioritas']],
            ];

            foreach ($plans as $i => [$name, $tag, $desc, $price, $popular, $features]) {
                $plan = PricingPlan::query()->create([
                    'name' => $name,
                    'tag' => $tag,
                    'description' => $desc,
                    'price_text' => $price,
                    'is_popular' => $popular,
                    'sort_order' => $i + 1,
                ]);

                foreach ($features as $j => $text) {
                    PricingFeature::query()->create([
                        'pricing_plan_id' => $plan->id,
                        'text' => $text,
                        'sort_order' => $j + 1,
                    ]);
                }
            }
        }

        HomeCta::query()->firstOrCreate([], [
            'heading' => 'Siap Membangun Produk Digital Anda?',
            'body' => 'Ceritakan kebutuhan Anda. Kami bantu dari ide hingga eksekusi—dengan desain futuristik, performa cepat, dan pengalaman pengguna yang elegan.',
            'primary_label' => 'Konsultasi Sekarang',
            'primary_url' => '#',
            'secondary_label' => 'Lihat Hasil Kami',
            'secondary_url' => '#portofolio',
        ]);

        Page::query()->updateOrCreate(
            ['slug' => 'tentang-kami'],
            [
                'title' => 'Tentang Kami',
                'hero_title' => 'Kami membangun produk digital modern yang siap scale',
                'hero_subtitle' => 'Fokus pada inovasi, desain premium, performa, dan pengalaman pengguna yang elegan.',
                'body' => 'Sankara Tech adalah digital agency yang membantu bisnis berkembang melalui produk digital modern. Kami menggabungkan strategi, desain, dan engineering agar hasilnya meyakinkan dan berdampak.',
            ],
        );

        $aboutPage = Page::query()->where('slug', 'tentang-kami')->first();
        if ($aboutPage && (! filled($aboutPage->image_url) || str_contains($aboutPage->image_url, 'kersa') || str_contains($aboutPage->image_url, 'sankara.png')) && ! filled($aboutPage->image_path)) {
            $aboutPage->image_url = '/logo.webp';
            $aboutPage->save();
        }

        if (PortfolioCategory::query()->count() === 0) {
            $cats = ['Website', 'Mobile App', 'Dashboard', 'Game', '3D Design'];
            foreach ($cats as $i => $name) {
                PortfolioCategory::query()->create([
                    'name' => $name,
                    'slug' => Str::slug($name),
                    'sort_order' => $i + 1,
                ]);
            }
        }

        $paths = glob(public_path('portofolio/*.{png,jpg,jpeg,webp}'), GLOB_BRACE) ?: [];
        foreach ($paths as $i => $p) {
            $name = pathinfo($p, PATHINFO_FILENAME);
            $slug = Str::slug($name);
            $publicUrl = '/portofolio/'.basename($p);

            $portfolio = Portfolio::query()->updateOrCreate(
                ['slug' => $slug],
                [
                    'title' => Str::headline($name),
                    'excerpt' => 'Preview project '.Str::headline($name).'.',
                    'preview_image_url' => $publicUrl,
                    'cover_image_url' => $publicUrl,
                    'is_active' => true,
                    'sort_order' => $i + 1,
                ],
            );

            if ($portfolio->categories()->count() === 0) {
                $defaultCategory = PortfolioCategory::query()->orderBy('sort_order')->first();
                if ($defaultCategory) {
                    $portfolio->categories()->syncWithoutDetaching([$defaultCategory->id]);
                }
            }
        }

        $existingContact = SiteSetting::getValue('contact', []);
        $contactDefaults = [
            'email' => 'zakinbesar@gmail.com',
            'whatsapp' => '0859183931050',
            'address' => 'Jakarta, Indonesia',
            'hours' => 'Senin–Jumat, 09.00–18.00 WIB',
            'inbox_email' => 'zakinbesar@gmail.com',
            'map_embed_url' => '',
        ];
        SiteSetting::setValue('contact', array_merge($contactDefaults, is_array($existingContact) ? $existingContact : []));

        $existingSocials = SiteSetting::getValue('socials', []);
        $socialDefaults = [
            'instagram' => '#',
            'linkedin' => '#',
            'dribbble' => '#',
        ];
        SiteSetting::setValue('socials', array_merge($socialDefaults, is_array($existingSocials) ? $existingSocials : []));

        if (! filled(SiteSetting::getValue('site_name'))) {
            SiteSetting::setValue('site_name', 'Sankara Tech');
        }

        if (! filled(SiteSetting::getValue('site_tagline'))) {
            SiteSetting::setValue('site_tagline', 'Digital Agency');
        }

        if (! filled(SiteSetting::getValue('site_logo')) || SiteSetting::getValue('site_logo') === '/logosankara.png') {
            SiteSetting::setValue('site_logo', '/logo.webp');
        }

        if (! filled(SiteSetting::getValue('site_favicon')) || SiteSetting::getValue('site_favicon') === '/logosankara.png') {
            SiteSetting::setValue('site_favicon', '/favicon.svg');
        }

        if (! filled(SiteSetting::getValue('footer_description'))) {
            SiteSetting::setValue('footer_description', 'Kami membangun produk digital modern: website, software, aplikasi mobile, UI/UX, game development, dan 3D modeling—dengan kualitas premium yang meyakinkan.');
        }

        if (! filled(SiteSetting::getValue('footer_copyright'))) {
            SiteSetting::setValue('footer_copyright', '© '.date('Y').' Sankara Tech. All rights reserved.');
        }

        if (! filled(SiteSetting::getValue('footer_subtext'))) {
            SiteSetting::setValue('footer_subtext', 'Built with Laravel • Blade • Livewire • Tailwind');
        }

        if (empty(SiteSetting::getValue('header_nav'))) {
            SiteSetting::setValue('header_nav', [
                ['key' => 'home', 'label' => 'Home', 'url' => '/'],
                ['key' => 'about', 'label' => 'Tentang Kami', 'url' => '/tentang-kami'],
                ['key' => 'services', 'label' => 'Layanan', 'url' => '/layanan'],
                ['key' => 'portfolios', 'label' => 'Portofolio', 'url' => '/portfolio'],
                ['key' => 'contact', 'label' => 'Kontak', 'url' => '/kontak'],
            ]);
        }

        if (empty(SiteSetting::getValue('bottom_nav'))) {
            SiteSetting::setValue('bottom_nav', [
                ['key' => 'home', 'label' => 'Home', 'url' => '/', 'icon' => 'home', 'custom_icon' => '', 'is_active' => true],
                ['key' => 'services', 'label' => 'Layanan', 'url' => '/layanan', 'icon' => 'services', 'custom_icon' => '', 'is_active' => true],
                ['key' => 'portfolios', 'label' => 'Portofolio', 'url' => '/portfolio', 'icon' => 'portfolios', 'custom_icon' => '', 'is_active' => true],
                ['key' => 'contact', 'label' => 'Kontak', 'url' => '/kontak', 'icon' => 'contact', 'is_active' => true],
            ]);
        }

        if (! filled(SiteSetting::getValue('theme'))) {
            SiteSetting::setValue('theme', 'emerald');
        }
    }
}
