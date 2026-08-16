<?php

namespace App\Services;

use App\Models\SiteSetting;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class SiteSettingService
{
    /**
     * @return array<string, mixed>
     */
    public function getSettingsEditData(): array
    {
        return [
            'siteName' => SiteSetting::getValue('site_name', 'Sankara Tech'),
            'siteTagline' => SiteSetting::getValue('site_tagline', 'Digital Agency'),
            'siteLogo' => SiteSetting::getValue('site_logo', '/logo.webp'),
            'siteFavicon' => SiteSetting::getValue('site_favicon', '/favicon.svg'),
            'footerDescription' => SiteSetting::getValue('footer_description', 'Kami membangun produk digital modern: website, software, aplikasi mobile, UI/UX, game development, dan 3D modeling—dengan kualitas premium yang meyakinkan.'),
            'footerCopyright' => SiteSetting::getValue('footer_copyright', '© '.date('Y').' Sankara Tech. All rights reserved.'),
            'footerSubtext' => SiteSetting::getValue('footer_subtext', 'Built with Laravel • Blade • Livewire • Tailwind'),
            'headerNav' => SiteSetting::getValue('header_nav', [
                ['key' => 'home', 'label' => 'Home', 'url' => '/'],
                ['key' => 'about', 'label' => 'Tentang Kami', 'url' => '/tentang-kami'],
                ['key' => 'services', 'label' => 'Layanan', 'url' => '/layanan'],
                ['key' => 'portfolios', 'label' => 'Portofolio', 'url' => '/portfolio'],
                ['key' => 'contact', 'label' => 'Kontak', 'url' => '/kontak'],
            ]),
            'bottomNav' => SiteSetting::getValue('bottom_nav', [
                ['key' => 'home', 'label' => 'Home', 'url' => '/', 'icon' => 'home', 'custom_icon' => ''],
                ['key' => 'services', 'label' => 'Layanan', 'url' => '/layanan', 'icon' => 'services', 'custom_icon' => ''],
                ['key' => 'portfolios', 'label' => 'Portofolio', 'url' => '/portfolio', 'icon' => 'portfolios', 'custom_icon' => ''],
                ['key' => 'contact', 'label' => 'Kontak', 'url' => '/kontak', 'icon' => 'contact', 'custom_icon' => ''],
            ]),
            'contact' => SiteSetting::getValue('contact', [
                'email' => 'hello@sankaratech.com',
                'whatsapp' => '+62 812-0000-0000',
                'address' => 'Jakarta, Indonesia',
                'hours' => 'Senin–Jumat, 09.00–18.00 WIB',
                'inbox_email' => 'hello@sankaratech.com',
                'map_embed_url' => '',
            ]),
            'socials' => SiteSetting::getValue('socials', [
                'instagram' => 'https://instagram.com/',
                'linkedin' => 'https://linkedin.com/',
                'dribbble' => 'https://dribbble.com/',
                'tiktok' => '',
                'twitter' => '',
                'discord' => '',
                'whatsapp' => '',
                'github' => '',
                'youtube' => '',
            ]),
            'seoTitle' => SiteSetting::getValue('seo_title', 'Sankara Tech - Digital Agency & Software House'),
            'seoDescription' => SiteSetting::getValue('seo_description', 'Kami membangun produk digital modern dengan performa tinggi.'),
            'seoKeywords' => SiteSetting::getValue('seo_keywords', 'software house, web development, mobile app, ui ux design'),
            'ogImage' => SiteSetting::getValue('og_image', ''),
            'ga4Id' => SiteSetting::getValue('ga4_id', ''),
            'gscVerification' => SiteSetting::getValue('gsc_verification', ''),
        ];
    }

    /**
     * @param  array<string, mixed>  $data
     * @param  array<string, UploadedFile|null>  $files
     */
    public function updateSettings(array $data, array $files = []): void
    {
        SiteSetting::setValue('site_name', $data['site_name']);
        SiteSetting::setValue('site_tagline', $data['site_tagline'] ?? '');
        SiteSetting::setValue('footer_description', $data['footer_description'] ?? '');
        SiteSetting::setValue('footer_copyright', $data['footer_copyright'] ?? '');
        SiteSetting::setValue('footer_subtext', $data['footer_subtext'] ?? '');

        if (isset($files['site_logo']) && $files['site_logo'] instanceof UploadedFile) {
            $logoPath = '/storage/'.$files['site_logo']->store('settings', 'public');
            SiteSetting::setValue('site_logo', $logoPath);
        }

        if (isset($files['site_favicon']) && $files['site_favicon'] instanceof UploadedFile) {
            $faviconPath = '/storage/'.$files['site_favicon']->store('settings', 'public');
            SiteSetting::setValue('site_favicon', $faviconPath);
        }

        $headerNavItems = [];
        if (isset($data['header_nav']) && is_array($data['header_nav'])) {
            foreach ($data['header_nav'] as $item) {
                if (empty($item['label']) || empty($item['url'])) {
                    continue;
                }
                $headerNavItems[] = [
                    'key' => Str::slug($item['label']),
                    'label' => trim((string) $item['label']),
                    'url' => trim((string) $item['url']),
                ];
            }
        }
        SiteSetting::setValue('header_nav', $headerNavItems);

        $bottomNavItems = [];
        if (isset($data['bottom_nav']) && is_array($data['bottom_nav'])) {
            foreach ($data['bottom_nav'] as $item) {
                if (empty($item['label']) || empty($item['url'])) {
                    continue;
                }
                $bottomNavItems[] = [
                    'key' => Str::slug($item['label']),
                    'label' => trim((string) $item['label']),
                    'url' => trim((string) $item['url']),
                    'icon' => $item['icon'] ?? 'home',
                    'custom_icon' => trim((string) ($item['custom_icon'] ?? '')),
                ];
            }
        }
        SiteSetting::setValue('bottom_nav', $bottomNavItems);

        if (isset($data['contact']) && is_array($data['contact'])) {
            SiteSetting::setValue('contact', $data['contact']);
        }

        if (isset($data['socials']) && is_array($data['socials'])) {
            SiteSetting::setValue('socials', $data['socials']);
        }

        SiteSetting::setValue('seo_title', $data['seo_title'] ?? '');
        SiteSetting::setValue('seo_description', $data['seo_description'] ?? '');
        SiteSetting::setValue('seo_keywords', $data['seo_keywords'] ?? '');
        SiteSetting::setValue('ga4_id', $data['ga4_id'] ?? '');
        SiteSetting::setValue('gsc_verification', $data['gsc_verification'] ?? '');

        if (isset($files['og_image_file']) && $files['og_image_file'] instanceof UploadedFile) {
            $ogPath = '/storage/'.$files['og_image_file']->store('settings', 'public');
            SiteSetting::setValue('og_image', $ogPath);
        } elseif (isset($data['og_image'])) {
            SiteSetting::setValue('og_image', $data['og_image']);
        }
    }
}
