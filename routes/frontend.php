<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/rooms', [HomeController::class, 'rooms'])->name('rooms.index');
Route::get('/conference', [\App\Http\Controllers\ConferenceController::class, 'index'])->name('conference.index');
Route::get('/restaurant', [\App\Http\Controllers\RestaurantController::class, 'index'])->name('restaurant.index');
Route::get('/rooms/{slug}', [HomeController::class, 'roomDetails'])->name('rooms.show');

Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/gallery', [HomeController::class, 'gallery'])->name('gallery');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact/send', [\App\Http\Controllers\ContactController::class, 'store'])->name('contact.send');
Route::get('/our-clients', [HomeController::class, 'ourClients'])->name('our-clients');
Route::get('/faq', [HomeController::class, 'faq'])->name('faq');
Route::get('/privacy-policy', [HomeController::class, 'privacyPolicy'])->name('privacy-policy');
Route::get('/terms-of-service', [HomeController::class, 'termsOfService'])->name('terms-of-service');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/account', [\App\Http\Controllers\User\AccountController::class, 'index'])->name('account.index');
    Route::put('/account/profile', [\App\Http\Controllers\User\AccountController::class, 'updateProfile'])->name('account.profile.update');
    Route::get('/dashboard', fn() => redirect()->route('account.index'))->name('dashboard');

    // Keep profile destroy for Danger Zone
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Wishlist (Favorites) Toggle
    Route::post('/favorites/toggle', [\App\Http\Controllers\FavoriteController::class, 'toggle'])->name('favorites.toggle');
});

Route::post('/bookings', [BookingController::class, 'store'])->middleware(['auth', 'verified'])->name('bookings.store');
Route::patch('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->middleware(['auth', 'verified'])->name('bookings.cancel');
Route::post('/reviews', [\App\Http\Controllers\ReviewController::class, 'store'])->middleware(['auth', 'verified'])->name('reviews.store');

// Currency Switcher
Route::get('/currency/switch/{code}', function ($code) {
    if (\App\Models\Currency::where('code', $code)->active()->exists()) {
        session(['currency_code' => $code]);
    }
    return back();
})->name('currency.switch');

// SSLCommerz Payment Routes
Route::post('/payment/success', [\App\Http\Controllers\SslCommerzPaymentController::class, 'success'])->name('payment.success');
Route::get('/payment/success/view/{tran_id}', [\App\Http\Controllers\SslCommerzPaymentController::class, 'viewSuccess'])->name('payment.success.view');
Route::post('/payment/fail', [\App\Http\Controllers\SslCommerzPaymentController::class, 'fail'])->name('payment.fail');
Route::post('/payment/cancel', [\App\Http\Controllers\SslCommerzPaymentController::class, 'cancel'])->name('payment.cancel');
Route::post('/payment/ipn', [\App\Http\Controllers\SslCommerzPaymentController::class, 'ipn'])->name('payment.ipn');
