<?php

namespace App\Services;

use App\Models\Currency;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class CurrencyService
{
    /**
     * Get the current active currency from session or detect via IP.
     */
    public function getCurrentCurrency()
    {
        if (Session::has('currency_code')) {
            $currency = Currency::where('code', Session::get('currency_code'))->active()->first();
            if ($currency) return $currency;
        }

        // Try to detect by IP if not set in session
        $detectedCode = $this->detectCurrencyByIP();
        $currency = Currency::where('code', $detectedCode)->active()->first();
        
        if (!$currency) {
            $currency = Currency::getDefault();
        }

        Session::put('currency_code', $currency->code);
        return $currency;
    }

    /**
     * Convert an amount from base currency (BDT) to target currency.
     */
    public function convert($amount, $currency = null)
    {
        if (!$currency) {
            $currency = $this->getCurrentCurrency();
        }

        // If it's already a Currency object, use it; otherwise find it
        if (!($currency instanceof Currency)) {
            $currency = Currency::where('code', $currency)->first();
        }

        if (!$currency) return $amount;

        return $amount * $currency->exchange_rate;
    }

    /**
     * Format the price based on currency.
     */
    public function format($amount, $currency = null)
    {
        if (!$currency) {
            $currency = $this->getCurrentCurrency();
        }

        $converted = $this->convert($amount, $currency);
        
        // If it's BDT, keep the 'TK' symbol after the number. Otherwise symbol before.
        if ($currency->code === 'BDT') {
            return number_format($converted, 0) . ' ' . $currency->symbol;
        }

        return $currency->symbol . ' ' . number_format($converted, 2);
    }

    /**
     * Update exchange rates from external API.
     */
    public function updateExchangeRates()
    {
        try {
            // Using BDT as base currency since prices are entered in BDT
            $response = Http::get('https://api.exchangerate-api.com/v4/latest/BDT');
            
            if ($response->successful()) {
                $rates = $response->json()['rates'];
                
                $currencies = Currency::all();
                foreach ($currencies as $currency) {
                    if (isset($rates[$currency->code])) {
                        $currency->update(['exchange_rate' => $rates[$currency->code]]);
                    }
                }
                return true;
            }
        } catch (\Exception $e) {
            \Log::error('Currency Update Failed: ' . $e->getMessage());
        }
        return false;
    }

    /**
     * Detect currency code based on user's IP address.
     */
    protected function detectCurrencyByIP()
    {
        return Cache::remember('ip_currency_' . request()->ip(), 86400, function () {
            try {
                // Skip for local IPs
                $ip = request()->ip();
                if ($ip === '127.0.0.1' || $ip === '::1') return 'BDT';

                $response = Http::get("https://ipapi.co/{$ip}/json/");
                if ($response->successful()) {
                    return $response->json()['currency'] ?? 'BDT';
                }
            } catch (\Exception $e) {
                \Log::error('GeoIP Detection Failed: ' . $e->getMessage());
            }
            return 'BDT';
        });
    }
}
