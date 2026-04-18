<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    protected $fillable = ['name', 'advance_amount', 'image', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
        'advance_amount' => 'decimal:2'
    ];
}
