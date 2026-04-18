<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Room::create([
            'name' => 'Super Deluxe',
            'room_type' => 'super-deluxe',
            'description' => 'Perfectly suited for families or groups, our Super Deluxe offers a cozy and comfortable space with a soothing view of natural scenery to enhance your stay. Features automated temperature control and premium linens.',
            'price' => 299.00,
            'old_price' => 350.00,
            'capacity_adults' => 2,
            'capacity_children' => 1,
            'bed_type' => '1 Queen-size',
            'room_size' => 80,
            'view_type' => 'Natural Scenery',
            'image' => 'assets/img/room/room1.jpg',
            'is_360_available' => false,
            'is_featured' => true,
            'badge_text' => 'Limited Time',
            'rating' => 4.8,
            'review_count' => 124,
        ]);

        \App\Models\Room::create([
            'name' => 'Classic Room',
            'room_type' => 'ac-deluxe',
            'description' => 'A timeless classic with modern amenities, perfect for business travelers and couples seeking a refined experience.',
            'price' => 450.00,
            'old_price' => 500.00,
            'capacity_adults' => 2,
            'capacity_children' => 0,
            'bed_type' => '1 Couple',
            'room_size' => 65,
            'view_type' => 'City View',
            'image' => 'https://images.unsplash.com/photo-1493809842364-78817add7ffb?auto=format&fit=crop&w=800&q=80',
            'is_360_available' => true,
            'panorama_url' => 'https://images.unsplash.com/photo-1596522354195-e84ae3c98731?q=80&w=887&auto=format&fit=crop',
            'is_featured' => true,
            'badge_text' => 'Genius Exclusive',
            'rating' => 4.9,
            'review_count' => 86,
        ]);

        \App\Models\Room::create([
            'name' => 'Executive Suite',
            'room_type' => 'exec-suite',
            'description' => 'Experience the pinnacle of luxury in our Executive Suite. Spanning two floors with a private balcony and premium concierge services.',
            'price' => 800.00,
            'old_price' => 950.00,
            'capacity_adults' => 2,
            'capacity_children' => 2,
            'bed_type' => '1 King Size',
            'room_size' => 120,
            'view_type' => 'Panoramic City View',
            'image' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=800&q=80',
            'is_360_available' => true,
            'panorama_url' => 'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?auto=format&fit=crop&w=1920&q=80',
            'is_featured' => true,
            'badge_text' => 'Top Pick',
            'rating' => 5.0,
            'review_count' => 42,
        ]);

        \App\Models\Room::create([
            'name' => 'Business Studio',
            'room_type' => 'business',
            'description' => 'Designed for the modern professional, our Business Studio provides a high-speed workspace and ergonomic furniture.',
            'price' => 220.00,
            'capacity_adults' => 1,
            'capacity_children' => 0,
            'bed_type' => '1 Queen Size',
            'room_size' => 45,
            'view_type' => 'Urban View',
            'image' => 'https://images.unsplash.com/photo-1596394516093-501ba68a0ba6?auto=format&fit=crop&w=800&q=80',
            'is_360_available' => false,
            'is_featured' => false,
            'badge_text' => 'Popular',
            'rating' => 4.5,
            'review_count' => 67,
        ]);

        \App\Models\Room::create([
            'name' => 'Family Deluxe',
            'room_type' => 'family-deluxe',
            'description' => 'Spacious and welcoming, the Family Deluxe is the ideal choice for families looking for shared moments and private corners.',
            'price' => 380.00,
            'old_price' => 420.00,
            'capacity_adults' => 4,
            'capacity_children' => 2,
            'bed_type' => '2 Queen Size',
            'room_size' => 95,
            'view_type' => 'Park View',
            'image' => 'https://images.unsplash.com/photo-1522771739844-6a9f6d5f14af?auto=format&fit=crop&w=800&q=80',
            'is_360_available' => false,
            'is_featured' => false,
            'badge_text' => 'Best Value',
            'rating' => 4.7,
            'review_count' => 93,
        ]);

        \App\Models\Room::create([
            'name' => 'Eco Luxury Cabin',
            'room_type' => 'nonac-luxury',
            'description' => 'Reconnect with nature in our Eco Luxury Cabin. Sustainable materials meet high-end comfort in a tranquil garden setting.',
            'price' => 150.00,
            'capacity_adults' => 2,
            'capacity_children' => 0,
            'bed_type' => '1 Double Bed',
            'room_size' => 40,
            'view_type' => 'Garden View',
            'image' => 'https://images.unsplash.com/photo-1562438668-bcf0ca6578f0?auto=format&fit=crop&w=800&q=80',
            'is_360_available' => false,
            'is_featured' => false,
            'badge_text' => 'New Listing',
            'rating' => 4.6,
            'review_count' => 18,
        ]);
    }
}
