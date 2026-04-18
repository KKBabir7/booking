<?php

use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\NavbarController;
use App\Http\Controllers\Admin\PromoBannerController;
use App\Http\Controllers\Admin\RoomController as AdminRoomController;
use App\Http\Controllers\Admin\PageSettingController;
use App\Http\Controllers\Admin\ConferenceHallController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\OfferBannerController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CurrencyController;
use Illuminate\Support\Facades\Route;

// ==================== Admin Auth ====================
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login')->middleware('guest');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store')->middleware('guest');
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout')->middleware('auth');
});

// ==================== Admin Protected Routes ====================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/notifications/counts', [DashboardController::class, 'getNotificationCounts'])->name('notifications.counts');

    Route::resource('navbar', NavbarController::class);
    Route::post('navbar/update-logo', [NavbarController::class, 'updateLogo'])->name('navbar.update-logo');
    Route::resource('reviews', AdminReviewController::class);

    // Modernized Home Page Routes
    Route::resource('home/banners', BannerController::class)->names('home_banners');
    Route::resource('home/promo_banners', PromoBannerController::class)->names('home_promo_banners');
    Route::resource('home/offer_banners', OfferBannerController::class)->names('home_offer_banners');
    Route::resource('home/services', ServiceController::class)->names('home_services');
    Route::resource('home/clients', ClientController::class)->names('home_clients');

    // Page Settings (Dynamic)
    Route::get('/home/restaurant', [PageSettingController::class, 'edit'])->defaults('page', 'home_restaurant')->name('home_restaurant');
    Route::put('/home/restaurant', [PageSettingController::class, 'update'])->defaults('page', 'home_restaurant')->name('home_restaurant.update');

    Route::get('/home/conference', [PageSettingController::class, 'edit'])->defaults('page', 'home_conference')->name('home_conference');
    Route::put('/home/conference', [PageSettingController::class, 'update'])->defaults('page', 'home_conference')->name('home_conference.update');

    // Page Settings
    Route::prefix('page')->name('page.')->group(function () {
        Route::get('/about', [PageSettingController::class, 'edit'])->defaults('page', 'about')->name('about.edit');
        Route::put('/about', [PageSettingController::class, 'update'])->defaults('page', 'about')->name('about.update');

        Route::get('/faq', [PageSettingController::class, 'edit'])->defaults('page', 'faq')->name('faq.edit');
        Route::put('/faq', [PageSettingController::class, 'update'])->defaults('page', 'faq')->name('faq.update');

        Route::get('/privacy-policy', [PageSettingController::class, 'edit'])->defaults('page', 'privacy_policy')->name('privacy.edit');
        Route::put('/privacy-policy', [PageSettingController::class, 'update'])->defaults('page', 'privacy_policy')->name('privacy.update');

        Route::get('/terms-of-service', [PageSettingController::class, 'edit'])->defaults('page', 'terms_of_service')->name('terms.edit');
        Route::put('/terms-of-service', [PageSettingController::class, 'update'])->defaults('page', 'terms_of_service')->name('terms.update');

        Route::get('/contact-information', [PageSettingController::class, 'edit'])->defaults('page', 'contact_information')->name('contact_information.edit');
        Route::put('/contact-information', [PageSettingController::class, 'update'])->defaults('page', 'contact_information')->name('contact_information.update');
    });

    // SEO Management
    Route::prefix('seo')->name('seo.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\SeoController::class, 'index'])->name('index');
        Route::post('/favicon', [\App\Http\Controllers\Admin\SeoController::class, 'updateFavicon'])->name('favicon.update');
        Route::delete('/favicon', [\App\Http\Controllers\Admin\SeoController::class, 'deleteFavicon'])->name('favicon.delete');
        Route::post('/meta', [\App\Http\Controllers\Admin\SeoController::class, 'store'])->name('store');
        Route::put('/meta/{seo_meta}', [\App\Http\Controllers\Admin\SeoController::class, 'update'])->name('update');
        Route::delete('/meta/{seo_meta}', [\App\Http\Controllers\Admin\SeoController::class, 'destroy'])->name('destroy');
    });

    // Rooms & Conference
    Route::prefix('page')->group(function () {
        Route::resource('rooms', AdminRoomController::class)->parameters(['rooms' => 'room'])->names('rooms');
        Route::resource('conference', ConferenceHallController::class)->parameters(['conference' => 'conference_hall'])->names('conference');
        Route::patch('conference/{conference_hall}/toggle-status', [ConferenceHallController::class, 'toggleStatus'])->name('conference.toggle-status');
    });

    // Generic Page Settings (for rooms, etc)
    Route::get('/page/{page}', [PageSettingController::class, 'edit'])->name('page.edit');
    Route::put('/page/{page}', [PageSettingController::class, 'update'])->name('page.update');

    // Administrative (Super Admin only)
    Route::middleware('super_admin')->group(function () {
        Route::resource('admin-user', \App\Http\Controllers\Admin\AdminUserController::class)->names('admin-user');
        
        // Payment Settings
        Route::get('payment-settings', [\App\Http\Controllers\Admin\PaymentSettingController::class, 'index'])->name('payment-settings.index');
        Route::post('payment-settings/update', [\App\Http\Controllers\Admin\PaymentSettingController::class, 'update'])->name('payment-settings.update');
        
        // Restaurant Management (Advance Payment CRUD)
        Route::resource('restaurants', \App\Http\Controllers\Admin\RestaurantController::class);
    });

    // Users (General Admin access)
    Route::resource('users', UserController::class);

    // Bookings (General Admin access)
    Route::get('bookings/{booking}/invoice', [\App\Http\Controllers\Admin\BookingController::class, 'invoice'])->name('bookings.invoice');
    Route::resource('bookings', \App\Http\Controllers\Admin\BookingController::class);

    // Contact Messages
    Route::resource('contacts', \App\Http\Controllers\Admin\ContactController::class)->only(['index', 'show', 'destroy']);
    Route::post('contacts/{contact}/reply', [\App\Http\Controllers\Admin\ContactController::class, 'reply'])->name('contacts.reply');

    // Currency Management
    Route::resource('currencies', CurrencyController::class)->except(['create', 'show', 'edit']);
    Route::post('currencies/refresh-rates', [CurrencyController::class, 'refreshRates'])->name('currencies.refresh-rates');
    Route::patch('currencies/{currency}/set-default', [CurrencyController::class, 'setAsDefault'])->name('currencies.set-default');
    Route::patch('currencies/{currency}/toggle-status', [CurrencyController::class, 'toggleStatus'])->name('currencies.toggle-status');

    // Email Management
    Route::get('/email-settings', [\App\Http\Controllers\Admin\EmailSettingController::class, 'index'])->name('email-settings.index');
    Route::post('/email-settings/credentials', [\App\Http\Controllers\Admin\EmailSettingController::class, 'updateCredentials'])->name('email-settings.update-credentials');
    Route::post('/email-settings/template/{template}', [\App\Http\Controllers\Admin\EmailSettingController::class, 'updateTemplate'])->name('email-settings.update-template');
});
