<?php

namespace App\Livewire\Admin\SiteSettings;

use App\Models\SiteSetting;
use App\Services\SiteSettingService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Artisan;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.dashboard')]
class Index extends Component
{
    use WithFileUploads;

    public string $site_name = '';

    public string $site_tagline = '';

    public mixed $logo = null;

    public ?string $existingLogo = null;

    public mixed $favicon = null;

    public ?string $existingFavicon = null;

    public string $seo_title = '';

    public string $seo_description = '';

    public string $seo_keywords = '';

    public mixed $og_image_file = null;

    public ?string $existingOgImage = null;

    public string $ga4_id = '';

    public string $gsc_verification = '';

    public string $footer_description = '';

    public string $footer_copyright = '';

    public string $footer_subtext = '';

    public array $header_nav = [];

    public array $bottom_nav = [];

    public array $contact = [
        'email' => '',
        'whatsapp' => '',
        'address' => '',
        'hours' => '',
        'inbox_email' => '',
        'map_embed_url' => '',
    ];

    public array $socials = [
        'instagram' => '',
        'linkedin' => '',
        'dribbble' => '',
        'tiktok' => '',
        'twitter' => '',
        'discord' => '',
        'whatsapp' => '',
        'github' => '',
        'youtube' => '',
    ];

    public ?string $sitemapLastGeneratedAt = null;

    public function mount(SiteSettingService $settingsService): void
    {
        $data = $settingsService->getSettingsEditData();

        $this->site_name = (string) $data['siteName'];
        $this->site_tagline = (string) $data['siteTagline'];
        $this->existingLogo = (string) $data['siteLogo'];
        $this->existingFavicon = (string) $data['siteFavicon'];

        $this->seo_title = (string) ($data['seoTitle'] ?? '');
        $this->seo_description = (string) ($data['seoDescription'] ?? '');
        $this->seo_keywords = (string) ($data['seoKeywords'] ?? '');
        $this->existingOgImage = (string) ($data['ogImage'] ?? '');
        $this->ga4_id = (string) ($data['ga4Id'] ?? '');
        $this->gsc_verification = (string) ($data['gscVerification'] ?? '');

        $this->footer_description = (string) $data['footerDescription'];
        $this->footer_copyright = (string) $data['footerCopyright'];
        $this->footer_subtext = (string) $data['footerSubtext'];

        $this->header_nav = (array) $data['headerNav'];
        $this->bottom_nav = (array) $data['bottomNav'];

        $this->contact = array_merge($this->contact, (array) $data['contact']);
        $this->socials = array_merge($this->socials, (array) $data['socials']);

        $this->sitemapLastGeneratedAt = SiteSetting::getValue('sitemap_last_generated_at');
    }

    public function addHeaderNavItem(): void
    {
        $this->header_nav[] = ['label' => '', 'url' => ''];
    }

    public function removeHeaderNavItem(int $index): void
    {
        unset($this->header_nav[$index]);
        $this->header_nav = array_values($this->header_nav);
    }

    public function addBottomNavItem(): void
    {
        $this->bottom_nav[] = ['label' => '', 'url' => '', 'icon' => 'home', 'custom_icon' => ''];
    }

    public function removeBottomNavItem(int $index): void
    {
        unset($this->bottom_nav[$index]);
        $this->bottom_nav = array_values($this->bottom_nav);
    }

    public function generateSitemap(): void
    {
        try {
            Artisan::call('sitemap:generate');
            $now = now()->toIso8601String();
            SiteSetting::setValue('sitemap_last_generated_at', $now);
            $this->sitemapLastGeneratedAt = $now;
            session()->flash('status', 'Sitemap XML berhasil diperbarui secara instan!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Gagal generate sitemap: '.$e->getMessage());
        }
    }

    public function save(SiteSettingService $settingsService): void
    {
        $this->validate([
            'site_name' => ['required', 'string', 'max:255'],
            'site_tagline' => ['nullable', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'max:4096'],
            'favicon' => ['nullable', 'image', 'max:2048'],
            'og_image_file' => ['nullable', 'image', 'max:4096'],
            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string', 'max:500'],
            'seo_keywords' => ['nullable', 'string', 'max:500'],
            'ga4_id' => ['nullable', 'string', 'max:64', 'regex:/^(G-[A-Za-z0-9]+)?$/'],
            'gsc_verification' => ['nullable', 'string', 'max:255'],
        ], [
            'site_name.required' => 'Nama brand / website wajib diisi.',
            'site_name.max' => 'Nama brand tidak boleh lebih dari 255 karakter.',
            'site_tagline.max' => 'Tagline tidak boleh lebih dari 255 karakter.',
            'logo.image' => 'Logo harus berupa gambar.',
            'logo.max' => 'Ukuran logo maksimal adalah 4MB.',
            'favicon.image' => 'Favicon harus berupa gambar.',
            'favicon.max' => 'Ukuran favicon maksimal adalah 2MB.',
            'og_image_file.image' => 'OG Image harus berupa gambar.',
            'og_image_file.max' => 'Ukuran OG Image maksimal adalah 4MB.',
            'seo_title.max' => 'SEO Title tidak boleh lebih dari 255 karakter.',
            'seo_description.max' => 'SEO Description tidak boleh lebih dari 500 karakter.',
            'seo_keywords.max' => 'SEO Keywords tidak boleh lebih dari 500 karakter.',
            'ga4_id.max' => 'ID GA4 tidak boleh lebih dari 64 karakter.',
            'ga4_id.regex' => 'ID GA4 harus diawali dengan G- (contoh: G-XXXXXXXXXX).',
            'gsc_verification.max' => 'Kode verifikasi GSC tidak boleh lebih dari 255 karakter.',
        ]);

        $files = [];
        if ($this->logo) {
            $files['site_logo'] = $this->logo;
        }
        if ($this->favicon) {
            $files['site_favicon'] = $this->favicon;
        }
        if ($this->og_image_file) {
            $files['og_image_file'] = $this->og_image_file;
        }

        $settingsService->updateSettings([
            'site_name' => $this->site_name,
            'site_tagline' => $this->site_tagline,
            'seo_title' => $this->seo_title,
            'seo_description' => $this->seo_description,
            'seo_keywords' => $this->seo_keywords,
            'ga4_id' => $this->ga4_id,
            'gsc_verification' => $this->gsc_verification,
            'footer_description' => $this->footer_description,
            'footer_copyright' => $this->footer_copyright,
            'footer_subtext' => $this->footer_subtext,
            'header_nav' => $this->header_nav,
            'bottom_nav' => $this->bottom_nav,
            'contact' => $this->contact,
            'socials' => $this->socials,
        ], $files);

        $this->existingLogo = SiteSetting::getValue('site_logo');
        $this->existingFavicon = SiteSetting::getValue('site_favicon');
        $this->existingOgImage = SiteSetting::getValue('og_image');
        $this->reset(['logo', 'favicon', 'og_image_file']);

        session()->flash('status', 'Pengaturan situs dan SEO berhasil disimpan.');
    }

    public function render(): View
    {
        return view('livewire.admin.site-settings');
    }
}
