<?php

namespace Tests\Feature;

use App\Livewire\Admin\Auth\Login as AdminLogin;
use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Admin\HomeSettings\Index as AdminHomeSettings;
use App\Livewire\Admin\Pages\About as AdminPagesAbout;
use App\Livewire\Admin\Portfolios\Create as AdminPortfoliosCreate;
use App\Livewire\Admin\Pricing\Create as AdminPricingCreate;
use App\Livewire\Admin\Services\Create as AdminServicesCreate;
use App\Livewire\Admin\Services\Index as AdminServicesIndex;
use App\Livewire\Admin\SiteSettings\Index as AdminSiteSettings;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class LivewireAdminTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_admin_can_login_via_livewire(): void
    {
        Livewire::test(AdminLogin::class)
            ->set('email', 'admin@sankaratech.test')
            ->set('password', 'password')
            ->call('login')
            ->assertHasNoErrors()
            ->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticated();
    }

    public function test_admin_dashboard_renders_metrics(): void
    {
        $admin = User::query()->where('email', 'admin@sankaratech.test')->firstOrFail();

        Livewire::actingAs($admin)
            ->test(AdminDashboard::class)
            ->assertStatus(200)
            ->assertSee('Admin Workspace');
    }

    public function test_admin_home_settings_saves_content(): void
    {
        $admin = User::query()->where('email', 'admin@sankaratech.test')->firstOrFail();

        Livewire::actingAs($admin)
            ->test(AdminHomeSettings::class)
            ->set('hero.heading', 'Hero Title Updated')
            ->call('save')
            ->assertHasNoErrors()
            ->assertSee('Pengaturan Beranda (Home) berhasil disimpan.');

        $this->assertDatabaseHas('home_heroes', [
            'heading' => 'Hero Title Updated',
        ]);
    }

    public function test_admin_pages_about_saves_content(): void
    {
        $admin = User::query()->where('email', 'admin@sankaratech.test')->firstOrFail();

        Livewire::actingAs($admin)
            ->test(AdminPagesAbout::class)
            ->set('title', 'Tentang Kami Updated')
            ->set('body', 'Konten Baru Tentang Kami')
            ->call('save')
            ->assertHasNoErrors()
            ->assertSee('Halaman Tentang Kami berhasil diperbarui.');

        $this->assertDatabaseHas('pages', [
            'slug' => 'tentang-kami',
            'title' => 'Tentang Kami Updated',
        ]);
    }

    public function test_admin_can_create_service_via_livewire(): void
    {
        $admin = User::query()->where('email', 'admin@sankaratech.test')->firstOrFail();

        Livewire::actingAs($admin)
            ->test(AdminServicesCreate::class)
            ->set('service.title', 'Cloud Architecture Service')
            ->set('service.slug', 'cloud-architecture')
            ->set('service.excerpt', 'Scalable cloud consulting')
            ->set('features', [
                ['text' => 'AWS & GCP Setup'],
                ['text' => 'Zero Downtime CI/CD'],
            ])
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect(route('admin.services.index'));

        $this->assertDatabaseHas('services', [
            'slug' => 'cloud-architecture',
            'title' => 'Cloud Architecture Service',
        ]);
    }

    public function test_admin_can_toggle_and_delete_service(): void
    {
        $admin = User::query()->where('email', 'admin@sankaratech.test')->firstOrFail();
        $service = Service::query()->firstOrFail();

        $initialStatus = $service->is_active;

        Livewire::actingAs($admin)
            ->test(AdminServicesIndex::class)
            ->call('toggleActive', $service->id)
            ->assertHasNoErrors();

        $this->assertEquals(! $initialStatus, $service->fresh()->is_active);

        Livewire::actingAs($admin)
            ->test(AdminServicesIndex::class)
            ->call('delete', $service->id)
            ->assertHasNoErrors();

        $this->assertDatabaseMissing('services', [
            'id' => $service->id,
        ]);
    }

    public function test_admin_can_create_portfolio_via_livewire(): void
    {
        $admin = User::query()->where('email', 'admin@sankaratech.test')->firstOrFail();

        Livewire::actingAs($admin)
            ->test(AdminPortfoliosCreate::class)
            ->set('portfolio.title', 'FinTech SuperApp')
            ->set('portfolio.slug', 'fintech-superapp')
            ->set('portfolio.client_name', 'FinCorp')
            ->set('technologiesText', 'Flutter, Laravel, Redis')
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect(route('admin.portfolios.index'));

        $this->assertDatabaseHas('portfolios', [
            'slug' => 'fintech-superapp',
            'title' => 'FinTech SuperApp',
        ]);
    }

    public function test_admin_can_create_pricing_plan_via_livewire(): void
    {
        $admin = User::query()->where('email', 'admin@sankaratech.test')->firstOrFail();

        Livewire::actingAs($admin)
            ->test(AdminPricingCreate::class)
            ->set('plan.name', 'Ultimate Enterprise')
            ->set('plan.price_text', 'Rp 25.000.000')
            ->set('features', [
                ['text' => 'Unlimited Revisions'],
            ])
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect(route('admin.pricing.index'));

        $this->assertDatabaseHas('pricing_plans', [
            'name' => 'Ultimate Enterprise',
        ]);
    }

    public function test_admin_site_settings_saves_and_generates_sitemap(): void
    {
        $admin = User::query()->where('email', 'admin@sankaratech.test')->firstOrFail();

        Livewire::actingAs($admin)
            ->test(AdminSiteSettings::class)
            ->set('site_name', 'Sankara Tech Ultimate')
            ->set('seo_title', 'Sankara Tech - Best Digital Agency')
            ->call('save')
            ->assertHasNoErrors()
            ->assertSee('Pengaturan situs dan SEO berhasil disimpan.');

        $this->assertEquals('Sankara Tech Ultimate', SiteSetting::getValue('site_name'));

        Livewire::actingAs($admin)
            ->test(AdminSiteSettings::class)
            ->call('generateSitemap')
            ->assertHasNoErrors()
            ->assertSee('Sitemap XML berhasil diperbarui');

        $this->assertFileExists(public_path('sitemap.xml'));
    }
}
