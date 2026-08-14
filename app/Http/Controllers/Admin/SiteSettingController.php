<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SiteSettingController extends Controller
{
    public function edit()
    {
        $siteName = SiteSetting::getValue('site_name', 'Sankara Tech');
        $siteTagline = SiteSetting::getValue('site_tagline', 'Digital Agency');
        $siteLogo = SiteSetting::getValue('site_logo', '/logosankara.png');
        $siteFavicon = SiteSetting::getValue('site_favicon', '/logosankara.png');

        $footerDescription = SiteSetting::getValue('footer_description', 'Kami membangun produk digital modern: website, software, aplikasi mobile, UI/UX, game development, dan 3D modeling—dengan kualitas premium yang meyakinkan.');
        $footerCopyright = SiteSetting::getValue('footer_copyright', '© ' . date('Y') . ' Sankara Tech. All rights reserved.');
        $footerSubtext = SiteSetting::getValue('footer_subtext', 'Built with Laravel • Blade • Livewire • Tailwind');

        $headerNav = SiteSetting::getValue('header_nav', [
            ['key' => 'home', 'label' => 'Home', 'url' => '/'],
            ['key' => 'about', 'label' => 'Tentang Kami', 'url' => '/tentang-kami'],
            ['key' => 'services', 'label' => 'Layanan', 'url' => '/layanan'],
            ['key' => 'portfolios', 'label' => 'Portofolio', 'url' => '/portfolio'],
            ['key' => 'contact', 'label' => 'Kontak', 'url' => '/kontak'],
        ]);

        $bottomNav = SiteSetting::getValue('bottom_nav', [
            ['key' => 'home', 'label' => 'Home', 'url' => '/', 'icon' => 'home', 'custom_icon' => '', 'is_active' => true],
            ['key' => 'services', 'label' => 'Layanan', 'url' => '/layanan', 'icon' => 'services', 'custom_icon' => '', 'is_active' => true],
            ['key' => 'portfolios', 'label' => 'Portofolio', 'url' => '/portfolio', 'icon' => 'portfolios', 'custom_icon' => '', 'is_active' => true],
            ['key' => 'contact', 'label' => 'Kontak', 'url' => '/kontak', 'icon' => 'contact', 'custom_icon' => '', 'is_active' => true],
        ]);

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
            'twitter' => '',
            'github' => '',
            'youtube' => '',
        ]);

        return view('admin.settings.edit', compact(
            'siteName',
            'siteTagline',
            'siteLogo',
            'siteFavicon',
            'footerDescription',
            'footerCopyright',
            'footerSubtext',
            'headerNav',
            'bottomNav',
            'contact',
            'socials'
        ));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'site_name' => ['required', 'string', 'max:255'],
            'site_tagline' => ['nullable', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'max:4096'],
            'favicon' => ['nullable', 'image', 'max:2048'],

            'footer_description' => ['nullable', 'string'],
            'footer_copyright' => ['nullable', 'string', 'max:255'],
            'footer_subtext' => ['nullable', 'string', 'max:255'],

            'header_nav' => ['nullable', 'array'],
            'header_nav.*.label' => ['required_with:header_nav', 'string', 'max:255'],
            'header_nav.*.url' => ['required_with:header_nav', 'string', 'max:255'],

            'bottom_nav' => ['nullable', 'array'],
            'bottom_nav.*.label' => ['required_with:bottom_nav', 'string', 'max:255'],
            'bottom_nav.*.url' => ['required_with:bottom_nav', 'string', 'max:255'],
            'bottom_nav.*.icon' => ['nullable', 'string', 'max:255'],
            'bottom_nav.*.custom_icon' => ['nullable', 'string'],

            'contact.email' => ['nullable', 'string', 'max:255'],
            'contact.whatsapp' => ['nullable', 'string', 'max:255'],
            'contact.address' => ['nullable', 'string', 'max:255'],
            'contact.hours' => ['nullable', 'string', 'max:255'],
            'contact.inbox_email' => ['nullable', 'email', 'max:255'],
            'contact.map_embed_url' => ['nullable', 'string', 'max:2048'],

            'socials.instagram' => ['nullable', 'string', 'max:255'],
            'socials.linkedin' => ['nullable', 'string', 'max:255'],
            'socials.dribbble' => ['nullable', 'string', 'max:255'],
            'socials.twitter' => ['nullable', 'string', 'max:255'],
            'socials.github' => ['nullable', 'string', 'max:255'],
            'socials.youtube' => ['nullable', 'string', 'max:255'],
        ]);

        SiteSetting::setValue('site_name', $data['site_name']);
        SiteSetting::setValue('site_tagline', $data['site_tagline'] ?? '');
        SiteSetting::setValue('footer_description', $data['footer_description'] ?? '');
        SiteSetting::setValue('footer_copyright', $data['footer_copyright'] ?? '');
        SiteSetting::setValue('footer_subtext', $data['footer_subtext'] ?? '');

        if ($request->hasFile('logo')) {
            $logoPath = '/storage/' . $request->file('logo')->store('settings', 'public');
            SiteSetting::setValue('site_logo', $logoPath);
        }

        if ($request->hasFile('favicon')) {
            $faviconPath = '/storage/' . $request->file('favicon')->store('settings', 'public');
            SiteSetting::setValue('site_favicon', $faviconPath);
        }

        // Header nav formatting
        $headerNavItems = [];
        foreach (($data['header_nav'] ?? []) as $item) {
            if (!empty(trim($item['label'] ?? ''))) {
                $headerNavItems[] = [
                    'key' => \Illuminate\Support\Str::slug($item['label']),
                    'label' => trim($item['label']),
                    'url' => trim($item['url'] ?? '#'),
                ];
            }
        }
        SiteSetting::setValue('header_nav', $headerNavItems);

        // Bottom nav formatting
        $bottomNavItems = [];
        foreach (($data['bottom_nav'] ?? []) as $item) {
            if (!empty(trim($item['label'] ?? ''))) {
                $bottomNavItems[] = [
                    'key' => \Illuminate\Support\Str::slug($item['label']),
                    'label' => trim($item['label']),
                    'url' => trim($item['url'] ?? '#'),
                    'icon' => $item['icon'] ?? 'home',
                    'custom_icon' => trim($item['custom_icon'] ?? ''),
                    'is_active' => !empty($item['is_active']),
                ];
            }
        }
        SiteSetting::setValue('bottom_nav', $bottomNavItems);

        if (isset($data['contact'])) {
            SiteSetting::setValue('contact', $data['contact']);
        }

        if (isset($data['socials'])) {
            SiteSetting::setValue('socials', $data['socials']);
        }

        return redirect()->route('admin.settings.edit')->with('status', 'Pengaturan situs berhasil disimpan.');
    }
}
