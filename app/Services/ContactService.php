<?php

namespace App\Services;

use App\Models\ContactMessage;
use App\Models\SiteSetting;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;

class ContactService
{
    /**
     * @return array<string, mixed>
     */
    public function getContactData(): array
    {
        $contact = SiteSetting::getValue('contact', []);
        if (is_array($contact) && isset($contact['map_embed_url']) && is_string($contact['map_embed_url']) && $contact['map_embed_url'] !== '') {
            $contact['map_embed_url'] = $this->normalizeMapEmbedForRender($contact['map_embed_url']) ?? $contact['map_embed_url'];
        }

        return is_array($contact) ? $contact : [];
    }

    /**
     * @param  array{name: string, email: string, phone?: ?string, message: string}  $data
     * @return array{message: ContactMessage, wa_link: ?string}
     */
    public function submitContactMessage(array $data, ?string $ip = null, ?string $userAgent = null): array
    {
        $name = strip_tags(trim($data['name']));
        $email = filter_var(trim($data['email']), FILTER_SANITIZE_EMAIL);
        $phone = isset($data['phone']) ? strip_tags(trim($data['phone'])) : null;
        $cleanMessage = preg_replace('/<(script|style)\b[^>]*>(.*?)<\/\1>/is', '', $data['message']) ?? $data['message'];
        $message = trim(strip_tags((string) $cleanMessage));

        /** @var ContactMessage $messageRow */
        $messageRow = ContactMessage::query()->create([
            'name' => $name,
            'email' => $email,
            'phone' => $phone ?: null,
            'message' => $message,
            'ip_address' => $ip,
            'user_agent' => $userAgent,
        ]);

        $contact = SiteSetting::getValue('contact', []);
        $inboxEmail = $contact['inbox_email'] ?? ($contact['email'] ?? null);

        if (filled($inboxEmail)) {
            try {
                Mail::send('emails.contact-message', ['row' => $messageRow, 'contact' => $contact], function ($m) use ($messageRow, $inboxEmail): void {
                    $m->to($inboxEmail);
                    $m->replyTo($messageRow->email, $messageRow->name);
                    $m->subject('Pesan Kontak - '.$messageRow->name);
                });
            } catch (\Throwable) {
                // Silently ignore mail sending error
            }
        }

        $waLink = $this->buildWhatsappLink($contact['whatsapp'] ?? null, $messageRow);

        return [
            'message' => $messageRow,
            'wa_link' => $waLink,
        ];
    }

    public function checkRateLimit(string $ip, int $maxAttempts = 5, int $decaySeconds = 60): ?int
    {
        $rateKey = 'contact-submit:'.$ip;
        if (RateLimiter::tooManyAttempts($rateKey, $maxAttempts)) {
            return RateLimiter::availableIn($rateKey);
        }

        RateLimiter::hit($rateKey, $decaySeconds);

        return null;
    }

    public function getPaginatedMessages(int $perPage = 20): LengthAwarePaginator
    {
        return ContactMessage::query()->latest()->paginate($perPage);
    }

    public function deleteMessage(ContactMessage $message): bool
    {
        return (bool) $message->delete();
    }

    public function buildWhatsappLink(?string $rawNumber, ContactMessage $row): ?string
    {
        $number = $this->normalizeWhatsappNumber($rawNumber);
        if (! $number) {
            return null;
        }

        $lines = [
            'Halo Sankara Tech, saya '.$row->name.'.',
            'Email: '.$row->email,
        ];

        if (filled($row->phone)) {
            $lines[] = 'Telp: '.$row->phone;
        }

        $lines[] = '';
        $lines[] = $row->message;

        return 'https://wa.me/'.$number.'?text='.rawurlencode(implode("\n", $lines));
    }

    public function normalizeWhatsappNumber(?string $rawNumber): ?string
    {
        if (! filled($rawNumber)) {
            return null;
        }

        $digits = preg_replace('/\D+/', '', $rawNumber) ?: '';
        if ($digits === '') {
            return null;
        }

        if (str_starts_with($digits, '0')) {
            $digits = '62'.substr($digits, 1);
        }

        return $digits;
    }

    public function normalizeMapEmbedForRender(string $url): ?string
    {
        $host = parse_url($url, PHP_URL_HOST);
        $path = parse_url($url, PHP_URL_PATH) ?: '';

        if ($host === 'www.google.com' && str_starts_with($path, '/maps/embed')) {
            return $url;
        }

        if (in_array($host, ['www.google.com', 'google.com'], true) && str_starts_with($path, '/maps')) {
            $q = null;
            $z = null;

            if (preg_match('/@(-?\d+(?:\.\d+)?),(-?\d+(?:\.\d+)?),(\d+(?:\.\d+)?)z/i', $url, $m)) {
                $q = $m[1].','.$m[2];
                $z = (string) (int) round((float) $m[3]);
            } else {
                $query = parse_url($url, PHP_URL_QUERY) ?: '';
                $params = [];
                parse_str($query, $params);

                foreach (['q', 'query', 'destination', 'center'] as $k) {
                    if (isset($params[$k]) && is_string($params[$k]) && $params[$k] !== '') {
                        $q = $params[$k];
                        break;
                    }
                }

                if (! $q && preg_match('~/maps/place/([^/]+)~i', $path, $pm)) {
                    $q = urldecode(str_replace('+', ' ', $pm[1]));
                }
            }

            if (! $q) {
                return null;
            }

            $embed = 'https://maps.google.com/maps?output=embed&q='.rawurlencode($q);
            if ($z) {
                $embed .= '&z='.rawurlencode($z);
            }

            return $embed;
        }

        return null;
    }
}
