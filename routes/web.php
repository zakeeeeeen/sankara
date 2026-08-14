<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\ContactMessageController as AdminContactMessageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\PortfolioCategoryController;
use App\Http\Controllers\Admin\PortfolioController as AdminPortfolioController;
use App\Http\Controllers\Admin\PricingPlanController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

Route::get('/', LandingController::class)->name('home');

Route::get('/tentang-kami', AboutController::class)->name('about');

Route::get('/layanan', [ServiceController::class, 'index'])->name('services.index');
Route::get('/layanan/{slug}', [ServiceController::class, 'show'])->name('services.show');

Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolios.index');
Route::get('/portfolio/{slug}', [PortfolioController::class, 'show'])->name('portfolios.show');

Route::get('/kontak', [ContactController::class, 'show'])->name('contact.show');
Route::post('/kontak', [ContactController::class, 'store'])->name('contact.store');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'create'])->middleware('guest')->name('login');
    Route::post('/login', [AdminAuthController::class, 'store'])->middleware('guest')->name('login.store');
    Route::post('/logout', [AdminAuthController::class, 'destroy'])->middleware('auth')->name('logout');

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/', DashboardController::class)->name('dashboard');
        Route::get('/home', [AdminHomeController::class, 'edit'])->name('home.edit');
        Route::put('/home', [AdminHomeController::class, 'update'])->name('home.update');

        Route::get('/pages/about', [AdminPageController::class, 'edit'])->name('pages.about.edit');
        Route::put('/pages/about', [AdminPageController::class, 'update'])->name('pages.about.update');

        Route::resource('services', AdminServiceController::class)->except(['show']);
        Route::resource('portfolios', AdminPortfolioController::class)->except(['show']);
        Route::resource('portfolio-categories', PortfolioCategoryController::class)->only(['index', 'store', 'update', 'destroy']);
        Route::resource('pricing', PricingPlanController::class)->except(['show'])->parameters(['pricing' => 'plan']);

        Route::get('/settings', [SiteSettingController::class, 'edit'])->name('settings.edit');
        Route::put('/settings', [SiteSettingController::class, 'update'])->name('settings.update');

        Route::get('contact-messages', [AdminContactMessageController::class, 'index'])->name('contact-messages.index');
        Route::get('contact-messages/{message}', [AdminContactMessageController::class, 'show'])->name('contact-messages.show');
        Route::delete('contact-messages/{message}', [AdminContactMessageController::class, 'destroy'])->name('contact-messages.destroy');
    });
});
