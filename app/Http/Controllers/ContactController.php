<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function show(Request $request)
    {
        $contact = SiteSetting::getValue('contact', []);
        if (is_array($contact) && isset($contact['map_embed_url']) && is_string($contact['map_embed_url']) && $contact['map_embed_url'] !== '') {
            $contact['map_embed_url'] = $this->normalizeMapEmbedForRender($contact['map_embed_url']) ?? $contact['map_embed_url'];
        }

        return view('contact.show', compact('contact'));
    }

    public function store(Request $request)
    {
        $payload = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:32'],
            'message' => ['required', 'string'],
        ]);

        $payload['phone'] = isset($payload['phone']) ? trim($payload['phone']) : null;

        $messageRow = ContactMessage::query()->create([
            'name' => $payload['name'],
            'email' => $payload['email'],
            'phone' => $payload['phone'] ?: null,
            'message' => $payload['message'],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        $contact = SiteSetting::getValue('contact', []);
        $inboxEmail = $contact['inbox_email'] ?? ($contact['email'] ?? null);

        if (filled($inboxEmail)) {
            try {
                Mail::send('emails.contact-message', ['row' => $messageRow, 'contact' => $contact], function ($m) use ($messageRow, $inboxEmail) {
                    $m->to($inboxEmail);
                    $m->replyTo($messageRow->email, $messageRow->name);
                    $m->subject('Pesan Kontak - ' . $messageRow->name);
                });
            } catch (\Throwable $e) {
            }
        }

        $waLink = $this->buildWhatsappLink($contact['whatsapp'] ?? null, $messageRow);

        return redirect()
            ->route('contact.show')
            ->with('status', 'Pesan berhasil dikirim. Terima kasih!')
            ->with('wa_link', $waLink);
    }

    private function buildWhatsappLink(?string $rawNumber, ContactMessage $row): ?string
    {
        $number = $this->normalizeWhatsappNumber($rawNumber);
        if (!$number) {
            return null;
        }

        $lines = [
            'Halo Kersa, saya ' . $row->name . '.',
            'Email: ' . $row->email,
        ];

        if (filled($row->phone)) {
            $lines[] = 'Telp: ' . $row->phone;
        }

        $lines[] = '';
        $lines[] = $row->message;

        return 'https://wa.me/' . $number . '?text=' . rawurlencode(implode("\n", $lines));
    }

    private function normalizeWhatsappNumber(?string $rawNumber): ?string
    {
        if (!filled($rawNumber)) {
            return null;
        }

        $digits = preg_replace('/\D+/', '', $rawNumber) ?: '';
        if ($digits === '') {
            return null;
        }

        if (str_starts_with($digits, '0')) {
            $digits = '62' . substr($digits, 1);
        }

        return $digits;
    }

    private function normalizeMapEmbedForRender(string $url): ?string
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
                $q = $m[1] . ',' . $m[2];
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

                if (!$q && preg_match('~/maps/place/([^/]+)~i', $path, $pm)) {
                    $q = urldecode(str_replace('+', ' ', $pm[1]));
                }
            }

            if (!$q) {
                return null;
            }

            $embed = 'https://maps.google.com/maps?output=embed&q=' . rawurlencode($q);
            if ($z) {
                $embed .= '&z=' . rawurlencode($z);
            }

            return $embed;
        }

        return null;
    }
}
