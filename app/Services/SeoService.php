<?php

namespace App\Services;

use App\Models\SiteSetting;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class SeoService
{
    /**
     * Generate dynamic SEO meta tags.
     *
     * @param  array<string, mixed>  $custom
     */
    public function renderTags(array $custom = []): HtmlString
    {
        $siteName = (string) SiteSetting::getValue('site_name', config('app.name', 'Sankara Tech'));
        $siteTagline = (string) SiteSetting::getValue('site_tagline', 'Digital Agency');
        $defaultTitle = (string) SiteSetting::getValue('meta_title', $siteName.' - '.$siteTagline);
        $defaultDescription = (string) SiteSetting::getValue(
            'meta_description',
            SiteSetting::getValue('footer_description', 'Sankara Tech adalah digital agency modern penyedia solusi website, software custom, mobile app, UI/UX, game, dan 3D modeling.')
        );
        $defaultKeywords = (string) SiteSetting::getValue('meta_keywords', 'digital agency, web development, software development, mobile app, UI UX design, game development, 3d modeling, laravel, tailwind, sankara tech');
        $defaultOgImage = (string) SiteSetting::getValue('og_image', SiteSetting::getValue('site_logo', asset('logo.webp')));

        if (! str_starts_with($defaultOgImage, 'http') && filled($defaultOgImage)) {
            $defaultOgImage = url($defaultOgImage);
        }

        $title = $custom['title'] ?? $defaultTitle;
        $description = Str::limit(strip_tags($custom['description'] ?? $defaultDescription), 160);
        $keywords = $custom['keywords'] ?? $defaultKeywords;
        $ogImage = $custom['image'] ?? $defaultOgImage;
        if (! str_starts_with((string) $ogImage, 'http') && filled($ogImage)) {
            $ogImage = url((string) $ogImage);
        }
        $canonical = $custom['canonical'] ?? url()->current();
        $type = $custom['type'] ?? 'website';
        $robots = $custom['robots'] ?? (app()->environment('production') ? 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1' : 'noindex, nofollow');
        $gaId = trim((string) SiteSetting::getValue('ga_measurement_id', ''));
        $gscCode = trim((string) SiteSetting::getValue('google_search_console_code', ''));

        $html = [];

        // Basic Meta
        $html[] = '<meta name="description" content="'.e($description).'">';
        if (filled($keywords)) {
            $html[] = '<meta name="keywords" content="'.e($keywords).'">';
        }
        $html[] = '<meta name="robots" content="'.e($robots).'">';
        $html[] = '<link rel="canonical" href="'.e($canonical).'">';

        if (filled($gscCode)) {
            $html[] = '<meta name="google-site-verification" content="'.e($gscCode).'">';
        }

        // OpenGraph
        $html[] = '<meta property="og:site_name" content="'.e($siteName).'">';
        $html[] = '<meta property="og:title" content="'.e($title).'">';
        $html[] = '<meta property="og:description" content="'.e($description).'">';
        $html[] = '<meta property="og:url" content="'.e($canonical).'">';
        $html[] = '<meta property="og:type" content="'.e($type).'">';
        if (filled($ogImage)) {
            $html[] = '<meta property="og:image" content="'.e($ogImage).'">';
            $html[] = '<meta property="og:image:alt" content="'.e($title).'">';
        }

        // Twitter Cards
        $html[] = '<meta name="twitter:card" content="summary_large_image">';
        $html[] = '<meta name="twitter:title" content="'.e($title).'">';
        $html[] = '<meta name="twitter:description" content="'.e($description).'">';
        if (filled($ogImage)) {
            $html[] = '<meta name="twitter:image" content="'.e($ogImage).'">';
        }

        // Google Analytics 4 (Async with DNS preconnect)
        if (filled($gaId) && preg_match('/^G-[A-Za-z0-9]+$/', $gaId)) {
            $html[] = '<link rel="preconnect" href="https://www.googletagmanager.com" crossorigin>';
            $html[] = '<link rel="dns-prefetch" href="https://www.googletagmanager.com">';
            $html[] = '<script async src="https://www.googletagmanager.com/gtag/js?id='.e($gaId).'"></script>';
            $html[] = '<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag("js",new Date());gtag("config","'.e($gaId).'",{page_path:window.location.pathname});</script>';
        }

        return new HtmlString(implode("\n        ", $html));
    }

    /**
     * Generate Schema.org JSON-LD structured data.
     *
     * @param  array<string, mixed>  $context
     */
    public function renderStructuredData(array $context = []): HtmlString
    {
        $siteName = (string) SiteSetting::getValue('site_name', config('app.name', 'Sankara Tech'));
        $siteLogo = (string) SiteSetting::getValue('site_logo', asset('logo.webp'));
        if (! str_starts_with($siteLogo, 'http') && filled($siteLogo)) {
            $siteLogo = url($siteLogo);
        }
        $contact = SiteSetting::getValue('contact', []);
        $socials = SiteSetting::getValue('socials', []);

        $sameAs = [];
        if (is_array($socials)) {
            foreach ($socials as $url) {
                if (filled($url) && $url !== '#' && str_starts_with((string) $url, 'http')) {
                    $sameAs[] = $url;
                }
            }
        }

        // 1. Organization & LocalBusiness
        $organization = [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            '@id' => url('/#organization'),
            'name' => $siteName,
            'url' => url('/'),
            'logo' => $siteLogo,
            'description' => (string) SiteSetting::getValue('footer_description', 'Digital agency modern untuk solusi website, software, mobile apps, UI/UX, game, dan 3D.'),
        ];

        if (count($sameAs) > 0) {
            $organization['sameAs'] = $sameAs;
        }

        if (is_array($contact)) {
            if (filled($contact['email'] ?? null)) {
                $organization['email'] = $contact['email'];
            }
            if (filled($contact['whatsapp'] ?? null)) {
                $organization['telephone'] = $contact['whatsapp'];
            }
            if (filled($contact['address'] ?? null)) {
                $organization['address'] = [
                    '@type' => 'PostalAddress',
                    'streetAddress' => $contact['address'],
                    'addressCountry' => 'ID',
                ];
            }
        }

        // 2. WebSite with SearchAction
        $website = [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            '@id' => url('/#website'),
            'url' => url('/'),
            'name' => $siteName,
            'publisher' => [
                '@id' => url('/#organization'),
            ],
        ];

        $schemas = [$organization, $website];

        // 3. Custom schemas (e.g. Service or Portfolio)
        if (isset($context['service'])) {
            $srv = $context['service'];
            $schemas[] = [
                '@context' => 'https://schema.org',
                '@type' => 'Service',
                'name' => $srv['title'] ?? '',
                'description' => $srv['description'] ?? ($srv['excerpt'] ?? ''),
                'provider' => [
                    '@id' => url('/#organization'),
                ],
                'url' => $srv['url'] ?? url()->current(),
            ];
        }

        if (isset($context['portfolio'])) {
            $port = $context['portfolio'];
            $schemas[] = [
                '@context' => 'https://schema.org',
                '@type' => 'CreativeWork',
                'name' => $port['title'] ?? '',
                'headline' => $port['title'] ?? '',
                'description' => $port['excerpt'] ?? '',
                'image' => $port['image'] ?? $siteLogo,
                'creator' => [
                    '@id' => url('/#organization'),
                ],
                'url' => $port['url'] ?? url()->current(),
            ];
        }

        if (isset($context['breadcrumb']) && is_array($context['breadcrumb'])) {
            $itemListElement = [];
            foreach ($context['breadcrumb'] as $i => $crumb) {
                $itemListElement[] = [
                    '@type' => 'ListItem',
                    'position' => $i + 1,
                    'name' => $crumb['name'] ?? '',
                    'item' => $crumb['url'] ?? url('/'),
                ];
            }

            $schemas[] = [
                '@context' => 'https://schema.org',
                '@type' => 'BreadcrumbList',
                'itemListElement' => $itemListElement,
            ];
        }

        $json = json_encode($schemas, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        return new HtmlString('<script type="application/ld+json">'."\n".$json."\n".'</script>');
    }
}
