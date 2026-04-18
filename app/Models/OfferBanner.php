<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfferBanner extends Model
{
    protected $fillable = [
        'image',
        'link',
        'is_active',
        'order_column',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saved(function () {
            \Illuminate\Support\Facades\Cache::forget('home_offer_banners');
        });

        static::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget('home_offer_banners');
        });
    }
}
