<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'subject',
        'message',
        'is_checked',
        'reply_message',
        'replied_at',
        'ip_address'
    ];

    protected $casts = [
        'is_checked' => 'boolean',
        'replied_at' => 'datetime',
    ];
}
