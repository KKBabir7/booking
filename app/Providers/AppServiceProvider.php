<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind('path.public', function() {
            return base_path();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        view()->composer(['partials.header', 'partials.mobile-menu'], function ($view) {
            $navbarItems = \Illuminate\Support\Facades\Cache::rememberForever('navbar_items', function () {
                return \App\Models\NavbarItem::where('is_active', true)
                    ->orderBy('order_column')
                    ->get();
            });

            $view->with('navbarItems', $navbarItems);
        });

        // Admin Notification Counts
        view()->composer('layouts.admin', function ($view) {
            $view->with([
                'unreadBookingsCount' => \App\Models\Booking::where('is_checked', false)
                                        ->where('status', '!=', 'payment_pending')
                                        ->count(),
                'unreadReviewsCount'  => \App\Models\Review::where('is_checked', false)->count(),
                'unreadUsersCount'    => \App\Models\User::where('role', \App\Models\User::class::ROLE_USER)
                                        ->where('is_checked', false)
                                        ->count(),
                'unreadContactsCount' => \App\Models\ContactMessage::where('is_checked', false)->count(),
            ]);
        });

        // Currency Data for Frontend
        view()->composer('*', function ($view) {
            if (!app()->runningInConsole()) {
                $currencyService = app(\App\Services\CurrencyService::class);
                $view->with([
                    'activeCurrency' => $currencyService->getCurrentCurrency(),
                    'allCurrencies' => \App\Models\Currency::active()->get(),
                    'currencyService' => $currencyService
                ]);
            }
        });

        // Runtime Email Configuration Override
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('email_settings')) {
                $smtpSettings = \App\Models\EmailSetting::where('group', 'smtp')->pluck('value', 'key');
                
                if ($smtpSettings->isNotEmpty()) {
                    config([
                        'mail.mailers.smtp.host' => $smtpSettings->get('mail_host'),
                        'mail.mailers.smtp.port' => $smtpSettings->get('mail_port'),
                        'mail.mailers.smtp.username' => $smtpSettings->get('mail_username'),
                        'mail.mailers.smtp.password' => $smtpSettings->get('mail_password'),
                        'mail.mailers.smtp.encryption' => $smtpSettings->get('mail_encryption'),
                        'mail.from.address' => $smtpSettings->get('mail_from_address'),
                        'mail.from.name' => $smtpSettings->get('mail_from_name'),
                    ]);
                }
            }
        } catch (\Exception $e) {
            // Silently fail if DB is not ready
        }
    }
}
