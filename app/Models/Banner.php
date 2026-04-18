<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 
        'subtitle', 
        'image', 
        'tag_label', 
        'tag_value', 
        'tag_off', 
        'button_text', 
        'button_link', 
        'style_class', 
        'order_column', 
        'is_active'
    ];

    protected static function boot()
    {
        parent::boot();

        static::saved(function () {
            \Illuminate\Support\Facades\Cache::forget('home_banners');
        });

        static::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget('home_banners');
        });
    }
}
