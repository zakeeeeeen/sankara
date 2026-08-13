<?php

namespace App\Http\Controllers;

use App\Models\Advantage;
use App\Models\HomeAbout;
use App\Models\HomeCta;
use App\Models\HomeHero;
use App\Models\HomeStat;
use App\Models\Portfolio;
use App\Models\PricingPlan;
use App\Models\Service;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function __invoke(Request $request)
    {
        $hero = HomeHero::query()->first();
        $stats = HomeStat::query()->orderBy('sort_order')->get();
        $about = HomeAbout::query()->first();
        $advantages = Advantage::query()->orderBy('sort_order')->get();
        $services = Service::query()->active()->orderBy('sort_order')->limit(6)->get();
        $portfolios = Portfolio::query()->active()->orderByDesc('published_at')->orderBy('sort_order')->get();
        $pricingPlans = PricingPlan::query()->orderBy('sort_order')->get()->load('features');
        $cta = HomeCta::query()->first();
        $contact = SiteSetting::getValue('contact', [
            'email' => 'hello@kersa.agency',
            'whatsapp' => '+62 812-0000-0000',
            'address' => 'Jakarta, Indonesia',
            'hours' => 'Senin–Jumat, 09.00–18.00 WIB',
        ]);

        $socials = SiteSetting::getValue('socials', [
            'instagram' => '#',
            'linkedin' => '#',
            'dribbble' => '#',
        ]);

        return view('landing', compact(
            'hero',
            'stats',
            'about',
            'advantages',
            'services',
            'portfolios',
            'pricingPlans',
            'cta',
            'contact',
            'socials',
        ));
    }
}

