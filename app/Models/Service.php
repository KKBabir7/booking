<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'icon', 'image', 'link'];

    protected static function boot()
    {
        parent::boot();

        static::saved(function () {
            \Illuminate\Support\Facades\Cache::forget('home_services');
        });

        static::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget('home_services');
        });
    }
}
