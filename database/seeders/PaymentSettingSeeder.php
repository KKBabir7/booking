<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentSetting;

class PaymentSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'ssl_store_id', 'value' => 'testbox', 'group' => 'sslcommerz'],
            ['key' => 'ssl_store_password', 'value' => 'qwerty', 'group' => 'sslcommerz'],
            ['key' => 'ssl_mode', 'value' => 'sandbox', 'group' => 'sslcommerz'], // sandbox or live
        ];

        foreach ($settings as $setting) {
            PaymentSetting::updateOrCreate(
                ['key' => $setting['key']],
                ['value' => $setting['value'], 'group' => $setting['group']]
            );
        }
    }
}
