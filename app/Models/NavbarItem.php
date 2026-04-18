<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NavbarItem extends Model
{
    use HasFactory;

    protected $fillable = ['label', 'url', 'icon', 'position', 'order_column', 'is_active'];

    protected static function boot()
    {
        parent::boot();

        static::saved(function () {
            \Illuminate\Support\Facades\Cache::forget('navbar_items');
        });

        static::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget('navbar_items');
        });
    }
}
