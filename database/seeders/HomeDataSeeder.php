<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HomeDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Services
        \App\Models\Service::create([
            'title' => 'Conference Hall',
            'description' => '7+ Multi-floor halls for up to 100 persons with HD AV setup.',
            'icon' => 'bi-building',
            'image' => 'assets/img/cover/conference.jpeg'
        ]);
        \App\Models\Service::create([
            'title' => 'Fine Dining',
            'description' => 'Experience gourmet cuisine at our multi-cuisine restaurant.',
            'icon' => 'bi-egg-fried',
            'image' => 'assets/img/cover/restaurant.jpeg'
        ]);

        // Clients
        \App\Models\Client::create(['name' => 'ActionAid', 'logo' => 'assets/img/client/actionaid-logo.png']);
        \App\Models\Client::create(['name' => 'Robi', 'logo' => 'assets/img/client/robi-logo.jpg.jpeg']);
        \App\Models\Client::create(['name' => 'Grameenphone', 'logo' => 'assets/img/client/gp-logo.png']);

        // Gallery
        \App\Models\Gallery::create(['title' => 'Lobby', 'image' => 'assets/img/gallery/gallery-1.png', 'category' => 'Interior']);
        \App\Models\Gallery::create(['title' => 'Suite View', 'image' => 'assets/img/gallery/gallery-2.png', 'category' => 'Rooms']);

        // Hero Banners
        \App\Models\Banner::create([
            'title' => 'First Time Booking Offer',
            'subtitle' => 'Experience ultimate relaxation at NGH. A special welcome gift for our first-time guests.',
            'image' => 'assets/img/offer/first.png',
            'tag_label' => 'WELCOME',
            'tag_value' => '35%',
            'tag_off' => 'OFF',
            'button_text' => 'Get This Offer',
            'button_link' => '#offers',
            'style_class' => ''
        ]);
        \App\Models\Banner::create([
            'title' => 'Free Breakfast Inclusion',
            'subtitle' => 'Book your stay today and wake up to a complimentary world-class breakfast every morning.',
            'image' => 'assets/img/offer/eat.png',
            'tag_label' => 'DINING',
            'tag_value' => 'FREE',
            'tag_off' => 'BFAST',
            'button_text' => 'Get This Offer',
            'button_link' => '#offers',
            'style_class' => 'style-2'
        ]);

        // Navbar Items
        \App\Models\NavbarItem::create(['label' => 'Home', 'url' => '/', 'order_column' => 1]);
        \App\Models\NavbarItem::create(['label' => 'Rooms', 'url' => '/rooms', 'order_column' => 2]);
        \App\Models\NavbarItem::create(['label' => 'Gallery', 'url' => '/gallery', 'order_column' => 3]);
        \App\Models\NavbarItem::create(['label' => 'Contact', 'url' => '/contact', 'order_column' => 4]);

        // Promo Banners (Middle section)
        \App\Models\PromoBanner::create([
            'title' => 'LUXURY ROOM DEAL',
            'subtitle' => 'Book your luxury getaway now and save big with our exclusive room deals.',
            'image' => 'assets/img/offer/promo-1.png',
            'discount_text' => '35% OFF',
            'badge_text' => 'LIMITED OFFER',
            'link' => '/rooms'
        ]);
    }
}
