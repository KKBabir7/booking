<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'title',
        'room_id',
        'hall_id',
        'check_in',
        'check_out',
        'date',
        'time_slot',
        'duration',
        'adults',
        'children',
        'infants',
        'pets',
        'guests',
        'total_price',
        'transaction_id',
        'payment_status',
        'amount_paid',
        'payment_percentage',
        'payment_method',
        'status',
        'is_checked',
        'admin_notes',
        'deposit_amount',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function conferenceHall()
    {
        return $this->belongsTo(ConferenceHall::class, 'hall_id');
    }

    /**
     * Scope a query to only include active bookings.
     * Stale "payment_pending" bookings (older than 1 minute) are excluded.
     */
    public function scopeActive($query)
    {
        return $query->whereNotIn('status', ['cancelled', 'completed'])
            ->where(function ($q) {
                $q->where('status', '!=', 'payment_pending')
                  ->orWhere('created_at', '>=', now()->subMinute());
            });
    }
}
