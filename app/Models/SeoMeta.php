<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeoMeta extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_name',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'slug',
        'canonical_url',
        'og_title',
        'og_description',
        'og_image',
        'twitter_title',
        'twitter_image',
        'robots_index',
        'robots_follow'
    ];
}
