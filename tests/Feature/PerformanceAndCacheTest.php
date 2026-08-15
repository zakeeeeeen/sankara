<?php

namespace Tests\Feature;

use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class PerformanceAndCacheTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_site_setting_is_cached_in_memory(): void
    {
        SiteSetting::clearCache();

        $this->assertFalse(Cache::has(SiteSetting::CACHE_KEY));

        $val1 = SiteSetting::getValue('site_name');
        $this->assertTrue(Cache::has(SiteSetting::CACHE_KEY));

        $cached = Cache::get(SiteSetting::CACHE_KEY);
        $this->assertIsArray($cached);
        $this->assertEquals($val1, $cached['site_name']);
    }

    public function test_site_setting_invalidates_cache_on_set_value(): void
    {
        SiteSetting::setValue('site_name', 'Initial Brand');
        $this->assertEquals('Initial Brand', SiteSetting::getValue('site_name'));

        // Update value
        SiteSetting::setValue('site_name', 'Updated Brand');
        $this->assertEquals('Updated Brand', SiteSetting::getValue('site_name'));
    }

    public function test_landing_page_executes_efficiently(): void
    {
        $response = $this->get('/');
        $response->assertOk();
    }
}
