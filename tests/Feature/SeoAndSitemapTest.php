<?php

namespace Tests\Feature;

use App\Models\Portfolio;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class SeoAndSitemapTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_sitemap_command_generates_xml_file(): void
    {
        $exitCode = Artisan::call('sitemap:generate');
        $this->assertSame(0, $exitCode);

        $path = public_path('sitemap.xml');
        $this->assertFileExists($path);

        $content = File::get($path);
        $this->assertStringContainsString('<?xml version="1.0" encoding="UTF-8"?>', $content);
        $this->assertStringContainsString('<urlset', $content);
        $this->assertStringContainsString('/layanan', $content);
        $this->assertStringContainsString('/portfolio', $content);
        $this->assertStringContainsString('/kontak', $content);
        $this->assertStringContainsString('/tentang-kami', $content);
    }

    public function test_sitemap_xml_route_returns_valid_xml(): void
    {
        $response = $this->get('/sitemap.xml');
        $response->assertOk();
        $response->assertHeader('Content-Type', 'application/xml; charset=utf-8');
        $this->assertStringContainsString('<urlset', $response->getContent());
    }

    public function test_robots_txt_route_returns_sitemap_reference(): void
    {
        $response = $this->get('/robots.txt');
        $response->assertOk();
        $response->assertHeader('Content-Type', 'text/plain; charset=utf-8');
        $this->assertStringContainsString('Sitemap:', $response->getContent());
        $this->assertStringContainsString('Disallow: /admin/', $response->getContent());
    }

    public function test_homepage_renders_dynamic_seo_and_json_ld(): void
    {
        SiteSetting::setValue('ga_measurement_id', 'G-1234567890');
        SiteSetting::setValue('meta_title', 'Sankara Tech - Top Agency');
        SiteSetting::setValue('meta_description', 'Agency digital terbaik untuk solusi bisnis modern.');

        $response = $this->get('/');
        $response->assertOk();

        $content = $response->getContent();

        // SEO Meta
        $this->assertStringContainsString('<meta name="description" content="Agency digital terbaik untuk solusi bisnis modern.">', $content);
        $this->assertStringContainsString('<meta property="og:title" content="Sankara Tech - Top Agency">', $content);
        $this->assertStringContainsString('<meta property="og:site_name" content="Sankara Tech">', $content);
        $this->assertStringContainsString('<meta name="twitter:card" content="summary_large_image">', $content);

        // Google Analytics 4 Tag
        $this->assertStringContainsString('https://www.googletagmanager.com/gtag/js?id=G-1234567890', $content);
        $this->assertStringContainsString('gtag("config","G-1234567890"', $content);

        // JSON-LD Schema
        $this->assertStringContainsString('"@type": "Organization"', $content);
        $this->assertStringContainsString('"@type": "WebSite"', $content);
    }

    public function test_service_show_page_renders_service_schema(): void
    {
        $service = Service::query()->where('slug', 'website-development')->firstOrFail();

        $response = $this->get(route('services.show', $service->slug));
        $response->assertOk();

        $content = $response->getContent();
        $this->assertStringContainsString('"@type": "Service"', $content);
        $this->assertStringContainsString('"@type": "BreadcrumbList"', $content);
        $this->assertStringContainsString($service->title, $content);
    }

    public function test_portfolio_show_page_renders_creative_work_schema(): void
    {
        $portfolio = Portfolio::query()->firstOrFail();

        $response = $this->get(route('portfolios.show', $portfolio->slug));
        $response->assertOk();

        $content = $response->getContent();
        $this->assertStringContainsString('"@type": "CreativeWork"', $content);
        $this->assertStringContainsString('"@type": "BreadcrumbList"', $content);
        $this->assertStringContainsString($portfolio->title, $content);
    }

    public function test_admin_can_trigger_manual_sitemap_generation(): void
    {
        $admin = User::query()->where('email', 'admin@sankaratech.test')->firstOrFail();

        $response = $this->actingAs($admin)->post(route('admin.sitemap.generate'));
        $response->assertRedirect();
        $response->assertSessionHas('status');

        $this->assertNotNull(SiteSetting::getValue('sitemap_last_generated_at'));
    }
}
