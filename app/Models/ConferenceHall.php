<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConferenceHall extends Model
{
    protected $fillable = [
        'name',
        'capacity',
        'price',
        'badge_text',
        'description',
        'image',
        'panorama_url',
        'status',
        'partial_payments',
        'service_charge',
        'tax',
    ];

    protected $casts = [
        'partial_payments' => 'array',
    ];

    /**
     * Get the bookings relating to this hall.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'hall_id');
    }
}
