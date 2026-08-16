<?php

namespace App\Console\Commands;

use App\Models\Page;
use App\Models\Portfolio;
use App\Models\Service;
use App\Models\SiteSetting;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

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
    protected $description = 'Generate the XML sitemap for search engine indexing';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Generating XML sitemap for Sankara Tech...');

        $urls = [];

        // 1. Homepage
        $urls[] = [
            'loc' => route('home'),
            'priority' => '1.0',
            'changefreq' => 'daily',
            'lastmod' => now()->toIso8601String(),
        ];

        // 2. About page
        if (Page::query()->where('slug', 'tentang-kami')->exists()) {
            $urls[] = [
                'loc' => route('about'),
                'priority' => '0.8',
                'changefreq' => 'weekly',
                'lastmod' => now()->toIso8601String(),
            ];
        }

        // 3. Services Index
        $urls[] = [
            'loc' => route('services.index'),
            'priority' => '0.9',
            'changefreq' => 'weekly',
            'lastmod' => now()->toIso8601String(),
        ];

        // Services Details
        foreach (Service::query()->active()->get() as $service) {
            $urls[] = [
                'loc' => route('services.show', $service->slug),
                'priority' => '0.8',
                'changefreq' => 'weekly',
                'lastmod' => $service->updated_at?->toIso8601String() ?? now()->toIso8601String(),
            ];
        }

        // 4. Portfolios Index
        $urls[] = [
            'loc' => route('portfolios.index'),
            'priority' => '0.9',
            'changefreq' => 'weekly',
            'lastmod' => now()->toIso8601String(),
        ];

        // Portfolios Details
        foreach (Portfolio::query()->active()->get() as $portfolio) {
            $urls[] = [
                'loc' => route('portfolios.show', $portfolio->slug),
                'priority' => '0.8',
                'changefreq' => 'monthly',
                'lastmod' => $portfolio->updated_at?->toIso8601String() ?? now()->toIso8601String(),
            ];
        }

        // 5. Contact
        $urls[] = [
            'loc' => route('contact.show'),
            'priority' => '0.7',
            'changefreq' => 'monthly',
            'lastmod' => now()->toIso8601String(),
        ];

        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";
        foreach ($urls as $item) {
            $xml .= "  <url>\n";
            $xml .= '    <loc>'.htmlspecialchars($item['loc'], ENT_XML1, 'UTF-8')."</loc>\n";
            $xml .= '    <lastmod>'.$item['lastmod']."</lastmod>\n";
            $xml .= '    <changefreq>'.$item['changefreq']."</changefreq>\n";
            $xml .= '    <priority>'.$item['priority']."</priority>\n";
            $xml .= "  </url>\n";
        }
        $xml .= '</urlset>';

        $outputPath = $this->option('path') ?: public_path('sitemap.xml');

        File::ensureDirectoryExists(dirname($outputPath));
        File::put($outputPath, $xml);

        $now = now()->toIso8601String();
        SiteSetting::setValue('sitemap_last_generated_at', $now);

        $this->info("XML sitemap successfully generated at: {$outputPath} with ".count($urls).' URLs.');

        return 0;
    }
}
