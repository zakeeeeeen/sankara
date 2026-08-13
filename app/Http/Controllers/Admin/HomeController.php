<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advantage;
use App\Models\HomeAbout;
use App\Models\HomeCta;
use App\Models\HomeHero;
use App\Models\HomeStat;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class HomeController extends Controller
{
    public function edit(Request $request)
    {
        $hero = HomeHero::query()->first();
        $about = HomeAbout::query()->first();
        $cta = HomeCta::query()->first();
        $stats = HomeStat::query()->orderBy('sort_order')->get();
        $advantages = Advantage::query()->orderBy('sort_order')->get();
        $theme = SiteSetting::getValue('theme', 'emerald');

        $contact = SiteSetting::getValue('contact', [
            'email' => '',
            'whatsapp' => '',
            'address' => '',
            'hours' => '',
            'inbox_email' => '',
            'map_embed_url' => '',
        ]);

        $socials = SiteSetting::getValue('socials', [
            'instagram' => '',
            'linkedin' => '',
            'dribbble' => '',
        ]);

        return view('admin.home.edit', compact('hero', 'about', 'cta', 'stats', 'advantages', 'contact', 'socials', 'theme'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'theme' => ['nullable', 'string', Rule::in(['emerald', 'violet', 'blue', 'amber', 'rose'])],
            'hero.heading' => ['required', 'string', 'max:255'],
            'hero.subheading' => ['nullable', 'string'],
            'hero.primary_cta_label' => ['nullable', 'string', 'max:255'],
            'hero.primary_cta_url' => ['nullable', 'string', 'max:255'],
            'hero.secondary_cta_label' => ['nullable', 'string', 'max:255'],
            'hero.secondary_cta_url' => ['nullable', 'string', 'max:255'],
            'hero.image_url' => ['nullable', 'string', 'max:255'],
            'hero.image' => ['nullable', 'image', 'max:4096'],

            'stats' => ['nullable', 'array'],
            'stats.*.value' => ['required_with:stats', 'string', 'max:50'],
            'stats.*.label' => ['required_with:stats', 'string', 'max:50'],

            'about.eyebrow' => ['nullable', 'string', 'max:255'],
            'about.heading' => ['required', 'string', 'max:255'],
            'about.body' => ['nullable', 'string'],
            'about.image_url' => ['nullable', 'string', 'max:255'],
            'about.image' => ['nullable', 'image', 'max:4096'],

            'advantages' => ['nullable', 'array'],
            'advantages.*.title' => ['required_with:advantages', 'string', 'max:255'],
            'advantages.*.description' => ['nullable', 'string'],

            'cta.heading' => ['required', 'string', 'max:255'],
            'cta.body' => ['nullable', 'string'],
            'cta.primary_label' => ['nullable', 'string', 'max:255'],
            'cta.primary_url' => ['nullable', 'string', 'max:255'],
            'cta.secondary_label' => ['nullable', 'string', 'max:255'],
            'cta.secondary_url' => ['nullable', 'string', 'max:255'],

            'contact.email' => ['nullable', 'string', 'max:255'],
            'contact.whatsapp' => ['nullable', 'string', 'max:255'],
            'contact.address' => ['nullable', 'string', 'max:255'],
            'contact.hours' => ['nullable', 'string', 'max:255'],
            'contact.inbox_email' => ['nullable', 'email', 'max:255'],
            'contact.map_embed_url' => ['nullable', 'url', 'max:2048'],

            'socials.instagram' => ['nullable', 'string', 'max:255'],
            'socials.linkedin' => ['nullable', 'string', 'max:255'],
            'socials.dribbble' => ['nullable', 'string', 'max:255'],
        ]);

        $rawMapUrl = $data['contact']['map_embed_url'] ?? null;
        if (filled($rawMapUrl)) {
            $normalized = $this->normalizeGoogleMapEmbedUrl($rawMapUrl);
            if (!$normalized) {
                return back()
                    ->withErrors(['contact.map_embed_url' => 'Gunakan link Google Maps (share) atau link embed.'])
                    ->withInput();
            }
            $data['contact']['map_embed_url'] = $normalized;
        }

        DB::transaction(function () use ($request, $data): void {
            $hero = HomeHero::query()->first() ?: new HomeHero();
            $hero->fill($data['hero']);

            if ($request->hasFile('hero.image')) {
                $hero->image_path = $request->file('hero.image')->store('home', 'public');
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

            $about = HomeAbout::query()->first() ?: new HomeAbout();
            $about->fill($data['about']);
            if ($request->hasFile('about.image')) {
                $about->image_path = $request->file('about.image')->store('home', 'public');
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

            $cta = HomeCta::query()->first() ?: new HomeCta();
            $cta->fill($data['cta']);
            $cta->save();

            SiteSetting::setValue('contact', $data['contact'] ?? []);
            SiteSetting::setValue('socials', $data['socials'] ?? []);
            SiteSetting::setValue('theme', $data['theme'] ?? 'emerald');
        });

        return redirect()->route('admin.home.edit')->with('status', 'Perubahan tersimpan.');
    }

    private function normalizeGoogleMapEmbedUrl(string $url): ?string
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

        if (in_array($host, ['maps.app.goo.gl', 'goo.gl'], true)) {
            $headers = @get_headers($url, true);
            if (!$headers) {
                return null;
            }

            $location = $headers['Location'] ?? $headers['location'] ?? null;
            if (is_array($location)) {
                $location = end($location) ?: null;
            }

            if (!is_string($location) || $location === '') {
                return null;
            }

            return $this->normalizeGoogleMapEmbedUrl($location);
        }

        return null;
    }
}

