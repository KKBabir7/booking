<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'room_id', 'rating', 'comment', 'is_featured',
        'cleanliness_rating', 'communication_rating', 'checkin_rating',
        'accuracy_rating', 'location_rating', 'value_rating',
        'is_fake', 'fake_guest_name', 'fake_guest_email', 'fake_guest_image', 'is_checked'
    ];

    protected static function booted()
    {
        static::saved(function ($review) {
            if ($review->room) {
                $review->room->updateAggregateRatings();
            }
        });

        static::deleted(function ($review) {
            if ($review->room) {
                $review->room->updateAggregateRatings();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
