<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentSetting extends Model
{
    protected $fillable = ['key', 'value', 'group'];

    public static function getGrouped($group)
    {
        return self::where('group', $group)->pluck('value', 'key')->toArray();
    }
}
