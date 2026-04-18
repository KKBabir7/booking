<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SslCommerzService
{
    protected $store_id;
    protected $store_password;
    protected $is_sandbox;
    protected $url;

    public function __construct()
    {
        $settings = \App\Models\PaymentSetting::getGrouped('sslcommerz');
        
        $this->store_id = !empty($settings['ssl_store_id']) ? $settings['ssl_store_id'] : env('SSLCZ_STORE_ID', 'testbox');
        $this->store_password = !empty($settings['ssl_store_password']) ? $settings['ssl_store_password'] : env('SSLCZ_STORE_PASSWORD', 'qwerty');
        $this->is_sandbox = (isset($settings['ssl_mode']) && $settings['ssl_mode'] !== '') 
            ? $settings['ssl_mode'] === 'sandbox' 
            : env('SSLCZ_TESTMODE', 'true') === 'true';
        
        $this->url = $this->is_sandbox 
            ? 'https://sandbox.sslcommerz.com/gwprocess/v4/api.php' 
            : 'https://securepay.sslcommerz.com/gwprocess/v4/api.php';
    }

    public function initiatePayment($booking, $payableAmount)
    {
        // If the booking has a specific currency (e.g. USD), we should send the converted amount to SSLCommerz 
        // to match the currency code, otherwise it will charge the BDT value as the target currency value.
        $currency = $booking->currency_code ?? 'BDT';
        $finalAmount = $payableAmount;

        if ($currency !== 'BDT' && $booking->exchange_rate > 0) {
            $finalAmount = round($payableAmount * $booking->exchange_rate, 2);
        }

        $post_data = [
            'store_id' => $this->store_id,
            'store_passwd' => $this->store_password,
            'total_amount' => $finalAmount,
            'currency' => $currency,
            'tran_id' => $booking->transaction_id,
            'success_url' => route('payment.success'),
            'fail_url' => route('payment.fail'),
            'cancel_url' => route('payment.cancel'),
            'ipn_url' => route('payment.ipn'),
            
            // Customer Details
            'cus_name' => $booking->user->name ?? 'Guest User',
            'cus_email' => $booking->user->email ?? 'guest@example.com',
            'cus_add1' => 'Dhaka',
            'cus_city' => 'Dhaka',
            'cus_postcode' => '1000',
            'cus_country' => 'Bangladesh',
            'cus_phone' => $booking->user->phone ?? '01700000000',
            
            // Ship/Product Details
            'shipping_method' => 'NO',
            'product_name' => 'Room Reservation: ' . ($booking->room->name ?? 'Room'),
            'product_category' => 'Hotel Reservation',
            'product_profile' => 'non-physical-goods',
        ];

        Log::info('SSLCommerz Payment Initiation', ['payload' => $post_data]);

        try {
            $response = Http::asForm()->post($this->url, $post_data);
            $result = $response->json();
            
            Log::info('SSLCommerz API Response', ['result' => $result]);

            if ($response->successful()) {
                if (isset($result['status']) && $result['status'] == 'SUCCESS') {
                    return $result['GatewayPageURL'];
                }
                
                return false;
            }
            
            return false;
        } catch (\Exception $e) {
            Log::error('SSLCommerz Service Error: ' . $e->getMessage());
            return false;
        }
    }

    public function validatePayment($request)
    {
        // For Sandbox simple simulation, we check if state is SUCCESS
        // In production, you would call the SSLCommerz validation API
        if ($request->status == 'VALID' || $request->status == 'SUCCESS') {
            return true;
        }
        return false;
    }
}

