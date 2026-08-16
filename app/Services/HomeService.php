<?php

namespace App\Services;

use App\Models\Advantage;
use App\Models\HomeAbout;
use App\Models\HomeCta;
use App\Models\HomeHero;
use App\Models\HomeStat;
use App\Models\Portfolio;
use App\Models\PricingPlan;
use App\Models\Service;
use App\Models\SiteSetting;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class HomeService
{
    public function __construct(protected ContactService $contactService) {}

    /**
     * @return array<string, mixed>
     */
    public function getLandingPageData(): array
    {
        return [
            'hero' => HomeHero::query()->first(),
            'stats' => HomeStat::query()->orderBy('sort_order')->get(),
            'about' => HomeAbout::query()->first(),
            'advantages' => Advantage::query()->orderBy('sort_order')->get(),
            'services' => Service::query()->active()->orderBy('sort_order')->limit(6)->get(),
            'portfolios' => Portfolio::query()
                ->active()
                ->with(['categories:id,name,slug'])
                ->orderByDesc('published_at')
                ->orderBy('sort_order')
                ->get(),
            'pricingPlans' => PricingPlan::query()->with('features')->orderBy('sort_order')->get(),
            'cta' => HomeCta::query()->first(),
            'contact' => SiteSetting::getValue('contact', [
                'email' => 'hello@sankaratech.com',
                'whatsapp' => '+62 812-0000-0000',
                'address' => 'Jakarta, Indonesia',
                'hours' => 'Senin–Jumat, 09.00–18.00 WIB',
            ]),
            'socials' => SiteSetting::getValue('socials', [
                'instagram' => '#',
                'linkedin' => '#',
                'dribbble' => '#',
            ]),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function getAdminHomeEditData(): array
    {
        return [
            'hero' => HomeHero::query()->first(),
            'about' => HomeAbout::query()->first(),
            'cta' => HomeCta::query()->first(),
            'stats' => HomeStat::query()->orderBy('sort_order')->get(),
            'advantages' => Advantage::query()->orderBy('sort_order')->get(),
            'contact' => SiteSetting::getValue('contact', [
                'email' => '',
                'whatsapp' => '',
                'address' => '',
                'hours' => '',
                'inbox_email' => '',
                'map_embed_url' => '',
            ]),
            'socials' => SiteSetting::getValue('socials', [
                'instagram' => '',
                'linkedin' => '',
                'dribbble' => '',
                'tiktok' => '',
                'twitter' => '',
                'discord' => '',
                'whatsapp' => '',
                'github' => '',
                'youtube' => '',
            ]),
        ];
    }

    /**
     * @param  array<string, mixed>  $data
     * @param  array<string, UploadedFile|null>  $files
     */
    public function updateHomeContent(array $data, array $files = []): void
    {
        $rawMapUrl = $data['contact']['map_embed_url'] ?? null;
        if (filled($rawMapUrl)) {
            $normalized = $this->contactService->normalizeMapEmbedForRender($rawMapUrl);
            if ($normalized) {
                $data['contact']['map_embed_url'] = $normalized;
            }
        }

        DB::transaction(function () use ($data, $files): void {
            /** @var HomeHero $hero */
            $hero = HomeHero::query()->first() ?: new HomeHero;
            $hero->fill($data['hero']);

            if (isset($files['hero_image']) && $files['hero_image'] instanceof UploadedFile) {
                $hero->image_path = $files['hero_image']->store('home', 'public');
            }
            $hero->save();

            HomeStat::query()->delete();
            foreach (($data['stats'] ?? []) as $i => $row) {
                HomeStat::query()->create([
                    'value' => $row['value'],
                    'label' => $row['label'],
                    'sort_order' => $i + 1,
                ]);
            }

            /** @var HomeAbout $about */
            $about = HomeAbout::query()->first() ?: new HomeAbout;
            $about->fill($data['about']);
            if (isset($files['about_image']) && $files['about_image'] instanceof UploadedFile) {
                $about->image_path = $files['about_image']->store('home', 'public');
            }
            $about->save();

            Advantage::query()->delete();
            foreach (($data['advantages'] ?? []) as $i => $row) {
                Advantage::query()->create([
                    'title' => $row['title'],
                    'description' => $row['description'] ?? null,
                    'icon' => 'check',
                    'sort_order' => $i + 1,
                ]);
            }

            /** @var HomeCta $cta */
            $cta = HomeCta::query()->first() ?: new HomeCta;
            $cta->fill($data['cta']);
            $cta->save();

            SiteSetting::setValue('contact', $data['contact'] ?? []);
            SiteSetting::setValue('socials', $data['socials'] ?? []);
        });
    }
}
