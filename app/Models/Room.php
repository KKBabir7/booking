<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'room_type',
        'description',
        'price',
        'old_price',
        'capacity_adults',
        'capacity_children',
        'capacity_infants',
        'capacity_pets',
        'bed_type',
        'room_size',
        'view_type',
        'image',
        'is_360_available',
        'panorama_url',
        'is_featured',
        'badge_text',
        'rating',
        'review_count',
        'amenities',
        'rules',
        'faqs',
        'gallery_images',
        'attributes',
        'partial_payments',
        'service_charge',
        'tax',
    ];

    protected $casts = [
        'amenities' => 'array',
        'rules' => 'array',
        'faqs' => 'array',
        'gallery_images' => 'array',
        'attributes' => 'array',
        'partial_payments' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($room) {
            if (empty($room->slug)) {
                $room->slug = \Illuminate\Support\Str::slug($room->name);

                // Ensure slug uniqueness
                $originalSlug = $room->slug;
                $count = 1;
                while (static::where('slug', $room->slug)->exists()) {
                    $room->slug = "{$originalSlug}-{$count}";
                    $count++;
                }
            }
        });

        static::updating(function ($room) {
            if (empty($room->slug)) {
                $room->slug = \Illuminate\Support\Str::slug($room->name);

                // Ensure slug uniqueness (excluding current room)
                $originalSlug = $room->slug;
                $count = 1;
                while (static::where('slug', $room->slug)->where('id', '!=', $room->id)->exists()) {
                    $room->slug = "{$originalSlug}-{$count}";
                    $count++;
                }
            }
        });
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites', 'room_id', 'user_id')->withTimestamps();
    }

    /**
     * Automatically update the room's total rating based on all its reviews.
     */
    public function updateAggregateRatings()
    {
        $reviews = $this->reviews()->get();
        if ($reviews->count() > 0) {
            $this->rating = round($reviews->avg('rating'), 2);
            $this->review_count = $reviews->count();
            $this->saveQuietly();
        } else {
            $this->rating = 0;
            $this->review_count = 0;
            $this->saveQuietly();
        }
    }
}
