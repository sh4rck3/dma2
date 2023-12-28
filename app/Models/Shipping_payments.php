<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipping_payments extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'xml_file',
        'title',
        'description',
        'original_name',
    ];
}
