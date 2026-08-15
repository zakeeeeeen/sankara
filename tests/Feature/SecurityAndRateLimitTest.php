<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class SecurityAndRateLimitTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
        RateLimiter::clear('contact-submit:127.0.0.1');
    }

    public function test_security_headers_are_present_on_all_responses(): void
    {
        $response = $this->get('/');
        $response->assertOk();

        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('X-XSS-Protection', '1; mode=block');
        $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->assertHeader('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');
        $this->assertNotEmpty($response->headers->get('Content-Security-Policy'));
    }

    public function test_contact_form_honeypot_silently_drops_spambots(): void
    {
        $response = $this->post(route('contact.store'), [
            'name' => 'Bot User',
            'email' => 'bot@spammer.com',
            'message' => 'Spam message',
            '_hp_website_title' => 'I am a spambot',
        ]);

        $response->assertRedirect(route('contact.show'));

        $this->assertDatabaseMissing('contact_messages', [
            'email' => 'bot@spammer.com',
        ]);
    }

    public function test_contact_form_validates_and_stores_clean_message(): void
    {
        $response = $this->post(route('contact.store'), [
            'name' => '<b>John Doe</b>',
            'email' => 'john@example.com',
            'phone' => '08123456789',
            'message' => '<script>alert(1)</script>Halo Sankara Tech',
        ]);

        $response->assertRedirect(route('contact.show'));
        $response->assertSessionHas('status');

        $this->assertDatabaseHas('contact_messages', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'message' => 'Halo Sankara Tech',
        ]);
    }

    public function test_contact_form_rate_limiting(): void
    {
        $payload = [
            'name' => 'Rate Limit Tester',
            'email' => 'tester@example.com',
            'message' => 'Valid message',
        ];

        // 5 allowed requests
        for ($i = 0; $i < 5; $i++) {
            $response = $this->post(route('contact.store'), $payload);
            $response->assertRedirect(route('contact.show'));
        }

        // 6th request should hit rate limit
        $response = $this->post(route('contact.store'), $payload);
        $response->assertSessionHasErrors('rate_limit');
    }
}
