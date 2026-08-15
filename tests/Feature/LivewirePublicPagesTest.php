<?php

namespace Tests\Feature;

use App\Livewire\ContactForm;
use App\Livewire\Pages\About as PublicAbout;
use App\Livewire\Pages\Contact as PublicContact;
use App\Livewire\Pages\Home as PublicHome;
use App\Livewire\Pages\Portfolios\Index as PublicPortfoliosIndex;
use App\Livewire\Pages\Portfolios\Show as PublicPortfoliosShow;
use App\Livewire\Pages\Services\Index as PublicServicesIndex;
use App\Livewire\Pages\Services\Show as PublicServicesShow;
use App\Models\Portfolio;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Livewire;
use Tests\TestCase;

class LivewirePublicPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
        RateLimiter::clear('contact-submit:127.0.0.1');
    }

    public function test_public_pages_render_successfully(): void
    {
        Livewire::test(PublicHome::class)->assertStatus(200);
        Livewire::test(PublicAbout::class)->assertStatus(200);
        Livewire::test(PublicServicesIndex::class)->assertStatus(200);
        Livewire::test(PublicPortfoliosIndex::class)->assertStatus(200);
        Livewire::test(PublicContact::class)->assertStatus(200);

        $service = Service::query()->firstOrFail();
        Livewire::test(PublicServicesShow::class, ['slug' => $service->slug])->assertStatus(200);

        $portfolio = Portfolio::query()->firstOrFail();
        Livewire::test(PublicPortfoliosShow::class, ['slug' => $portfolio->slug])->assertStatus(200);
    }

    public function test_contact_form_livewire_submission(): void
    {
        Livewire::test(ContactForm::class)
            ->set('name', 'Livewire Tester')
            ->set('email', 'livewire@test.com')
            ->set('phone', '08123456789')
            ->set('message', 'Testing contact form with Livewire component.')
            ->call('submit')
            ->assertHasNoErrors()
            ->assertSet('status', 'Pesan berhasil dikirim. Terima kasih!');

        $this->assertDatabaseHas('contact_messages', [
            'name' => 'Livewire Tester',
            'email' => 'livewire@test.com',
        ]);
    }
}
