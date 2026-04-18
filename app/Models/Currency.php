<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $fillable = [
        'code',
        'name',
        'symbol',
        'exchange_rate',
        'is_active',
        'is_default',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public static function getDefault()
    {
        return self::where('is_default', true)->first() ?? self::first();
    }
}
