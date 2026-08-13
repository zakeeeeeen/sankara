<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $services = Service::query()->active()->orderBy('sort_order')->get();

        return view('services.index', compact('services'));
    }

    public function show(Request $request, string $slug)
    {
        $service = Service::query()->active()->where('slug', $slug)->firstOrFail();
        $service->load(['features', 'portfolioCategories']);

        $categoryIds = $service->portfolioCategories->pluck('id')->all();
        $relatedPortfolios = Portfolio::query()
            ->active()
            ->when(
                count($categoryIds) > 0,
                fn ($q) => $q->whereHas('categories', fn ($c) => $c->whereIn('portfolio_categories.id', $categoryIds)),
                fn ($q) => $q->whereRaw('1=0'),
            )
            ->with('categories')
            ->orderByDesc('published_at')
            ->orderBy('sort_order')
            ->limit(3)
            ->get();

        return view('services.show', compact('service', 'relatedPortfolios'));
    }
}

