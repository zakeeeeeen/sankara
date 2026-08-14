<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Portfolio;
use App\Models\PortfolioCategory;
use App\Models\PricingPlan;
use App\Models\Service;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $servicesCount = Service::query()->count();
        $portfoliosCount = Portfolio::query()->count();
        $categoriesCount = PortfolioCategory::query()->count();
        $pricingCount = PricingPlan::query()->count();
        $messagesCount = ContactMessage::query()->count();

        $recentMessages = ContactMessage::query()
            ->latest()
            ->take(5)
            ->get();

        $siteName = SiteSetting::getValue('site_name', 'Sankara Tech');
        $siteTagline = SiteSetting::getValue('site_tagline', 'Digital Agency');
        $siteLogo = SiteSetting::getValue('site_logo', asset('logosankara.png'));

        return view('admin.dashboard', compact(
            'servicesCount',
            'portfoliosCount',
            'categoriesCount',
            'pricingCount',
            'messagesCount',
            'recentMessages',
            'siteName',
            'siteTagline',
            'siteLogo'
        ));
    }
}
