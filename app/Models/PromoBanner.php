<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoBanner extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'subtitle', 'image', 'link', 'discount_text', 'badge_text', 'is_active'];

    protected static function boot()
    {
        parent::boot();

        static::saved(function () {
            \Illuminate\Support\Facades\Cache::forget('home_promo_banner');
        });

        static::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget('home_promo_banner');
        });
    }
}
