<?php

use App\Http\Controllers\ContactController;
use App\Livewire\Admin\Auth\Login as AdminLogin;
use App\Livewire\Admin\ContactMessages\Index as AdminContactMessagesIndex;
use App\Livewire\Admin\ContactMessages\Show as AdminContactMessagesShow;
use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Admin\HomeSettings\Index as AdminHomeSettings;
use App\Livewire\Admin\Pages\About as AdminPagesAbout;
use App\Livewire\Admin\PortfolioCategories\Index as AdminPortfolioCategoriesIndex;
use App\Livewire\Admin\Portfolios\Create as AdminPortfoliosCreate;
use App\Livewire\Admin\Portfolios\Edit as AdminPortfoliosEdit;
use App\Livewire\Admin\Portfolios\Index as AdminPortfoliosIndex;
use App\Livewire\Admin\Pricing\Create as AdminPricingCreate;
use App\Livewire\Admin\Pricing\Edit as AdminPricingEdit;
use App\Livewire\Admin\Pricing\Index as AdminPricingIndex;
use App\Livewire\Admin\Services\Create as AdminServicesCreate;
use App\Livewire\Admin\Services\Edit as AdminServicesEdit;
use App\Livewire\Admin\Services\Index as AdminServicesIndex;
use App\Livewire\Admin\SiteSettings\Index as AdminSiteSettings;
use App\Livewire\Pages\About as PublicAbout;
use App\Livewire\Pages\Contact as PublicContact;
use App\Livewire\Pages\Home as PublicHome;
use App\Livewire\Pages\Portfolios\Index as PublicPortfoliosIndex;
use App\Livewire\Pages\Portfolios\Show as PublicPortfoliosShow;
use App\Livewire\Pages\Services\Index as PublicServicesIndex;
use App\Livewire\Pages\Services\Show as PublicServicesShow;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;

// Public Marketing Livewire Routes
Route::get('/', PublicHome::class)->name('home');
Route::get('/tentang-kami', PublicAbout::class)->name('about');

Route::get('/layanan', PublicServicesIndex::class)->name('services.index');
Route::get('/layanan/{slug}', PublicServicesShow::class)->name('services.show');

Route::get('/portfolio', PublicPortfoliosIndex::class)->name('portfolios.index');
Route::get('/portfolio/{slug}', PublicPortfoliosShow::class)->name('portfolios.show');

Route::get('/kontak', PublicContact::class)->name('contact.show');
Route::post('/kontak', [ContactController::class, 'store'])->name('contact.store');

// SEO Routes: sitemap.xml & robots.txt
Route::get('/sitemap.xml', function () {
    $path = public_path('sitemap.xml');
    if (! File::exists($path)) {
        Artisan::call('sitemap:generate');
    }

    if (File::exists($path)) {
        return Response::make(File::get($path), 200, [
            'Content-Type' => 'application/xml; charset=utf-8',
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }

    abort(404);
})->name('sitemap');

Route::get('/robots.txt', function () {
    $path = public_path('robots.txt');
    if (File::exists($path)) {
        return Response::make(File::get($path), 200, [
            'Content-Type' => 'text/plain; charset=utf-8',
            'Cache-Control' => 'public, max-age=86400',
        ]);
    }

    return response("User-agent: *\nAllow: /\nDisallow: /admin/\nSitemap: ".url('sitemap.xml')."\n", 200, [
        'Content-Type' => 'text/plain; charset=utf-8',
    ]);
})->name('robots');

// Admin Panel Livewire Routes
Route::prefix('admin')->name('admin.')->group(function (): void {
    Route::get('/login', AdminLogin::class)->middleware('guest')->name('login');
    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('admin.login');
    })->middleware('auth')->name('logout');

    Route::middleware(['auth', 'admin'])->group(function (): void {
        Route::get('/', AdminDashboard::class)->name('dashboard');
        Route::get('/home', AdminHomeSettings::class)->name('home.edit');
        Route::get('/pages/about', AdminPagesAbout::class)->name('pages.about.edit');

        // Services Livewire
        Route::get('/services', AdminServicesIndex::class)->name('services.index');
        Route::get('/services/create', AdminServicesCreate::class)->name('services.create');
        Route::get('/services/{service}/edit', AdminServicesEdit::class)->name('services.edit');

        // Portfolios Livewire
        Route::get('/portfolios', AdminPortfoliosIndex::class)->name('portfolios.index');
        Route::get('/portfolios/create', AdminPortfoliosCreate::class)->name('portfolios.create');
        Route::get('/portfolios/{portfolio}/edit', AdminPortfoliosEdit::class)->name('portfolios.edit');
        Route::get('/portfolio-categories', AdminPortfolioCategoriesIndex::class)->name('portfolio-categories.index');

        // Pricing Plans Livewire
        Route::get('/pricing', AdminPricingIndex::class)->name('pricing.index');
        Route::get('/pricing/create', AdminPricingCreate::class)->name('pricing.create');
        Route::get('/pricing/{plan}/edit', AdminPricingEdit::class)->name('pricing.edit');

        // Site Settings, SEO & Sitemap Livewire
        Route::get('/settings', AdminSiteSettings::class)->name('settings.edit');
        Route::post('/sitemap/generate', function () {
            Artisan::call('sitemap:generate');
            $now = now()->toIso8601String();
            SiteSetting::setValue('sitemap_last_generated_at', $now);

            return back()->with('status', 'Sitemap XML berhasil di-generate!');
        })->name('sitemap.generate');

        // Contact Messages Livewire
        Route::get('/contact-messages', AdminContactMessagesIndex::class)->name('contact-messages.index');
        Route::get('/contact-messages/{message}', AdminContactMessagesShow::class)->name('contact-messages.show');
    });
});
