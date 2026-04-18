<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Currency::updateOrCreate(
            ['code' => 'BDT'],
            [
                'name' => 'Bangladeshi Taka',
                'symbol' => 'TK',
                'exchange_rate' => 1.000000,
                'is_active' => true,
                'is_default' => true,
            ]
        );

        \App\Models\Currency::updateOrCreate(
            ['code' => 'USD'],
            [
                'name' => 'US Dollar',
                'symbol' => '$',
                'exchange_rate' => 0.0084, // Approximate, will be updated by API
                'is_active' => true,
                'is_default' => false,
            ]
        );

        \App\Models\Currency::updateOrCreate(
            ['code' => 'EUR'],
            [
                'name' => 'Euro',
                'symbol' => '€',
                'exchange_rate' => 0.0078, // Approximate, will be updated by API
                'is_active' => true,
                'is_default' => false,
            ]
        );
    }
}
