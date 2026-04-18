<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageSetting extends Model
{
    protected $fillable = ['page', 'key', 'value'];

    /**
     * Get all settings for a given page as a key => value array.
     */
    public static function getPage(string $page): array
    {
        return \Illuminate\Support\Facades\Cache::rememberForever("page_settings_{$page}", function () use ($page) {
            return static::where('page', $page)->pluck('value', 'key')->toArray();
        });
    }

    /**
     * Set (upsert) a value for a given page + key.
     */
    public static function set(string $page, string $key, mixed $value): void
    {
        static::updateOrCreate(
            ['page' => $page, 'key' => $key],
            ['value' => $value]
        );
        \Illuminate\Support\Facades\Cache::forget("page_settings_{$page}");
    }
}
