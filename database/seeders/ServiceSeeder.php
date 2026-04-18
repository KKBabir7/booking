<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'title' => 'Conference Hall Booking',
                'description' => '7+ Multi-floor halls for up to 100 persons with HD AV setup and city...',
                'icon' => 'bi-building',
                'image' => 'assets/img/conference/conf-big.jpg',
                'link' => '/conference'
            ],
            [
                'title' => 'Restaurant & Dining',
                'description' => '3 Multi-cuisine specialized restaurants featuring Thai, Indian, Chinese & Desh...',
                'icon' => 'bi-cup-hot',
                'image' => 'assets/img/restaurant/rest-big.jpg',
                'link' => '/restaurant'
            ],
            [
                'title' => 'Guest House & Rooms',
                'description' => '58 luxury 3-star rooms in the heart of the city with 24/7 security and elite...',
                'icon' => 'bi-door-open',
                'image' => 'assets/img/room/room1.jpg',
                'link' => '/rooms'
            ]
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(['title' => $service['title']], $service);
        }
    }
}
