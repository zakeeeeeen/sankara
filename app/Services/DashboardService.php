<?php

namespace App\Services;

use App\Models\ContactMessage;
use App\Models\Portfolio;
use App\Models\PortfolioCategory;
use App\Models\PricingPlan;
use App\Models\Service;
use App\Models\SiteSetting;
use Illuminate\Database\Eloquent\Collection;

class DashboardService
{
    /**
     * @return array{
     *     siteName: string,
     *     siteTagline: string,
     *     siteLogo: string,
     *     servicesCount: int,
     *     portfoliosCount: int,
     *     categoriesCount: int,
     *     pricingCount: int,
     *     messagesCount: int,
     *     recentMessages: Collection<int, ContactMessage>
     * }
     */
    public function getDashboardData(): array
    {
        return [
            'siteName' => SiteSetting::getValue('site_name', 'Sankara Tech'),
            'siteTagline' => SiteSetting::getValue('site_tagline', 'Digital Agency'),
            'siteLogo' => SiteSetting::getValue('site_logo', asset('logo.webp')),
            'servicesCount' => Service::query()->count(),
            'portfoliosCount' => Portfolio::query()->count(),
            'categoriesCount' => PortfolioCategory::query()->count(),
            'pricingCount' => PricingPlan::query()->count(),
            'messagesCount' => ContactMessage::query()->count(),
            'recentMessages' => ContactMessage::query()->latest()->limit(5)->get(),
        ];
    }
}
