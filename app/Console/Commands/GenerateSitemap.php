<?php

namespace App\Console\Commands;

use App\Models\Page;
use App\Models\Portfolio;
use App\Models\Service;
use App\Models\SiteSetting;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate {--path= : Custom output path for sitemap.xml}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the XML sitemap using Spatie Sitemap';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Generating XML sitemap for Sankara Tech...');

        $sitemap = Sitemap::create();

        // 1. Homepage
        $sitemap->add(
            Url::create(route('home'))
                ->setPriority(1.0)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
        );

        // 2. About page
        if (Page::query()->where('slug', 'tentang-kami')->exists()) {
            $sitemap->add(
                Url::create(route('about'))
                    ->setPriority(0.8)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
            );
        }

        // 3. Services Index
        $sitemap->add(
            Url::create(route('services.index'))
                ->setPriority(0.9)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
        );

        // 4. Individual Active Services
        $services = Service::query()->active()->get(['slug', 'updated_at']);
        foreach ($services as $service) {
            $url = Url::create(route('services.show', $service->slug))
                ->setPriority(0.8)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY);

            if ($service->updated_at) {
                $url->setLastModificationDate($service->updated_at);
            }

            $sitemap->add($url);
        }

        // 5. Portfolios Index
        $sitemap->add(
            Url::create(route('portfolios.index'))
                ->setPriority(0.9)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
        );

        // 6. Individual Active Portfolios
        $portfolios = Portfolio::query()->active()->get(['slug', 'updated_at']);
        foreach ($portfolios as $portfolio) {
            $url = Url::create(route('portfolios.show', $portfolio->slug))
                ->setPriority(0.8)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY);

            if ($portfolio->updated_at) {
                $url->setLastModificationDate($portfolio->updated_at);
            }

            $sitemap->add($url);
        }

        // 7. Contact page
        $sitemap->add(
            Url::create(route('contact.show'))
                ->setPriority(0.7)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
        );

        $outputPath = $this->option('path') ?: public_path('sitemap.xml');

        $sitemap->writeToFile($outputPath);

        SiteSetting::setValue('sitemap_last_generated_at', now()->toDateTimeString());

        $totalUrls = 1 + ($services->count()) + 1 + ($portfolios->count()) + 2;
        $this->info("Sitemap successfully written to: {$outputPath} ({$totalUrls} URLs)");

        return self::SUCCESS;
    }
}
