<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Financial extends Model
{
    use HasFactory;

    Protected $fillable = [
        'csv_file',
        'title',
        'description',
        'original_filename',
    ];
}
