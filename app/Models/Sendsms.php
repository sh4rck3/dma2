<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sendsms extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'phone',
        'message',
        'status',
        'created_at',
        'updated_at',
    ];
}
