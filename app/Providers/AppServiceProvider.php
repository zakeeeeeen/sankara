<?php

namespace App\Providers;

use App\Models\SiteSetting;
use App\Services\SeoService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(SeoService::class, fn () => new SeoService);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layouts.marketing', function ($view): void {
            $view->with([
                'siteSettings' => SiteSetting::getAllCached(),
                'seoService' => app(SeoService::class),
            ]);
        });
    }
}
