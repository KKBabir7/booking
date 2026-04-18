<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    protected $fillable = [
        'slug',
        'name',
        'subject',
        'content',
        'primary_color',
        'site_link',
        'footer_text'
    ];
}
