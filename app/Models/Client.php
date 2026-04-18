<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'logo', 'link'];

    protected static function boot()
    {
        parent::boot();

        static::saved(function () {
            \Illuminate\Support\Facades\Cache::forget('home_clients');
        });

        static::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget('home_clients');
        });
    }
}
