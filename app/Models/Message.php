<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'message_id',
        'body',
        'read',
        'media_type',
        'ticket_id',
        'from_me',
        'is_deleted',
        'contact_id'
    ];
}
