<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filecsv extends Model
{
    use HasFactory;

    protected $fillable = [
        'csv_file',
        'title',
        'description',
        'original_name',
    ];
}
